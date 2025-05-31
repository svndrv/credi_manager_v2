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
                        <form id="form_filtro_ventas">
                            <input type="text" class="form-control" id="dni_f" name="dni" placeholder="Ingrese un DNI">
                    </div>
                    <div class="col-lg-3 mb-4">
                        <select class="form-select" name="estado" id="estado_f">
                            <option value="0">Estado</option>
                            <option value="Pendiente">Pendiente</option>
                            <option value="Desembolsado">Desembolsado</option>
                            <!-- <option value="Cancelado">Cancelado</option> -->
                        </select>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <select class="form-select" name="tipo_producto" id="tipo_producto_f">
                            <option value="0">Producto</option>
                            <option value="LD">LD</option>
                            <option value="TC">TC</option>
                            <option value="LD/TC">LD/TC</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <input type="date" class="form-control" id="fecha_misventas" name="fecha_misventas" value="<?= date('Y-m-d') ?>">
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
                        <div class="table-responsive  border-4">
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


<div class="modal fade" id="obtener-proceso-ventas" tabindex="-1" aria-labelledby="obtener-ProcesoVentasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obtener-procesoventasLabel">Transladar a Ventas Desembolsadas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerProcesoVentas" enctype="multipart/form-data">

                    <input type="hidden" name="option" value="agregar_procesoventas">
                    <input type="hidden" name="procesoventas_id" id="procesoventas_id">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">


                    <div class="row p-2">               
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres_procesoventas" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombres_procesoventas" name="nombres" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="dni_procesoventas" class="form-label">Dni</label>
                                <input type="text" class="form-control" id="dni_procesoventas" name="dni" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="celular1_procesoventas" class="form-label">Celular</label>
                                <input type="text" class="form-control" id="celular1_procesoventas" name="celular" disabled>
                            </div>

                            <div class="mb-3">
                                <label for="tem_procesoventas" class="form-label">TEM</label>
                                <input type="text" class="form-control" id="tem_procesoventas" name="tem" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="estado" class="form-label">Estado</label>
                                <input type="text" class="form-control" id="estado" name="estado" value="Pendiente" disabled>
                            </div>

                            <!-- <div class="mb-3">
                                <label for="fecha_procesoventas" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_procesoventas" name="fecha_procesoventas" value="<?= date('Y-m-d') ?>">
                            </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_max_procesoventas" class="form-label">Crédito</label>
                                <input type="text" class="form-control" id="credito_max_procesoventas" name="credito" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="linea_procesoventas" class="form-label">Linea</label>
                                <input type="text" class="form-control" id="linea_procesoventas" name="linea" disabled>
                            </div>
                            <div class="mb-3">
                                <label for="plazo_max_procesoventas" class="form-label">Plazo</label>
                                <select class="form-select" id="plazo_max_procesoventas" name="plazo" disabled>
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
                                <label for="tipo_producto_procesoventas" class="form-label">Producto</label>
                                <select class="form-select" id="tipo_producto_procesoventas" name="tipo_producto" disabled>
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
                                    <input class="form-control" type="file" name="documento" id="documento" accept="application/pdf" disabled>
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
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="deshabilitar_text_edit()">Cerrar</button>
                <button id="boton_submit_edit" type="submit" class="btn btn-danger d-none">Editar datos</button>
                <button id="boton_edit" type="button" class="btn btn-primary" onclick="habilitar_text_edit()"><i class="fa-solid fa-pen"></i></button>
                <button id="boton_read" type="button" class="btn btn-danger d-none" onclick="deshabilitar_text_edit()"><i class="fa-brands fa-readme"></i></button>
            </div>
            </form>
        </div>
    </div>
</div>





<div class="modal fade" id="agregar-procesoventa" tabindex="-1" aria-labelledby="agregar-ProcesoVentasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="agregar-procesoventasLabel">Transladar a Ventas en Proceso</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarProcesoVentas" enctype="multipart/form-data">

                    <input type="text" name="option" value="agregar_procesoventas">
                    <input type="text" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <input type="text" id="estado" name="estado" value="Pendiente">

                    <div class="row p-2">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres_procesoventas" class="form-label">Nombre completo</label>
                                <input type="text" class="form-control" id="nombres_procesoventas" name="nombres">
                            </div>
                            <div class="mb-3">
                                <label for="dni_procesoventas" class="form-label">Dni</label>
                                <input type="text" class="form-control" id="dni_procesoventas" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular1_procesoventas" class="form-label">Celular</label>
                                <input type="text" class="form-control" id="celular1_procesoventas" name="celular">
                            </div>

                            <div class="mb-3">
                                <label for="tem_procesoventas" class="form-label">TEM</label>
                                <input type="text" class="form-control" id="tem_procesoventas" name="tem">
                            </div>
                            <!-- <div class="mb-3">
                                <label for="fecha_procesoventas" class="form-label">Fecha</label>
                                <input type="date" class="form-control" id="fecha_procesoventas" name="fecha_procesoventas" value="<?= date('Y-m-d') ?>">
                            </div> -->
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_max_procesoventas" class="form-label">Crédito</label>
                                <input type="text" class="form-control" id="credito_max_procesoventas" name="credito">
                            </div>
                            <div class="mb-3">
                                <label for="linea_procesoventas" class="form-label">Linea</label>
                                <input type="text" class="form-control" id="linea_procesoventas" name="linea">
                            </div>
                            <div class="mb-3">
                                <label for="plazo_max_procesoventas" class="form-label">Plazo</label>
                                <select class="form-select" id="plazo_max_procesoventas" name="plazo">
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
                                <label for="tipo_producto_procesoventas" class="form-label">Producto</label>
                                <select class="form-select" id="tipo_producto_procesoventas" name="tipo_producto">
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