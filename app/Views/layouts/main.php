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

    <?= $this->renderSection('css') ?>
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
                <?= $this->include('layouts/menu') ?>
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
                <?= $this->include('layouts/header') ?>
            </header>

            <div id="app-content">
                <?= $this->renderSection('content') ?>
            </div>
        </main>
    </div>

    <!-- Modales de Caja -->
    <div id="modalAperturaCaja" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white dark:bg-slate-900 rounded-3xl w-full max-w-md shadow-2xl border border-slate-200 dark:border-slate-800 overflow-hidden transform transition-all">
            <div class="p-8">
                <div class="size-16 rounded-2xl bg-emerald-100 dark:bg-emerald-900/30 flex items-center justify-center text-emerald-600 mb-6 mx-auto">
                    <span class="material-symbols-outlined !text-4xl">lock_open</span>
                </div>
                <h3 class="text-2xl font-bold text-slate-900 dark:text-white text-center mb-2">Apertura de Caja</h3>
                <p class="text-slate-500 dark:text-slate-400 text-center mb-8">Ingresa el monto inicial para comenzar el turno.</p>

                <div class="space-y-4">
                    <div class="space-y-2">
                        <label class="text-xs font-bold uppercase tracking-widest text-slate-400">Caja Chica / Monto Inicial (S/)</label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">S/</span>
                            <input type="number" id="monto_inicial" step="0.01" value="0.00"
                                class="w-full h-14 pl-10 pr-4 rounded-xl border-slate-200 dark:border-slate-800 bg-slate-50 dark:bg-slate-800/50 text-xl font-bold focus:ring-primary focus:border-primary transition-all">
                        </div>
                    </div>
                </div>

                <div class="flex gap-3 mt-10">
                    <button onclick="cerrarModalApertura()"
                        class="flex-1 h-14 rounded-xl border border-slate-200 dark:border-slate-800 text-slate-600 dark:text-slate-300 font-bold hover:bg-slate-50 dark:hover:bg-slate-800 transition-all">
                        Cancelar
                    </button>
                    <button onclick="ejecutarApertura()"
                        class="flex-1 h-14 rounded-xl bg-primary text-slate-900 font-bold hover:shadow-lg hover:shadow-primary/30 transition-all">
                        Abrir Caja
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="<?= base_url('js/main.js') ?>"></script>
    <script>
        const baseUrl = '<?= base_url() ?>';

        function abrirModalApertura() {
            document.getElementById('modalAperturaCaja').classList.remove('hidden');
        }

        function cerrarModalApertura() {
            document.getElementById('modalAperturaCaja').classList.add('hidden');
        }

        async function ejecutarApertura() {
            const monto = document.getElementById('monto_inicial').value;

            try {
                const response = await fetch(`${baseUrl}/caja/abrir`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: `monto_inicial=${monto}`
                });

                const result = await response.json();

                if (result.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Caja Abierta!',
                        text: result.message,
                        confirmButtonText: 'Continuar'
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message
                    });
                }
            } catch (error) {
                console.error(error);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Ocurrió un problema al procesar la solicitud.'
                });
            }
        }

        async function confirmarCerrarCaja() {
            const result = await Swal.fire({
                title: 'Cerrar Caja',
                text: '¿Estás seguro de cerrar la caja actual?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#13ec49',
                cancelButtonColor: '#f44336',
                confirmButtonText: 'Sí, cerrar caja'
            });

            if (result.isConfirmed) {
                try {
                    const response = await fetch(`${baseUrl}/caja/cerrar`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: `monto_cierre=0`
                    });

                    const result = await response.json();

                    if (result.status === 'success') {
                        Swal.fire({
                            icon: 'success',
                            title: '¡Caja Cerrada!',
                            text: result.message,
                            confirmButtonText: 'Continuar'
                        }).then(() => {
                            window.location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message
                        });
                    }
                } catch (error) {
                    console.error(error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Ocurrió un problema al procesar la solicitud.'
                    });
                }
            }
        }
    </script>
    <?= $this->renderSection('scripts') ?>
    <!-- Mobile Overlay -->
    <div
        id="mobileOverlay"
        onclick="toggleSidebar()"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>
</body>

</html>