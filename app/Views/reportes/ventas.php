<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
                <a class="hover:text-primary transition-colors" href="<?= base_url('dashboard') ?>">Home</a>
                <span class="material-symbols-outlined text-xs leading-none">chevron_right</span>
                <span class="text-slate-900 dark:text-slate-300 font-medium">Reportes</span>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Reporte de Ventas</h2>
            <p class="text-slate-500 dark:text-slate-400 text-sm">Analiza el rendimiento de tus ventas con filtros personalizados</p>
        </div>
    </div>

    <!-- Filters Section -->
    <section class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm transition-all hover:shadow-md">
        <form id="ventasReportForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Fecha Inicio -->
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider ml-1">Fecha Inicio</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors text-lg">calendar_today</span>
                    <input type="date" name="desde" id="desde" value="<?= date('Y-m-d') ?>"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
            </div>

            <!-- Fecha Fin -->
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider ml-1">Fecha Fin</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors text-lg">event</span>
                    <input type="date" name="hasta" id="hasta" value="<?= date('Y-m-d') ?>"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all">
                </div>
            </div>

            <!-- Sucursal -->
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider ml-1">Sucursal</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors text-lg">storefront</span>
                    <select name="sucursal_id" id="sucursal_id"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">Todas las sucursales</option>
                        <?php foreach ($sucursales as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Tipo Comprobante -->
            <div class="space-y-1.5">
                <label class="text-[11px] font-bold text-slate-500 uppercase tracking-wider ml-1">Tipo Comprobante</label>
                <div class="relative group">
                    <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors text-lg">receipt_long</span>
                    <select name="comprobante_id" id="comprobante_id"
                        class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all appearance-none cursor-pointer">
                        <option value="">Todos los tipos</option>
                        <?php foreach ($comprobantes as $c): ?>
                            <option value="<?= $c['id_tipodoc_electronico'] ?>"><?= $c['descripcion'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="lg:col-span-4 flex items-center justify-end gap-3 mt-2 border-t border-slate-100 dark:border-slate-800 pt-6">
                <button type="button" onclick="limpiarFiltros()" class="px-6 py-2.5 text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all flex items-center gap-2">
                    <span class="material-symbols-outlined text-lg">refresh</span>
                    Limpiar
                </button>
                <button type="submit" class="bg-primary hover:bg-primary/90 text-slate-900 font-bold py-2.5 px-8 rounded-xl transition-all shadow-lg shadow-primary/20 flex items-center justify-center gap-2 min-w-[140px]">
                    <span class="material-symbols-outlined text-lg">search</span>
                    Buscar
                </button>
                <button type="button" id="btnExportar" class="bg-emerald-500 hover:bg-emerald-600 text-white font-bold py-2.5 px-8 rounded-xl transition-all shadow-lg shadow-emerald-500/20 flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-lg">download</span>
                    Excel
                </button>
            </div>
        </form>
    </section>

    <!-- Results Table -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden min-h-[400px]">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center w-20">#</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Fecha de Emisión</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-center">Tipo Comprobante</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest">Serie y Número</th>
                        <th class="px-6 py-4 text-[10px] font-black text-slate-400 uppercase tracking-widest text-right">Monto Total</th>
                    </tr>
                </thead>
                <tbody id="reportTableBody" class="divide-y divide-slate-100 dark:divide-slate-800">
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <div class="size-16 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center">
                                    <span class="material-symbols-outlined text-3xl text-slate-300">analytics</span>
                                </div>
                                <div class="space-y-1">
                                    <p class="font-bold text-slate-900 dark:text-white">Generar Reporte de Ventas</p>
                                    <p class="text-xs">Ajusta los filtros y haz clic en "Buscar" para obtener los resultados.</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        const ventasReportForm = $('#ventasReportForm');
        const tableBody = $('#reportTableBody');

        // Buscar ventas
        ventasReportForm.on('submit', function(e) {
            e.preventDefault();

            const btn = $(this).find('button[type="submit"]');
            const originalContent = btn.html();
            btn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin text-lg">refresh</span> Buscando...');

            $.ajax({
                url: '<?= base_url('reportes/buscarVentas') ?>',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        renderTable(response.data);
                    }
                },
                error: function() {
                    alert('Error al buscar las ventas');
                },
                complete: function() {
                    btn.prop('disabled', false).html(originalContent);
                }
            });
        });

        function renderTable(data) {
            if (data.length === 0) {
                tableBody.html(`
                    <tr>
                        <td colspan="5" class="px-6 py-20 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-3">
                                <span class="material-symbols-outlined text-4xl text-slate-200">sentiment_neutral</span>
                                <p class="font-bold text-slate-600">No se encontraron ventas con los filtros seleccionados.</p>
                            </div>
                        </td>
                    </tr>
                `);
                return;
            }

            let html = '';
            data.forEach((item, index) => {
                html += `
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors group">
                    <td class="px-6 py-4 text-sm font-bold text-slate-400 text-center w-20 group-hover:text-primary transition-colors">
                        ${index + 1}
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex flex-col">
                            <span class="text-sm font-bold text-slate-900 dark:text-white">${new Date(item.fecha_venta).toLocaleDateString()}</span>
                            <span class="text-[10px] text-slate-400 font-medium uppercase uppercase tracking-wider">${new Date(item.fecha_venta).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="inline-flex px-2.5 py-1 text-[10px] font-black rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400 uppercase tracking-widest border border-slate-200 dark:border-slate-700">
                            ${item.tipo_doc}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <span class="text-sm font-mono font-bold text-slate-900 dark:text-white">${item.serie_comprobante}</span>
                            <span class="text-slate-300">-</span>
                            <span class="text-sm font-bold text-slate-600 dark:text-slate-400">${item.numero_comprobante.padStart(8, '0')}</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-right">
                        <div class="text-sm font-bold text-slate-900 dark:text-white">
                            S/ ${parseFloat(item.total).toFixed(2)}
                        </div>
                    </td>
                </tr>
                `;
            });
            tableBody.html(html);
        }

        // Exportar a Excel
        $('#btnExportar').on('click', function() {
            const params = ventasReportForm.serialize();
            window.location.href = `<?= base_url('reportes/exportarVentas') ?>?${params}`;
        });
    });

    function limpiarFiltros() {
        $('#ventasReportForm')[0].reset();
        $('#reportTableBody').html(`
            <tr>
                <td colspan="5" class="px-6 py-20 text-center text-slate-400">
                    <div class="flex flex-col items-center gap-3">
                        <div class="size-16 rounded-full bg-slate-50 dark:bg-slate-800 flex items-center justify-center">
                            <span class="material-symbols-outlined text-3xl text-slate-300">analytics</span>
                        </div>
                        <div class="space-y-1">
                            <p class="font-bold text-slate-900 dark:text-white">Generar Reporte de Ventas</p>
                            <p class="text-xs">Ajusta los filtros y haz clic en "Buscar" para obtener los resultados.</p>
                        </div>
                    </div>
                </td>
            </tr>
        `);
    }
</script>
<?= $this->endSection() ?>