<main class="content-pages content px-5 py-4">
    <section class="container-fluid">
        <article class="card shadow bg-body-tertiary">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    Tabla de Ventas en Proceso
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 mb-4">
                        <form id="form_filtro_procesoventas">
                            <input type="text" class="form-control" id="pv_dni" name="dni" placeholder="Ingrese un DNI">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <select class="form-select" id="pv_estado" name="estado">
                            <option value="0">Estado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Aprobado">Aprobado</option>
                            <option value="Apelando">Apelando</option>
                            <option value="Desaprobado">Desaprobado</option>
                            <!-- <option value="Cancelado">Cancelado</option> -->
                        </select>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <select class="form-select" id="pv_tipoproducto" name="tipo_producto">
                            <option value="0">Producto</option>
                            <option value="LD">LD</option>
                            <option value="TC">TC</option>
                            <option value="LD/TC">LD/TC</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <input type="date" class="form-control" id="pv_createdat" name="created_at" value="">
                    </div>
                    <div class="col-lg-3">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>
                            <div class="col-lg-6 text-end">
                                <button type="button" class="btn btn-warning btn-md px-4 text-white" data-bs-toggle="modal" data-bs-target="#agregar-procesoventa">
                                    <i class="fa-solid fa-user-plus"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pt-3">
                        <div class="table-responsive border-4">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Dni</th>
                                        <th scope="col">Celular</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listar_procesoventas">
                                    <tr>
                                        <td colspan="6" class="text-center">No hay datos...</td>
                                    </tr>
                                </tbody>

                            </table>
                            <nav aria-label="Navegación de páginas">
                                <ul id="paginacion_pventas" class="pagination justify-content-center">
                                    <!-- Aquí se agregarán dinámicamente los enlaces de paginación -->
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
</main>


<!--======================== MODALS ========================-->

<div class="modal fade" id="obtener-proceso-ventas" tabindex="-1" aria-labelledby="obtener-ProcesoVentasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="obtener-procesoventasLabel">Ver y Editar Ventas en Proceso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerProcesoVentas" enctype="multipart/form-data">

                    <input type="hidden" name="option" value="actualizar_procesoventas">
                    <input type="hidden" name="id" id="id_ob_pventas">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">


                    <div class="row p-2">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres_ob_pventas" class="form-label fw-bold">Nombre completo</label>
                                <input type="text" class="form-control" id="nombres_ob_pventas" name="nombres" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="dni_ob_pventas" class="form-label fw-bold">Dni</label>
                                <input type="text" class="form-control" id="dni_ob_pventas" name="dni" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="celular_ob_pventas" class="form-label fw-bold">Celular</label>
                                <input type="text" class="form-control" id="celular_ob_pventas" name="celular" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="tem_ob_pventas" class="form-label fw-bold">TEM</label>
                                <input type="text" class="form-control" id="tem_ob_pventas" name="tem" disabled>
                            </div>
                            <?php if ($_SESSION['rol'] === '1' || $_SESSION['rol'] === '2') { ?>
                                <div class="mb-3">
                                    <label for="estado_ob_pventas" class="form-label fw-bold">Estado:</label>
                                    <select class="form-select" name="estado" id="estado_ob_pventas" disabled>
                                        <option value="0">Estado</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Apelando">Apelando</option>
                                        <option value="Desaprobado">Desaprobado</option>
                                        <option value="Aprobado">Aprobado</option>
                                    </select>
                                </div>
                            <?php } ?>

                            <!-- <div class="mb-3">
                                <label for="fecha_procesoventas" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_procesoventas" name="fecha_procesoventas" value="<?= date('Y-m-d') ?>">
                            </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_ob_pventas" class="form-label fw-bold">Crédito</label>
                                <input type="text" class="form-control" id="credito_ob_pventas" name="credito" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="linea_ob_pventas" class="form-label fw-bold">Linea</label>
                                <input type="text" class="form-control" id="linea_ob_pventas" name="linea" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="plazo_ob_pventas" class="form-label fw-bold">Plazo</label>
                                <select class="form-select" id="plazo_ob_pventas" name="plazo" disabled>
                                    <option selected>Plazo</option>
                                    <option value="0">0</option>
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="36">36</option>
                                    <option value="48">48</option>
                                    <option value="72">72</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tipoproducto_ob_pventas" class="form-label fw-bold">Producto</label>
                                <select class="form-select" id="tipoproducto_ob_pventas" name="tipo_producto" disabled>
                                    <option value="0">Producto</option>
                                    <option value="LD">LD</option>
                                    <option value="TC">TC</option>
                                    <option value="LD/TC">LD/TC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="documento" class="form-label fw-bold">Documento</label>
                                <div class="input-group mb-3">
                                    <input class="form-control d-none" type="file" name="documento" id="documento" accept="application/pdf">
                                    <button id="bton-trash-edit-pv" class="btn btn-secondary d-none" type="button" onclick="
                                        document.getElementById('documento').value = '';
                                        document.getElementById('archivoDocumento').value = '';
                                        document.getElementById('documento-preview').innerText = 'No se ha seleccionado ningún archivo.';
                                        document.getElementById('linkDocumento').style.display = 'none';
                                        ">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                                <button id="btnVerDocumento" type="button" class="btn btn-primary">
                                    <i class="fa-solid fa-eye me-2"></i>Ver solicitud
                                </button>
                                <p id="documento-preview" class="form-text text-muted">No se ha seleccionado ningún archivo.</p>
                            </div>
                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="deshabilitar_text_edit()">Cerrar</button>
                <button id="boton_submit_edit" type="submit" class="btn btn-primary d-none">Editar datos</button>
                <button id="boton_edit" type="button" class="btn btn-success" onclick="habilitar_text_edit()"><i class="fa-solid fa-pen"></i></button>
                <button id="boton_read" type="button" class="btn btn-primary d-none" onclick="deshabilitar_text_edit()"><i class="fa-brands fa-readme"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="agregar-procesoventa" tabindex="-1" aria-labelledby="agregar-ProcesoVentasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="agregar-procesoventasLabel">Agregar Proceso en Ventas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarProcesoVentas" enctype="multipart/form-data">

                    <input type="hidden" name="option" value="agregar_procesoventas">
                    <input type="hidden" id="id_add_pventas" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <input type="hidden" id="estado_add_pventas" name="estado" value="Pendiente">

                    <div class="row p-2">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres_add_pventas" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombres_add_pventas" name="nombres">
                            </div>
                            <div class="mb-3">
                                <label for="dni_add_pventas" class="form-label">Dni</label>
                                <input type="text" class="form-control" id="dni_add_pventas" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular_add_pventas" class="form-label">Celular</label>
                                <input type="text" class="form-control" id="celular_add_pventas" name="celular">
                            </div>

                            <div class="mb-3">
                                <label for="tem_add_pventas" class="form-label">TEM</label>
                                <input type="text" class="form-control" id="tem_add_pventas" name="tem">
                            </div>
                            <!-- <div class="mb-3">
                                <label for="fecha_procesoventas" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_procesoventas" name="fecha_procesoventas" value="<?= date('Y-m-d') ?>">
                            </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_add_pventas" class="form-label">Crédito</label>
                                <input type="text" class="form-control" id="credito_add_pventas" name="credito">
                            </div>
                            <div class="mb-3">
                                <label for="linea_add_pventas" class="form-label">Linea</label>
                                <input type="text" class="form-control" id="linea_add_pventas" name="linea">
                            </div>
                            <div class="mb-3">
                                <label for="plazo_add_pventas" class="form-label">Plazo</label>
                                <select class="form-select" id="plazo_add_pventas" name="plazo">
                                    <option selected>Plazo</option>
                                    <option value="0">0</option>
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="36">36</option>
                                    <option value="48">48</option>
                                    <option value="72">72</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tipoproducto_add_pventas" class="form-label">Producto</label>
                                <select class="form-select" id="tipoproducto_add_pventas" name="tipo_producto">
                                    <option value="0">Producto</option>
                                    <option value="LD">LD</option>
                                    <option value="TC">TC</option>
                                    <option value="LD/TC">LD/TC</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="documento" class="form-label">Cargar Documento</label>
                                <div class="input-group">
                                    <input class="form-control" type="file" name="documento" id="documento" accept="application/pdf">
                                    <button class="btn btn-secondary" type="button" onclick="
                                            document.getElementById('documento').value = '';
                                            document.getElementById('archivoDocumento').value = '';
                                            document.getElementById('documento-preview').innerText = 'No se ha seleccionado ningún archivo.';
                                        ">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>

                                </div>

                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Agregar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="to-ventasdesembolsadas" tabindex="-1" aria-labelledby="ventasdesembolsadasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="ventasdesembolsadasLabel">Trasladar a Ventas Desembolsadas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerProcesoVentas_ventas" enctype="multipart/form-data">

                    <input type="hidden" name="option" value="trasladar_to_ventas">
                    <input type="hidden" name="id" id="id_to_ventas">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <div class="row p-2">
                        <p class="h5 fw-bold pb-3">Resumen de venta</p>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres_to_ventas" class="form-label fw-bold">Nombre completo</label>
                                <p id="view-nombres-to-ventas"></p>
                                <input type="hidden" class="form-control" id="nombres_to_ventas" name="nombres">
                            </div>
                            <div class="mb-3">
                                <label for="dni_to_ventas" class="form-label fw-bold">Dni</label>
                                <p id="view-dni-to-ventas"></p>
                                <input type="hidden" class="form-control" id="dni_to_ventas" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular_to_ventas" class="form-label fw-bold">Celular</label>
                                <p id="view-celular-to-ventas"></p>
                                <input type="hidden" class="form-control" id="celular_to_ventas" name="celular">
                            </div>

                            <div class="mb-3">
                                <label for="tem_to_ventas" class="form-label fw-bold">TEM</label>
                                <p id="view-tem-to-ventas"></p>
                                <input type="hidden" class="form-control" id="tem_to_ventas" name="tem">
                            </div>
                            <div class="mb-3">
                                <label for="documento" class="form-label fw-bold d-block">Documento</label>
                                <img src="img/add-pv/img_pdf.jpg" class="logo-table-mini me-2"><a href="#" id="verSolicitud" style="display: none;">Ver solicitud</a>
                                <input type="hidden" class="form-control" id="documento-preview-to-ventas" name="documento">
                                <!-- <p id="documento-preview-to-ventas" class="form-text text-muted">No se ha seleccionado ningún archivo.</p> -->
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_to_ventas" class="form-label fw-bold">Crédito</label>
                                <p id="view-credito-to-ventas"></p>
                                <input type="hidden" class="form-control" id="credito_to_ventas" name="credito">
                            </div>
                            <div class="mb-3">
                                <label for="linea_to_ventas" class="form-label fw-bold">Linea</label>
                                <p id="view-linea-to-ventas"></p>
                                <input type="hidden" class="form-control" id="linea_to_ventas" name="linea">
                            </div>
                            <div class="mb-3">
                                <label for="plazo_to_ventas" class="form-label fw-bold">Plazo</label>
                                <p id="view-plazo-to-ventas"></p>
                                <input type="hidden" class="form-control" id="plazo_to_ventas" name="plazo">
                            </div>
                            <div class="mb-3">
                                <label for="tipoproducto_to_ventas" class="form-label fw-bold">Producto</label>
                                <p id="view-tipoproducto-to-ventas"></p>
                                <input type="hidden" class="form-control" id="tipoproducto_to_ventas" name="tipo_producto">
                            </div>
                            <div class="mb-3">
                                <label for="estado_to_ventas" class="form-label fw-bold">Estado</label>
                                <p id="view-estado-to-ventas"></p>
                                <input type="hidden" class="form-control" id="estado_to_ventas" name="estado">
                            </div>
                        </div>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="deshabilitar_text_edit()">Cerrar</button>
                <button type="submit" class="btn btn-success">Trasladar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="archivar-procesoventas" tabindex="-1" aria-labelledby="archivar_procesoventasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="archivar_procesoventasLabel">Archivar Venta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formToArchivadoVentas" enctype="multipart/form-data">
                    <input type="text" name="id_procesoventas" id="id_to_archivar_venta">
                    <input type="text" name="option" value="agregar_archivadoventas">
                    <div class="row p-2">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres_to_ventas" class="form-label fw-bold">Nombre completo</label>
                                <p id="view-nombres-to-archive"></p>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="fechar_archivar" class="form-label fw-bold">Fecha</label>
                                <input type="date" class="form-control" id="fecha_archivar" name="created_at" value="<?= date('Y-m-d') ?>" readonly>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="descripcion_archivar" class="form-label fw-bold">Motivo</label>
                                <textarea class="form-control" id="descripcion_archivar" rows="4" name="descripcion" style="resize: none;"></textarea>
                            </div>

                        </div>
                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="deshabilitar_text_edit()">Cerrar</button>
                <button type="submit" class="btn btn-success">Archivar</button>
            </div>
            </form>
        </div>
    </div>
</div>