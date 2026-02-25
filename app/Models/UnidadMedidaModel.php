<?php

namespace App\Models;

use CodeIgniter\Model;

class UnidadMedidaModel extends Model
{
    protected $table      = 'sunat_unidadmedida';
    protected $primaryKey = 'idunidad';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['idunidad', 'codigo', 'nombre', 'simbolo'];

    protected $useTimestamps = false;
}
