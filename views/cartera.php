<main class="content-pages content px-5 py-4">
    <section class="container-fluid mt-3">
        <article class="card shadow bg-body-tertiary">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    Lista de cartera de clientes
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">

                    <div class="col-lg-3 mb-4">
                        <form id="form_filtro_cartera">
                            <input type="text" class="form-control" id="c-dni" name="dni" placeholder="Ingrese un DNI">
                    </div>
                    <div class="col-lg-2 mb-3">
                        <button type="submit" class="btn btn-dark w-25"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                    <div class="col-lg-7 mb-3 text-end">
                        <button type="button" class="btn btn-warning btn-md px-5 text-white" data-bs-toggle="modal" data-bs-target="#agregar-cartera">
                            <i class="fa-solid fa-user-plus me-2"></i>Agregar</button>

                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Dni</th>
                                        <th scope="col">Celular</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listar_cartera">
                                    <tr>
                                        <td colspan="6" class="text-center">No hay datos...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>
</main>


<div class="modal fade" id="editar-cartera" tabindex="-1" aria-labelledby="editar-carteraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editar-carteraModalLabel">Editar Cliente</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formActualizarCartera">
                    <input type="hidden" name="option" value="actualizar_cartera">
                    <input type="hidden" name="id" id="id_car">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <input type="hidden" id="estado" name="estado" value="Pendiente">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="nombres_car" name="nombres" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="dni_car" name="dni" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="celular_car" name="celular" aria-describedby="emailHelp">
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>


<div class="modal fade" id="agregar-cartera" tabindex="-1" aria-labelledby="agregar-carteraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="agregar-carteraModalLabel">Agregar Cartera</h1>
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
                                <input type="text" class="form-control" id="nombres_car" name="nombres" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="dni_car" name="dni" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="celular_car" name="celular" aria-describedby="emailHelp">
                            </div>                          
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="obtener_cartera" tabindex="-1" aria-labelledby="obtener_carteraModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obtener_carteraModalLabel">Transladar a Ventas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerBase">
                    <input type="hidden" name="option" value="agregar_ventas">
                    <input type="hidden" name="id" id="car_id">
                    <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $_SESSION['id'] ?>">
                    <input type="hidden" id="estado" name="estado" value="Pendiente">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="car_nombres" name="nombres" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="car_dni" name="dni" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="car_celular" name="celular" aria-describedby="emailHelp">
                            </div>
                            <div class="mb-3">
                                <label for="tem" class="form-label">TEM:</label>
                                <input type="text" class="form-control" id="car_tem" name="tem" aria-describedby="emailHelp" value="0.00">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_max" class="form-label">Credito:</label>
                                <input type="text" class="form-control" id="car_credito" name="credito" value="0.000">
                            </div>
                            <div class="mb-3">
                                <label for="linea" class="form-label">Linea:</label>
                                <input type="text" class="form-control" id="car_linea" name="linea" value="0.000">
                            </div>
                            <div class="mb-3">
                                <label for="plazo_max" class="form-label">Plazo:</label>
                                <select class="form-select" name="plazo" id="car_plazo">
                                    <option selected value="0">Plazo</option>
                                    <option value="12">12</option>
                                    <option value="24">24</option>
                                    <option value="36">36</option>
                                    <option value="48">48</option>
                                    <option value="72">72</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="tipo_producto" class="form-label">Producto:</label>
                                <select class="form-select" name="tipo_producto" id="car_tipo_producto">
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
                <button type="submit" class="btn btn-primary">Trasladar</button>
            </div>
            </form>
        </div>
    </div>
</div>