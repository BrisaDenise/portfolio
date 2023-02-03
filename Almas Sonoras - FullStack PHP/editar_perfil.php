<?php

//Iniciamos la sesión e incluimos el acceso a la base de datos
session_start();
include('accesoDB.php');

//Si la sesión está vacía, es decir, no hay alguien logeado
if(empty($_SESSION['usuario_nombre']))
{
    //Lo redirigimos a la página de acceso
    header("Location: acceso.php");
    die();
}

//Si el usuario es el Admin
elseif($_SESSION['usuario_nombre'] == 'Admin')
{
    //Lo redirigimos a la página principal
    //Esto es porque pense en que la información del Admin no se pudiera alterar
    header("Location: index.php");
    die();
}

//Y si se cumplen el resto de condicionales, mostramos la página
else
{

?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Administración de perfil | Almas sonoras</title>
        
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

        <?php
        include("header.php");
        ?>

    </head>
    <body>
       
       
        <nav class="navbar navbar-expand-lg navbar-dark bg-black navbar-expand-sm navbar-expand-md fixed-bottom">
            <div class="container px-4 px-lg-5">
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item"><a class="nav-link" href="index.php">Tu melodía</a></li>
                        <li class="nav-item"><a class="nav-link" href="mapa.php">Nuestras melodías</a></li>
                    </ul>
                </div>
            </div>
        </nav>


       
        <section>
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5">
                    <div class="col-lg-12">

                        <div class="dis-flex">
                            <a class="m-t-50" href="index.php"><img src="images/atras.png" alt="atras"></a>

                            <h1 class="m-l-10">Administrar perfil</h1>

                        </div>
                        <hr>

                        <div>


                        <?php

                        //Creamos una variable donde guardamos el nombre del usuario
                        $nombre = $_SESSION['usuario_nombre'];


                        //Si se decide cambiar el nombre de usuario y presiona el botón...
                        if(isset($_POST['act_nombre']))
                        {
                            
                            //Guardamos el nuevo nombre ingresado en una variable
                            $nuevo_nombre = $_POST['nombre_usuario'];

                            //Consultamos a la DB por algún nombre que sea igual al ingresado
                            $sql_corr = "SELECT Nombre FROM usuarios WHERE Nombre='".$nuevo_nombre."'";
                            $resultado_corr = $conexion->query($sql_corr);

                            //En el caso que sí, notificamos al usuario que ese usuario ya existe
                            if($resultado_corr->num_rows > 0)
                            {
                              ?>
                                <div class="alerta-estatica-arriba rojo">
                                    <p>El nombre de usuario elegido ya está registrado.</p>
                                </div>
                             <?php
                            }


                            //Si no se encuentran coincidencias
                            else{

                                //Pedimos a la DB realizar una actualización del nombre del usuario por el nuevo ingresado
                                $registrar_act = "UPDATE usuarios SET Nombre = '".$nuevo_nombre."' WHERE Nombre = '".$nombre."'";

                                //En el caso de que se hay podido realizar, damo la noticia al usuario
                                if($conexion->query($registrar_act) === TRUE)
                                    {

                                        ?>

                                        <div class="alerta-estatica-arriba verde">
                                            <p>¡Nombre actualizado con éxito!</p>
                                        </div>

                                         <?php

                                         //Actualizamos el nombre del usuario en la variable inicial
                                        $_SESSION['usuario_nombre'] = $nuevo_nombre;
                                    }

                                //Sino, alertamos del error
                                else 
                                {
                                    ?>

                                        <div class="alerta-estatica-arriba rojo">
                                            <p>¡Ha ocurrido un ERROR!</p>
                                        </div>

                                    <?php
                                }
                            }
                        }



                        //Si el usuario decide cambiar su contraseña y confirma...
                        else if (isset($_POST['act_contra']))
                        {

                            //Primero verificamos que la nueva contraseña y la verificación, sean iguales
                            //Si nolo son, avisamos sobre esto
                            if ($_POST['nueva_contra']  != $_POST['confir_contra']) 
                            {
                                ?>

                                <div class="alerta-estatica-arriba rojo">
                                    <p>Las contraseñas ingresadas no coinciden.</p>
                                </div>

                             <?php
                            }

                            //Si sí lo son...
                            else{

                                //Codificamos la nueva contraseña
                                $nueva_contra = md5($_POST['nueva_contra']);

                                //Y hacemos una consulta a la DB pidiendo la actualización de la clave del usuario
                                $act_contra = "UPDATE usuarios SET Clave = '".$nueva_contra."' WHERE Nombre = '".$nombre."'";

                                //Si el resultado fue exitoso, avisaremos al usuario
                                if($conexion->query($act_contra) === TRUE)
                                    {
                                        ?>

                                        <div class="alerta-estatica-arriba verde">
                                            <p>¡Contraseña actualizada con éxito!</p>
                                        </div>

                                         <?php
                                    }

                                //Si no, comunicaremos del error
                                else 
                                    {
                                        ?>

                                            <div class="alerta-estatica-arriba rojo">
                                                <p>¡Ha ocurrido un ERROR!</p>
                                            </div>

                                        <?php
                                    }

                            }

                        }


                        //Si el usuario decide cambiar el mail y presiona el botón...
                        else if (isset($_POST['act_email']))
                        {

                            //Guardamos en una variable el nuevo mail ingresado
                            $nuevo_email = $_POST["nuevo_mail"];

                            //Consultamos si el mail ingresado es igual a algún otro usuario
                            $sql_e = "SELECT Email FROM usuarios WHERE Email='".$nuevo_email."'";
                            $resultado_e = $conexion->query($sql_e);

                            //En el caso de que sí lo sea, alertamos al usuario de ello
                            if ($resultado_e->num_rows > 0)
                            {
                                ?>

                                <div class="alerta-estatica-arriba rojo">
                                    <p>El mail ingresado ya ha sido registrado.</p>
                                </div>

                                <?php
                            }

                            //Si no, verificamos que tenga el formato correcto. Si no lo tiene, alertamos
                            else if (!filter_var($_POST["nuevo_mail"], FILTER_VALIDATE_EMAIL))
                            {
                                ?>

                                <div class="alerta-estatica-arriba rojo">
                                    <p>El mail ingresado no tiene el formato correcto.</p>
                                </div>

                                <?php
                            }

                            //Si ningún condicional anterior se cumple...
                            else{

                                //Actualizamos la DB con el nuevo mail del usuario
                                $act_email = "UPDATE usuarios SET Email = '".$nuevo_email."' WHERE Nombre = '".$nombre."'";

                                //Si el proceso fue exitoso, se lo comunicamos
                                if($conexion->query($act_email) === TRUE)
                                    {
                                        ?>

                                        <div class="alerta-estatica-arriba verde">
                                            <p>¡Email actualizado con éxito!</p>
                                        </div>

                                         <?php
                                    }

                                //Si no, alertamos del error
                                else 
                                    {
                                        ?>

                                            <div class="alerta-estatica-arriba rojo">
                                                <p>¡Ha ocurrido un ERROR!</p>
                                            </div>

                                        <?php
                                    }

                            }
                        }
                        
                        ?>

                        <div>

                        <div class="cuadro_editar">
                        <form id="edicion_usuario_n" method="post" action="<?=$_SERVER['PHP_SELF']?>">

                            <h5 class="login100-form-title m-b-12">Cambiar nombre de usuario</h5>
                            
                            <label class="m-b-10" for="nombre_usuario">Nombre de usuario</label>
                            <input class="input100 m-b-10" type="text" name="nombre_usuario" id="nombre_usuario" placeholder="<?=$_SESSION['usuario_nombre']?>">
                            <input  class="login100-form-btn" type="submit" name="act_nombre" id="act_nombre" value="Confirmar">
                      
                        </form>
                        </div>


                        <div class="cuadro_editar w-50 w-100">
                        <form id="edicion_usuario_c" method="post" action="<?=$_SERVER['PHP_SELF']?>">

                            <h5 class="login100-form-title">Cambiar contraseña</h5>

                            <div class="contenedor-titulo">

                            <div class="objetos-contenedor">
                            <label class="m-b-10" for="nueva_contra">Nueva contraseña</label>
                            <input  class="input100" type="password" name="nueva_contra" id="nueva_contra" maxlength="15" minlength="8" pattern="[a-zA-Z][a-zA-Z0-9-_/.]+">
                            </div>

                            <div class="objetos-contenedor">
                            <label class="m-b-10" for="confir_contra">Confirmar contraseña</label>
                            <input  class="input100" type="password" name="confir_contra" id="confir_contra" maxlength="15" minlength="8" pattern="[a-zA-Z][a-zA-Z0-9-_/.]+">
                            </div>

                            </div>

                            <input class="login100-form-btn"  type="submit" name="act_contra" id="act_contra" value="Confirmar">

                        </form>
                        </div>


                            <?php

                            $nombre = $_SESSION['usuario_nombre'];

                            //Pedimos de la DB el mail del usuario logeado
                            $sql_email = "SELECT Email FROM usuarios WHERE Nombre='".$nombre."'";
                            $resultado_email = $conexion->query($sql_email);


                            //Si el resultado es exitoso, guardamos el mail en una variable para poder mostrarlo en el placeholder del input

                            if($resultado_email->num_rows > 0)
                            {
                                while ($fila = $resultado_email->fetch_assoc()) 
                                 {
                                    $email = $fila['Email'];
                                 }
                            }

                            ?>


                            <div class="cuadro_editar">
                            <form id="edicion_usuario_e" method="post" action="<?=$_SERVER['PHP_SELF']?>">

                            <h5 class="login100-form-title m-b-12">Cambiar email</h5>
                            
                            <label class="m-b-10" for="nuevo_mail">Email</label>
                            <input class="input100 m-b-10"  type="text" name="nuevo_mail" id="nuevo_mail" type="email" name="usuario_email" placeholder="<?=$email ?>">

                            <input class="login100-form-btn" type="submit" name="act_email" id="act_email" value="Confirmar">

                            </form>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

    </body>
</html>

<?php
}
?>