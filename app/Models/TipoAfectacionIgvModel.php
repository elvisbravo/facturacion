<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoAfectacionIgvModel extends Model
{
    protected $table      = 'sunat_tipoafectacionigv';
    protected $primaryKey = 'id_tipoafectacionigv';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id_tipoafectacionigv', 'descripcion'];

    protected $useTimestamps = false;
}
