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

//Si no, cargamos la página
else
{
?>

<!DOCTYPE html>
<html lang="en">
    <head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <title>Almas sonoras</title>

        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>

        <?php
        include("header.php");
        ?>

        <!-- Cargar la librerías p5.js -->
        <script src="p5/p5.js"></script>
        <script src="p5/addons/p5.sound.js"></script>
        <script src="js/sketch.js"></script>
        <script src="js/main.js"></script>


    </head>
    <body>
       
       
        <nav class="navbar navbar-expand-lg navbar-dark bg-black navbar-expand-sm navbar-expand-md fixed-bottom">
            <div class="container px-4">
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item active"><a class="nav-link" href="#">Tu melodía</a></li>
                        <li class="nav-item"><a class="nav-link" href="mapa.php">Nuestras melodías</a></li>
                    </ul>
                </div>
            </div>
        </nav>


       
        <section>
            <div class="container px-4 px-lg-5">
                <div class="gx-4 gx-lg-5">
                    <div>


                        <div class="contenedor-titulo m-b-10">

                        <div class="objetos-contenedor">
                        <?php

                            //Si el usuario logeado es el Admin, entonces le mostramos la opción de "Administrar usuarios"
                            if($_SESSION['usuario_nombre'] == 'Admin')
                            {
                                ?>
                                        <abbr title="Administración de usuarios"><button class="btn_menu"><a href="adm_user.php"><img src="images/adm.png" alt="Administración de usuarios"></a></button></abbr>
                                <?php
                            }

                            //En cambio, si es algún otro usuario, mostraremos "Administrar perfil"
                            else{

                                ?>
                                        <abbr title="Administrar perfil"><button class="btn_menu"><a href="editar_perfil.php"><img src="images/config.png" alt="Configuración"></a></button></abbr>
                                <?php
                            }
                        ?>
                        </div>


                        <div class="objetos-contenedor">
                            <h1 class="text-center">Toca tu melodía</h1>
                            <h6 class="text-center m-t-12 m-b-12">Hola <strong><?=$_SESSION['usuario_nombre']?></strong>, este es tu espacio para crear...</h6>
                        </div>


                        <div class="objetos-contenedor">
                            <abbr title="Salir"><button class="btn_menu"><a href="logout.php"><img src="images/logout.png" alt="Logout"></a></button></abbr>
                        </div>


                        </div>



                        <div id="sketch_p5js" class="container-md text_alineacion">



                        </div>
                    </div>
                </div>
            
            <hr class="linea_index">

            <?php
            
            //Guardamos el nombre del usuario logeado en una variable
            $nombre = $_SESSION['usuario_nombre'];


            //******************************************************************************************************************
            //                    Lo siguiente se relaciona con el 'sketch.js' ya que es esta página será visualizado         //
            //                    por eso haré referencia a cuestiones que se comentaron en ese archivo.                      //
            //******************************************************************************************************************


            //Si se presiona el botón guardar, para grabar la melodía hecha por el usuario en la DB
            if(isset($_POST['guardar']))
            {
                //Se consulta por toda la fila correspondiente a ese usuario
                $sql = "SELECT Nombre FROM usuarios WHERE Nombre='".$nombre."'";
                $resultado = $conexion->query($sql);

                //Una vez que el proceso fue exitoso...
                if($resultado->num_rows > 0)
                {
                    //Se guardan en variables los valores en los inputs de cada nota
                    //Recordemos que estos input se cargaban con información que recibian del sketch de p5.js
                    $nota1 = $_POST['primer_nota'];
                    $nota2 = $_POST['segunda_nota'];
                    $nota3 = $_POST['tercer_nota'];
                    $nota4 = $_POST['cuarta_nota'];
                    $nota5 = $_POST['quinta_nota'];
                    $nota6 = $_POST['sexta_nota'];
                    $nota7 = $_POST['septima_nota'];
                    $nota8 = $_POST['octava_nota'];
                    $nota9 = $_POST['novena_nota'];
                    $nota10 = $_POST['decima_nota'];


                    //Se realiza una actualización de los valores de cada columna de las notas del usuario con las variables generadas anteriormente
                    $registrar_notas = "UPDATE usuarios SET Nota1 ='$nota1', Nota2 ='$nota2', Nota3 ='$nota3', Nota4 ='$nota4', Nota5 ='$nota5', Nota6 ='$nota6', Nota7 ='$nota7', Nota8 ='$nota8', Nota9 ='$nota9', Nota10 ='$nota10' WHERE Nombre = '$nombre'";

                    //Si el proceso fue exitoso, se avisará al usuario de ello
                    if($conexion->query($registrar_notas) === TRUE)
                    {
                        ?>

                                <div class="alerta-estatica-arriba verde">
                                    <p>¡Que linda melodía! Cargada con éxito.</p>
                                </div>

                             <?php
                    }

                    //Si no, se alertará al usuario
                    else 
                    {

                        ?>

                            <div class="alerta-estatica-arriba rojo">
                                <p>¡No! Algo salió mal.</p>
                            </div>

                        <?php
                        
                    }
                }
            }


            //Si se presiona el botón borrar...
            else if(isset($_POST['borrar']))
            {

                //Actualizamos los valores de las columnas a NADA
                $sql_borrar_notas = "UPDATE usuarios SET Nota1 ='', Nota2 ='', Nota3 ='', Nota4 ='', Nota5 ='', Nota6 ='', Nota7 ='', Nota8 ='', Nota9 ='', Nota10 ='' WHERE Nombre = '$nombre'";

                $resultado_borrar_notas = $conexion->query($sql_borrar_notas);


                //Si la operación fue exitosa, avisamos al usuario
                if ($resultado_borrar_notas === TRUE)
                {
                    ?>

                        <div class="alerta-estatica-arriba verde">
                            <p>¡Adiós melodía! Borrada con éxito.</p>
                        </div>

                    <?php
                }

                //Si no, alertaremos del error
                else 
                    {
                       ?>
                            <div class="alerta-estatica-arriba rojo">
                                <p>¡No! Algo salió mal.</p>
                            </div>
                        <?php 
                    }
            }

            ?>



            <form  class="login100-form validate-form flex-c flex-w" id="form1" action="<?=$_SERVER['PHP_SELF']?>" method="post">

                <input class="ocultar" type="text" name="primer_nota" id="primer_nota">
                <input class="ocultar" type="text" name="segunda_nota" id="segunda_nota">
                <input class="ocultar" type="text" name="tercer_nota" id="tercer_nota">
                <input class="ocultar" type="text" name="cuarta_nota" id="cuarta_nota">
                <input class="ocultar" type="text" name="quinta_nota" id="quinta_nota">
                <input class="ocultar" type="text" name="sexta_nota" id="sexta_nota">
                <input class="ocultar" type="text" name="septima_nota" id="septima_nota">
                <input class="ocultar" type="text" name="octava_nota" id="octava_nota">
                <input class="ocultar" type="text" name="novena_nota" id="novena_nota">
                <input class="ocultar" type="text" name="decima_nota" id="decima_nota">

                <abbr title="Guarda tu meldoía recién creada"><input class="boton_redondo" type="submit" id= "guardar" name="guardar" value="Guardar"  disabled></abbr>


                <?php

                    //Guardamos en una variable el nombre del usuario
                    $nombre = $_SESSION['usuario_nombre'];

                    //Creamos una variable que simula un bool puesto en FALSE
                    //Esta la ubicaremos en un input que leera 'main.js' para mostrar o no los botones 'REPRODUCIR' y 'BORRA'
                    $estado = 'false';

                    //Seleccionamos de la DB del usuario todas sus notas
                    $sql_notas = "SELECT Nota1, Nota2, Nota3, Nota4, Nota5, Nota6, Nota7, Nota8, Nota9, Nota10 FROM usuarios WHERE Nombre = '".$nombre."'";
                    $resultado_notas = $conexion->query($sql_notas);

                    //Si el resultado fue exitoso
                    if ($resultado_notas->num_rows > 0)
                    {
                        while ($fila = $resultado_notas->fetch_assoc()) 
                        {
                            //Guardamos en variables la ruta guardada en cada columna, para las 10 notas
                            $uno = $fila['Nota1'];
                            $dos = $fila['Nota2'];
                            $tres = $fila['Nota3'];
                            $cuatro = $fila['Nota4'];
                            $cinco = $fila['Nota5'];
                            $seis = $fila['Nota6'];
                            $siete = $fila['Nota7'];
                            $ocho = $fila['Nota8'];
                            $nueve = $fila['Nota9'];
                            $diez = $fila['Nota10'];

                            //En el caso de que la primer nota sea igual a nada, es decir, no hay melodía
                            //Cambiaremos el estado a true, si no, a false.
                            if($uno == ''){$estado = 'true';} 
                            else {$estado = 'false';}

                        }
                    }

                    //En el caso de un error lo comunicaremos
                    else {echo "<p>ERROR</p>";}
                ?>



                 <abbr title="Reproduce tu melodía guardada"><input class="boton_redondo"  type="button" id= "reproducir" name="reproducir" value="Reproducir" onclick="play()"></abbr>

                 <audio id="audio1" src="<?= $uno ?> "></audio>
                 <audio id="audio2" src="<?= $dos ?> "></audio>
                 <audio id="audio3" src="<?= $tres ?> "></audio>
                 <audio id="audio4" src="<?= $cuatro ?> "></audio>
                 <audio id="audio5" src="<?= $cinco ?> "></audio>
                 <audio id="audio6" src="<?= $seis ?> "></audio>
                 <audio id="audio7" src="<?= $siete ?> "></audio>
                 <audio id="audio8" src="<?= $ocho ?> "></audio>
                 <audio id="audio9" src="<?= $nueve ?> "></audio>
                 <audio id="audio10" src="<?= $diez ?> "></audio>


                 <input class="ocultar" type='text' name='estado_repr' id='estado_repr' value='<?= $estado ?>'>

                <abbr title="Elimina tu melodía guardada"><input class="boton_redondo" type="submit" id="borrar" name="borrar" value="Borrar"></abbr>

            </form>       
          </div>  
        </section>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
}
?>