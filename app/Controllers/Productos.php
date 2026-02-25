<?php

namespace App\Controllers;

use App\Models\CategoriaProductoModel;
use App\Models\ProductoModel;

class Productos extends BaseController
{
    public function index()
    {
        return view('productos/index');
    }

    public function categorias()
    {
        return view('productos/categorias');
    }

    public function guardarCategoria()
    {
        $categoriaModel = new CategoriaProductoModel();

        try {
            $nombre = $this->request->getPost('nombre_categoria');
            $descripcion = $this->request->getPost('descripcion');
            $id = $this->request->getPost('id');

            $data = [
                'nombre_categoria' => $nombre,
                'descripcion' => $descripcion,
                'estado' => 1
            ];

            if ($id == 0) {
                $categoriaModel->save($data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Categoría guardada correctamente'
                ]);
            } else {
                $categoriaModel->update($id, $data);

                return $this->response->setJSON([
                    'status' => 'success',
                    'message' => 'Categoría actualizada correctamente'
                ]);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al guardar la categoría'
            ]);
        }
    }

    public function listarCategorias()
    {
        $categoriaModel = new CategoriaProductoModel();
        $categorias = $categoriaModel
            ->select('categoria_producto.*, COUNT(productos.id) as total_productos')
            ->join('productos', 'productos.categoria_id = categoria_producto.id', 'left')
            ->where('categoria_producto.estado', 1)
            ->groupBy('categoria_producto.id')
            ->findAll();

        return $this->response->setJSON($categorias);
    }

    public function deleteCategoria($id)
    {
        $categoriaModel = new CategoriaProductoModel();

        $data = [
            'estado' => 0
        ];

        $categoriaModel->update($id, $data);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Categoría eliminada correctamente'
        ]);
    }

    public function listarProductos()
    {
        $productoModel = new ProductoModel();
        $productos = $productoModel
            ->select('productos.*, categoria_producto.nombre_categoria as categoria, sunat_unidadmedida.nombre as unidad')
            ->join('categoria_producto', 'categoria_producto.id = productos.categoria_id', 'left')
            ->join('sunat_unidadmedida', 'sunat_unidadmedida.idunidad = productos.unidad_medida_id', 'left')
            ->where('productos.estado', 1)
            ->findAll();

        return $this->response->setJSON($productos);
    }

    public function guardarProducto()
    {
        $productoModel = new ProductoModel();

        try {
            $id = $this->request->getPost('id');
            $data = [
                'nombre_producto' => $this->request->getPost('nombre'),
                'codigo' => $this->request->getPost('sku'),
                'categoria_id' => $this->request->getPost('categoria_id'),
                'tipo_afectacion_igv' => $this->request->getPost('tipo_igv'),
                'codigo_moneda' => $this->request->getPost('moneda'),
                'unidad_medida_id' => $this->request->getPost('unidad_medida'),
                'estado' => 1
            ];

            if ($id == 0) {
                $productoModel->save($data);
                return $this->response->setJSON(['status' => 'success', 'message' => 'Producto guardado correctamente']);
            } else {
                $productoModel->update($id, $data);
                return $this->response->setJSON(['status' => 'success', 'message' => 'Producto actualizado correctamente']);
            }
        } catch (\Exception $e) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Error al procesar el producto: ' . $e->getMessage()]);
        }
    }

    public function getProducto($id)
    {
        $productoModel = new ProductoModel();
        $producto = $productoModel->find($id);

        return $this->response->setJSON($producto);
    }

    public function deleteProducto($id)
    {
        $productoModel = new ProductoModel();
        $productoModel->update($id, ['estado' => 0]);

        return $this->response->setJSON([
            'status' => 'success',
            'message' => 'Producto eliminado correctamente'
        ]);
    }
}
