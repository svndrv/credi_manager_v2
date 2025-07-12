<main class="content-pages content px-5 py-5">
    
    <section class="container-fluid">
        <article class="card shadow bg-body-tertiary">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    Mis Ventas Desembolsadas
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 mb-4">
                        <form id="form_filtro_misventas">                            
                            <input type="text" class="form-control" id="mv_id" name="id" placeholder="Ingrese un ID">
                    </div>
                    <div class="col-lg-2 mb-4">
                            <input type="text" class="form-control" id="mv_dni" name="dni" placeholder="Ingrese un DNI">
                    </div>
                    <div class="col-lg-2 mb-4">
                        <select class="form-select" id="mv_tipo_producto" name="tipo_producto">
                            <option value="0">Producto</option>
                            <option value="LD">LD</option>
                            <option value="TC">TC</option>
                            <option value="LD/TC">LD/TC</option>
                        </select>
                    </div>
                    <div class="col-lg-2 mb-4">
                        <input type="date" class="form-control" id="mv_createdat" name="created_at" value="">
                    </div>
                    <div class="col-lg-2 mb-3">
                        <button type="submit" class="btn btn-dark w-25"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </form>
                    </div>
                    <div class="col-lg-12">
                        <div class="table-responsive border-4">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr class="text-center">
                                        <th scope="col">ID</th>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Dni</th>
                                        <th scope="col">Celular</th>
                                        <th scope="col">Credito</th>
                                        <th scope="col">Linea</th>
                                        <th scope="col">Plazo</th>
                                        <th scope="col">TEM</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Documento</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listar_misventas">
                                    <tr>
                                        <td colspan="12" class="text-center">No hay datos...</td>
                                    </tr>
                                </tbody>
                            </table>
                            <nav aria-label="Navegación de páginas">
                                <ul id="paginacion_misventas" class="pagination justify-content-center">
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



<div class="modal fade" id="obtener-ventas" tabindex="-1" aria-labelledby="obtener-ventasModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="obtener-baseLabel">Editar Ventas</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerVentas">
                    <input type="hidden" name="option" value="actualizar_ventas">
                    <input type="hidden" name="id" id="id2">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres" class="form-label">Nombres:</label>
                                <input type="text" class="form-control" id="nombres2" name="nombres">
                            </div>
                            <div class="mb-3">
                                <label for="dni" class="form-label">Dni:</label>
                                <input type="text" class="form-control" id="dni3" name="dni">
                            </div>
                            <div class="mb-3">
                                <label for="celular" class="form-label">Celular:</label>
                                <input type="text" class="form-control" id="celular3" name="celular">
                            </div>

                            <div class="mb-3">
                                <label for="tem" class="form-label">TEM:</label>
                                <input type="text" class="form-control" id="tem2" name="tem">
                            </div>
                            <div class="mb-3">
                                <label for="id_usuario" class="form-label">Usuario:</label>
                                <input type="text" class="form-control" id="nombre_completo" name="nombre_completo" disabled>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_max" class="form-label">Credito:</label>
                                <input type="text" class="form-control" id="credito2" name="credito">
                            </div>
                            <div class="mb-3">
                                <label for="linea" class="form-label">Linea:</label>
                                <input type="text" class="form-control" id="linea2" name="linea">
                            </div>
                            <div class="mb-3">
                                <label for="plazo_max" class="form-label">Plazo:</label>
                                <select class="form-select" name="plazo" id="plazo2">
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
                                <select class="form-select" name="tipo_producto" id="tipo_producto2">
                                    <option value="0">Producto</option>
                                    <option value="LD">LD</option>
                                    <option value="TC">TC</option>
                                    <option value="LD/TC">LD/TC</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <input type="text" class="form-control" id="estado2" name="estado">
                            </div>
                        </div>
                    </div>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Editar</button>
            </div>
            </form>
        </div>
    </div>
</div>