<?php

namespace App\Controllers;

use App\Models\ClientesModel;

class Clientes extends BaseController
{
    public function listar()
    {
        try {
            $clientes = new ClientesModel();

            $datos = $clientes->where('estado', 1)->orderBy('nombres', 'ASC')->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Clientes listados correctamente',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar clientes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function buscar()
    {
        try {
            $clientes = new ClientesModel();
            $datos = $clientes->select('clientes.*, sunat_tipodocidentidad.nombre as tipo_doc_nombre')
                ->join('sunat_tipodocidentidad', 'sunat_tipodocidentidad.id_tipodocidentidad = clientes.id_tipo_documento')
                ->where('clientes.estado', 1)
                ->groupStart()
                ->like('clientes.nombres', $this->request->getPost('nombres'))
                ->orLike('clientes.numero_documento', $this->request->getPost('nombres'))
                ->groupEnd()
                ->orderBy('clientes.nombres', 'ASC')
                ->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Clientes listados correctamente',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar clientes',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function guardar()
    {
        try {
            $clientes = new ClientesModel();
            $id = $this->request->getPost('id');

            $data = [
                'numero_documento'  => $this->request->getPost('numero_documento'),
                'nombres'           => $this->request->getPost('nombres'),
                'id_tipo_documento' => $this->request->getPost('id_tipo_documento'),
                'correo'           => $this->request->getPost('correo'),
                'telefono'         => $this->request->getPost('telefono'),
                'direccion'        => $this->request->getPost('direccion'),
                'estado'           => 1
            ];

            if ($id == 0 || empty($id)) {
                $clientId = $clientes->insert($data);
                $message = 'Cliente registrado correctamente';
            } else {
                $clientes->update($id, $data);
                $clientId = $id;
                $message = 'Cliente actualizado correctamente';
            }

            $tipoDoc = new \App\Models\TipoIdentidadModel();
            $tipoDocData = $tipoDoc->find($data['id_tipo_documento']);

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => $message,
                'data'    => [
                    'id' => $clientId,
                    'numero_documento' => $data['numero_documento'],
                    'nombres' => $data['nombres'],
                    'id_tipo_documento' => $data['id_tipo_documento'],
                    'tipo_doc_nombre' => $tipoDocData['nombre'] ?? 'DNI'
                ]
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Error al guardar el cliente: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getTiposDocumento()
    {
        try {
            $model = new \App\Models\TipoIdentidadModel();
            $datos = $model->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar tipos de documento'
            ], 500);
        }
    }
}
