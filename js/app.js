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
    exportar_word();
    trasladar_base_procesoventas();
  }
  if (params.get("view") === "proceso_ventas") {
    listarRegistros_ProcesoVentas(1);
    agregar_procesoventas();
    trasladar_to_ventas();
    no_tras_ventas();
    actualizar_proceso_ventas();
    to_proceso_archivados();

    $("#form_filtro_procesoventas").submit(function (e) {
      e.preventDefault();
      filtro_procesoventa(1);
      
    });
    
  }
  if (params.get("view") === "consultas") {
    actualizar_consulta();
    crear_ventas();
    agregar_consulta_cartera();
    listar_consultas_paginadas(1);
    $("#form_consultas").submit(function (e) {
      e.preventDefault();
      filtro_consultas(1); 
      
    });
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
    listar_carteras_paginadas(1);
    crear_cartera();
    actualizar_cartera();
    crear_ventas();
    $("#form_filtro_cartera").submit(function (e) {
      e.preventDefault();
      filtro_cartera(1); 
    });
    
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
  if (params.get("view") === "archivado_ventas") {
    listar_archivadoventas(1);
    desarchivar_venta();
     $("#form_filtro_archivadoventas").submit(function (e) {
      e.preventDefault();
      filtro_archivadoventas(1);
    });
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

/* -------------------   VENTAS EN PROCESO   ---------------------- */

const habilitar_text_edit = function () {
  document.getElementById("boton_read").classList.remove("d-none");
  document.getElementById("boton_submit_edit").classList.remove("d-none");
  document.getElementById("boton_edit").classList.add("d-none");
  document.getElementById("documento").classList.remove("d-none");
  document.getElementById("documento").disabled = false;
  document.getElementById("bton-trash-edit-pv").classList.remove("d-none");
  document.getElementById("nombres_ob_pventas").disabled = false;
  document.getElementById("dni_ob_pventas").disabled = false;
  document.getElementById("celular_ob_pventas").disabled = false;
  document.getElementById("tem_ob_pventas").disabled = false;
  document.getElementById("estado_ob_pventas").disabled = false;
  document.getElementById("credito_ob_pventas").disabled = false;
  document.getElementById("linea_ob_pventas").disabled = false;
  document.getElementById("plazo_ob_pventas").disabled = false;
  document.getElementById("tipoproducto_ob_pventas").disabled = false;
};
const deshabilitar_text_edit = function () {
  document.getElementById("boton_read").classList.add("d-none");
  document.getElementById("boton_submit_edit").classList.add("d-none");
  document.getElementById("bton-trash-edit-pv").classList.add("d-none");
  document.getElementById("documento").classList.add("d-none");
  document.getElementById("boton_edit").classList.remove("d-none");
  document.getElementById("nombres_ob_pventas").disabled = true;
  document.getElementById("dni_ob_pventas").disabled = true;
  document.getElementById("celular_ob_pventas").disabled = true;
  document.getElementById("tem_ob_pventas").disabled = true;
  document.getElementById("credito_ob_pventas").disabled = true;
  document.getElementById("linea_ob_pventas").disabled = true;
  document.getElementById("plazo_ob_pventas").disabled = true;
  document.getElementById("tipoproducto_ob_pventas").disabled = true;
  document.getElementById("estado_ob_pventas").disabled = true;  
};
const no_tras_ventas = function () {
  $(document).on("click", "#pen_venta", function (e) {
    e.preventDefault();
    Swal.fire({
      title: "La venta se encuentra pendiente.",
      confirmButtonColor: "#3ea1f7ef",
      backdrop: `
              rgba(33, 107, 219, 0.2)
              left top
              no-repeat
              `,
    });
  });
  $(document).on("click", "#apela_venta", function (e) {
    e.preventDefault();
    Swal.fire({
      title: "La venta se encuentra en apelación.",
      confirmButtonColor: "#fff200",
      backdrop: `
              rgba(202, 204, 58, 0.2)
              left top
              no-repeat
              `,
    });
  });
  $(document).on("click", "#desa_venta", function (e) {
    e.preventDefault();
    Swal.fire({
      title: "La venta fue desaprobada.",
      confirmButtonColor: "#fe4343",
      backdrop: `
              rgba(204, 58, 58, 0.2)
              left top
              no-repeat
              `,
    });
  });
};
const obtener_procesoventas_x_id = function (id) {
  $("#obtener-proceso-ventas").modal("show");
  $.ajax({
    url: "controller/proceso_ventas.php",
    method: "POST",
    data: {
      id: id,
      option: "procesoventas_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id_ob_pventas").val(data[i]["id"]);
        $("#nombres_ob_pventas").val(data[i]["nombres"]);
        $("#dni_ob_pventas").val(data[i]["dni"]);
        $("#celular_ob_pventas").val(data[i]["celular"]);
        $("#credito_ob_pventas").val(data[i]["credito"]);
        $("#linea_ob_pventas").val(data[i]["linea"]);
        $("#plazo_ob_pventas").val(data[i]["plazo"]);
        $("#estado_ob_pventas").val(data[i]["estado"]);
        $("#tipoproducto_ob_pventas").val(data[i]["tipo_producto"]);
        $("#tem_ob_pventas").val(data[i]["tem"]);
        $("#documento_actual").val(data[i]["documento"]);
        $("#documento-preview").text(data[i]["documento"] ? data[i]["documento"] : "No se ha seleccionado ningún archivo.");

        if (data[i]["documento"]) {
          const rutaDocumento = "pdf/documents/" + data[i]["documento"]; // ⚠️ Ajusta esto
          $("#btnVerDocumento").off("click").on("click", function () {
            window.open(rutaDocumento, "_blank");
          }).show();
        } else {
          $("#btnVerDocumento").hide();
        }
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const to_ventas_desembolsadas = function (id) {
  $("#to-ventasdesembolsadas").modal("show");
  $.ajax({
    url: "controller/proceso_ventas.php",
    method: "POST",
    data: {
      id: id,
      option: "procesoventas_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#view-nombres-to-ventas").text(data[i]["nombres"]);
        $("#view-dni-to-ventas").text(data[i]["dni"]);
        $("#view-celular-to-ventas").text(data[i]["celular"]);
        $("#view-linea-to-ventas").text(data[i]["linea"]);
        $("#view-plazo-to-ventas").text(data[i]["plazo"]);
        $("#view-credito-to-ventas").text(data[i]["credito"]);
        $("#view-estado-to-ventas").text(data[i]["estado"]);
        $("#view-tipoproducto-to-ventas").text(data[i]["tipo_producto"]);
        $("#view-tem-to-ventas").text(data[i]["tem"]);

        $("#id_to_ventas").val(data[i]["id"]);
        $("#nombres_to_ventas").val(data[i]["nombres"]);
        $("#dni_to_ventas").val(data[i]["dni"]);
        $("#celular_to_ventas").val(data[i]["celular"]);
        $("#credito_to_ventas").val(data[i]["credito"]);
        $("#linea_to_ventas").val(data[i]["linea"]);
        $("#plazo_to_ventas").val(data[i]["plazo"]);
        $("#estado_to_ventas").val(data[i]["estado"]);
        $("#tipoproducto_to_ventas").val(data[i]["tipo_producto"]);
        $("#tem_to_ventas").val(data[i]["tem"]);

        $("#documento-preview-to-ventas").val(data[i]["documento"]);

        if (data[i]["documento"]) {
          const rutaDocumento = "pdf/documents/" + data[i]["documento"];
          $("#verSolicitud")
            .off("click")
            .on("click", function (e) {
              e.preventDefault();
              window.open(rutaDocumento, "_blank");
            })
            .show();
        } else {
          $("#verSolicitud").hide();
        }
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const trasladar_base_procesoventas = function () {
  $("#formObtenerProcesoVentas").submit(function (e) {
    e.preventDefault();

    const form = $("#formObtenerProcesoVentas")[0];
    const data = new FormData(form);

    // 👇 Se establece el valor que activa el case correcto en el controller
    data.append("option", "agregar_procesoventas");

    $.ajax({
      url: "controller/proceso_ventas.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        const response = JSON.parse(data);

        if (response.status === "error") {
          Swal.fire({
            title: "Error",
            text: response.message,
            icon: "error",
            confirmButtonColor: "#fe4343",
            backdrop: `
              rgba(204, 58, 58, 0.2)
              left top
              no-repeat
            `,
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
          limpiarFormularioProcesoVentas();
        }
      },
      error: function () {
        Swal.fire({
          title: "Error de red",
          text: "No se pudo enviar el formulario. Intenta nuevamente.",
          icon: "error",
        });
      },
    });
  });
};
const limpiarFormularioProcesoVentas = function () {
  $("#obtener-procesoventas").modal("hide");
  $("#formObtenerProcesoVentas")[0].reset();
  $("#formObtenerProcesoVentas")[0].reset();
  $("#documento").val("");
  $("#documento-preview").text("No se ha seleccionado ningún archivo.");
};
const archivar_proceso_ventas = function (id) {
  $("#archivar-procesoventas").modal("show");
  $.ajax({
    url: "controller/proceso_ventas.php",
    method: "POST",
    data: {
      id: id,
      option: "procesoventas_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id_to_archivar_venta").val(data[i]["id"]);
        $("#view-nombres-to-archive").text(data[i]["nombres"]);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const to_proceso_archivados = function () {
  $("#formToArchivadoVentas").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formToArchivadoVentas")[0]);
for (let pair of data.entries()) {
  console.log(`${pair[0]}: ${pair[1]}`);
}
    $.ajax({
      url: "controller/archivado_ventas.php",
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
          listarRegistros_ProcesoVentas(1);
          $("#formToArchivadoVentas").trigger("reset");
          $("#archivar-procesoventas").modal("hide");
                 
        }
      },
    });
  });
};
const listarRegistros_ProcesoVentas = function (pagina) {
  $.ajax({
    url: "controller/proceso_ventas.php",
    type: "POST",
    data: { option: "listar_pventas", pagina: pagina },
    dataType: "json",
    success: function (response) {
      let html = "";
      if (response.length > 0) {
        response.map((x) => {
          const { id, nombres, dni, celular, created_at, estado } = x;
          if (estado === "Pendiente") {
            iconestado = "<i class='fa-solid fa-clock-rotate-left me-2'></i>";
            bgestado = "pendiente";
          } else if (estado === "Aprobado") {
            iconestado = "<i class='fa-solid fa-check me-2'></i>";
            bgestado = "aprobado";
          } else if (estado === "Desaprobado") {
            iconestado = "<i class='fa-solid fa-xmark me-2'></i>";
            bgestado = "desaprobado";
          } else if (estado === "Apelando") {
            iconestado = "<i class='fa-solid fa-exclamation me-2'></i>";
            bgestado = "apelando";
          }

          if (estado == "Aprobado") {
            icontoventas =
              `<a href="#" onclick="to_ventas_desembolsadas(${id})"><i class="icon-to-ventas fa-solid fa-circle-check"></i></a>`;;
          } else if (estado == "Pendiente") {
            icontoventas =
              "<a href='#' id='pen_venta'><i class='icon-pen-ventas fa-solid fa-clock'></i></a>";
          } else if (estado == "Apelando") {
            icontoventas =
              "<a href='#' id='apela_venta'><i class='icon-apela-ventas fa-solid fa-circle-exclamation'></i></a>";
          } else if (estado == "Desaprobado") {
            icontoventas =
              "<a href='#' id='desa_venta'><i class='icon-no-ventas fa-solid fa-circle-xmark'></i></a>";
          }

          html =
            html +
            `<tr>
              <td>${nombres}</td>
              <td>${dni}</td>
              <td>${celular}</td>
              <td>${created_at}</td>
              <td class="text-center"><span class="icon-estado-${bgestado}">${iconestado}${estado}</span></td>             
              <td class="text-center">
                <a onclick="obtener_procesoventas_x_id(${id})"><i class="fa-solid fa-clipboard me-2"></i></a>
                <a onclick="archivar_proceso_ventas(${id})"><i class="fa-solid fa-box-archive me-2"></i></a>          
                ${icontoventas}     
              </td>
            </tr>`;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='6'>No se encontraron resultados.</td>`;
      }
      $("#listar_procesoventas").html(html);

      construirPaginacion_ProcesoVentas(pagina);
    },
  });
};
function construirPaginacion_ProcesoVentas(pagina_actual_pventas) {
  $.ajax({
    url: "controller/proceso_ventas.php",
    type: "POST",
    data: { option: "contar_pventas" },
    dataType: "json",
    success: function (response) {
      let total_pventas = response.total;
      let por_pagina = 7; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_pventas / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual_pventas == 1 ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listarRegistros_ProcesoVentas(${pagina_actual_pventas - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual_pventas == i ? "active" : ""
            }">
                              <a class="page-link" href="javascript:void(0);" onclick="listarRegistros_ProcesoVentas(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual_pventas == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listarRegistros_ProcesoVentas(${pagina_actual_pventas + 1
          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion_pventas").html(html);
    },
  });
}
const actualizar_proceso_ventas = function () {
  $("#formObtenerProcesoVentas").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formObtenerProcesoVentas")[0]);

data.forEach((valor, clave) => {
  console.log(`${clave}:`, valor);
});
    $.ajax({
      url: "controller/proceso_ventas.php", 
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

          listarRegistros_ProcesoVentas(1);
          $("#obtener-proceso-ventas").modal("hide");
          $("#formObtenerProcesoVentas").trigger("reset");
        }
      },
    });
  });
};
const agregar_procesoventas = function () {
  $("#formAgregarProcesoVentas").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formAgregarProcesoVentas")[0]);
    var data2 = $(this).serialize();
    console.log(data2);
    $.ajax({
      url: "controller/proceso_ventas.php",
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
          listarRegistros_ProcesoVentas(1);
          $("#formAgregarProcesoVentas").trigger("reset");
          $("#agregar-procesoventa").modal("hide");
        }
      },
    });
  });
};
const trasladar_to_ventas = function () {
  $("#formObtenerProcesoVentas_ventas").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formObtenerProcesoVentas_ventas")[0]);
    for (let pair of data.entries()) {
  console.log(pair[0] + ':', pair[1]);
}
    $.ajax({
      url: "controller/proceso_ventas.php",
      method: "POST",
      data: data,
      contentType: false,
      cache: false,
      processData: false,
      success: function (data) {
        console.log("Respuesta del servidor:", data);
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
          listarRegistros_ProcesoVentas(1);
          $("#to-ventasdesembolsadas").modal("hide");
        }
      },
    });
  });
};
const obtener_procesoventas = function (id) {
  $("#obtener-procesoventas").modal("show");
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
        $("#procesoventas_id").val(data[i]["id"]);
        $("#nombres_to_procesoventas").val(data[i]["nombres"]);
        $("#dni_to_procesoventas").val(data[i]["dni"]);
        $("#celular_to_procesoventas").val(data[i]["celular_1"]);
        $("#credito_to_procesoventas").val(data[i]["credito_max"]);
        $("#linea_to_procesoventas").val(data[i]["linea_max"]);
        $("#plazo_to_procesoventas").val(data[i]["plazo_max"]);
        $("#tipoproducto_to_procesoventas").val(data[i]["tipo_producto"]);
        $("#tem_to_procesoventas").val(data[i]["tem"]);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const filtro_procesoventa = function (pagina = 1) {
  var dni = document.getElementById("pv_dni").value.trim();
  var estado = document.getElementById("pv_estado").value.trim();
  var tipo_producto = document.getElementById("pv_tipoproducto").value.trim();
  var created_at = document.getElementById("pv_createdat").value.trim();

  $.ajax({
    url: "controller/proceso_ventas.php",
    method: "POST",
    data: {
      dni: dni,
      estado: estado,
      tipo_producto: tipo_producto,
      created_at: created_at,
      option: "filtro_procesoventas",
      pagina: pagina
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = "";
      if (data.length > 0) {
        data.map((x) => {
          const { id, nombres, dni, celular, created_at, estado } = x;
          if (estado === "Pendiente") {
            iconestado = "<i class='fa-solid fa-clock-rotate-left me-2'></i>";
            bgestado = "pendiente";
          } else if (estado === "Aprobado") {
            iconestado = "<i class='fa-solid fa-check me-2'></i>";
            bgestado = "aprobado";
          } else if (estado === "Desaprobado") {
            iconestado = "<i class='fa-solid fa-xmark me-2'></i>";
            bgestado = "desaprobado";
          } else if (estado === "Apelando") {
            iconestado = "<i class='fa-solid fa-exclamation me-2'></i>";
            bgestado = "apelando";
          }

          if (estado == "Aprobado") {
            icontoventas =
              `<a href="#" onclick="to_ventas_desembolsadas(${id})"><i class="icon-to-ventas fa-solid fa-circle-check"></i></a>`;
          } else if (estado == "Pendiente") {
            icontoventas =
              "<a href='#' id='pen_venta'><i class='icon-pen-ventas fa-solid fa-clock'></i></a>";
          } else if (estado == "Apelando") {
            icontoventas =
              "<a href='#' id='apela_venta'><i class='icon-apela-ventas fa-solid fa-circle-exclamation'></i></a>";
          } else if (estado == "Desaprobado") {
            icontoventas =
              "<a href='#' id='desa_venta'><i class='icon-no-ventas fa-solid fa-circle-xmark'></i></a>";
          }

          html =
            html +
            `<tr>
              <td>${nombres}</td>
              <td>${dni}</td>
              <td>${celular}</td>
              <td>${created_at}</td>
              <td class="text-center"><span class="icon-estado-${bgestado}">${iconestado}${estado}</span></td>             
              <td class="text-center">
                <a onclick="obtener_procesoventas_x_id(${id})"><i class="fa-solid fa-clipboard me-2"></i></a>
                <a onclick="obtener_cartera(${id})"></a><i class="fa-solid fa-box-archive me-2"></i></a>          
                ${icontoventas}     
              </td>
            </tr>`;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='6'>No se encontraron resultados.</td>`;
      }
      $("#listar_procesoventas").html(html);

      construirPaginacion_ProcesoVentas_filtro(pagina, dni, estado, tipo_producto, created_at);
    }
  });
};
function construirPaginacion_ProcesoVentas_filtro(pagina_actual_procesoventas, dni, estado, tipo_producto, created_at) {
  $.ajax({
    url: "controller/proceso_ventas.php",
    type: "POST",
    data: { option: "contar_procesoventas_filtro",
      dni: dni,
      estado: estado,
      tipo_producto: tipo_producto,
      created_at: created_at,
    },
    dataType: "json",
    success: function (response) {
      let total_procesoventas_filtro = response.total;
      let por_pagina = 7; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_procesoventas_filtro / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual_procesoventas == 1 ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="filtro_procesoventa(${pagina_actual_procesoventas - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual_procesoventas == i ? "active" : ""
            }">
                              <a class="page-link" href="javascript:void(0);" onclick="filtro_procesoventa(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual_procesoventas == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="filtro_procesoventa(${pagina_actual_procesoventas + 1
          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion_pventas").html(html);
    },
  });
}

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
          listar_carteras_paginadas(1);
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
            listar_carteras_paginadas(1);
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
          listar_carteras_paginadas(1);
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
            title: "No se encontraron campañas con el DNI solicitado.",
            padding: "2em",
          });
          listar_carteras_paginadas(1);
        }
        $("#listar_cartera").html(html);
      },
    });
  });
};

const listar_carteras_paginadas = function (pagina) {
  $.ajax({
    url: "controller/cartera.php",
    type: "POST",
    data: { option: "listar_pcartera", pagina: pagina },
    dataType: "json",
    success: function (response) {
      let html = "";
      if (response.length > 0) {
        response.map((x) => {
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

      construirPaginacion_Cartera(pagina);
    },
  });
};
function construirPaginacion_Cartera(pagina_actual_pcartera) {
  $.ajax({
    url: "controller/cartera.php",
    type: "POST",
    data: { option: "contar_pcartera" },
    dataType: "json",
    success: function (response) {
      let total_pcartera = response.total;
      let por_pagina = 11; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_pcartera / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual_pcartera == 1 ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listar_carteras_paginadas(${pagina_actual_pcartera - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual_pcartera == i ? "active" : ""
            }">
                              <a class="page-link" href="javascript:void(0);" onclick="listar_carteras_paginadas(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual_pcartera == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listar_carteras_paginadas(${pagina_actual_pcartera + 1
          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion_pcartera").html(html);
    },
  });
}
const filtro_cartera = function (pagina = 1) {
  var dni = document.getElementById("ca-dni").value.trim();

  $.ajax({
    url: "controller/cartera.php",
    method: "POST",
    data: {
      dni: dni,
      option: "filtro_cartera",
      pagina: pagina
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = "";
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
          `<tr><td class='text-center' colspan='5'>No se encontraron resultados.</td>`;
      }
      $("#listar_cartera").html(html);

      construirPaginacion_cartera_filtro(pagina, dni);
    }
  });
};
function construirPaginacion_cartera_filtro(pagina_actual_consultas, dni) {
  $.ajax({
    url: "controller/cartera.php",
    type: "POST",
    data: { option: "contar_cartera_filtro",
      dni: dni,},
    dataType: "json",
    success: function (response) {
      let total_cartera_filtro = response.total;
      let por_pagina = 11; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_cartera_filtro / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual_consultas == 1 ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="filtro_cartera(${pagina_actual_consultas - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual_consultas == i ? "active" : ""
            }">
                              <a class="page-link" href="javascript:void(0);" onclick="filtro_cartera(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual_consultas == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="filtro_cartera(${pagina_actual_consultas + 1
          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion_pcartera").html(html);
    },
  });
}


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
          $("#imgHeader").html(`<img src="img/fotos/${foto}" alt="${nombres.split(" ")[0]
            } ${apellidos.split(" ")[0]
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
};

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
                <a onclick="obtener_base(${id})"><i class="fa-solid fa-user-plus me-2"></i></a>
                <a onclick="trasladar_base(${id})"><i class="fa-solid fa-wallet"></i></a>
                <a onclick="obtener_procesoventas(${id})"><i class="fa-solid fa-plus"></i></a>
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
                          <a class="page-link" href="javascript:void(0);" onclick="listarRegistros(${pagina_actual - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual == i ? "active" : ""}">
                              <a class="page-link" href="javascript:void(0);" onclick="listarRegistros(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listarRegistros(${pagina_actual + 1
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

/* -------------------   VENTAS ARCHIVADAS   ---------------------- */

const listar_archivadoventas = function (pagina) {
  $.ajax({
    url: "controller/archivado_ventas.php",
    type: "POST",
    data: { option: "listar_aventas", pagina: pagina },
    dataType: "json",
    success: function (response) {
      let html = "";
      if (response.length > 0) {
        response.map((x) => {
          const { id_archivado, nombres, dni, descripcion, created_at } = x;
          html =
            html +
            `<tr>
              <td>${nombres}</td>
              <td>${dni}</td>
              <td>${descripcion}</td>
              <td>${created_at}</td>
              <td class="text-center">
                <a onclick="obtener_archivadoventas_x_id(${id_archivado})"><i class="fa-solid fa-box-open me-2"></i></a>   
              </td>
            </tr>`;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='6'>No se encontraron resultados.</td>`;
      }
      $("#listar_archivadoventas").html(html);

      construirPaginacion_ArhivadoVentas(pagina);
    },
  });
};
function construirPaginacion_ArhivadoVentas(pagina_actual_pventas) {
  $.ajax({
    url: "controller/archivado_ventas.php",
    type: "POST",
    data: { option: "contar_aventas" },
    dataType: "json",
    success: function (response) {
      let total_aventas = response.total;
      let por_pagina = 7; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_aventas / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual_pventas == 1 ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listar_archivadoventas(${pagina_actual_pventas - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual_pventas == i ? "active" : ""
            }">
                              <a class="page-link" href="javascript:void(0);" onclick="listar_archivadoventas(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual_pventas == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listar_archivadoventas(${pagina_actual_pventas + 1
          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion_archivadoventas").html(html);
    },
  });
}
const obtener_archivadoventas_x_id = function (id) {
  $("#obtener-venta-archivada").modal("show");
  $.ajax({
    url: "controller/archivado_ventas.php",
    method: "POST",
    data: {
      id: id,
      option: "obtener_archivados_x_id",
    },
    success: function (response) {
      data = JSON.parse(response);
      $.each(data, function (i, e) {
        $("#id_archivado_ventas").val(data[i]["id_archivado"]);
        $("#id_procesoventas_archivado_ventas").val(data[i]["id_proceso"]);
        $("#view-nombres-archivado").text(data[i]["nombres"]);
        $("#view-dni-archivado").text(data[i]["dni"]);
        $("#view-celular-archivado").text(data[i]["celular"]);
        $("#view-credito-archivado").text(data[i]["credito"]);
        $("#view-linea-archivado").text(data[i]["linea"]);
        $("#view-plazo-archivado").text(data[i]["plazo"]);
        $("#view-estado-archivado").text(data[i]["estado"]);
        $("#view-tipoproducto-archivado").text(data[i]["tipo_producto"]);
        $("#view-tem-archivado").text(data[i]["tem"]);
        $("#view-descripcion-archivado").text(data[i]["descripcion"]);
        $("#documento_actual").text(data[i]["documento"]);
        $("#documento-preview").text(data[i]["documento"] ? data[i]["documento"] : "No se ha seleccionado ningún archivo.");

        if (data[i]["documento"]) {
          const rutaDocumento = "pdf/documents/" + data[i]["documento"]; // ⚠️ Ajusta esto
          $("#verArchivado").off("click").on("click", function () {
            window.open(rutaDocumento, "_blank");
          }).show();
        } else {
          $("#verArchivado").hide();
        }
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener la meta: ", error);
      alert("Hubo un error al obtener la meta.");
    },
  });
};
const desarchivar_venta = function () {
  $("#formObtenerVentaArchivada").submit(function (e) {
    e.preventDefault();
    const data = new FormData($("#formObtenerVentaArchivada")[0]);
    for (const [key, value] of data.entries()) {
    console.log(key, value);}

    $.ajax({
      url: "controller/archivado_ventas.php",
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
          listar_archivadoventas(1);
          $("#obtener-venta-archivada").modal("hide");
          $("#formObtenerVentaArchivada").trigger("reset");
        }
      },
    });
  });
};
const filtro_archivadoventas = function (pagina = 1) {
  var dni = document.getElementById("ar_dni").value.trim();
  var created_at = document.getElementById("ar_createdat").value.trim();

  $.ajax({
    url: "controller/archivado_ventas.php",
    method: "POST",
    data: {
      dni: dni,
      created_at: created_at,
      option: "filtro_archivadoventas",
      pagina: pagina
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = "";
      if (data.length > 0) {
        data.map((x) => {
          const { id_archivado, nombres, dni, descripcion, created_at } = x;
          html =
            html +
            `<tr>
              <td>${nombres}</td>
              <td>${dni}</td>
              <td>${descripcion}</td>
              <td>${created_at}</td>
              <td class="text-center">
                <a onclick="obtener_archivadoventas_x_id(${id_archivado})"><i class="fa-solid fa-box-open me-2"></i></a>   
              </td>
            </tr>`;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='6'>No se encontraron resultados.</td>`;
      }
      $("#listar_archivadoventas").html(html);

      construirPaginacion_ArchivadoVentas_filtro(pagina, dni, created_at);
    }
  });
};
function construirPaginacion_ArchivadoVentas_filtro(pagina_actual_archivadoventas, dni, created_at) {
  $.ajax({
    url: "controller/archivado_ventas.php",
    type: "POST",
    data: { option: "contar_archivados_filtro",
      dni: dni,
      created_at: created_at,
    },
    dataType: "json",
    success: function (response) {
      let total_archivadoventas_filtro = response.total;
      let por_pagina = 3; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_archivadoventas_filtro / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual_archivadoventas == 1 ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="filtro_archivadoventas(${pagina_actual_archivadoventas - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual_archivadoventas == i ? "active" : ""
            }">
                              <a class="page-link" href="javascript:void(0);" onclick="filtro_archivadoventas(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual_archivadoventas == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="filtro_archivadoventas(${pagina_actual_archivadoventas + 1
          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion_archivadoventas").html(html);
    },
  });
}

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

// const listar_consultas = function () {
//   $.ajax({
//     url: "controller/consultas.php",
//     success: function (response) {
//       const data = JSON.parse(response);
//       let html = ``;
//       if (data.length > 0) {
//         data.map((x) => {
//           const { id, dni, celular, descripcion, campana } = x;
//           html =
//             html +
//             `<tr>
//               <td>${dni}</td>
//               <td>${celular}</td>
//               <td>${descripcion}</td>
//               <td>${campana}</td>
//               <td class="text-center">
//                 <a onclick="obtener_consultas(${id})"><i class="fa-solid fa-circle-plus me-3"></i></a>
//                 <a onclick="obtener_consulta_cartera(${id})"><i class="fa-solid fa-wallet me-3"></i>
//                 <a onclick="eliminar_consulta(${id})"><i class="fa-solid fa-trash me-3"></i></a>
//               </td>
//             </tr>`;
//         });
//       } else {
//         html =
//           html +
//           `<tr><td class='text-center' colspan='6'>No se encontraron resultados.</td>`;
//       }
//       $("#listar_consultas").html(html);
//     },
//   });
// };

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
          listar_consultas_paginadas();
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
            listar_consultas_paginadas(1);
          } else {
            alert("algo salio mal" + data);
          }
        },
      });
    }
  });
};
const filtro_consultas = function (pagina = 1) {
  var dni = document.getElementById("c-dni").value.trim();
  var campana = document.getElementById("c-campana").value.trim();

  $.ajax({
    url: "controller/consultas.php",
    method: "POST",
    data: {
      dni: dni,
      campana: campana,
      option: "filtro_consultas",
      pagina: pagina
    },
    success: function (response) {
      const data = JSON.parse(response);
      let html = ``;
      if (data.length > 0) {
        data.map((x) => {
          const { id, dni, celular, descripcion, campana, created_at } = x;
          let estadocampana = campana == "Si" ? "aprobado" : "desaprobado";

          html += `
            <tr>
              <td>${dni}</td>
              <td>${celular}</td>
              <td>${descripcion}</td>
              <td class="text-center"><span class="icon-estado-${estadocampana}">${campana}</span></td>        
              <td class="text-center">
                <a onclick="obtener_consultas(${id})"><i class="fa-solid fa-circle-plus me-2"></i></a>
                <a onclick="obtener_consulta_cartera(${id})"><i class="fa-solid fa-wallet me-2"></i></a>
                <a onclick="eliminar_consulta(${id})"><i class="fa-solid fa-trash me-2"></i></a>     
              </td>
            </tr>`;
        });
      } else {
        html = `<tr><td class='text-center' colspan='6'>No se encontraron resultados.</td></tr>`;
      }

      $("#listar_consultas").html(html);

      construirPaginacion_consultas_filtro(pagina, dni, campana);
    },
  });
};
function construirPaginacion_consultas_filtro(pagina_actual_consultas, dni, campana) {
  $.ajax({
    url: "controller/consultas.php",
    type: "POST",
    data: { option: "contar_consultas_filtro",
      dni: dni,
      campana: campana,},
    dataType: "json",
    success: function (response) {
      let total_consultas_filtro = response.total;
      let por_pagina = 7; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_consultas_filtro / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual_consultas == 1 ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="filtro_consultas(${pagina_actual_consultas - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual_consultas == i ? "active" : ""
            }">
                              <a class="page-link" href="javascript:void(0);" onclick="filtro_consultas(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual_consultas == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="filtro_consultas(${pagina_actual_consultas + 1
          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion_consultas").html(html);
    },
  });
}
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
const listar_consultas_paginadas = function (pagina) {
  $.ajax({
    url: "controller/consultas.php",
    type: "POST",
    data: { option: "listar_consultas_pag", pagina: pagina },
    dataType: "json",
    success: function (response) {
      let html = "";
      if (response.length > 0) {
        response.map((x) => {
          const { id, dni, celular, descripcion, campana } = x;

          if (campana == "Si") {
            estadocampana =
              "aprobado";
          } else if (campana == "No") {
            estadocampana =
              "desaprobado";
          } 

          html =
            html +
            `<tr>
              <td>${dni}</td>
              <td>${celular}</td>
              <td>${descripcion}</td>
              <td class="text-center"><span class="icon-estado-${estadocampana}">${campana}</span></td>        
              <td class="text-center">
                <a onclick="obtener_consultas(${id})"><i class="fa-solid fa-circle-plus me-2"></i></a>
                <a onclick="obtener_consulta_cartera(${id})"><i class="fa-solid fa-wallet me-2"></i>
                <a onclick="eliminar_consulta(${id})"><i class="fa-solid fa-trash me-2"></i></a>     
              </td>
            </tr>`;
        });
      } else {
        html =
          html +
          `<tr><td class='text-center' colspan='5'>No se encontraron resultados.</td>`;
      }
      $("#listar_consultas").html(html);

      construirPaginacion_consultas(pagina);
    },
  });
};
function construirPaginacion_consultas(pagina_actual_consultas) {
  $.ajax({
    url: "controller/consultas.php",
    type: "POST",
    data: { option: "contar_consultas" },
    dataType: "json",
    success: function (response) {
      let total_consultas = response.total;
      let por_pagina = 7; // Cantidad de registros por página
      let total_paginas = Math.ceil(total_consultas / por_pagina);
      let html = "";

      if (total_paginas > 1) {
        // Botón anterior
        html += `<li class="page-item ${pagina_actual_consultas == 1 ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listar_consultas_paginadas(${pagina_actual_consultas - 1
          });">Anterior</a>
                      </li>`;

        // Botones de páginas
        for (let i = 1; i <= total_paginas; i++) {
          html += `<li class="page-item ${pagina_actual_consultas == i ? "active" : ""
            }">
                              <a class="page-link" href="javascript:void(0);" onclick="listar_consultas_paginadas(${i});">${i}</a>
                          </li>`;
        }

        // Botón siguiente
        html += `<li class="page-item ${pagina_actual_consultas == total_paginas ? "disabled" : ""
          }">
                          <a class="page-link" href="javascript:void(0);" onclick="listar_consultas_paginadas(${pagina_actual_consultas + 1
          });">Siguiente</a>
                      </li>`;
      }

      $("#paginacion_consultas").html(html);
    },
  });
}

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
  const boton = document.getElementById("btn-descargar-excel");
  if (boton) {
    boton.addEventListener("click", () => {
      window.location.href = "controller/exp_excel.php";
    });
  }
};

/* ---------------------- WORD ------------------------- */

const exportar_word = () => {
  const boton = document.getElementById("btn-descargar-word");
  if (boton) {
    boton.addEventListener("click", () => {
      window.location.href = "controller/exp_word.php";
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
