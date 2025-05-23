const url = new URL(window.location.href);
const params = new URLSearchParams(url.search);

$(function () {
  cargar_perfil();

  if (params.get("view") === "gestionar") {
    base_x_dni();
    listarRegistros(1);
    construirPaginacion();
    borrar_base();
    importar();
    crear_ventas();
    agregar_base_cartera();
    exportar();
  }

  if (params.get("view") === "consultas") {
    listar_consultas();
    filtro_consultas();
    actualizar_consulta();
    crear_ventas();
    agregar_consulta_cartera();
  } else {
    crear_consultas();
    rellenar_consulta();
  }

  if (params.get("view") === "ventas") {
    contar_ld();
    contar_tc();
    contar_ld_monto();
    listar_ventas();
    crear_ventas();
    filtro_ventas();
    actualizar_ventas();
  }

  if (params.get("view") === "usuarios") {
    listar_empleados();
    ventas_x_usuario();
    select_usuarios();
    filtro_empleados();
    actualizar_usuarios();
    crear_usuarios();
  }

  if (params.get("view") === "metas") {
    listar_metas();
    crear_metas();
    actualizar_meta();
    select_usuarios();
    filtro_metas();
  }

  if (params.get("view") === "metasfv") {
    listar_metasfv();
    crear_metasfv();
    actualizar_metasfv();
    filtro_metasfv();
  }

  if (params.get("view") === "cartera") {
    listar_cartera();
    crear_cartera();
    actualizar_cartera();
    crear_ventas();
    cartera_x_dni();
  }

  if (params.get("view") === "inicio") {
    listar_bonos();
    listar_metas_inicio();
    actualizar_bono();
    listar_metas_ventas();
    contar_ld_por_id();
    contar_tc_por_id();
    contar_ld_monto_por_id();
    rellenar_ultima_meta();
  } else {
  }
});

const ventas_x_usuario = function () {
  $("#form_venta_usuario").submit(function (e) {
    e.preventDefault();
    var id_usuario = document.getElementById("id_usuario").value.trim();
    var mes = document.getElementById("mes").value.trim();
    $.ajax({
      url: "controller/ventas.php",
      method: "POST",
      data: {
        id_usuario: id_usuario,
        mes: mes,
        option: "ventas_x_usuario",
      },
      success: function (response) {
        const data = JSON.parse(response);
        let ld_cant_html = ``;
        let tc_cant_html = ``;
        let ld_mont_html = ``;
        //console.log(data);
        if (data.length > 0) {
          data.map((x) => {
            const { ld_cantidad, tc_cantidad, ld_monto } = x;
            ld_cant_html =
              ld_cant_html + `<p class="card-text">Cant. ${ld_cantidad}</p>`;
            tc_cant_html =
              tc_cant_html + `<p class="card-text">Cant. ${tc_cantidad}</p>`;
            ld_mont_html =
              ld_mont_html + `<p class="card-text">S/. ${ld_monto}</p>`;
          });
        } else {
          ld_cant_html = ld_cant_html + `<p class="card-text">Cant. 0</p>`;
          tc_cant_html = tc_cant_html + `<p class="card-text">Cant. 0</p>`;
          ld_mont_html = ld_mont_html + `<p class="card-text">S/. 0.0</p>`;
        }
        $("#ld_cantidad_text").html(ld_cant_html);
        $("#tc_cantidad_text").html(tc_cant_html);
        $("#ld_monto_text").html(ld_mont_html);
      },
    });
  });
};
const listar_metas_inicio = function () {
  $.ajax({
    url: "controller/meta.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((metas_por_usuario) => {
          let mes = null;
          switch (metas_por_usuario.mes) {
            case "1":
              mes = "Enero";
              break;
            case "2":
              mes = "Febrero";
              break;
            case "3":
              mes = "Marzo";
              break;
            case "4":
              mes = "Abril";
              break;
            case "5":
              mes = "Mayo";
              break;
            case "6":
              mes = "Junio";
              break;
            case "7":
              mes = "Julio";
              break;
            case "8":
              mes = "Agosto";
              break;
            case "9":
              mes = "Septiembre";
              break;
            case "10":
              mes = "Octubre";
              break;
            case "11":
              mes = "Noviembre";
              break;
            case "12":
              mes = "Diciembre";
              break;
            default:
              mes = "Mes desconocido";
          }

          html += `
            <tr>
              <th scope="row">${metas_por_usuario.id}</th>
              <td>${metas_por_usuario.ld_cantidad}</td>
              <td>${metas_por_usuario.ld_monto}</td>
              <td>${metas_por_usuario.tc_cantidad}</td>
              <td>${metas_por_usuario.usuario_nombre}</td>
              <td>${mes}</td>
              <td>${metas_por_usuario.cumplido}</td>
            </tr>`;
        });
      } else {
        html = `<tr><td class='text-center' colspan='8'>No se encontraron resultados</td></tr>`;
      }
      $("#listar_metas").html(html);
    },
  });
};

/* -------------------   CARTERA   ---------------------- */

const listar_cartera = function () {
  $.ajax({
    url: "controller/cartera.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { id, nombres, dni, celular, created_at } = x;
          html =
            html +
            `<tr>
              <td>${nombres}</td>
              <td>${dni}</td>
              <td>${celular}</td>
              <td>${created_at}</td>
              <td class="text-center">
                <a onclick="obtener_cartera(${id})"><i class="fa-regular fa-pen-to-square me-2" style="color: #001b2b"></i></a>
                <a onclick="trasladar_venta(${id})"><i class="fa-solid fa-circle-plus me-2" style="color: #001b2b"></i>
                <a onclick="eliminar_cartera(${id})"><i class="fa-solid fa-trash" style="color: #001b2b"></i></a>
              </td>
            </tr>`;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='11'>No se encontraron resultados.</td>`;
      }
      $("#listar_cartera").html(html);
    },
  });
};
const obtener_cartera = function (id) {
  $("#editar-cartera").modal("show");
  $.ajax({
    url: "controller/cartera.php",
    method: "POST",
    data: {
      id: id,
      option: "obtener_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id_car").val(data[i]["id"]);
        $("#nombres_car").val(data[i]["nombres"]);
        $("#dni_car").val(data[i]["dni"]);
        $("#celular_car").val(data[i]["celular"]);
      });
    },
  });
};
const trasladar_venta = function (id) {
  $("#obtener_cartera").modal("show");
  $.ajax({
    url: "controller/cartera.php",
    method: "POST",
    data: {
      id: id,
      option: "obtener_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#car_id").val(data[i]["id"]);
        $("#car_nombres").val(data[i]["nombres"]);
        $("#car_dni").val(data[i]["dni"]);
        $("#car_celular").val(data[i]["celular"]);
      });
    },
  });
};
const crear_cartera = function () {
  $("#formAgregarCartera").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formAgregarCartera")[0]);

    $.ajax({
      url: "controller/cartera.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);
        console.log(response);
        if (response.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_cartera();
          $("#agregar-cartera").modal("hide");
          $("#formAgregarCartera").trigger("reset");
        }
      },
    });
  });
};
const eliminar_cartera = function (id) {
  Swal.fire({
    title: "¿Estás seguro?",
      text: "El cliente será eliminada.",
      showCancelButton: true,
      confirmButtonColor: "rgb(33,219,130)",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
      cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "controller/cartera.php",
        method: "POST",
        data: {
          id: id,
          option: "eliminar_cartera",
        },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.status === "success") {
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3500,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              },
            });
            Toast.fire({
              icon: "success",
              title: response.message,
            });
            listar_cartera();
          } else {
            alert("algo salio mal" + data);
          }
        },
      });
    }
  });
};
const actualizar_cartera = function () {
  $("#formActualizarCartera").submit(function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: "controller/cartera.php",
      method: "POST",
      data: data,
      success: function (data) {
        const response = JSON.parse(data);
        console.log(response.status);
        if (response.status == "success") {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_cartera();
          $("#editar-cartera").modal("hide");
          $("#formActualizarCartera").trigger("reset");
        } else {
          alert("Algo salió mal.");
        }
      },
    });
  });
};
const cartera_x_dni = function () {
  $("#form_filtro_cartera").submit(function (e) {
    e.preventDefault();
    var dni = document.getElementById("c-dni").value.trim();
    $.ajax({
      url: "controller/cartera.php",
      method: "POST",
      data: {
        dni: dni,
        option: "cartera_x_dni",
      },
      success: function (response) {
        const data = JSON.parse(response);
        let html = ``;
        if (data.length > 0) {
          data.map((x) => {
            const { id, dni, nombres, celular, created_at } = x;
            html =
              html +
              `<tr>
              <td>${id}</td>
              <td>${nombres}</td>
              <td>${dni}</td>
              <td>${celular}</td>
              <td>${created_at}</td>
              <td class="text-center">
                <a onclick="obtener_cartera(${id})"><i class="fa-regular fa-pen-to-square me-2" style="color: #001b2b"></i></a>
                <a onclick="trasladar_venta(${id})"><i class="fa-solid fa-circle-plus me-2" style="color: #001b2b"></i>
                <a onclick="eliminar_cartera(${id})"><i class="fa-solid fa-trash" style="color: #001b2b"></i></a>
              </td>
            </tr>`;
          });
        } else {
          Swal.fire({
            title: "No se encontraron campañas.",
            padding: "2em",
          });
          listar_cartera();
        }
        $("#listar_cartera").html(html);
      },
    });
  });
};

/* -------------------   VENTASMETAS   ---------------------- */
const listar_metas_ventas = function () {
  $.ajax({
    url: "controller/metaventa.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((metas_venta) => {
          html += `
            <tr>
           <td class="text-center">${metas_venta.Usuario}</td>
              <td class="text-center">${metas_venta.LDCantidad}</td>
              <td class="text-center">${metas_venta.LDMonto}</td>
              <td class="text-center">${metas_venta.TCCantidad}</td>
              <td class="text-center">${metas_venta.cumplido}</td>
            </tr>`;
        });
      } else {
        html = `<tr><td class='text-center' colspan='6'>No se encontraron resultados</td></tr>`;
      }
      $("#listar_metas_venta").html(html);
    },
  });
};
/* -------------------   PERFIL   ---------------------- */

const cargar_perfil = () => {
  return new Promise((resolve, reject) => {
    try {
      $.ajax({
        url: "controller/usuario.php",
        method: "POST",
        data: { opcion: "obtener_perfil" },
        success: function (data) {
          console.log(data);
          const perfil = JSON.parse(data);
          const { id, nombres, apellidos, rol, foto } = perfil;
          let rolHeader = "";
          if (rol === "1") {
            rolHeader = "Administrador";
          } else if (rol === "2") {
            rolHeader = "Operador";
          } else if (rol === "3") {
            rolHeader = "Asesor";
          }
          localStorage.setItem("id", id);
          localStorage.setItem("rol", rol);
          $("#nameHeader").html(
            `${nombres.split(" ")[0]} ${apellidos.split(" ")[0]}`
          );
          $("#rolHeader").html(`${rolHeader}`);
          $("#imgHeader").html(`<img src="img/fotos/${foto}" alt="${
            nombres.split(" ")[0]
          } ${
            apellidos.split(" ")[0]
          }" class="rounded-circle d-none d-sm-block" style="width: 2.7em; height: 2.7em"
              data-lock-picture="img/fotos/${foto}" />`);
        },
      });
      resolve();
    } catch (error) {
      reject(error);
    }
  });
};

/* -------------------   BONO   ---------------------- */

const obtener_bono = function (id) {
  $("#gestion-bono").modal("show");
  $.ajax({
    url: "controller/bono.php",
    method: "POST",
    data: {
      id: id,
      option: "obtener_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#bono-id").val(data[i]["id"]);
        $("#descripcion_bono").val(data[i]["descripcion"]);
        if (data[i]["estado"] === "Disponible") {
          $("#bono-estado-1").prop("checked", true);
        } else if (data[i]["estado"] === "Finalizado") {
          $("#bono-estado-2").prop("checked", true);
        }
      });
    },
  });
};
const listar_bonos = function () {
  $.ajax({
    url: "controller/bono.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html_descripcion = ``;
      let html_estado = ``;
      let estado = response.estado;
      if (data.length > 0) {
        const rol = localStorage.getItem("rol");
        console.log(rol);
        data.map((x) => {
          const { id, descripcion, estado } = x;
          html_descripcion = html_descripcion + `<span>${descripcion}</span> `;
          if (rol !== "3") {
            if (estado == "Disponible") {
              html_estado =
                html_estado +
                `<span class="mb-3 d-block" name="estado" id="bono-estado">
                    <i class="fa-regular fa-circle-check me-2" style="color: #39c988"></i>
                    ${estado}
              </span>
              <div class="getbono">
                <button onclick="obtener_bono(${id})" type="button" class="btn btn-success btn-sm">Gestionar bonos</button>
              </div>`;
            } else {
              html_estado =
                html_estado +
                `<span class="mb-3 d-block" name="estado" id="bono-estado">
                    <i class="fa-regular fa-circle-xmark me-2" style="color: #ff3d50"></i>
                    ${estado}
              </span>
              <div class="getbono">
                <button onclick="obtener_bono(${id})" type="button" class="btn btn-success btn-sm">Gestionar bonos</button>
              </div>`;
            }
          } else {
            if (estado == "Disponible") {
              html_estado =
                html_estado +
                `<span class="mb-3 d-block" name="estado" id="bono-estado">
                    <i class="fa-regular fa-circle-check me-2" style="color: #39c988"></i>
                    ${estado}
              </span>`;
            } else {
              html_estado =
                html_estado +
                `<span class="mb-3 d-block" name="estado" id="bono-estado">
                    <i class="fa-regular fa-circle-xmark me-2" style="color: #ff3d50"></i>
                    ${estado}
              </span>`;
            }
          }
        });
      } else {
        html_descripcion =
          html_descripcion +
          `<span>No se encontraron bonos para el dia de hoy.</span> `;
      }
      $("#bono-descripcion").html(html_descripcion);
      $("#bono-estado").html(html_estado);
    },
  });
};
const actualizar_bono = function (id) {
  $("#formActualizarBono")
    .off("submit")
    .on("submit", function (e) {
      e.preventDefault();
      var data2 = $(this).serialize();
      console.log(data2);
      const formData = new FormData(this); // Usar el propio formulario para crear FormData

      $.ajax({
        url: "controller/bono.php",
        method: "POST",
        data: formData,
        contentType: false,
        cache: false,
        processData: false,
        success: function (data) {
          console.log(data);
          const response = JSON.parse(data);

          if (response.status === "error") {
            Swal.fire({
              icon: "error",
              title: "Lo sentimos",
              text: response.message,
            });
          } else {
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 1500,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              },
            });
            Toast.fire({
              icon: "success",
              title: response.message,
            });
            listar_bonos();
            $("#gestion-bono").modal("hide");
            $("#formActualizarBono").trigger("reset");
          }
        },
        error: function (xhr, status, error) {
          console.error("Error en la solicitud:", status, error);
          Swal.fire({
            icon: "error",
            title: "Error",
            text: "Ha ocurrido un error al intentar actualizar el bono. Por favor, inténtelo de nuevo.",
          });
        },
      });
    });
};

/* -------------------   METAS INDIVIDUALES  ---------------------- */

const listar_metas = function () {
  $.ajax({
    url: "controller/meta.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((metas_por_usuario) => {
          let mes = null;
          switch (metas_por_usuario.mes) {
            case "1":
              mes = "Enero";
              break;
            case "2":
              mes = "Febrero";
              break;
            case "3":
              mes = "Marzo";
              break;
            case "4":
              mes = "Abril";
              break;
            case "5":
              mes = "Mayo";
              break;
            case "6":
              mes = "Junio";
              break;
            case "7":
              mes = "Julio";
              break;
            case "8":
              mes = "Agosto";
              break;
            case "9":
              mes = "Septiembre";
              break;
            case "10":
              mes = "Octubre";
              break;
            case "11":
              mes = "Noviembre";
              break;
            case "12":
              mes = "Diciembre";
              break;
            default:
              mes = "Mes desconocido";
          }

          html += `
            <tr>
              <th scope="row">${metas_por_usuario.id}</th>
              <td>${metas_por_usuario.ld_cantidad}</td>
              <td>${metas_por_usuario.ld_monto}</td>
              <td>${metas_por_usuario.tc_cantidad}</td>
              <td>${metas_por_usuario.usuario_nombre}</td>
              <td>${mes}</td>
              <td>${metas_por_usuario.cumplido}</td>
              <td class="text-center">
                <a onclick="obtener_metas(${metas_por_usuario.id})">
                  <i class="fa-regular fa-pen-to-square me-2"></i>
                </a>
                <a onclick="eliminar_meta(${metas_por_usuario.id})">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>`;
        });
      } else {
        html = `<tr><td class='text-center' colspan='8'>No se encontraron resultados</td></tr>`;
      }
      $("#listar_metas").html(html);
    },
  });
};
const eliminar_meta = function (id) {
  Swal.fire({
    title: "¿Estas seguro?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "controller/meta.php",
        method: "POST",
        data: {
          id: id,
          option: "eliminar_meta",
        },
        success: function (data) {
          const response = JSON.parse(data);
          console.log(response.status);
          if (response.status === "success") {
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              },
            });
            Toast.fire({
              icon: "success",
              title: response.message,
            });
            listar_metas();
          } else {
            alert("algo salio mal" + data);
          }
        },
      });
    }
  });
};

const obtener_metas = function (id) {
  $("#editar-metas").modal("show");
  $.ajax({
    url: "controller/meta.php",
    method: "POST",
    data: {
      id: id,
      option: "obtener_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id").val(data[i]["id"]);
        $("#modal_ld_cantidad").val(data[i]["ld_cantidad"]);
        $("#modal_tc_cantidad").val(data[i]["tc_cantidad"]);
        $("#modal_ld_monto").val(data[i]["ld_monto"]);
        $("#modal_mes").val(data[i]["mes"]);
        $("#modal_cumplido").val(data[i]["cumplido"]);

        // Obtener el nombre completo del usuario
        var usuarioNombre = data[i]["usuario_nombre"];

        // Seleccionar el usuario en el select modal_id_usuario
        $("#modal_id_usuario")
          .find("option")
          .filter(function () {
            return $(this).text() === usuarioNombre;
          })
          .prop("selected", true);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const actualizar_meta = function () {
  $("#formActualizarMeta").submit(function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: "controller/meta.php",
      method: "POST",
      data: data,
      success: function (data) {
        const response = JSON.parse(data);
        if (response.status === "success") {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_metas();
          $("#editar-metas").modal("hide");
          $("#formActualizarMeta").trigger("reset");
        } else {
          alert("Algo salió mal.");
        }
      },
    });
  });
};

const crear_metas = function () {
  $("#formAgregarMeta").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formAgregarMeta")[0]);

    $.ajax({
      url: "controller/meta.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);
        if (response.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          Swal.fire({
            title: "Felicidades",
            text: response.message,
            icon: "success",
          });
          listar_metas();
          $("#agregar-meta").modal("hide");
          $("#formAgregarMeta").trigger("reset");
        }
      },
    });
  });
};
const filtro_metas = function () {
  $("#form_filtro_meta").submit(function (e) {
    e.preventDefault();
    var id_usuario = document.getElementById("id_usuario_f").value.trim();
    var mes = document.getElementById("mes_f").value.trim();
    var cumplido = document.getElementById("cumplido_f").value.trim();
    $.ajax({
      url: "controller/meta.php",
      method: "POST",
      data: {
        id_usuario: id_usuario,
        mes: mes,
        cumplido: cumplido,
        option: "filtro_metas",
      },
      success: function (response) {
        const data = JSON.parse(response);
        let html = ``;
        if (data.length > 0) {
          data.map((metas_por_usuario) => {
            let mes = null;
            switch (metas_por_usuario.mes) {
              case "1":
                mes = "Enero";
                break;
              case "2":
                mes = "Febrero";
                break;
              case "3":
                mes = "Marzo";
                break;
              case "4":
                mes = "Abril";
                break;
              case "5":
                mes = "Mayo";
                break;
              case "6":
                mes = "Junio";
                break;
              case "7":
                mes = "Julio";
                break;
              case "8":
                mes = "Agosto";
                break;
              case "9":
                mes = "Septiembre";
                break;
              case "10":
                mes = "Octubre";
                break;
              case "11":
                mes = "Noviembre";
                break;
              case "12":
                mes = "Diciembre";
                break;
              default:
                mes = "Mes desconocido";
            }

            html += `
              <tr>
                <th scope="row">${metas_por_usuario.id}</th>
                <td>${metas_por_usuario.ld_cantidad}</td>
                <td>${metas_por_usuario.ld_monto}</td>
                <td>${metas_por_usuario.tc_cantidad}</td>
                <td>${metas_por_usuario.nombre_completo}</td>
                <td>${mes}</td>
                <td>${metas_por_usuario.cumplido}</td>
                <td class="text-center">
                  <a onclick="obtener_metas(${metas_por_usuario.id})">
                  <i class="fa-regular fa-pen-to-square me-2"></i>
                </a>
                  <a onclick="eliminar_meta(${metas_por_usuario.id})">
                    <i class="fa-solid fa-trash"></i>
                  </a>
                </td>
              </tr>`;
          });
        } else {
          html = `<tr><td class='text-center' colspan='8'>No se encontraron resultados</td></tr>`;
        }
        $("#listar_metas").html(html);
      },
    });
  });
};

/* -------------------   METAS FUERZA DE VENTAS  ---------------------- */

const listar_metasfv = function () {
  $.ajax({
    url: "controller/metafv.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((metas_por_usuario) => {
          let mes = null;
          switch (metas_por_usuario.mes) {
            case "1":
              mes = "Enero";
              break;
            case "2":
              mes = "Febrero";
              break;
            case "3":
              mes = "Marzo";
              break;
            case "4":
              mes = "Abril";
              break;
            case "5":
              mes = "Mayo";
              break;
            case "6":
              mes = "Junio";
              break;
            case "7":
              mes = "Julio";
              break;
            case "8":
              mes = "Agosto";
              break;
            case "9":
              mes = "Septiembre";
              break;
            case "10":
              mes = "Octubre";
              break;
            case "11":
              mes = "Noviembre";
              break;
            case "12":
              mes = "Diciembre";
              break;
            default:
              mes = "Mes desconocido";
          }

          html += `
            <tr>
              <th scope="row">${metas_por_usuario.id}</th>
              <td>${metas_por_usuario.ld_cantidad}</td>
              <td>${metas_por_usuario.ld_monto}</td>
              <td>${metas_por_usuario.tc_cantidad}</td>
              <td>${metas_por_usuario.sede}</td>
              <td>${mes}</td>
              <td>${metas_por_usuario.cumplido}</td>
              <td class="text-center">
               <a onclick="obtener_metasfv(${metas_por_usuario.id})">
                  <i class="fa-regular fa-pen-to-square me-2"></i>
                </a>
                <a onclick="eliminar_metafv(${metas_por_usuario.id})">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>`;
        });
      } else {
        html = `<tr><td class='text-center' colspan='8'>No se encontraron resultados</td></tr>`;
      }
      $("#listar_metasfv").html(html);
    },
  });
};
const crear_metasfv = function () {
  $("#formAgregarMeta").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formAgregarMeta")[0]);

    $.ajax({
      url: "controller/metafv.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);
        if (response.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          Swal.fire({
            title: "Felicidades",
            text: response.message,
            icon: "success",
          });
          listar_metasfv();
          $("#agregar-meta").modal("hide");
          $("#formAgregarMeta").trigger("reset");
        }
      },
    });
  });
};
const obtener_metasfv = function (id) {
  $("#editar-metas").modal("show");
  $.ajax({
    url: "controller/metafv.php",
    method: "POST",
    data: {
      id: id,
      option: "obtener_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id").val(data[i]["id"]);
        $("#modal_ld_cantidad").val(data[i]["ld_cantidad"]);
        $("#modal_tc_cantidad").val(data[i]["tc_cantidad"]);
        $("#modal_ld_monto").val(data[i]["ld_monto"]);
        $("#modal_sede").val(data[i]["sede"]);
        $("#modal_mes").val(data[i]["mes"]);
        $("#modal_cumplido").val(data[i]["cumplido"]);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const actualizar_metasfv = function (id) {
  $("#formActualizarMeta").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formActualizarMeta")[0]);
    $.ajax({
      url: "controller/metafv.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        //alert(data)
        const response = JSON.parse(data);

        if (response.status === "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_metasfv();
          $("#editar-metas").modal("hide");
          $("#formActualizarMeta").trigger("reset");
        }
      },
    });
  });
};

const eliminar_metafv = function (id) {
  Swal.fire({
    title: "¿Estás seguro?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Sí",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "controller/metafv.php",
        method: "POST",
        data: {
          id: id,
          option: "eliminar_metafv",
        },

        success: function (data) {
          const response = JSON.parse(data);
          if (response.status === "success") {
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              },
            });
            Toast.fire({
              icon: "success",
              title: response.message,
            });
            listar_metasfv();
            $("#editar-metas").modal("hide");
            $("#formActualizarMeta").trigger("reset");
          } else {
            alert("Algo salió mal: " + data);
          }
        },
      });
    }
  });
};
const filtro_metasfv = function () {
  $("#form_filtro_meta").submit(function (e) {
    e.preventDefault();
    var mes = document.getElementById("mes_f").value.trim();
    var cumplido = document.getElementById("cumplido_f").value.trim();
    $.ajax({
      url: "controller/metafv.php",
      method: "POST",
      data: {
        mes: mes,
        cumplido: cumplido,
        option: "filtro_metasfv",
      },
      success: function (response) {
        const data = JSON.parse(response);
        let html = ``;
        if (data.length > 0) {
          data.map((metas_por_usuario) => {
            let mes = null;
            switch (metas_por_usuario.mes) {
              case "1":
                mes = "Enero";
                break;
              case "2":
                mes = "Febrero";
                break;
              case "3":
                mes = "Marzo";
                break;
              case "4":
                mes = "Abril";
                break;
              case "5":
                mes = "Mayo";
                break;
              case "6":
                mes = "Junio";
                break;
              case "7":
                mes = "Julio";
                break;
              case "8":
                mes = "Agosto";
                break;
              case "9":
                mes = "Septiembre";
                break;
              case "10":
                mes = "Octubre";
                break;
              case "11":
                mes = "Noviembre";
                break;
              case "12":
                mes = "Diciembre";
                break;
              default:
                mes = "Mes desconocido";
            }

            html += `
            <tr>
              <th scope="row">${metas_por_usuario.id}</th>
              <td>${metas_por_usuario.ld_cantidad}</td>
              <td>${metas_por_usuario.ld_monto}</td>
              <td>${metas_por_usuario.tc_cantidad}</td>
              <td>${metas_por_usuario.sede}</td>
              <td>${mes}</td>
              <td>${metas_por_usuario.cumplido}</td>
              <td class="text-center">
               <a onclick="obtener_metasfv(${metas_por_usuario.id})">
                  <i class="fa-regular fa-pen-to-square me-2"></i>
                </a>
                <a onclick="eliminar_metafv(${metas_por_usuario.id})">
                  <i class="fa-solid fa-trash"></i>
                </a>
              </td>
            </tr>`;
          });
        } else {
          html = `<tr><td class='text-center' colspan='8'>No se encontraron resultados</td></tr>`;
        }
        $("#listar_metasfv").html(html);
      },
    });
  });
};

const rellenar_ultima_meta = function () {
  $.ajax({
    url: "controller/metafv.php",
    type: "POST",
    data: {
      option: "ultima_meta",
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html_ld = ``;
      let html_monto = ``;
      let html_tc = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { ld_cantidad, tc_cantidad, ld_monto } = x;
          html_ld = html_ld + `<span>${ld_cantidad} préstamos</span>`;
          html_tc = html_tc + `<span>${tc_cantidad} tarjetas</span>`;
          html_monto = html_monto + `<span>S/. ${ld_monto}</span>`;
        });
      } else {
        html_ld = html_ld + `<span>No hay meta.</span>`;
        html_tc = html_tc + `<span>No hay meta.</span>`;
        html_monto = html_monto + `<span>No hay meta.</span>`;
      }
      $("#ld_meta").html(html_ld);
      $("#tc_meta").html(html_tc);
      $("#monto_meta").html(html_monto);
    },
  });
}

/* ----------------------------------------------------- */

/* -------------------   BASE   ---------------------- */

const base_x_dni = function () {
  $("#form_filtro_base").submit(function (e) {
    e.preventDefault();
    var dni = document.getElementById("dni").value.trim();
    $.ajax({
      url: "controller/base.php",
      method: "POST",
      data: {
        dni: dni,
        option: "base_x_dni",
      },
      success: function (response) {
        const data = JSON.parse(response);
        let html = ``;
        if (data.length > 0) {
          const rol = localStorage.getItem("rol");
          data.map((x) => {
            const {
              id,
              dni,
              nombres,
              tipo_cliente,
              direccion,
              distrito,
              credito_max,
              linea_max,
              plazo_max,
              tem,
              celular_1,
              celular_2,
              celular_3,
              tipo_producto,
              combo,
            } = x;
            if (rol !== "2") {
              html =
                html +
                `<tr><td>${nombres}</td><td>${dni}</td><td>${tipo_cliente}</td><td>${direccion}</td><td>${distrito}</td><td>S/.${credito_max}</td><td>S/.${linea_max}</td><td>${plazo_max}</td><td>${tem}%</td><td>${celular_1}</td><td>${celular_2}</td><td>${celular_3}</td><td>${tipo_producto}</td><td>${combo}</td>
                <td>
                  <a onclick="obtener_base(${id})"><i class="fa-solid fa-plus me-4"></i></a>
                  <a onclick="trasladar_base(${id})"><i class="fa-solid fa-wallet me-4"></i>
                </td></tr>`;
            } else {
              html =
                html +
                `<tr><td>${nombres}</td><td>${dni}</td><td>${tipo_cliente}</td><td>${direccion}</td><td>${distrito}</td><td>S/.${credito_max}</td><td>S/.${linea_max}</td><td>${plazo_max}</td><td>${tem}%</td><td>${celular_1}</td><td>${celular_2}</td><td>${celular_3}</td><td>${tipo_producto}</td><td>${combo}</td><td class="text-center">
                  ...
                </td></tr>`;
            }
          });
        } else {
          Swal.fire({
            title: "No se encontraron campañas.",
            padding: "2em",
          });
          listarRegistros();
        }
        $("#listar_base").html(html);
      },
    });
  });
};
const listarRegistros = function (pagina) {
  $.ajax({
    url: "controller/base.php",
    type: "POST",
    data: { option: "listar", pagina: pagina },
    dataType: "json",
    success: function (response) {
      const rol = localStorage.getItem("rol");
      let html = "";
      if (response.length > 0) {
        response.map((x) => {
          const {
            id,
            dni,
            nombres,
            tipo_cliente,
            direccion,
            distrito,
            credito_max,
            linea_max,
            plazo_max,
            tem,
            celular_1,
            celular_2,
            celular_3,
            tipo_producto,
            combo,
          } = x;

          if (rol !== "2") {
            html =
              html +
              `<tr><td>${nombres}</td><td>${dni}</td><td>${tipo_cliente}</td><td>${direccion}</td><td>${distrito}</td><td>S/.${credito_max}</td><td>S/.${linea_max}</td><td>${plazo_max}</td><td>${tem}%</td><td>${celular_1}</td><td>${celular_2}</td><td>${celular_3}</td><td>${tipo_producto}</td><td>${combo}</td><td>
                <a onclick="obtener_base(${id})"><i class="fa-solid fa-plus me-4"></i></a>
                <a onclick="trasladar_base(${id})"><i class="fa-solid fa-wallet me-4"></i>
              </td></tr>`;
          } else {
            html =
              html +
              `<tr><td>${nombres}</td><td>${dni}</td><td>${tipo_cliente}</td><td>${direccion}</td><td>${distrito}</td><td>S/.${credito_max}</td><td>S/.${linea_max}</td><td>${plazo_max}</td><td>${tem}%</td><td>${celular_1}</td><td>${celular_2}</td><td>${celular_3}</td><td>${tipo_producto}</td><td>${combo}</td></tr>`;
          }
        });
      } else {
        html = `<tr><td class='text-center' colspan='15'>No hay datos registrados</td></tr>`;
      }
      $("#listar_base").html(html);

      construirPaginacion(pagina); // Llamar a la función de construcción de paginación
    },
  });
};
function construirPaginacion(pagina_actual) {
  $.ajax({
    url: "controller/base.php",
    type: "POST",
    data: { option: "contar" },
    dataType: "json",
    success: function (response) {
      let total_registros = response.total;
      let por_pagina = 5; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_registros / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual == 1 ? "disabled" : ""}">
                          <a class="page-link" href="javascript:void(0);" onclick="listarRegistros(${
                            pagina_actual - 1
                          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual == i ? "active" : ""}">
                              <a class="page-link" href="javascript:void(0);" onclick="listarRegistros(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${
          pagina_actual == total_paginas ? "disabled" : ""
        }">
                          <a class="page-link" href="javascript:void(0);" onclick="listarRegistros(${
                            pagina_actual + 1
                          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion").html(html);
    },
  });
}
const obtener_base = function (id) {
  $("#obtener-base").modal("show");
  $.ajax({
    url: "controller/base.php",
    method: "POST",
    data: {
      id: id,
      option: "base_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id").val(data[i]["id"]);
        $("#nombres").val(data[i]["nombres"]);
        $("#dni2").val(data[i]["dni"]);
        $("#celular_1").val(data[i]["celular_1"]);
        $("#credito_max").val(data[i]["credito_max"]);
        $("#linea").val(data[i]["linea_max"]);
        $("#plazo_max").val(data[i]["plazo_max"]);
        $("#tipo_producto").val(data[i]["tipo_producto"]);
        $("#tem").val(data[i]["tem"]);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const borrar_base = function () {
  $("#btn-borrar-base").click(function (e) {
    e.preventDefault();
    Swal.fire({
      title: "¿Estás seguro?",
      text: "La base será eliminada.",
      showCancelButton: true,
      confirmButtonColor: "rgb(33,219,130)",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        $.ajax({
          url: "controller/base.php",
          method: "POST",
          data: {
            option: "borrar_base",
          },
          success: function (data) {
            const response = JSON.parse(data);
            if (response.status === "success") {
              Swal.fire({
                title: "Ejecución Exitosa.",
                text: response.message,
                icon: "success",
                confirmButtonColor: "rgb(33,219,130)",
                backdrop: `
              rgba(33,219,130,0.2)
              left top
              no-repeat
              `,
              });
              listarRegistros();
            } else {
              alert("algo salio mal" + data);
            }
          },
        });
      }
    });
  });
};

const trasladar_base = function (id) {
  $("#obtener-cartera_base").modal("show");
  $.ajax({
    url: "controller/base.php",
    method: "POST",
    data: {
      id: id,
      option: "base_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#tras_id").val(data[i]["id"]);
        $("#tras_nombres").val(data[i]["nombres"]);
        $("#tras_dni").val(data[i]["dni"]);
        $("#tras_celular").val(data[i]["celular_1"]);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};

const agregar_base_cartera = function () {
  $("#formAgregarCartera").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formAgregarCartera")[0]);

    $.ajax({
      url: "controller/cartera.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);
        console.log(response);
        if (response.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_cartera();
          $("#obtener-cartera_base").modal("hide");
          $("#formAgregarCartera").trigger("reset");
        }
      },
    });
  });
};

/* ----------------------------------------------------- */

/* -------------------   VENTAS   ---------------------- */

const listar_ventas = function () {
  $.ajax({
    url: "controller/ventas.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const {
            id,
            nombres,
            dni,
            celular,
            credito,
            linea,
            plazo,
            tem,
            nombre_completo,
            tipo_producto,
            estado,
          } = x;
          html =
            html +
            `<tr>
              <td>${nombres}</td>
              <td>${dni}</td>
              <td>${celular}</td>
              <td>S/.${credito}</td>
              <td>S/.${linea}</td>
              <td>${plazo}</td>
              <td>${tem}%</td>
              <td>${nombre_completo}</td>
              <td>${tipo_producto}</td>
              <td>${estado}</td>
              <td class="text-center">
                <a onclick="obtener_ventas(${id})"><i class="fa-regular fa-pen-to-square me-3" style="color: #001b2b"></i></a>
                <a onclick="eliminar_venta(${id})"><i class="fa-solid fa-trash"></i></a>
              </td>
            </tr>`;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='12'>No se encontraron resultados.</td>`;
      }
      $("#listar_ventas").html(html);
    },
  });
};
const crear_ventas = function () {
  $("#formObtenerBase").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formObtenerBase")[0]);
    var data2 = $(this).serialize();
    console.log(data2);
    $.ajax({
      url: "controller/ventas.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);

        if (response.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          Swal.fire({
            title: "Felicidades",
            text: response.message,
            icon: "success",
            confirmButtonColor: "rgb(33,219,130)",
            backdrop: `
          rgba(33,219,130,0.2)
          left top
          no-repeat
          `,
          });
          $("#obtener-base").modal("hide");
          $("#editar-consulta").modal("hide");
          $("#obtener_cartera").modal("hide");
          $("#formObtenerBase").trigger("reset");

        }
      },
    });
  });
};
var contar_ld = function () {
  $.ajax({
    url: "controller/ventas.php",
    type: "POST",
    data: {
      option: "contar_filas_ld",
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { cantidad_ld } = x;
          html = html + `<p class="card-text">Cant. ${cantidad_ld}</p>`;
        });
      } else {
        html = html + `<p class="card-text">Cant. 0</p>`;
      }
      $("#ld_cantidad_text").html(html);
    },
  });
};
var contar_tc = function () {
  $.ajax({
    url: "controller/ventas.php",
    type: "POST",
    data: {
      option: "contar_filas_tc",
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { cantidad_tc } = x;
          html = html + `<p class="card-text">Cant. ${cantidad_tc}</p>`;
        });
      } else {
        html = html + `<p class="card-text">Cant. 0</p>`;
      }
      $("#tc_cantidad_text").html(html);
    },
  });
};
var contar_ld_monto = function () {
  $.ajax({
    url: "controller/ventas.php",
    type: "POST",
    data: {
      option: "ld_monto",
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { ld_monto } = x;
          html = html + `<p class="card-text">S/. ${ld_monto}</p>`;
        });
      } else {
        html = html + `<p class="card-text">S/. 0.0</p>`;
      }
      $("#ld_monto_text").html(html);
    },
  });
};
const contar_ld_por_id = function (id_usuario) {
  $.ajax({
    url: "controller/ventas.php",
    type: "POST",
    data: {
      option: "contar_filas_ld_por_id",
      id_usuario: id_usuario,
    },
    success: function (response) {
      const data = JSON.parse(response);
      console.log(data);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { cantidad_ld } = x;
          html = html + `<p class="card-text">Cant. ${cantidad_ld}</p>`;
        });
      } else {
        html = html + `<p class="card-text">Cant. 0</p>`;
      }
      $("#ld_cantidad_text_id").html(html);
    },
  });
};
var contar_tc_por_id = function (id_usuario) {
  $.ajax({
    url: "controller/ventas.php",
    type: "POST",
    data: {
      option: "contar_filas_tc_por_id",
      id_usuario: id_usuario,
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { cantidad_tc } = x;
          html = html + `<p class="card-text">Cant. ${cantidad_tc}</p>`;
        });
      } else {
        html = html + `<p class="card-text">Cant. 0</p>`;
      }
      $("#tc_cantidad_text_id").html(html);
    },
  });
};
var contar_ld_monto_por_id = function (id_usuario) {
  $.ajax({
    url: "controller/ventas.php",
    type: "POST",
    data: {
      option: "ld_monto_por_id",
      id_usuario: id_usuario,
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { ld_monto } = x;
          html = html + `<p class="card-text">S/. ${ld_monto}</p>`;
        });
      } else {
        html = html + `<p class="card-text">S/. 0.0</p>`;
      }
      $("#ld_monto_text_id").html(html);
    },
  });
};
const obtener_ventas = function (id) {
  $("#obtener-ventas").modal("show");
  $.ajax({
    url: "controller/ventas.php",
    method: "POST",
    data: {
      id: id,
      option: "venta_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id2").val(data[i]["id"]);
        $("#nombres2").val(data[i]["nombres"]);
        $("#dni3").val(data[i]["dni"]);
        $("#celular3").val(data[i]["celular"]);
        $("#credito2").val(data[i]["credito"]);
        $("#linea2").val(data[i]["linea"]);
        $("#plazo2").val(data[i]["plazo"]);
        $("#tipo_producto2").val(data[i]["tipo_producto"]);
        $("#tem2").val(data[i]["tem"]);
        $("#nombre_completo").val(data[i]["nombre_completo"]);
        $("#estado2").val(data[i]["estado"]);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const filtro_ventas = function () {
  $("#form_filtro_ventas").submit(function (e) {
    e.preventDefault();
    var dni = document.getElementById("dni_f").value.trim();
    var estado = document.getElementById("estado_f").value.trim();
    var tipo_producto = document.getElementById("tipo_producto_f").value.trim();
    $.ajax({
      url: "controller/ventas.php",
      method: "POST",
      data: {
        dni: dni,
        estado: estado,
        tipo_producto: tipo_producto,
        option: "filtro_ventas",
      },
      success: function (response) {
        const data = JSON.parse(response);
        console.log(data);

        let html = ``;
        if (data.length > 0) {
          data.map((x) => {
            const {
              id,
              nombres,
              dni,
              celular,
              credito,
              linea,
              plazo,
              tem,
              nombre_completo,
              tipo_producto,
              estado,
            } = x;
            html =
              html +
              `<tr>
                <td>${id}</td>
                <td>${nombres}</td>
                <td>${dni}</td>
                <td>${celular}</td>
                <td>S/.${credito}</td>
                <td>S/.${linea}</td>
                <td>${plazo}</td>
                <td>${tem}%</td>
                <td>${nombre_completo}</td>
                <td>${tipo_producto}</td>
                <td>${estado}</td>
                <td class="text-center">
                  <a onclick="obtener_ventas(${id})"><i class="fa-regular fa-pen-to-square me-4" style="color: #001b2b"></i></a>
                  <a onclick="eliminar_venta(${id})"><i class="fa-solid fa-trash"></i></a>
                </td>
              </tr>`;
          });
        } else {
          html =
            html +
            `<tr><td class='text-center' colspan='12'>No se encontraron resultados</td>`;
        }
        $("#listar_ventas").html(html);
      },
    });
  });
};
const actualizar_ventas = function (id) {
  $("#formObtenerVentas").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formObtenerVentas")[0]);
    $.ajax({
      url: "controller/ventas.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);

        if (response.status === "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_ventas();
          contar_ld();
          contar_tc();
          contar_ld_monto();
          $("#obtener-ventas").modal("hide");
          $("#formObtenerVentas").trigger("reset");
        }
      },
    });
  });
};
const eliminar_venta = function (id) {
  Swal.fire({
    title: "¿Estás seguro?",
      text: "La venta será eliminada.",
      showCancelButton: true,
      confirmButtonColor: "rgb(33,219,130)",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
      cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "controller/ventas.php",
        method: "POST",
        data: {
          id: id,
          option: "eliminar_ventas",
        },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.status === "success") {
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3500,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              },
            });
            Toast.fire({
              icon: "success",
              title: response.message,
            });
            listar_ventas();
            contar_ld();
            contar_tc();
            contar_ld_monto();
            $("#obtener-ventas").modal("hide");
            $("#formObtenerVentas").trigger("reset");
          } else {
            alert("algo salio mal" + data);
          }
        },
      });
    }
  });
};

/* ----------------------------------------------------- */

/* ------------------   USUARIOS   --------------------- */

const select_usuarios = function () {
  $.ajax({
    url: "controller/usuario.php",
    type: "GET",
    success: function (response) {
      const usuarios = JSON.parse(response);
      var selectIds = ["#id_usuario_f", "#modal_id_usuario", "#id_usuario2"];

      // Limpiar los selects antes de agregar nuevas opciones
      selectIds.forEach(function (selectId) {
        var select = $(selectId);
        select.empty();

        // Agregar la opción "Selecciona usuario"
        var defaultOption = $("<option></option>")
          .attr("value", "")
          .text("Selecciona usuario")
          .prop("selected", true);
        select.append(defaultOption);

        // Agregar usuarios
        usuarios.forEach(function (usu) {
          if (usu.rol != 2) {
            var option = $("<option></option>")
              .attr("value", usu.id)
              .text(usu.nombres + " " + usu.apellidos);
            select.append(option);
          }
        });

        // Detectar cambio de selección
        select.change(function () {
          var selectedUserId = $(this).val();
          console.log("ID de usuario seleccionado:", selectedUserId);
        });
      });
    },
  });
};
// const select_usuarios = function () {
//   $.ajax({
//     url: "controller/ventas.php",
//     type: "GET",
//     success: function (response) {
//       const usuarios = JSON.parse(response);
//       var select = $("#id_usuario");
//       usuarios.forEach(function (usu) {
//         var option = $("<option></option>")
//           .attr("value", usu.id)
//           .text(usu.nombres + " " + usu.apellidos);
//         select.append(option);
//       });
//     },
//   });
// };
const filtro_empleados = function () {
  $("#form_filtro_empleados").submit(function (e) {
    e.preventDefault();
    var rol = document.getElementById("rol").value.trim();
    var estado = document.getElementById("estado").value.trim();
    $.ajax({
      url: "controller/usuario.php",
      method: "POST",
      data: {
        rol: rol,
        estado: estado,
        opcion: "filtro_empleados",
      },
      success: function (response) {
        const data = JSON.parse(response);
        let html = ``;
        if (data.length > 0) {
          data.map((usuario) => {
            let rol = null;
            let estado = null;
            if (usuario.estado === "1") {
              estado = "Activo";
              iconestado = "activo";
            } else if (usuario.estado === "2") {
              estado = "Inactivo";
              iconestado = "inactivo";
            }
  
            if (usuario.rol === "1") {
              rol = "Administrador";
              iconrol = "admin";
            } else if (usuario.rol === "2") {
              rol = "Operador";
              iconrol = "operador";
            } else if (usuario.rol === "3") {
              rol = "Asesor";
              iconrol = "asesor";
            }
  
            html =
              html +
              `<tr class="align-middle">
              <td scope="row">
                <img src="img/fotos/${usuario.foto}" alt="Foto de ${usuario.nombres}" class="img-usuario shadow me-3">
                ${usuario.usuario}
              </td>
              <td>${usuario.nombres}</td><td>${usuario.apellidos}</td>
              <td>
                <img src="img/icons/${iconrol}.png" class="icon-rol me-2">
                  ${rol}
              </td>
              <td class="text-center"><span class="icon-estado-${iconestado}">${estado}</span></td>
              <td class="text-center">
                <a onclick="obtener_usuarios(${usuario.id})"><i class="fa-regular fa-pen-to-square me-3" style="color: #001b2b"></i></a>
                <a onclick="eliminar_usuario(${usuario.id})"><i class="fa-solid fa-trash" style="color: #001b2b"></i></a>
                </td>
            </tr>`;
          });
        } else {
          html =
            html +
            `<tr><td class='text-center' colspan='6'>No se encontraron resultados</td>`;
        }
        $("#listar_empleados").html(html);
      },
    });
  });
};
const listar_empleados = function () {
  $.ajax({
    url: "controller/usuario.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((usuario) => {
          let rol = null;
          let estado = null;
          if (usuario.estado === "1") {
            estado = "Activo";
            iconestado = "activo";
          } else if (usuario.estado === "2") {
            estado = "Inactivo";
            iconestado = "inactivo";
          }

          if (usuario.rol === "1") {
            rol = "Administrador";
            iconrol = "admin";
          } else if (usuario.rol === "2") {
            rol = "Operador";
            iconrol = "operador";
          } else if (usuario.rol === "3") {
            rol = "Asesor";
            iconrol = "asesor";
          }

          console.log(usuario.foto);
          html =
            html +
            `
            <tr class="align-middle">
              <td scope="row">
                <img src="img/fotos/${usuario.foto}" alt="Foto de ${usuario.nombres}" class="img-usuario shadow me-3">
                ${usuario.usuario}
              </td>
              <td>${usuario.nombres}</td><td>${usuario.apellidos}</td>
              <td>
                <img src="img/icons/${iconrol}.png" class="icon-rol me-2">
                  ${rol}
              </td>
              <td class="text-center"><span class="icon-estado-${iconestado}">${estado}</span></td>
              <td class="text-center">
                <a onclick="obtener_usuarios(${usuario.id})"><i class="fa-regular fa-pen-to-square me-3" style="color: #001b2b"></i></a>
                <a onclick="eliminar_usuario(${usuario.id})"><i class="fa-solid fa-trash" style="color: #001b2b"></i></a>
                </td>
            </tr>
            `;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='4'>No se encontraron resultados</td>`;
      }
      $("#listar_empleados").html(html);
    },
  });
};
const obtener_usuarios = function (id) {
  $("#editar-usuario").modal("show");
  $.ajax({
    url: "controller/usuario.php",
    method: "POST",
    data: {
      id: id,
      opcion: "obtener_x_id_usuario",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id").val(data[i]["id"]);
        $("#usuario").val(data[i]["usuario"]);
        $("#nombres").val(data[i]["nombres"]);
        $("#apellidos").val(data[i]["apellidos"]);
        $("#estado2").val(data[i]["estado"]);
        $("#rol2").val(data[i]["rol"]);
        $("#archivoFoto2").val(data[i]["foto"]);

        $(".fotoPerfil2").html(
          `<img src="./img/fotos/` +
            data[i]["foto"] +
            `" alt="" class='fotoPerfil rounded' style="width: 15rem;">`
        );
      });
    },
  });
};
const eliminar_usuario = function (id) {
  Swal.fire({
    title: "¿Estas seguro?",
    icon: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Si",
    cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "controller/usuario.php",
        method: "POST",
        data: {
          id: id,
          opcion: "eliminar_usuario",
        },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.status === "success") {
            const Toast = Swal.mixin({
              toast: true,
              position: "top-end",
              showConfirmButton: false,
              timer: 3000,
              timerProgressBar: true,
              didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
              },
            });
            Toast.fire({
              icon: "success",
              title: response.message,
            });
            listar_empleados();
          } else {
            alert("algo salio mal" + data);
          }
        },
      });
    }
  });
};

const actualizar_usuarios = function (id) {
  $("#formActualizarEmpleado").submit(function (e) {
    e.preventDefault();
    var data2 = $(this).serialize();
    console.log(data2);
    const data = new FormData($("#formActualizarEmpleado")[0]);
    $.ajax({
      url: "controller/usuario.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);

        if (response.status === "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_empleados();
          $("#editar-usuario").modal("hide");
          $("#formActualizarEmpleado").trigger("reset");
        }
      },
    });
  });
};
const crear_usuarios = function () {
  $("#formAgregarEmpleado").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formAgregarEmpleado")[0]);

    $.ajax({
      url: "controller/usuario.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);
        console.log(response);
        if (response.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_empleados();
          $("#agregar-usuario").modal("hide");
          $("#formAgregarEmpleado").trigger("reset");
        }
      },
    });
  });
};

/* ----------------------------------------------------- */

/* ------------------   CONSULTAS   --------------------- */

const listar_consultas = function () {
  $.ajax({
    url: "controller/consultas.php",
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { id, dni, celular, descripcion, campana } = x;
          html =
            html +
            `<tr>
              <td>${dni}</td>
              <td>${celular}</td>
              <td>${descripcion}</td>
              <td>${campana}</td>
              <td class="text-center">
                <a onclick="obtener_consultas(${id})"><i class="fa-solid fa-circle-plus me-3"></i></a>
                <a onclick="obtener_consulta_cartera(${id})"><i class="fa-solid fa-wallet me-3"></i>
                <a onclick="eliminar_consulta(${id})"><i class="fa-solid fa-trash me-3"></i></a>
              </td>
            </tr>`;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='6'>No se encontraron resultados.</td>`;
      }
      $("#listar_consultas").html(html);
    },
  });
};
const obtener_consulta_cartera = function (id) {
  $("#agregar-consulta-cartera").modal("show");
  $.ajax({
    url: "controller/consultas.php",
    method: "POST",
    data: {
      id: id,
      option: "obtener_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#con_id").val(data[i]["id"]);
        $("#con_dni").val(data[i]["dni"]);
        $("#con_celular").val(data[i]["celular"]);
      });
    },
  });
};
const agregar_consulta_cartera = function () {
  $("#formAgregarCartera").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formAgregarCartera")[0]);

    $.ajax({
      url: "controller/cartera.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);
        console.log(response);
        if (response.status == "error") {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: response.message,
          });
        } else {
          const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.onmouseenter = Swal.stopTimer;
              toast.onmouseleave = Swal.resumeTimer;
            },
          });
          Toast.fire({
            icon: "success",
            title: response.message,
          });
          listar_consultas();
          $("#agregar-consulta-cartera").modal("hide");
          $("#formAgregarCartera").trigger("reset");
        }
      },
    });
  });
};
const rellenar_consulta = function () {
  $("#dni").on("input", function () {
    var dni = document.getElementById("dni").value.trim();

    if (dni.length !== 8) {
      $("#campana").val("No-Found");
    } else {
      $.ajax({
        url: "controller/consultas.php",
        method: "POST",
        data: {
          dni: dni,
          option: "verificar_dni_base",
        },
        success: function (response) {
          if (response == "1") {
            $("#campana").val("Si");
            listar_consultas();
          } else {
            $("#campana").val("No");
            listar_consultas();
          }
        },
      });
    }
  });
};
const verificar_dni_base = function () {
  $("#verificar").click(function (e) {
    e.preventDefault();
    var dni = document.getElementById("dni").value.trim();

    $.ajax({
      url: "controller/consultas.php",
      method: "POST",
      data: {
        dni: dni,
        option: "verificar_dni_base",
      },
      success: function (response) {
        if (response == "1") {
          Swal.fire({
            title: "Felicidades",
            text: "Un asesor se contactara con usted pronto.",
            icon: "success",
          });
        } else {
          Swal.fire({
            icon: "error",
            title: "Lo sentimos",
            text: "Usted no cuenta con una campaña este mes, intentelo el siguiente.",
          });
        }
      },
    });
  });
};
const crear_consultas = function () {
  $("#form_consulta").submit(function (e) {
    e.preventDefault();
    var dni = document.getElementById("dni").value.trim();
    var celular = document.getElementById("celular").value.trim();
    var descripcion = document.getElementById("descripcion").value.trim();
    var data = $(this).serialize();
    let html = ``;
    if (dni.length !== 8 || celular.length !== 9) {
      html =
        html +
        `<div class="alert alert-danger" role="alert">
            <i class="fa-solid fa-triangle-exclamation me-2"></i>
            Hubo un error. Vuelva a ingresar los datos requeridos.
            </div>`;
    } else {
      $.ajax({
        url: "controller/consultas.php",
        method: "POST",
        data: data,
        success: function (data) {
          if (data == "ok") {
            listar_consultas();
          } else {
            Swal.fire({
              icon: "error",
              title: "Error",
              text: "Algo salio mal",
            });
          }
        },
      });
      $.ajax({
        url: "controller/consultas.php",
        method: "POST",
        data: {
          dni: dni,
          option: "verificar_dni_base",
        },
        success: function (response) {
          if (response == "1") {
            Swal.fire({
              title: "Felicidades",
              text: "Un asesor se contactara con usted pronto.",
              icon: "success",
              confirmButtonColor: "rgb(0, 60, 94)",
            });
            limpiar_form_consulta();
          } else {
            Swal.fire({
              icon: "error",
              title: "Lo sentimos",
              text: "Usted no cuenta con una campaña este mes, intentelo el siguiente.",
              confirmButtonColor: "rgb(0, 60, 94)",
            });
            limpiar_form_consulta();
          }
        },
      });
    }

    $("#alerta").html(html);
  });
};
const limpiar_form_consulta = function () {
  document.getElementById("celular").value = "";
  document.getElementById("dni").value = "";
  document.getElementById("descripcion").value = "";
};
const eliminar_consulta = function (id) {
  Swal.fire({
    title: "¿Estás seguro?",
      text: "La consulta será eliminada.",
      showCancelButton: true,
      confirmButtonColor: "rgb(33,219,130)",
      cancelButtonColor: "#d33",
      confirmButtonText: "Si",
      cancelButtonText: "Cancelar",
  }).then((result) => {
    if (result.isConfirmed) {
      $.ajax({
        url: "controller/consultas.php",
        method: "POST",
        data: {
          id: id,
          option: "eliminar_consulta",
        },
        success: function (data) {
          const response = JSON.parse(data);
          if (response.status === "success") {
            Swal.fire({
              title: "Felicidades",
              text: response.message,
              icon: "success",
              confirmButtonColor: "rgb(33,219,130)",
            });
            listar_consultas();
          } else {
            alert("algo salio mal" + data);
          }
        },
      });
    }
  });
};
const filtro_consultas = function () {
  $("#form_consultas").submit(function (e) {
    e.preventDefault();
    var dni = document.getElementById("c-dni").value.trim();
    var campana = document.getElementById("c-campana").value.trim();
    $.ajax({
      url: "controller/consultas.php",
      method: "POST",
      data: {
        dni: dni,
        campana: campana,
        option: "filtro_consultas",
      },
      success: function (response) {
        const data = JSON.parse(response);
        let html = ``;
        if (data.length > 0) {
          data.map((x) => {
            const { id, dni, celular, descripcion, campana } = x;
            html =
              html +
              `<tr>
                <td>${id}</td>
                <td>${dni}</td>
                <td>${celular}</td>
                <td>${descripcion}</td>
                <td>${campana}</td>
                <td class="text-center">
                  <a onclick="obtener_consultas(${id})"><i class="fa-solid fa-circle-plus me-3"></i></a>
                  <a onclick="obtener_consulta_cartera(${id})"><i class="fa-solid fa-wallet me-3"></i>
                  <a onclick="eliminar_consulta(${id})"><i class="fa-solid fa-trash me-3"></i></a>
                </tr>`;
          });
        } else {
          html =
            html +
            `<tr><td class='text-center' colspan='6'>No se encontraron resultados.</td>`;
        }
        $("#listar_consultas").html(html);
      },
    });
  });
};
const obtener_consultas = function (id) {
  $("#editar-consulta").modal("show");
  $.ajax({
    url: "controller/consultas.php",
    method: "POST",
    data: {
      id: id,
      option: "obtener_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id2").val(data[i]["id"]);
        $("#dni2").val(data[i]["dni"]);
        $("#celular2").val(data[i]["celular"]);
      });
    },
  });
};
const actualizar_consulta = function () {
  $("#formActualizarConsulta").submit(function (e) {
    e.preventDefault();
    var data = $(this).serialize();
    $.ajax({
      url: "controller/consultas.php",
      method: "POST",
      data: data,
      success: function (response) {
        if (response == "ok") {
          listar_consultas();
          $("#editar-consulta").modal("hide");
          $("#formActualizarConsulta").trigger("reset");
        } else {
          alert("Algo salio mal.");
        }
      },
    });
  });
};

/* ----------------------------------------------------- */

/* ---------------------- EXCEL ------------------------- */

const importar = function () {
  $("#uploadForm").on("submit", function (e) {
    e.preventDefault();
    var formData = new FormData(this);
    $.ajax({
      url: "controller/excel.php",
      type: "POST",
      data: formData,
      processData: false,
      contentType: false,
      success: function (response) {
        if (response == "success") {
          Swal.fire({
            title: "Felicidades",
            text: "La base se registro correctamente.",
            icon: "success",
            confirmButtonColor: "rgb(33,219,130)",
            backdrop: `
              rgba(33,219,130,0.2)
              left top
              no-repeat
              `,
          });
          listarRegistros();
          $("#file").val("");
        } else {
          Swal.fire({
            title: "Hubo un error",
            text: "No selecciono un documento. Por favor, seleccione uno.",
            icon: "error",
            confirmButtonColor: "#d33",
            backdrop: `
              rgba(242, 116, 116,0.2)
              left top
              no-repeat
              `,
          });
        }
      },
    });
  });
};


const exportar = () => {
    const boton = document.getElementById("btn-descargar-excel")
    if (boton) {
        boton.addEventListener("click", () => {
            window.location.href = "controller/exp_excel.php";
        });
    }
};

/* ----------------------------------------------------- */

function sendMail() {
  var sendername = document.getElementById("sendername").value.trim();
  var to = document.getElementById("to").value.trim();
  var message = document.getElementById("message").value.trim();
  var subject = document.getElementById("subject").value.trim();
  var replyto = document.getElementById("replyto").value.trim();

  // Limpiar los contenedores de alertas antes de agregar nuevas alertas
  document.getElementById("sendername-alert").innerHTML = "";
  document.getElementById("subject-alert").innerHTML = "";
  document.getElementById("message-alert").innerHTML = "";

  var hasError = false;

  if (sendername.length == 0) {
    document.getElementById(
      "sendername-alert"
    ).innerHTML = `<div class="alert alert-danger" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        Error,  ingresa tu nombre.
        </div>`;
    hasError = true;
  }

  if (to.length == 0) {
    document.getElementById(
      "subject-alert"
    ).innerHTML = `<div class="alert alert-danger" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        Error,  ingresa un destinatario.
        </div>`;
    hasError = true;
  }

  if (subject.length == 0) {
    document.getElementById(
      "subject-alert"
    ).innerHTML = `<div class="alert alert-danger" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        Error,  ingresa un asunto.
        </div>`;
    hasError = true;
  }

  if (replyto.length == 0) {
    document.getElementById(
      "subject-alert"
    ).innerHTML = `<div class="alert alert-danger" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        Error,  ingresa un correo.
        </div>`;
    hasError = true;
  }

  if (message.length == 0) {
    document.getElementById(
      "message-alert"
    ).innerHTML = `<div class="alert alert-danger" role="alert">
        <i class="fa-solid fa-triangle-exclamation me-2"></i>
        Error,  ingresa un mensaje.
        </div>`;
    hasError = true;
  }

  // Si hay algún error, detener la ejecución
  if (hasError) {
    return;
  }

  (function () {
    emailjs.init("SZdN821G8VoZ8ZKF9"); // Llave pública de la cuenta
  })();

  var params = {
    sendername: sendername,
    to: to,
    subject: subject,
    replyto: replyto,
    message: message,
  };

  var serviceID = "service_9omv6zk"; // email service id
  var templateID = "template_1nlut2o"; // email template id

  emailjs
    .send(serviceID, templateID, params)
    .then((res) => {
      Swal.fire({
        title: "Enviado",
        text: "El correo se envió correctamente.",
        icon: "success",
      });
      document.getElementById("sendername").value = "";
      document.getElementById("subject").value = "";
      document.getElementById("message").value = "";
      $("#contactanos").modal("hide");
    })
    .catch((error) => {
      Swal.fire({
        title: "Error",
        text: "Hubo un problema al enviar el correo. Por favor, intenta nuevamente.",
        icon: "error",
      });
      $("#contactanos").modal("hide");
    });
}
