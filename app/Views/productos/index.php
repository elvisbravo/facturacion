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
    }

    .dark table.dataTable thead th {
        border-bottom: 2px solid #1e293b !important;
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
        background: #f8fafc !important;
    }

    .dark .dt-custom-footer {
        border-top-color: #1e293b !important;
        background: #0f172a !important;
    }

    .dataTables_wrapper .dataTables_info {
        display: block !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        color: #64748b !important;
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
        background: white !important;
        color: #64748b !important;
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

    .dataTables_wrapper .dataTables_paginate .paginate_button.current {
        background: #13ec49 !important;
        color: #064e17 !important;
        border-color: #13ec49 !important;
        font-weight: 800 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        padding: 0 1.25rem !important;
        font-weight: 800 !important;
        text-transform: uppercase !important;
        font-size: 0.7rem !important;
        letter-spacing: 0.05em !important;
        background: #f8fafc !important;
        border-color: #e2e8f0 !important;
    }

    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.previous,
    .dark .dataTables_wrapper .dataTables_paginate .paginate_button.next {
        background: #1e293b !important;
        border-color: #334155 !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button.disabled {
        opacity: 0.4 !important;
        cursor: not-allowed !important;
    }
</style>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Select2 Dark Mode Fixes */
    .select2-container--default .select2-selection--single {
        background-color: transparent !important;
        border-color: #e2e8f0 !important;
        height: 42px !important;
        display: flex !important;
        align-items: center !important;
        border-radius: 0.5rem !important;
        font-size: 0.875rem !important;
    }

    .dark .select2-container--default .select2-selection--single {
        border-color: #1e293b !important;
        color: white !important;
    }

    .dark .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #f1f5f9 !important;
    }

    .select2-dropdown {
        background-color: white !important;
        border-color: #e2e8f0 !important;
    }

    .dark .select2-dropdown {
        background-color: #0f172a !important;
        border-color: #1e293b !important;
        color: white !important;
    }

    .dark .select2-results__option--selectable {
        color: #94a3b8 !important;
    }

    .dark .select2-results__option--highlighted[aria-selected] {
        background-color: #13ec49 !important;
        color: #064e17 !important;
    }

    .select2-search__field {
        background-color: transparent !important;
    }

    .select2-container {
        width: 100% !important;
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
                <span class="text-slate-900 dark:text-slate-300 font-medium">Inventory Management</span>
            </div>
            <h2 class="text-3xl font-bold text-slate-900 dark:text-white">
                Inventory Overview
            </h2>
        </div>
        <div class="flex gap-3">
            <button
                class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-sm">
                <span class="material-symbols-outlined text-lg leading-none">filter_list</span>
                Advanced Filters
            </button>
            <button
                class="flex items-center gap-2 px-4 py-2 border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200 font-semibold rounded-lg hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-sm">
                <span class="material-symbols-outlined text-lg leading-none">download</span>
                Export CSV
            </button>
            <button id="openProductModalBtn"
                class="flex items-center gap-2 px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-shadow shadow-lg shadow-primary/20 text-sm">
                <span class="material-symbols-outlined text-lg leading-none">add_circle</span>
                Registar Nuevo Producto
            </button>
        </div>
    </div>
    <!-- Stats Summary -->
    <!--<div class="grid grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
            <p class="text-slate-500 text-sm font-medium mb-1">
                Total Products
            </p>
            <p class="text-2xl font-bold text-slate-900 dark:text-white">
                1,284
            </p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
            <p class="text-slate-500 text-sm font-medium mb-1">
                Low Stock Alerts
            </p>
            <p class="text-2xl font-bold text-amber-500">12</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
            <p class="text-slate-500 text-sm font-medium mb-1">
                Out of Stock
            </p>
            <p class="text-2xl font-bold text-rose-500">3</p>
        </div>
        <div class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800">
            <p class="text-slate-500 text-sm font-medium mb-1">
                Inventory Value
            </p>
            <p class="text-2xl font-bold text-emerald-500">$42,904.50</p>
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
                        class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-xs py-1 px-2 focus:ring-primary focus:border-primary outline-none">
                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span>registros</span>
                </div>

                <div class="h-4 w-px bg-slate-300 dark:bg-slate-700 hidden md:block"></div>

                <div class="flex gap-2">
                    <select id="categoryFilter"
                        class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-xs py-1.5 focus:ring-primary focus:border-primary outline-none px-2">
                        <option value="">Todas las Categorías</option>
                        <!-- Categories will be loaded here -->
                    </select>
                </div>
            </div>

            <div class="relative w-full md:w-64">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input type="text" id="tableSearch" placeholder="Buscar producto..."
                    class="w-full pl-9 pr-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-lg text-xs focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" />
            </div>
        </div>
        <!-- High Density Table -->
        <div class="overflow-x-auto">
            <table id="productsTable" class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            #
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            Imagen
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            Nombre
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            Unidad
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            Costo
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800 text-center">
                            Precio Venta
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800">
                            Stock
                        </th>
                        <th class="px-6 py-3 border-b border-slate-200 dark:border-slate-800 text-right">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <!-- Loaded via Ajax -->
                </tbody>
            </table>
        </div>
        <!-- Pagination -->
        <!-- DataTables footer injected here -->
    </div>
</div>


<div id="productModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4 sm:p-6">
    <div id="modalOverlay" class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    <div
        class="relative w-full max-w-4xl bg-white dark:bg-slate-900 rounded-xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
            <h3 id="productModalTitle" class="text-xl font-bold text-slate-900 dark:text-white">
                Register New Product
            </h3>
            <button id="closeProductModalBtn"
                class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
            <form id="formProducto" class="space-y-6">
                <input type="hidden" id="id_prod" name="id" value="0">

                <!-- General Info Section -->
                <div class="space-y-4">
                    <h4 class="text-sm font-bold text-primary uppercase tracking-wider flex items-center gap-2">
                        <span class="material-symbols-outlined text-base">inventory_2</span>
                        Información General
                    </h4>
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- Code with Generate Button -->
                        <div class="md:col-span-4 space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">Código / SKU</label>
                            <div class="flex gap-1">
                                <input id="prod_sku" name="sku" type="text"
                                    class="flex-1 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2.5 px-3 focus:ring-primary focus:border-primary outline-none transition-all"
                                    placeholder="CÓDIGO123" required />
                                <button type="button" id="btnGenerateCode"
                                    class="px-2 bg-slate-100 dark:bg-slate-700 text-slate-600 dark:text-slate-300 rounded-lg hover:bg-primary hover:text-white transition-colors border border-slate-200 dark:border-slate-600"
                                    title="Generar código automático">
                                    <span class="material-symbols-outlined text-sm">magic_button</span>
                                </button>
                            </div>
                        </div>
                        <!-- Product Name -->
                        <div class="md:col-span-8 space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">Nombre del Producto</label>
                            <input id="prod_nombre" name="nombre" type="text"
                                class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2.5 px-3 focus:ring-primary focus:border-primary outline-none transition-all"
                                placeholder="Nombre completo del producto..." required />
                        </div>
                    </div>
                </div>

                <div class="h-px bg-slate-100 dark:bg-slate-800"></div>

                <!-- classification & specs -->
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <!-- Category -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase">Categoría</label>
                        <select id="prod_categoria" name="categoria_id" required
                            class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2.5 px-3 focus:ring-primary focus:border-primary outline-none transition-all">
                            <option value="">Seleccionar Categoría</option>
                        </select>
                    </div>
                    <!-- Unit of Measure (Searchable) -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase">Unidad de Medida</label>
                        <select id="prod_unidad_medida" name="unidad_medida" required
                            class="select2-search w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2.5 px-3 focus:ring-primary focus:border-primary outline-none transition-all">
                            <option value="NIU">UNIDADES</option>
                            <option value="KGM">KILOGRAMOS</option>
                            <option value="GLL">GALONES</option>
                            <option value="LTR">LITROS</option>
                            <option value="MTR">METROS</option>
                            <option value="FOT">PIES</option>
                        </select>
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase">Almacén</label>
                        <select id="prod_almacen" name="almacen"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2.5 px-3 focus:ring-primary focus:border-primary outline-none transition-all">
                            <option value="Almacén Central">Almacén Central</option>
                            <option value="Almacén Secundario">Almacén Secundario</option>
                            <option value="Oficina Principal">Oficina Principal</option>
                        </select>
                    </div>
                    <!-- Money -->
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase">Moneda</label>
                        <div class="flex gap-4 items-center h-10">
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="moneda" value="PEN" checked
                                    class="w-4 h-4 text-primary bg-slate-100 border-slate-300 focus:ring-primary focus:ring-2" />
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">Soles</span>
                            </label>
                            <label class="flex items-center gap-2 cursor-pointer group">
                                <input type="radio" name="moneda" value="USD"
                                    class="w-4 h-4 text-primary bg-slate-100 border-slate-300 focus:ring-primary focus:ring-2" />
                                <span class="text-sm font-medium text-slate-700 dark:text-slate-300 group-hover:text-primary transition-colors">Dólares</span>
                            </label>
                        </div>
                    </div>
                </div>

                <!-- Tax & Price Section -->
                <div class="bg-slate-50 dark:bg-slate-800/30 p-4 rounded-xl space-y-4 border border-slate-100 dark:border-slate-800">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                        <!-- IGV Type -->
                        <div class="md:col-span-5 space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">Tipo de IGV</label>
                            <select id="prod_tipo_igv" name="tipo_igv"
                                class="w-full bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2 px-3 focus:ring-primary focus:border-primary outline-none">
                                <option value="10">Gravado - Operación Onerosa</option>
                                <option value="20">Exonerado - Operación Onerosa</option>
                                <option value="30">Inafecto - Operación Onerosa</option>
                                <option value="17">Gravado - IVAP</option>
                            </select>
                        </div>
                        <!-- Afecto a ICBPER -->
                        <div class="md:col-span-7 space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">¿Afecto a ICBPER?</label>
                            <div class="flex gap-4 items-center h-10">
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="afecto_icbper" value="0" checked
                                        class="w-4 h-4 text-primary bg-white border-slate-300 focus:ring-primary" />
                                    <span class="text-sm font-medium">No</span>
                                </label>
                                <label class="flex items-center gap-2 cursor-pointer">
                                    <input type="radio" name="afecto_icbper" value="1"
                                        class="w-4 h-4 text-primary bg-white border-slate-300 focus:ring-primary" />
                                    <span class="text-sm font-medium">Sí (Impuesto Bolsa)</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Purchase Price -->
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">P. Compra</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] font-bold">COSTO</span>
                                <input id="prod_precio_compra" name="precio_compra" type="number" step="0.01"
                                    class="w-full pl-14 pr-3 py-2.5 bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none"
                                    placeholder="0.00" />
                            </div>
                        </div>
                        <!-- Sales Inc IGV -->
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-primary uppercase">P. Venta (Incl. IGV)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] font-bold">TOTAL</span>
                                <input id="prod_precio_venta_con_igv" name="precio_venta_con_igv" type="number" step="0.01"
                                    class="w-full pl-14 pr-3 py-2.5 bg-white dark:bg-slate-800 border-primary/30 dark:border-primary/20 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none font-bold"
                                    placeholder="0.00" />
                            </div>
                        </div>
                        <!-- Sales Excl IGV -->
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">P. Venta (Sin IGV)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-[10px] font-bold">BASE</span>
                                <input id="prod_precio_venta_sin_igv" name="precio_venta_sin_igv" type="number" step="0.01"
                                    class="w-full pl-14 pr-3 py-2.5 bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none font-medium"
                                    placeholder="0.00" />
                            </div>
                        </div>
                        <!-- Weight -->
                        <div class="space-y-1.5">
                            <label class="block text-[11px] font-bold text-slate-500 uppercase">Peso (KG)</label>
                            <input id="prod_peso" name="peso" type="number" step="0.001"
                                class="w-full px-3 py-2.5 bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary outline-none"
                                placeholder="0.000" />
                        </div>
                    </div>
                </div>

                <!-- Stock Section -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-slate-500 uppercase">Stock Inicial</label>
                        <input id="prod_stock_inicial" name="stock_inicial" type="number"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm py-2.5 px-3 focus:ring-primary focus:border-primary outline-none font-semibold"
                            placeholder="0" />
                    </div>
                    <div class="space-y-1.5">
                        <label class="block text-[11px] font-bold text-rose-500 uppercase">Stock Mínimo</label>
                        <input id="prod_stock_minimo" name="stock_minimo" type="number"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-rose-200 dark:border-rose-900/50 rounded-lg text-sm py-2.5 px-3 focus:ring-rose-500 focus:border-rose-500 outline-none font-semibold"
                            placeholder="5" />
                    </div>
                    <div class="space-y-1.5 flex flex-col justify-end">
                        <button type="button" id="btnAddPresentations"
                            class="w-full px-4 py-2.5 bg-slate-900 dark:bg-white text-white dark:text-slate-900 text-sm font-bold rounded-lg hover:opacity-90 transition-all flex items-center justify-center gap-2">
                            <span class="material-symbols-outlined text-base">layers</span>
                            Agregar Presentaciones / Tamaños
                        </button>
                    </div>
                </div>

                <!-- Presentations List (Hidden by default, shown when button clicked) -->
                <div id="presentationsSection" class="hidden space-y-4 animate-in slide-in-from-top duration-300">
                    <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-2">
                        <h5 class="text-[11px] font-bold text-slate-400 uppercase tracking-widest">Presentaciones / Tamaños</h5>
                        <button type="button" id="btnNewPresentation" class="text-sm font-bold text-primary hover:underline">+ Nueva Fila</button>
                    </div>
                    <div class="overflow-hidden border border-slate-100 dark:border-slate-800 rounded-lg">
                        <table class="w-full text-left border-collapse text-xs">
                            <thead class="bg-slate-50 dark:bg-slate-800">
                                <tr>
                                    <th class="px-3 py-2">Nombre (Ej: Caja x12)</th>
                                    <th class="px-3 py-2 text-center">Factor</th>
                                    <th class="px-3 py-2">P. Venta</th>
                                    <th class="px-3 py-2">Código Barras</th>
                                    <th class="px-3 py-2 text-right"></th>
                                </tr>
                            </thead>
                            <tbody id="presentationsTableBody" class="divide-y divide-slate-50 dark:divide-slate-800">
                                <!-- Presentation rows will be added here -->
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="flex items-center gap-2 text-[10px] text-slate-400 uppercase font-bold">
                    <span class="material-symbols-outlined text-[12px]">store</span>
                    Sucursal: <input id="prod_sucursal" name="sucursal" type="text" value="Principal" class="bg-transparent border-none p-0 focus:ring-0 w-24">
                </div>
            </form>
        </div>
        <div
            class="px-6 py-4 border-t border-slate-200 dark:border-slate-800 flex justify-end items-center gap-3 bg-slate-50 dark:bg-slate-900/50">
            <button id="cancelProductModalBtn"
                class="px-4 py-2 text-sm font-semibold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg transition-colors">
                Cancelar
            </button>
            <button type="submit" form="formProducto"
                class="px-6 py-2 bg-primary text-white font-bold rounded-lg hover:bg-primary/90 transition-shadow shadow-lg shadow-primary/20 text-sm">
                Guardar Producto
            </button>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('js/productos/lista.js') ?>"></script>
<?= $this->endSection() ?>
```