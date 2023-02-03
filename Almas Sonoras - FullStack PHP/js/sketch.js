
//Creamos...

//...un array donde guardaremos los sonidos de cada nota
const notas = [];

//...un array donde guardaremos la ruta de la nota de la tecla presionada
const notas_escritas = [];

//...un array para para crear objetos de la clase Tecla
let teclas_notas = [];

//...un array donde se guarda el sonido de la nota de la tecla presionada
let melodia = [];

//...un bool para identificar cuando la cantidad de notas llego a 10
let lleno = false;

//...un array de posx para ubicar en el eje x a las teclas
let posx = [];
//...una variable con el valor de posy para ubicar en el eje y a las teclas, como todas estan a la misma altura, usamos solo una.
let posy;
//...una variable para calcular el ancho de las teclas dependiende el tamñalo de la ventana del navegador
let ancho_t;


//...tres variables para determinar posición X, Y e ANCHO de circulo de reprodución
let circulox;
let circuloy;
let circulow;

//...dos variables para cargar las imagenes de borrar y resetear
let reset, borrar;

//...una variable para cargar la fuente del sketch
let fuente;

//...tres variables para determinar posición X, Y e ANCHO de circulo de silencio
let silenX;
let silenY;
let silenW;

//...dos variables para determinar el tamaño del canvas con respecto al navegador
let ancho = window.innerWidth*0.55;
let alto = window.innerHeight*0.4;



//En la función preload...
function preload() {

	//Cargamos en el array notas[] cada una de las notas
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

	//Y definimos que su modo de reproducción sea SUSTAIN para que puedan pisarse entre si y no cortarse
	for (var i = 0; i < notas.length; i++) {notas[i].playMode('sustain');}

	//Cargamos las imagenes de eliminar y resetear
	reset = loadImage('images/eliminar.png');
	borrar = loadImage('images/borrar.png');

	//Cargamos la fuente del sketch
	fuente = loadFont('fonts/Comfortaa/Comfortaa-Regular.ttf');

}



//En la función setup...
function setup() {
  
  //Se crea el canvas con un tamaño dependiente a la ventana del browser
  let canvas = createCanvas(ancho,alto);
  //Asignamoe el parent del sketch en el DOM
  canvas.parent('sketch_p5js');


  	//Definimos los valores de las variables de ubicaciones X, Y e anchos
    circulox = width*0.5;
    circuloy = height*0.2;
    circulow = 70;

    silenX= width*0.9;
    silenY= height*0.7;
    silenW= width*0.06;

	posy = height*0.5;

  	posx[0] = width*0.09;
	posx[1] = width*0.15;
	posx[2] = width*0.21;
	posx[3] = width*0.27;
	posx[4] = width*0.33;
	posx[5] = width*0.39;
	posx[6] = width*0.45;
	posx[7] = width*0.51;
	posx[8] = width*0.57;
	posx[9] = width*0.63;
	posx[10] = width*0.69;
	posx[11] = width*0.75;

	ancho_t = width*0.05;


	//Creamos los objetos Tecla para hacer las 12 teclas de una octava
	teclas_notas = [new Tecla(posx[0], posy, ancho_t, 'blanca'), 
  				    new Tecla(posx[1],posy, ancho_t, 'negra'),
  				    new Tecla(posx[2], posy, ancho_t, 'blanca'),
  				    new Tecla(posx[3], posy, ancho_t, 'negra'),
  				    new Tecla(posx[4], posy, ancho_t, 'blanca'),
  				    new Tecla(posx[5], posy, ancho_t, 'blanca'),
  				    new Tecla(posx[6], posy, ancho_t, 'negra'),
  				    new Tecla(posx[7], posy, ancho_t, 'blanca'),
  				    new Tecla(posx[8], posy, ancho_t, 'negra'),
  				    new Tecla(posx[9], posy, ancho_t, 'blanca'),
  				    new Tecla(posx[10], posy, ancho_t, 'negra'),
  				    new Tecla(posx[11], posy, ancho_t, 'blanca')];

  	//Centramos las imagenes que vamos a estar mostrando
  	imageMode(CENTER);
}




//En la función draw...
function draw() {

	//Pintamos el fondo de blanco
	background(255);

  //Mostramos cada uno de los objetos Teclas creados anteriormente  
  for (var i = 0; i < teclas_notas.length; i++) 
  {
  	teclas_notas[i].display();
  }


  //Definimos el cursor del sketch en arrow para después modificarlo según donde esté
  cursor(ARROW);

 

  //Mostramos el ícono de borrar, y decidimos que si el mouse se posiciona sobre la imagen aparecerá un título descriptivo
  image(borrar, circulox+70, circuloy);
  if (mouseX > (circulox+70)-(borrar.width/2) && mouseX < (circulox+70)+(borrar.width/2) && mouseY > circuloy-(borrar.height/2) && mouseY < circuloy+(borrar.height/2))
	{
		noStroke();
	 	fill(70);
	  	textSize(11);
	  	textAlign(LEFT);
	  	textWrap(WORD);
	  	text('Borra tu última nota', circulox +55, circuloy+25, 80);

	  	//Si se ha ya presionado una tecla, el cursor cambiará a una mano
	  	if(melodia[0] != null)
	  	cursor(HAND);
	}

  
  //Mostramos el ícono de resetear, y decidimos que si el mouse se posiciona sobre la imagen aparecerá un título descriptivo
  image(reset, circulox-70, circuloy);
  if(mouseX > (circulox-70)-(reset.width/2) && mouseX < (circulox-70)+(reset.width/2) && mouseY > circuloy-(reset.height/2) && mouseY < circuloy+(reset.height/2))
	{
		 noStroke();
		  fill(70);
		  textSize(11);
		  textAlign(RIGHT);
		  textWrap(WORD);
		  text('Elimina todas tus notas', circulox-150, circuloy+25, 100);

		  //Si se ha ya presionado una tecla, el cursor cambiará a una mano
		  if(melodia[0] != null)
		  cursor(HAND);
	}

  
  //Dibujamos el circulo para reproducir la melodía que el usuario va creando
  noStroke();
  fill(230);
  circle(circulox, circuloy, circulow);

  //Si se ha ya presionado una tecla, el cursor cambiará a una mano sobre el reproductor
  if(melodia[0] != null)
  if(mouseX > (circulox - circulow/2) && mouseX < (circulox + circulow/2) && mouseY > (circuloy - circulow/2) && mouseY < (circuloy + circulow/2))
	{
		cursor(HAND);
	}


  //Aquí, hacemos un condicional para cambiar de color tanto el reproductor como la tecla 'silencio'
  //La idea es que cuando no haya ninguna melodía para reproduccir el botón de reproducción se vea deshabilitado
  //Con respecto al silencio, el usuario no va a poder colocar un silencio como su primer nota, por eso se ve deshabilitada
  //Cuando la primer nota haya sido tocada, es decir hay algo por reproducir  y se puede agregar un silencio, cambia a un color que indica 'habilitado'

  if(melodia[0] == null){fill(200);}
  else{fill(0);}

  //Dibujamos el tiangulo 'Reproducir'
  triangle(circulox-10,circuloy-15,circulox-10,circuloy+15,circulox+15,circuloy);
  
  //Escribimos 'Silencio' para poder identificar la función de esa "tecla".
  textSize(12);
  textFont(fuente);
  textAlign(CENTER, CENTER);
  text('Silencio',silenX, silenY+40);
  

  //En este caso aplicamos lo mismo que en el anterior solo que con stroke
  //Ademas le decimos que si ya son nueve notas las tocadas, el usuario no puede agregar un silencio, es decir que la útima nota nunca puede ser un silencio, al igual que la primera
  if(melodia[0] == null || melodia.length >= 9){stroke(200);}
  else{stroke(0);}

  //Dibujamos la "tecla" del silencio.
  strokeWeight(4);
  fill(255);
  circle(silenX, silenY, silenW);
  noStroke();



  	
  //**************************************************************************************************************************************

  	//A partir de acá, vamos a dar la información conseguida para que posteriormente pueda guardarse en la base de datos
	//Cuando la cantidad de notas es igual a 10...	
	if (notas_escritas.length == 10)
	{
		//Se pone TRUE la variable lleno, es decir, ya no se permiten más notas
		lleno = true;

		//Habilitamos el botón de guardar para que el usuario lo utilice
		document.getElementById('guardar').disabled = false;

		//Y le pasamos al HTML todas las notas guardadas que fueron tocadas por el usuario
		//La subimos a 10 inputs ocultos para que PHP pueda leerlo
		document.getElementById('primer_nota').value = notas_escritas[0];
		document.getElementById('segunda_nota').value = notas_escritas[1];
		document.getElementById('tercer_nota').value = notas_escritas[2];
		document.getElementById('cuarta_nota').value = notas_escritas[3];
		document.getElementById('quinta_nota').value = notas_escritas[4];
		document.getElementById('sexta_nota').value = notas_escritas[5];
		document.getElementById('septima_nota').value = notas_escritas[6];
		document.getElementById('octava_nota').value = notas_escritas[7];
		document.getElementById('novena_nota').value = notas_escritas[8];
		document.getElementById('decima_nota').value = notas_escritas[9];
	} 

	//En el caso de que no se hayan llegado a las 10 notas aún
	else 
	{
		//Lleno quedará en false, permitiendo que se toquen más notas
		lleno = false;
		//Y se deshabilitará el botón de guardar, porque el usuario debe completar las 10 notas
		document.getElementById('guardar').disabled = true;
	}

}





//Con esta función controlaremos todo lo que pase al hacer click sobre lo que mostremos
function mouseClicked(){


	//AL HACER CLICK SOBRE LAS TECLAS ******************************************************************************************************

	//Si el mouse esta dentro de todo el alto de la tecla
	if (mouseY > posy && mouseY < (posy + 120))
	{
		//Recorremos todo el array de notas, para poder ver cual se reproduce
		for (var i = 0; i < notas.length; i++)
		{
			//Si el mouse está dentro del ancho de la tecla
			if(mouseX > posx[i] && mouseX < (posx[i] + ancho_t))
			{ 
				//Y si todavía no se han llegado a las 10 notas
				if(!lleno)
				{
					//Reproducimos el sonido de la tecla tocada
					notas[i].play();

					//Con este switch identificamos que nota se reprodujo para cargar su información
					switch(i){

						//Si fue la tecla 1, se ha tocado 'DO', por lo tanto subiremos su ruta y el sonido al array de melodia (donde se guardan la serie de notas que tocas)
						case 0:
							notas_escritas.push('sonidos/do.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 2, se ha tocado 'DO#'
						case 1:
							notas_escritas.push('sonidos/dos.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 3, se ha tocado 'RE'
						case 2:
							notas_escritas.push('sonidos/re.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 4, se ha tocado 'RE#'
						case 3:
							notas_escritas.push('sonidos/res.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 5, se ha tocado 'MI'
						case 4:
							notas_escritas.push('sonidos/mi.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 6, se ha tocado 'FA'
						case 5:
							notas_escritas.push('sonidos/fa.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 7, se ha tocado 'FA#'
						case 6:
							notas_escritas.push('sonidos/fas.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 8, se ha tocado 'SOL'
						case 7:
							notas_escritas.push('sonidos/sol.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 9, se ha tocado 'SOL#'
						case 8:
							notas_escritas.push('sonidos/sols.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 10, se ha tocado 'LA'
						case 9:
							notas_escritas.push('sonidos/la.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 11, se ha tocado 'SIb'
						case 10:
							notas_escritas.push('sonidos/sib.mp3');
							melodia.push(notas[i]);
							break;

						//Si fue la tecla 12, se ha tocado 'SI'
						case 11:
							notas_escritas.push('sonidos/si.mp3');
							melodia.push(notas[i]);
							break;

					}
				}
			}
		}
	}



	//AL HACER CLICK SOBRE EL SILENCIO ****************************************************************************************************

	//Si hay algo en melodía, es decir, si se ha tocado una tecla y si no se han tocado 10 notas
	if(melodia[0] != null && !lleno)
	{
		//Si además no es la novena nota la actual (para evitar que la última nota sea un silencio)
		if(melodia.length != 9)
		{
			//Entonces, si el mouse está dentro del circulo
			if(mouseX > (silenX - silenW/2) && mouseX < (silenX + silenW/2) && mouseY > (silenY - silenW/2) && mouseY < (silenY + silenW/2))
			{
				//Se agregará NADA como ruta y NADA como nota a melodía
				notas_escritas.push(' ');
				melodia.push(' ');
			}
		}
	}



	//AL HACER CLICK EN REPRODUCIR ********************************************************************************************************

	//Si el mouse está dentro del circulo de reproducción
	if(mouseX > (circulox - circulow/2) && mouseX < (circulox + circulow/2) && mouseY > (circuloy - circulow/2) && mouseY < (circuloy + circulow/2))
	{
		//Se pasará por todo el array de melodía, es decir que recorreremos todas las teclas tocadas hasta el momento
		for (var i = 0; i < melodia.length && i < 10; i++) 
		{
			//En el caso de que sea igual a NADA, que significa silencio, solo dejará correr el tiempo
			//Pero si no...
			if(melodia[i] != ' ')
			{
				//Reproducirá la melodía
				melodia[i].play();
			}

			//Se realiza una espera de 350ms con una función que detallaremos más abajo
			esperar(350);
		}
	}



	//AL HACER CLICK EN BORRAR *************************************************************************************************************

	//Si el mouse está en el ícono de borrar
	else if (mouseX > (circulox+70)-(borrar.width/2) && mouseX < (circulox+70)+(borrar.width/2) && mouseY > circuloy-(borrar.height/2) && mouseY < circuloy+(borrar.height/2))
	{
		//Se quita el último elemento del array de melodía y de notas_escritas(la ruta)
		melodia.pop();
		notas_escritas.pop();
	}



	//AL HACER CLICK EN RESETEAR *************************************************************************************************************

	//Si el mouse está en el ícono de resetear
	else if(mouseX > (circulox-70)-(reset.width/2) && mouseX < (circulox-70)+(reset.width/2) && mouseY > circuloy-(reset.height/2) && mouseY < circuloy+(reset.height/2))
	{
		//Se borra completamente la melodía hecha hasta el momento y, por lo tanto, también todas sus rutas guardadas
		melodia.splice(0, melodia.length);
		notas_escritas.splice(0, notas_escritas.length);
	}
}





//Con esta clase construiremos y mostraremos las teclas
class Tecla {

	//En un constructor pediremos que datos a cada objeto: posición en Y, X y que tipo de tecla es
	constructor(x,y, w, tecla){
		this.x = x;
		this.y = y;
		this.w = w;
		this.tecla = tecla;
	}

	//Con esta función dibujamos las teclas
	display(){

		stroke(0);
  		strokeWeight(2);

  		//En el caso de que el tipo de tecla sea blanca
		if(this.tecla == 'blanca')
			{
				//Las pintamos de blanco y las hacemos largas
				fill(255);
				rect(this.x,this.y,this.w,120)
			}

		//En el caso de que el tipo de tecla sea negra
		else if (this.tecla == 'negra') 
			{
				//Las pintamos de negro y las hacemos cortas
				fill(0);
				rect(this.x,this.y,this.w,90)
			}	
	}
}






//Con esta función creamos el tiempo de espera entre cada nota
function esperar(ms){

	//Tomamos el tiempo exacto al momento que se llama a la función
	var tiempo_actual = new Date().getTime();
	//Y guardamos esa variable es otra
	var tiempo = tiempo_actual;

	//Mientras el tiempo que avanza siga siendo menor al tiempo capturado más la cantidad de milisegundos pasados
	while (tiempo < tiempo_actual + ms){
		//Tiempo se va actualizando
		tiempo = new Date().getTime();
	}

	//Una vez sobrepasado la función termina.
}