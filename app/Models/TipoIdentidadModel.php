<?php

namespace App\Models;

use CodeIgniter\Model;

class TipoIdentidadModel extends Model
{
    protected $table      = 'sunat_tipodocidentidad';
    protected $primaryKey = 'id_tipodocidentidad';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id_tipodocidentidad', 'nombre', 'descripcion'];

    protected $useTimestamps = false;
}
