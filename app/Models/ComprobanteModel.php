<?php

namespace App\Models;

use CodeIgniter\Model;

class ComprobanteModel extends Model
{
    protected $table      = 'sunat_tipodocelectronico';
    protected $primaryKey = 'id_tipodoc_electronico';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id_tipodoc_electronico', 'descripcion'];

    protected $useTimestamps = false;
}
