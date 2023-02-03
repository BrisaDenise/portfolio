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

//En el caso de que no haya nadie logeado, mostramos la pagina de REGISTRO
else
{

?>


<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<title>Registrarse | Almas sonoras</title>

<?php
 	include("header.php");
?>

</head>
<body>



<?php

	//Al cargar todo los datos y presionar para registrarte
	if(isset($_POST['enviar']))
	{

		//Cargamos en variables el nombre ingresado, la contraseña y el email
		$nombre = $_POST['usuario_nombre'];
		$contrasena = $_POST['usuario_contrasena'];
		$email = $_POST['usuario_email'];

		//Realizamos una consulta donde pedimos los nombre de usuarios ya registrados que tengas el mismo nombre ingresado
		$sql_n = "SELECT Nombre FROM usuarios WHERE Nombre='".$nombre."'";
		$resultado_n = $conexion->query($sql_n);


		//Realizamos una consulta donde pedimos los emails de usuarios ya registrados que tengas el mismo email ingresado
		$sql_e = "SELECT Email FROM usuarios WHERE Email='".$email."'";
		$resultado_e = $conexion->query($sql_e);


		//Primero comparamos las contraseñas. Si no son iguales, damos aviso de este error
		if ($_POST['usuario_contrasena']  != $_POST['usuario_contrasena_conf']) 
		{

			?>

			<div class="container-login100">
				<p>Las contraseñas ingresadas no coinciden. </p><br>
				<p><a href= 'javascript:history.back();'> <strong>Reintentar</strong></a></p>
			</div>

			<?php
		}

		//Si no, verificamos que el formato del mail sea el correcto. Si no lo es, damos aviso
		else if (!filter_var($_POST["usuario_email"], FILTER_VALIDATE_EMAIL))
		{
			?>

			<div class="container-login100">
				<p>El Email ingresado no posee el formato correcto. </p><br>
				<p><a href= 'javascript:history.back();'> <strong>Reintentar</strong></a></p>
			</div>

			<?php
		}


		//Si no, vemos si la consulta de nombre iguales sacó resultados. En caso afirmativo, avisamos que alguien ya tiene ese nombre
		else if($resultado_n->num_rows > 0)
		{
			?>

			<div class="container-login100">
				<p>El nombre de usuario elegido ya ha sido registrado. </p><br>
				<p><a href= 'javascript:history.back();'> <strong>Reintentar</strong></a></p>
			</div>

			<?php
		}


		//Si no, vemos si la consulta de emails iguales sacó resultados. En caso afirmativo, avisamos que alguien ya tiene ese email
		else if ($resultado_e->num_rows > 0)
		{
			?>

			<div class="container-login100">
				<p>El email ingresado ya ha sido registrado. </p><br>
				<p><a href= 'javascript:history.back();'> <strong>Reintentar</strong></a></p>
			</div>

			<?php
		}


		//Y en el caso que ninguno de los anteriores condicionales se cumplan...
		else
		{

			//Codificamos la contraseña
			$contrasena = md5($contrasena);
			
			//Insertamos la información dada por el nuevo usuario a una nueva fila en la DB
			$registrar = "INSERT INTO usuarios (Nombre, Clave, Email, Registro) VALUES ('".$nombre."','".$contrasena."','".$email."',NOW())";

			//Si todo fue exitoso, damos aviso y le permitimos dirigirse a logears
			if($conexion->query($registrar) === TRUE)
			{
				?>

				<div class="container-login100">
					<p>Datos ingresados correctamente. Ya puedes acceder: </p><br>
					<p><a href= 'acceso.php'><strong>INICIAR SESIÓN</strong></a></p>
				</div>

				<?php
			}

			//Si no, comunicamos la presencia de un error
			else
			{

				?>

				<div class="container-login100">
					<p>Ha ocurrido un error y no se registraron los datos. Por favor, reintente nuevamente.</p><br>
					<p><a href= 'javascript:history.back();'><strong>Reintentar</strong></a></p>
				</div>

				<?php
			}
		}
	}
	

	else
	{

?>

	<div class="limiter">
		<div class="container-login100">

			<div class="titulo"><h1 class="objeto-titulo">ALMAS SONORAS</h1></div>

			<div class="wrap-login100 p-t-50 p-b-40">
				<form class="login100-form validate-form flex-sb flex-w" action="<?=$_SERVER['PHP_SELF']?>" method="post">
					<span class="login100-form-title p-b-20">
						Registrate
					</span>

					
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
						<input class="input100" type="text" name="usuario_nombre" placeholder="Nombre de Usuario" maxlength="15" pattern="[a-zA-Z]+" required>
						<span class="focus-input100"></span>
					</div>
					
					
					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="usuario_contrasena" placeholder="Contraseña" maxlength="15" minlength="8" pattern="[a-zA-Z][a-zA-Z0-9-_/.]+" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Password is required">
						<input class="input100" type="password" name="usuario_contrasena_conf" maxlength="15" minlength="8" pattern="[a-zA-Z][a-zA-Z0-9-_/.]+" placeholder="Confirmar contraseña" required>
						<span class="focus-input100"></span>
					</div>

					<div class="wrap-input100 validate-input m-b-10" data-validate = "Email is required">
						<input class="input100" type="text" type="email" name="usuario_email" placeholder="Email" required>
						<span class="focus-input100"></span>
					</div>


					<div class="container-login100-form-btn m-t-5">
							<input class="login100-form-btn" type="submit" name="enviar" value="Registrarse">
					</div>

				</form>

				<div class="flex-sb-m w-full p-t-3 p-b-24 m-t-10">
					<p>¿Ya estás registrado? <a href="acceso.php">Inicia sesión</a></p>
				</div>

			</div>
		</div>
	</div>

<?php 
    } }
?>

</body>
</html>