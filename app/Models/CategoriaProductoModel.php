<?php

namespace App\Models;

use CodeIgniter\Model;

class CategoriaProductoModel extends Model
{
    protected $table      = 'categoria_producto';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'nombre_categoria', 'descripcion', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
