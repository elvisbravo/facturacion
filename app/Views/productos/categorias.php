<?= $this->extend('layouts/main') ?>

<?= $this->section('css') ?>
<style>
    /* DataTables Basic Styling */
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_length {
        display: none;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        border-bottom: 2px solid #e2e8f0 !important;
        /* slate-200 */
    }

    .dark table.dataTable thead th {
        border-bottom: 2px solid #1e293b !important;
        /* slate-800 */
    }

    table.dataTable.no-footer {
        border-bottom: none !important;
    }

    /* DataTables Footer Styling (Info & Paginate) */
    .dt-custom-footer {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        padding: 1.5rem 2rem !important;
        border-top: 1px solid #e2e8f0 !important;
        /* slate-200 */
        background: #f8fafc !important;
        /* slate-50 */
    }

    .dark .dt-custom-footer {
        border-top-color: #1e293b !important;
        /* slate-800 */
        background: #0f172a !important;
        /* slate-900 */
    }

    .dataTables_wrapper .dataTables_info {
        display: block !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        color: #64748b !important;
        /* slate-500 */
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    .dark .dataTables_wrapper .dataTables_info {
        color: #94a3b8 !important;
    }

    .dataTables_wrapper .dataTables_paginate {
        display: flex !important;
        align-items: center !important;
        gap: 0.5rem !important;
    }

    /* Important: Spacing between numbers inside the span */
    .dataTables_wrapper .dataTables_paginate span {
        display: flex !important;
        gap: 0.25rem !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        min-width: 2.5rem !important;
        height: 2.5rem !important;
        padding: 0 0.75rem !important;
        margin: 0 !important;
        border-radius: 0.75rem !important;
        border: 1px solid #e2e8f0 !important;
        /* slate-200 */
        background: white !important;
        color: #64748b !important;
        /* slate-500 */
        font-size: 0.8125rem !important;
        font-weight: 600 !important;
        cursor: pointer !important;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1) !important;
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05) !important;
    }

    .dark .dataTables_wrapper .dataTables_paginate .paginate_button {
        border-color: #1e293b !important;
        background: #0f172a !important;
        color: #94a3b8 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) {
        background: #f8fafc !important;
        color: #0f172a !important;
        border-color: #cbd5e1 !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1) !important;
    }

    .dark .dataTables_wrapper .dataTables_paginate .paginate_button:hover:not(.current):not(.disabled) {
        background: #1e293b !important;
        color: white !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.current,
    .dataTables_wrapper .dataTables_paginate .paginate_button.current:hover {
        background: #13ec49 !important;
        /* primary */
        color: #064e17 !important;
        border-color: #13ec49 !important;
        font-weight: 800 !important;
        box-shadow: 0 10px 15px -3px rgba(19, 236, 73, 0.25) !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        padding: 0 1.25rem !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        font-size: 0.7rem !important;
        letter-spacing: 0.05em !important;
        background: #f8fafc !important;
        /* slate-50 */
        border-color: #e2e8f0 !important;
        white-space: nowrap !important;
    }

    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        background: #1e293b !important;
        /* slate-800 */
        border-color: #334155 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover:not(.disabled),
    .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover:not(.disabled) {
        background: white !important;
        border-color: #13ec49 !important;
        color: #13ec49 !important;
    }

    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.previous:hover:not(.disabled),
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.next:hover:not(.disabled) {
        background: #0f172a !important;
        border-color: #13ec49 !important;
        color: #13ec49 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.4 !important;
        cursor: not-allowed !important;
        background: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
        box-shadow: none !important;
        transform: none !important;
        color: #94a3b8 !important;
    }

    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        background: #0f172a !important;
        /* slate-900 */
        border-color: #1e293b !important;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="px-8 py-6 flex flex-col gap-6">
    <div class="flex justify-between items-end">
        <div>
            <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
                <a class="hover:text-primary transition-colors" href="#">Home</a>
                <span class="material-symbols-outlined text-xs leading-none">chevron_right</span>
                <span class="text-slate-900 dark:text-slate-300 font-medium">Categorías</span>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">
                Gestión de Categorías
            </h2>
        </div>
        <div class="flex gap-3">
            <button id="openCategoryModalBtn"
                class="flex items-center gap-2 px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-shadow shadow-lg shadow-primary/20 text-sm">
                <span class="material-symbols-outlined text-lg leading-none">add_circle</span>
                Registrar Nueva Categoría
            </button>
        </div>
    </div>
    <!-- Stats Summary -->
    <!--<div class="grid grid-cols-4 gap-4">
        <div
            class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
            <p class="text-slate-500 text-sm font-medium mb-1">
                Total Categorías
            </p>
            <p class="text-2xl font-bold text-slate-900 dark:text-white">
                24
            </p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
            <p class="text-slate-500 text-sm font-medium mb-1">
                Categorías Activas
            </p>
            <p class="text-2xl font-bold text-emerald-500">22</p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
            <p class="text-slate-500 text-sm font-medium mb-1">
                Categorías Inactivas
            </p>
            <p class="text-2xl font-bold text-rose-500">2</p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
            <p class="text-slate-500 text-sm font-medium mb-1">
                Productos Asociados
            </p>
            <p class="text-2xl font-bold text-primary">1,284</p>
        </div>
    </div>-->
    <!-- Data Table Container -->
    <div
        class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 flex flex-col overflow-hidden">
        <!-- Table Search & Sort Controls -->
        <div
            class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-xs font-medium text-slate-500">
                    <span>Mostrar</span>
                    <select id="tableLength"
                        class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-xs py-1 px-2 focus:ring-primary focus:border-primary outline-none cursor-pointer">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>registros</span>
                </div>
            </div>

            <div class="relative w-full md:w-64">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input id="tableSearch" type="text" placeholder="Buscar categoría..."
                    class="w-full pl-9 pr-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" />
            </div>
        </div>
        <!-- High Density Table -->
        <div class="overflow-x-auto">
            <table id="categoriesTable" class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            #
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            Nombre
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            Descripción
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            Productos
                        </th>
                        <th
                            class="px-6 py-3 border-b border-slate-200 dark:border-slate-800 text-right">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Data will be loaded via Ajax -->
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <!-- DataTables footer will be injected here automatically by the 'dom' property -->
    </div>
</div>

<div id="categoryModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4 sm:p-6">
    <div id="modalOverlay" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    <div
        class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <h3 id="categoryModalTitle" class="text-xl font-bold text-slate-900 dark:text-white">
                Registrar Nueva Categoría
            </h3>
            <button id="closeCategoryModalBtn"
                class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form class="space-y-6" id="formCategoria">
            <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">

                <div class="space-y-4">
                    <div class="space-y-1.5">
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-tight">Nombre de la
                            Categoría</label>
                        <input id="cat_nombre"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary px-4 py-2"
                            name="nombre_categoria"
                            placeholder="Ej. Electrónica" type="text" />
                    </div>
                    <div class="space-y-1.5">
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-tight">Descripción</label>
                        <textarea id="cat_descripcion" name="descripcion"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary px-4 py-2 min-h-[100px]"
                            placeholder="Descripción breve de la categoría..."></textarea>
                    </div>
                    <input type="hidden" id="id_cat" name="id" value="0">
                </div>

            </div>
            <div
                class="px-6 py-4 border-t border-slate-200 dark:border-slate-800 flex justify-end items-center gap-3 bg-slate-50 dark:bg-slate-900/50">
                <button id="cancelCategoryModalBtn"
                    class="px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                    Cancelar
                </button>
                <button type="submit"
                    class="px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-shadow shadow-lg shadow-primary/20 text-sm">
                    Guardar Categoría
                </button>
            </div>
        </form>
    </div>
</div>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="<?= base_url('js/productos/categorias.js') ?>"></script>
<?= $this->endSection() ?>