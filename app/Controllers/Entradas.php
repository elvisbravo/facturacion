<?php

namespace App\Controllers;

use App\Models\VentasModel;
use App\Models\ComprobanteModel;
use App\Models\ProductoModel;
use App\Models\ConfiguracionComprobantesModel;
use App\Models\DetalleVentaModel;
use App\Models\InventarioModel;
use App\Models\MovimientoInventarioModel;
use App\Models\PresentacionProductoModel;
use App\Models\MetodosPagoModel;

class Entradas extends BaseController
{
    public function index()
    {
        $comprobanteModel = new ComprobanteModel();
        // Obtener Boleta (03), Factura (01) y Nota de Venta (77)
        $data['tiposComprobante'] = $comprobanteModel->whereIn('id_tipodoc_electronico', ['03', '01', '77'])->findAll();

        $metodoPagoModel = new MetodosPagoModel();
        $data['metodosPago'] = $metodoPagoModel->where('estado', 1)->findAll();

        $session_sucursal = session()->get('sucursal_id');
        $sucursal_id = !empty($session_sucursal) ? $session_sucursal : 1;
        $tipoEnvio = session()->get('tipo_envio_sunat') ?? 'prueba';

        $productoModel = new ProductoModel();
        // Cargar productos que sean entradas con su stock actual en la sucursal/entorno vigente
        $data['entradas'] = $productoModel->select('productos.id, productos.nombre_producto, COALESCE(pp.precio_con_igv, 0) as precio_venta, COALESCE(SUM(inventario.stock_actual), 0) as stock_actual')
            ->join('presentacion_producto pp', 'pp.producto_id = productos.id AND pp.factor_conversion = 1', 'left')
            ->join('inventario', 'inventario.producto_id = productos.id', 'left')
            ->join('almacenes', 'almacenes.id = inventario.almacen_id', 'left')
            ->where('almacenes.sucursal_id', $sucursal_id)
            ->where('inventario.tipo_envio_sunat', $tipoEnvio)
            ->where('productos.estado', 1)
            ->groupStart()
            ->like('nombre_producto', 'ENTRADA')
            ->orLike('nombre_producto', 'TICKET')
            ->groupEnd()
            ->groupBy('productos.id')
            ->findAll();

        $data['cajaAbierta'] = getCajaAbierta();

        return view('entradas/index', $data);
    }

    public function guardar()
    {
        // Reutilizar la lógica de Ventas.guardar pero simplificada
        // O simplemente redirigir a un comando interno.
        // Mejor la implemento aquí para que sea independiente.

        $ventasController = new Ventas();
        return $ventasController->guardar();
    }
}
