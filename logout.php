<?php
session_start();
require_once("config/conexion.php");
session_destroy();
header("Location:./");
exit();