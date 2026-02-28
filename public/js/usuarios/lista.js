$(document).ready(function () {
  const userModal = document.getElementById("userModal");
  const openUserModalBtn = document.getElementById("openUserModalBtn");
  const closeUserModalBtn = document.getElementById("closeUserModalBtn");
  const cancelUserModalBtn = document.getElementById("cancelUserModalBtn");
  const modalOverlay = document.getElementById("modalOverlay");
  const userModalTitle = document.getElementById("userModalTitle");
  const formUsuario = document.getElementById("formUsuario");

  const toggleModal = () => {
    userModal.classList.toggle("hidden");
  };

  let table = $("#usersTable").DataTable({
    ajax: {
      url: "/usuarios/listar",
      dataSrc: "data",
    },
    columns: [
      {
        data: null,
        className: "px-6 py-3 text-xs text-slate-500",
        render: (data, type, row, meta) => meta.row + 1,
      },
      {
        data: "usuario",
        className:
          "px-6 py-3 text-sm font-semibold text-slate-900 dark:text-white",
      },
      {
        data: null,
        className: "px-6 py-3 text-sm text-slate-600 dark:text-slate-400",
        render: (data, type, row) => `${row.nombres} ${row.apellidos}`,
      },
      {
        data: "nombre_perfil",
        className: "px-6 py-3 text-xs text-slate-600 dark:text-slate-400",
      },
      {
        data: "nombre_sucursal",
        className: "px-6 py-3 text-xs text-slate-600 dark:text-slate-400",
      },
      {
        data: null,
        className: "px-6 py-3 text-right",
        render: function (data, type, row) {
          return `
                        <button class="text-slate-400 hover:text-primary transition-colors p-1 edit-user-btn"
                            data-id="${row.id}">
                            <span class="material-symbols-outlined text-lg">edit</span>
                        </button>
                        <button class="text-slate-400 hover:text-rose-500 transition-colors p-1 delete-user-btn"
                            data-id="${row.id}" data-nombre="${row.usuario}">
                            <span class="material-symbols-outlined text-lg">delete</span>
                        </button>
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

  // Open modal for new user
  if (openUserModalBtn) {
    openUserModalBtn.addEventListener("click", () => {
      userModalTitle.textContent = "Registrar Nuevo Usuario";
      document.getElementById("user_id").value = "0";
      formUsuario.reset();
      document.getElementById("user_password").required = true;
      document.getElementById("user_password").placeholder =
        "Contraseña obligatoria";
      document.getElementById("containerAlmacen").classList.add("hidden");
      document.getElementById("user_almacen").required = false;
      toggleModal();
    });
  }

  // Toggle Almacen field based on Profile
  $("#user_perfil").on("change", function () {
    const perfilId = this.value;
    const container = document.getElementById("containerAlmacen");
    const selectAlmacen = document.getElementById("user_almacen");

    if (perfilId == "2") {
      // 2 = Cajero
      container.classList.remove("hidden");
      selectAlmacen.required = true;
    } else {
      container.classList.add("hidden");
      selectAlmacen.required = false;
      selectAlmacen.value = "";
    }
  });

  // Edit user
  $("#usersTable").on("click", ".edit-user-btn", function () {
    const id = this.dataset.id;
    fetch(`/usuarios/get/${id}`)
      .then((res) => res.json())
      .then((res) => {
        if (res.status === "success") {
          const data = res.data;
          userModalTitle.textContent = "Editar Usuario";
          document.getElementById("user_id").value = data.id;
          document.getElementById("user_usuario").value = data.usuario;
          document.getElementById("user_nombres").value = data.nombres;
          document.getElementById("user_apellidos").value = data.apellidos;
          document.getElementById("user_perfil").value = data.perfil_id;
          document.getElementById("user_sucursal").value = data.sucursal_id;

          document.getElementById("user_password").required = false;
          document.getElementById("user_password").placeholder =
            "Dejar vacío para no cambiar";
          document.getElementById("user_password").value = "";

          // Show/Hide Almacen based on profile
          const container = document.getElementById("containerAlmacen");
          const selectAlmacen = document.getElementById("user_almacen");
          if (data.perfil_id == "2") {
            container.classList.remove("hidden");
            selectAlmacen.required = true;
            selectAlmacen.value = data.almacen_id || "";
          } else {
            container.classList.add("hidden");
            selectAlmacen.required = false;
            selectAlmacen.value = "";
          }

          toggleModal();
        }
      });
  });

  // Delete user
  $("#usersTable").on("click", ".delete-user-btn", function () {
    const id = this.dataset.id;
    const nombre = this.dataset.nombre;
    Swal.fire({
      title: "¿Estás seguro?",
      text: `Vas a eliminar al usuario "${nombre}".`,
      icon: "warning",
      showCancelButton: true,
      confirmButtonColor: "#13ec49",
      cancelButtonColor: "#f43f5e",
      confirmButtonText: "Sí, eliminar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        fetch(`/usuarios/eliminar/${id}`)
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
  if (formUsuario) {
    formUsuario.addEventListener("submit", function (e) {
      e.preventDefault();
      const formData = new FormData(this);
      fetch("/usuarios/guardar", {
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
          Swal.fire("Error", "Ocurrió un error al guardar", "error");
        });
    });
  }

  // Modal Close
  if (closeUserModalBtn)
    closeUserModalBtn.addEventListener("click", toggleModal);
  if (cancelUserModalBtn)
    cancelUserModalBtn.addEventListener("click", toggleModal);
  if (modalOverlay) modalOverlay.addEventListener("click", toggleModal);
});
