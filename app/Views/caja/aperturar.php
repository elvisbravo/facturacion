<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="p-4 lg:p-8 space-y-8">
    <!-- Page Header Actions -->
    <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6">
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-3">
                <span
                    class="inline-flex items-center rounded-full bg-emerald-100 dark:bg-emerald-900/30 px-2.5 py-0.5 text-xs font-bold text-emerald-800 dark:text-emerald-400 uppercase tracking-tighter">
                    <span class="mr-1.5 h-2 w-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    Caja Abierta
                </span>
                <h1 class="text-3xl font-bold tracking-tight">
                    Gestión de Caja Diaria
                </h1>
            </div>
            <p class="text-slate-500 dark:text-slate-400 font-medium">
                Fecha: 25 Feb, 2026 | Responsable:
                <span class="text-slate-900 dark:text-slate-200 font-bold">Jorge Pérez</span>
            </p>
        </div>
        <div class="flex gap-3 w-full md:w-auto">
            <button
                class="flex-1 md:flex-none flex items-center justify-center gap-2 rounded-xl h-12 px-6 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-slate-100 text-base font-bold hover:bg-slate-50 dark:hover:bg-slate-700 transition-all">
                <span class="material-symbols-outlined">lock_open</span>
                Apertura
            </button>
            <button
                class="flex-1 md:flex-none flex items-center justify-center gap-2 rounded-xl h-12 px-6 bg-primary text-slate-900 text-base font-bold hover:shadow-lg hover:shadow-primary/30 transition-all">
                <span class="material-symbols-outlined">lock</span>
                Cerrar Caja
            </button>
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
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-5 font-bold flex items-center gap-3">
                            <div
                                class="size-8 rounded-lg bg-orange-100 dark:bg-orange-900/20 flex items-center justify-center text-orange-600">
                                <span class="material-symbols-outlined">payments</span>
                            </div>
                            Efectivo
                        </td>
                        <td class="px-6 py-5 text-right font-medium">
                            S/ 500.00
                        </td>
                        <td class="px-6 py-5 text-right text-emerald-500 font-bold">
                            + S/ 1,200.00
                        </td>
                        <td class="px-6 py-5 text-right text-rose-500 font-bold">
                            - S/ 150.00
                        </td>
                        <td class="px-6 py-5 text-right font-bold text-slate-900 dark:text-white">
                            S/ 1,550.00
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-5 font-bold flex items-center gap-3">
                            <div
                                class="size-8 rounded-lg bg-blue-100 dark:bg-blue-900/20 flex items-center justify-center text-blue-600">
                                <span class="material-symbols-outlined">credit_card</span>
                            </div>
                            Visa / Mastercard
                        </td>
                        <td class="px-6 py-5 text-right font-medium">S/ 0.00</td>
                        <td class="px-6 py-5 text-right text-emerald-500 font-bold">
                            + S/ 2,450.00
                        </td>
                        <td class="px-6 py-5 text-right text-rose-500 font-bold">
                            - S/ 0.00
                        </td>
                        <td class="px-6 py-5 text-right font-bold text-slate-900 dark:text-white">
                            S/ 2,450.00
                        </td>
                    </tr>
                    <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                        <td class="px-6 py-5 font-bold flex items-center gap-3">
                            <div class="size-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary">
                                <span class="material-symbols-outlined">smartphone</span>
                            </div>
                            Yape
                        </td>
                        <td class="px-6 py-5 text-right font-medium">S/ 0.00</td>
                        <td class="px-6 py-5 text-right text-emerald-500 font-bold">
                            + S/ 850.00
                        </td>
                        <td class="px-6 py-5 text-right text-rose-500 font-bold">
                            - S/ 0.00
                        </td>
                        <td class="px-6 py-5 text-right font-bold text-slate-900 dark:text-white">
                            S/ 850.00
                        </td>
                    </tr>
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
                S/ 4,900.00
            </p>
            <p class="text-emerald-500 text-[10px] font-bold flex items-center gap-1">
                <span class="material-symbols-outlined text-xs">arrow_upward</span>
                +12.5% vs ayer
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
                S/ 200.00
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
                S/ 5,200.00
            </p>
            <p class="text-slate-900/70 text-[10px] font-bold uppercase relative z-10">
                Saldo real disponible
            </p>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <h4 class="text-sm font-bold text-slate-900 dark:text-white uppercase tracking-widest">
                Últimos Movimientos
            </h4>
            <button class="text-primary text-xs font-bold hover:underline uppercase tracking-tighter">
                Ver historial completo
            </button>
        </div>
        <div class="space-y-3">
            <div
                class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-100 dark:border-slate-800 flex items-center justify-between hover:border-primary/30 transition-colors">
                <div class="flex items-center gap-4">
                    <div
                        class="bg-emerald-100 dark:bg-emerald-900/30 size-10 rounded-lg flex items-center justify-center text-emerald-600">
                        <span class="material-symbols-outlined">add_shopping_cart</span>
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white text-sm">
                            Venta #1042 - Ticket
                        </p>
                        <p class="text-slate-500 text-[10px] font-medium">
                            Hace 15 min • Visa
                        </p>
                    </div>
                </div>
                <p class="font-bold text-emerald-500">S/ 245.00</p>
            </div>
            <div
                class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-100 dark:border-slate-800 flex items-center justify-between hover:border-rose-500/30 transition-colors">
                <div class="flex items-center gap-4">
                    <div
                        class="bg-rose-100 dark:bg-rose-900/30 size-10 rounded-lg flex items-center justify-center text-rose-600">
                        <span class="material-symbols-outlined">outbox</span>
                    </div>
                    <div>
                        <p class="font-bold text-slate-900 dark:text-white text-sm">
                            Pago de Servicios - Luz
                        </p>
                        <p class="text-slate-500 text-[10px] font-medium">
                            Hace 45 min • Efectivo
                        </p>
                    </div>
                </div>
                <p class="font-bold text-rose-500">- S/ 150.00</p>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>