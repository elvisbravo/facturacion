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

$routes->get('caja', 'Caja::index');

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
