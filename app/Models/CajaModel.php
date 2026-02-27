<?php

namespace App\Models;

use CodeIgniter\Model;

class CajaModel extends Model
{
    protected $table      = 'caja';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'sucursal_id', 'nombre_caja', 'estado', 'hora_cierre'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
