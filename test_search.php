<?php
define('FCPATH', __DIR__ . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR);
require 'vendor/autoload.php';
$db = \Config\Database::connect();
$results = $db->table('productos')->select('id, nombre_producto')->like('nombre_producto', 'entrada')->get()->getResultArray();
echo json_encode($results);
