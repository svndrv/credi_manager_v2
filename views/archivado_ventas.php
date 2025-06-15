<main class="content-pages content px-5 py-4">
    <section class="container-fluid">
        <article class="card shadow bg-body-tertiary">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    Tabla de Ventas Archivadas
                </h5>
            </div>
            <div class="card-body p-4">
                <div class="row">
                    <div class="col-lg-2 mb-4">
                        <form id="form_filtro_archivadoventas">
                            <input type="text" class="form-control" id="pv_dni" name="dni" placeholder="Ingrese un DNI">
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
                        </div>
                    </div>
                    <div class="col-lg-12 pt-3">
                        <div class="table-responsive border-4">
                            <table class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Nombres</th>
                                        <th scope="col">Dni</th>
                                        <th scope="col">Motivo</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Acción</th>
                                    </tr>
                                </thead>
                                <tbody id="listar_archivadoventas">
                                    <tr>
                                        <td colspan="6" class="text-center">No hay datos...</td>
                                    </tr>
                                </tbody>

                            </table>
                            <nav aria-label="Navegación de páginas">
                                <ul id="paginacion_aventas" class="pagination justify-content-center">
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


<div class="modal fade" id="obtener-venta-archivada" tabindex="-1" aria-labelledby="obtener-venta-archivadaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <img src="img/logotipo/logotipo-mini.png" class="logo-table-mini me-2">
                <h1 class="modal-title fs-5" id="obtener-venta-archivadaLabel">Ver Venta Archivada</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formObtenerVentaArchivada" enctype="multipart/form-data">
                    <input type="text" name="option" value="desarchivar_venta">
                    <input type="text" name="id_archivado" id="id_archivado_ventas">
                    <input type="text" name="id_proceso" id="id_procesoventas_archivado_ventas">
                    <div class="row p-2">
                        <p class="h5 fw-bold pb-3">Resumen de venta archivada</p>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="nombres_archivado" class="form-label fw-bold">Nombre completo</label>
                                <p id="view-nombres-archivado"></p>
                            </div>
                            <div class="mb-3">
                                <label for="dni_archivado" class="form-label fw-bold">Dni</label>
                                <p id="view-dni-archivado"></p>
                            </div>
                            <div class="mb-3">
                                <label for="celular_archivado" class="form-label fw-bold">Celular</label>
                                <p id="view-celular-archivado"></p>
                            </div>

                            <div class="mb-3">
                                <label for="tem_archivado" class="form-label fw-bold">TEM</label>
                                <p id="view-tem-archivado"></p>
                            </div>
                            <div class="mb-3">
                                <label for="documento" class="form-label fw-bold d-block">Documento</label>
                                <img src="img/add-pv/img_pdf.jpg" class="logo-table-mini me-2"><a href="#" id="verArchivado" style="display: none;">Ver solicitud</a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="credito_archivado" class="form-label fw-bold">Crédito</label>
                                <p id="view-credito-archivado"></p>
                            </div>
                            <div class="mb-3">
                                <label for="linea_archivado" class="form-label fw-bold">Linea</label>
                                <p id="view-linea-archivado"></p>
                            </div>
                            <div class="mb-3">
                                <label for="plazo_archivado" class="form-label fw-bold">Plazo</label>
                                <p id="view-plazo-archivado"></p>
                            </div>
                            <div class="mb-3">
                                <label for="tipoproducto_archivado" class="form-label fw-bold">Producto</label>
                                <p id="view-tipoproducto-archivado"></p>
                            </div>
                            <div class="mb-3">
                                <label for="estado_archivado" class="form-label fw-bold">Estado</label>
                                <p id="view-estado-archivado"></p>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <label for="descripcion_archivar" class="form-label fw-bold">Motivo</label>
                                <textarea class="form-control" id="view-descripcion-archivado" rows="4" style="resize: none;" readonly></textarea>
                            </div>
                        </div>

                    </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Desarchivar</button>
            </div>
            </form>
        </div>
    </div>
</div>