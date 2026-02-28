<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function admin()
    {
        if (session()->get('rol_id') != 1) {
            return redirect()->to('ventas');
        }

        $request = $this->request->getPost();
        if (empty($request)) {
            $request = $this->request->getGet();
        }

        $fechaInicio = $request['fecha_inicio'] ?? date('Y-m-01');
        $fechaFin    = $request['fecha_fin'] ?? date('Y-m-d');
        $sucursal_id = $request['sucursal_id'] ?? '';
        $almacen_id  = $request['almacen_id'] ?? '';

        $db = \Config\Database::connect();

        // Función base para aplicar filtros
        $applyFilters = function ($builder, $tableName) use ($fechaInicio, $fechaFin, $sucursal_id, $almacen_id) {
            // Asegurar que usamos el nombre de la tabla correcto para los campos comunes
            $builder->where("DATE(ventas.fecha_venta) >=", $fechaInicio)
                ->where("DATE(ventas.fecha_venta) <=", $fechaFin);

            // Si la tabla base no es 'ventas', nos aseguramos de tener el join con ventas para los filtros
            if ($tableName !== 'ventas') {
                // El join ya está en la consulta principal del controlador para topProducts y paymentBreakdown
            }

            if (!empty($sucursal_id)) {
                $builder->where('ventas.sucursal_id', $sucursal_id);
            }

            if (!empty($almacen_id)) {
                // Como ventas no tiene almacen_id, filtramos a través de movimiento_inventario
                $builder->join('movimiento_inventario', 'movimiento_inventario.referencia_id = ventas.id AND movimiento_inventario.referencia_tipo = "VENTA"', 'inner')
                    ->where('movimiento_inventario.almacen_id', $almacen_id);
            }
            return $builder;
        };

        // 1. Contadores (Base: ventas)
        $boletasQuery = $db->table('ventas');
        $applyFilters($boletasQuery, 'ventas');
        $boletas = $boletasQuery->where('tipo_comprobante_id', '03')->countAllResults();

        $facturasQuery = $db->table('ventas');
        $applyFilters($facturasQuery, 'ventas');
        $facturas = $facturasQuery->where('tipo_comprobante_id', '01')->countAllResults();

        $notasVentaQuery = $db->table('ventas');
        $applyFilters($notasVentaQuery, 'ventas');
        $notasVenta = $notasVentaQuery->where('tipo_comprobante_id', '77')->countAllResults();

        $totalNetoQuery = $db->table('ventas');
        $applyFilters($totalNetoQuery, 'ventas');
        $totalNeto = $totalNetoQuery->selectSum('total')->get()->getRowArray()['total'] ?? 0;

        // 2. Top Products (Base: detalle_venta)
        $topProductsQuery = $db->table('detalle_venta')
            ->join('ventas', 'ventas.id = detalle_venta.venta_id');
        $applyFilters($topProductsQuery, 'detalle_venta');
        $topProducts = $topProductsQuery->select('detalle_venta.descripcion, SUM(detalle_venta.cantidad) as total_qty')
            ->groupBy('detalle_venta.descripcion')
            ->orderBy('total_qty', 'DESC')
            ->limit(6)
            ->get()->getResultArray();

        // 3. Payment Methods (Base: pagos_venta)
        $paymentQuery = $db->table('pagos_venta')
            ->join('ventas', 'ventas.id = pagos_venta.venta_id')
            ->join('metodos_pago', 'metodos_pago.id = pagos_venta.metodo_pago_id');
        $applyFilters($paymentQuery, 'pagos_venta');
        $paymentBreakdown = $paymentQuery->select('metodos_pago.nombre, SUM(pagos_venta.monto) as total_monto')
            ->groupBy('metodos_pago.nombre')
            ->get()->getResultArray();

        // Data for selectors
        $sucursalesModel = new \App\Models\SucursalesModel();

        $data = [
            'boletas'    => $boletas,
            'facturas'   => $facturas,
            'notasVenta' => $notasVenta,
            'totalNeto'  => floatval($totalNeto),
            'topProducts' => $topProducts,
            'paymentBreakdown' => $paymentBreakdown,
            'sucursales' => $sucursalesModel->where('estado', 1)->findAll(),
            'filtros'    => [
                'fecha_inicio' => $fechaInicio,
                'fecha_fin'    => $fechaFin,
                'sucursal_id'  => $sucursal_id,
                'almacen_id'   => $almacen_id
            ]
        ];

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'status' => 'success',
                'data' => $data
            ]);
        }

        return view('dashboard/admin', $data);
    }
}
