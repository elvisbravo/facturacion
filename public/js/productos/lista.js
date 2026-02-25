// Product Modal elements
const productModal = document.getElementById("productModal");
const openModalBtn = document.getElementById("openProductModalBtn");
const closeModalBtn = document.getElementById("closeProductModalBtn");
const cancelModalBtn = document.getElementById("cancelProductModalBtn");
const modalOverlay = document.getElementById("modalOverlay");
const productModalTitle = document.getElementById("productModalTitle");

// Form elements
const formProducto = document.getElementById("formProducto");
const idProd = document.getElementById("id_prod");
const prodSku = document.getElementById("prod_sku");
const prodNombre = document.getElementById("prod_nombre");
const prodCategoria = document.getElementById("prod_categoria");
const prodUnidad = document.getElementById("prod_unidad_medida");
const prodPrecioCompra = document.getElementById("prod_precio_compra");
const prodPrecioConIgv = document.getElementById("prod_precio_venta_con_igv");
const prodPrecioSinIgv = document.getElementById("prod_precio_venta_sin_igv");
const prodStockInicial = document.getElementById("prod_stock_inicial");
const prodStockMinimo = document.getElementById("prod_stock_minimo");
const prodPeso = document.getElementById("prod_peso");
const prodSucursal = document.getElementById("prod_sucursal");
const prodAlmacen = document.getElementById("prod_almacen");

const toggleModal = () => {
    productModal.classList.toggle("hidden");
    // Hide presentations section when opening/closing main modal
    document.getElementById("presentationsSection").classList.add("hidden");
};

// Global Table Variable
let table;

// Function to Initialize DataTable
function initDataTable() {
    table = $('#productsTable').DataTable({
        ajax: {
            url: '/productos/listar',
            dataSrc: 'data',
            data: function (d) {
                d.almacen_id = $('#warehouseFilter').val();
            }
        },
        columns: [
            {
                data: null,
                className: 'px-6 py-3 text-xs text-slate-500',
                render: (data, type, row, meta) => meta.row + 1
            },
            {
                data: null,
                render: function (data, type, row) {
                    const imgPath = row.imagen_producto ? `/uploads/productos/${row.imagen_producto}` : '/uploads/productos/producto.png';
                    return `
                        <div class="w-10 h-10 rounded bg-slate-100 dark:bg-slate-800 overflow-hidden">
                            <img class="w-full h-full object-cover" src="${imgPath}" alt="${row.nombre_producto}" onerror="this.src='https://via.placeholder.com/40?text=PS'">
                        </div>
                    `;
                }
            },
            {
                data: 'nombre_producto',
                className: 'px-6 py-3 text-sm font-semibold text-slate-900 dark:text-white'
            },
            {
                data: 'unidad',
                className: 'px-6 py-3 text-xs text-slate-600 dark:text-slate-400'
            },
            {
                data: 'precio_compra',
                render: (data) => `S/ ${parseFloat(data || 0).toFixed(2)}`,
                className: 'px-6 py-3 text-sm text-slate-600 dark:text-slate-400'
            },
            {
                data: 'precio_venta',
                render: (data) => `S/ ${parseFloat(data || 0).toFixed(2)}`,
                className: 'px-6 py-3 text-sm font-bold text-slate-900 dark:text-white text-center'
            },
            {
                data: 'stock',
                render: function (data, type, row) {
                    const level = Math.min(row.stock, 100);
                    const color = row.stock < 10 ? 'rose' : (row.stock < 20 ? 'amber' : 'emerald');
                    return `
                        <div class="flex flex-col items-center gap-1">
                            <span class="text-sm font-medium text-slate-900 dark:text-white">${row.stock}</span>
                            <div class="w-20 bg-slate-200 dark:bg-slate-700 h-1 rounded-full overflow-hidden">
                                <div class="bg-${color}-500 h-full" style="width: ${level}%"></div>
                            </div>
                        </div>
                    `;
                }
            },
            {
                data: null,
                className: 'px-6 py-3 text-right',
                render: function (data, type, row) {
                    return `
                        <button class="text-slate-400 hover:text-primary transition-colors p-1 edit-prod-btn"
                            data-id="${row.id}">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>
                        <button class="text-slate-400 hover:text-rose-500 transition-colors p-1 delete-prod-btn"
                            data-id="${row.id}" data-nombre="${row.nombre_producto}">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
                    `;
                }
            }
        ],
        language: {
            url: 'https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json',
            paginate: {
                previous: '<span class="material-symbols-outlined text-base mr-1">arrow_back</span> Anterior',
                next: 'Siguiente <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>'
            }
        },
        pageLength: 10,
        dom: 'rt<"dt-custom-footer"ip>'
    });
}

// Function to load categories into select
function loadCategories() {
    fetch('/categorias/listar')
        .then(response => response.json())
        .then(data => {
            const selects = [prodCategoria, document.getElementById('categoryFilter')];
            selects.forEach(select => {
                if (select) {
                    const currentVal = select.value;
                    const isFilter = select.id === 'categoryFilter';
                    const defaultText = isFilter ? 'Todas las Categorías' : 'Seleccionar Categoría';
                    const defaultValue = isFilter ? '0' : '';

                    select.innerHTML = `<option value="${defaultValue}">${defaultText}</option>`;
                    data.forEach(cat => {
                        select.innerHTML += `<option value="${cat.id}">${cat.nombre_categoria}</option>`;
                    });

                    if (currentVal) {
                        select.value = currentVal;
                    }
                }
            });
        });
}

// Function to load units into select
function loadUnits() {
    fetch('/unidad_medida/listar')
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                const select = document.getElementById('prod_unidad_medida');
                if (select) {
                    const currentVal = select.value;
                    select.innerHTML = '<option value="">Seleccionar Unidad</option>';
                    res.data.forEach(unit => {
                        select.innerHTML += `<option value="${unit.idunidad}">${unit.nombre}</option>`;
                    });
                    select.value = currentVal;
                }
            }
        });
}

// Function to load storage locations (almacenes) into select
function loadAlmacenes() {
    fetch('/almacen/listar')
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                const modalSelect = document.getElementById('prod_almacen');
                const filterSelect = document.getElementById('warehouseFilter');

                if (modalSelect) {
                    const currentVal = modalSelect.value;
                    modalSelect.innerHTML = '<option value="">Seleccionar Almacén</option>';
                    res.data.forEach(almacen => {
                        modalSelect.innerHTML += `<option value="${almacen.id}">${almacen.nombre}</option>`;
                    });
                    modalSelect.value = currentVal;
                }

                if (filterSelect) {
                    const currentFilter = filterSelect.value;
                    filterSelect.innerHTML = '<option value="0">Todos los Almacenes</option>';
                    res.data.forEach(almacen => {
                        filterSelect.innerHTML += `<option value="${almacen.id}">${almacen.nombre}</option>`;
                    });
                    if (currentFilter) {
                        filterSelect.value = currentFilter;
                    }
                }
            }
        });
}

// Function to load tax types (tipo IGV) into select
function loadTaxTypes() {
    fetch('/tipo_afectacion_igv/listar')
        .then(response => response.json())
        .then(res => {
            if (res.status === 'success') {
                const select = document.getElementById('prod_tipo_igv');
                if (select) {
                    const currentVal = select.value;
                    select.innerHTML = '<option value="">Seleccionar Tipo IGV</option>';
                    res.data.forEach(tax => {
                        select.innerHTML += `<option value="${tax.id_tipoafectacionigv}">${tax.descripcion}</option>`;
                    });
                    select.value = currentVal || '10'; // Default to 10 if no value
                }
            }
        });
}

// Presentation Row Generation
function addPresentationRow(data = {}) {
    const tbody = document.getElementById("presentationsTableBody");
    const rowId = Date.now();
    const tr = document.createElement("tr");
    tr.className = "hover:bg-slate-50 dark:hover:bg-slate-800/50 transition-colors";
    tr.innerHTML = `
        <td class="px-3 py-2">
            <input type="text" name="p_nombre[]" value="${data.nombre || ''}" class="w-full bg-white dark:bg-slate-800 border-none p-0 text-xs focus:ring-0" placeholder="Ej: Bolsa x50">
        </td>
        <td class="px-3 py-2">
            <input type="number" step="any" name="p_factor[]" value="${data.factor || '1'}" class="w-12 mx-auto bg-white dark:bg-slate-800 border-none p-0 text-xs text-center focus:ring-0" placeholder="1">
        </td>
        <td class="px-3 py-2">
            <input type="number" step="any" name="p_precio[]" value="${data.precio || ''}" class="w-16 bg-white dark:bg-slate-800 border-none p-0 text-xs focus:ring-0 font-bold" placeholder="0.00">
        </td>
        <td class="px-3 py-2">
            <input type="text" name="p_sku[]" value="${data.sku || ''}" class="w-full bg-white dark:bg-slate-800 border-none p-0 text-xs focus:ring-0 font-mono" placeholder="775...">
        </td>
        <td class="px-3 py-2 text-right">
            <button type="button" class="text-rose-400 hover:text-rose-600 btn-remove-row">
                <span class="material-symbols-outlined text-sm">delete</span>
            </button>
        </td>
    `;
    tbody.appendChild(tr);

    tr.querySelector(".btn-remove-row").addEventListener("click", () => {
        tr.remove();
        if (tbody.children.length === 0) {
            document.getElementById("presentationsSection").classList.add("hidden");
        }
    });
}

// Pricing Logic
function updatePrices(from) {
    const taxRate = 1.18; // Fixed for now, could be dynamic based on Tipo IGV
    if (from === 'con') {
        const val = parseFloat(prodPrecioConIgv.value) || 0;
        prodPrecioSinIgv.value = (val / taxRate).toFixed(3);
    } else {
        const val = parseFloat(prodPrecioSinIgv.value) || 0;
        prodPrecioConIgv.value = (val * taxRate).toFixed(2);
    }
}

// Event Listeners
document.addEventListener("DOMContentLoaded", function () {
    initDataTable();
    loadCategories();
    loadUnits();
    loadAlmacenes();
    loadTaxTypes();

    // Initialize Select2
    $('.select2-search').select2({
        dropdownParent: $('#productModal'),
        width: '100%'
    });

    // Opening Modal for New Product
    if (openModalBtn) {
        openModalBtn.addEventListener("click", () => {
            productModalTitle.textContent = "Registrar Nuevo Producto";
            idProd.value = "0";
            formProducto.reset();
            $('.select2-search').val('').trigger('change');
            document.getElementById("presentationsTableBody").innerHTML = "";
            toggleModal();
        });
    }

    // Code Generator
    document.getElementById("btnGenerateCode").addEventListener("click", () => {
        const random = "PROD-" + Math.random().toString(36).substring(2, 8).toUpperCase();
        prodSku.value = random;
    });

    // Price Sync
    prodPrecioConIgv.addEventListener("input", () => updatePrices('con'));
    prodPrecioSinIgv.addEventListener("input", () => updatePrices('sin'));

    // Toggle Presentations
    document.getElementById("btnAddPresentations").addEventListener("click", () => {
        const section = document.getElementById("presentationsSection");
        section.classList.toggle("hidden");
        if (!section.classList.contains("hidden") && document.getElementById("presentationsTableBody").children.length === 0) {
            addPresentationRow();
        }
    });

    document.getElementById("btnNewPresentation").addEventListener("click", () => addPresentationRow());

    // Custom Search
    $('#tableSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Custom Length
    $('#tableLength').on('change', function () {
        table.page.len(this.value).draw();
    });

    // Category Filter
    $('#categoryFilter').on('change', function () {
        table.column(3).search(this.options[this.selectedIndex].text === 'Todas las Categorías' ? '' : this.options[this.selectedIndex].text).draw();
    });

    // Warehouse Filter
    $('#warehouseFilter').on('change', function () {
        table.ajax.reload();
    });

    // Handle Edit Buttons (Requires loading all fields)
    $('#productsTable').on('click', '.edit-prod-btn', function () {
        const id = this.dataset.id;
        fetch(`/productos/get/${id}`)
            .then(res => res.json())
            .then(data => {
                productModalTitle.textContent = "Editar Producto";
                idProd.value = data.id;
                prodNombre.value = data.nombre_producto;
                prodSku.value = data.codigo;
                prodCategoria.value = data.categoria_id;
                $('.select2-search').val(data.unidad_medida || 'NIU').trigger('change');

                // Set radio values (moneda, afecto_icbper)
                const radiosMoneda = document.getElementsByName('moneda');
                radiosMoneda.forEach(r => { if (r.value === data.moneda) r.checked = true; });

                const radiosIcbper = document.getElementsByName('afecto_icbper');
                radiosIcbper.forEach(r => { if (r.value == data.afecto_icbper) r.checked = true; });

                document.getElementById('prod_tipo_igv').value = data.tipo_igv || '10';
                prodPrecioCompra.value = data.precio_compra;
                prodPrecioConIgv.value = data.precio_venta_con_igv;
                prodPrecioSinIgv.value = data.precio_venta_sin_igv;
                prodStockInicial.value = data.stock_inicial;
                prodStockMinimo.value = data.stock_minimo;
                prodPeso.value = data.peso;
                prodSucursal.value = data.sucursal;
                if (prodAlmacen) prodAlmacen.value = data.almacen || 'Almacén Central';

                toggleModal();
            });
    });

    // Handle Delete
    $('#productsTable').on('click', '.delete-prod-btn', function () {
        const id = this.dataset.id;
        const nombre_producto = this.dataset.nombre;
        Swal.fire({
            title: '¿Estás seguro?',
            text: `Vas a eliminar "${nombre_producto}".`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#13ec49',
            cancelButtonColor: '#f43f5e',
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/productos/delete/${id}`)
                    .then(r => r.json())
                    .then(res => {
                        if (res.status === 'success') {
                            table.ajax.reload();
                            Swal.fire('¡Eliminado!', res.message, 'success');
                        }
                    });
            }
        });
    });

    // Form Submit
    if (formProducto) {
        formProducto.addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch("/productos/guardar", {
                method: "POST",
                body: formData
            })
                .then(r => r.json())
                .then(data => {
                    if (data.status === "success") {
                        toggleModal();
                        table.ajax.reload();
                        Swal.fire("¡Éxito!", data.message, "success");
                    } else {
                        Swal.fire("Error", data.message, "error");
                    }
                });
        });
    }

    // Modal Close
    if (closeModalBtn) closeModalBtn.addEventListener("click", toggleModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener("click", toggleModal);
    if (modalOverlay) modalOverlay.addEventListener("click", toggleModal);
});