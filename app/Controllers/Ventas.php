<?php

namespace App\Controllers;

class Ventas extends BaseController
{
    public function index()
    {
        $data = [];
        if (session()->get('rol_id') == 1) {
            $sucursalModel = new \App\Models\SucursalesModel();
            $data['sucursales'] = $sucursalModel->where('estado', 1)->findAll();
        }
        return view('ventas/index', $data);
    }

    public function detalle($id)
    {
        $ventasModel = new \App\Models\VentasModel();
        $detalleModel = new \App\Models\DetalleVentaModel();
        $movCajaModel = new \App\Models\MovimientoCajaModel();

        // Usamos joins a la izquierda para que no falle si falta algún dato relacionado
        $venta = $ventasModel->select('ventas.*, sunat_tipodocelectronico.descripcion as tipo_comprobante, clientes.nombres as cliente_nombre, clientes.numero_documento as cliente_doc, clientes.direccion as cliente_direccion')
            ->join('sunat_tipodocelectronico', 'sunat_tipodocelectronico.id_tipodoc_electronico = ventas.tipo_comprobante_id', 'left')
            ->join('clientes', 'clientes.id = ventas.cliente_id', 'left')
            ->find($id);

        if (!$venta) {
            return '<div class="p-8 text-center"><span class="material-symbols-outlined text-rose-500 text-5xl mb-3">error</span><p class="font-bold text-slate-500">Error: Venta no encontrada.</p></div>';
        }

        $data['venta'] = $venta;
        $data['detalle'] = $detalleModel->where('venta_id', $id)->findAll();

        // Obtener pagos relacionados
        $data['pagos'] = $movCajaModel->select('movimiento_caja.*, metodos_pago.nombre as metodo')
            ->join('metodos_pago', 'metodos_pago.id = movimiento_caja.metodo_pago_id', 'left')
            ->where('referencia_mov_id', $id)
            ->where('referencia_tipo_mov', 'VENTA')
            ->findAll();

        return view('ventas/detalle_modal', $data);
    }

    public function listar()
    {
        $db = \Config\Database::connect();
        $session_sucursal = session()->get('sucursal_id');
        $session_rol = session()->get('rol_id');
        $session_usuario = session()->get('id');
        $session_envio = session()->get('tipo_envio_sunat') ?? 'prueba';

        $request = $this->request->getGet();
        // Determinar la sucursal a filtrar (solo para admins)
        $filtro_sucursal = $request['sucursal_id'] ?? '';

        // Si no es admin, forzar su propia sucursal
        if ($session_rol != 1) {
            $sucursal_id_final = $session_sucursal;
        } else {
            $sucursal_id_final = !empty($filtro_sucursal) ? $filtro_sucursal : '';
        }

        $draw = intval($request['draw'] ?? 1);
        $start = intval($request['start'] ?? 0);
        $length = intval($request['length'] ?? 10);
        $searchValue = $request['search']['value'] ?? '';
        $orderColumnIndex = intval($request['order'][0]['column'] ?? 0);
        $orderDir = $request['order'][0]['dir'] ?? 'desc';

        $columns = [
            0 => 'fecha_venta',
            1 => 'serie_comprobante',
            2 => 'clientes.nombres',
            3 => 'total',
            4 => null, // Métodos de pago (calculado)
            5 => 'estado_envio_sunat'
        ];
        $orderColumn = $columns[$orderColumnIndex] ?? 'fecha_venta';

        // 1. Preparar Query Base con Joins
        $builder = $db->table('ventas')
            ->select('ventas.*, sunat_tipodocelectronico.descripcion as tipo_comprobante, clientes.nombres as cliente_nombre, clientes.numero_documento as cliente_doc')
            ->join('sunat_tipodocelectronico', 'sunat_tipodocelectronico.id_tipodoc_electronico = ventas.tipo_comprobante_id', 'left')
            ->join('clientes', 'clientes.id = ventas.cliente_id', 'left');

        // Filtrar por el ambiente de envío actual (prueba/produccion)
        $builder->where('ventas.tipo_envio_sunat', $session_envio);

        // Aplicar filtros de Sucursal y Usuario según ROLES
        if ($session_rol == 2) {
            // Cajero: solo sus ventas y su sucursal
            $builder->where('ventas.sucursal_id', $session_sucursal);
            $builder->where('ventas.usuario_id', $session_usuario);
        } else {
            // Admin: opcionalmente por sucursal
            if (!empty($sucursal_id_final)) {
                $builder->where('ventas.sucursal_id', $sucursal_id_final);
            }
        }

        // 2. Aplicar Filtros Globales (Búsqueda)
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('clientes.nombres', $searchValue)
                ->orLike('clientes.numero_documento', $searchValue)
                ->orLike('ventas.serie_comprobante', $searchValue)
                ->orLike('ventas.numero_comprobante', $searchValue)
                ->groupEnd();
        }

        // 3. Aplicar Filtros de Fecha y Estado
        $desde = $request['desde'] ?? '';
        $hasta = $request['hasta'] ?? '';
        $estado = $request['estado'] ?? '';

        if (!empty($desde)) $builder->where('DATE(ventas.fecha_venta) >=', $desde);
        if (!empty($hasta)) $builder->where('DATE(ventas.fecha_venta) <=', $hasta);
        if (!empty($estado)) $builder->where('ventas.estado_envio_sunat', $estado);

        // --- CÁLCULO DE ESTADÍSTICAS ---
        $statsBuilder = clone $builder;
        $totalVentas = $statsBuilder->selectSum('total')->get()->getRowArray()['total'] ?? 0;

        $statsBuilder = clone $builder;
        $comprobantesCount = $statsBuilder->whereIn('sunat_tipodocelectronico.descripcion', ['BOLETA', 'FACTURA'])->countAllResults();

        $statsBuilder = clone $builder;
        $notasVentaCount = $statsBuilder->where('sunat_tipodocelectronico.descripcion', 'NOTA DE VENTA')->countAllResults();

        $statsBuilder = clone $builder;
        $pendientesCount = $statsBuilder->whereIn('sunat_tipodocelectronico.descripcion', ['BOLETA', 'FACTURA'])
            ->where('ventas.estado_envio_sunat !=', 'Aceptado')
            ->countAllResults();

        // --- DATA PARA LA TABLA ---
        $countResult = clone $builder;
        $totalFiltered = $countResult->countAllResults();

        $builder->orderBy($orderColumn, $orderDir);
        if ($length > 0) {
            $builder->limit($length, $start);
        }
        $records = $builder->get()->getResultArray();

        // --- FETCH PAYMENT METHODS ---
        $venta_ids = array_column($records, 'id');
        $pagos_venta = [];
        if (!empty($venta_ids)) {
            $all_pagos = $db->table('pagos_venta')
                ->select('pagos_venta.venta_id, pagos_venta.monto, metodos_pago.nombre as metodo')
                ->join('metodos_pago', 'metodos_pago.id = pagos_venta.metodo_pago_id', 'left')
                ->whereIn('venta_id', $venta_ids)
                ->get()->getResultArray();

            // Fallback for existing records in movimiento_caja
            $found_ids = array_unique(array_column($all_pagos, 'venta_id'));
            $missing_ids = array_diff($venta_ids, $found_ids);

            if (!empty($missing_ids)) {
                $fallback = $db->table('movimiento_caja')
                    ->select('referencia_mov_id as venta_id, monto, metodos_pago.nombre as metodo')
                    ->join('metodos_pago', 'metodos_pago.id = movimiento_caja.metodo_pago_id', 'left')
                    ->whereIn('referencia_mov_id', $missing_ids)
                    ->where('referencia_tipo_mov', 'VENTA')
                    ->get()->getResultArray();
                $all_pagos = array_merge($all_pagos, $fallback);
            }

            foreach ($all_pagos as $p) {
                $pagos_venta[$p['venta_id']][] = [
                    'metodo' => $p['metodo'] ?? 'S/N',
                    'monto' => number_format($p['monto'], 2)
                ];
            }
        }

        $data = [];
        foreach ($records as $row) {
            $data[] = [
                'id' => $row['id'],
                'fecha_venta' => $row['fecha_venta'],
                'tipo_comprobante' => $row['tipo_comprobante'] ?? 'S/N',
                'serie' => $row['serie_comprobante'],
                'numero' => str_pad($row['numero_comprobante'], 8, '0', STR_PAD_LEFT),
                'cliente_nombre' => $row['cliente_nombre'] ?? 'PÚBLICO GENERAL',
                'cliente_doc' => $row['cliente_doc'] ?? '-',
                'total' => number_format($row['total'], 2),
                'estado_envio_sunat' => $row['estado_envio_sunat'],
                'metodos_pago' => $pagos_venta[$row['id']] ?? []
            ];
        }

        return $this->response->setJSON([
            'draw' => $draw,
            'recordsTotal' => intval($totalFiltered),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $data,
            'stats' => [
                'totalVentas' => number_format($totalVentas, 2),
                'totalComprobantes' => str_pad($comprobantesCount, 2, '0', STR_PAD_LEFT),
                'totalNotasVenta' => str_pad($notasVentaCount, 2, '0', STR_PAD_LEFT),
                'pendientesSunat' => str_pad($pendientesCount, 2, '0', STR_PAD_LEFT)
            ]
        ]);
    }

    public function posVenta()
    {
        $comprobanteModel = new \App\Models\ComprobanteModel();
        $todos = $comprobanteModel->findAll();

        // Filtrar solo Boleta, Factura y Nota de Venta
        $data['tiposComprobante'] = array_filter($todos, function ($item) {
            $desc = strtoupper($item['descripcion']);
            return strpos($desc, 'BOLETA') !== false ||
                strpos($desc, 'FACTURA') !== false ||
                strpos($desc, 'NOTA DE VENTA') !== false;
        });
        $data['tiposComprobante'] = array_values($data['tiposComprobante']);

        $caja = getCajaAbierta();
        $data['cajaAbierta'] = $caja;
        $data['cajaVencida'] = false;

        if ($caja && !empty($caja['hora_cierre'])) {
            $fechaAperturaStr = $caja['fecha_apertura'];
            $openingTime = strtotime($fechaAperturaStr);
            $closingHour = $caja['hora_cierre']; // 03:00:00

            // Primer cierre programado el mismo día de la apertura
            $targetClosingTime = strtotime(date('Y-m-d', $openingTime) . ' ' . $closingHour);

            // Si se abrió después de esa hora, el cierre es al día siguiente
            if ($targetClosingTime <= $openingTime) {
                $targetClosingTime = strtotime('+1 day', $targetClosingTime);
            }

            if (time() > $targetClosingTime) {
                $data['cajaVencida'] = true;
            }
        }

        return view('ventas/pos', $data);
    }

    public function guardar()
    {
        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $json = $this->request->getJSON(true);
            $sucursal_id = session()->get('sucursal_id');
            $usuario_id = session()->get('id');

            // 0. Verificar Caja Abierta y Vigente
            $apertura = getCajaAbierta();
            if (!$apertura) {
                throw new \Exception("No hay una caja abierta para este usuario. Debe abrir caja antes de vender.");
            }

            if (!empty($apertura['hora_cierre'])) {
                $openingTime = strtotime($apertura['fecha_apertura']);
                $targetClosingTime = strtotime(date('Y-m-d', $openingTime) . ' ' . $apertura['hora_cierre']);
                if ($targetClosingTime <= $openingTime) {
                    $targetClosingTime = strtotime('+1 day', $targetClosingTime);
                }

                if (time() > $targetClosingTime) {
                    throw new \Exception("La caja actual (" . $apertura['nombre_caja'] . ") ya superó su horario de cierre programado (" . date('H:i', $targetClosingTime) . "). Debe cerrarla para continuar.");
                }
            }

            $cart = $json['cart'] ?? [];
            $paymentMethods = $json['paymentMethods'] ?? [];
            $cliente_id = $json['cliente_id'] ?? 1;
            $docType_id = $json['docType_id'] ?? null;
            $almacen_id = $json['almacen_id'] ?? 0;
            $tipoEnvio = session()->get('tipo_envio_sunat') ?? 'prueba';

            if (!$docType_id) {
                throw new \Exception("Tipo de comprobante no seleccionado.");
            }

            // 1. Obtener Serie y Número
            $configModel = new \App\Models\ConfiguracionComprobantesModel();
            $config = $configModel->where([
                'comprobante_id'   => $docType_id,
                'sucursal_id'      => $sucursal_id,
                'tipo_envio_sunat' => $tipoEnvio,
                'estado'           => 1
            ])->first();

            if (!$config) {
                throw new \Exception("No hay configuración de serie/número para este comprobante.");
            }

            $serie = $config['serie'];
            $numero = $config['numero'];
            $numero_siguiente = $config['numero'] + 1;

            // 2. Calcular Totales
            $total = 0;
            foreach ($cart as $item) {
                $total += $item['price'] * $item['quantity'];
            }

            $porcentaje_igv = 18; // TODO: Cargar de config si existe
            $factor = 1 + ($porcentaje_igv / 100);
            //$total_gravadas = round($total / $factor, 2);
            //$total_igv = round($total - $total_gravadas, 2);
            $total_exoneradas = $total;
            $total_gravadas = 0.00;
            $total_igv = 0.00;

            // 3. Guardar Venta
            $ventasModel = new \App\Models\VentasModel();
            $ventaData = [
                'fecha_venta' => date('Y-m-d H:i:s'),
                'tipo_comprobante_id' => $docType_id,
                'serie_comprobante' => $serie,
                'numero_comprobante' => $numero,
                'tipo_envio_sunat' => $tipoEnvio,
                'id_tipo_operacion' => '0101',
                'total_gravadas' => $total_gravadas,
                'total_exoneradas' => $total_exoneradas,
                'total_igv' => $total_igv,
                'total' => $total,
                'cliente_id' => $cliente_id,
                'usuario_id' => $usuario_id,
                'sucursal_id' => $sucursal_id,
                'estado' => 1,
                'porcentaje_igv' => $porcentaje_igv,
                'sub_total' => $total,
                'total_letras' => $this->convertirANumerosALetras($total),
                'codigo_moneda' => 'PEN',
                'tipo_cambio_sunat' => 1,
                'fecha_vencimiento' => date('Y-m-d'),
                'tipo_pago' => 'CONTADO',
                'estado_envio_sunat' => 'Pendiente',
                'estado' => 1
            ];

            $venta_id = $ventasModel->insert($ventaData);

            // 4. Actualizar Configuración de Comprobante
            $configModel->update($config['id'], ['numero' => $numero_siguiente]);

            // 5. Detalle de Venta e Inventario
            $detalleModel = new \App\Models\DetalleVentaModel();
            $inventarioModel = new \App\Models\InventarioModel();
            $movInvModel = new \App\Models\MovimientoInventarioModel();
            $productoModel = new \App\Models\ProductoModel();
            $presentacionModel = new \App\Models\PresentacionProductoModel();

            foreach ($cart as $item) {
                $pId = $item['id'];
                $qty = $item['quantity'];
                $price = $item['price'];
                $itemTotal = $price * $qty;

                $precio_sin_igv = round($price / $factor, 2);
                $subtotal_item = round($itemTotal / $factor, 2);
                $igv_item = round($itemTotal - $subtotal_item, 2);

                // Obtener datos del producto y su presentación principal
                $prodData = $productoModel->find($pId);
                $presData = $presentacionModel->where(['producto_id' => $pId, 'factor_conversion' => 1])->first();

                $detalleModel->insert([
                    'venta_id' => $venta_id,
                    'presentacion_id' => $presData['id'] ?? null,
                    'cantidad' => $qty,
                    'precio' => $price,
                    'precio_sin_igv' => $precio_sin_igv,
                    'subtotal' => $subtotal_item,
                    'igv' => $igv_item,
                    'importe' => $itemTotal,
                    'unidad_medida_id' => $prodData['unidad_medida_id'] ?? 1,
                    'descripcion' => $prodData['nombre_producto'],
                    'id_tipoafectacionigv' => $prodData['tipo_afectacion_igv'],
                    'codigo_producto' => $prodData['codigo'],
                    'estado' => 1
                ]);

                // Actualizar Inventario
                $inv = $inventarioModel->where([
                    'producto_id' => $pId,
                    'almacen_id' => $almacen_id,
                    'tipo_envio_sunat' => $tipoEnvio
                ])->first();

                $stockAnterior = $inv ? $inv['stock_actual'] : 0;
                $newStock = $stockAnterior - $qty;

                if ($inv) {
                    $inventarioModel->update($inv['id'], ['stock_actual' => $newStock]);
                }

                // Movimiento Inventario
                $movInvModel->insert([
                    'producto_id' => $pId,
                    'almacen_id' => $almacen_id,
                    'tipo' => 'SALIDA',
                    'cantidad' => $qty,
                    'motivo' => 'VENTA POS',
                    'referencia_id' => $venta_id,
                    'referencia_tipo' => 'VENTA',
                    'num_documento' => $serie . '-' . $numero,
                    'tipo_envio_sunat' => $tipoEnvio,
                    'stock_anterior' => $stockAnterior,
                    'stock_actual' => $newStock,
                    'usuario_id' => $usuario_id
                ]);
            }

            // 6. Movimiento de Caja y Pagos Venta
            if (isset($apertura) && $apertura) {
                $movCajaModel = new \App\Models\MovimientoCajaModel();
                $pagosVentaModel = new \App\Models\PagosVentaModel();

                foreach ($paymentMethods as $pm) {
                    $movCajaModel->insert([
                        'apertura_caja_id' => $apertura['id'],
                        'tipo_movimiento' => 'INGRESO',
                        'monto' => $pm['amount'],
                        'metodo_pago_id' => $pm['id'],
                        'referencia_mov_id' => $venta_id,
                        'referencia_tipo_mov' => 'VENTA',
                        'concepto_id' => 1,
                        'estado' => 1
                    ]);

                    $pagosVentaModel->insert([
                        'venta_id' => $venta_id,
                        'monto' => $pm['amount'],
                        'metodo_pago_id' => $pm['id'],
                        'referencia' => 'VENTA POS',
                        'estado' => 1
                    ]);
                }
            }

            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception("Error en la transacción de base de datos.");
            }

            return $this->response->setJSON([
                'status' => 'success',
                'message' => 'Venta guardada correctamente',
                'venta_id' => $venta_id
            ]);
        } catch (\Exception $e) {
            $db->transRollback();
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Error al guardar la venta: ' . $e->getMessage()
            ], 500);
        }
    }


    public function ticket($id = 0)
    {
        // ── Modelos ───────────────────────────────────────────────────────
        $ventasModel     = new \App\Models\VentasModel();
        $sucursalesModel = new \App\Models\SucursalesModel();
        $empresasModel   = new \App\Models\EmpresasModel();
        $clientesModel   = new \App\Models\ClientesModel();
        $detalleModel    = new \App\Models\DetalleVentaModel();
        $comprobanteMod  = new \App\Models\ComprobanteModel();
        $usuariosModel   = new \App\Models\UsuariosModel();
        $movCajaModel    = new \App\Models\MovimientoCajaModel();
        $metodosPagoMod  = new \App\Models\MetodosPagoModel();

        // ── Buscar Venta ──────────────────────────────────────────────────
        $venta = $ventasModel->find($id);
        if (!$venta) {
            die('Error: Venta no encontrada.');
        }

        // ── Cargar Relaciones ─────────────────────────────────────────────
        $sucursal    = $sucursalesModel->find($venta['sucursal_id']);
        $empresa     = $empresasModel->find($sucursal['empresa_id'] ?? 0);
        $cliente     = $clientesModel->find($venta['cliente_id']);
        $items_db    = $detalleModel->where('venta_id', $id)->findAll();
        $comprobante = $comprobanteMod->find($venta['tipo_comprobante_id']);
        $cajeroData  = $usuariosModel->find($venta['usuario_id']);

        // ── Preparar Datos ────────────────────────────────────────────────
        $nombreEmpresa = strtoupper((string)($empresa['razon_social'] ?? 'BRAVO FACT'));
        $rucEmpresa    = 'RUC: ' . (string)($empresa['ruc'] ?? '20600000000');
        $dirEmpresa    = (string)($sucursal['direccion'] ?? 'AV. PRINCIPAL 123');
        $telEmpresa    = 'Tel: ' . (string)($sucursal['telefono'] ?? '999-999-999');
        $webEmpresa    = (string)($empresa['email'] ?? 'ventas@bravofact.pe');
        $nombreComercial = strtoupper((string)($empresa['nombre_comercial'] ?? $nombreEmpresa));

        $tipoDocDesc   = strtoupper((string)($comprobante['descripcion'] ?? 'COMPROBANTE ELECTRÓNICO'));
        $serie         = $venta['serie_comprobante'];
        $corr          = str_pad($venta['numero_comprobante'], 8, '0', STR_PAD_LEFT);
        $fecha         = date('d/m/Y H:i', strtotime($venta['fecha_venta']));
        $nombreCliente = strtoupper((string)($cliente['nombres'] ?? 'CLIENTE GENERICO'));
        $docCliente    = (string)($cliente['numero_documento'] ?? '00000000');
        $nombreCajero  = strtoupper((string)($cajeroData['nombres'] ?? 'ADMIN'));

        $totalVenta    = $venta['total'];
        $opGravadas    = $venta['total_gravadas'];
        $opExoneradas  = $venta['total_exoneradas'];
        $igv           = $venta['total_igv'];
        $totalLetras   = $venta['total_letras'];

        // ── Metodos de Pago ───────────────────────────────────────────────
        $pagos = $movCajaModel->select('movimiento_caja.*, metodos_pago.nombre as metodo')
            ->join('metodos_pago', 'metodos_pago.id = movimiento_caja.metodo_pago_id')
            ->where('referencia_mov_id', $id)
            ->where('referencia_tipo_mov', 'VENTA')
            ->findAll();

        $items = [];
        foreach ($items_db as $it) {
            $items[] = [
                'desc'  => $it['descripcion'],
                'qty'   => $it['cantidad'],
                'price' => $it['precio']
            ];
        }

        // ── Cargar FPDF ───────────────────────────────────────────────────
        require_once ROOTPATH . 'vendor/setasign/fpdf/fpdf.php';

        // ── Dimensiones ───────────────────────────────────────────────────
        $pageW  = 58;
        $margin = 2;
        $w      = $pageW - ($margin * 2);

        // ── Crear PDF ─────────────────────────────────────────────────────
        $pdf = new \FPDF('P', 'mm', [$pageW, 230]);
        $pdf->AddPage();
        $pdf->SetMargins($margin, $margin, $margin);
        $pdf->SetAutoPageBreak(true, $margin);
        $pdf->SetDrawColor(0, 0, 0);
        $pdf->SetTextColor(0, 0, 0);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 1: CABECERA
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $pdf->SetY($margin);

        // Nombre comercial en grande y negrita
        $pdf->SetFont('Helvetica', 'B', 14);
        $pdf->MultiCell($w, 7, $this->toLatin1($nombreComercial), 0, 'C');

        // Razon social debajo
        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->MultiCell($w, 4, $this->toLatin1($nombreEmpresa), 0, 'C');

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->Cell($w, 4, $this->toLatin1($rucEmpresa), 0, 1, 'C');
        $pdf->Cell($w, 4, $this->toLatin1($dirEmpresa), 0, 1, 'C');
        $pdf->Cell($w, 4, $this->toLatin1($telEmpresa . '  |  ' . $webEmpresa), 0, 1, 'C');

        // Separador doble
        $pdf->Ln(2);
        $this->lineaDoble($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 2: TIPO DE COMPROBANTE
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->Cell($w, 6, $this->toLatin1($tipoDocDesc), 0, 1, 'C');

        $pdf->SetFont('Helvetica', 'B', 8);
        $pdf->Cell($w, 5, $this->toLatin1("SERIE: {$serie}   N°: {$corr}"), 0, 1, 'C');

        $pdf->Ln(1);
        $this->lineaSimple($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 3: DATOS DEL COMPROBANTE
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $pdf->SetX($margin);
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->Cell($w * 0.42, 5, 'Fecha emision:', 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->Cell($w * 0.58, 5, $fecha, 0, 1, 'R');

        $pdf->SetX($margin);
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->Cell($w * 0.42, 5, 'Cliente:', 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->Cell($w * 0.58, 5, $this->toLatin1($nombreCliente . ' (' . $docCliente . ')'), 0, 1, 'R');

        $pdf->SetX($margin);
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->Cell($w * 0.42, 5, 'Cajero:', 0, 0, 'L');
        $pdf->SetFont('Helvetica', '', 7.5);
        $pdf->Cell($w * 0.58, 5, $this->toLatin1($nombreCajero), 0, 1, 'R');

        $pdf->Ln(1);
        $this->lineaSimple($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 4: DETALLE DE ITEMS
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $cDesc = $w * 0.46;
        $cQty  = $w * 0.12;
        $cPU   = $w * 0.20;
        $cTot  = $w * 0.22;

        // Encabezado tabla en negrita + subrayado
        $pdf->SetFont('Helvetica', 'B', 7.5);
        $pdf->SetX($margin);
        $pdf->Cell($cDesc, 5, 'DESCRIPCION',          'B', 0, 'L');
        $pdf->Cell($cQty,  5, 'CANT',                 'B', 0, 'C');
        $pdf->Cell($cPU,   5, 'P.U.',                 'B', 0, 'R');
        $pdf->Cell($cTot,  5, 'TOTAL',                'B', 1, 'R');

        // Filas de items
        $pdf->SetFont('Helvetica', '', 7.5);
        foreach ($items as $item) {
            $total = $item['qty'] * $item['price'];
            $pdf->SetX($margin);
            // Nombre del producto con MultiCell por si es largo
            $pdf->Cell($cDesc, 5.5, $this->toLatin1($item['desc']),                           0, 0, 'L');
            $pdf->Cell($cQty,  5.5, (string)(int)$item['qty'],                    0, 0, 'C');
            $pdf->Cell($cPU,   5.5, 'S/' . number_format($item['price'], 2), 0, 0, 'R');
            $pdf->Cell($cTot,  5.5, 'S/' . number_format($total, 2),        0, 1, 'R');
        }

        $pdf->Ln(1);
        $this->lineaSimple($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 5: TOTALES
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        $pdf->SetFont('Helvetica', '', 7.5);

        if ($opGravadas > 0) {
            $pdf->SetX($margin);
            $pdf->Cell($w * 0.6, 5, 'Op. Gravadas:', 0, 0, 'L');
            $pdf->Cell($w * 0.4, 5, 'S/ ' . number_format($opGravadas, 2), 0, 1, 'R');
        }

        if ($opExoneradas > 0) {
            $pdf->SetX($margin);
            $pdf->Cell($w * 0.6, 5, 'Op. Exoneradas:', 0, 0, 'L');
            $pdf->Cell($w * 0.4, 5, 'S/ ' . number_format($opExoneradas, 2), 0, 1, 'R');
        }

        $pdf->SetX($margin);
        $pdf->Cell($w * 0.6, 5, 'IGV (18%):', 0, 0, 'L');
        $pdf->Cell($w * 0.4, 5, 'S/ ' . number_format($igv, 2), 0, 1, 'R');

        $pdf->Ln(1);
        $this->lineaDoble($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        // Total en grande y negrita
        $pdf->SetFont('Helvetica', 'B', 12);
        $pdf->SetX($margin);
        $pdf->Cell($w * 0.52, 8, 'TOTAL:', 0, 0, 'L');
        $pdf->Cell($w * 0.48, 8, 'S/ ' . number_format($totalVenta, 2), 0, 1, 'R');

        $this->lineaDoble($pdf, $margin, $pdf->GetY(), $pageW - $margin);
        $pdf->Ln(2);

        $pdf->SetFont('Helvetica', '', 7);
        $pdf->SetX($margin);
        $pdf->MultiCell($w, 4, $this->toLatin1($totalLetras), 0, 'L');
        $pdf->Ln(1);

        // ── Métodos de Pago ───────────────────────────────────────────────
        $pdf->SetFont('Helvetica', 'B', 7);
        $pdf->SetX($margin);
        $pdf->Cell($w, 4, 'FORMA DE PAGO:', 0, 1, 'L');
        $pdf->SetFont('Helvetica', '', 7);
        foreach ($pagos as $p) {
            $pdf->SetX($margin);
            $pdf->Cell($w * 0.6, 4, $this->toLatin1($p['metodo']) . ':', 0, 0, 'L');
            $pdf->Cell($w * 0.4, 4, 'S/ ' . number_format($p['monto'], 2), 0, 1, 'R');
        }
        $pdf->Ln(1);

        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // BLOQUE 6: PIE DE PÁGINA
        // ━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━━
        // Línea de corte punteada
        $this->lineaPunteada($pdf, $margin, $pdf->GetY(), $pageW - $margin, $pdf->GetY());
        $pdf->Ln(3);

        $pdf->SetFont('Helvetica', '', 6.5);
        $pdf->SetX($margin);
        $pdf->MultiCell($w, 3.5, $this->toLatin1('Representacion impresa de la ' . $tipoDocDesc . '. Consulte en: ' . $webEmpresa), 0, 'C');

        $pdf->Ln(2);
        $pdf->SetFont('Helvetica', 'B', 9);
        $pdf->SetX($margin);
        $pdf->Cell($w, 6, '*** GRACIAS POR SU COMPRA ***', 0, 1, 'C');

        // ── Enviar al navegador (inline) ──────────────────────────────────
        $pdf->Output('I', "ticket-{$id}.pdf");
        exit;
    }

    // ── Línea simple ──────────────────────────────────────────────────────
    private function lineaSimple($pdf, float $x1, float $y, float $x2): void
    {
        $pdf->SetLineWidth(0.3);
        $pdf->Line($x1, $y, $x2, $y);
    }

    // ── Línea doble (efecto de separación fuerte) ─────────────────────────
    private function lineaDoble($pdf, float $x1, float $y, float $x2): void
    {
        $pdf->SetLineWidth(0.5);
        $pdf->Line($x1, $y, $x2, $y);
        $pdf->SetLineWidth(0.2);
        $pdf->Line($x1, $y + 0.8, $x2, $y + 0.8);
        $pdf->SetLineWidth(0.3); // reset
    }

    // ── Línea punteada de corte ───────────────────────────────────────────
    private function lineaPunteada($pdf, float $x1, float $y, float $x2, float $y2, float $segLen = 2): void
    {
        $pdf->SetLineWidth(0.2);
        $x = $x1;
        while ($x < $x2) {
            $end = min($x + $segLen, $x2);
            $pdf->Line($x, $y, $end, $y);
            $x += $segLen * 2;
        }
    }

    public function convertirANumerosALetras($number)
    {
        if (extension_loaded('intl')) {
            $formatter = new \NumberFormatter("es", \NumberFormatter::SPELLOUT);
            $parts = explode('.', number_format($number, 2, '.', ''));
            $entero = (int)$parts[0];
            $decimal = $parts[1];
            $enteroTexto = strtoupper($formatter->format($entero));
            return "SON: " . $enteroTexto . " Y " . $decimal . "/100 SOLES";
        }

        // Fallback or manual implementation if intl is not available
        $unidades = ['', 'un', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve'];
        $dieces = ['diez', 'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve'];
        $decenas = ['', 'diez', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
        $centenas = ['', 'ciento', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];

        $asLetters = function ($n) use ($unidades, $dieces, $decenas, $centenas, &$asLetters) {
            if ($n == 0) return 'cero';
            if ($n == 100) return 'cien';
            if ($n < 10) return $unidades[$n];
            if ($n < 20) return $dieces[$n - 10];
            if ($n < 30) return ($n == 20 ? 'veinte' : 'veinti' . $unidades[$n - 20]);
            if ($n < 100) return $decenas[floor($n / 10)] . ($n % 10 == 0 ? '' : ' y ' . $asLetters($n % 10));
            if ($n < 1000) return $centenas[floor($n / 100)] . ($n % 100 == 0 ? '' : ' ' . $asLetters($n % 100));
            if ($n < 2000) return 'mil ' . ($n % 1000 == 0 ? '' : $asLetters($n % 1000));
            if ($n < 1000000) return $asLetters(floor($n / 1000)) . ' mil' . ($n % 1000 == 0 ? '' : ' ' . $asLetters($n % 1000));
            return 'número demasiado grande';
        };

        $parts = explode('.', number_format($number, 2, '.', ''));
        $entero = (int)$parts[0];
        $decimal = $parts[1];

        return "SON: " . strtoupper($asLetters($entero)) . " Y " . $decimal . "/100 SOLES";
    }

    private function toLatin1($str)
    {
        return iconv('UTF-8', 'windows-1252//TRANSLIT', (string)$str);
    }
}
