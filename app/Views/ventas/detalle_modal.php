<div class="space-y-6">
    <!-- Sale Info Header -->
    <div class="flex flex-col md:flex-row justify-between gap-4 bg-slate-50 dark:bg-slate-800/50 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
        <div class="space-y-1">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Estado SUNAT</p>
            <div class="flex items-center gap-1.5 text-emerald-500 font-bold text-sm">
                <span class="size-2 rounded-full bg-emerald-500 shadow-sm"></span>
                <?= $venta['estado_envio_sunat'] ?>
            </div>
        </div>
        <div class="space-y-1 md:text-right">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Comprobante</p>
            <p class="text-sm font-bold text-slate-900 dark:text-white">
                <?= $venta['tipo_comprobante'] ?? 'COMPROBANTE' ?> <?= $venta['serie_comprobante'] ?>-<?= str_pad($venta['numero_comprobante'], 8, '0', STR_PAD_LEFT) ?>
            </p>
        </div>
        <div class="space-y-1 md:text-right">
            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest">Fecha y Hora</p>
            <p class="text-sm font-bold text-slate-900 dark:text-white">
                <?= date('d/m/Y h:i A', strtotime($venta['fecha_venta'])) ?>
            </p>
        </div>
    </div>

    <!-- Client Info -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="space-y-2">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Datos del Cliente</h4>
            <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-100 dark:border-slate-800 space-y-2 h-full">
                <div>
                    <p class="text-[10px] text-slate-400 font-bold">NOMBRE / RAZÓN SOCIAL</p>
                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200"><?= $venta['cliente_nombre'] ?? 'PÚBLICO GENERAL' ?></p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-bold">DOCUMENTO</p>
                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200"><?= $venta['cliente_doc'] ?? '-' ?></p>
                </div>
                <div>
                    <p class="text-[10px] text-slate-400 font-bold">DIRECCIÓN</p>
                    <p class="text-xs text-slate-600 dark:text-slate-400"><?= $venta['cliente_direccion'] ?: 'No registra' ?></p>
                </div>
            </div>
        </div>
        <div class="space-y-2">
            <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pago y Liquidación</h4>
            <div class="space-y-2">
                <?php if (empty($pagos)): ?>
                    <div class="p-3 text-center bg-slate-50 dark:bg-slate-800/30 rounded-lg border border-dashed border-slate-200 dark:border-slate-800">
                        <p class="text-[10px] font-bold text-slate-400 uppercase">Sin información de pagos</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($pagos as $pago): ?>
                        <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/30 rounded-lg border border-slate-100 dark:border-slate-800">
                            <div class="flex items-center gap-3">
                                <div class="size-8 rounded-full bg-white dark:bg-slate-800 flex items-center justify-center text-slate-400">
                                    <span class="material-symbols-outlined text-lg">payments</span>
                                </div>
                                <span class="text-xs font-bold text-slate-700 dark:text-slate-300"><?= $pago['metodo'] ?></span>
                            </div>
                            <span class="text-xs font-bold text-slate-900 dark:text-white">S/ <?= number_format($pago['monto'], 2) ?></span>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Items Table -->
    <div class="space-y-2">
        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-wider">Detalle de Productos</h4>
        <div class="overflow-x-auto rounded-xl border border-slate-100 dark:border-slate-800">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-[10px] font-bold text-slate-400 uppercase">
                        <th class="px-4 py-3">Cant.</th>
                        <th class="px-4 py-3">Producto</th>
                        <th class="px-4 py-3">P. Unit</th>
                        <th class="px-4 py-3 text-right">Importe</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <?php foreach ($detalle as $item): ?>
                        <tr class="text-xs hover:bg-slate-50/50 dark:hover:bg-slate-800/20 transition-colors">
                            <td class="px-4 py-3 font-bold text-slate-900 dark:text-white"><?= number_format($item['cantidad'], 2) ?></td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400"><?= $item['descripcion'] ?></td>
                            <td class="px-4 py-3 text-slate-600 dark:text-slate-400">S/ <?= number_format($item['precio'], 2) ?></td>
                            <td class="px-4 py-3 font-bold text-slate-900 dark:text-white text-right">S/ <?= number_format($item['importe'], 2) ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 font-bold text-sm">
                        <td colspan="3" class="px-4 py-3 text-right text-slate-500 uppercase">Total Venta</td>
                        <td class="px-4 py-3 text-right text-primary text-lg">S/ <?= number_format($venta['total'], 2) ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>