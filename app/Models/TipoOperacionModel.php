<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoOperacionModel extends Model
{
    protected $table      = 'sunat_tipooperacion';
    protected $primaryKey = 'id_codigotipooperacion';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id_codigotipooperacion', 'orden', 'descripcion'];

    protected $useTimestamps = false;
}
