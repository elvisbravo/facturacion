<?= $this->extend('layouts/main') ?>

<?= $this->section('css') ?>
<style>
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        display: none;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        border-bottom: 2px solid #e2e8f0 !important;
    }

    .dark table.dataTable thead th {
        border-bottom: 2px solid #1e293b !important;
    }

    .dt-custom-footer {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 1.5rem 2rem !important;
        border-top: 1px solid #e2e8f0 !important;
        background: #f8fafc !important;
    }

    .dark .dt-custom-footer {
        border-top-color: #1e293b !important;
        background: #0f172a !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="px-8 py-6 flex flex-col gap-6">
    <div class="flex justify-between items-end">
        <div>
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
                <a class="hover:text-primary transition-colors" href="<?= base_url('dashboard') ?>">Home</a>
                <span class="material-symbols-outlined text-xs leading-none">chevron_right</span>
                <span class="text-slate-900 dark:text-slate-300 font-medium">Gestión de Almacenes</span>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">
                Almacenes
            </h2>
        </div>
        <div>
            <button id="openAlmacenModalBtn"
                class="flex items-center gap-2 px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-shadow shadow-lg shadow-primary/20 text-sm">
                <span class="material-symbols-outlined text-lg leading-none">add_home</span>
                Registrar Nuevo Almacén
            </button>
        </div>
    </div>

    <!-- Data Table Container -->
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    <span>Mostrar</span>
                    <select id="tableLength" class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-xs py-1 px-2 outline-none">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                    </select>
                    <span>registros</span>
                </div>
            </div>
            <div class="relative w-full md:w-64">
                <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input type="text" id="tableSearch" placeholder="Buscar almacén..."
                    class="w-full pl-9 pr-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 outline-none" />
            </div>
        </div>

        <div class="overflow-x-auto">
            <table id="almacenTable" class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">#</th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">Nombre</th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">Sede / Sucursal</th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Loaded via Ajax -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Almacén -->
<div id="almacenModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4 sm:p-6">
    <div id="modalOverlay" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-xl shadow-2xl flex flex-col overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <h3 id="almacenModalTitle" class="text-xl font-bold text-slate-900 dark:text-white">Registrar Nuevo Almacén</h3>
            <button id="closeAlmacenModalBtn" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6">
            <form id="formAlmacen" class="space-y-4">
                <input type="hidden" id="almacen_id" name="id" value="0">

                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">Nombre del Almacén</label>
                    <input id="almacen_nombre" name="nombre" type="text" required placeholder="Ej: Almacén Central"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2.5 px-3 focus:ring-primary outline-none" />
                </div>

                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">Sucursal a la que pertenece</label>
                    <select id="almacen_sucursal" name="sucursal_id" required
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2.5 px-3 focus:ring-primary outline-none">
                        <option value="">Seleccionar Sucursal</option>
                        <?php foreach ($sucursales as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </form>
        </div>
        <div class="px-6 py-4 border-t border-slate-200 dark:border-slate-800 flex justify-end items-center gap-3 bg-slate-50 dark:bg-slate-900/50">
            <button id="cancelAlmacenModalBtn" class="px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">Cancelar</button>
            <button type="submit" form="formAlmacen" class="px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-shadow shadow-lg shadow-primary/20 text-sm">Guardar Almacén</button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('js/almacen/lista.js') ?>"></script>
<?= $this->endSection() ?>