<?php

namespace App\Models;

use CodeIgniter\Model;

class ConceptosModel extends Model
{
    protected $table      = 'conceptos';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'nombre_concepto', 'tipo_movimiento', 'visible', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
