<?php

namespace App\Controllers;

use App\Models\UsuariosModel;

class Auth extends BaseController
{
    public function login()
    {
        return view('auth/login');
    }

    public function acceder()
    {
        $usuario = $this->request->getPost('usuario');
        $password = $this->request->getPost('password');

        if (empty($usuario) || empty($password)) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Usuario y contraseña son obligatorios"
            ]);
        }

        $usuariosModel = new UsuariosModel();

        $user = $usuariosModel
            ->select('usuarios.*, perfil.nombre_perfil, sucursales.tipo_envio_sunat')
            ->join('perfil', 'perfil.id = usuarios.perfil_id')
            ->join('sucursales', 'sucursales.id = usuarios.sucursal_id')
            ->where('usuarios.usuario', $usuario)
            ->first();

        if (empty($user)) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Usuario no encontrado"
            ]);
        }

        if ($user['password'] != $password) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Contraseña incorrecta"
            ]);
        }

        $session = session();
        $session->set([
            'id' => $user['id'],
            'usuario' => $user['usuario'],
            'nombres' => $user['nombres'],
            'apellidos' => $user['apellidos'],
            'rol' => $user['nombre_perfil'],
            'rol_id' => $user['perfil_id'],
            'sucursal_id' => $user['sucursal_id'],
            'tipo_envio_sunat' => $user['tipo_envio_sunat'],
            'logged_in' => true
        ]);

        return $this->response->setJSON([
            "status" => "success",
            "message" => "Login exitoso"
        ]);
    }
}
