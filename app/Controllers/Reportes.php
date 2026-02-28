<?php

namespace App\Controllers;

use App\Models\VentasModel;
use App\Models\SucursalesModel;
use App\Models\ComprobanteModel;

class Reportes extends BaseController
{
    public function ventas()
    {
        $sucursalModel = new SucursalesModel();
        $comprobanteModel = new ComprobanteModel();

        $data = [
            'sucursales' => $sucursalModel->where('estado', 1)->findAll(),
            'comprobantes' => $comprobanteModel->findAll()
        ];

        return view('reportes/ventas', $data);
    }

    public function buscarVentas()
    {
        $ventasModel = new VentasModel();

        $desde = $this->request->getPost('desde');
        $hasta = $this->request->getPost('hasta');
        $sucursal_id = $this->request->getPost('sucursal_id');
        $comprobante_id = $this->request->getPost('comprobante_id');
        $tipo_envio = session()->get('tipo_envio_sunat') ?? 'prueba';

        $builder = $ventasModel->select('ventas.*, sunat_tipodocelectronico.descripcion as tipo_doc')
            ->join('sunat_tipodocelectronico', 'sunat_tipodocelectronico.id_tipodoc_electronico = ventas.tipo_comprobante_id', 'left');

        $builder->where('ventas.tipo_envio_sunat', $tipo_envio);

        if (!empty($desde)) {
            $builder->where('DATE(ventas.fecha_venta) >=', $desde);
        }
        if (!empty($hasta)) {
            $builder->where('DATE(ventas.fecha_venta) <=', $hasta);
        }
        if (!empty($sucursal_id)) {
            $builder->where('ventas.sucursal_id', $sucursal_id);
        }
        if (!empty($comprobante_id)) {
            $builder->where('ventas.tipo_comprobante_id', $comprobante_id);
        }

        $ventas = $builder->orderBy('ventas.id', 'DESC')->findAll();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $ventas
        ]);
    }

    public function exportarVentas()
    {
        $ventasModel = new VentasModel();

        $desde = $this->request->getGet('desde');
        $hasta = $this->request->getGet('hasta');
        $sucursal_id = $this->request->getGet('sucursal_id');
        $comprobante_id = $this->request->getGet('comprobante_id');
        $tipo_envio = session()->get('tipo_envio_sunat') ?? 'prueba';

        $builder = $ventasModel->select('ventas.*, sunat_tipodocelectronico.descripcion as tipo_doc')
            ->join('sunat_tipodocelectronico', 'sunat_tipodocelectronico.id_tipodoc_electronico = ventas.tipo_comprobante_id', 'left');

        $builder->where('ventas.tipo_envio_sunat', $tipo_envio);

        if (!empty($desde)) {
            $builder->where('DATE(ventas.fecha_venta) >=', $desde);
        }
        if (!empty($hasta)) {
            $builder->where('DATE(ventas.fecha_venta) <=', $hasta);
        }
        if (!empty($sucursal_id)) {
            $builder->where('ventas.sucursal_id', $sucursal_id);
        }
        if (!empty($comprobante_id)) {
            $builder->where('ventas.tipo_comprobante_id', $comprobante_id);
        }

        $ventas = $builder->orderBy('ventas.id', 'DESC')->findAll();

        $filename = "Reporte_Ventas_" . date('Ymd_His') . ".csv";

        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename=' . $filename);

        $output = fopen('php://output', 'w');
        // UTF-8 BOM
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Header
        fputcsv($output, ['#', 'Fecha de Emisión', 'Tipo Comprobante', 'Serie', 'Número', 'Total']);

        $i = 1;
        foreach ($ventas as $v) {
            fputcsv($output, [
                $i++,
                $v['fecha_venta'],
                $v['tipo_doc'],
                $v['serie_comprobante'],
                str_pad($v['numero_comprobante'], 8, '0', STR_PAD_LEFT),
                number_format($v['total'], 2)
            ]);
        }

        fclose($output);
        exit;
    }
}
