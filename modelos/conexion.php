<?php

class Conexion{

	static public function conectar(){

		$link = new PDO("mysql:host=localhost;dbname=inventario_wsl",
			            "wsl_bd_inventory",
			            "y8M6Rw3W5L&2JbHxj#S^Lc");

		$link->exec("set names utf8");

		return $link;

	}

}