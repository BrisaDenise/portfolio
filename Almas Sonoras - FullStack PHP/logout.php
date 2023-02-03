<?php
	

	//Iniciamos la sesión e incluimos el acceso a la base de datos
	session_start();
	include('accesoDB.php');

	//Según el nombre del usuario que inicio sesión
	if(isset($_SESSION['usuario_nombre']))
	{
		//Destruiremos su inicio de sesión y lo enviaremos a la página de LOGIN
		session_destroy();
		header("Location: acceso.php");
	}

	else
	{
		//Si no, comunicaremos el error
		echo "Operación Incorrecta";
	}
?>