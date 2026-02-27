<a
    class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary text-white font-medium shadow-md shadow-primary/20"
    href="<?= base_url('dashboard') ?>">
    <span class="material-symbols-outlined">dashboard</span>
    <span>Dashboard</span>
</a>
<a
    class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
    href="<?= base_url('ventas') ?>">
    <span class="material-symbols-outlined">receipt_long</span>
    <span>Ventas</span>
</a>
<a
    class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
    href="<?= base_url('productos') ?>">
    <span class="material-symbols-outlined">inventory_2</span>
    <span>Inventario</span>
</a>
<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
    href="<?= base_url('categorias') ?>">
    <span class="material-symbols-outlined">category</span>
    <span>Categorías</span>
</a>
<?php $cajaAbierta = getCajaAbierta(); ?>
<?php if ($cajaAbierta): ?>
    <button onclick="confirmarCerrarCaja()"
        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
        <span class="material-symbols-outlined text-rose-500">lock</span>
        <span>Cerrar Caja</span>
    </button>
<?php else: ?>
    <button onclick="abrirModalApertura()"
        class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-emerald-600 dark:text-emerald-400 hover:bg-emerald-50 dark:hover:bg-emerald-900/20 transition-colors">
        <span class="material-symbols-outlined text-emerald-500">lock_open</span>
        <span>Abrir Caja</span>
    </button>
<?php endif; ?>

<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
    href="<?= base_url('caja-aperturar') ?>">
    <span class="material-symbols-outlined">account_balance_wallet</span>
    <span>Gestionar Caja</span>
</a>

<a
    class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
    href="#">
    <span class="material-symbols-outlined">bar_chart</span>
    <span>Reportes</span>
</a>
<div
    class="pt-4 pb-2 border-t border-slate-200 dark:border-slate-800 mt-4">
    <p
        class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-widest">
        Sistema
    </p>
</div>
<a
    class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
    href="#">
    <span class="material-symbols-outlined">settings</span>
    <span>Configuración</span>
</a>