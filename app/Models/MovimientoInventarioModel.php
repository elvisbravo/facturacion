<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimientoInventarioModel extends Model
{
    protected $table      = 'movimiento_inventario';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'producto_id', 'almacen_id ', 'tipo', 'cantidad', 'motivo', 'referencia_id', 'referencia_tipo', 'num_documento', 'tipo_envio_sunat'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
