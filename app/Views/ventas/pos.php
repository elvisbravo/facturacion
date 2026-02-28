<!doctype html>

<html class="light" lang="es">

<head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <title>Full-Screen POS Terminal View</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&amp;display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap"
        rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
        body {
            font-family: "Inter", sans-serif;
        }

        .material-symbols-outlined {
            font-variation-settings:
                "FILL" 0,
                "wght" 400,
                "GRAD" 0,
                "opsz" 24;
        }

        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        html,
        body {
            overflow: hidden;
            height: 100vh;
            width: 100vw;
            margin: 0;
            padding: 0;
        }

        @media (max-width: 1024px) {
            .cart-sidebar {
                position: fixed;
                right: 0;
                top: 0;
                bottom: 0;
                transform: translateX(100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                width: 100% !important;
                max-width: 400px;
                z-index: 100 !important;
            }

            .cart-sidebar.active {
                transform: translateX(0) !important;
            }

            .mobile-menu {
                left: 0;
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 120 !important;
            }

            .mobile-menu.active {
                transform: translateX(0) !important;
            }
        }

        /* Essential Animations */
        @keyframes bounce-subtle {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-5px);
            }
        }

        .animate-bounce-subtle {
            animation: bounce-subtle 2s infinite ease-in-out;
        }

        @keyframes pulse-primary {
            0% {
                box-shadow: 0 0 0 0 rgba(19, 236, 73, 0.4);
            }

            70% {
                box-shadow: 0 0 0 15px rgba(19, 236, 73, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(19, 236, 73, 0);
            }
        }

        .animate-pulse-primary {
            animation: pulse-primary 2s infinite;
        }

        /* Custom scrollbar for better aesthetics */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        .dark .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #334155;
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark text-slate-900 dark:text-slate-100 font-display h-screen overflow-hidden">
    <div class="flex h-full w-full flex-col">
        <!-- Top Navigation Bar -->
        <header
            class="flex items-center justify-between border-b border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 px-4 lg:px-6 py-3 shrink-0">
            <div class="flex items-center gap-2 lg:gap-6 flex-1 lg:flex-none">
                <!-- Hamburger Menu Button -->
                <button onclick="toggleMobileMenu()" class="lg:hidden size-10 flex items-center justify-center rounded-lg hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined">menu</span>
                </button>

                <div class="flex items-center gap-3 text-slate-900 dark:text-slate-100 shrink-0">
                    <div class="size-8 bg-primary rounded-lg flex items-center justify-center">
                        <span class="material-symbols-outlined text-slate-900 font-bold">point_of_sale</span>
                    </div>
                    <h2 class="text-lg lg:text-xl font-bold tracking-tight hidden sm:block">
                        BravoFact
                    </h2>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <div class="hidden lg:flex gap-6 mr-6">
                    <a class="text-sm font-semibold border-b-2 border-primary pb-1" href="<?= base_url('pos') ?>">Terminal</a>
                    <a class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors"
                        href="<?= base_url('ventas') ?>">Ventas</a>
                    <a class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors"
                        href="<?= base_url('dashboard') ?>">Dashboard</a>
                    <a class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors"
                        href="<?= base_url('productos') ?>">Inventario</a>
                    <a class="text-sm font-medium text-slate-500 hover:text-slate-900 dark:hover:text-white transition-colors"
                        href="<?= base_url('caja-aperturar') ?>">Caja</a>
                </div>

                <div class="flex items-center gap-2">

                    <button class="p-2 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                        <span class="material-symbols-outlined">notifications</span>
                    </button>
                    <div class="relative">
                        <button id="userProfileBtn"
                            class="flex items-center gap-3 pl-4 border-l border-slate-200 dark:border-slate-800 hover:bg-slate-50 dark:hover:bg-slate-800/50 p-1 rounded-lg transition-colors"
                            onclick="toggleUserMenu()">
                            <div class="text-right hidden sm:block">
                                <p class="text-xs font-bold text-slate-900 dark:text-slate-100">
                                    <?= session()->get('nombres') ?>
                                </p>
                                <p class="text-[10px] text-slate-500 uppercase"><?= session()->get('rol') ?></p>
                            </div>
                            <div
                                class="size-10 rounded-full bg-primary/10 dark:bg-primary/20 flex items-center justify-center overflow-hidden border-2 border-primary/30">
                                <span class="material-symbols-outlined text-primary font-fill">account_circle</span>
                            </div>
                            <span class="material-symbols-outlined text-sm text-slate-400">expand_more</span>
                        </button>

                        <!-- User Dropdown Menu -->
                        <div id="userDropdown"
                            class="hidden absolute right-0 top-full mt-2 w-48 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 rounded-xl shadow-xl z-[60] py-2 animate-in fade-in zoom-in-95 duration-150">
                            <a href="#"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                                <span class="material-symbols-outlined text-lg">account_circle</span>
                                Mi Perfil
                            </a>
                            <div class="h-px bg-slate-100 dark:bg-slate-800 my-1 mx-2"></div>
                            <a href="<?= base_url('auth/salir') ?>"
                                class="flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                Cerrar Sesión
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Content Area -->
        <main class="flex flex-1 overflow-hidden">
            <!-- Left Panel: Product Grid -->
            <section class="flex-1 flex flex-col min-w-0 bg-slate-50 dark:bg-background-dark/50 overflow-hidden">

                <!-- Search & Warehouse Unified Bar -->
                <div class="px-6 py-4 bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 flex flex-col md:flex-row gap-4 items-center shrink-0">
                    <div class="relative flex-1 w-full">
                        <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400">search</span>
                        <input id="productSearch"
                            class="w-full bg-slate-50 dark:bg-slate-800 border-none rounded-xl pl-10 pr-4 py-2.5 text-sm focus:ring-2 focus:ring-primary shadow-sm"
                            placeholder="Buscar por nombre, código o categoría..." type="text" />
                    </div>

                    <div class="flex items-center gap-3 w-full md:w-auto">
                        <div class="relative flex-1 md:flex-none">
                            <span class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-sm">inventory_2</span>
                            <select id="posWarehouse" class="w-full md:w-48 bg-slate-50 dark:bg-slate-800 border-none rounded-xl pl-9 pr-4 py-2.5 text-xs font-bold focus:ring-2 focus:ring-primary outline-none shadow-sm">
                                <option value="0">Todos los Almacenes</option>
                            </select>
                        </div>

                        <?php
                        $tipoEnvio = session()->get('tipo_envio_sunat') ?? 'PRUEBA';
                        $envioColor = ($tipoEnvio == 'produccion') ? 'emerald' : 'orange';
                        ?>
                        <div class="px-3 py-2.5 rounded-xl bg-<?= $envioColor ?>-100 dark:bg-<?= $envioColor ?>-900/40 text-<?= $envioColor ?>-600 dark:text-<?= $envioColor ?>-400 text-[10px] font-black uppercase tracking-widest border border-<?= $envioColor ?>-200 dark:border-<?= $envioColor ?>-800 shadow-sm flex items-center gap-2">
                            <span class="size-2 rounded-full bg-<?= $envioColor ?>-500 animate-pulse"></span>
                            <?= $tipoEnvio ?>
                        </div>
                    </div>
                </div>

                <!-- Categories Bar -->
                <div id="posCategories"
                    class="px-6 py-4 flex gap-3 overflow-x-auto whitespace-nowrap bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800 scrollbar-hide shrink-0">
                    <button class="px-6 py-2 rounded-full bg-primary text-slate-900 font-bold text-sm shadow-sm category-btn active" data-id="0">
                        Todos
                    </button>
                    <!-- Categories will be loaded here -->
                </div>

                <!-- Grid -->
                <div class="flex-1 overflow-y-auto p-6 pb-32 lg:pb-6">
                    <div id="posProductGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-4">
                        <!-- Product Cards will be loaded here -->
                    </div>
                </div>
            </section>
            <!-- Right Panel: Shopping Cart -->
            <aside id="cartSidebar"
                class="cart-sidebar w-[400px] flex flex-col bg-white dark:bg-slate-900 border-l border-slate-200 dark:border-slate-800 shadow-2xl lg:shadow-none shrink-0 z-50">
                <!-- Mobile Cart Close -->
                <button onclick="toggleMobileCart()"
                    class="lg:hidden absolute left-4 top-4 size-10 bg-white dark:bg-slate-800 rounded-full shadow-lg flex items-center justify-center text-slate-500">
                    <span class="material-symbols-outlined">close</span>
                </button>
                <!-- Cart Header -->
                <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                    <div>
                        <h3 class="text-xl font-bold">Carrito</h3>
                        <p class="text-sm text-slate-500">Mesa 04 / Orden #124</p>
                    </div>
                    <button id="clearCartBtn" onclick="clearCart()"
                        class="text-red-500 text-sm font-semibold hover:bg-red-50 dark:hover:bg-red-900/20 px-3 py-1 rounded-lg transition-colors">
                        Vaciar
                    </button>
                </div>
                <!-- Cart Items -->
                <div id="cartItemsContainer" class="flex-1 overflow-y-auto px-6 py-4 space-y-4">
                    <!-- Items will be injected here by JS -->
                </div>
                <!-- Summary and Checkout -->
                <div class="p-6 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-800 space-y-4">
                    <!-- Document Type Tabs -->

                    <div class="flex justify-between text-sm">
                        <span class="text-slate-500">Subtotal</span>
                        <span id="subtotalValue" class="font-medium">S/ 0.00</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm text-slate-500">Descuento</span>
                        <input
                            class="flex-1 h-8 bg-white dark:bg-slate-900 border-slate-200 dark:border-slate-700 rounded text-xs px-2 focus:ring-primary"
                            placeholder="Código o %" type="text" />
                        <span class="text-sm font-medium text-red-500">-S/ 0.00</span>
                    </div>
                    <div class="flex justify-between items-end pt-2">
                        <span class="text-lg font-bold">Total</span>
                        <span id="totalValue" class="text-3xl font-black text-primary">S/ 0.00</span>
                    </div>
                    <button id="payButton"
                        class="w-full bg-primary hover:bg-primary/90 text-slate-900 font-black py-4 rounded-xl text-xl shadow-lg shadow-primary/20 transition-all flex items-center justify-center gap-2">
                        PAGAR
                        <span class="material-symbols-outlined font-black">payments</span>
                    </button>
                </div>
            </aside>
        </main>
    </div>

    <!-- FIXED ELEMENTS (Direct Children of Body for best stacking/visibility) -->

    <!-- Mobile Floating Action Button (Lower Right) -->
    <button onclick="toggleMobileCart()"
        class="lg:hidden fixed bottom-6 right-6 size-16 bg-primary text-slate-900 rounded-full shadow-[0_8px_30px_rgba(19,236,73,0.5)] flex items-center justify-center z-[100] transition-all active:scale-90 animate-bounce-subtle animate-pulse-primary">
        <div class="relative">
            <span class="material-symbols-outlined text-4xl font-black">shopping_cart</span>
            <span id="mobileCartCount"
                class="absolute -top-3 -right-3 size-7 bg-slate-900 text-white text-[12px] font-black rounded-full flex items-center justify-center ring-4 ring-primary">0</span>
        </div>
    </button>

    <!-- Mobile Side Menu -->
    <div id="mobileSideMenu" class="mobile-menu fixed inset-y-0 w-[280px] bg-white dark:bg-slate-900 z-[110] shadow-2xl flex flex-col lg:hidden">
        <div class="p-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="size-8 bg-primary rounded-lg flex items-center justify-center">
                    <span class="material-symbols-outlined text-slate-900 font-bold">point_of_sale</span>
                </div>
                <span class="font-bold text-lg tracking-tight">BravoFact</span>
            </div>
            <button onclick="toggleMobileMenu()" class="size-9 flex items-center justify-center rounded-lg bg-slate-50 dark:bg-slate-800 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="flex-1 overflow-y-auto py-4 custom-scrollbar">
            <nav class="px-3 space-y-1">
                <a href="<?= base_url('pos') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-primary text-slate-900 font-bold shadow-lg shadow-primary/10">
                    <span class="material-symbols-outlined font-fill">terminal</span>
                    Terminal POS
                </a>
                <a href="<?= base_url('dashboard') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 font-medium transition-colors">
                    <span class="material-symbols-outlined">dashboard</span>
                    Dashboard
                </a>
                <a href="<?= base_url('productos') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 font-medium transition-colors">
                    <span class="material-symbols-outlined">inventory_2</span>
                    Inventario / Stock
                </a>
                <a href="<?= base_url('ventas') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 font-medium transition-colors">
                    <span class="material-symbols-outlined">receipt_long</span>
                    Ventas Realizadas
                </a>
                <a href="<?= base_url('caja') ?>" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-600 dark:text-slate-400 hover:bg-slate-50 dark:hover:bg-slate-800/50 font-medium transition-colors">
                    <span class="material-symbols-outlined font-fill">account_balance_wallet</span>
                    Movimientos de Caja
                </a>
            </nav>
        </div>
        <div class="p-4 border-t border-slate-100 dark:border-slate-800">
            <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-slate-800/50">
                <div class="size-10 rounded-full bg-primary/10 flex items-center justify-center overflow-hidden border border-primary/20">
                    <span class="material-symbols-outlined text-primary font-fill">account_circle</span>
                </div>
                <div class="min-w-0">
                    <p class="text-xs font-bold truncate truncate text-slate-900 dark:text-slate-100"><?= session()->get('nombres') ?></p>
                    <p class="text-[9px] text-slate-500 uppercase font-medium tracking-wider"><?= session()->get('rol') ?></p>
                </div>
                <a href="<?= base_url('auth/salir') ?>" class="ml-auto size-8 flex items-center justify-center rounded-lg text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            </div>
        </div>
    </div>

    <!-- Overlays -->
    <div id="menuOverlay" onclick="toggleMobileMenu()" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[105]"></div>
    <div id="mobileOverlay" onclick="toggleMobileCart()" class="hidden fixed inset-0 bg-slate-900/60 backdrop-blur-sm z-[95]"></div>

    <!-- Payment Modal -->
    <div id="paymentModal"
        class="hidden fixed inset-0 bg-slate-900/70 backdrop-blur-md z-[150] flex items-center justify-center p-4">
        <div
            class="bg-white dark:bg-slate-900 w-full max-w-4xl rounded-2xl shadow-2xl flex flex-col max-h-[90vh] overflow-hidden border border-slate-200 dark:border-slate-800">
            <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center shrink-0">
                <div class="flex items-center gap-2">
                    <div class="bg-primary/10 p-2 rounded-lg">
                        <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                    </div>
                    <h3 class="text-xl font-bold">Finalizar Transacción</h3>
                </div>
                <button onclick="closePaymentModal()"
                    class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-2 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg">
                    <span class="material-symbols-outlined">close</span>
                </button>
            </div>
            <div class="flex-1 overflow-y-auto p-6 custom-scrollbar">
                <div class="grid grid-cols-1 lg:grid-cols-5 gap-8">
                    <div class="lg:col-span-2 space-y-6">
                        <div class="space-y-3">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Seleccionar Cliente</label>
                            <div class="flex gap-2">
                                <div class="relative flex-1">
                                    <span
                                        class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xl">person_search</span>
                                    <input id="customerSearchInput"
                                        class="w-full pl-10 pr-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl focus:ring-2 focus:ring-primary focus:border-transparent outline-none"
                                        placeholder="Nombre, RUC o DNI..." type="text" oninput="searchCustomer(this.value)" />
                                    <!-- Search Results Dropdown -->
                                    <div id="customerSearchResults"
                                        class="hidden absolute left-0 right-0 top-full mt-2 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl z-[60] max-h-60 overflow-y-auto overflow-x-hidden">
                                    </div>
                                </div>
                                <button onclick="openCustomerModal()" class="size-[46px] flex items-center justify-center bg-primary text-slate-900 rounded-xl shadow-lg shadow-primary/20 hover:bg-primary/90 transition-all shrink-0">
                                    <span class="material-symbols-outlined font-black">add</span>
                                </button>
                            </div>
                            <div id="selectedCustomerDisplay"
                                class="p-3 bg-blue-50 dark:bg-blue-900/20 border border-blue-100 dark:border-blue-800/50 rounded-lg flex items-center gap-3">
                                <span class="material-symbols-outlined text-blue-600">person</span>
                                <div>
                                    <p id="selectedCustomerName" class="text-sm font-bold text-blue-900 dark:text-blue-300">
                                        Cliente Varios
                                    </p>
                                    <p id="selectedCustomerId" class="text-xs text-blue-700 dark:text-blue-400">
                                        ID: 00000000
                                    </p>
                                </div>
                                <button onclick="resetCustomerSelection()"
                                    class="ml-auto text-blue-600 hover:underline text-xs font-medium">
                                    Restablecer
                                </button>
                            </div>
                        </div>
                        <div class="space-y-3">
                            <label class="text-sm font-semibold text-slate-700 dark:text-slate-300">Tipo de Comprobante</label>
                            <div class="grid grid-cols-1 gap-2">
                                <?php
                                $selectedIndex = 0;
                                foreach ($tiposComprobante as $i => $t) {
                                    if (strpos(strtoupper($t['descripcion']), 'BOLETA') !== false) {
                                        $selectedIndex = $i;
                                        break;
                                    }
                                }
                                ?>
                                <?php foreach ($tiposComprobante as $index => $tipo): ?>
                                    <?php
                                    $desc = strtoupper($tipo['descripcion']);
                                    $icon = 'description';
                                    $sub = '';
                                    $isSelected = ($index === $selectedIndex);

                                    if (strpos($desc, 'BOLETA') !== false) {
                                        $icon = 'receipt_long';
                                        $sub = 'Uso para personas naturales';
                                    } elseif (strpos($desc, 'FACTURA') !== false) {
                                        $icon = 'business';
                                        $sub = 'Requiere RUC válido';
                                    } else {
                                        $sub = 'Documento interno';
                                    }
                                    ?>
                                    <label
                                        class="relative flex items-center p-4 border <?= $isSelected ? 'border-2 border-primary bg-primary/5' : 'border-slate-200 dark:border-slate-700' ?> rounded-xl cursor-pointer transition-all hover:bg-primary/5 group"
                                        id="docTypeContainer_<?= $tipo['id_tipodoc_electronico'] ?>">
                                        <input <?= $isSelected ? 'checked' : '' ?>
                                            class="hidden"
                                            name="docType"
                                            type="radio"
                                            value="<?= $tipo['id_tipodoc_electronico'] ?>"
                                            data-es-factura="<?= strpos($desc, 'FACTURA') !== false ? 'true' : 'false' ?>"
                                            data-es-boleta="<?= strpos($desc, 'BOLETA') !== false ? 'true' : 'false' ?>" />
                                        <span class="material-symbols-outlined <?= $isSelected ? 'text-primary' : 'text-slate-500' ?> mr-3 group-hover:text-primary transition-colors"><?= $icon ?></span>
                                        <div class="flex-1">
                                            <span class="block text-sm font-bold text-slate-900 dark:text-white"><?= $tipo['descripcion'] ?></span>
                                            <span class="block text-xs text-slate-500"><?= $sub ?></span>
                                        </div>
                                        <?php if ($isSelected): ?>
                                            <span class="material-symbols-outlined text-primary check-icon">check_circle</span>
                                        <?php endif; ?>
                                    </label>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                    <div class="lg:col-span-3 flex flex-col gap-6">
                        <div class="grid grid-cols-3 gap-4">
                            <div
                                class="bg-slate-50 dark:bg-slate-800/50 p-4 rounded-2xl border border-slate-100 dark:border-slate-700">
                                <p class="text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">
                                    Total a Pagar
                                </p>
                                <p id="modalTotalToPay" class="text-2xl font-black text-slate-900 dark:text-white">
                                    S/ 0.00
                                </p>
                            </div>
                            <div
                                class="bg-green-50 dark:bg-green-900/20 p-4 rounded-2xl border border-green-100 dark:border-green-800/50">
                                <p class="text-[10px] font-bold text-green-600 dark:text-green-400 uppercase tracking-wider mb-1">
                                    Monto Pagado
                                </p>
                                <p id="modalAmountPaid" class="text-2xl font-black text-green-600 dark:text-green-400">
                                    S/ 0.00
                                </p>
                            </div>
                            <div
                                class="bg-orange-50 dark:bg-orange-900/20 p-4 rounded-2xl border border-orange-100 dark:border-orange-800/50">
                                <p class="text-[10px] font-bold text-orange-600 dark:text-orange-400 uppercase tracking-wider mb-1">
                                    Vuelto / Restante
                                </p>
                                <p id="modalBalance" class="text-2xl font-black text-orange-600 dark:text-orange-400">
                                    S/ 0.00
                                </p>
                            </div>
                        </div>
                        <div
                            class="bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl overflow-hidden">
                            <div
                                class="px-4 py-3 bg-slate-50 dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700 flex justify-between">
                                <span class="text-xs font-bold text-slate-500 uppercase">Método de Pago</span>
                                <span class="text-xs font-bold text-slate-500 uppercase">Importe</span>
                            </div>
                            <div id="activePaymentMethods" class="divide-y divide-slate-100 dark:divide-slate-800">
                                <!-- Active methods will be injected here -->
                            </div>
                            <!-- Add Method Section -->
                            <div class="p-4 bg-slate-50 dark:bg-slate-800/50 border-t border-slate-200 dark:border-slate-700">
                                <p class="text-[10px] font-bold text-slate-500 uppercase mb-3">
                                    Agregar método de pago
                                </p>
                                <div id="paymentMethodsContainer" class="flex flex-wrap gap-2">
                                    <!-- Dynamic payment methods will be loaded here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="px-6 py-5 bg-slate-50 dark:bg-slate-800/80 border-t border-slate-200 dark:border-slate-700 flex gap-4 shrink-0 mt-auto">
                <button onclick="closePaymentModal()"
                    class="px-8 py-4 border-2 border-slate-200 dark:border-slate-600 rounded-xl font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 transition-colors uppercase text-sm">
                    Cancelar
                </button>
                <button onclick="processPayment()"
                    class="flex-1 py-4 bg-primary text-slate-900 rounded-xl font-black shadow-xl shadow-primary/30 hover:bg-primary/90 flex items-center justify-center gap-3 transition-transform active:scale-[0.98] uppercase tracking-wide">
                    <span class="material-symbols-outlined">print</span>
                    Confirmar Pago y Emitir Comprobante
                </button>
            </div>
        </div>

        <!-- Customer Modal -->
        <div id="customerModal" class="hidden fixed inset-0 bg-slate-900/70 backdrop-blur-md z-[160] flex items-center justify-center p-4">
            <div class="bg-white dark:bg-slate-900 w-full max-w-lg rounded-2xl shadow-2xl flex flex-col border border-slate-200 dark:border-slate-800">
                <div class="px-6 py-4 border-b border-slate-100 dark:border-slate-800 flex justify-between items-center">
                    <h3 id="customerModalTitle" class="text-xl font-bold">Nuevo Cliente</h3>
                    <button onclick="closeCustomerModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 p-2 rounded-lg">
                        <span class="material-symbols-outlined">close</span>
                    </button>
                </div>
                <form id="customerForm" class="p-6 space-y-4">
                    <input type="hidden" id="custId" name="id" value="0">
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1 col-span-1">
                            <label class="text-xs font-bold text-slate-500 uppercase">Tipo Documento</label>
                            <select id="custTipoDoc" name="id_tipo_documento" class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm p-2 focus:ring-primary h-10 outline-none">
                                <!-- Loaded via JS -->
                            </select>
                        </div>
                        <div class="space-y-1 col-span-1">
                            <label class="text-xs font-bold text-slate-500 uppercase">Nro. Documento</label>
                            <input id="custDoc" name="numero_documento" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm p-2 focus:ring-primary h-10 outline-none" required>
                        </div>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase">Nombres / Razón Social</label>
                        <input id="custNombres" name="nombres" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm p-2 focus:ring-primary h-10 outline-none" required>
                    </div>
                    <div class="space-y-1">
                        <label class="text-xs font-bold text-slate-500 uppercase">Dirección</label>
                        <input id="custDir" name="direccion" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm p-2 focus:ring-primary h-10 outline-none">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-500 uppercase">Teléfono</label>
                            <input id="custTel" name="telefono" type="text" class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm p-2 focus:ring-primary h-10 outline-none">
                        </div>
                        <div class="space-y-1">
                            <label class="text-xs font-bold text-slate-500 uppercase">Email</label>
                            <input id="custEmail" name="correo" type="email" class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm p-2 focus:ring-primary h-10 outline-none">
                        </div>
                    </div>
                    <div class="pt-4 flex gap-3">
                        <button type="button" onclick="closeCustomerModal()" class="flex-1 py-3 border border-slate-200 dark:border-slate-700 rounded-xl font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-50 transition-colors uppercase text-xs">Cancelar</button>
                        <button type="submit" class="flex-1 py-3 bg-primary text-slate-900 rounded-xl font-black shadow-lg shadow-primary/20 hover:bg-primary/90 transition-transform active:scale-[0.98] uppercase text-xs">Guardar Cliente</button>
                    </div>
                </form>
            </div>
        </div>
        <script>
            const BASE_URL = "<?= base_url() ?>";
            <?php if (isset($cajaVencida) && $cajaVencida): ?>
                document.addEventListener('DOMContentLoaded', () => {
                    Swal.fire({
                        title: '¡Caja Vencida!',
                        text: 'La caja "<?= $cajaAbierta['nombre_caja'] ?>" ha superado su hora de cierre programada (<?= date('H:i', strtotime($cajaAbierta['hora_cierre'])) ?>). Debe cerrarla para continuar operando correctamente.',
                        icon: 'warning',
                        confirmButtonColor: '#13ec49',
                        confirmButtonText: 'Ir a Gestión de Caja',
                        allowOutsideClick: false,
                        allowEscapeKey: false
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = BASE_URL + 'caja-aperturar';
                        }
                    });
                });
            <?php endif; ?>
        </script>
        <script src="<?= base_url('js/ventas/pos.js') ?>"></script>
</body>

</html>