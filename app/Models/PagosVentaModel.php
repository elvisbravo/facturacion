<?php

namespace App\Models;

use CodeIgniter\Model;

class PagosVentaModel extends Model
{
    protected $table      = 'pagos_venta';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'venta_id', 'monto', 'metodo_pago_id', 'referencia', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
