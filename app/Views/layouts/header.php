<div class="flex items-center gap-4">
    <button
        onclick="toggleSidebar()"
        class="p-2 -ml-2 rounded-lg text-slate-600 dark:text-slate-400 lg:hidden">
        <span class="material-symbols-outlined">menu</span>
    </button>
    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
        <h2 class="text-lg lg:text-xl font-bold tracking-tight">
            Recreo San Andres
        </h2>
        <?php $tipoEnvio = session()->get('tipo_envio_sunat') ?? 'prueba'; ?>
        <?php if ($tipoEnvio == 'produccion'): ?>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200 uppercase tracking-widest shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 mr-1.5 animate-pulse"></span>
                Producción
            </span>
        <?php else: ?>
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-200 uppercase tracking-widest shadow-sm">
                <span class="w-1.5 h-1.5 rounded-full bg-rose-500 mr-1.5 animate-pulse"></span>
                Prueba
            </span>
        <?php endif; ?>
    </div>
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
                    <?= session()->get('nombres') . ' ' . session()->get('apellidos') ?>
                </p>
                <p
                    class="text-[10px] text-primary font-bold uppercase tracking-wider">
                    <?= session()->get('rol') ?>
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
                href="<?= base_url('auth/salir') ?>"
                class="flex items-center gap-3 px-4 py-2 text-sm text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-900/20 transition-colors">
                <span class="material-symbols-outlined text-lg">logout</span>
                Salir
            </a>
        </div>
    </div>
</div>