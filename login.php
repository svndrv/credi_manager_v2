<?php

session_start();
//echo $_SESSION['usuario']
if (isset($_SESSION['id'])) {
  header("Location:dashboard.php?view=inicio");
};

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/bootstrapcss/bootstrap.css">
  <link rel="stylesheet" href="css/style.css">
  <title>CrediManager | Login</title>
  <link rel="icon" href="img/icolo-burogroup-b-white.ico">
</head>

<body id="body-login">

  <div class="container d-flex justify-content-center align-items-center min-vh-100">
    <div class="row border rounded-5 p-3 bg-white shadow box-area">
      <div class="col-md-6 rounded-4 d-flex justify-content-center align-items-center flex-column left-box" style="background: rgb(0,60,94);">
        <div class="featured-image mb-3">
          <img src="img/logi-login2.png" class="img-fluid" style="width: 250px;">
        </div>
        <p class="text-white fs-2" style="font-weight: bold;">CREDIMANAGER</p>
        <small class="text-white text-wrap text-center" style="width: 17rem;">El ingreso a la plataforma es solo a <br>personal autorizado</small>
      </div>
      <div class="col md-6 right-box">
        <div class="row aligh-items-center">
          <div class="header-text mb-3">
            <h1 class="fw-bold">BURÓ GROUP<i class="fa-solid fa-circle-check fa-xs p-3"></i></h1>
          </div>
          <form id="formLogin">
            <input type="hidden" value="login" name="opcion">
            <div class="input-group mb-2">
              <input type="text" id="usuario" name="usuario" class="form-control form-control-lg bg-light fs-6" placeholder="Ingresar usuario">
              <span class="input-group-text">
                <i class="fa-solid fa-user" style="color: #474747;"></i>
              </span>
            </div>
            <div class="input-group mb-4">
              <input type="password" id="contrasena" name="contrasena" class="form-control form-control-lg bg-light fs-6" placeholder="Ingresar contraseña">
              <span class="input-group-text">
                <i class="fa-solid fa-lock" style="color: #474747;"></i>
              </span>
            </div>
            <div class="input-group mb-2">
              <button type="submit" class="btn btn-lg w-100 fs-6 text-white" style="background-color: #0ed290;">Ingresar</button>
            </div>
          </form>
          <div class="input-group mb-5">
            <a href="index.php" class="btn btn-lg  w-100 fs-6 text-white" style="background-color: #9cbbc4;">Regresar</a>
          </div>
          <small class="text-secondary">
            *Si no recuerdas tu cuenta, comunicate con personal autorizado.
            <!-- <a href="#">Contactarse</a> -->
          </small>

        </div>
      </div>
    </div>
  </div>
</body>

<!-- BOOSTRAP -->
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<!-- AJAX -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<!-- SWEETALERT -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- FONTAWESOME -->
<script src="https://kit.fontawesome.com/2314719ba4.js" crossorigin="anonymous"></script>
<!-- JS -->
<script src="js/login.js"></script>

</html>