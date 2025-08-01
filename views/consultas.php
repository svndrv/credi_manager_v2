<main class="content-pages content px-5 py-4">
    <section class="container-fluid mt-3">
        <article class="card shadow bg-body-tertiary">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    Gestión de Consultas
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">

                    <div class="col-lg-3 mb-4">
                        <form id="form_consultas">
                            <input type="text" class="form-control" id="c-dni" name="c-dni" placeholder="Ingrese un DNI">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <select class="form-select" name="c-campana" id="c-campana">
                            <option value="0">Estado de campaña</option>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-3">
                        <button type="submit" class="btn btn-dark w-25"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive  border-4">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">ID</th>
                                        <th scope="col">DNI</th>
                                        <th scope="col">Celular</th>
                                        <th scope="col">Descripción</th>
                                        <th scope="col">Campaña</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listar_consultas">
                                    <tr>
                                        <td colspan="6" class="text-center">No hay datos...</td>
                                    </tr>
                                </tbody>
                            </table>
                            <nav aria-label="Navegación de páginas">
                                <ul id="paginacion_consultas" class="pagination justify-content-center">
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

<div class="modal fade" id="editar-consulta" tabindex="-1" aria-labelledby="editar-consultaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="editar-consultaModalLabel">Trasladar a Ventas en Proceso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerBase">
                    <input type="hidden" name="option" value="agregar_ventas">
                    <input type="hidden" name="id" id="id2">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <input type="hidden" id="estado" name="estado" value="Pendiente">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="edinombres" name="nombres">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="dni2" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="celular2" name="celular">
                            </div>
                            <div class="mb-3">
                                <label for="tem" class="form-label">TEM:</label>
                                <input type="text" class="form-control" id="tem" name="tem" value="0.00">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_max" class="form-label">Credito:</label>
                                <input type="text" class="form-control" id="credito_max" name="credito" value="0.000">
                            </div>
                            <div class="mb-3">
                                <label for="linea" class="form-label">Linea:</label>
                                <input type="text" class="form-control" id="linea" name="linea" value="0.000">
                            </div>
                            <div class="mb-3">
                                <label for="plazo_max" class="form-label">Plazo:</label>
                                <select class="form-select" name="plazo" id="plazo_max">
                                    <option selected>Plazo</option>
                                    <option value="00">0</option>
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="36">36</option>
                                    <option value="48">48</option>
                                    <option value="72">72</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_producto" class="form-label">Producto:</label>
                                <select class="form-select" name="tipo_producto" id="tipo_producto">
                                    <option value="0">Producto</option>
                                    <option value="LD">LD</option>
                                    <option value="TC">TC</option>
                                    <option value="LD/TC">LD/TC</option>
                                </select>
                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Trasladar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="agregar-consulta-cartera" tabindex="-1" aria-labelledby="agregar-consulta-carteraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="agregar-consulta-carteraModalLabel">Transladar a Cartera</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarCartera">
                    <input type="hidden" name="option" value="agregar_cartera">
                    <input type="hidden" id="con_id" name="id">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="con_nombres" name="nombres" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="con_dni" name="dni" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="con_celular" name="celular" aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="to_consultas_procesoventas" tabindex="-1" aria-labelledby="obtener-ProcesoVentasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="to_procesoventasLabel">Transladar a Ventas en Proceso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerProcesoVentas" enctype="multipart/form-data">

                    <input type="hidden" name="opcion" value="base_x_id">
                    <input type="hidden" name="option" value="agregar_procesoventas">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <input type="hidden" id="estado" name="estado" value="Pendiente">

                    <div class="row p-2">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres_to_procesoventas" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombres_to_procesoventas" name="nombres">
                            </div>
                            <div class="mb-3">
                                <label for="dni_to_procesoventas" class="form-label">Dni</label>
                                <input type="text" class="form-control" id="dni_to_procesoventas" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular_to_procesoventas" class="form-label">Celular</label>
                                <input type="text" class="form-control" id="celular_to_procesoventas" name="celular">
                            </div>

                            <div class="mb-3">
                                <label for="tem_to_procesoventas" class="form-label">TEM</label>
                                <input type="text" class="form-control" id="tem_to_procesoventas" name="tem">
                            </div>
                            <!-- <div class="mb-3">
                                <label for="fecha_procesoventas" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_procesoventas" name="fecha_procesoventas" value="<?= date('Y-m-d') ?>">
                            </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_to_procesoventas" class="form-label">Crédito</label>
                                <input type="text" class="form-control" id="credito_to_procesoventas" name="credito">
                            </div>
                            <div class="mb-3">
                                <label for="linea_to_procesoventas" class="form-label">Linea</label>
                                <input type="text" class="form-control" id="linea_to_procesoventas" name="linea">
                            </div>
                            <div class="mb-3">
                                <label for="plazo_to_procesoventas" class="form-label">Plazo</label>
                                <select class="form-select" id="plazo_to_procesoventas" name="plazo">
                                    <option value="0">Plazo</option>
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="36">36</option>
                                    <option value="48">48</option>
                                    <option value="72">72</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tipoproducto_consultas_to_procesoventas" class="form-label">Producto</label>
                                <select class="form-select" id="tipoproducto_consultas_to_procesoventas" name="tipo_producto">
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
                                    <input type="hidden" name="archivoDocumento" id="archivoDocumento" value="">
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
                <button type="submit" class="btn btn-success">Transladar</button>
            </div>
            </form>
        </div>
    </div>
</div>