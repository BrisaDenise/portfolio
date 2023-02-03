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

//Si el usuario NO es el Admin
elseif($_SESSION['usuario_nombre'] != 'Admin')
{
    //Lo redirigimos a la página principal
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

        <title>Administración de usuarios | Almas sonoras</title>
        
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

                            <h1 class="m-l-10">Panel de administración de usuarios</h1>
                        </div>

                        <hr class="m-b-40">


                    <?php

                        //Crearemos un contador para guardar los ids de los usuarios
                        //¡No significa que todos los números estén usados por ids!
                        $total_id = 0;

                        //Realizamos una consulta para obtener a todos los usuarios de nuestra DB
                        $sql_users = "SELECT * FROM usuarios";
                        $resultado_users = $conexion->query($sql_users);

                        //Si existe un resultado...
                        if ($resultado_users->num_rows > 0)
                        {
                            while ($fila = $resultado_users->fetch_assoc()) 
                            {
                                //Vamos actualizando nuestro contador con los ids hasta conseguir el último
                                $total_id = $fila['Id'];
                            }
                        }


                        //Como los ids van en forma ascendente, el último id será el número más grande en nuestra DB
                        //Entonces, recorreremos todos los número hasta ese último id
                        for ( $i = 1 ; $i <= $total_id ; $i++) 
                        {   

                            //Creamos una variable en la que unimos "borrar_user" + el contador
                            //Sucede que ese nombre es el asignado a los botones de borrar
                            $n_user = "borrar_user".$i;

                            //Entonces, si se presiona alguno de ellos
                            if(isset($_POST[$n_user]))
                            {
                                //Declararemos una variable para guardar ese id
                                $id=$i;

                                //Y creamos una consulta donde pedimos que se borre de la DB al usuario con ese Id
                                $sql_borrar = "DELETE FROM usuarios WHERE Id='$id'";

                                //En el caso de que se haya logrado eliminarlo
                                if($resultado_borrar = $conexion->query($sql_borrar))
                                {
                                    //Alertaremos al Admin de esta acción completada
                                    ?>
                                        <div class="alerta-estatica-arriba verde">
                                            <p>El usuario Id <?= $id ?> ha sido eliminado con éxito.</p>
                                        </div>

                                    <?php

                                }

                                //Y si no, también se lo avisaremos
                                else
                                {
                                    ?>
                                        <div class="alerta-estatica-arriba rojo">
                                            <p>El usuario Id <?= $id ?> no pudo ser eliminado.</p>
                                        </div>

                                    <?php
                                } 
                            }
                        }
                    ?>



                    <div id="tabla-wrapper">

                    <div id="tabla-scroll">

                    <table class="table">
                        <div id="para_pintar">
                        <thead>
                             <tr>
                                 
                                 <th><span class="fijo">Id</span></th>
                                 <th><span class="fijo">Nombre de usuario</span></th>
                                 <th><span class="fijo">Email</span></th>
                                 <th><span class="fijo">Fecha y hora de registro</span></th>
                                 <th><span class="fijo">Acciones</span></th>
                             </tr>
                         </thead>
                         <div>
                         <tbody>


                        <?php

                        //A continuación crearemos una tabla en la que mostrar la información de cada usuario registrado y la posibilidad de eliminar al usuario por parte del administrador.

                        //Hacemos una consulta donde pedimos todo lo que haya en nuestra DB
                        $sql_users = "SELECT * FROM usuarios";
                        $resultado_users = $conexion->query($sql_users);

                        //Si existe un resultado
                        if ($resultado_users->num_rows > 0)
                        {    
                            //Mientras se recorra cada fila
                            while($fila = $resultado_users->fetch_assoc())
                            {
                                //Tomamos el id como identificador que va a ayudarnos en el envío del formulario
                                $num=$fila['Id'];

                                //Creamos la nueva fila de la tabla y cada una de sus columnas
                                //Mostraremos Id, Nombre, Email y Fecha de registro
                                echo "<tr>";
                                echo "<th>".$fila['Id']."</th>";
                                echo "<th>".$fila['Nombre']."</th>";
                                echo "<th>".$fila['Email']."</th>";
                                echo "<th>".$fila['Registro']."</th>";


                                //Por último crearemos una casilla donde habrá un form con un botón
                                //Este form procesará el borrado del usuario
                                //A cada botón se le atribuirá un nombre especial "borrar user" + ID, de esa forma podemos identificar de que usuario es cada botón y borrar el usuario correcto
                                //Nos servirá tanto para el submit como para el cuadro confirm que expliqué el 'main.js'

                                echo "<th>
                                      <form id='form".$num."' action='adm_user.php' method='post'>
                                      <input class='btn_tabla'  type='button' name='borrar_user".$num."' id='borrar_user".$num."' value='Borrar' onclick='confirmar(".$num.")'>
                                      </form>
                                      </th>";

                                echo "<tr>";
                            }
                        }

                        ?>

                    </tbody>

                    </table>

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