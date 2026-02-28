<?php
require 'vendor/autoload.php';
$db = \Config\Database::connect();
$results = $db->table('productos')->like('nombre_producto', 'entrada')->get()->getResultArray();
echo json_encode($results);
