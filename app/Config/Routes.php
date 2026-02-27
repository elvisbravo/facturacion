<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Auth::login');

$routes->post('auth/acceder', 'Auth::acceder');

$routes->get('dashboard', 'Dashboard::admin');

$routes->get('productos', 'Productos::index');

$routes->get('ventas', 'Ventas::index');
$routes->get('ventas/listar', 'Ventas::listar');
$routes->get('ventas/detalle/(:num)', 'Ventas::detalle/$1');
$routes->get('pos', 'Ventas::posVenta');
$routes->get('ventas/ticket/(:num)', 'Ventas::ticket/$1');
$routes->post('ventas/guardar', 'Ventas::guardar');

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

$routes->get('unidad_medida/listar', 'UnidadMedida::listar');

$routes->get('almacen/listar', 'Almacen::listar');

$routes->get('tipo_afectacion_igv/listar', 'TipoAfectacionIgv::listar');

$routes->get('metodo_pago/listar', 'MetodoPago::listar');

$routes->get('clientes/listar', 'Clientes::listar');
$routes->post('clientes/buscar', 'Clientes::buscar');
$routes->post('clientes/guardar', 'Clientes::guardar');
$routes->get('clientes/tipos_documento', 'Clientes::getTiposDocumento');
