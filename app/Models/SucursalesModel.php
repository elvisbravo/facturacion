<?php

namespace App\Models;

use CodeIgniter\Model;

class SucursalesModel extends Model
{
    protected $table      = 'sucursales';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'empresa_id', 'codigo_anexo', 'nombre', 'factor_igv', 'direccion', 'ubigeo_id', 'urbanizacion', 'telefono', 'email', 'tipo_envio_sunat', 'estado'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
