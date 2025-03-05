<?php
require_once "modelos/categorias.modelo.php";

class CategoriasHelper {

    public static function mostrarCategorias($item, $valor) {
        $tabla = "categorias";
        return ModeloCategorias::mdlMostrarCategorias($tabla, $item, $valor);
    }
}
?>
