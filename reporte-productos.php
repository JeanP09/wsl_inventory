<?php
require_once "controladores/productos.controlador.php";
require_once "modelos/productos.modelo.php";

if (isset($_GET["tipo"])) {
  $tipo = $_GET["tipo"];
  ControladorProductos::ctrDescargarReporte($tipo);
}
?>
