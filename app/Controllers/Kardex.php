<?php

namespace App\Controllers;

use App\Models\MovimientoInventarioModel;
use App\Models\ProductoModel;
use App\Models\SucursalesModel;
use App\Models\AlmacenModel;

class Kardex extends BaseController
{
    public function index()
    {
        $productoModel = new ProductoModel();
        $sucursalModel = new SucursalesModel();

        $data = [
            'productos' => $productoModel->where('estado', 1)->findAll(),
            'sucursales' => $sucursalModel->where('estado', 1)->findAll()
        ];

        return view('inventario/kardex', $data);
    }

    public function buscar()
    {
        $producto_id = $this->request->getPost('producto_id');
        $sucursal_id = $this->request->getPost('sucursal_id');
        $almacen_id  = $this->request->getPost('almacen_id');
        $fecha_inicio = $this->request->getPost('fecha_inicio');
        $fecha_fin    = $this->request->getPost('fecha_fin');

        $db = \Config\Database::connect();
        $builder = $db->table('movimiento_inventario');
        $builder->select('movimiento_inventario.*, productos.nombre_producto, sucursales.nombre as nombre_sucursal, almacenes.nombre as nombre_almacen, usuarios.usuario as nombre_usuario');
        $builder->join('productos', 'productos.id = movimiento_inventario.producto_id');
        $builder->join('almacenes', 'almacenes.id = movimiento_inventario.almacen_id');
        $builder->join('sucursales', 'sucursales.id = almacenes.sucursal_id');
        $builder->join('usuarios', 'usuarios.id = movimiento_inventario.usuario_id', 'left');

        if (!empty($producto_id)) {
            $builder->where('movimiento_inventario.producto_id', $producto_id);
        }
        if (!empty($sucursal_id)) {
            $builder->where('almacenes.sucursal_id', $sucursal_id);
        }
        if (!empty($almacen_id)) {
            $builder->where('movimiento_inventario.almacen_id', $almacen_id);
        }
        if (!empty($fecha_inicio)) {
            $builder->where('DATE(movimiento_inventario.created_at) >=', $fecha_inicio);
        }
        if (!empty($fecha_fin)) {
            $builder->where('DATE(movimiento_inventario.created_at) <=', $fecha_fin);
        }

        $builder->orderBy('movimiento_inventario.created_at', 'DESC');
        $movimientos = $builder->get()->getResultArray();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $movimientos
        ]);
    }

    public function exportarExcel()
    {
        $producto_id = $this->request->getGet('producto_id');
        $sucursal_id = $this->request->getGet('sucursal_id');
        $almacen_id  = $this->request->getGet('almacen_id');
        $fecha_inicio = $this->request->getGet('fecha_inicio');
        $fecha_fin    = $this->request->getGet('fecha_fin');

        $db = \Config\Database::connect();
        $builder = $db->table('movimiento_inventario');
        $builder->select('movimiento_inventario.*, productos.nombre_producto, sucursales.nombre as nombre_sucursal, almacenes.nombre as nombre_almacen, usuarios.usuario as nombre_usuario');
        $builder->join('productos', 'productos.id = movimiento_inventario.producto_id');
        $builder->join('almacenes', 'almacenes.id = movimiento_inventario.almacen_id');
        $builder->join('sucursales', 'sucursales.id = almacenes.sucursal_id');
        $builder->join('usuarios', 'usuarios.id = movimiento_inventario.usuario_id', 'left');

        if (!empty($producto_id)) $builder->where('movimiento_inventario.producto_id', $producto_id);
        if (!empty($sucursal_id)) $builder->where('almacenes.sucursal_id', $sucursal_id);
        if (!empty($almacen_id)) $builder->where('movimiento_inventario.almacen_id', $almacen_id);
        if (!empty($fecha_inicio)) $builder->where('DATE(movimiento_inventario.created_at) >=', $fecha_inicio);
        if (!empty($fecha_fin)) $builder->where('DATE(movimiento_inventario.created_at) <=', $fecha_fin);

        $builder->orderBy('movimiento_inventario.created_at', 'DESC');
        $movimientos = $builder->get()->getResultArray();

        $filename = "kardex_" . date('Ymd_His') . ".csv";

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');
        // BOM for Excel UTF-8
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        fputcsv($output, ['FECHA', 'PRODUCTO', 'SUCURSAL', 'ALMACEN', 'TIPO', 'CANTIDAD', 'SALDO FINAL', 'MOTIVO', 'USUARIO', 'DOCUMENTO']);

        foreach ($movimientos as $m) {
            fputcsv($output, [
                $m['created_at'],
                $m['nombre_producto'],
                $m['nombre_sucursal'],
                $m['nombre_almacen'],
                strtoupper($m['tipo']),
                $m['cantidad'],
                $m['stock_actual'],
                $m['motivo'],
                $m['nombre_usuario'],
                ($m['referencia_tipo'] ?? '-') . " " . ($m['num_documento'] ?? $m['referencia_id'] ?? '-')
            ]);
        }

        fclose($output);
        exit;
    }
}
