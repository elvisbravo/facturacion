<?php

namespace App\Models;

use CodeIgniter\Model;

class EmpresasModel extends Model
{
    protected $table      = 'empresas';
    protected $primaryKey = 'id';

    protected $useAutoIncrement = true;

    protected $returnType     = 'array';

    protected $allowedFields = ['id', 'ruc', 'razon_social', 'direccion_fiscal', 'email', 'usuario_sol', 'clave_sol', 'pass_certificado', 'logo', 'estado', 'nombre_comercial'];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
