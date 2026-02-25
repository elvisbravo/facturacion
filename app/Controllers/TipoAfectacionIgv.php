<?php

namespace App\Controllers;

use App\Models\TipoAfectacionIgvModel;

class TipoAfectacionIgv extends BaseController
{
    public function listar()
    {
        try {
            $tipoAfectacionIgv = new TipoAfectacionIgvModel();

            $datos = $tipoAfectacionIgv->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Tipo de afectación IGV listados correctamente',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar tipo de afectación IGV',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
