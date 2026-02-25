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
    <script src="<?= base_url('js/main.js') ?>"></script>
    <?= $this->renderSection('scripts') ?>
    <!-- Mobile Overlay -->
    <div
        id="mobileOverlay"
        onclick="toggleSidebar()"
        class="hidden fixed inset-0 bg-slate-900/50 backdrop-blur-sm z-40 lg:hidden"></div>
</body>

</html>