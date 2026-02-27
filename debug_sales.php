<?php
require 'vendor/autoload.php';
$db = \Config\Database::connect();
$query = $db->query('SELECT sucursal_id, COUNT(*) as count FROM ventas GROUP BY sucursal_id');
print_r($query->getResultArray());

$query2 = $db->query('SELECT * FROM ventas LIMIT 1');
print_r($query2->getRowArray());
