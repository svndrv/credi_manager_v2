<main class="content-pages content px-5 py-4">
    <div class="container-fluid mt-3">
        <div class="card shadow bg-body-tertiary">
            <div class="card-header card-style-custom">
                <h5 class="card-title fw-bold p-1">
                    Gestión de Usuarios
                </h5>
            </div>
            <div class="card-body p-4">
                <form id="form_filtro_empleados">
                    <div class="row">
                        <div class="col-lg-3 ">

                            <select class="form-select mb-4" aria-label="Default select example" id="rol" name="rol">
                                <option class="form-select-item" value="0">Seleccionar el rol</option>
                                <option class="form-select-item" value="1">Administrador</option>
                                <option class="form-select-item" value="2">Operador</option>
                                <option class="form-select-item" value="3">Asesor</option>
                            </select>
                        </div>
                        <div class="col-lg-3 ">
                            <select class="form-select mb-4" aria-label="Default select example" id="estado" name="estado">
                                <option class="form-select-item" value="0">Seleccionar el estado</option>
                                <option class="form-select-item" value="1">Activo</option>
                                <option class="form-select-item" value="2">Inactivo</option>
                            </select>
                        </div>


                        <div class="col-lg-2 mb-3">
                            <button type="submit" class="btn btn-dark"><i class="fa-solid fa-magnifying-glass"></i></button>

                        </div>
                </form>
                <div class="col-lg-4 mb-3 text-end">
                    <button type="button" class="btn btn-warning btn-md px-5 text-white" data-bs-toggle="modal" data-bs-target="#agregar-usuario">
                        <i class="fa-solid fa-user-plus me-2"></i>Agregar</button>

                </div>

            </div>


            <div class="table-responsive ">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th scope="col">Usuario</th>
                            <th scope="col">Nombres</th>
                            <th scope="col">Apellidos</th>
                            <th scope="col">Rol</th>
                            <th scope="col">Estado</th>
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="listar_empleados">
                        <tr>
                            <td colspan="8" class="text-center">No hay datos</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>
</main>

<div class="modal fade" id="editar-usuario" tabindex="-1" aria-labelledby="editar-usuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editar-usuarioLabel">Editar Usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formActualizarEmpleado">
                    <input type="hidden" name="opcion" value="actualizar_usuarios">
                    <input type="hidden" name="id" id="id">
                    <div class="row">
                        <div class="col-lg-4 d-flex justify-content-center  mb-3 text-center pt-4">
                            <div class="fotoPerfil2">
                                <img src="./img/user.png" alt="" class='fotoPerfil rounded' style="width: 75%;">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="usuario" class="form-label">Usuario:</label>
                                        <input type="text" class="form-control" id="usuario" name="usuario">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres:</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres">
                                    </div>
                                    <div class="mb-3">
                                        <label for="rol" class="form-label">Rol:</label>
                                        <select class="form-select" name="rol" id="rol2">
                                            <option value="0">Estado de campaña</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Operador</option>
                                            <option value="3">Asesor</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="contrasena" class="form-label">Contraseña:</label>
                                        <input type="text" class="form-control" id="contrasena" name="contrasena" placeholder="Contraseña">
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos:</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos">
                                    </div>
                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado:</label>
                                        <select class="form-select" name="estado" id="estado2">
                                            <option value="0">Estado de campaña</option>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label rol="foto">Foto</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <input class="form-control" type="file" name='foto' id='foto' />
                                                    <input type="hidden" name='archivoFoto' id='archivoFoto2' />
                                                </span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload"><i class='bx bxs-trash'></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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


<div class="modal fade" id="agregar-usuario" tabindex="-1" aria-labelledby="agregar-usuarioModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="agregar-usuarioLabel">Agregar Empleado</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="formAgregarEmpleado">
                    <div class="row">
                        <div class="col-lg-4 d-flex justify-content-center  mb-3 text-center pt-4">
                            <div class="fotoPerfil">
                                <img src="./img/user.png" alt="" class='fotoPerfil rounded' style="width: 75%;">
                            </div>
                        </div>
                        <div class="col-lg-8">
                            <div class="row">
                                <div class="col-lg-6">
                                    <input type="hidden" name="opcion" value="agregar_usuario">
                                    <input type="hidden" name="id" id="id">
                                    <div class="mb-3">
                                        <label for="usuario" class="form-label">Usuario:</label>
                                        <input type="text" class="form-control" id="usuario" name="usuario">
                                    </div>
                                    <div class="mb-3">
                                        <label for="nombres" class="form-label">Nombres:</label>
                                        <input type="text" class="form-control" id="nombres" name="nombres">
                                    </div>
                                    <div class="mb-3">
                                        <label for="estado" class="form-label">Estado:</label>
                                        <select class="form-select" name="estado" id="estado2">
                                            <option value="0">Estado de campaña</option>
                                            <option value="1">Activo</option>
                                            <option value="2">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="mb-3">
                                        <label for="contrasena" class="form-label">Contraseña:</label>
                                        <input type="text" class="form-control" id="contrasena" name="contrasena">
                                    </div>
                                    <div class="mb-3">
                                        <label for="apellidos" class="form-label">Apellidos:</label>
                                        <input type="text" class="form-control" id="apellidos" name="apellidos">
                                    </div>
                                    <div class="mb-3">
                                        <label for="rol" class="form-label">Rol:</label>
                                        <select class="form-select" name="rol" id="rol2">
                                            <option value="0">Estado de campaña</option>
                                            <option value="1">Administrador</option>
                                            <option value="2">Operador</option>
                                            <option value="3">Asesor</option>
                                        </select>
                                    </div>

                                </div>
                                <div class="col-lg-12">
                                    <div class="mb-3">
                                        <label rol="foto">Foto</label>
                                        <div class="fileupload fileupload-new" data-provides="fileupload">
                                            <div class="input-append">
                                                <div class="uneditable-input">
                                                    <span class="fileupload-preview"></span>
                                                </div>
                                                <span class="btn btn-default btn-file">
                                                    <input class="form-control" type="file" name='foto' id='foto' />
                                                    <input type="hidden" name='archivoFoto' id='archivoFoto' />
                                                </span>
                                                <a href="#" class="btn btn-default fileupload-exists" data-dismiss="fileupload"><i class='bx bxs-trash'></i></a>
                                            </div>
                                        </div>
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