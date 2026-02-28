<?php

namespace App\Controllers;

use App\Models\UsuariosModel;
use App\Models\PerfilModel;
use App\Models\SucursalesModel;
use App\Models\AlmacenModel;

class Usuarios extends BaseController
{
    public function index()
    {
        $perfilModel = new PerfilModel();
        $sucursalModel = new SucursalesModel();
        $almacenModel = new AlmacenModel();

        $data = [
            'perfiles'   => $perfilModel->where('estado', 1)->findAll(),
            'sucursales' => $sucursalModel->where('estado', 1)->findAll(),
            'almacenes'  => $almacenModel->where('estado', 1)->findAll()
        ];

        return view('usuarios/index', $data);
    }

    public function listar()
    {
        try {
            $usuariosModel = new UsuariosModel();
            $usuarios = $usuariosModel->select('usuarios.*, perfil.nombre_perfil, sucursales.nombre as nombre_sucursal')
                ->join('perfil', 'perfil.id = usuarios.perfil_id')
                ->join('sucursales', 'sucursales.id = usuarios.sucursal_id')
                ->where('usuarios.estado', 1)
                ->findAll();

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $usuarios
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar usuarios: ' . $e->getMessage()
            ], 500);
        }
    }

    public function guardar()
    {
        try {
            $usuariosModel = new UsuariosModel();
            $id = $this->request->getPost('id');

            $perfil_id = $this->request->getPost('perfil_id');
            $data = [
                'usuario'     => $this->request->getPost('usuario'),
                'nombres'     => $this->request->getPost('nombres'),
                'apellidos'   => $this->request->getPost('apellidos'),
                'perfil_id'   => $perfil_id,
                'sucursal_id' => $this->request->getPost('sucursal_id'),
                'estado'      => 1
            ];

            // Lógica de Almacén: Administrador (1) -> Almacén 1, Cajero (2) -> Almacén seleccionado
            if ($perfil_id == 1) {
                $data['almacen_id'] = 1;
            } else if ($perfil_id == 2) {
                $data['almacen_id'] = $this->request->getPost('almacen_id');
            }

            $password = $this->request->getPost('password');
            if (!empty($password)) {
                $data['password'] = $password;
            }

            if (empty($id)) {
                if (empty($password)) {
                    return $this->response->setJSON([
                        'status' => 'error',
                        'message' => 'La contraseña es obligatoria para nuevos usuarios'
                    ], 400);
                }
                $usuariosModel->insert($data);
                $message = 'Usuario creado correctamente';
            } else {
                $usuariosModel->update($id, $data);
                $message = 'Usuario actualizado correctamente';
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => $message
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al guardar usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getUsuario($id)
    {
        try {
            $usuariosModel = new UsuariosModel();
            $usuario = $usuariosModel->find($id);

            if ($usuario) {
                // Remove password from response for security (even if it's plain text in DB)
                unset($usuario['password']);
                return $this->response->setJSON([
                    'status' => 'success',
                    'data' => $usuario
                ]);
            } else {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'Usuario no encontrado'
                ], 404);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al obtener usuario: ' . $e->getMessage()
            ], 500);
        }
    }

    public function eliminar($id)
    {
        try {
            $usuariosModel = new UsuariosModel();
            // Logical delete
            $usuariosModel->update($id, ['estado' => 0]);

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Usuario eliminado correctamente'
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al eliminar usuario: ' . $e->getMessage()
            ], 500);
        }
    }
}
