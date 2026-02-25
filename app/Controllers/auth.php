<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use CodeIgniter\RESTful\ResourceController;

class Auth extends ResourceController
{
    protected $format = 'json';

    public function login()
    {
        try {
            $data = json_decode($this->request->getBody(true));

            if (empty($data->usuario) || empty($data->password)) {
                return $this->failValidationErrors('Faltan datos obligatorios');
            }

            $usuario = new UsuariosModel();

            $usuarios = $usuario->query("SELECT usuarios.id, usuarios.usuario, usuarios.nombres, usuarios.apellidos, perfil.id AS rol_id, perfil.nombre_perfil AS rol FROM usuarios INNER JOIN perfil ON usuarios.perfil_id = perfil.id WHERE usuarios.estado = 1 and usuarios.usuario = ? AND usuarios.password = ?", [$data->usuario, $data->password])->getRow();

            if (empty($usuarios)) {
                return $this->failNotFound('Usuario o contraseña incorrectos');
            }

            return $this->respond([
                'status' => 200,
                'mensaje' => 'Login exitoso',
                'result' => $usuarios
            ]);
        } catch (\Exception $e) {
            return $this->failServerError('Error interno del servidor');
        }
    }

    public function show($id = null)
    {
        return $this->respond([
            'id' => $id,
            'nombre' => 'Cliente ' . $id
        ]);
    }

    public function create()
    {
        $data = [];

        return $this->respondCreated([
            'mensaje' => 'Cliente creado',
            'data' => $data
        ]);
    }

    public function update($id = null)
    {
        $data = [];

        return $this->respond([
            'mensaje' => 'Cliente actualizado',
            'id' => $id,
            'data' => $data
        ]);
    }

    public function delete($id = null)
    {
        return $this->respondDeleted([
            'mensaje' => 'Cliente eliminado',
            'id' => $id
        ]);
    }
}
