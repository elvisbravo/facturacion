<?php

namespace App\Models;

use CodeIgniter\Model;

class MetodosPagoModel extends Model
{
    protected $table      = 'metodos_pago';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'nombre', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
