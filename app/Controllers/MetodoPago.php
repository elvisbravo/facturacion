<?php

namespace App\Controllers;

use App\Models\MetodosPagoModel;

class MetodoPago extends BaseController
{
    public function listar()
    {
        try {
            $metodoPago = new MetodosPagoModel();

            $datos = $metodoPago->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Métodos de pago listados correctamente',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar métodos de pago',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
