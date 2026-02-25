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
        $usuario = $usuariosModel->join('perfil', 'perfil.id = usuarios.perfil_id')->where('usuarios.usuario', $usuario)->first();

        if (empty($usuario)) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Usuario no encontrado"
            ]);
        }

        if ($usuario['password'] != $password) {
            return $this->response->setJSON([
                "status" => "error",
                "message" => "Contraseña incorrecta"
            ]);
        }

        $session = session();
        $session->set([
            'id' => $usuario['id'],
            'usuario' => $usuario['usuario'],
            'nombres' => $usuario['nombres'],
            'apellidos' => $usuario['apellidos'],
            'rol' => $usuario['nombre_perfil'],
            'rol_id' => $usuario['perfil_id'],
            'logged_in' => true
        ]);

        return $this->response->setJSON([
            "status" => "success",
            "message" => "Login exitoso"
        ]);
    }
}
