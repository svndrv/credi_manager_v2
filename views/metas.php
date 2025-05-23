<main class="content-pages content px-5 py-4">
    <div class="container-fluid mt-3">
        <div class="card shadow bg-body-tertiar">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    Metas
                </h5>
            </div>
            <div class="card-body p-4">
                <form id="form_filtro_meta">
                    <div class="row">
                        <div class="col-lg-3">

                            <select class="form-select mb-4" aria-label="Default select example" id="id_usuario_f" name="id_usuario_f">
                                <option value=0>Seleccionar Usuario</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <select class="form-select" aria-label="Default select example" name="mes_f" id="mes_f">
                                <option value="0">Selecciona el mes</option>
                                <option value="1">Enero</option>
                                <option value="2">Febrero</option>
                                <option value="3">Marzo</option>
                                <option value="4">Abril</option>
                                <option value="5">Mayo</option>
                                <option value="6">Junio</option>
                                <option value="7">Julio</option>
                                <option value="8">Agosto</option>
                                <option value="9">Septiembre</option>
                                <option value="10">Octubre</option>
                                <option value="11">Noviembre</option>
                                <option value="12">Diciembre</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <select class="form-select mb-4" aria-label="Default select example" id="cumplido_f" name="cumplido_f">
                                <option value="0">Seleccionar Cumplido</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Si">Si</option>
                                <option value="No">No</option>
                            </select>

                        </div>

                        <div class="col-lg-1">
                            <button type="submit" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </div>
                </form>
                <div class="col-lg-2 d-flex justify-content-end mb-4">
                    <button type="button" class="btn btn-warning px-3 text-white" data-bs-toggle="modal" data-bs-target="#agregar-meta">
                        <i class="fa-solid fa-user-plus me-2"></i> Agregar
                    </button>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">LD Cantidad</th>
                            <th scope="col">LD Monto</th>
                            <th scope="col">TC Cantidad</th>
                            <th scope="col">Usuario</th>
                            <th scope="col">Mes</th>
                            <th scope="col">Cumplido</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="listar_metas">
                        <tr>
                            <td colspan="8" class="text-center">No hay datos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>

<!-- Modal -->
<div class="modal fade" id="editar-metas" tabindex="-1" aria-labelledby="editar-metaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editar-metaModalLabel">Actualizar Meta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formActualizarMeta">
                    <input type="hidden" name="option" value="actualizar_meta">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="ld_cantidad" class="form-label">LD Cantidad:</label>
                                <input type="number" class="form-control" id="modal_ld_cantidad" name="ld_cantidad">
                            </div>
                            <div class="mb-3">
                                <label for="tc_cantidad" class="form-label">TC Cantidad:</label>
                                <input type="number" class="form-control" id="modal_tc_cantidad" name="tc_cantidad">
                            </div>
                            <div class="mb-3">
                                <label for="ld_monto" class="form-label">LD Monto:</label>
                                <input type="number" class="form-control" id="modal_ld_monto" name="ld_monto">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="id_usuario" class="form-label">Usuario:</label>
                                <select class="form-select" name="id_usuario" id="modal_id_usuario">

                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="mes" class="form-label">Mes:</label>
                                <select class="form-select" name="mes" id="modal_mes">
                                    <option value="0">Seleccionar mes</option>
                                    <option value="1">Enero</option>
                                    <option value="2">Febrero</option>
                                    <option value="3">Marzo</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Mayo</option>
                                    <option value="6">Junio</option>
                                    <option value="7">Julio</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Septiembre</option>
                                    <option value="10">Octubre</option>
                                    <option value="11">Noviembre</option>
                                    <option value="12">Diciembre</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="cumplido" class="form-label">Cumplido:</label>
                                <select class="form-select" name="cumplido" id="modal_cumplido">
                                    <option value="0">Seleccionar estado</option>
                                    <option value="Si">Si</option>
                                    <option value="No">No</option>
                                    <option value="Pendiente">Pendiente</option>
                                </select>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<div class="modal fade" id="agregar-meta" tabindex="-1" aria-labelledby="agregar-metaModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="agregar-metaLabel">Agregar Meta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarMeta">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="option" value="agregar_meta">
                                    <input type="hidden" name="id" id="id">
                                    <div class="mb-3">
                                        <label for="ld_cantidad" class="form-label">LD Cantidad:</label>
                                        <input type="number" class="form-control" id="ld_cantidad" name="ld_cantidad">
                                    </div>
                                    <div class="mb-3">
                                        <label for="ld_monto" class="form-label">LD Monto:</label>
                                        <input type="number" class="form-control" id="ld_monto" name="ld_monto">
                                    </div>
                                    <div class="mb-3">
                                        <label for="tc_cantidad" class="form-label">TC Cantidad:</label>
                                        <input type="number" class="form-control" id="tc_cantidad" name="tc_cantidad">
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="id_usuario" class="form-label">Usuario:</label>
                                        <select class="form-select" name="id_usuario" id="id_usuario2">
                                            <option value="0">Selecciona usuario</option>
                                            <!-- Opciones de usuarios se llenarán dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mes" class="form-label">Mes:</label>
                                        <select class="form-select" name="mes" id="mes">
                                            <option value="0">Seleccionar mes</option>
                                            <option value="1">Enero</option>
                                            <option value="2">Febrero</option>
                                            <option value="3">Marzo</option>
                                            <option value="4">Abril</option>
                                            <option value="5">Mayo</option>
                                            <option value="6">Junio</option>
                                            <option value="7">Julio</option>
                                            <option value="8">Agosto</option>
                                            <option value="9">Septiembre</option>
                                            <option value="10">Octubre</option>
                                            <option value="11">Noviembre</option>
                                            <option value="12">Diciembre</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="cumplido" class="form-label">Cumplido:</label>
                                        <select class="form-select" name="cumplido" id="cumplido">
                                            <option value="0">Seleccionar estado</option>
                                            <option value="Si">Si</option>
                                            <option value="No">No</option>
                                            <option value="Pendiente">Pendiente</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-success">Registrar</button>
            </div>
            </form>
        </div>
    </div>
</div>