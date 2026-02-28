<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-8 space-y-6">
    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h2 class="text-2xl font-bold text-slate-800 dark:text-white">Kardex de Inventario</h2>
            <p class="text-slate-500 dark:text-slate-400">Consulta el historial de movimientos de tus productos</p>
        </div>
    </div>

    <!-- Filters Section -->
    <section class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm">
        <form id="kardexForm" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Producto -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Producto</label>
                <select name="producto_id" id="producto_id" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary">
                    <option value="">Seleccione un producto...</option>
                    <?php foreach ($productos as $producto): ?>
                        <option value="<?= $producto['id'] ?>"><?= $producto['nombre_producto'] ?> (<?= $producto['codigo'] ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Sucursal -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Sucursal</label>
                <select name="sucursal_id" id="sucursal_id" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary">
                    <option value="">Todas las sucursales</option>
                    <?php foreach ($sucursales as $suc): ?>
                        <option value="<?= $suc['id'] ?>"><?= $suc['nombre'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Almacen -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Almacén</label>
                <select name="almacen_id" id="almacen_id" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary">
                    <option value="">Todos los almacenes</option>
                </select>
            </div>

            <!-- Fecha Inicio -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Fecha Inicio</label>
                <input type="date" name="fecha_inicio" id="fecha_inicio" value="<?= date('Y-m-01') ?>" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary">
            </div>

            <!-- Fecha Fin -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Fecha Fin</label>
                <input type="date" name="fecha_fin" id="fecha_fin" value="<?= date('Y-m-d') ?>" class="w-full px-4 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary">
            </div>

            <!-- Action Buttons -->
            <div class="flex items-end gap-2">
                <button type="submit" class="flex-1 bg-primary hover:bg-primary/90 text-white font-bold py-2 px-4 rounded-lg transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">search</span>
                    Buscar
                </button>
                <button type="button" id="btnExportar" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-2 px-4 rounded-lg transition-all flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined">download</span>
                    Excel
                </button>
            </div>
        </form>
    </section>

    <!-- Results Table -->
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 border-b border-slate-200 dark:border-slate-800">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Producto</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Sede/Almacén</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tipo</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Cant.</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Saldo</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Motivo</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Documento</th>
                    </tr>
                </thead>
                <tbody id="kardexTableBody" class="divide-y divide-slate-100 dark:divide-slate-800">
                    <tr>
                        <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center gap-2">
                                <span class="material-symbols-outlined text-4xl">info</span>
                                <p>Seleccione un producto y haga clic en buscar</p>
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
        const sucursalSelect = $('#sucursal_id');
        const almacenSelect = $('#almacen_id');
        const kardexForm = $('#kardexForm');
        const tableBody = $('#kardexTableBody');

        // Cargar almacenes dinámicamente
        sucursalSelect.on('change', function() {
            const sucursalId = $(this).val();
            if (!sucursalId) {
                almacenSelect.html('<option value="">Todos los almacenes</option>');
                return;
            }

            $.get(`<?= base_url('almacen/getPorSucursal') ?>/${sucursalId}`, function(response) {
                if (response.status === 'success') {
                    let html = '<option value="">Todos los almacenes</option>';
                    response.data.forEach(almacen => {
                        html += `<option value="${almacen.id}">${almacen.nombre}</option>`;
                    });
                    almacenSelect.html(html);
                }
            });
        });

        // Buscar movimientos
        kardexForm.on('submit', function(e) {
            e.preventDefault();

            const btn = $(this).find('button[type="submit"]');
            const originalContent = btn.html();
            btn.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin">refresh</span> Buscando...');

            $.ajax({
                url: '<?= base_url('kardex/buscar') ?>',
                method: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    if (response.status === 'success') {
                        renderTable(response.data);
                    }
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
                    <td colspan="8" class="px-6 py-12 text-center text-slate-400">
                        <p>No se encontraron movimientos con los filtros seleccionados.</p>
                    </td>
                </tr>
            `);
                return;
            }

            let html = '';
            data.forEach(item => {
                const isEntry = item.tipo.toUpperCase() === 'ENTRADA' || item.tipo.toUpperCase() === 'COMPRA' || item.tipo.toUpperCase() === 'INGRESO';
                const colorClass = isEntry ? 'text-emerald-500 bg-emerald-50 dark:bg-emerald-500/10' : 'text-rose-500 bg-rose-50 dark:bg-rose-500/10';
                const sign = isEntry ? '+' : '-';

                html += `
                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                        <div class="font-medium text-slate-800 dark:text-white">${new Date(item.created_at).toLocaleDateString()}</div>
                        <div class="text-xs text-slate-400">${new Date(item.created_at).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                        <div class="font-medium text-slate-800 dark:text-white">${item.nombre_producto}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                        <div class="font-medium text-slate-800 dark:text-white">${item.nombre_sucursal}</div>
                        <div class="text-xs text-slate-400">${item.nombre_almacen}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-bold rounded ${colorClass}">
                            ${item.tipo.toUpperCase()}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-center ${isEntry ? 'text-emerald-500' : 'text-rose-500'}">
                        ${sign} ${parseFloat(item.cantidad).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 text-sm font-bold text-center text-slate-800 dark:text-white">
                        ${parseFloat(item.stock_actual).toFixed(2)}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                        ${item.motivo || '-'}
                        ${item.nombre_usuario ? `<div class="text-xs text-slate-400">Por: ${item.nombre_usuario}</div>` : ''}
                    </td>
                    <td class="px-6 py-4 text-sm text-slate-600 dark:text-slate-400">
                        <span class="font-medium text-slate-800 dark:text-white">${item.referencia_tipo || '-'}</span>
                        <div class="text-xs text-slate-400">${item.num_documento || item.referencia_id || '-'}</div>
                    </td>
                </tr>
            `;
            });
            tableBody.html(html);
        }

        // Exportar a Excel
        $('#btnExportar').on('click', function() {
            const params = kardexForm.serialize();
            window.location.href = `<?= base_url('kardex/exportarExcel') ?>?${params}`;
        });
    });
</script>
<?= $this->endSection() ?>