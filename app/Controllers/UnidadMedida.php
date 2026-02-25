<?php

namespace App\Controllers;

use App\Models\UnidadMedidaModel;

class UnidadMedida extends BaseController
{
    public function listar()
    {
        try {
            $unidad = new UnidadMedidaModel();

            $datos = $unidad->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Unidades listadas correctamente',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar unidades',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
