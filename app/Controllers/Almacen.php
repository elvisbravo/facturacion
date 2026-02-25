<?php

namespace App\Controllers;

use App\Models\AlmacenModel;

class Almacen extends BaseController
{
    public function listar()
    {
        try {
            $almacen = new AlmacenModel();

            $datos = $almacen->where('estado', 1)->where('sucursal_id', session()->get('sucursal_id'))->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Almacenes listados correctamente',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar almacenes',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
