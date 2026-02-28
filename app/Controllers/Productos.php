<?php

namespace App\Controllers;

use App\Models\CategoriaProductoModel;
use App\Models\InventarioModel;
use App\Models\MovimientoInventarioModel;
use App\Models\PresentacionProductoModel;
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
        $session_sucursal = session()->get('sucursal_id');
        $sucursal_id = !empty($session_sucursal) ? $session_sucursal : 1;
        $tipoEnvio = session()->get('tipo_envio_sunat') ?? 'prueba';

        $almacen_id = $this->request->getGet('almacen_id');
        $categoria_id = $this->request->getGet('categoria_id');

        try {
            $sqlAlmacen = "";
            if ($almacen_id != 0 && !empty($almacen_id)) {
                $sqlAlmacen = " AND i.almacen_id = " . intval($almacen_id);
            }

            $sqlCategoria = "";
            if ($categoria_id != 0 && !empty($categoria_id)) {
                $sqlCategoria = " AND p.categoria_id = " . intval($categoria_id);
            }

            $producto = new ProductoModel();

            // Usamos LEFT JOIN para que aparezcan productos sin stock o sin presentaciones aún
            // Agrupamos por ID de producto para sumar los stocks de los almacenes
            $sql = "SELECT 
                        p.id, 
                        p.nombre_producto, 
                        p.codigo, 
                        p.categoria_id, 
                        p.tipo_afectacion_igv, 
                        p.codigo_moneda, 
                        p.unidad_medida_id, 
                        p.imagen_producto, 
                        c.nombre_categoria as categoria,
                        sum.nombre as unidad, 
                        COALESCE(pp.precio_compra, 0) as precio_compra, 
                        COALESCE(pp.precio_con_igv, 0) as precio_venta,
                        COALESCE(SUM(i.stock_actual), 0) as stock
                    FROM productos p 
                    LEFT JOIN categoria_producto c ON c.id = p.categoria_id
                    LEFT JOIN sunat_unidadmedida sum ON sum.idunidad = p.unidad_medida_id
                    LEFT JOIN presentacion_producto pp ON pp.producto_id = p.id AND pp.factor_conversion = 1
                    LEFT JOIN (
                        SELECT producto_id, stock_actual, tipo_envio_sunat, almacen_id 
                        FROM inventario 
                        INNER JOIN almacenes ON almacenes.id = inventario.almacen_id
                        WHERE almacenes.sucursal_id = $sucursal_id
                    ) i ON i.producto_id = p.id AND i.tipo_envio_sunat = '$tipoEnvio' $sqlAlmacen
                    WHERE p.estado = 1 $sqlCategoria
                    GROUP BY p.id";

            $datos = $producto->query($sql)->getResultArray();

            return $this->response->setJSON([
                'status' => 'success',
                'data' => $datos
            ]);
        } catch (\Exception $e) {
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al listar los productos: ' . $e->getMessage()
            ]);
        }
    }

    public function guardarProducto()
    {
        $productoModel = new ProductoModel();
        $presentacion = new PresentacionProductoModel();
        $inventario = new InventarioModel();
        $movimiento_inventario = new MovimientoInventarioModel();

        $productoModel->db->transStart();

        try {
            $id = $this->request->getPost('id');
            $img = $this->request->getFile('imagen_producto');
            $nombre_producto = $this->request->getPost('nombre');

            // Determinar nombre de imagen
            if ($img && $img->isValid() && !$img->hasMoved()) {
                $nombre_limpio = str_replace(' ', '', $nombre_producto);
                $codigo_aleatorio = substr(str_shuffle("0123456789"), 0, 4);
                $imagen_nombre = $nombre_limpio . $codigo_aleatorio . "." . $img->getExtension();

                $uploadPath = ROOTPATH . 'public/uploads/productos/';
                if (!is_dir($uploadPath)) {
                    mkdir($uploadPath, 0777, true);
                }
                $img->move($uploadPath, $imagen_nombre);
            } else {
                if ($id == 0) {
                    $imagen_nombre = "producto.png";
                } else {
                    $productoActual = $productoModel->find($id);
                    $imagen_nombre = $productoActual['imagen_producto'] ?? "producto.png";
                }
            }

            $data = [
                'nombre_producto' => $nombre_producto,
                'codigo' => $this->request->getPost('sku'),
                'categoria_id' => $this->request->getPost('categoria_id'),
                'tipo_afectacion_igv' => $this->request->getPost('tipo_igv'),
                'codigo_moneda' => $this->request->getPost('moneda'),
                'unidad_medida_id' => $this->request->getPost('unidad_medida'),
                'imagen_producto' => $imagen_nombre,
                'estado' => 1
            ];

            if ($id == 0) {
                if (!$productoModel->insert($data)) {
                    throw new \Exception("Error al insertar el producto maestro.");
                }
                $newProductId = $productoModel->insertID();

                $presentacion->insert([
                    'producto_id' => $newProductId,
                    'nombre' => $this->request->getPost('nombre'),
                    'codigo_barras' => "",
                    'precio_con_igv' => $this->request->getPost('precio_venta_con_igv'),
                    'precio_sin_igv' => $this->request->getPost('precio_venta_sin_igv'),
                    'precio_compra' => $this->request->getPost('precio_compra'),
                    'unidad_medida_id' => $this->request->getPost('unidad_medida'),
                    'factor_conversion' => 1,
                    'estado' => 1
                ]);

                $almacenId = $this->request->getPost('almacen');
                $stockInicial = $this->request->getPost('stock_inicial');
                $stockMinimo = $this->request->getPost('stock_minimo');
                $userId = session()->get('id');

                $inventario->insert([
                    'producto_id' => $newProductId,
                    'almacen_id' => $almacenId,
                    'stock_actual' => $stockInicial,
                    'stock_minimo' => $stockMinimo,
                    'stock_maximo' => 0, // O un valor por defecto adecuado
                    'tipo_envio_sunat' => "prueba",
                    'usuario_id' => $userId
                ]);

                $inventario->insert([
                    'producto_id' => $newProductId,
                    'almacen_id' => $almacenId,
                    'stock_actual' => $stockInicial,
                    'stock_minimo' => $stockMinimo,
                    'stock_maximo' => 0,
                    'tipo_envio_sunat' => "produccion",
                    'usuario_id' => $userId
                ]);

                $movimiento_inventario->insert([
                    'producto_id' => $newProductId,
                    'almacen_id' => $almacenId,
                    'tipo' => "Inventario Inicial",
                    'cantidad' => $stockInicial,
                    'motivo' => "Agregar stock Inicial",
                    'referencia_id' => "",
                    'referencia_tipo' => "Inicial",
                    'num_documento' => "",
                    'tipo_envio_sunat' => "produccion",
                    'stock_anterior' => 0,
                    'stock_actual' => $stockInicial,
                    'usuario_id' => $userId
                ]);

                $movimiento_inventario->insert([
                    'producto_id' => $newProductId,
                    'almacen_id' => $almacenId,
                    'tipo' => "Inventario Inicial",
                    'cantidad' => $stockInicial,
                    'motivo' => "Agregar stock Inicial",
                    'referencia_id' => "",
                    'referencia_tipo' => "Inicial",
                    'num_documento' => "",
                    'tipo_envio_sunat' => "prueba",
                    'stock_anterior' => 0,
                    'stock_actual' => $stockInicial,
                    'usuario_id' => $userId
                ]);

                $productoModel->db->transComplete();

                if ($productoModel->db->transStatus() === false) {
                    throw new \Exception("La transacción de base de datos falló.");
                }

                return $this->response->setJSON(['status' => 'success', 'message' => 'Producto guardado correctamente']);
            } else {
                if (!$productoModel->update($id, $data)) {
                    throw new \Exception("Error al actualizar el producto.");
                }

                $productoModel->db->transComplete();

                if ($productoModel->db->transStatus() === false) {
                    throw new \Exception("La transacción de actualización falló.");
                }

                return $this->response->setJSON(['status' => 'success', 'message' => 'Producto actualizado correctamente']);
            }
        } catch (\Exception $e) {

            $productoModel->db->transRollback();

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

    public function ajustarStock()
    {
        $db = \Config\Database::connect();
        $json = $this->request->getJSON(true);

        $tipo       = strtoupper($json['tipo'] ?? '');         // INGRESO | SALIDA
        $almacen_id = intval($json['almacen_id'] ?? 0);
        $motivo     = $json['motivo'] ?? ($tipo === 'INGRESO' ? 'Ingreso de stock' : 'Salida de stock');
        $items      = $json['items'] ?? [];
        $tipoEnvio  = session()->get('tipo_envio_sunat') ?? 'prueba';
        $usuario_id = session()->get('id');

        if (!in_array($tipo, ['INGRESO', 'SALIDA'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Tipo de movimiento inválido.']);
        }

        if (!$almacen_id || empty($items)) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Datos incompletos.']);
        }

        $inventarioModel  = new InventarioModel();
        $movInvModel      = new MovimientoInventarioModel();

        $db->transStart();
        try {
            foreach ($items as $item) {
                $producto_id = intval($item['producto_id'] ?? 0);
                $cantidad    = floatval($item['cantidad'] ?? 0);
                $motivoItem  = $item['motivo'] ?? $motivo;

                if (!$producto_id || $cantidad <= 0) continue;

                // Obtener inventario actual
                $inv = $inventarioModel->where([
                    'producto_id'      => $producto_id,
                    'almacen_id'       => $almacen_id,
                    'tipo_envio_sunat' => $tipoEnvio
                ])->first();

                $stockAnterior = $inv ? floatval($inv['stock_actual']) : 0;

                // Calcular nuevo stock
                $nuevoStock = ($tipo === 'INGRESO')
                    ? $stockAnterior + $cantidad
                    : $stockAnterior - $cantidad;

                if ($tipo === 'SALIDA' && $nuevoStock < 0) {
                    $db->transRollback();
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => "Stock insuficiente para el producto ID $producto_id. Stock actual: $stockAnterior"
                    ]);
                }

                // Actualizar o crear inventario
                if ($inv) {
                    $inventarioModel->update($inv['id'], ['stock_actual' => $nuevoStock]);
                } else {
                    $inventarioModel->insert([
                        'producto_id'      => $producto_id,
                        'almacen_id'       => $almacen_id,
                        'stock_actual'     => $nuevoStock,
                        'stock_minimo'     => 0,
                        'stock_maximo'     => 0,
                        'tipo_envio_sunat' => $tipoEnvio,
                        'usuario_id'       => $usuario_id
                    ]);
                }

                // Registrar movimiento
                $movInvModel->insert([
                    'producto_id'      => $producto_id,
                    'almacen_id'       => $almacen_id,
                    'tipo'             => $tipo,
                    'cantidad'         => $cantidad,
                    'motivo'           => $motivoItem,
                    'referencia_id'    => '',
                    'referencia_tipo'  => 'MANUAL',
                    'num_documento'    => '',
                    'tipo_envio_sunat' => $tipoEnvio,
                    'stock_anterior'   => $stockAnterior,
                    'stock_actual'     => $nuevoStock,
                    'usuario_id'       => $usuario_id
                ]);
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Error en la transacción de base de datos.');
            }

            $accion = $tipo === 'INGRESO' ? 'ingresados' : 'dados de salida';
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => count($items) . ' producto(s) ' . $accion . ' correctamente.'
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Error al procesar: ' . $e->getMessage()
            ]);
        }
    }
}
