<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="p-4 lg:p-8 space-y-6">
    <!-- Page Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">
                Gestión de Ventas
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Consulta y administra todos los comprobantes emitidos.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button
                class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-lg text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                <span class="material-symbols-outlined text-lg">ios_share</span>
                Exportar
            </button>
            <a href="<?= base_url('pos') ?>"
                class="flex items-center gap-2 px-4 py-2 bg-primary text-slate-900 rounded-lg text-sm font-bold hover:shadow-lg hover:shadow-primary/30 transition-all">
                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                Nueva Venta
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- TOTAL VENTAS -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Total Ventas</span>
                <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-xl">payments</span>
                </div>
            </div>
            <h3 id="statTotalVentas" class="text-2xl font-bold text-slate-900 dark:text-white">S/ 0.00</h3>
            <p class="text-[10px] text-emerald-500 font-bold mt-1 uppercase tracking-tighter">Suma total según filtros</p>
        </div>

        <!-- COMPROBANTES (BOLETAS + FACTURAS) -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Comprobantes</span>
                <div class="size-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <span class="material-symbols-outlined text-xl">description</span>
                </div>
            </div>
            <h3 id="statComprobantes" class="text-2xl font-bold text-slate-900 dark:text-white">00</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-tighter">Boletas y Facturas</p>
        </div>

        <!-- NOTAS DE VENTA -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Notas de Venta</span>
                <div class="size-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-500">
                    <span class="material-symbols-outlined text-xl">sticky_note_2</span>
                </div>
            </div>
            <h3 id="statNotasVenta" class="text-2xl font-bold text-slate-900 dark:text-white">00</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-tighter">Comprobantes internos</p>
        </div>

        <!-- PENDIENTES SUNAT -->
        <div class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pendientes SUNAT</span>
                <div class="size-8 rounded-lg bg-orange-500/10 flex items-center justify-center text-orange-500">
                    <span class="material-symbols-outlined text-xl">cloud_sync</span>
                </div>
            </div>
            <h3 id="statPendientes" class="text-2xl font-bold text-slate-900 dark:text-white">00</h3>
            <p class="text-[10px] text-orange-500 font-bold mt-1 uppercase tracking-tighter">Requieren atención</p>
        </div>
    </div>

    <!-- Main Table Section -->
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col">
        <!-- Table Controls -->
        <div
            class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50 rounded-t-2xl">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                    <span>MOSTRAR</span>
                    <select id="lenSelector"
                        class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-800 rounded-lg text-xs py-1 px-2 focus:ring-primary outline-none">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                </div>
                <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 hidden md:block"></div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Desde</span>
                        <input type="date" id="fechaDesde" value="<?= date('Y-m-01') ?>"
                            class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-800 rounded-lg text-xs py-1 px-2 focus:ring-primary outline-none transition-all" />
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Hasta</span>
                        <input type="date" id="fechaHasta" value="<?= date('Y-m-d') ?>"
                            class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-800 rounded-lg text-xs py-1 px-2 focus:ring-primary outline-none transition-all" />
                    </div>
                    <select id="estadoFiltro"
                        class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-800 rounded-lg text-xs py-1 px-2 focus:ring-primary outline-none">
                        <option value="">Todos los Estados</option>
                        <option value="Aceptado">Aceptado</option>
                        <option value="Pendiente">Pendiente</option>
                        <option value="Rechazado">Rechazado</option>
                    </select>
                </div>
            </div>
            <div class="relative w-full md:w-72">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input type="text" id="ventaSearch" placeholder="Buscar por cliente, documento o correlativo..."
                    class="w-full pl-10 pr-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-xl text-xs focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" />
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-visible">
            <table id="ventasTable" class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-800/50 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-sm">
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Fecha / Hora
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Comprobante
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Cliente
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Total
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Métodos de Pago
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Estado SUNAT
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 text-right">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Data loaded via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Simple Modern Modal -->
<div id="modalDetalle" class="fixed inset-0 z-[150] hidden">
    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm transition-opacity" onclick="closeModal()"></div>

    <!-- Modal Content -->
    <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-full max-w-lg md:max-w-2xl px-4 scale-95 transition-transform">
        <div class="bg-white dark:bg-slate-900 rounded-3xl shadow-2xl overflow-hidden border border-slate-200 dark:border-slate-800">
            <!-- Header -->
            <div class="px-6 py-5 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div class="flex items-center gap-3 text-slate-900 dark:text-white">
                    <div class="size-10 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">receipt_long</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold">Detalle de Venta</h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400" id="modalSubTitle">Cargando información...</p>
                    </div>
                </div>
                <button onclick="closeModal()" class="size-9 flex items-center justify-center rounded-xl bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>

            <!-- Body -->
            <div class="p-6 max-h-[70vh] overflow-y-auto" id="modalBody">
                <div class="flex flex-col items-center justify-center py-12 space-y-4">
                    <div class="size-12 border-4 border-primary border-t-white rounded-full animate-spin"></div>
                    <p class="text-sm font-bold text-slate-400 animate-pulse">Obteniendo datos de venta...</p>
                </div>
            </div>

            <!-- Footer -->
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50 flex justify-end gap-3">
                <button onclick="closeModal()" class="px-4 py-2 text-sm font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">
                    Cerrar
                </button>
                <button id="modalBtnImprimir" class="flex items-center gap-2 px-5 py-2 bg-primary text-slate-900 rounded-xl text-sm font-bold shadow-lg shadow-primary/20 hover:scale-[1.02] active:scale-95 transition-all">
                    <span class="material-symbols-outlined text-lg">print</span>
                    Imprimir Ticket
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    /* Estilos para customizar DataTable al diseño */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
        padding: 0.25rem 0.75rem !important;
        margin-left: 0.25rem !important;
        border-radius: 0.5rem !important;
        border: 1px solid #e2e8f0 !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        background: white !important;
        color: #64748b !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #13ec49 !important;
        color: #102215 !important;
        border-color: #13ec49 !important;
    }

    .dataTables_wrapper .dataTables_info {
        font-size: 0.75rem !important;
        color: #64748b !important;
        font-weight: 600 !important;
    }

    .dataTables_length,
    .dataTables_filter {
        display: none !important;
    }

    table.dataTable thead th {
        border-bottom: 1px solid #e2e8f0 !important;
    }

    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        background: #1e293b !important;
        border-color: #334155 !important;
        color: #94a3b8 !important;
    }

    #ventasTable td {
        white-space: nowrap;
    }

    .action-dropdown {
        position: absolute;
        right: 0;
        margin-top: 0.5rem;
        width: 220px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 0.75rem;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        z-index: 200;
        overflow: hidden;
    }

    .dark .action-dropdown {
        background: #0f172a;
        border-color: #1e293b;
    }

    .action-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        width: 100%;
        padding: 0.625rem 1rem;
        font-size: 0.75rem;
        font-weight: 700;
        text-align: left;
        color: #334155;
        transition: all 0.2s;
        border: none;
        background: transparent;
        cursor: pointer;
    }

    .dark .action-item {
        color: #94a3b8;
    }

    .action-item:hover {
        background: #f8fafc;
        color: #102215;
    }

    .dark .action-item:hover {
        background: #1e293b;
        color: white;
    }

    .action-item span.material-symbols-outlined {
        font-size: 1.125rem;
        color: #94a3b8;
    }

    .action-item:hover span.material-symbols-outlined {
        color: currentColor;
    }
</style>

<!-- Scripts para DataTable -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/locale/es.min.js"></script>

<script>
    function closeModal() {
        $('#modalDetalle').addClass('hidden');
        $('body').css('overflow', 'auto');
    }

    function openModalVenta(id, correlativo) {
        $('#modalSubTitle').text(correlativo);
        $('#modalDetalle').removeClass('hidden');
        $('body').css('overflow', 'hidden');

        $('#modalBody').html(`
            <div class="flex flex-col items-center justify-center py-12 space-y-4">
                <div class="size-12 border-4 border-primary border-t-white rounded-full animate-spin"></div>
                <p class="text-sm font-bold text-slate-400 animate-pulse">Obteniendo datos de venta...</p>
            </div>
        `);

        $('#modalBtnImprimir').off('click').on('click', function() {
            window.open('<?= base_url('ventas/ticket/') ?>/' + id, '_blank');
        });

        $.get('<?= base_url('ventas/detalle') ?>/' + id, function(html) {
            $('#modalBody').html(html);
        }).fail(function() {
            $('#modalBody').html(`
                <div class="text-center py-12">
                    <span class="material-symbols-outlined text-rose-500 text-5xl mb-3">error</span>
                    <p class="text-sm font-bold text-slate-500">Error al cargar el detalle de la venta.</p>
                </div>
            `);
        });
    }

    $(document).ready(function() {
        moment.locale('es');

        if ($.fn.DataTable && !$.fn.DataTable.isDataTable('#ventasTable')) {
            const table = $('#ventasTable').DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?= base_url('ventas/listar') ?>",
                    "type": "GET",
                    "data": function(d) {
                        d.desde = $('#fechaDesde').val();
                        d.hasta = $('#fechaHasta').val();
                        d.estado = $('#estadoFiltro').val();
                    }
                },
                "columns": [{
                        "data": "fecha_venta",
                        "render": function(data) {
                            const date = moment(data);
                            return `
                                <p class="font-bold text-slate-900 dark:text-white">${date.format('DD MMM, YYYY')}</p>
                                <p class="text-[10px] text-slate-500">${date.format('hh:mm A')}</p>
                            `;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data) {
                            return `
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 uppercase tracking-tighter">${data.tipo_comprobante}</span>
                                <p class="font-bold mt-1 text-slate-700 dark:text-slate-300">${data.serie}-${data.numero}</p>
                            `;
                        }
                    },
                    {
                        "data": null,
                        "render": function(data) {
                            return `
                                <p class="font-bold text-slate-900 dark:text-white">${data.cliente_nombre}</p>
                                <p class="text-[10px] text-slate-500">DOC: ${data.cliente_doc}</p>
                            `;
                        }
                    },
                    {
                        "data": "total",
                        "render": function(data) {
                            return `<p class="text-sm font-bold text-slate-900 dark:text-white">S/ ${data}</p>`;
                        }
                    },
                    {
                        "data": "metodos_pago",
                        "orderable": false,
                        "render": function(data) {
                            if (!data || data.length === 0) return '<span class="text-[10px] text-slate-400 font-bold uppercase tracking-tighter">Sin registro</span>';
                            return data.map(m => `
                                <div class="flex items-center gap-1.5 mb-1 last:mb-0">
                                    <span class="px-1.5 py-0.5 rounded bg-slate-100 dark:bg-slate-800 text-[9px] font-bold text-slate-500 uppercase">${m.metodo}</span>
                                    <span class="text-[10px] font-bold text-slate-900 dark:text-white">S/ ${m.monto}</span>
                                </div>
                            `).join('');
                        }
                    },
                    {
                        "data": "estado_envio_sunat",
                        "render": function(data) {
                            const color = data === 'Aceptado' ? 'emerald' : 'orange';
                            return `
                                <div class="flex items-center gap-1.5 text-${color}-500 font-bold text-[10px] uppercase">
                                    <span class="size-2 rounded-full bg-${color}-500 shadow-lg shadow-${color}-500/50"></span>
                                    ${data}
                                </div>
                            `;
                        }
                    },
                    {
                        "data": null,
                        "orderable": false,
                        "className": "text-right",
                        "render": function(data) {
                            const correlativo = `${data.serie}-${data.numero}`;
                            return `
                                <div class="relative inline-block text-left dropdown">
                                    <button class="p-2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg dropdown-toggle">
                                        <span class="material-symbols-outlined text-xl">more_vert</span>
                                    </button>
                                    <div class="action-dropdown hidden absolute right-0 mt-2 w-56 origin-top-right bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl z-[200] overflow-hidden">
                                        <div class="py-1">
                                            <button onclick="openModalVenta(${data.id}, '${correlativo}')" class="action-item">
                                                <span class="material-symbols-outlined">visibility</span>
                                                Detalle de Venta
                                            </button>
                                            <button class="action-item">
                                                <span class="material-symbols-outlined">cloud_upload</span>
                                                Enviar a SUNAT
                                            </button>
                                            <button onclick="window.open('<?= base_url('ventas/ticket/') ?>/${data.id}', '_blank')" class="action-item">
                                                <span class="material-symbols-outlined">receipt_long</span>
                                                Ver Ticket
                                            </button>
                                            <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                                            <button class="action-item">
                                                <span class="material-symbols-outlined">assignment_return</span>
                                                Crear Nota de Crédito
                                            </button>
                                            <button class="action-item text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-500/10">
                                                <span class="material-symbols-outlined text-rose-500">cancel</span>
                                                Anular Comprobante
                                            </button>
                                            <div class="h-px bg-slate-100 dark:bg-slate-800 my-1"></div>
                                            <button class="action-item">
                                                <span class="material-symbols-outlined">chat</span>
                                                Enviar WhatsApp
                                            </button>
                                            <button class="action-item">
                                                <span class="material-symbols-outlined">mail</span>
                                                Enviar Correo
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            `;
                        }
                    }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json"
                },
                "dom": 'rt<"flex items-center justify-between p-6 border-t border-slate-200 dark:border-slate-800"ip>',
                "pageLength": 10,
                "order": [
                    [0, "desc"]
                ],
                "createdRow": function(row, data, dataIndex) {
                    $(row).addClass('hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors');
                    $('td', row).addClass('px-6 py-4 font-medium text-sm');
                }
            });

            // Actualizar tarjetas de resumen con la data del servidor
            table.on('xhr.dt', function(e, settings, json, xhr) {
                if (json && json.stats) {
                    $('#statTotalVentas').text('S/ ' + json.stats.totalVentas);
                    $('#statComprobantes').text(json.stats.totalComprobantes);
                    // Actualizar el label de Notas de Venta
                    $('#statNotasVenta').text(json.stats.totalNotasVenta);
                    $('#statPendientes').text(json.stats.pendientesSunat);
                }
            });

            $(document).on('click', '.dropdown-toggle', function(e) {
                e.stopPropagation();
                const menu = $(this).next('.action-dropdown');
                $('.action-dropdown').not(menu).addClass('hidden');
                menu.toggleClass('hidden');
            });

            $(document).on('click', function() {
                $('.action-dropdown').addClass('hidden');
            });

            $('#ventaSearch').on('keyup', function() {
                table.search(this.value).draw();
            });

            $('#lenSelector').on('change', function() {
                table.page.len(this.value).draw();
            });

            $('#fechaDesde, #fechaHasta, #estadoFiltro').on('change', function() {
                table.ajax.reload();
            });
        }
    });
</script>
<?= $this->endSection() ?>