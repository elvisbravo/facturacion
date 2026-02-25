<?php

namespace App\Models;

use CodeIgniter\Model;

class ConfiguracionComprobantesModel extends Model
{
    protected $table      = 'configuracion_comprobantes';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'sucursal_id', 'comprobante_id', 'serie', 'numero', 'estado', 'tipo_envio_sunat'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
