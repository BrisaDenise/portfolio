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
        <title>Mapa sonoro | Almas sonoras</title>
        
        <link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
        <?php
        include("header.php");
        ?>

        <!-- Cargar la librerías p5.js -->
        <script src="p5/p5.js"></script>
        <script src="p5/addons/p5.sound.js"></script>

    </head>
    <body>
       
       
        <nav class="navbar navbar-expand-lg navbar-dark bg-black navbar-expand-sm navbar-expand-md  fixed-bottom">
            <div class="container px-4 px-lg-5">
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ml-auto">
                        <li class="nav-item "><a class="nav-link" href="index.php">Tu melodía</a></li>
                        <li class="nav-item active"><a class="nav-link" href="#">Nuestras melodías</a></li>
                    </ul>
                </div>
            </div>
        </nav>


       
        <section>
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5">
                    <div>

                        <h1 class="text-center m-t-50">Mapa Sonoro</h1>
                            <h6 class="text-center m-t-8 m-b-30">Toca varias melodías en sucesión y escucha como suenan ¡juntos! </h6>


                        <?php

                        //Creamos...

                        //...un array para guardar los nombre de todos los usuarios registrados
                        $usuarios = array();

                        //...un array para guardar los ids de todos los usuarios registrados
                        $ids = array();

                        //...un array bidimensional para guardar la melodía de cada usuario registrado
                        $melodias = array();

                        //...un contador para saber la cantidad de usuarios logueados
                        $cant_user = 0;

                        //...un contador para aumentar el número del primer índice del array bidimensional
                        $index = 0;



                        //Creamos una consulta donde pedimos la información de todos los usuarios en la DB
                        $sql_users = "SELECT * FROM usuarios";
                        $resultado_users = $conexion->query($sql_users);

                        //Si el proceso lanzó resultados
                        if ($resultado_users->num_rows > 0)
                        {
                            while ($fila = $resultado_users->fetch_assoc()) 
                            {

                                //Aumentamos en uno el contador de usuarios
                                $cant_user++;

                                //Guardamos el nombre del usuario en el array 'usuarios[]'
                                array_push($usuarios, $fila['Nombre']);

                                //Guardamos el id del usuario en el array 'ids[]'
                                array_push($ids, $fila['Id']);

                                //Guardamos cada uno de las notas, en orden, dentro de un mismo primer índice
                                //De esta manera la notas nos quedarán agrupadas en un mismo usuario
                                $melodias[$index][0] =  $fila['Nota1'];
                                $melodias[$index][1] =  $fila['Nota2'];
                                $melodias[$index][2] =  $fila['Nota3'];
                                $melodias[$index][3] =  $fila['Nota4'];
                                $melodias[$index][4] =  $fila['Nota5'];
                                $melodias[$index][5] =  $fila['Nota6'];
                                $melodias[$index][6] =  $fila['Nota7'];
                                $melodias[$index][7] =  $fila['Nota8'];
                                $melodias[$index][8] =  $fila['Nota9'];
                                $melodias[$index][9] =  $fila['Nota10'];

                                //Aumentamos en uno el indice
                                $index++;
                            }
                        }

                        ?>


                        <script>

                            <?php

                                //Pasamos el array 'usuarios[]' de PHP a JavaScript 
                                $js_users_array = json_encode($usuarios);
                                echo "var nombre_user = " .$js_users_array. ";\n";

                                //Pasamos el array 'ids[]' de PHP a JavaScript 
                                $js_ids_array = json_encode($ids);
                                echo "var id_user = " .$js_ids_array. ";\n";

                                //Pasamos el array 'melodia[]' de PHP a JavaScript 
                                $js_melodias_array = json_encode($melodias);
                                echo "var melodia_user = " .$js_melodias_array. ";\n";

                            ?>

                            //Creamos...

                            //***************************************************************************************************//
                            //                                                                                                   //
                            //    Decidí que las personas no pudieran cargar su propia imagen, porque quiero que su apariencia   //
                            //    permanezca en el anonimato; y, dentro de una página destinada al sonido, que sea su melodía lo //
                            //    que los identifique antes que la imagen. Además, cuentan con el nombre. Entonces, nombre +     //
                            //    melodía es la suficiente identificación buscada para la temática de la página.                 //
                            //                                                                                                   //
                            //***************************************************************************************************//

                            //...una variable para cargar el icono único de los usuarios
                            let icono;

                            //...dos variables para determinar el ancho y alto del sketcj utilizando la ventana del browser
                            let ancho = (window.innerWidth * 82) / 100;
                            let alto = (window.innerHeight * 67) / 100;

                            //...dos arrays para guardar las posiciones X e Y de la representación de cada usuario
                            let posx = [];
                            let posy = [];

                            //...un array donde crearemos una lista de objetos de la clase 'UsuarioIcons'
                            let iconos = [];

                            //...un array donde cargaremos los sonidos de cada una de las 12 notas
                            let notas = [];

                            //...una variable donde cargaremos la fuente que usaremos en el sketch
                            let fuente;

                            //...una variable donde cargaremos la imagen del fondo del mapa
                            let mapa;
                            


                            //En la función preload...
                            function preload(){

                                //Cargo las imágenes de icono y del mapa de fondo
                                icono = loadImage('images/usuario.png');
                                mapa = loadImage('images/mapa.png');

                                //Cargamos la fuente que usaremos en el sketch
                                fuente = loadFont('fonts/Comfortaa/Comfortaa-Regular.ttf');

                                //Cargamos el sonido de cada nota en el array 'notas'
                                notas[0] = loadSound('sonidos/do.mp3');
                                notas[1] = loadSound('sonidos/dos.mp3');
                                notas[2] = loadSound('sonidos/re.mp3');
                                notas[3] = loadSound('sonidos/res.mp3');
                                notas[4] = loadSound('sonidos/mi.mp3');
                                notas[5] = loadSound('sonidos/fa.mp3');
                                notas[6] = loadSound('sonidos/fas.mp3');
                                notas[7] = loadSound('sonidos/sol.mp3');
                                notas[8] = loadSound('sonidos/sols.mp3');
                                notas[9] = loadSound('sonidos/la.mp3');
                                notas[10] = loadSound('sonidos/sib.mp3');
                                notas[11] = loadSound('sonidos/si.mp3');

                                //Definimos el modo de reproducción en SUSTAIN
                                for (var i = 0; i < notas.length; i++) {notas[i].playMode('sustain');}

                                //Creamos un ciclo que se repetirá iguall cantidad de veces que de usuarios
                                for (i = 0; i < <?php echo $cant_user ?>; i++)
                                {

                                    //Los usuarios tendrán una posición random cada vez que se recarga la página
                                    //Guardamos en cada array de posiciones un numero aleatorio entre 100 (para dar un margen) y el ancho y alto de la pantalla + 100 (para dejar otro margen)
                                    posx[i] = random(100, ancho-50);
                                    posy[i] = random(100, alto-50);


                                    //Creamos los objetos de la Clase UsuarioIcons para cada usuario
                                    //Le damos el nombre de cada usuario, y la posición random conseguida anteriormente
                                    iconos[i] = new UsuarioIcons(nombre_user[i], posx[i], posy[i]);
                                }
                            }



                            //En la función setup...
                            function setup(){

                                //Creamos el canvas con el ancho y alto anteriormente calculado
                                let canvas = createCanvas(ancho,alto);
                                //Le asignamos un parent dentro del HTML
                                canvas.parent('p5.js');
                            }



                            //En la función draw...
                            function draw(){

                                //Pintamos el fondo de blanco
                                background(255);

                                //Definimos el modo en el que se va a dibujar la imagen y la mostramos
                                imageMode(CORNER);
                                image(mapa,0, 0, ancho, alto);

    
                                //Definimos el cursor del sketch
                                //Esto principalmente para después cambiarlo
                                cursor(ARROW);

                                //Creamos un ciclo que se repita la misma cantidad de veces que usuarios en la DB
                                for (j = 0; j < <?php echo $cant_user ?>; j++)
                                {
                                    //Si la primer nota de la melodía del usuario es igual a NADA
                                    //Y recordamos que no podiamos porner NADA en la primer nota
                                    //Significa que no tiene melodía, entonces no lo mostramos

                                    //Pero si en cambio si hay algo en la primer nota
                                    if(melodia_user[j][0] != '')
                                    {
                                       //Mostramos el icono del usuario
                                       iconos[j].display();

                                       //Si el cursor está dentro de algún ícono mostramos el cursor HAND
                                       if(mouseX > posx[j] - 15 && mouseX < posx[j] + 15 && mouseY > posy[j]-15 && posy[j]+15)
                                        {
                                            cursor(HAND);
                                        }
                                    }
                                }
                            }



                            //Al hacer click...
                            function mouseClicked(){

                                //Hacemos un ciclo mpara recorrer a cada usuario
                                for (j = 0; j < <?php echo $cant_user ?>; j++)
                                {
                                    //Y en el caso de que el mouse se posicione dentro de su ícono, ejeculamos 'reproducirMelodía'
                                    if (mouseX > posx[j]-20 && mouseX < posx[j]+20 && mouseY > posy[j]-20 && mouseY < posy[j]+20)
                                    {
                                        reproducirMelodia(j);
                                    }
                                }

                            }
                            


                            //Con esta función reproduciremos la melodía del usuario clickeado
                            //Al estar cada nota guardada en un array, debemos recorrerlo con un for
                            //Entonces, hasta que el ciclo no termine no se terminará la función
                            //Es esa la razón por la cual las melodías no pueden superponerse, sino ENCADENARSE
                            //Porque no se tratan de una canción que en sustain puede encimarsele otra
                            //Entonces me resulto imposible lograr la superposición y el loop de las melodías
                            //También intenté hacer una reproducción en cadena, pero el tiempo que se toma para recorrer todos los usuarios, lo toma como un error y el navegador muestra 'La página no responde'
                            //Entonces, lo dejé como una elección del usuario cuantas melodías encadenar.


                            //***De cualquier forma, si hay alguna otra forma de hacerlo que me pueda explicar, se lo agradecería**// 


                            function reproducirMelodia(usuario)
                            {
                                //Con un for recorremos las diez melodías que conforman una melodía
                                for (m = 0; m < 10; m++)
                                {
                                        //Y consultamos a cada nueva nota que sonido reproducir según su ruta
                                        switch(melodia_user[usuario][m])
                                        {
                                            //Si es 'sonidos/do.mp3' el sonido a reproducir será DO
                                            case 'sonidos/do.mp3':
                                                notas[0].play();
                                                break;

                                            //Si es 'sonidos/dos.mp3' el sonido a reproducir será DO#
                                            case 'sonidos/dos.mp3':
                                                notas[1].play();
                                                break;

                                            //Si es 'sonidos/re.mp3' el sonido a reproducir será RE
                                            case 'sonidos/re.mp3':
                                                notas[2].play();
                                                break;

                                            //Si es 'sonidos/res.mp3' el sonido a reproducir será RE#
                                            case 'sonidos/res.mp3':
                                                notas[3].play();
                                                break;

                                            //Si es 'sonidos/mi.mp3' el sonido a reproducir será MI
                                            case 'sonidos/mi.mp3':
                                                notas[4].play();
                                                break;

                                            //Si es 'sonidos/fa.mp3' el sonido a reproducir será FA
                                            case 'sonidos/fa.mp3':
                                                notas[5].play();
                                                break;

                                            //Si es 'sonidos/fas.mp3' el sonido a reproducir será FA#
                                            case 'sonidos/fas.mp3':
                                                notas[6].play();
                                                break;

                                            //Si es 'sonidos/sol.mp3' el sonido a reproducir será SOL
                                            case 'sonidos/sol.mp3':
                                                notas[7].play();
                                                break;

                                            //Si es 'sonidos/sols.mp3' el sonido a reproducir será SOL#
                                            case 'sonidos/sols.mp3':
                                                notas[8].play();
                                                break;

                                            //Si es 'sonidos/la.mp3' el sonido a reproducir será LA
                                            case 'sonidos/la.mp3':
                                                notas[9].play();
                                                break;

                                            //Si es 'sonidos/sib.mp3' el sonido a reproducir será SIb
                                            case 'sonidos/sib.mp3':
                                                notas[10].play();
                                                break;

                                            //Si es 'sonidos/si.mp3' el sonido a reproducir será SI
                                            case 'sonidos/si.mp3':
                                                notas[11].play();
                                                break;

                                            //En el caso de que no haya NADA, es decir: silencio, solo se dejará correr el tiempo
                                            case '':
                                                break;
                                        }

                                        //Nuevamente, utilizamos la función esperar, misma que en 'sketch.js'
                                        esperar(350);
                                }
                            }

                            //Creamos una clase para hacer cada icono de usuario con su nombre
                            class UsuarioIcons{

                                //Creamos un constructor en el que pediremos el nombre del usuario y sus posiciones X e Y calculadas anteriorment al azar
                                constructor(nombre,x , y){
                                    this.nombre = nombre;
                                    this.x = x;
                                    this.y = y;
                                }


                                //Creamos una función con la que dibujaremos al usuario en el mapa
                                display(){

                                    //Definimos el modo de centrar la imagen y dibujamos el icono único en las posiciones
                                    imageMode(CENTER);
                                    image(icono, this.x,this.y, icono.width, icono.height);

                                    //Alineando el texto, con la fuente cargada, escibimos el nombre del usuario sobre el ícono
                                    textFont(fuente);
                                    textAlign(CENTER, CENTER);
                                    textSize(10);
                                    fill(0);
                                    text(this.nombre, this.x, this.y - 25);
                                }
                            }



                            //Esta función la utilizamos para reasignar valores cuando se reescala la ventana del browser
                            window.onresize = function() {
                               
                                //Recalculamos el ancho y alto de nuestro canvas
                                ancho = (window.innerWidth * 75) / 100;
                                alto = (window.innerHeight * 75) / 100; 
                              
                                //Y volvemos a dimensionar el canvas
                                resizeCanvas(ancho, alto);

                                //Con un ciclo pasamos por la cantidad de usuarios que hayan
                                for (i = 0; i < <?php echo $cant_user ?>; i++)
                                {
                                    //Volvemos a calcular las posiciones X e Y de los usuarios
                                    posx[i] = random(100, ancho-50);
                                    posy[i] = random(100, alto-50);

                                    //Y volvemos a asignar los valores a los objetos de la clase 'UsuarioIcons'
                                    iconos[i] = new UsuarioIcons(nombre_user[i], posx[i], posy[i]);
                                }

                            }



                            //Misma función de tiempo de espera utilizada en 'sketch.js'
                            function esperar(ms){
                                var tiempo_actual = new Date().getTime();
                                var tiempo = tiempo_actual;

                                while (tiempo < tiempo_actual + ms){
                                    tiempo = new Date().getTime();
                                }
                            }


                        </script>

                        <div id="p5.js"></div>

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