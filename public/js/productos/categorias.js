// Category Modal elements
const categoryModal = document.getElementById("categoryModal");
const openModalBtn = document.getElementById("openCategoryModalBtn");
const closeModalBtn = document.getElementById("closeCategoryModalBtn");
const cancelModalBtn = document.getElementById("cancelCategoryModalBtn");
const modalOverlay = document.getElementById("modalOverlay");
const modalTitle = document.getElementById("categoryModalTitle");

// Form elements
const catNombre = document.getElementById("cat_nombre");
const catDescripcion = document.getElementById("cat_descripcion");
const idCat = document.getElementById("id_cat");
const formCategoria = document.getElementById("formCategoria");

const toggleModal = () => categoryModal.classList.toggle("hidden");

// Global Table Variable
let table;

// Function to Initialize DataTable
function initDataTable() {
    table = $('#categoriesTable').DataTable({
        ajax: {
            url: '/categorias/listar',
            dataSrc: ''
        },
        columns: [
            {
                data: 'id',
                className: 'px-6 py-3 text-xs font-mono text-slate-500'
            },
            {
                data: 'nombre_categoria',
                className: 'px-6 py-3 text-sm font-semibold text-slate-900 dark:text-white'
            },
            {
                data: 'descripcion',
                className: 'px-6 py-3 text-sm text-slate-600 dark:text-slate-400'
            },
            {
                data: 'total_productos',
                className: 'px-6 py-3 text-sm text-slate-600 dark:text-slate-400'
            },
            {
                data: null,
                className: 'px-6 py-3 text-right',
                render: function (data, type, row) {
                    return `
                        <button class="text-slate-400 hover:text-primary transition-colors p-1 edit-cat-btn"
                            data-id="${row.id}" data-nombre="${row.nombre_categoria}" data-descripcion="${row.descripcion}">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>
                        <button class="text-slate-400 hover:text-rose-500 transition-colors p-1 delete-cat-btn"
                            data-id="${row.id}" data-nombre="${row.nombre_categoria}">
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
        dom: 'rt<"dt-custom-footer"ip>',
        drawCallback: function () { }
    });
}

// Event Listeners
document.addEventListener("DOMContentLoaded", function () {
    // Initialize Table
    initDataTable();

    // Opening Modal for New Category
    if (openModalBtn) {
        openModalBtn.addEventListener("click", () => {
            modalTitle.textContent = "Registrar Nueva Categoría";
            idCat.value = "0";
            catNombre.value = "";
            catDescripcion.value = "";
            toggleModal();
        });
    }

    // Custom Search
    $('#tableSearch').on('keyup', function () {
        table.search(this.value).draw();
    });

    // Custom Length
    $('#tableLength').on('change', function () {
        table.page.len(this.value).draw();
    });

    // Handle Edit Buttons
    $('#categoriesTable').on('click', '.edit-cat-btn', function () {
        const data = this.dataset;
        modalTitle.textContent = "Editar Categoría";
        idCat.value = data.id;
        catNombre.value = data.nombre;
        catDescripcion.value = data.descripcion;
        toggleModal();
    });

    // Handle Delete Buttons
    $('#categoriesTable').on('click', '.delete-cat-btn', function () {
        const id = this.dataset.id;
        const nombre = this.dataset.nombre;

        Swal.fire({
            title: '¿Estás seguro?',
            text: `Vas a eliminar la categoría "${nombre}". Esta acción no se puede deshacer.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#13ec49',
            cancelButtonColor: '#f43f5e',
            mask: true,
            confirmButtonText: 'Sí, eliminar',
            cancelButtonText: 'Cancelar',
            background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
            color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
        }).then((result) => {
            if (result.isConfirmed) {
                fetch(`/categorias/delete/${id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            table.ajax.reload();
                            Swal.fire({
                                title: '¡Eliminado!',
                                text: data.message,
                                icon: 'success',
                                confirmButtonColor: '#13ec49',
                                background: document.documentElement.classList.contains('dark') ? '#0f172a' : '#fff',
                                color: document.documentElement.classList.contains('dark') ? '#fff' : '#000'
                            });
                        }
                    });
            }
        });
    });

    // Handle Form Submission
    if (formCategoria) {
        formCategoria.addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(this);
            fetch("/categorias/guardar", {
                method: "POST",
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        toggleModal();
                        table.ajax.reload();
                        Swal.fire({
                            title: "¡Éxito!",
                            text: data.message,
                            icon: "success",
                            confirmButtonColor: "#13ec49",
                            background: document.documentElement.classList.contains("dark") ? "#0f172a" : "#fff",
                            color: document.documentElement.classList.contains("dark") ? "#fff" : "#000"
                        });
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: data.message,
                            icon: "error",
                            confirmButtonColor: "#f43f5e",
                            background: document.documentElement.classList.contains("dark") ? "#0f172a" : "#fff",
                            color: document.documentElement.classList.contains("dark") ? "#fff" : "#000"
                        });
                    }
                });
        });
    }

    // Modal Close buttons
    if (closeModalBtn) closeModalBtn.addEventListener("click", toggleModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener("click", toggleModal);
    if (modalOverlay) modalOverlay.addEventListener("click", toggleModal);
});
