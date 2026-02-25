<?php

namespace App\Models;

use CodeIgniter\Model;

class MovimientoCajaModel extends Model
{
    protected $table      = 'movimiento_caja';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'apertura_caja_id', 'tipo_movimiento', 'monto', 'metodo_pago_id', 'referencia_mov_id', 'referencia_tipo_mov', 'concepto_id', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
