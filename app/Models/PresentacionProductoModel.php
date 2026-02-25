<?php

namespace App\Models;

use CodeIgniter\Model;

class PresentacionProductoModel extends Model
{
    protected $table      = 'presentacion_producto';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'producto_id', 'nombre', 'estado', 'codigo_barras', 'precio_con_igv', 'precio_sin_igv', 'unidad_medida_id', 'factor_conversion'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
