<?php
$db = mysqli_connect('localhost', 'root', '', 'facturacion');
if (!$db) die("Connection failed: " . mysqli_connect_error());

$res = mysqli_query($db, "SELECT pv.*, mp.nombre as metodo FROM pagos_venta pv JOIN metodos_pago mp ON mp.id = pv.metodo_pago_id WHERE pv.venta_id = 1");
echo "Pagos para venta 1 (pagos_venta):\n";
while ($row = mysqli_fetch_assoc($res)) {
    print_r($row);
}

$res2 = mysqli_query($db, "SELECT * FROM movimiento_caja WHERE referencia_mov_id = 1 AND referencia_tipo_mov = 'VENTA'");
echo "\nMovimientos en caja para venta 1:\n";
while ($row2 = mysqli_fetch_assoc($res2)) {
    print_r($row2);
}

mysqli_close($db);
