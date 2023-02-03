<?php

//Iniciamos la sesión e incluimos el acceso a la base de datos
session_start();
include('accesoDB.php');

//Si la sesión no está vacía, es decir, hay alguien logeado
if(!empty($_SESSION['usuario_nombre']))
{
	//Lo redirigimos a la página principal 
    header("Location: index.php");
    die();
}

//En el caso de que no haya nadie logeado, mostramos la pagina de INICIO DE SESIÓN
else
{

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>Ingresar | Almas sonoras</title>
	<meta charset="UTF-8">
	
<?php
include("header.php");
?>

</head>
<body >


<?php


//Una vez que se envíe el formulario de inicio de sesión
//Y se presione el submit 'Enviar'...
if(isset($_POST['enviar']))
	{

			//Guardamos el nombre ingresado y la contraseña
			$nombre = $_POST['usuario_nombre'];
			$contrasena = $_POST['usuario_contrasena'];

			//Codificamos la contraseña para poder compararla a la guardada, ya que se guardan codificadas
			$contrasena = md5($contrasena);

			//Hacemos una consulta a la base de datos pidiendole que nos devuelva el usuario que tenga ese nombre y contraseña
			$sql = "SELECT Id, Nombre, Clave, Email FROM usuarios WHERE Nombre = '".$nombre."' AND Clave = '".$contrasena."'";
			$resultado = $conexion->query($sql);

			//Si la consulta lanza resultado
			if ($resultado->num_rows > 0)
			{	
				//Y mientras recorramos la fila del usuario
				while ($row = $resultado->fetch_assoc()) 
				{
					//Guardaremos su nombre y id, y lo rediccionaremos a la página principal
					$_SESSION['Id'] = $row['Id'];
					$_SESSION['usuario_nombre'] = $row['Nombre'];
					header("Location: index.php");
					die();
				}

			}

	}



//En el caso de que la sesión siga vacio mostraremos el formulario de ingreso
if(empty($_SESSION['usuario_nombre']))
{

?>
	<div class="limiter">
		<div class="container-login100">

			<div class="titulo"><h1 class="objeto-titulo">ALMAS SONORAS</h1></div>

			<div class="wrap-login100 p-t-50 p-b-60">



				<form class="login100-form validate-form flex-sb flex-w" action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<span class="login100-form-title p-b-20">
						Iniciar sesión
					</span>

					
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="usuario_nombre" placeholder="Usuario" required>
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="usuario_contrasena" placeholder="Contraseña" required>
						<span class="focus-input100"></span>
					</div>

					<div class="container-login100-form-btn m-t-5">
							<input class="login100-form-btn" type="submit" name="enviar" value="Ingresar">
					</div>

				</form>

				<div class="flex-sb-m w-full p-t-3 p-b-10 m-t-10">
					<p>¿No estás registrado aún? <a href="registro.php">Registrate</a></p>
				</div>
<?php


	}


	if(isset($_POST['enviar']))
	{
		//Si no existen resultados coicidentes
		if (!$resultado->num_rows > 0)
		{
			//Alertamos al usuario de ello con un texto

			?>
				<div class="flex-sb-m w-full p-t-3 p-b-24 m-t-5 ">
                   	 <p class="alerta-invalido "> El usuario o la contraseña ingresada no son correctas.</p>
                </div>

            <?php
		}
	}
?>

			</div>
		</div>
	</div>

</body>
</html>

<?php
}
?>