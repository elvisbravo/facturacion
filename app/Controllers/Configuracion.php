<?php

namespace App\Controllers;

use App\Models\CajaModel;
use App\Models\ConfiguracionComprobantesModel;
use App\Models\ComprobanteModel;
use App\Models\SucursalesModel;

class Configuracion extends BaseController
{
    public function index()
    {
        $cajaModel = new CajaModel();
        $comprobanteConfigModel = new ConfiguracionComprobantesModel();
        $comprobanteModel = new ComprobanteModel();
        $sucursalModel = new SucursalesModel();

        $sucursal_id = session()->get('sucursal_id');

        $data = [
            'cajas' => $cajaModel->select('caja.*, sucursales.nombre as nombre_sucursal')
                ->join('sucursales', 'sucursales.id = caja.sucursal_id')
                ->where('caja.estado', 1)
                ->findAll(),
            'config_comprobantes' => $comprobanteConfigModel
                ->select('configuracion_comprobantes.*, sunat_tipodocelectronico.descripcion, sucursales.nombre as nombre_sucursal')
                ->join('sunat_tipodocelectronico', 'sunat_tipodocelectronico.id_tipodoc_electronico = configuracion_comprobantes.comprobante_id')
                ->join('sucursales', 'sucursales.id = configuracion_comprobantes.sucursal_id')
                ->findAll(),
            'tipos_comprobante' => $comprobanteModel->findAll(),
            'sucursales' => $sucursalModel->where('estado', 1)->findAll()
        ];

        return view('configuracion/index', $data);
    }

    public function guardarCaja()
    {
        try {
            $cajaModel = new CajaModel();
            $id = $this->request->getPost('id');
            $data = [
                'hora_cierre' => $this->request->getPost('hora_cierre')
            ];

            $cajaModel->update($id, $data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Configuración de caja actualizada'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardarComprobante()
    {
        try {
            $model = new ConfiguracionComprobantesModel();
            $id = $this->request->getPost('id');

            $data = [
                'sucursal_id'      => $this->request->getPost('sucursal_id'),
                'comprobante_id'    => $this->request->getPost('comprobante_id'),
                'serie'             => strtoupper($this->request->getPost('serie')),
                'numero'            => $this->request->getPost('numero'),
                'tipo_envio_sunat' => $this->request->getPost('tipo_envio_sunat'),
                'estado'            => 1
            ];

            if (empty($id)) {
                $model->insert($data);
                $message = 'Configuración de comprobante agregada';
            } else {
                $model->update($id, $data);
                $message = 'Configuración de comprobante actualizada';
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminarComprobante($id)
    {
        try {
            $model = new ConfiguracionComprobantesModel();
            $model->delete($id);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Configuración eliminada'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
    public function guardarSucursal()
    {
        try {
            $model = new SucursalesModel();
            $id = $this->request->getPost('id');
            $data = [
                'tipo_envio_sunat' => $this->request->getPost('tipo_envio_sunat')
            ];

            $model->update($id, $data);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Configuración de sucursal actualizada'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }
}
