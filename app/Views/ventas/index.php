<?= $this->extend('layouts/main') ?>
<?= $this->section('content') ?>
<div class="p-4 lg:p-8 space-y-6">
    <!-- Page Header Actions -->
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold tracking-tight">
                Gestión de Ventas
            </h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">
                Consulta y administra todos los comprobantes emitidos.
            </p>
        </div>
        <div class="flex items-center gap-2">
            <button
                class="flex items-center gap-2 px-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-lg text-sm font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                <span class="material-symbols-outlined text-lg">ios_share</span>
                Exportar
            </button>
            <a href="<?= base_url('pos') ?>"
                class="flex items-center gap-2 px-4 py-2 bg-primary text-slate-900 rounded-lg text-sm font-bold hover:shadow-lg hover:shadow-primary/30 transition-all">
                <span class="material-symbols-outlined text-lg">add_shopping_cart</span>
                Nueva Venta
            </a>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ventas de Hoy</span>
                <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                    <span class="material-symbols-outlined text-xl">payments</span>
                </div>
            </div>
            <h3 class="text-2xl font-bold">S/ 4,280.50</h3>
            <p class="text-[10px] text-emerald-500 font-bold mt-1">
                +12.5% vs ayer
            </p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Comprobantes</span>
                <div class="size-8 rounded-lg bg-blue-500/10 flex items-center justify-center text-blue-500">
                    <span class="material-symbols-outlined text-xl">description</span>
                </div>
            </div>
            <h3 class="text-2xl font-bold">124</h3>
            <p class="text-[10px] text-slate-400 font-bold mt-1">
                85 Facturas, 39 Boletas
            </p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Ticket Promedio</span>
                <div class="size-8 rounded-lg bg-purple-500/10 flex items-center justify-center text-purple-500">
                    <span class="material-symbols-outlined text-xl">analytics</span>
                </div>
            </div>
            <h3 class="text-2xl font-bold">S/ 34.50</h3>
            <p class="text-[10px] text-rose-500 font-bold mt-1">
                -2.1% vs ayer
            </p>
        </div>
        <div
            class="bg-white dark:bg-slate-900 p-6 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500 uppercase tracking-wider">Pendientes SUNAT</span>
                <div class="size-8 rounded-lg bg-orange-500/10 flex items-center justify-center text-orange-500">
                    <span class="material-symbols-outlined text-xl">cloud_sync</span>
                </div>
            </div>
            <h3 class="text-2xl font-bold">02</h3>
            <p class="text-[10px] text-orange-500 font-bold mt-1">
                Requieren atención
            </p>
        </div>
    </div>

    <!-- Main Table Section -->
    <div
        class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden flex flex-col">
        <!-- Table Controls -->
        <div
            class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row md:items-center justify-between gap-4 bg-slate-50/50 dark:bg-slate-900/50">
            <div class="flex items-center gap-4">
                <div class="flex items-center gap-2 text-xs font-bold text-slate-500">
                    <span>MOSTRAR</span>
                    <select
                        class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-800 rounded-lg text-xs py-1 px-2 focus:ring-primary outline-none">
                        <option>10</option>
                        <option>25</option>
                        <option>50</option>
                    </select>
                </div>
                <div class="h-4 w-px bg-slate-200 dark:bg-slate-700 hidden md:block"></div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Desde</span>
                        <input type="date"
                            class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-800 rounded-lg text-xs py-1 px-2 focus:ring-primary outline-none transition-all" />
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-[10px] font-bold text-slate-400 uppercase tracking-tighter">Hasta</span>
                        <input type="date"
                            class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-800 rounded-lg text-xs py-1 px-2 focus:ring-primary outline-none transition-all" />
                    </div>
                    <select
                        class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-800 rounded-lg text-xs py-1 px-2 focus:ring-primary outline-none">
                        <option>Todos los Estados</option>
                        <option>Aceptado</option>
                        <option>Pendiente</option>
                        <option>Rechazado</option>
                    </select>
                </div>
            </div>
            <div class="relative w-full md:w-72">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">search</span>
                <input type="text" placeholder="Buscar por cliente, documento o correlativo..."
                    class="w-full pl-10 pr-4 py-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-800 rounded-xl text-xs focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none transition-all" />
            </div>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr
                        class="bg-slate-50 dark:bg-slate-800/50 text-[10px] font-bold text-slate-500 uppercase tracking-widest text-sm">
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Fecha / Hora
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Comprobante
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Cliente
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Total
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800">
                            Estado SUNAT
                        </th>
                        <th class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 text-right">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-sm">
                            <p class="font-bold text-slate-900 dark:text-white">
                                25 Feb, 2026
                            </p>
                            <p class="text-[10px] text-slate-500">07:04 AM</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-sm">
                            <span
                                class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-blue-100 dark:bg-blue-900/30 text-blue-600 dark:text-blue-400 uppercase tracking-tighter">Factura</span>
                            <p class="font-bold mt-1 text-slate-700 dark:text-slate-300">
                                F001-0000156
                            </p>
                        </td>
                        <td class="px-6 py-4 font-medium text-sm">
                            <p class="font-bold text-slate-900 dark:text-white">
                                Inversiones Tech S.A.C.
                            </p>
                            <p class="text-[10px] text-slate-500">
                                RUC: 20601234567
                            </p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-900 dark:text-white">
                                S/ 1,280.00
                            </p>
                        </td>
                        <td class="px-6 py-4 font-medium text-sm">
                            <div class="flex items-center gap-1.5 text-emerald-500 font-bold text-[10px] uppercase">
                                <span class="size-2 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50"></span>
                                Aceptado
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 text-sm font-medium">
                                <button
                                    class="p-2 text-slate-400 hover:text-primary transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </button>
                                <button
                                    class="p-2 text-slate-400 hover:text-blue-500 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">print</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/80 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-4 font-medium text-sm">
                            <p class="font-bold text-slate-900 dark:text-white">
                                25 Feb, 2026
                            </p>
                            <p class="text-[10px] text-slate-500">06:45 AM</p>
                        </td>
                        <td class="px-6 py-4 font-medium text-sm">
                            <span
                                class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 uppercase tracking-tighter">Boleta</span>
                            <p class="font-bold mt-1 text-slate-700 dark:text-slate-300">
                                B001-0004281
                            </p>
                        </td>
                        <td class="px-6 py-4 font-medium text-sm">
                            <p class="font-bold text-slate-900 dark:text-white">
                                Juan Carlos Lopez
                            </p>
                            <p class="text-[10px] text-slate-500">DNI: 45678912</p>
                        </td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-bold text-slate-900 dark:text-white">
                                S/ 45.50
                            </p>
                        </td>
                        <td class="px-6 py-4 font-medium text-sm">
                            <div class="flex items-center gap-1.5 text-emerald-500 font-bold text-[10px] uppercase">
                                <span class="size-2 rounded-full bg-emerald-500 shadow-lg shadow-emerald-500/50"></span>
                                Aceptado
                            </div>
                        </td>
                        <td class="px-6 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 text-sm font-medium">
                                <button
                                    class="p-2 text-slate-400 hover:text-primary transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">visibility</span>
                                </button>
                                <button
                                    class="p-2 text-slate-400 hover:text-blue-500 transition-colors hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                                    <span class="material-symbols-outlined text-lg">print</span>
                                </button>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?= $this->endSection() ?>