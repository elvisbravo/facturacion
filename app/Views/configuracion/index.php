<?= $this->extend('layouts/main') ?>

<?= $this->section('css') ?>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    .badge-prueba {
        background-color: #fee2e2;
        color: #ef4444;
        border: 1px solid #fecaca;
    }

    .badge-produccion {
        background-color: #dcfce7;
        color: #16a34a;
        border: 1px solid #bbf7d0;
    }

    .tab-active {
        border-bottom: 2px solid #13ec49;
        color: #13ec49;
    }
</style>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="px-8 py-6 flex flex-col gap-8">
    <div>
        <div class="flex items-center gap-2 text-slate-500 text-sm mb-1">
            <a class="hover:text-primary transition-colors" href="<?= base_url('dashboard') ?>">Home</a>
            <span class="material-symbols-outlined text-xs leading-none">chevron_right</span>
            <span class="text-slate-900 dark:text-slate-300 font-medium">Configuración del Sistema</span>
        </div>
        <h2 class="text-3xl font-bold text-slate-900 dark:text-white">Configuración</h2>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

        <!-- CONFIGURACIÓN DE CAJAS -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 flex flex-col overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">account_balance_wallet</span>
                <h3 class="font-bold text-slate-900 dark:text-white">Horario de Cierre de Cajas</h3>
            </div>
            <div class="p-6 space-y-4">
                <?php if (empty($cajas)): ?>
                    <p class="text-sm text-slate-500">No hay cajas registradas.</p>
                <?php else: ?>
                    <?php foreach ($cajas as $c): ?>
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-800">
                            <div>
                                <p class="text-sm font-bold text-slate-900 dark:text-white"><?= $c['nombre_caja'] ?></p>
                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest">Sede: <?= $c['nombre_sucursal'] ?></p>
                            </div>
                            <div class="flex items-center gap-3">
                                <input type="time" id="caja_hora_<?= $c['id'] ?>" value="<?= $c['hora_cierre'] ?>"
                                    class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-sm px-2 focus:ring-primary outline-none h-9">
                                <button onclick="actualizarHoraCaja(<?= $c['id'] ?>)"
                                    class="size-9 flex items-center justify-center bg-primary text-slate-900 rounded-lg hover:shadow-lg hover:shadow-primary/20 transition-all">
                                    <span class="material-symbols-outlined text-base">save</span>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- CONFIGURACIÓN DE COMPROBANTES CON TABS -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 flex flex-col overflow-hidden shadow-sm">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="material-symbols-outlined text-primary">receipt_long</span>
                    <h3 class="font-bold text-slate-900 dark:text-white">Series y Correlativos</h3>
                </div>
                <button onclick="abrirModalComprobante()"
                    class="px-3 py-1.5 bg-primary text-slate-900 text-xs font-bold rounded-lg hover:shadow-lg transition-all">
                    + Nuevo Correlativo
                </button>
            </div>

            <!-- Tabs por Sucursal -->
            <div class="border-b border-slate-200 dark:border-slate-800 px-6 bg-slate-50/30 dark:bg-slate-900">
                <div class="flex gap-6 overflow-x-auto no-scrollbar">
                    <?php foreach ($sucursales as $index => $s): ?>
                        <button onclick="switchTab(<?= $s['id'] ?>)" id="tab-btn-<?= $s['id'] ?>"
                            class="py-3 text-xs font-bold uppercase tracking-wider text-slate-500 border-b-2 border-transparent transition-all whitespace-nowrap tab-btn <?= $index === 0 ? 'tab-active' : '' ?>">
                            <?= $s['nombre'] ?>
                        </button>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="flex-1">
                <?php foreach ($sucursales as $index => $s): ?>
                    <div id="tab-content-<?= $s['id'] ?>" class="tab-content <?= $index === 0 ? '' : 'hidden' ?>">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left text-sm">
                                <thead class="bg-slate-50 dark:bg-slate-800/50 text-slate-500 dark:text-slate-400 text-[10px] font-bold uppercase tracking-wider">
                                    <tr>
                                        <th class="px-6 py-3">Tipo de Comprobante</th>
                                        <th class="px-6 py-3 text-center">Serie</th>
                                        <th class="px-6 py-3 text-center">Número</th>
                                        <th class="px-6 py-3 text-center">Ambiente</th>
                                        <th class="px-6 py-3 text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-100 dark:divide-slate-800">
                                    <?php
                                    $configsSede = array_filter($config_comprobantes, function ($cfg) use ($s) {
                                        return $cfg['sucursal_id'] == $s['id'];
                                    });
                                    ?>
                                    <?php if (empty($configsSede)): ?>
                                        <tr>
                                            <td colspan="5" class="px-6 py-10 text-center text-slate-500 italic">No hay correlativos configurados para esta sede.</td>
                                        </tr>
                                    <?php else: ?>
                                        <?php foreach ($configsSede as $cfg): ?>
                                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors">
                                                <td class="px-6 py-4">
                                                    <p class="font-medium text-slate-900 dark:text-white"><?= $cfg['descripcion'] ?></p>
                                                </td>
                                                <td class="px-6 py-4 text-center font-mono text-xs"><?= $cfg['serie'] ?></td>
                                                <td class="px-6 py-4 text-center font-bold text-slate-700 dark:text-slate-300"><?= str_pad($cfg['numero'], 6, '0', STR_PAD_LEFT) ?></td>
                                                <td class="px-6 py-4 text-center">
                                                    <?php if ($cfg['tipo_envio_sunat'] == 'Producción'): ?>
                                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase badge-produccion">Producción</span>
                                                    <?php else: ?>
                                                        <span class="px-2 py-0.5 rounded-full text-[9px] font-bold uppercase badge-prueba">Prueba</span>
                                                    <?php endif; ?>
                                                </td>
                                                <td class="px-6 py-4 text-right">
                                                    <div class="flex justify-end gap-1">
                                                        <button onclick='editarComprobante(<?= json_encode($cfg) ?>)' class="text-slate-400 hover:text-primary transition-colors p-1">
                                                            <span class="material-symbols-outlined text-lg">edit</span>
                                                        </button>
                                                        <button onclick="eliminarComprobante(<?= $cfg['id'] ?>)" class="text-slate-400 hover:text-rose-500 transition-colors p-1">
                                                            <span class="material-symbols-outlined text-lg">delete</span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- CONFIGURACIÓN DE ENVÍO SUNAT POR SUCURSAL -->
        <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 flex flex-col overflow-hidden shadow-sm lg:col-span-2">
            <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900 flex items-center gap-3">
                <span class="material-symbols-outlined text-primary">hub</span>
                <h3 class="font-bold text-slate-900 dark:text-white">Envío SUNAT por Sucursal</h3>
            </div>
            <div class="p-6">
                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
                    <?php foreach ($sucursales as $s): ?>
                        <div class="flex items-center justify-between p-4 bg-slate-50 dark:bg-slate-800/50 rounded-xl border border-slate-100 dark:border-slate-800">
                            <div class="flex-1 text-left">
                                <p class="text-sm font-bold text-slate-900 dark:text-white"><?= $s['nombre'] ?></p>
                                <p class="text-[10px] text-slate-500 uppercase font-bold tracking-widest"><?= $s['codigo_anexo'] ?? 'Sin Código' ?></p>
                            </div>
                            <div class="flex items-center gap-2">
                                <select id="sucursal_envio_<?= $s['id'] ?>"
                                    class="bg-white dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-lg text-xs px-2 py-1.5 focus:ring-primary outline-none transition-all font-bold">
                                    <option value="prueba" <?= $s['tipo_envio_sunat'] == 'prueba' ? 'selected' : '' ?>>Prueba</option>
                                    <option value="produccion" <?= $s['tipo_envio_sunat'] == 'produccion' ? 'selected' : '' ?>>Producción</option>
                                </select>
                                <button onclick="actualizarSucursal(<?= $s['id'] ?>)"
                                    class="size-8 flex items-center justify-center bg-primary text-slate-900 rounded-lg hover:shadow-lg hover:shadow-primary/20 transition-all">
                                    <span class="material-symbols-outlined text-sm">save</span>
                                </button>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Configuración Comprobante -->
<div id="compModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center p-4">
    <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm" onclick="cerrarModal()"></div>
    <div class="relative w-full max-w-lg bg-white dark:bg-slate-900 rounded-2xl shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in-95 duration-200">
        <div class="px-6 py-4 border-b border-slate-200 dark:border-slate-800 flex items-center justify-between bg-slate-50 dark:bg-slate-900">
            <h3 id="compModalTitle" class="text-lg font-bold text-slate-900 dark:text-white">Configurar Correlativo</h3>
            <button onclick="cerrarModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-200 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <form id="formComprobante" class="p-6 space-y-5">
            <input type="hidden" name="id" id="comp_id">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">Sede / Sucursal</label>
                    <select name="sucursal_id" id="comp_sucursal" required class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm py-2 px-3 outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        <option value="">Seleccionar Sede...</option>
                        <?php foreach ($sucursales as $s): ?>
                            <option value="<?= $s['id'] ?>"><?= $s['nombre'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">Tipo de Comprobante</label>
                    <select name="comprobante_id" id="comp_tipo" required class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm py-2 px-3 outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all">
                        <option value="">Seleccionar...</option>
                        <?php foreach ($tipos_comprobante as $tc): ?>
                            <option value="<?= $tc['id_tipodoc_electronico'] ?>"><?= $tc['descripcion'] ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">Serie (Ej: F001, B001)</label>
                    <input type="text" name="serie" id="comp_serie" required maxlength="4" placeholder="F001"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm py-2.5 px-3 outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-mono">
                </div>
                <div class="space-y-1.5">
                    <label class="block text-[11px] font-bold text-slate-500 uppercase">Número Siguiente</label>
                    <input type="number" name="numero" id="comp_numero" required placeholder="1" min="1"
                        class="w-full bg-slate-50 dark:bg-slate-800 border-slate-200 dark:border-slate-700 rounded-xl text-sm py-2.5 px-3 outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all font-bold">
                </div>
            </div>

            <div class="space-y-1.5">
                <label class="block text-[11px] font-bold text-slate-500 uppercase">Ambiente / Tipo de Envío</label>
                <div class="grid grid-cols-2 gap-4">
                    <label class="flex items-center gap-3 p-3 border-2 border-slate-100 dark:border-slate-800 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                        <input type="radio" name="tipo_envio_sunat" value="Prueba" id="envio_prueba" checked class="w-4 h-4 text-primary focus:ring-primary">
                        <div>
                            <p class="text-sm font-bold">Prueba</p>
                            <p class="text-[10px] text-slate-500">BETA / Desarrollo</p>
                        </div>
                    </label>
                    <label class="flex items-center gap-3 p-3 border-2 border-slate-100 dark:border-slate-800 rounded-xl cursor-pointer hover:bg-slate-50 dark:hover:bg-slate-800 transition-all has-[:checked]:border-primary has-[:checked]:bg-primary/5">
                        <input type="radio" name="tipo_envio_sunat" value="Producción" id="envio_produccion" class="w-4 h-4 text-primary focus:ring-primary">
                        <div>
                            <p class="text-sm font-bold">Producción</p>
                            <p class="text-[10px] text-slate-500">SUNAT Real</p>
                        </div>
                    </label>
                </div>
            </div>

            <div class="pt-4 flex justify-end gap-3">
                <button type="button" onclick="cerrarModal()" class="px-4 py-2 text-sm font-bold text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-all">Cancelar</button>
                <button type="submit" class="px-8 py-2.5 bg-primary text-slate-900 font-bold rounded-xl hover:shadow-lg hover:shadow-primary/30 transition-all">Guardar Configuración</button>
            </div>
        </form>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    const bUrl = '<?= base_url() ?>';
    const cleanBaseUrl = bUrl.endsWith('/') ? bUrl.slice(0, -1) : bUrl;

    function switchTab(sucursalId) {
        // Hide all contents
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        // Remove active class from all buttons
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('tab-active'));

        // Show current
        document.getElementById(`tab-content-${sucursalId}`).classList.remove('hidden');
        document.getElementById(`tab-btn-${sucursalId}`).classList.add('tab-active');
    }

    function actualizarHoraCaja(id) {
        const horaInput = document.getElementById(`caja_hora_${id}`);
        const hora = horaInput.value;
        const btn = event.currentTarget;

        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-base animate-spin">sync</span>';

        const formData = new FormData();
        formData.append('id', id);
        formData.append('hora_cierre', hora);

        fetch(`${cleanBaseUrl}/configuracion/guardar_caja`, {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Actualizado!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-base">save</span>';
            });
    }

    function actualizarSucursal(id) {
        const envioInput = document.getElementById(`sucursal_envio_${id}`);
        const tipo_envio = envioInput.value;
        const btn = event.currentTarget;

        btn.disabled = true;
        btn.innerHTML = '<span class="material-symbols-outlined text-sm animate-spin">sync</span>';

        const formData = new FormData();
        formData.append('id', id);
        formData.append('tipo_envio_sunat', tipo_envio);

        fetch(`${cleanBaseUrl}/configuracion/guardar_sucursal`, {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Sucursal Actualizada!',
                        text: res.message,
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            })
            .finally(() => {
                btn.disabled = false;
                btn.innerHTML = '<span class="material-symbols-outlined text-sm">save</span>';
            });
    }

    function abrirModalComprobante() {
        document.getElementById('comp_id').value = '';
        document.getElementById('formComprobante').reset();
        document.getElementById('envio_prueba').checked = true;
        document.getElementById('compModalTitle').textContent = 'Configurar Correlativo';
        document.getElementById('compModal').classList.remove('hidden');
    }

    function cerrarModal() {
        document.getElementById('compModal').classList.add('hidden');
    }

    function editarComprobante(data) {
        document.getElementById('comp_id').value = data.id;
        document.getElementById('comp_sucursal').value = data.sucursal_id;
        document.getElementById('comp_tipo').value = data.comprobante_id;
        document.getElementById('comp_serie').value = data.serie;
        document.getElementById('comp_numero').value = data.numero;

        if (data.tipo_envio_sunat == 'Producción') {
            document.getElementById('envio_produccion').checked = true;
        } else {
            document.getElementById('envio_prueba').checked = true;
        }

        document.getElementById('compModalTitle').textContent = 'Editar Correlativo';
        document.getElementById('compModal').classList.remove('hidden');
    }

    function eliminarComprobante(id) {
        Swal.fire({
            title: '¿Eliminar correlativo?',
            text: "Se borrará la serie y numeración configurada.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#13ec49',
            cancelButtonColor: '#f43f5e',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`${cleanBaseUrl}/configuracion/eliminar_comprobante/${id}`)
                    .then(r => r.json())
                    .then(res => {
                        if (res.status === 'success') location.reload();
                    });
            }
        });
    }

    document.getElementById('formComprobante').onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        fetch(`${cleanBaseUrl}/configuracion/guardar_comprobante`, {
                method: 'POST',
                body: formData
            })
            .then(r => r.json())
            .then(res => {
                if (res.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Guardado!',
                        timer: 1000,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire('Error', res.message, 'error');
                }
            });
    };
</script>
<?= $this->endSection() ?>