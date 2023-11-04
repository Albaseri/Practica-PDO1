<?php

use App\Db\Producto;

require_once __DIR__ . "/../vendor/autoload.php";
//Si  no existe el cod obtenido por POST, nos lleva a inicio



if (!isset($_POST['codigo'])) {
    header("Location: inicio.php");
    die();
}

session_start();

// Recogemos el código
$codigo = (int) $_POST['codigo'];
Producto::delete($codigo);

$_SESSION['mensajeExito'] = "El producto se ha eliminado correctamente.";
header("Location:inicio.php");
