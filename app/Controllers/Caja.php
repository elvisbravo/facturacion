<?php

namespace App\Controllers;

use App\Models\AperturaCajaModel;
use App\Models\CajaModel;

class Caja extends BaseController
{
    public function aperturar()
    {
        $session = session();
        $sucursal_id = $session->get('sucursal_id');
        $cajaAbierta = getCajaAbierta();

        $resumen = [];
        $totales = [
            'ingresos' => 0,
            'egresos' => 0,
            'neto' => 0
        ];

        if ($cajaAbierta) {
            $metodosMod = new \App\Models\MetodosPagoModel();
            $movMod = new \App\Models\MovimientoCajaModel();

            $metodos = $metodosMod->where('estado', 1)->findAll();

            foreach ($metodos as $m) {
                $metodo_id = $m['id'];

                // Sumar Ingresos
                $ingresos = $movMod->selectSum('monto')
                    ->where('apertura_caja_id', $cajaAbierta['id'])
                    ->where('metodo_pago_id', $metodo_id)
                    ->where('tipo_movimiento', 'INGRESO')
                    ->where('estado', 1)
                    ->first();

                // Sumar Egresos
                $egresos = $movMod->selectSum('monto')
                    ->where('apertura_caja_id', $cajaAbierta['id'])
                    ->where('metodo_pago_id', $metodo_id)
                    ->where('tipo_movimiento', 'EGRESO')
                    ->where('estado', 1)
                    ->first();

                $valIngresos = $ingresos['monto'] ?? 0;
                $valEgresos = $egresos['monto'] ?? 0;

                // Monto Inicial (Solo para efectivo, asumimos que es el que tiene ID 1 o nombre searchable)
                $montoInicial = 0;
                if (strpos(strtoupper($m['nombre']), 'EFECTIVO') !== false) {
                    $montoInicial = $cajaAbierta['monto_inicial'];
                }

                $parcial = $montoInicial + $valIngresos - $valEgresos;

                $resumen[] = [
                    'nombre' => $m['nombre'],
                    'monto_inicial' => $montoInicial,
                    'ingresos' => $valIngresos,
                    'egresos' => $valEgresos,
                    'parcial' => $parcial
                ];

                $totales['ingresos'] += $valIngresos;
                $totales['egresos'] += $valEgresos;
                $totales['neto'] += $parcial;
            }

            // Resumen de Caja (Detalle de Ingresos y Egresos AGRUPADO)
            $db = \Config\Database::connect();

            // 1. Obtener IDs de ventas únicas procesadas en esta apertura
            $ventaIdsData = $movMod->select('referencia_mov_id')
                ->where('apertura_caja_id', $cajaAbierta['id'])
                ->where('referencia_tipo_mov', 'VENTA')
                ->groupBy('referencia_mov_id')
                ->findAll();

            $ids = array_column($ventaIdsData, 'referencia_mov_id');

            $data['detalles_ingresos'] = [];
            if (!empty($ids)) {
                $data['detalles_ingresos'] = $db->table('detalle_venta')
                    ->select('SUM(cantidad) as cantidad, descripcion as producto, precio, SUM(importe) as importe')
                    ->whereIn('venta_id', $ids)
                    ->groupBy('descripcion, precio')
                    ->get()->getResultArray();
            }

            // 2. Obtener otros movimientos (Egresos/Manuales) agrupados por concepto
            $data['otros_movimientos'] = $movMod->select('SUM(monto) as monto, concepto_id, tipo_movimiento')
                ->where('apertura_caja_id', $cajaAbierta['id'])
                ->where('referencia_tipo_mov !=', 'VENTA')
                ->groupBy('concepto_id, tipo_movimiento')
                ->findAll();

            $conceptosMod = new \App\Models\ConceptosModel();
            foreach ($data['otros_movimientos'] as &$mov) {
                $conc = $conceptosMod->find($mov['concepto_id']);
                $mov['producto'] = strtoupper((string)($conc['nombre_concepto'] ?? 'OTROS MOVIMIENTOS'));
                $mov['cantidad'] = 1;
                $mov['precio'] = $mov['monto'];
                $mov['importe'] = $mov['monto'];
            }
        }

        $data['cajaAbierta'] = $cajaAbierta;
        $data['resumen'] = $resumen;
        $data['totales'] = $totales;

        $data['cajaVencida'] = false;
        if ($cajaAbierta && !empty($cajaAbierta['hora_cierre'])) {
            $openingTime = strtotime($cajaAbierta['fecha_apertura']);
            $targetClosingTime = strtotime(date('Y-m-d', $openingTime) . ' ' . $cajaAbierta['hora_cierre']);
            if ($targetClosingTime <= $openingTime) {
                $targetClosingTime = strtotime('+1 day', $targetClosingTime);
            }
            if (time() > $targetClosingTime) {
                $data['cajaVencida'] = true;
            }
        }

        return view('caja/aperturar', $data);
    }

    public function abrir()
    {
        $session = session();
        $usuario_id = $session->get('id');
        $sucursal_id = $session->get('sucursal_id');
        $monto_inicial = $this->request->getPost('monto_inicial');

        // Buscar una caja disponible para la sucursal
        $cajaModel = new CajaModel();
        $caja = $cajaModel->where('sucursal_id', $sucursal_id)->where('estado', 1)->first();

        if (!$caja) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No hay una caja configurada para esta sucursal.'
            ]);
        }

        $aperturaCajaModel = new AperturaCajaModel();

        // Verificar si ya tiene una caja abierta
        $abierta = $aperturaCajaModel->where('usuario_id', $usuario_id)
            ->where('estado', 1)
            ->first();

        if ($abierta) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Ya tienes una caja abierta.'
            ]);
        }

        $data = [
            'caja_id' => $caja['id'],
            'usuario_id' => $usuario_id,
            'fecha_apertura' => date('Y-m-d H:i:s'),
            'monto_inicial' => $monto_inicial,
            'estado' => 1
        ];

        if ($aperturaCajaModel->insert($data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Caja abierta correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al abrir la caja.'
            ]);
        }
    }

    public function cerrar()
    {
        $session = session();
        $usuario_id = $session->get('id');
        $monto_cierre = $this->request->getPost('monto_cierre') ?? 0;

        $aperturaCajaModel = new AperturaCajaModel();
        $abierta = $aperturaCajaModel->where('usuario_id', $usuario_id)
            ->where('estado', 1)
            ->first();

        if (!$abierta) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'No tienes ninguna caja abierta.'
            ]);
        }

        $data = [
            'fecha_cierre' => date('Y-m-d H:i:s'),
            'monto_cierre' => $monto_cierre,
            'estado' => 0
        ];

        if ($aperturaCajaModel->update($abierta['id'], $data)) {
            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Caja cerrada correctamente.'
            ]);
        } else {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al cerrar la caja.'
            ]);
        }
    }
}
