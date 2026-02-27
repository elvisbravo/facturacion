<?php
require 'vendor/autoload.php';
// Need to define constants or simulate environment for CI configs
define('ENVIRONMENT', 'development');

// Simulate the database connection manually if CI isn't helping
$db = mysqli_connect('localhost', 'root', '', 'facturacion');
if (!$db) die("Connection failed: " . mysqli_connect_error());

$res = mysqli_query($db, "SELECT sucursal_id, COUNT(*) as qty FROM ventas GROUP BY sucursal_id");
echo "Ventas por sucursal:\n";
while ($row = mysqli_fetch_assoc($res)) {
    echo "Sucursal ID: " . $row['sucursal_id'] . " - Cantidad: " . $row['qty'] . "\n";
}

$res2 = mysqli_query($db, "SELECT * FROM ventas LIMIT 1");
$row2 = mysqli_fetch_assoc($res2);
echo "Ejemplo de venta:\n";
print_r($row2);

mysqli_close($db);
