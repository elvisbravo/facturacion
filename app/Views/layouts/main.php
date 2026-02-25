<!doctype html>

<html lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Resumen - BravoFact</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;900&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#13ec49",
                        "background-light": "#f6f8f6",
                        "background-dark": "#102215",
                    },
                    fontFamily: {
                        display: ["Inter"],
                    },
                    borderRadius: {
                        DEFAULT: "0.25rem",
                        lg: "0.5rem",
                        xl: "0.75rem",
                        full: "9999px",
                    },
                },
            },
        };
    </script>
    <style>
        @media (max-width: 1024px) {
            .sidebar-mobile {
                position: fixed;
                left: -100%;
                top: 0;
                bottom: 0;
                z-index: 50;
                transition: all 0.3s ease;
            }

            .sidebar-mobile.active {
                left: 0;
            }
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark font-display text-slate-900 dark:text-slate-100">
    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar Navigation -->
        <aside
            id="sidebar"
            class="sidebar-mobile w-64 flex-shrink-0 bg-white dark:bg-slate-900 border-r border-slate-200 dark:border-slate-800 flex flex-col lg:static lg:translate-x-0">
            <div class="p-6 flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-lg bg-primary flex items-center justify-center text-white">
                    <span class="material-symbols-outlined">point_of_sale</span>
                </div>
                <div>
                    <h1
                        class="text-slate-900 dark:text-white font-bold text-lg leading-tight">
                        Bravo<span class="text-primary">Fact</span>
                    </h1>
                    <p
                        class="text-slate-500 dark:text-slate-400 text-[10px] uppercase tracking-widest font-bold">
                        Panel Administrativo
                    </p>
                </div>
            </div>
            <nav class="flex-1 px-4 space-y-1 mt-4">
                <a
                    class="flex items-center gap-3 px-3 py-2 rounded-lg bg-primary text-white font-medium shadow-md shadow-primary/20"
                    href="dashboard.html">
                    <span class="material-symbols-outlined">dashboard</span>
                    <span>Dashboard</span>
                </a>
                <a
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    href="venta.html">
                    <span class="material-symbols-outlined">receipt_long</span>
                    <span>Ventas</span>
                </a>
                <a
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    href="producto.html">
                    <span class="material-symbols-outlined">inventory_2</span>
                    <span>Inventario</span>
                </a>
                <a
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    href="caja.html">
                    <span class="material-symbols-outlined">account_balance_wallet</span>
                    <span>Caja</span>
                </a>
                <a
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors"
                    href="#">
                    <span class="material-symbols-outlined">description</span>
                    <span>Facturación</span>
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
            </nav>
            <div class="p-4 border-t border-slate-200 dark:border-slate-800">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-full bg-slate-200 dark:bg-slate-700 overflow-hidden">
                        <img
                            alt="Avatar"
                            data-alt="User profile picture avatar placeholder"
                            src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzhN3Z3RUxn_gtcwDnDGYEgT4yoA94fFihS80uGh4CCSuALfluZgQg31auRCEwYDr8mWd4mt09FKyQsONFbh38VqtHCejynsIfk5U8nP4l8x8GQGEkm7R0UcEQcyALOh6JZRas_K97DHF5pTwzhcssAIw4SSnJ6dl9qsPobt3WxCiTy4qNGBe9-L2mdtieRMMCqIj5ZfxeUvgk6v8-8nnI6keyyiFs3AdJmKza4glzjGQARywePFmtFy5m5CHkA0C3Q0DbhwJRrREn" />
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-semibold truncate">Admin User</p>
                        <p class="text-xs text-slate-500 truncate">admin@empresa.com</p>
                    </div>
                </div>
            </div>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 overflow-y-auto">
            <!-- Top Header -->
            <header
                class="sticky top-0 z-30 bg-white/80 dark:bg-slate-900/80 backdrop-blur-md border-b border-slate-200 dark:border-slate-800 px-4 lg:px-8 py-4 flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <button
                        onclick="toggleSidebar()"
                        class="p-2 -ml-2 rounded-lg text-slate-600 dark:text-slate-400 lg:hidden">
                        <span class="material-symbols-outlined">menu</span>
                    </button>
                    <h2 class="text-lg lg:text-xl font-bold tracking-tight">
                        Resumen de Operaciones
                    </h2>
                </div>
                <div class="flex items-center gap-3">
                    <button
                        class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 relative">
                        <span class="material-symbols-outlined">notifications</span>
                        <span
                            class="absolute top-2 right-2 w-2 h-2 bg-red-500 rounded-full border-2 border-white dark:border-slate-900"></span>
                    </button>
                    <div class="w-px h-6 bg-slate-300 dark:bg-slate-700"></div>
                    <div class="relative">
                        <button
                            id="userProfileBtn"
                            onclick="toggleUserMenu()"
                            class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 p-1 rounded-lg transition-colors focus:outline-none">
                            <div class="text-right hidden sm:block">
                                <p
                                    class="text-xs font-bold text-slate-900 dark:text-slate-100">
                                    Cajero Principal
                                </p>
                                <p
                                    class="text-[10px] text-primary font-bold uppercase tracking-wider">
                                    Perfil
                                </p>
                            </div>
                            <div
                                class="size-9 rounded-full bg-slate-200 dark:bg-slate-700 flex items-center justify-center overflow-hidden border-2 border-primary/20">
                                <img
                                    alt="Avatar"
                                    src="https://lh3.googleusercontent.com/aida-public/AB6AXuDzhN3Z3RUxn_gtcwDnDGYEgT4yoA94fFihS80uGh4CCSuALfluZgQg31auRCEwYDr8mWd4mt09FKyQsONFbh38VqtHCejynsIfk5U8nP4l8x8GQGEkm7R0UcEQcyALOh6JZRas_K97DHF5pTwzhcssAIw4SSnJ6dl9qsPobt3WxCiTy4qNGBe9-L2mdtieRMMCqIj5ZfxeUvgk6v8-8nnI6keyyiFs3AdJmKza4glzjGQARywePFmtFy5m5CHkA0C3Q0DbhwJRrREn"
                                    class="w-full h-full object-cover" />
                            </div>
                            <span class="material-symbols-outlined text-sm text-slate-400">expand_more</span>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div
                            id="userDropdown"
                            class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-900 rounded-xl shadow-xl border border-slate-200 dark:border-slate-800 py-2 z-50 animate-in fade-in slide-in-from-top-2 duration-200">
                            <a
                                href="#"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <span class="material-symbols-outlined text-lg">account_circle</span>
                                Mi Perfil
                            </a>
                            <a
                                href="#"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <span class="material-symbols-outlined text-lg">settings</span>
                                Configuración
                            </a>
                            <div
                                class="h-px bg-slate-100 dark:bg-slate-800 my-1 mx-2"></div>
                            <a
                                href="login.html"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                Salir
                            </a>
                        </div>
                    </div>
                </div>
            </header>

            <div id="app-content">
                <div class="p-8 space-y-8">
                    <!-- Filters Bar -->
                    <section
                        class="bg-white dark:bg-slate-900 p-4 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm flex flex-wrap items-end gap-4">
                        <div class="flex-1 min-w-[200px] space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Fecha Inicio</label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">calendar_month</span>
                                <input
                                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary"
                                    type="date"
                                    value="2023-10-01" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-[200px] space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Fecha Fin</label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">calendar_month</span>
                                <input
                                    class="w-full pl-10 pr-4 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm focus:ring-primary focus:border-primary"
                                    type="date"
                                    value="2023-10-31" />
                            </div>
                        </div>
                        <div class="flex-1 min-w-[200px] space-y-1.5">
                            <label
                                class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Sucursal</label>
                            <div class="relative">
                                <span
                                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">store</span>
                                <select
                                    class="w-full pl-10 pr-10 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm appearance-none focus:ring-primary focus:border-primary">
                                    <option>Todas las Sucursales</option>
                                    <option>Sede Miraflores</option>
                                    <option>Sede San Isidro</option>
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
                                    class="w-full pl-10 pr-10 py-2 bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm appearance-none focus:ring-primary focus:border-primary">
                                    <option>Almacén Principal</option>
                                    <option>Almacén Secundario</option>
                                </select>
                            </div>
                        </div>
                        <button
                            class="bg-primary hover:bg-primary/90 text-white p-2.5 rounded-lg transition-colors flex items-center justify-center">
                            <span class="material-symbols-outlined">filter_alt</span>
                        </button>
                    </section>
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
                                <h3 class="text-3xl font-bold tracking-tight">1,284</h3>
                                <span
                                    class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                                    12%
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Acumulado del mes</p>
                        </div>
                        <div
                            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                            <div
                                class="absolute right-0 top-0 p-3 text-primary/10 transition-transform group-hover:scale-110">
                                <span class="material-symbols-outlined text-6xl">description</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-500">Total Facturas</p>
                            <div class="mt-2 flex items-baseline gap-2">
                                <h3 class="text-3xl font-bold tracking-tight">412</h3>
                                <span
                                    class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                                    8%
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Acumulado del mes</p>
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
                                <h3 class="text-3xl font-bold tracking-tight">215</h3>
                                <span
                                    class="text-rose-500 text-xs font-bold flex items-center bg-rose-50 dark:bg-rose-500/10 px-1.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-sm">arrow_downward</span>
                                    3%
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Acumulado del mes</p>
                        </div>
                        <div
                            class="bg-white dark:bg-slate-900 p-6 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm relative overflow-hidden group">
                            <div
                                class="absolute right-0 top-0 p-3 text-primary/10 transition-transform group-hover:scale-110">
                                <span class="material-symbols-outlined text-6xl">account_balance_wallet</span>
                            </div>
                            <p class="text-sm font-semibold text-slate-500">Total Neto</p>
                            <div class="mt-2 flex items-baseline gap-2">
                                <h3 class="text-3xl font-bold tracking-tight text-primary">
                                    S/ 45,280
                                </h3>
                                <span
                                    class="text-emerald-500 text-xs font-bold flex items-center bg-emerald-50 dark:bg-emerald-500/10 px-1.5 py-0.5 rounded">
                                    <span class="material-symbols-outlined text-sm">arrow_upward</span>
                                    15.4%
                                </span>
                            </div>
                            <p class="text-xs text-slate-400 mt-1">Ganancia neta total</p>
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
                                <!-- Simulated Bar Chart -->
                                <div class="space-y-4">
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span>Smartphone Galaxy S23</span>
                                            <span class="font-bold">245 unid.</span>
                                        </div>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                            <div
                                                class="bg-primary h-2 rounded-full"
                                                style="width: 95%"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span>Wireless Headphones Sony</span>
                                            <span class="font-bold">184 unid.</span>
                                        </div>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                            <div
                                                class="bg-primary h-2 rounded-full"
                                                style="width: 78%"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span>MacBook Air M2</span>
                                            <span class="font-bold">128 unid.</span>
                                        </div>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                            <div
                                                class="bg-primary h-2 rounded-full"
                                                style="width: 65%"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span>Tablet iPad Pro 11"</span>
                                            <span class="font-bold">96 unid.</span>
                                        </div>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                            <div
                                                class="bg-primary h-2 rounded-full"
                                                style="width: 55%"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span>Monitor LG UltraWide</span>
                                            <span class="font-bold">88 unid.</span>
                                        </div>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                            <div
                                                class="bg-primary h-2 rounded-full"
                                                style="width: 45%"></div>
                                        </div>
                                    </div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-xs font-medium">
                                            <span>Mechanical Keyboard RGB</span>
                                            <span class="font-bold">72 unid.</span>
                                        </div>
                                        <div
                                            class="w-full bg-slate-100 dark:bg-slate-800 rounded-full h-2">
                                            <div
                                                class="bg-primary h-2 rounded-full"
                                                style="width: 35%"></div>
                                        </div>
                                    </div>
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
                                        viewbox="0 0 36 36">
                                        <circle
                                            class="stroke-slate-100 dark:stroke-slate-800"
                                            cx="18"
                                            cy="18"
                                            fill="none"
                                            r="15.915"
                                            stroke-width="4"></circle>
                                        <circle
                                            cx="18"
                                            cy="18"
                                            fill="none"
                                            r="15.915"
                                            stroke="#137fec"
                                            stroke-dasharray="40 60"
                                            stroke-dashoffset="0"
                                            stroke-width="4"></circle>
                                        <circle
                                            cx="18"
                                            cy="18"
                                            fill="none"
                                            r="15.915"
                                            stroke="#10b981"
                                            stroke-dasharray="25 75"
                                            stroke-dashoffset="-40"
                                            stroke-width="4"></circle>
                                        <circle
                                            cx="18"
                                            cy="18"
                                            fill="none"
                                            r="15.915"
                                            stroke="#f59e0b"
                                            stroke-dasharray="20 80"
                                            stroke-dashoffset="-65"
                                            stroke-width="4"></circle>
                                        <circle
                                            cx="18"
                                            cy="18"
                                            fill="none"
                                            r="15.915"
                                            stroke="#ec4899"
                                            stroke-dasharray="15 85"
                                            stroke-dashoffset="-85"
                                            stroke-width="4"></circle>
                                    </svg>
                                    <div
                                        class="absolute inset-0 flex flex-col items-center justify-center text-center">
                                        <span class="text-2xl font-bold tracking-tight">S/ 45.2k</span>
                                        <span class="text-[10px] text-slate-400 font-bold uppercase">Total</span>
                                    </div>
                                </div>
                                <div class="flex-1 space-y-3 w-full">
                                    <div
                                        class="flex items-center justify-between group cursor-default">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-primary"></span>
                                            <span
                                                class="text-sm font-medium text-slate-700 dark:text-slate-300">Yape</span>
                                        </div>
                                        <span class="text-sm font-bold">40%</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between group cursor-default">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                            <span
                                                class="text-sm font-medium text-slate-700 dark:text-slate-300">Plin</span>
                                        </div>
                                        <span class="text-sm font-bold">25%</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between group cursor-default">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                            <span
                                                class="text-sm font-medium text-slate-700 dark:text-slate-300">Visa / Mastercard</span>
                                        </div>
                                        <span class="text-sm font-bold">20%</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between group cursor-default">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-pink-500"></span>
                                            <span
                                                class="text-sm font-medium text-slate-700 dark:text-slate-300">Efectivo</span>
                                        </div>
                                        <span class="text-sm font-bold">15%</span>
                                    </div>
                                    <div
                                        class="flex items-center justify-between group cursor-default pt-2 mt-2 border-t border-slate-100 dark:border-slate-800">
                                        <div class="flex items-center gap-2">
                                            <span class="w-3 h-3 rounded-full bg-slate-300"></span>
                                            <span
                                                class="text-sm font-medium text-slate-700 dark:text-slate-300">QR / Otros</span>
                                        </div>
                                        <span class="text-sm font-bold">5%</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- Recent Transactions Summary -->
                    <section
                        class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 shadow-sm overflow-hidden">
                        <div
                            class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between">
                            <h4 class="font-bold text-slate-800 dark:text-white">
                                Recent Electronic Documents
                            </h4>
                            <div class="flex gap-2">
                                <button
                                    class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    Exportar CSV
                                </button>
                                <button
                                    class="px-3 py-1.5 rounded-lg border border-slate-200 dark:border-slate-700 text-xs font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                    Ver Todo
                                </button>
                            </div>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead
                                    class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 font-semibold border-b border-slate-200 dark:border-slate-800">
                                    <tr>
                                        <th class="px-6 py-3">Número</th>
                                        <th class="px-6 py-3">Cliente</th>
                                        <th class="px-6 py-3">Fecha / Hora</th>
                                        <th class="px-6 py-3">Sucursal</th>
                                        <th class="px-6 py-3">Monto</th>
                                        <th class="px-6 py-3">Estado SUNAT</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <tr>
                                        <td
                                            class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                                            B001-0004281
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                            Juan Carlos Lopez
                                        </td>
                                        <td class="px-6 py-4 text-slate-500">2023-10-24 14:22</td>
                                        <td class="px-6 py-4 text-slate-500">Sede Miraflores</td>
                                        <td class="px-6 py-4 font-bold">S/ 124.50</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-xs font-bold">Aceptado</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                                            F001-0000156
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                            Corporación Tech S.A.C.
                                        </td>
                                        <td class="px-6 py-4 text-slate-500">2023-10-24 13:45</td>
                                        <td class="px-6 py-4 text-slate-500">Sede San Isidro</td>
                                        <td class="px-6 py-4 font-bold">S/ 4,280.00</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400 text-xs font-bold">Aceptado</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                                            B001-0004280
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                            Maria Fernanda Rios
                                        </td>
                                        <td class="px-6 py-4 text-slate-500">2023-10-24 13:10</td>
                                        <td class="px-6 py-4 text-slate-500">Sede Miraflores</td>
                                        <td class="px-6 py-4 font-bold">S/ 85.00</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-600 dark:text-amber-400 text-xs font-bold">Pendiente</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td
                                            class="px-6 py-4 font-bold text-slate-900 dark:text-white">
                                            F001-0000155
                                        </td>
                                        <td class="px-6 py-4 text-slate-600 dark:text-slate-400">
                                            Innovate Peru E.I.R.L.
                                        </td>
                                        <td class="px-6 py-4 text-slate-500">2023-10-24 11:30</td>
                                        <td class="px-6 py-4 text-slate-500">Sede San Isidro</td>
                                        <td class="px-6 py-4 font-bold">S/ 1,120.50</td>
                                        <td class="px-6 py-4">
                                            <span
                                                class="px-2 py-1 rounded-full bg-rose-100 dark:bg-rose-900/30 text-rose-600 dark:text-rose-400 text-xs font-bold">Rechazado</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </section>
                </div>
        </main>
    </div>
    <script>
        window.toggleSidebar = function() {
            const sidebar = document.getElementById("sidebar");
            const overlay = document.getElementById("mobileOverlay");
            sidebar.classList.toggle("active");
            overlay.classList.toggle("hidden");
        };

        window.toggleUserMenu = function() {
            const dropdown = document.getElementById("userDropdown");
            dropdown.classList.toggle("hidden");
        };

        // Close dropdowns when clicking outside
        document.addEventListener("click", (e) => {
            const userBtn = document.getElementById("userProfileBtn");
            const userDropdown = document.getElementById("userDropdown");
            if (
                userBtn &&
                !userBtn.contains(e.target) &&
                !userDropdown.contains(e.target)
            ) {
                userDropdown.classList.add("hidden");
            }
        });
    </script>
    <!-- Mobile Overlay -->
    <div
        id="mobileOverlay"
        onclick="toggleSidebar()"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>
</body>

</html>