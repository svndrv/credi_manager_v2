<div class="floating-container">
    <div class="floating-button"><i class="fa-solid fa-plus"></i></div>
    <div class="element-container">
        <span class="float-element">
            <i class="fa-brands fa-whatsapp" style="color: #ffffff;"></i>
        </span>
        <span class="float-element">
            <a type="button" data-bs-toggle="modal" data-bs-target="#contactanos"><i class="fa-solid fa-envelope" style="color: #ffffff;"></i></a>
        </span>
        <span class="float-element">
            <a target="_blank" href="https://www.facebook.com/talentohumanobgof/"><i class="fa-brands fa-facebook" style="color: #ffffff;"></i></a>
        </span>
    </div>
</div>

<div class="modal fade" id="contactanos" tabindex="-1" aria-labelledby="contactanosLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="contactanosLabel">Contáctanos</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <section class="container">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- A (Email) -->
                            <input type="hidden" name="to" id="to" value="burogroup.cs@gmail.com">
                            <div class="input-group mb-2">
                                <input type="text" name="sendername" id="sendername" class="form-control form-control-lg bg-light fs-6" placeholder="Ingrese su nombre">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-user" style="color: #474747;"></i>
                                </span>
                            </div>
                            <div id="sendername-alert"></div>
                            
                            <div class="input-group mb-2">
                                <input type="text" name="subject" id="subject" class="form-control form-control-lg bg-light fs-6" placeholder="Ingresa el asunto">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-paper-plane" style="color: #474747;"></i>
                                </span>
                            </div>
                            <div id="subject-alert"></div>
                            
                            <!-- Responder a (Email) -->
                            <input type="hidden" name="replyto" id="replyto" value="noreply@gmail.com">
                            <div class="input-group mb-2">
                                <textarea class="form-control" name="message" id="message" rows="3" placeholder="Ingrese la forma de contactarse con usted y su consulta."></textarea>
                            </div>
                            <div id="message-alert"></div>
                        </div>
                    </div>
                </section>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" onclick="sendMail();">Enviar</button>
            </div>
        </div>
    </div>
</div>


