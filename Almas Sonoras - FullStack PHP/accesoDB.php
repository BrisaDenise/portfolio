<?php

	//Con este php nos conectamos a la base de datos ha utilizar en la pag
	//Creamos la variables que guardaran nombre del host, clase, base de datos y de donde es esa base de datos
	$hostDB = "localhost";
	$usuarioDB = "root";
	$claveDB = "";
	$nombreDB = "usuarios_sonoros";

	//Hacemos una consulta para conectarnos a la DB
	$conexion = new mysqli($hostDB, $usuarioDB, $claveDB, $nombreDB);

	//En el caso de que salga un error en la conexión lo comunicaremos
	if ($conexion->connect_error)
	{
		die("Conexión fallida: " . $conexion->connect_error);
	}
?>