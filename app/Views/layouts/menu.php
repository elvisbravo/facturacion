<?php
$uri = service('uri');
$active_segment = $uri->getSegment(1);

// Definimos una función helper para las clases del menú
function get_menu_class($segment, $active_segment)
{
    if ($segment === $active_segment) {
        return "flex items-center gap-3 px-3 py-2 rounded-lg bg-primary text-white font-medium shadow-md shadow-primary/20 active-menu-item";
    }
    return "flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors";
}
?>

<?php if (session()->get('rol_id') == 1): ?>
    <a class="<?= get_menu_class('dashboard', $active_segment) ?>" href="<?= base_url('dashboard') ?>">
        <span class="material-symbols-outlined">dashboard</span>
        <span>Dashboard</span>
    </a>
<?php endif; ?>
<a class="<?= get_menu_class('ventas', $active_segment) ?>" href="<?= base_url('ventas') ?>">
    <span class="material-symbols-outlined">receipt_long</span>
    <span>Ventas</span>
</a>
<?php if (session()->get('rol_id') == 1): ?>
    <a class="<?= get_menu_class('entradas', $active_segment) ?>" href="<?= base_url('entradas') ?>">
        <span class="material-symbols-outlined">confirmation_number</span>
        <span>Entradas</span>
    </a>
<?php endif; ?>
<a class="<?= get_menu_class('productos', $active_segment) ?>" href="<?= base_url('productos') ?>">
    <span class="material-symbols-outlined">inventory_2</span>
    <span>Inventario</span>
</a>
<a class="<?= get_menu_class('almacen', $active_segment) ?>" href="<?= base_url('almacen') ?>">
    <span class="material-symbols-outlined">warehouse</span>
    <span>Almacenes</span>
</a>
<a class="<?= get_menu_class('categorias', $active_segment) ?>" href="<?= base_url('categorias') ?>">
    <span class="material-symbols-outlined">category</span>
    <span>Categorías</span>
</a>
<a class="<?= get_menu_class('kardex', $active_segment) ?>" href="<?= base_url('kardex') ?>">
    <span class="material-symbols-outlined">history</span>
    <span>Kardex</span>
</a>

<a class="<?= get_menu_class('caja-aperturar', $active_segment) ?>" href="<?= base_url('caja-aperturar') ?>">
    <span class="material-symbols-outlined">account_balance_wallet</span>
    <span>Gestionar Caja</span>
</a>

<a class="<?= get_menu_class('reportes', $active_segment) ?>" href="<?= base_url('reportes/ventas') ?>">
    <span class="material-symbols-outlined">bar_chart</span>
    <span>Reporte Ventas</span>
</a>

<?php if (session()->get('rol_id') == 1): ?>
    <div class="pt-4 pb-2 border-t border-slate-200 dark:border-slate-800 mt-4">
        <p class="px-3 text-xs font-semibold text-slate-400 uppercase tracking-widest">Sistema</p>
    </div>

    <a class="<?= get_menu_class('usuarios', $active_segment) ?>" href="<?= base_url('usuarios') ?>">
        <span class="material-symbols-outlined">group</span>
        <span>Usuarios</span>
    </a>
    <a class="<?= get_menu_class('configuracion', $active_segment) ?>" href="<?= base_url('configuracion') ?>">
        <span class="material-symbols-outlined">settings</span>
        <span>Configuración</span>
    </a>
<?php endif; ?>

<a class="flex items-center gap-3 px-3 py-2 rounded-lg text-rose-600 dark:text-rose-400 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors"
    href="<?= base_url('auth/salir') ?>">
    <span class="material-symbols-outlined">logout</span>
    <span>Cerrar Sesión</span>
</a>