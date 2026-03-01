<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

$routes->post('auth/acceder', 'Auth::acceder');
$routes->get('auth/salir', 'Auth::salir');

$routes->match(['get', 'post'], 'dashboard', 'Dashboard::admin');

$routes->get('productos', 'Productos::index');

$routes->get('ventas', 'Ventas::index');
$routes->get('ventas/listar', 'Ventas::listar');
$routes->get('ventas/detalle/(:num)', 'Ventas::detalle/$1');
$routes->get('pos', 'Ventas::posVenta');
$routes->get('ventas/ticket/(:num)', 'Ventas::ticket/$1');
$routes->post('ventas/guardar', 'Ventas::guardar');

$routes->get('entradas', 'Entradas::index');
$routes->get('entradas/listar', 'Entradas::listar');
$routes->post('entradas/guardar', 'Entradas::guardar');

$routes->get('caja-aperturar', 'Caja::aperturar');
$routes->post('caja/abrir', 'Caja::abrir');
$routes->post('caja/cerrar', 'Caja::cerrar');

$routes->get('categorias', 'Productos::categorias');
$routes->get('categorias/delete/(:num)', 'Productos::deleteCategoria/$1');
$routes->post('categorias/guardar', 'Productos::guardarCategoria');
$routes->get('categorias/listar', 'Productos::listarCategorias');

$routes->get('productos/listar', 'Productos::listarProductos');
$routes->get('productos/get/(:num)', 'Productos::getProducto/$1');
$routes->post('productos/guardar', 'Productos::guardarProducto');
$routes->get('productos/delete/(:num)', 'Productos::deleteProducto/$1');
$routes->post('productos/ajustar_stock', 'Productos::ajustarStock');

$routes->get('unidad_medida/listar', 'UnidadMedida::listar');

$routes->get('almacen/listar', 'Almacen::listar');

$routes->get('tipo_afectacion_igv/listar', 'TipoAfectacionIgv::listar');

$routes->get('metodo_pago/listar', 'MetodoPago::listar');

$routes->get('clientes/listar', 'Clientes::listar');
$routes->post('clientes/buscar', 'Clientes::buscar');
$routes->post('clientes/guardar', 'Clientes::guardar');
$routes->get('clientes/tipos_documento', 'Clientes::getTiposDocumento');

// Usuarios
$routes->get('usuarios', 'Usuarios::index');
$routes->get('usuarios/listar', 'Usuarios::listar');
$routes->post('usuarios/guardar', 'Usuarios::guardar');
$routes->get('usuarios/eliminar/(:num)', 'Usuarios::eliminar/$1');
$routes->get('usuarios/get/(:num)', 'Usuarios::getUsuario/$1');

// Configuración
$routes->get('configuracion', 'Configuracion::index');
$routes->post('configuracion/guardar_caja', 'Configuracion::guardarCaja');
$routes->post('configuracion/guardar_comprobante', 'Configuracion::guardarComprobante');
$routes->post('configuracion/guardar_sucursal', 'Configuracion::guardarSucursal');
$routes->get('configuracion/eliminar_comprobante/(:num)', 'Configuracion::eliminarComprobante/$1');

// Almacenes
$routes->get('almacen', 'Almacen::index');
$routes->get('almacen/listar', 'Almacen::listar');
$routes->post('almacen/guardar', 'Almacen::guardar');
$routes->get('almacen/eliminar/(:num)', 'Almacen::eliminar/$1');
$routes->get('almacen/get/(:num)', 'Almacen::getAlmacen/$1');
$routes->get('almacen/getPorSucursal/(:num)', 'Almacen::getPorSucursal/$1');

// Kardex
$routes->get('kardex', 'Kardex::index');
$routes->post('kardex/buscar', 'Kardex::buscar');
$routes->get('kardex/exportarExcel', 'Kardex::exportarExcel');

// Reportes
$routes->get('reportes/ventas', 'Reportes::ventas');
$routes->post('reportes/buscarVentas', 'Reportes::buscarVentas');
$routes->get('reportes/exportarVentas', 'Reportes::exportarVentas');
