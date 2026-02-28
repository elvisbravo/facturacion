<?php
// Mock script to add a ticket product
require_once 'app/Config/Constants.php';
require_once 'system/bootstrap.php';

$db = \Config\Database::connect();

// 1. Create Category "CONCIERTOS" if not exists
$cat = $db->table('categoria_producto')->where('nombre_categoria', 'CONCIERTOS')->get()->getRow();
if (!$cat) {
    $db->table('categoria_producto')->insert([
        'nombre_categoria' => 'CONCIERTOS',
        'descripcion' => 'Entradas para eventos',
        'estado' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    $catId = $db->insertID();
} else {
    $catId = $cat->id;
}

// 2. Create Product "ENTRADA GENERAL" if not exists
$prod = $db->table('productos')->where('nombre_producto', 'ENTRADA GENERAL')->get()->getRow();
if (!$prod) {
    $db->table('productos')->insert([
        'codigo' => 'TICKET-001',
        'tipo_afectacion_igv' => '20', // Exonerado
        'categoria_id' => $catId,
        'nombre_producto' => 'ENTRADA GENERAL',
        'precio_venta' => 50.00,
        'codigo_moneda' => 'PEN',
        'unidad_medida_id' => 7, // NIU / Unidad
        'imagen_producto' => 'producto.png',
        'estado' => 1,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);
    $prodId = $db->insertID();

    // Initial Stock in Warehouse 1
    $db->table('inventario')->insert([
        'producto_id' => $prodId,
        'almacen_id' => 1,
        'stock' => 1000,
        'created_at' => date('Y-m-d H:i:s'),
        'updated_at' => date('Y-m-d H:i:s')
    ]);

    // Presentation (factor 1)
    $db->table('presentacion_producto')->insert([
        'producto_id' => $prodId,
        'nombre_presentacion' => 'UNIDAD',
        'factor_conversion' => 1,
        'precio_venta' => 50.00,
        'predeterminado' => 1,
        'estado' => 1
    ]);
}
echo "Configuración de entradas lista.";
