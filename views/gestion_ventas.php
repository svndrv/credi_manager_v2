<main class="content-pages content px-5 py-4">
    <section class="container-fluid">
        <article class="card shadow bg-body-tertiary">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    Tabla de Ventas en Gestión
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 mb-4">
                        <form id="form_filtro_gestionoventas">
                            <input type="text" class="form-control" id="gv_dni" name="dni" placeholder="Ingrese un DNI">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <select class="form-select" aria-label="Default select example" id="gv_id_usuario" name="id_usuario_f">
                            <option value=0>Seleccionar Usuario</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <select class="form-select" id="gv_estado" name="estado">
                            <option value="0">Estado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Aprobado">Aprobado</option>
                            <option value="Apelando">Apelando</option>
                            <option value="Desaprobado">Desaprobado</option>
                            <!-- <option value="Cancelado">Cancelado</option> -->
                        </select>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <select class="form-select" id="gv_tipoproducto" name="tipo_producto">
                            <option value="0">Producto</option>
                            <option value="LD">LD</option>
                            <option value="TC">TC</option>
                            <option value="LD/TC">LD/TC</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <input type="date" class="form-control" id="gv_createdat" name="created_at" value="">
                    </div>
                    <div class="col-lg-1">
                        <div class="row">
                            <div class="col-lg-6">
                                <button type="submit" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 pt-3">
                        <div class="table-responsive border-4">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">ID</th>
                                        <th scope="col">Usuario</th>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Dni</th>
                                        <th scope="col">Celular</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Estado</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listar_gestionventas">
                                    <tr>
                                        <td colspan="8" class="text-center">No hay datos...</td>
                                    </tr>
                                </tbody>

                            </table>
                            <nav aria-label="Navegación de páginas">
                                <ul id="paginacion_gventas" class="pagination justify-content-center">
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

<div class="modal fade" id="obtener-gestion-ventas" tabindex="-1" aria-labelledby="obtener-gestion-ventasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="obtener-gestion-ventasLabel">Ver y Editar Ventas en Proceso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerGestionVentas" enctype="multipart/form-data">

                    <input type="hidden" name="option" value="actualizar_procesoventas">
                    <input type="hidden" name="id" id="id_ob_gventas">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">

                    <div class="row p-2">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="nombres_ob_gventas" class="form-label fw-bold">Nombre completo</label>
                                <input type="text" class="form-control" id="nombres_ob_gventas" name="nombres">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="dni_ob_gventas" class="form-label fw-bold">Dni</label>
                                <input type="text" class="form-control" id="dni_ob_gventas" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular_ob_gventas" class="form-label fw-bold">Celular</label>
                                <input type="text" class="form-control" id="celular_ob_gventas" name="celular">
                            </div>

                            <div class="mb-3">
                                <label for="tem_ob_gventas" class="form-label fw-bold">TEM</label>
                                <input type="text" class="form-control" id="tem_ob_gventas" name="tem">
                            </div>
                            <?php if ($_SESSION['rol'] === '1' || $_SESSION['rol'] === '2') { ?>
                                <div class="mb-3">
                                    <label for="estado_ob_gventas" class="form-label fw-bold">Estado:</label>
                                    <select class="form-select" name="estado" id="estado_ob_gventas">
                                        <option value="0">Estado</option>
                                        <option value="Pendiente">Pendiente</option>
                                        <option value="Apelando">Apelando</option>
                                        <option value="Desaprobado">Desaprobado</option>
                                        <option value="Aprobado">Aprobado</option>
                                    </select>
                                </div>
                            <?php } else { ?>
                                <input type="hidden" class="form-control" id="estado_ob_gventas" name="estado">
                            <?php } ?>

                            <!-- <div class="mb-3">
                                <label for="fecha_procesoventas" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_procesoventas" name="fecha_procesoventas" value="<?= date('Y-m-d') ?>">
                            </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_ob_gventas" class="form-label fw-bold">Crédito</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon1">S/.</span>
                                    <input type="text" class="form-control" id="credito_ob_gventas" name="credito" aria-describedby="basic-addon2">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="credito_ob_gventas" class="form-label fw-bold">Crédito</label>
                                <div class="input-group">
                                    <span class="input-group-text" id="basic-addon2">S/.</span>
                                    <input type="text" class="form-control" id="linea_ob_gventas" name="linea" aria-describedby="basic-addon2">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="plazo_ob_gventas" class="form-label fw-bold">Plazo</label>
                                <select class="form-select" id="plazo_ob_gventas" name="plazo">
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
                                <label for="tipoproducto_ob_gventas" class="form-label fw-bold">Producto</label>
                                <select class="form-select" id="tipoproducto_ob_gventas" name="tipo_producto">
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success"><i class="fa-solid fa-pen"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>