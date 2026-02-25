<?php

namespace App\Models;

use CodeIgniter\Model;

class InventarioModel extends Model
{
    protected $table      = 'inventario';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'almacen_id', 'producto_id', 'stock_actual', 'stock_minimo', 'stock_maximo', 'tipo_envio_sunat', 'usuario_id'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
