<?php

namespace App\Models;

use CodeIgniter\Model;

class AperturaCajaModel extends Model
{
    protected $table      = 'apertura_caja';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'caja_id', 'usuario_id', 'fecha_apertura', 'monto_inicial', 'fecha_cierre', 'monto_cierre', 'estado'];

    protected $useTimestamps = false;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
