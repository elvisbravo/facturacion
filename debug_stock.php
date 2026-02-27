<?php
// Cargar el entorno de CodeIgniter 4
define('ENVIRONMENT', 'development');
defined('FCPATH') || define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
$pathsConfig = 'app/Config/Paths.php';
require realpath($pathsConfig) ?: $pathsConfig;
$paths = new Config\Paths();
require rtrim($paths->systemDirectory, '\\/ ') . DIRECTORY_SEPARATOR . 'bootstrap.php';

$db = \Config\Database::connect();

$sql = "SELECT p.nombre_producto, i.stock_actual, i.tipo_envio_sunat, a.nombre as almacen, a.sucursal_id
        FROM productos p
        LEFT JOIN inventario i ON p.id = i.producto_id
        LEFT JOIN almacenes a ON a.id = i.almacen_id
        WHERE p.estado = 1";

$query = $db->query($sql);
echo "Resultados de Inventario:\n";
foreach ($query->getResultArray() as $row) {
    print_r($row);
}
