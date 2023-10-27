<?php

use App\Db\Usuario;

session_start();
require __DIR__ . "/../vendor/autoload.php";
if (!isset($_POST['id'])) {
    header("Location:inicio.php");
    die();
}
$id = $_POST['id'];
(new Usuario)->setId($id)->delete();
$_SESSION['mensaje'] = "Usuario borrado con éxito";
header("Location:inicio.php");
