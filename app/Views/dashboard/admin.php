<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="p-8 space-y-8">
    <!-- Filters Bar -->
    <form method="post" action="<?= base_url('dashboard') ?>" id="filterForm"
        class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-wrap items-end gap-4">
        <div class="flex-1 min-w-[200px] space-y-1.5">
            <label
                class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Fecha Inicio</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">calendar_month</span>
                <input
                    name="fecha_inicio"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary"
                    type="date"
                    value="<?= $filtros['fecha_inicio'] ?>" />
            </div>
        </div>
        <div class="flex-1 min-w-[200px] space-y-1.5">
            <label
                class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Fecha Fin</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">calendar_month</span>
                <input
                    name="fecha_fin"
                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary"
                    type="date"
                    value="<?= $filtros['fecha_fin'] ?>" />
            </div>
        </div>
        <div class="flex-1 min-w-[200px] space-y-1.5">
            <label
                class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Sucursal</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">store</span>
                <select
                    name="sucursal_id" id="sucursal_select"
                    class="w-full pl-10 pr-10 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm appearance-none focus:ring-primary focus:border-primary">
                    <option value="">Todas las Sucursales</option>
                    <?php foreach ($sucursales as $suc): ?>
                        <option value="<?= $suc['id'] ?>" <?= $filtros['sucursal_id'] == $suc['id'] ? 'selected' : '' ?>>
                            <?= $suc['nombre'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>
        <div class="flex-1 min-w-[200px] space-y-1.5">
            <label
                class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Almacén</label>
            <div class="relative">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">warehouse</span>
                <select
                    name="almacen_id" id="almacen_select"
                    class="w-full pl-10 pr-10 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm appearance-none focus:ring-primary focus:border-primary">
                    <option value="">Todos los Almacenes</option>
                </select>
            </div>
        </div>
        <button
            type="submit"
            class="bg-primary hover:bg-primary/90 text-white p-2.5 rounded-lg transition-colors flex items-center justify-center">
            <span class="material-symbols-outlined">filter_alt</span>
        </button>
    </form>
    <!-- Metric Cards -->
    <section class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 p-3 text-primary/10 transition-transform group-hover:scale-110">
                <span class="material-symbols-outlined text-6xl">receipt</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Boletas</p>
            <div class="mt-2 flex items-baseline gap-2">
                <h3 id="stat-boletas" class="text-3xl font-bold tracking-tight"><?= number_format($boletas) ?></h3>
                <span
                    class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded">
                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                    N/A
                </span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Acumulado total</p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 p-3 text-primary/10 transition-transform group-hover:scale-110">
                <span class="material-symbols-outlined text-6xl">description</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Facturas</p>
            <div class="mt-2 flex items-baseline gap-2">
                <h3 id="stat-facturas" class="text-3xl font-bold tracking-tight"><?= number_format($facturas) ?></h3>
                <span
                    class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded">
                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                    N/A
                </span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Acumulado total</p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 p-3 text-primary/10 transition-transform group-hover:scale-110">
                <span class="material-symbols-outlined text-6xl">payments</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">
                Total Notas de Venta
            </p>
            <div class="mt-2 flex items-baseline gap-2">
                <h3 id="stat-notasventa" class="text-3xl font-bold tracking-tight"><?= number_format($notasVenta) ?></h3>
                <span
                    class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded">
                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                    N/A
                </span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Acumulado total</p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
            <div
                class="absolute right-0 top-0 p-3 text-primary/10 transition-transform group-hover:scale-110">
                <span class="material-symbols-outlined text-6xl">account_balance_wallet</span>
            </div>
            <p class="text-sm font-semibold text-slate-500">Total Neto</p>
            <div class="mt-2 flex items-baseline gap-2">
                <h3 id="stat-totalneto" class="text-3xl font-bold tracking-tight text-primary">
                    S/ <?= number_format($totalNeto, 2) ?>
                </h3>
                <span
                    class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded">
                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                    N/A
                </span>
            </div>
            <p class="text-xs text-slate-400 mt-1">Ingresos totales por ventas</p>
        </div>
    </section>
    <!-- Charts Area -->
    <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Top 10 Products -->
        <div
            class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col">
            <div
                class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h4 class="font-bold text-slate-800 dark:text-white">
                    Top 10 Most Sold Products
                </h4>
                <button class="text-primary text-xs font-bold hover:underline">
                    Ver Reporte
                </button>
            </div>
            <div class="p-6 flex-1 space-y-4">
                <div id="top-products-container" class="space-y-4">
                    <?php if (empty($topProducts)): ?>
                        <p class="text-sm text-slate-400 text-center py-8">No hay ventas registradas aún.</p>
                        <?php else:
                        $maxQty = $topProducts[0]['total_qty'] ?? 1;
                        foreach ($topProducts as $prod):
                            $percentage = ($prod['total_qty'] / $maxQty) * 100;
                        ?>
                            <div class="space-y-1">
                                <div class="flex justify-between text-xs font-medium">
                                    <span class="truncate pr-4"><?= $prod['descripcion'] ?></span>
                                    <span class="font-bold flex-shrink-0"><?= number_format($prod['total_qty']) ?> unid.</span>
                                </div>
                                <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                    <div class="bg-primary h-2 rounded-full" style="width: <?= $percentage ?>%"></div>
                                </div>
                            </div>
                    <?php endforeach;
                    endif; ?>
                </div>
            </div>
        </div>
        <!-- Payment Methods Breakdown -->
        <div
            class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col">
            <div
                class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                <h4 class="font-bold text-slate-800 dark:text-white">
                    Payment Methods Breakdown
                </h4>
                <button class="text-primary text-xs font-bold hover:underline">
                    Configurar
                </button>
            </div>
            <div
                class="p-6 flex-1 flex flex-col md:flex-row items-center gap-8">
                <!-- Simulated Donut Chart -->
                <div class="relative w-48 h-48 flex-shrink-0">
                    <svg
                        class="w-full h-full transform -rotate-90"
                        viewbox="0 0 36 36" id="donut-segments">
                        <circle
                            class="stroke-slate-100 dark:stroke-slate-800"
                            cx="18"
                            cy="18"
                            fill="none"
                            r="15.915"
                            stroke-width="4"></circle>
                        <?php
                        $offset = 0;
                        $colors = ['#13ec49', '#137fec', '#f59e0b', '#ec4899', '#6366f1'];
                        foreach ($paymentBreakdown as $index => $pay):
                            $percent = ($totalNeto > 0) ? ($pay['total_monto'] / $totalNeto) * 100 : 0;
                            $dashArray = "$percent " . (100 - $percent);
                            $color = $colors[$index % count($colors)];
                        ?>
                            <circle
                                cx="18"
                                cy="18"
                                fill="none"
                                r="15.915"
                                stroke="<?= $color ?>"
                                stroke-dasharray="<?= $dashArray ?>"
                                stroke-dashoffset="<?= -$offset ?>"
                                stroke-width="4"></circle>
                        <?php $offset += $percent;
                        endforeach; ?>
                    </svg>
                    <div
                        class="absolute inset-0 flex flex-col items-center justify-center text-center">
                        <span class="text-xl font-bold tracking-tight" id="donut-center-text">S/ <?= ($totalNeto >= 1000) ? number_format($totalNeto / 1000, 1) . 'k' : number_format($totalNeto, 0) ?></span>
                        <span class="text-[10px] text-slate-400 font-bold uppercase">Total</span>
                    </div>
                </div>
                <div class="flex-1 space-y-3 w-full" id="payment-legend">
                    <?php foreach ($paymentBreakdown as $index => $pay):
                        $percent = ($totalNeto > 0) ? ($pay['total_monto'] / $totalNeto) * 100 : 0;
                        $color = $colors[$index % count($colors)];
                    ?>
                        <div class="flex items-center justify-between group cursor-default">
                            <div class="flex items-center gap-2">
                                <span class="w-3 h-3 rounded-full" style="background-color: <?= $color ?>"></span>
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300"><?= $pay['nombre'] ?></span>
                            </div>
                            <span class="text-sm font-bold"><?= number_format($percent, 1) ?>%</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Add IDs for Chart elements -->
<style>
    #stat-totalneto-donut {
        font-size: 1.25rem;
        font-weight: bold;
    }
</style>

<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
    $(document).ready(function() {
        const sucursalSelect = $('#sucursal_select');
        const almacenSelect = $('#almacen_select');
        const filterForm = $('#filterForm');
        const btnFilter = filterForm.find('button[type="submit"]');

        function formatNumber(num, decimals = 0) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: decimals,
                maximumFractionDigits: decimals
            }).format(num);
        }

        function loadAlmacenes(sucursalId, callback) {
            if (!sucursalId) {
                almacenSelect.html('<option value="">Todos los Almacenes</option>');
                return;
            }

            $.get(`<?= base_url('almacen/getPorSucursal') ?>/${sucursalId}`, function(response) {
                if (response.status === 'success') {
                    let html = '<option value="">Todos los Almacenes</option>';
                    const selectedAlmacen = '<?= $filtros['almacen_id'] ?>';
                    response.data.forEach(almacen => {
                        const selected = (almacen.id == selectedAlmacen) ? 'selected' : '';
                        html += `<option value="${almacen.id}" ${selected}>${almacen.nombre}</option>`;
                    });
                    almacenSelect.html(html);
                    if (callback) callback();
                }
            });
        }

        // Ajax Filter
        filterForm.on('submit', function(e) {
            e.preventDefault();

            // Show loading state
            btnFilter.prop('disabled', true).html('<span class="material-symbols-outlined animate-spin">refresh</span>');

            const data = $(this).serialize();

            $.ajax({
                url: '<?= base_url('dashboard') ?>',
                method: 'POST',
                data: data,
                dataType: 'json',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    if (response.status === 'success') {
                        const d = response.data;

                        // Update Stats
                        $('#stat-boletas').text(formatNumber(d.boletas));
                        $('#stat-facturas').text(formatNumber(d.facturas));
                        $('#stat-notasventa').text(formatNumber(d.notasVenta));
                        $('#stat-totalneto').text('S/ ' + formatNumber(d.totalNeto, 2));

                        // Update Top Products
                        let topHtml = '';
                        if (d.topProducts.length === 0) {
                            topHtml = '<p class="text-sm text-slate-400 text-center py-8">No hay ventas registradas aún.</p>';
                        } else {
                            const maxQty = d.topProducts[0].total_qty || 1;
                            d.topProducts.forEach(prod => {
                                const pct = (prod.total_qty / maxQty) * 100;
                                topHtml += `
                                <div class="space-y-1">
                                    <div class="flex justify-between text-xs font-medium">
                                        <span class="truncate pr-4">${prod.descripcion}</span>
                                        <span class="font-bold flex-shrink-0">${formatNumber(prod.total_qty)} unid.</span>
                                    </div>
                                    <div class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                        <div class="bg-primary h-2 rounded-full" style="width: ${pct}%"></div>
                                    </div>
                                </div>`;
                            });
                        }
                        $('#top-products-container').html(topHtml);

                        // Update Donut Chart & Legend
                        updateCharts(d.paymentBreakdown, d.totalNeto);
                    }
                },
                complete: function() {
                    btnFilter.prop('disabled', false).html('<span class="material-symbols-outlined">filter_alt</span>');
                }
            });
        });

        function updateCharts(breakdown, total) {
            const colors = ['#13ec49', '#137fec', '#f59e0b', '#ec4899', '#6366f1'];
            let svgHtml = `
            <circle class="stroke-slate-100 dark:stroke-slate-800" cx="18" cy="18" fill="none" r="15.915" stroke-width="4"></circle>`;

            let legendHtml = '';
            let offset = 0;

            breakdown.forEach((pay, index) => {
                const percent = (total > 0) ? (pay.total_monto / total) * 100 : 0;
                const dashArray = `${percent} ${100 - percent}`;
                const color = colors[index % colors.length];

                svgHtml += `
                <circle cx="18" cy="18" fill="none" r="15.915"
                    stroke="${color}" stroke-dasharray="${dashArray}"
                    stroke-dashoffset="${-offset}" stroke-width="4"></circle>`;

                legendHtml += `
                <div class="flex items-center justify-between group cursor-default">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full" style="background-color: ${color}"></span>
                        <span class="text-sm font-medium text-slate-700 dark:text-slate-300">${pay.nombre}</span>
                    </div>
                    <span class="text-sm font-bold">${formatNumber(percent, 1)}%</span>
                </div>`;

                offset += percent;
            });

            $('#donut-segments').html(svgHtml);
            $('#payment-legend').html(legendHtml);

            const centerText = (total >= 1000) ? (total / 1000).toFixed(1) + 'k' : total.toFixed(0);
            $('#donut-center-text').text('S/ ' + centerText);
        }

        if (sucursalSelect.val()) {
            loadAlmacenes(sucursalSelect.val());
        }

        sucursalSelect.on('change', function() {
            loadAlmacenes($(this).val());
        });
    });
</script>
<?= $this->endSection() ?>