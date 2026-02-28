$(document).ready(function () {
  const almacenModal = document.getElementById("almacenModal");
  const openAlmacenModalBtn = document.getElementById("openAlmacenModalBtn");
  const closeAlmacenModalBtn = document.getElementById("closeAlmacenModalBtn");
  const cancelAlmacenModalBtn = document.getElementById(
    "cancelAlmacenModalBtn",
  );
  const modalOverlay = document.getElementById("modalOverlay");
  const almacenModalTitle = document.getElementById("almacenModalTitle");
  const formAlmacen = document.getElementById("formAlmacen");

  const toggleModal = () => {
    almacenModal.classList.toggle("hidden");
  };

  let table = $("#almacenTable").DataTable({
    ajax: {
      url: "/almacen/listar",
      dataSrc: "data",
    },
    columns: [
      {
        data: null,
        className: "px-6 py-4 text-xs text-slate-500",
        render: (data, type, row, meta) => meta.row + 1,
      },
      {
        data: "nombre",
        className:
          "px-6 py-4 text-sm font-semibold text-slate-900 dark:text-white",
      },
      {
        data: "nombre_sucursal",
        className: "px-6 py-4 text-xs text-slate-600 dark:text-slate-400",
      },
      {
        data: null,
        className: "px-6 py-4 text-right",
        render: function (data, type, row) {
          return `
            <div class="flex justify-end gap-1">
              <button class="text-slate-400 hover:text-primary transition-colors p-1 edit-almacen-btn"
                  data-id="${row.id}">
                  <span class="material-symbols-outlined text-lg">edit</span>
              </button>
              <button class="text-slate-400 hover:text-rose-500 transition-colors p-1 delete-almacen-btn"
                  data-id="${row.id}" data-nombre="${row.nombre}">
                  <span class="material-symbols-outlined text-lg">delete</span>
              </button>
            </div>
          `;
        },
      },
    ],
    language: {
      url: "https://cdn.datatables.net/plug-ins/1.13.7/i18n/es-ES.json",
      paginate: {
        previous:
          '<span class="material-symbols-outlined text-base mr-1">arrow_back</span> Anterior',
        next: 'Siguiente <span class="material-symbols-outlined text-base ml-1">arrow_forward</span>',
      },
    },
    pageLength: 10,
    dom: 'rt<"dt-custom-footer"ip>',
  });

  // Custom Search
  $("#tableSearch").on("keyup", function () {
    table.search(this.value).draw();
  });

  // Custom Length
  $("#tableLength").on("change", function () {
    table.page.len(this.value).draw();
  });

  // Open modal for new
  if (openAlmacenModalBtn) {
    openAlmacenModalBtn.addEventListener("click", () => {
      almacenModalTitle.textContent = "Registrar Nuevo Almacén";
      document.getElementById("almacen_id").value = "0";
      formAlmacen.reset();
      toggleModal();
    });
  }

  // Edit flow
  $("#almacenTable").on("click", ".edit-almacen-btn", function () {
    const id = this.dataset.id;
    fetch(`/almacen/get/${id}`)
      .then((res) => res.json())
      .then((res) => {
        if (res.status === "success") {
          const data = res.data;
          almacenModalTitle.textContent = "Editar Almacén";
          document.getElementById("almacen_id").value = data.id;
          document.getElementById("almacen_nombre").value = data.nombre;
          document.getElementById("almacen_sucursal").value = data.sucursal_id;
          toggleModal();
        }
      });
  });

  // Delete flow
  $("#almacenTable").on("click", ".delete-almacen-btn", function () {
    const id = this.dataset.id;
    const nombre = this.dataset.nombre;

    if (id == "1") {
      Swal.fire(
        "Acción no permitida",
        "No se puede eliminar el almacén principal del sistema.",
        "warning",
      );
      return;
    }

    Swal.fire({
      title: "¿Estás seguro?",
      text: `Vas a eliminar el almacén "${nombre}".`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#13ec49",
      cancelButtonColor: "#f43f5e",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`/almacen/eliminar/${id}`)
          .then((r) => r.json())
          .then((res) => {
            if (res.status === "success") {
              table.ajax.reload();
              Swal.fire("¡Eliminado!", res.message, "success");
            } else {
              Swal.fire("Error", res.message, "error");
            }
          });
      }
    });
  });

  // Form Submit
  if (formAlmacen) {
    formAlmacen.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch("/almacen/guardar", {
        method: "POST",
        body: formData,
      })
        .then((r) => r.json())
        .then((data) => {
          if (data.status === "success") {
            toggleModal();
            table.ajax.reload();
            Swal.fire("¡Éxito!", data.message, "success");
          } else {
            Swal.fire("Error", data.message, "error");
          }
        })
        .catch((err) => {
          Swal.fire(
            "Error",
            "Ocurrió un error al procesar la solicitud",
            "error",
          );
        });
    });
  }

  // Close triggers
  if (closeAlmacenModalBtn)
    closeAlmacenModalBtn.addEventListener("click", toggleModal);
  if (cancelAlmacenModalBtn)
    cancelAlmacenModalBtn.addEventListener("click", toggleModal);
  if (modalOverlay) modalOverlay.addEventListener("click", toggleModal);
});
