<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleVentaModel extends Model
{
    protected $table      = 'detalle_venta';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'venta_id', 'presentacion_id', 'unidad_medida_id', 'unidad_medida', 'cantidad', 'precio', 'subtotal', 'id_codigoprecio', 'igv', 'isc', 'icbper', 'importe', 'id_tipoafectacionigv', 'codigo_producto', 'descripcion', 'precio_sin_igv', 'tipo_unidad', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
