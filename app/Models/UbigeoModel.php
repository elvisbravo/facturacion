<?php

namespace App\Models;

use CodeIgniter\Model;

class UbigeoModel extends Model
{
    protected $table      = 'sunat_codigoubigeo';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'codigo_ubigeo', 'departamento', 'provincia', 'distrito'];

    protected $useTimestamps = false;
}
