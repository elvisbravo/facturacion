<?php

namespace App\Controllers;

use App\Models\AlmacenModel;
use App\Models\SucursalesModel;

class Almacen extends BaseController
{
    public function index()
    {
        $sucursalModel = new SucursalesModel();
        $data = [
            'sucursales' => $sucursalModel->where('estado', 1)->findAll()
        ];
        return view('almacen/index', $data);
    }

    public function listar()
    {
        try {
            $almacenModel = new AlmacenModel();

            // Join con sucursales para mostrar el nombre de la sede
            $datos = $almacenModel->select('almacenes.*, sucursales.nombre as nombre_sucursal')
                ->join('sucursales', 'sucursales.id = almacenes.sucursal_id')
                ->where('almacenes.estado', 1)
                ->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Almacenes listados correctamente',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar almacenes: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardar()
    {
        try {
            $almacenModel = new AlmacenModel();
            $id = $this->request->getPost('id');

            $data = [
                'nombre'      => $this->request->getPost('nombre'),
                'sucursal_id' => $this->request->getPost('sucursal_id'),
                'estado'      => 1
            ];

            if (empty($id)) {
                $almacenModel->insert($data);
                $message = 'Almacén creado correctamente';
            } else {
                $almacenModel->update($id, $data);
                $message = 'Almacén actualizado correctamente';
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al guardar almacén: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getAlmacen($id)
    {
        try {
            $almacenModel = new AlmacenModel();
            $almacen = $almacenModel->find($id);

            if ($almacen) {
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $almacen
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Almacén no encontrado'
                ], 404);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al obtener almacén: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminar($id)
    {
        try {
            $almacenModel = new AlmacenModel();
            // Don't allow deleting the main warehouse (id 1) easily if needed
            if ($id == 1) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'No se puede eliminar el almacén principal'
                ], 400);
            }

            $almacenModel->update($id, ['estado' => 0]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Almacén eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al eliminar almacén: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getPorSucursal($sucursal_id)
    {
        try {
            $almacenModel = new AlmacenModel();
            $almacenes = $almacenModel->where('sucursal_id', $sucursal_id)
                ->where('estado', 1)
                ->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $almacenes
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al obtener almacenes: ' . $e->getMessage()
            ], 500);
        }
    }
}
