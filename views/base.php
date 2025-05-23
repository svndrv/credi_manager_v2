<main class="content-pages content px-5 py-4">
    <section class="container-fluid mt-3">
        <article class="card shadow bg-body-tertiar">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    <?php if ($_SESSION['rol'] != '2') { ?>Gestionar <?php } else { ?>Lista Base <?php } ?>
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-3 mb-4">
                        <form id="form_filtro_base">
                            <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese un DNI">
                    </div>
                    <div class="col-lg-2 mb-3">
                        <button type="submit" class="btn btn-dark w-25"><i class="fa-solid fa-magnifying-glass me-2"></i></button>
                        </form>
                    </div>

                    <?php if ($_SESSION['rol'] === '2' || $_SESSION['rol'] === '1') { ?>

                        <div class="col-lg-7 mb-3">
                            <form id="uploadForm" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <input type="file" name="file" id="file" accept=".xlsx" class="form-control">
                                    </div>
                                    <div class="col-lg-4">
                                        <button type="submit" value="Upload" class="btn btn-success"><i class="fa-solid fa-file-import me-2"></i>Importar Excel</button>
                                    </div>
                                </div>

                            </form>

                        </div>


                    <?php }  ?>

                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Dni</th>
                                        <th scope="col">Tipo de Cliente</th>
                                        <th scope="col">Dirección</th>
                                        <th scope="col">Distrito</th>
                                        <th scope="col">Credito Max</th>
                                        <th scope="col">Linea Max</th>
                                        <th scope="col">Plazo</th>
                                        <th scope="col">TEM</th>
                                        <th scope="col">Celular 1</th>
                                        <th scope="col">Celular 2</th>
                                        <th scope="col">Celular 3</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Combo</th>
                                        <?php if ($_SESSION['rol'] != 2) { ?><th scope="col">Acción</th><?php }?>
                                        
                                    </tr>
                                </thead>
                                <tbody id="listar_base">
                                    <tr>
                                        <td colspan="14" class="text-center">No hay datos...</td>
                                    </tr>
                                </tbody>
                            </table>
                            <nav aria-label="Navegación de páginas">
                                <ul id="paginacion" class="pagination justify-content-center">
                                    <!-- Aquí se agregarán dinámicamente los enlaces de paginación -->
                                </ul>
                            </nav>
                        </div>
                    </div>

                    <?php if ($_SESSION['rol'] === '2' || $_SESSION['rol'] === '1') { ?>

                        <div class="col-lg-12 mb-3 d-flex justify-content-start mt-4">
                            <button type="button" id="btn-borrar-base" class="btn btn-danger"><i class="fa-solid fa-trash me-2"></i>Borrar base</button>
                        </div>

                    <?php } ?>
                </div>
            </div>
        </article>
    </section>
</main>

<div class="modal fade" id="obtener-base" tabindex="-1" aria-labelledby="obtener-baseModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obtener-baseLabel">Transladar a Ventas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerBase">
                    <input type="hidden" name="opcion" value="base_x_id">
                    <input type="hidden" name="option" value="agregar_ventas">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <input type="hidden" id="estado" name="estado" value="Pendiente">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="nombres" name="nombres">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">Dni:</label>
                                <input type="text" class="form-control" id="dni2" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular_1" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="celular_1" name="celular">
                            </div>

                            <div class="mb-3">
                                <label for="tem" class="form-label">TEM:</label>
                                <input type="text" class="form-control" id="tem" name="tem">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_max" class="form-label">Credito:</label>
                                <input type="text" class="form-control" id="credito_max" name="credito">
                            </div>
                            <div class="mb-3">
                                <label for="linea" class="form-label">Linea:</label>
                                <input type="text" class="form-control" id="linea" name="linea">
                            </div>
                            <div class="mb-3">
                                <label for="plazo_max" class="form-label">Plazo:</label>
                                <select class="form-select" name="plazo" id="plazo_max">
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
                <button type="submit" class="btn btn-primary">Transladar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="obtener-cartera_base" tabindex="-1" aria-labelledby="obtener-carteraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obtener-carteraModalLabel">Trasladar Cartera</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarCartera">
                    <input type="hidden" name="option" value="agregar_cartera">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="tras_nombres" name="nombres">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="tras_dni" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="tras_celular" name="celular">
                            </div>                          
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Trasladar</button>
            </div>
            </form>
        </div>
    </div>
</div>