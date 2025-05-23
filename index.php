<?php
session_start();

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Buró Group | Prestamos y Tarjetas de Crédito</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.css">
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="img/icolo-burogroup-b-white.ico">


</head>

<body data-bs-spy="scroll" data-bs-target=".navbar">

    <!-- NAVBAR -->
    <?php require "includes/navbar.php" ?>

    <!-- HERO -->
    <section id="hero" class="min-vh-100 d-flex align-items-center text-center">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <h1 data-aos="fade-left" class="text-uppercase text-white fw-semibold display-1">BIENVENIDO A BURÓ</h1>
                    <h5 class="text-white mt-3 mb-4" data-aos="fade-right">EN COLABORACIÓN CON <span id="credi">CREDI</span><span id="scotia">SCOTIA</span> OFRECEMOS SERVICIOS DE ASESORIA FINANCIERA</p>
                    </h5>
                    <div data-aos="fade-up" data-aos-delay="50">
                        <a href="#consultar" class="btn btn-brand me-2">Consulta</a>
                        <a href="#campannas" class="btn btn-light ms-2">Campañas</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <?php require "includes/carrusel.php" ?>

    <!-- SERVICIOS -->
    <section id="servicios" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">SERVICIOS</h1>
                        <div class="line"></div>
                        <p>Contamos con personal capacitado para solucionar todas tus dudas financieras.</p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/ld-cover.jpg" alt="">
                        </div>
                        <h5 class="mt-4">PRESTAMOS PERSONALES</h5>
                        <p>Préstamo personal en efectivo que te permite, mediante el pago de cuotas fijas al mes, utilizarlo para lo que desees.</p>
                        <a href="#">Leer mas</a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/unica-cover.png" alt="">
                        </div>
                        <h5 class="mt-4">TARJETA DE CRÉDITO</h5>
                        <p>Bono de bienvenida HASTA S/ 100 de devolución en tu primer consumo dentro de los 30 primeros días de activada la tarjeta.</p>
                        <a href="#">Leer mas</a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="350">
                    <div class="team-member image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/aseso-cover.png" alt="">
                        </div>
                        <h5 class="mt-4">ASESORIA FINANCIERA</h5>
                        <p>Contactenos y le brindaremos ayuda para resolver cualquier duda acerca del rubro financiero y servicios que ofrecemos.</p>
                        <a href="#">Leer mas</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CONSULTAR -->
    <section class="section-padding bg-light" id="consultar">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 text-white fw-semibold">Realiza tu consulta</h1>
                        <div class="line bg-white"></div>
                        <p class="text-white">*Su consulta será almacenada en nuestros registros para futuras campañas.</p>
                    </div>
                </div>
            </div>
            <div class="row justify-content-center" data-aos="fade-down" data-aos-delay="250">
                <div class="col-lg-8">
                    <form id="form_consulta" class="row g-3 p-lg-5 p-4 bg-white theme-shadow">
                    <input type="hidden" name="option" value="crear_consulta">
                    <input type="hidden" id="campana"  name="campana">
                        <div class="form-group col-lg-6">
                            <div class="input-group">
                                <input type="text" id="dni" name="dni" class="form-control form-control-lg bg-light fs-6" placeholder="Ingresar DNI">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-address-card" style="color: #474747;"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-6">
                            <div class="input-group">
                                <input type="text" id="celular" name="celular" class="form-control form-control-lg bg-light fs-6" placeholder="Ingresar celular">
                                <span class="input-group-text">
                                    <i class="fa-solid fa-mobile-screen" style="color: #474747;"></i>
                                </span>
                            </div>
                        </div>
                        <div class="form-group col-lg-12">
                            <textarea id="descripcion" name="descripcion" rows="5" class="form-control" placeholder="Ingresar consulta (Opcional)"></textarea>
                        </div>
                        <div id="alerta"></div>
                        <div class="form-group col-lg-12 d-grid">
                            <button id="verificar" type="submit" class="btn btn-brand">Consultar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- SERVICES -->
    <section id="campannas" class="section-padding border-top">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">CAMPAÑAS</h1>
                        <div class="line"></div>
                        <p>*Las campañas a solo firma son asignadas mensualmente, según el historial crediticio del cliente.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4 text-center">
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="fa-regular fa-id-card"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Consulta con tu DNI</h5>
                        <p>Realiza tu consulta por cualquiera de nuestros medios con tan solo tu número de dni.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="fa-solid fa-signature"></i>
                        </div>
                        <h5 class="mt-4 mb-3">A solo firma</h5>
                        <p>Retira tu préstamo personal y/o tarjeta de crédito ÚNICA yendo con tan solo tu firma.</p>
                    </div>
                </div>
                <div class="col-lg-4 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <div class="service theme-shadow p-lg-5 p-4">
                        <div class="iconbox">
                            <i class="fa-solid fa-comments-dollar"></i>
                        </div>
                        <h5 class="mt-4 mb-3">Mensaje de texto</h5>
                        <p>Consulta y confirma préstamos personales y/o activaciones de tarjeta ÚNICA con tu celular.</p>
                    </div>
                </div>
                
            </div>
        </div>
    </section>

    <!-- COUNTER -->
    <section id="counter" class="section-padding">
        <div class="container text-center">
            <div class="row g-4">
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="150">
                    <h1 class="text-white display-4">+20</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">AÑOS DE EXPERIENCIA</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="250">
                    <h1 class="text-white display-4">TOP 1</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">SERVICIOS TERCIARIOS</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="350">
                    <h1 class="text-white display-4">+30</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">ALIANZAS ESTRATÉGICAS</h6>
                </div>
                <div class="col-lg-3 col-sm-6" data-aos="fade-down" data-aos-delay="450">
                    <h1 class="text-white display-4">+100</h1>
                    <h6 class="text-uppercase mb-0 text-white mt-3">FUERZA DE VENTAS</h6>
                </div>
            </div>
        </div>
    </section>

    <!-- PORTFOLIO -->
    <section id="beneficios" class="section-padding">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center" data-aos="fade-down" data-aos-delay="150">
                    <div class="section-title">
                        <h1 class="display-4 fw-semibold">BENEFICIOS</h1>
                        <div class="line"></div>
                        <p>Brindamos facilidades para tu desembolso de préstamos personales o activación de tarjetas Única.</p>
                    </div>
                </div>
            </div>
            <div class="row g-4">
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="150">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/guia-img1.png" alt="">
                        </div>
                        <a href="img/inicio/guia-img1.png" data-fancybox="gallery" class="iconbox"><i class="ri-search-2-line"></i></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/guia-img6.jpg" alt="">
                        </div>
                        <a href="img/inicio/guia-img6.jpg" data-fancybox="gallery" class="iconbox"><i class="ri-search-2-line"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="250">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/guia-img5.jpg" alt="">
                        </div>
                        <a href="img/inicio/guia-img5.jpg" data-fancybox="gallery" class="iconbox"><i class="ri-search-2-line"></i></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/guia-img2.png" alt="">
                        </div>
                        <a href="img/inicio/guia-img2.png" data-fancybox="gallery" class="iconbox"><i class="ri-search-2-line"></i></a>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-down" data-aos-delay="350">
                    <div class="portfolio-item image-zoom">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/guia-img3.png" alt="">
                        </div>
                        <a href="img/inicio/guia-img3.png" data-fancybox="gallery" class="iconbox"><i class="ri-search-2-line"></i></a>
                    </div>
                    <div class="portfolio-item image-zoom mt-4">
                        <div class="image-zoom-wrapper">
                            <img src="img/inicio/guia-img4.jpg" alt="">
                        </div>
                        <a href="img/inicio/guia-img4.jpg" data-fancybox="gallery" class="iconbox"><i class="ri-search-2-line"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--  PARTE INFERIOR  -->
    <div class="text-center pt-5">
        <h1>EMPRESAS QUE CONFIAN EN NOSOTROS</h1>
        <p class="text-secondary">Más de 300 empresas confian en nosotros y nuestros rigurosos procesos de selección</p>
    </div>

    <?php require "includes/carrusel.php" ?>
    <?php require "includes/float-iconos.php" ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@4.0/dist/fancybox.umd.js"></script>
    <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
    <script src="./assets/js/main.js"></script>
</body>

<?php require "includes/footer.php" ?>

<!-- AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- FONTAWESOME -->
<script src="https://kit.fontawesome.com/2314719ba4.js" crossorigin="anonymous"></script>
<!-- JS -->
<script src="js/app.js"></script>
<!-- EMAILJS -->
<script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

</html>