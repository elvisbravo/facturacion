<?php
$db = mysqli_connect('localhost', 'root', '', 'facturacion');
if (!$db) die("Connection failed: " . mysqli_connect_error());

$res = mysqli_query($db, "DESCRIBE detalle_venta");
echo "Detalle Venta Columns:\n";
while ($row = mysqli_fetch_assoc($res)) {
    echo $row['Field'] . " (" . $row['Type'] . ")\n";
}

$res2 = mysqli_query($db, "SELECT * FROM detalle_venta LIMIT 1");
$row2 = mysqli_fetch_assoc($res2);
echo "\nEjemplo Detalle Venta:\n";
print_r($row2);

mysqli_close($db);
