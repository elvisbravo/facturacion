<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 lg:p-8 space-y-8">
    <!-- Page Header Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-3">
                <?php if ($cajaAbierta): ?>
                    <span
                        class="inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-2.5 py-0.5 text-xs font-bold text-emerald-800 dark:text-emerald-400 uppercase tracking-tighter">
                        <span class="mr-1.5 h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Caja Abierta
                    </span>
                <?php else: ?>
                    <span
                        class="inline-flex items-center rounded-full bg-rose-100 dark:bg-rose-900/30 px-2.5 py-0.5 text-xs font-bold text-rose-800 dark:text-rose-400 uppercase tracking-tighter">
                        <span class="mr-1.5 h-2 w-2 rounded-full bg-rose-500"></span>
                        Caja Cerrada
                    </span>
                <?php endif; ?>
                <h1 class="text-3xl font-bold tracking-tight">
                    Gestión de Caja Diaria
                </h1>
            </div>
            <p class="text-slate-500 dark:text-slate-400 font-medium">
                Fecha: <?= date('d M, Y') ?> | Responsable:
                <span class="text-slate-900 dark:text-slate-200 font-bold"><?= session()->get('nombres') ?> <?= session()->get('apellidos') ?></span>
            </p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <?php if (!$cajaAbierta): ?>
                <button onclick="abrirModalApertura()"
                    class="flex-1 md:flex-none flex items-center justify-center gap-2 rounded-xl h-12 px-6 bg-emerald-500 text-white text-base font-bold hover:shadow-lg hover:shadow-emerald-500/30 transition-all">
                    <span class="material-symbols-outlined">lock_open</span>
                    Apertura
                </button>
            <?php else: ?>
                <button onclick="confirmarCerrarCaja()"
                    class="flex-1 md:flex-none flex items-center justify-center gap-2 rounded-xl h-12 px-6 bg-primary text-slate-900 text-base font-bold hover:shadow-lg hover:shadow-primary/30 transition-all">
                    <span class="material-symbols-outlined">lock</span>
                    Cerrar Caja
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Summary Table Section -->
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/50">
            <h3 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest">
                Resumen por Métodos de Pago
            </h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-widest">
                        <th class="px-6 py-4">Método de Pago</th>
                        <th class="px-6 py-4 text-right">Monto Inicial</th>
                        <th class="px-6 py-4 text-right">Ingresos</th>
                        <th class="px-6 py-4 text-right">Egresos</th>
                        <th class="px-6 py-4 text-right">Total Parcial</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php if ($cajaAbierta): ?>
                        <?php foreach ($resumen as $r): ?>
                            <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                                <td class="px-6 py-5 font-bold flex items-center gap-3">
                                    <div
                                        class="size-8 rounded-lg bg-orange-100 dark:bg-orange-900/20 flex items-center justify-center text-orange-600">
                                        <span class="material-symbols-outlined">payments</span>
                                    </div>
                                    <?= $r['nombre'] ?>
                                </td>
                                <td class="px-6 py-5 text-right font-medium">
                                    S/ <?= number_format($r['monto_inicial'], 2) ?>
                                </td>
                                <td class="px-6 py-5 text-right text-emerald-500 font-bold">
                                    + S/ <?= number_format($r['ingresos'], 2) ?>
                                </td>
                                <td class="px-6 py-5 text-right text-rose-500 font-bold">
                                    - S/ <?= number_format($r['egresos'], 2) ?>
                                </td>
                                <td class="px-6 py-5 text-right font-bold text-slate-900 dark:text-white">
                                    S/ <?= number_format($r['parcial'], 2) ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic">
                                Abra la caja para ver el resumen de movimientos.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Footer Metrics Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest">
                    Total Ingresos
                </p>
                <span class="material-symbols-outlined text-emerald-500">trending_up</span>
            </div>
            <p class="text-slate-900 dark:text-white text-3xl font-bold">
                S/ <?= number_format($totales['ingresos'] ?? 0, 2) ?>
            </p>
            <p class="text-emerald-500 text-[10px] font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">arrow_upward</span>
                Ingresos registrados hoy
            </p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col gap-2">
            <div class="flex items-center justify-between">
                <p class="text-slate-500 dark:text-slate-400 text-xs font-bold uppercase tracking-widest">
                    Total Egresos
                </p>
                <span class="material-symbols-outlined text-rose-500">trending_down</span>
            </div>
            <p class="text-slate-900 dark:text-white text-3xl font-bold">
                S/ <?= number_format($totales['egresos'] ?? 0, 2) ?>
            </p>
            <p class="text-slate-400 text-[10px] font-bold uppercase">
                Retiros y gastos de hoy
            </p>
        </div>
        <div
            class="bg-primary rounded-2xl p-6 border border-primary/20 shadow-xl shadow-primary/20 flex flex-col gap-2 relative overflow-hidden group">
            <div
                class="absolute -right-4 -top-4 text-slate-900/10 group-hover:scale-110 transition-transform duration-500">
                <span class="material-symbols-outlined !text-[120px]">account_balance_wallet</span>
            </div>
            <div class="flex items-center justify-between relative z-10">
                <p class="text-slate-900 text-xs font-bold uppercase tracking-widest opacity-70">
                    Total Neto en Caja
                </p>
            </div>
            <p class="text-slate-900 text-4xl font-bold relative z-10">
                S/ <?= number_format($totales['neto'] ?? 0, 2) ?>
            </p>
            <p class="text-slate-900/70 text-[10px] font-bold uppercase relative z-10">
                Saldo real disponible
            </p>
        </div>
    </div>

    <!-- Resumen de Caja Section -->
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest leading-none">
                Resumen de Caja (Ingresos y Egresos)
            </h4>
        </div>
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-slate-400 dark:text-slate-500 text-[10px] font-bold uppercase tracking-widest border-b border-slate-100 dark:border-slate-800 bg-slate-50/30 dark:bg-slate-800/20">
                        <th class="px-6 py-4">CANT</th>
                        <th class="px-6 py-4">PRODUCTO / CONCEPTO</th>
                        <th class="px-6 py-4 text-right">PRECIO</th>
                        <th class="px-6 py-4 text-right">IMPORTE</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php if ($cajaAbierta): ?>

                        <!-- Listar Ingresos por Detalle de Venta -->
                        <?php if (!empty($detalles_ingresos)): ?>
                            <?php foreach ($detalles_ingresos as $det): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500">
                                        <?= (int)$det['cantidad'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900 dark:text-white"><?= $det['producto'] ?></span>
                                            <span class="text-[9px] uppercase font-bold text-emerald-500 tracking-tighter">
                                                INGR • VENTA
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm text-slate-600 dark:text-slate-400">
                                        S/ <?= number_format($det['precio'], 2) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-emerald-600">
                                        + S/ <?= number_format($det['importe'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!-- Listar Egresos y Otros Movimientos -->
                        <?php if (!empty($otros_movimientos)): ?>
                            <?php foreach ($otros_movimientos as $mov): ?>
                                <tr class="hover:bg-slate-50/50 transition-colors">
                                    <td class="px-6 py-4 font-mono text-xs text-slate-500">
                                        <?= (int)$mov['cantidad'] ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-bold text-slate-900 dark:text-white"><?= $mov['producto'] ?></span>
                                            <span class="text-[9px] uppercase font-bold <?= $mov['tipo_movimiento'] == 'INGRESO' ? 'text-emerald-500' : 'text-rose-500' ?> tracking-tighter">
                                                <?= $mov['tipo_movimiento'] == 'INGRESO' ? 'INGR' : 'EGR' ?> • <?= $mov['tipo_movimiento'] == 'INGRESO' ? 'RECARGA' : 'GASTO' ?>
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-right text-sm text-slate-600 dark:text-slate-400">
                                        S/ <?= number_format($mov['precio'], 2) ?>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold <?= $mov['tipo_movimiento'] == 'INGRESO' ? 'text-emerald-600' : 'text-rose-600' ?> tracking-tight">
                                        <?= $mov['tipo_movimiento'] == 'INGRESO' ? '+' : '-' ?> S/ <?= number_format($mov['importe'], 2) ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <?php if (empty($detalles_ingresos) && empty($otros_movimientos)): ?>
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">
                                    Aún no hay ingresos ni egresos en este turno.
                                </td>
                            </tr>
                        <?php endif; ?>

                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-400 italic">
                                La caja está cerrada.
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>