

//La siguiente función nos va a permitir emitir una alerta que el ADMIN deberá confirmar o no para eliminar un usuario
//Al llamar a la función, pedimos el id del usuario para saber que submit activar.
function confirmar(id){

    //Formamos el nombre del botón eliminar del usuario seleccionado
    var boton = eval('borrar_user'+ id);

    //Creamos una alerta que el usuario debe confirmar o no
    //Si la acepta, el botón se convierte en un submit y envía el formulario que elima al usuario
    if(confirm('¿Estás seguro que quieres eliminar este usuario de tu base de datos?')){boton.type = 'submit';}

    //Si no, no hace nada.
    else{}
}




//Habilitar y deshabilitar botones "Borrar" y "Reproducir"
//Cuando estemos en la pag 'index.php' ejecutaremos el siguiente código
if (window.location.href.match('index.php') != null){

    //Una vez que la pantalla se haya cargado...
    window.onload=function() {
        
        //Tomaremos el valor del input 'estado_repr' para saber si estado es TRUE or FALSE
        var estado = document.getElementById("estado_repr").value;

        //Si es true, es decir, si no hay notas en la base de datos del usuario que borrar ni reproducir
        if (estado == 'true')
        {
            //Deshabilitamos el botón de BORRAR y REPRODUCIR
            document.getElementById("reproducir").disabled = true;
            document.getElementById("borrar").disabled = true;
        }

        //Si no, los habilitamos
        else{
            document.getElementById("reproducir").disabled = false; 
            document.getElementById("borrar").disabled = false;
        }
    }
}



//Reproducir melodía guardada del usuario
//Cuando se llame a la función 'play()'
function play() {

    //Se obtienen los elementos audio, es decir, cada una de las 10 notas/silencios guardadas por el usuario
    var audio1 = document.getElementById("audio1");
    var audio2 = document.getElementById("audio2");
    var audio3 = document.getElementById("audio3");
    var audio4 = document.getElementById("audio4");
    var audio5 = document.getElementById("audio5");
    var audio6 = document.getElementById("audio6");
    var audio7 = document.getElementById("audio7");
    var audio8 = document.getElementById("audio8");
    var audio9 = document.getElementById("audio9");
    var audio10 = document.getElementById("audio10");

    //Se crea un contador
    var i = 1;

    //Creamos un intervalo para reproducir una nota/silencio después de otra
    var intervalo = setInterval(() => {

        //Si el contador llega a 11, es decir que no hay más notas
        if (i == 11){

            //Eliminamos el intervalo
            clearInterval(intervalo);
        }

        //Si no
        else{

            //Formamos el nombre de cada variable de audio obtenida anteriormente
            var audio = eval('audio'+i);

            //Y si no es igual a esa url, es decir, un silencio
            if(audio.src != 'http://localhost/tp2-LeonBrisa/index.php')
            {
                //Reproducimos la nota
                audio.play();
            }
            
            //Aumentamos en uno el contador
            i++;
        }

        //Definimos que la velocidad en que se haga el intervalo sea de 350ms
    }, 350);
}



//Iniciamos jQuery, y le decimos que comience a trabajar cuando el DOM ya esté cargado
$(document).ready(function(){

    //Si un elemento de esta clase es visible, es decir, display = 'block'
    if ($(".alerta-estatica-arriba").is(':visible')){

        //Activamos el siguiente temporizador
         setTimeout(function(){

            //En el que el elemento realizará un fade out de 2s.
            $(".alerta-estatica-arriba").fadeOut(2000);

        //A los 2s.
        },2000);
    }

    //Animación del título principal
    $("div.titulo").fadeIn(1000);

    //Si ingresamos el mouse dentro del título, cambiamos el color de fondo y el de letras
    $("div.titulo").mouseover(function() {
        $("div.titulo").fadeOut(100, function() {
            $("div.titulo").css("background-color", "black").fadeIn(500);
            $("h1.objeto-titulo").css("color", "white").fadeIn(500);
        });
    })

    //Y cuando se retire el mouse, volverá a su estado original
    $("div.titulo").mouseout(function() {
        $("div.titulo").fadeOut(100, function() {
            $("div.titulo").css("background-color", "white").fadeIn(500);
            $("h1.objeto-titulo").css("color", "black").fadeIn(500);
        });
    })

    

});