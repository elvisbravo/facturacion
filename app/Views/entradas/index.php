<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>

<div class="h-full flex items-center justify-center p-4 lg:p-8">
    <div class="w-full max-w-lg bg-white dark:bg-slate-900 rounded-3xl shadow-xl overflow-hidden border border-slate-200 dark:border-slate-800 animate-in fade-in zoom-in-95 duration-300">

        <!-- Header -->
        <div class="p-6 bg-primary text-slate-900 border-b border-primary/20 flex items-center gap-4">
            <div class="size-12 rounded-2xl bg-white/20 flex items-center justify-center">
                <span class="material-symbols-outlined text-3xl font-bold">confirmation_number</span>
            </div>
            <div>
                <h2 class="text-2xl font-black uppercase tracking-tight">Vender Entradas</h2>
                <p class="text-xs font-bold opacity-80 uppercase tracking-widest">Módulo de emisión rápida</p>
            </div>
        </div>

        <!-- Form Body -->
        <div class="p-8 space-y-6">

            <!-- Comprobante Selector -->
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Tipo de Comprobante</label>
                <div class="grid grid-cols-2 gap-2">
                    <?php foreach ($tiposComprobante as $tipo): ?>
                        <label class="doc-radio relative flex items-center justify-center p-3 border-2 border-slate-100 dark:border-slate-800 rounded-xl cursor-pointer transition-all hover:bg-slate-50 dark:hover:bg-slate-800">
                            <input type="radio" name="docType" value="<?= $tipo['id_tipodoc_electronico'] ?>" class="sr-only" <?= $tipo['id_tipodoc_electronico'] === '77' ? 'checked' : '' ?>>
                            <span class="text-xs font-black text-slate-600 dark:text-slate-400 uppercase"><?= $tipo['descripcion'] ?></span>
                        </label>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Cliente Section -->
            <div id="clienteSection" class="space-y-2 animate-in fade-in slide-in-from-top-2 duration-300">
                <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Identificación del Cliente</label>
                <div class="flex gap-2">
                    <div class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">badge</span>
                        <input type="text" id="clienteDoc" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-black focus:ring-4 focus:ring-primary/20 transition-all outline-none" placeholder="DNI / RUC" value="00000001">
                    </div>
                    <button type="button" onclick="buscarCliente()" class="bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 px-4 rounded-2xl hover:bg-primary hover:text-slate-900 transition-all">
                        <span class="material-symbols-outlined">search</span>
                    </button>
                </div>
                <div id="clienteCargado" class="flex items-center gap-2 px-4 py-2 bg-primary/5 rounded-xl border border-primary/20">
                    <span class="material-symbols-outlined text-primary text-sm">person</span>
                    <span id="clienteNombre" class="text-[11px] font-black text-primary uppercase">CLIENTE VARIOS</span>
                    <input type="hidden" id="clienteId" value="1">
                </div>
            </div>

            <!-- Entrada Selector -->
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Tipo de Entrada</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">event_seat</span>
                    <select id="entradaId" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold focus:ring-4 focus:ring-primary/20 transition-all outline-none">
                        <?php if (empty($entradas)): ?>
                            <option value="0" disabled selected>No se encontraron Entradas/Tickets...</option>
                        <?php else: ?>
                            <option value="0" disabled>Seleccionar Entrada...</option>
                            <?php foreach ($entradas as $index => $e): ?>
                                <option value="<?= $e['id'] ?>" data-price="<?= $e['precio_venta'] ?>" <?= $index === 0 ? 'selected' : '' ?>><?= $e['nombre_producto'] ?> (Stock: <?= $e['stock_actual'] ?>)</option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <!-- Precio Override -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Precio Unitario</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-slate-400">S/</span>
                        <input type="number" id="entradaPrecio" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-10 pr-4 py-4 text-lg font-black focus:ring-4 focus:ring-primary/20 transition-all outline-none" placeholder="0.00" step="0.01">
                    </div>
                </div>

                <!-- Cantidad -->
                <div class="space-y-2">
                    <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Cantidad</label>
                    <div class="relative">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-xl">add_shopping_cart</span>
                        <input type="number" id="entradaCantidad" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-12 pr-4 py-4 text-lg font-black focus:ring-4 focus:ring-primary/20 transition-all outline-none" value="1" min="1">
                    </div>
                </div>
            </div>

            <!-- Payment Method Selector -->
            <div class="space-y-2">
                <label class="text-xs font-black text-slate-500 uppercase tracking-widest">Método de Pago</label>
                <div class="relative">
                    <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400">payments</span>
                    <select id="metodoPagoId" class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-2xl pl-12 pr-4 py-4 text-sm font-bold focus:ring-4 focus:ring-primary/20 transition-all outline-none">
                        <?php foreach ($metodosPago as $metodo): ?>
                            <option value="<?= $metodo['id'] ?>" <?= $metodo['nombre'] === 'EFECTIVO' ? 'selected' : '' ?>><?= $metodo['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Total Preview -->
            <div class="bg-slate-50 dark:bg-slate-800/50 p-6 rounded-3xl border border-slate-100 dark:border-slate-800 text-center animate-in slide-in-from-bottom-2 duration-500">
                <p class="text-[10px] font-black text-slate-400 uppercase tracking-widest mb-1">Total a cobrar</p>
                <h3 id="totalCobrar" class="text-5xl font-black text-slate-900 dark:text-white">S/ 0.00</h3>
            </div>

            <!-- Action Button -->
            <button onclick="procesarVentaEntrada()" class="w-full bg-primary text-slate-900 font-black py-5 rounded-2xl text-xl shadow-xl shadow-primary/30 hover:shadow-primary/50 flex items-center justify-center gap-3 transition-all active:scale-[0.98] uppercase tracking-wide">
                <span class="material-symbols-outlined font-black">print</span>
                Emitir Entrada
            </button>

        </div>

        <!-- Footer -->
        <div class="px-6 py-4 bg-slate-50/50 dark:bg-slate-900/50 border-t border-slate-100 dark:border-slate-800 text-center">
            <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">
                Usuario activo: <span class="text-slate-600 dark:text-slate-300"><?= session()->get('nombres') ?></span> | Sucursal: <span class="text-slate-600 dark:text-slate-300">Principal</span>
            </p>
        </div>
    </div>
</div>

<style>
    .doc-radio.selected {
        border-color: #13ec49;
        background-color: rgba(19, 236, 73, 0.05);
        border-width: 2px;
    }

    .doc-radio.selected span {
        color: #13ec49;
        font-weight: 900;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    const BASE_URL = "<?= base_url() ?>";

    $(document).ready(function() {
        $('#entradaId').on('change', function() {
            const price = $(this).find(':selected').data('price');
            $('#entradaPrecio').val(parseFloat(price).toFixed(2));
            calcularTotal();
        });

        $('#entradaPrecio, #entradaCantidad').on('input', function() {
            calcularTotal();
        });

        $('.doc-radio').on('click', function() {
            const radio = $(this).find('input');
            radio.prop('checked', true);
            $('.doc-radio').removeClass('selected');
            $(this).addClass('selected');

            const selectedDoc = radio.val();
            if (selectedDoc === '77') {
                resetCliente();
                $('#clienteDoc').attr('placeholder', 'DNI / RUC');
            } else if (selectedDoc === '01') {
                // Factura -> RUC (6)
                if ($('#clienteId').val() == '1') {
                    $('#clienteDoc').val('').attr('placeholder', 'INGRESAR RUC').focus();
                    $('#clienteNombre').text('SE REQUIERE RUC');
                }
            } else {
                // Boleta -> DNI (1)
                if ($('#clienteId').val() == '1') {
                    $('#clienteDoc').attr('placeholder', 'DNI / RUC');
                }
            }

            calcularTotal();
        });

        $('#clienteDoc').on('keypress', function(e) {
            if (e.which == 13) {
                buscarCliente();
            }
        });

        // Initialize first selection
        $('.doc-radio input:checked').closest('.doc-radio').addClass('selected');

        // Trigger change for the first ticket if selected
        if ($('#entradaId').val() != '0') {
            $('#entradaId').trigger('change');
        }
    });

    function resetCliente() {
        $('#clienteId').val('1');
        $('#clienteDoc').val('00000001');
        $('#clienteNombre').text('CLIENTE VARIOS');
    }

    function buscarCliente() {
        const doc = $('#clienteDoc').val();
        if (!doc) return;

        $.ajax({
            url: BASE_URL + '/clientes/buscar',
            type: 'POST',
            data: {
                nombres: doc
            },
            success: function(res) {
                if (res.status === 'success' && res.data.length > 0) {
                    const client = res.data[0];
                    $('#clienteId').val(client.id);
                    $('#clienteNombre').text(client.nombres);
                    $('#clienteDoc').val(client.numero_documento);

                    // Validación rápida de RUC si es factura
                    const docType = $('input[name="docType"]:checked').val();
                    if (docType === '01' && client.id_tipo_documento != 6) {
                        Swal.fire('Atención', 'Este cliente no tiene RUC. Para Factura se requiere un RUC.', 'warning');
                    }
                } else {
                    Swal.fire({
                        title: 'No encontrado',
                        text: '¿Deseas registrar este cliente?',
                        icon: 'info',
                        showCancelButton: true,
                        confirmButtonText: 'Registrar',
                        cancelButtonText: 'No'
                    }).then((r) => {
                        if (r.isConfirmed) {
                            // Aquí se podría abrir un modal de registro rápido, 
                            // por ahora simplifico informando.
                            Swal.fire('Info', 'Por favor registre al cliente en el módulo de Clientes.', 'info');
                        }
                    });
                }
            }
        });
    }

    function calcularTotal() {
        const precio = parseFloat($('#entradaPrecio').val()) || 0;
        const cantidad = parseInt($('#entradaCantidad').val()) || 0;
        const total = precio * cantidad;
        $('#totalCobrar').text('S/ ' + total.toFixed(2));
    }

    function procesarVentaEntrada() {
        const entradaId = $('#entradaId').val();
        const precio = parseFloat($('#entradaPrecio').val()) || 0;
        const cantidad = parseInt($('#entradaCantidad').val()) || 0;
        const docType = $('input[name="docType"]:checked').val();
        const clienteId = $('#clienteId').val();

        if (!entradaId || entradaId <= 0) {
            Swal.fire('Error', 'Debe seleccionar un tipo de entrada.', 'error');
            return;
        }

        if (cantidad <= 0) {
            Swal.fire('Error', 'La cantidad debe ser mayor a 0.', 'error');
            return;
        }

        // Validación de Cliente para Factura
        if (docType === '01' && (clienteId == '1' || $('#clienteDoc').val().length < 11)) {
            Swal.fire('Error', 'Para Factura se requiere un cliente con RUC válido (11 dígitos).', 'error');
            return;
        }

        Swal.fire({
            title: '¿Confirmar Emisión?',
            text: `Se emitirá la entrada por un total de S/ ${(precio * cantidad).toFixed(2)}`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#13ec49',
            confirmButtonText: 'Sí, emitir',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    title: 'Procesando...',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                const data = {
                    cart: [{
                        id: entradaId,
                        name: $('#entradaId option:selected').text().split(' (')[0],
                        price: precio,
                        quantity: cantidad,
                        image: 'producto.png'
                    }],
                    paymentMethods: [{
                        id: $('#metodoPagoId').val(),
                        amount: precio * cantidad
                    }],
                    cliente_id: clienteId,
                    docType_id: docType,
                    almacen_id: 1 // Almacén Principal por defecto para entradas
                };

                $.ajax({
                    url: BASE_URL + '/ventas/guardar',
                    type: 'POST',
                    contentType: 'application/json',
                    data: JSON.stringify(data),
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                title: '¡Entrada Emitida!',
                                text: res.message,
                                icon: 'success',
                                showCancelButton: true,
                                confirmButtonText: 'Imprimir Ticket',
                                cancelButtonText: 'Cerrar'
                            }).then((r) => {
                                if (r.isConfirmed) {
                                    window.open(BASE_URL + '/ventas/ticket/' + res.venta_id, '_blank');
                                }
                                location.reload();
                            });
                        } else {
                            Swal.fire('Error', res.message, 'error');
                        }
                    },
                    error: function() {
                        Swal.fire('Error', 'No se pudo procesar la venta.', 'error');
                    }
                });
            }
        });
    }
</script>

<?= $this->endSection() ?>