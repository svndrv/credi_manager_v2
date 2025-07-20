<main class="content-pages content px-5 pt-4" style="background-color: #fcfaf3;">
    <section class="container-fluid mt-3">
        <?php if ($_SESSION['rol'] !== '2') { ?>
            <article class="row">
            <div class="col-lg-12 mt-3">
                <div class="row">
                    <div class="col-lg-4 col-sm-12">
                        <div id="bg-card-ld" class="card shadow w-100" style="width: 20rem;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 d-flex justify-content-center">
                                        <img src="img/money.png" style="width: 4rem;" />
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 id="ldc-card-tittle" class="card-title">LD</h5>
                                        <h6 class="card-subtitle mb-2 text-body-secondary">Prestamo Personal</h6>
                                        <div id="ld_cantidad_text_id">
                                            <p class="card-text">Cant. 0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div id="bg-card-tc" class="card shadow w-100" style="width: 20rem;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 d-flex justify-content-center">
                                        <img src="img/card.png" style="width: 4rem;" />
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 id="tcc-card-tittle" class="card-title">TC</h5>
                                        <h6 class="card-subtitle mb-2 text-body-secondary">Tarjeta de crédito</h6>
                                        <div id="tc_cantidad_text_id">
                                            <p class="card-text">Cant. 0 </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-12">
                        <div id="bg-card-ldm" class="card shadow w-100" style="width: 20rem;">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4 d-flex justify-content-center">
                                        <img src="img/bag-coin.png" style="width: 4rem;" />
                                    </div>
                                    <div class="col-lg-8">
                                        <h5 id="ldm-card-tittle" class="card-title">Monto de LD</h5>
                                        <h6 class="card-subtitle mb-2 text-body-secondary">Total de Crédito</h6>
                                        <div id="ld_monto_text_id">
                                            <p class="card-text">S/. 0.0</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
        <?php }  ?>
        
        <article class="row">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-9">
                        <div class="card shadow bg-body-tertiar">
                            <div class="card-header card-style-custom">
                                <h5 class="card-title fw-bold p-1">
                                    Meta mensual de Fuerza de Ventas
                                </h5>
                            </div>
                            <div class="card-body p-4">

                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="text-center">
                                            <tr>
                                                <th scope="col">Usuario</th>
                                                <th scope="col">LD Cantidad</th>
                                                <th scope="col">LD Monto</th>
                                                <th scope="col">TC Cantidad</th>
                                                <th scope="col">Cumplido</th>
                                            </tr>
                                        </thead>
                                        <tbody id="listar_metas_venta">
                                            <tr>
                                                <td colspan="8" class="text-center">No hay datos</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="col-lg-3">
                        <div class="card shadow bg-body-tertiar w-100">
                            <div class="card-body py-4">
                                <div class="align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 fw-bold">
                                        Bono diario
                                        </h4>
                                        <p class="mb-3" name="descripcion" id="bono-descripcion">
                                            <span>se han encontrado bonos diarios el dia de hoy.</span>
                                        </p>
                                        <span class="mb-3 d-block" name="estado" id="bono-estado">
                                            <i class="fa-regular fa-circle-check me-2" style="color: #39c988"></i>
                                            No found
                                        </span>
                                        <div class="getbono">
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card shadow bg-body-tertiar w-100">
                            <div class="card-body py-4">
                                <div class="align-items-start">
                                    <div class="flex-grow-1">
                                        <h4 class="mb-2 fw-bold mb-3">
                                            Meta mensual
                                        </h4>
                                        <div id="bg-card-ld" class="card shadow w-100" style="width: 20rem;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h6 id="ldc-card-tittle" class="card-title d-inline me-3 bg-white rounded-circle p-1">LD</h6><div class="d-inline" id="ld_meta"><span>50 préstamos</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="bg-card-tc" class="card shadow w-100" style="width: 20rem;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h6 id="tcc-card-tittle" class="card-title d-inline me-3 bg-white rounded-circle p-1">TC</h6><div class="d-inline" id="tc_meta"><span>50 préstamos</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="bg-card-ldm" class="card shadow w-100" style="width: 20rem;">
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-lg-12">
                                                        <h6 id="ldm-card-tittle" class="card-title d-inline me-3 bg-white rounded-circle p-1">MT</h6><div class="d-inline" id="monto_meta"><span>50 préstamos</span></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </article>
    </section>

</main>

<!-- Modal -->
<div class="modal fade" id="gestion-bono" tabindex="-1" aria-labelledby="gestion-bonoLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="gestion-bonoLabel">Bono</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formActualizarBono">
                <input type="hidden" name="option" value="actualizar_bono">
                <input type="hidden" name="id" id="bono-id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" id="descripcion_bono" name="descripcion" rows="3"></textarea>
                    </div>
                    <div class="mb-3">

                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estado" id="bono-estado-1" value="Disponible" checked>
                            <label class="form-check-label" for="bono-estado-1">
                                Disponible
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="estado" id="bono-estado-2" value="Finalizado">
                            <label class="form-check-label" for="bono-estado-2">
                                Finalizado
                            </label>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-danger">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>