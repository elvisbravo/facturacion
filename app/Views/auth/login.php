<!doctype html>
<html class="light" lang="es">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - BravoFact System</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap"
        rel="stylesheet" />
    <script>
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        primary: "#13ec49",
                        "background-light": "#f6f8f6",
                        "background-dark": "#0a150e",
                    },
                    fontFamily: {
                        sans: ["Inter", "sans-serif"],
                    },
                },
            },
        };
    </script>
    <style>
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .dark .glass-card {
            background: rgba(16, 34, 21, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }
    </style>
</head>

<body
    class="bg-background-light dark:bg-background-dark min-h-screen flex items-center justify-center p-4 relative overflow-hidden transition-colors duration-300">
    <!-- Abstract Background Elements -->
    <div
        class="absolute top-[-10%] left-[-10%] w-[40%] h-[40%] bg-primary/20 rounded-full blur-[120px] pointer-events-none"></div>
    <div
        class="absolute bottom-[-10%] right-[-10%] w-[40%] h-[40%] bg-primary/10 rounded-full blur-[100px] pointer-events-none"></div>

    <!-- Theme Toggle -->
    <button
        onclick="toggleTheme()"
        class="absolute top-6 right-6 p-2 rounded-xl bg-white dark:bg-slate-800 shadow-lg text-slate-600 dark:text-slate-300 hover:scale-110 transition-transform z-10">
        <span id="themeIcon" class="material-symbols-outlined">dark_mode</span>
    </button>

    <div
        class="w-full max-w-md animate-in fade-in zoom-in duration-700 relative z-0">
        <!-- Logo Area -->
        <div class="flex flex-col items-center mb-8">
            <div
                class="size-16 bg-primary rounded-2xl flex items-center justify-center shadow-lg shadow-primary/30 float-animation mb-4">
                <span
                    class="material-symbols-outlined text-4xl text-slate-900"
                    style="font-variation-settings: 'FILL' 1, 'wght' 700, 'GRAD' 0, 'opsz' 48;">point_of_sale</span>
            </div>
            <h1
                class="text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                Bravo<span class="text-primary">Fact</span>
            </h1>
            <p class="text-slate-500 dark:text-slate-400 mt-2 font-medium">
                Sistema de Facturación e Inventario
            </p>
        </div>

        <input type="hidden" id="base_url" value="<?= base_url() ?>">

        <!-- Login Card -->
        <div
            class="glass-card rounded-3xl p-8 shadow-2xl overflow-hidden relative">
            <div
                class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-transparent via-primary to-transparent opacity-50"></div>

            <form id="loginForm" onsubmit="handleLogin(event)" class="space-y-6">
                <!-- Username Input -->
                <div class="space-y-2">
                    <label
                        class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider ml-1">Usuario</label>
                    <div class="relative group">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">person</span>
                        <input
                            required
                            type="text"
                            name="usuario"
                            placeholder="Usuario o correo"
                            class="w-full pl-12 pr-4 py-4 bg-slate-100 dark:bg-slate-800 border-2 border-transparent focus:border-primary/30 focus:bg-white dark:focus:bg-slate-900 rounded-2xl dark:text-white placeholder:text-slate-400 outline-none transition-all" />
                    </div>
                </div>

                <!-- Password Input -->
                <div class="space-y-2">
                    <div class="flex justify-between items-center ml-1">
                        <label
                            class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Contraseña</label>
                        <a href="#" class="text-xs font-bold text-primary hover:underline">¿La olvidaste?</a>
                    </div>
                    <div class="relative group">
                        <span
                            class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 group-focus-within:text-primary transition-colors">lock</span>
                        <input
                            required
                            id="passwordInput"
                            type="password"
                            name="password"
                            placeholder="••••••••"
                            class="w-full pl-12 pr-12 py-4 bg-slate-100 dark:bg-slate-800 border-2 border-transparent focus:border-primary/30 focus:bg-white dark:focus:bg-slate-900 rounded-2xl dark:text-white placeholder:text-slate-400 outline-none transition-all" />
                        <button
                            type="button"
                            onclick="togglePassword()"
                            class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                            <span id="passwordIcon" class="material-symbols-outlined">visibility</span>
                        </button>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center gap-3 ml-1">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" value="" class="sr-only peer" />
                        <div
                            class="w-11 h-6 bg-slate-200 peer-focus:outline-none dark:bg-slate-700 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-primary"></div>
                        <span
                            class="ml-3 text-sm font-medium text-slate-600 dark:text-slate-400">Recordarme</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <button
                    type="submit"
                    class="w-full bg-primary hover:bg-primary/90 text-slate-900 font-black py-4 rounded-2xl text-lg shadow-xl shadow-primary/20 transition-all transform active:scale-[0.98] flex items-center justify-center gap-2 group">
                    INGRESAR
                    <span
                        class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                </button>
            </form>

            <!-- Footer -->
            <div
                class="mt-8 pt-6 border-t border-slate-100 dark:border-slate-800 text-center">
                <p class="text-sm text-slate-500 dark:text-slate-400">
                    ¿No tienes una cuenta?
                    <a href="#" class="text-primary font-bold hover:underline">Contáctanos aquí</a>
                </p>
            </div>
        </div>

        <!-- System Status -->
        <div class="mt-8 flex items-center justify-center gap-6">
            <div class="flex items-center gap-2">
                <div class="size-2 bg-primary rounded-full animate-pulse"></div>
                <span
                    class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Servidor Online</span>
            </div>
            <div class="w-px h-3 bg-slate-300 dark:bg-slate-700"></div>
            <div class="flex items-center gap-2">
                <span
                    class="text-[10px] font-bold text-slate-500 uppercase tracking-[0.2em]">Versión 1.4.2</span>
            </div>
        </div>
    </div>

    <script src="<?= base_url('js/auth/login.js') ?>"></script>
</body>

</html>