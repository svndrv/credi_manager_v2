<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location:index.php");
};
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrapcss/bootstrap.css">
    <link rel="stylesheet" href="css/dashboard.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    <title>CREDIMANAGER | Buró Group</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link rel="icon" href="img/icon-logo-2.ico">
</head>

<body>
    <div class="wrapper">
        <?php $view = $_GET['view']; ?>
        <!-- ASIDE -->
        <?php require "includes/sidebar-left.php" ?>
        <div class="main">
            <!-- NAVEGADOR -->
            <?php require "includes/navbardb.php" ?>
            <!-- HEADER -->
            <?php require "includes/header.php" ?>
            <!-- VIEWS -->
            <?php
            switch ($view) {
                case "gestionar":
                    require './views/base.php';
                    break;
                case "usuarios":
                    require './views/usuarios.php';
                    break;
                case "consultas":
                    require './views/consultas.php';
                    break;
                case "metas":
                    require './views/metas.php';
                    break;
                case "cartera":
                    require './views/cartera.php';
                    break;
                case "ventas":
                    require './views/ventas.php';
                    break;
                case "metasfv":
                    require './views/metasfv.php';
                    break;
                default:
                    require './views/inicio.php';
                    break;
            }
            ?>
            <!-- FOOTER -->
            <?php require "includes/footerdb.php" ?>
        </div>
        <!-- <a href="#" class="theme-toggle">
            <i class="fa-regular fa-moon"></i>
            <i class="fa-regular fa-sun"></i>
        </a> -->
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
<!-- DATATABLE -->
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<!-- JS -->
<script src="js/dashboard.js"></script>
<script src="js/app.js"></script>

</html>