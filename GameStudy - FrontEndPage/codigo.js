

$(document).ready(function(){




	//botones en computadora

	$(".general_genero button").click(function(){

		var clase = this.getAttribute('class');

		$("div."+ clase).toggle('slow');

	});



	//bajar al apretar un a en nav


	$("a").click(function(){

		var donde_ir = this.getAttribute('href');

		$('html, body').animate({
			scrollTop:$(donde_ir).offset().top}, 2000);

	});



	//Desvanecer botón de subir segun distancia

	$(window).scroll(function(){

	    if ($(this).scrollTop() > 400) { 
	        $('#volver').fadeIn(); 
	    } 

	    else { 
	        $('#volver').fadeOut(); 
	    } 

	});



	//Subir arriba de todo

	$("#volver").click(function(){
		$('html, body').animate({scrollTop:0}, 1000);
	});




	$('div#titulo_principal').fadeIn(3000);
	$('section.pagina_principal').fadeIn(3000);



});







function validarContacto()
{

	var nombre_ = document.contacto_form.nombre.value;
	var apellido_ = document.contacto_form.apellido.value;
	var correo_ = document.contacto_form.correo.value;
	var asunto_ = document.getElementById('asunto').options.selectedIndex;
	var comentarios_ = document.contacto_form.comentarios.value;

	var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;


	if(nombre_.lenght==0 || !isNaN(nombre_))
	{
		document.contacto_form.nombre.style.backgroundColor = 'rgb(255,166,162)';
		document.getElementById('alerta_nombre').style.display = 'block';
		document.contacto_form.nombre.focus();
		return false;
	}


	else if (apellido_.lenght==0 || !isNaN(apellido_)) 
	{
		document.contacto_form.apellido.style.backgroundColor = 'rgb(255,166,162)';
		document.getElementById('alerta_apellido').style.display = 'block';
		document.contacto_form.apellido.focus();
		return false;
	}


	else if( !(ck_email.test(correo_)) ) 
	{
	 	document.contacto_form.correo.style.backgroundColor = 'rgb(255,166,162)';
	 	document.getElementById('alerta_correo').style.display = 'block';
	 	document.contacto_form.correo.focus();
	 	return false;
	}



	else if(asunto_==0)
	{
		document.contacto_form.asunto.style.backgroundColor = 'rgb(255,166,162)';
		document.getElementById('alerta_asunto').style.display = 'block';
		document.contacto_form.asunto.focus();
		return false;
	}

	else if(comentarios_.lenght==0 || !isNaN(comentarios_))
	{
		document.contacto_form.comentarios.style.backgroundColor = 'rgb(255,166,162)';
		document.getElementById('alerta_comentarios').style.display = 'block';
		document.contacto_form.comentarios.focus();
		return false;
	}
	

	else{

		document.getElementById('agradecer_contactar').style.display = 'block';
		document.getElementById('contacto_form').style.display = 'none';
	}
}


function subscribir()
{
	var correo_electronico_usuario = document.subscripcion_form.correo_electronico.value;

	var ck_email = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/;

	if( !(ck_email.test(correo_electronico_usuario)) ) 
	{
	 	document.getElementById('alerta_correo_subscripcion').style.display = 'block';
	 	document.subscripcion_form.correo_electronico.focus();
	 	return false;
	}

	else{

		document.getElementById('agradecer_subscribir').style.display = 'block';
		document.getElementById('subscripcion_form').style.display = 'none';
	}

}











//Galeria

var i=1;

function control(estado)
{

	if (estado == 'avanzar') 
	{
		if (i==6) 
		{
			document.getElementById('mostrar_'+i).style.display='none';
			i=1;
			document.getElementById('mostrar_'+i).style.display='block';

		}


		else{

			document.getElementById('mostrar_'+i).style.display='none';
			document.getElementById('mostrar_'+(i+1)).style.display='block';

			i++;

		}
	}

	else if (estado== 'retroceder')
	{
		if (i==1) 
		{
			document.getElementById('mostrar_'+i).style.display='none';
			i=6;
			document.getElementById('mostrar_'+i).style.display='block';

		}


		else{

			document.getElementById('mostrar_'+i).style.display='none';
			document.getElementById('mostrar_'+(i-1)).style.display='block';

			i= i-1;

		}
	}

	

}










//JUEGO TRIVIA

var respuestas_reales = new Array ('Nim','Ralph Baer','Sega y Nintendo', 'Alemania', 'Jaguar', 'PlayStation 2', 'ET', 'NES', 'Gráfica', 'Gamejolt', 'Panasonic Q', 'TV Tennis Electrotennis', 'Dina', '1993', 'Naipes', 'Nintendo Switch', 'MMORPG', 'Blizzcon', 'E3','Super Mario Bros.');

var r = 0;

var errores = 0;

var estrellitas = 0;

function jugar()
{

	var respuesta_ingresada = document.getElementById('respuesta_'+r).value;

	var estrellas = document.getElementById('casa_estrellitas').innerHTML;




	if (respuesta_ingresada == respuestas_reales[r])
	{
		document.getElementById('casa_estrellitas').innerHTML = estrellas + '<img src="imagenes/estrellita.gif" alt="estrellita'+r+'">';
		estrellitas++;

	}

	else {

		errores++;
		document.getElementById('vida_'+errores).src= 'imagenes/roto.gif';
	}

	document.getElementById('pregunta_'+r+'_').style.display = 'none';
	document.getElementById('respuesta_'+r).value='';


	if (r<19) 
	{

		r++;

		document.getElementById('pregunta_'+r+'_').style.display = 'block';

	}

	else if (r==19) 
	{
		document.getElementById('pregunta_'+r+'_').style.display = 'none';
		document.getElementById('mensaje').style.display='block';
		document.getElementById('ingresar_respuesta').style.display='none';
		document.getElementById('mensaje').innerHTML = '<p>WOOOOOOOOW</p><p>ERES GENIAL. TOMA, TE LO MERECES</p><img src="imagenes/trofeo.gif" alt="trofeo">';
		document.getElementById('casa_estrellitas').innerHTML = estrellas + '<br> <p>Mira todas esas estrellitas... MÁXIMA DECORACIÓN</p>';

	}

	


	


	if(errores==3)
	{

		document.getElementById('pregunta_'+r+'_').style.display = 'none';
		document.getElementById('mensaje').style.display='block';
		document.getElementById('mensaje').innerHTML = '<p><strong>GAME OVER</strong></p><p>Hm...</p><p>Siempre se puede volver a intentar ¿no?</p>';
		document.getElementById('ingresar_respuesta').style.display='none';
		document.getElementById('reintento'). style.display='block';

		if (estrellitas==0) 
		{
			document.getElementById('casa_estrellitas').innerHTML = ':(';

		}
	}

	

}


function reintentar() 
{
	document.getElementById('mensaje').style.display= 'none';
	document.getElementById('reintento'). style.display='none';
	document.getElementById('pregunta_0_').style.display = 'block';
	document.getElementById('ingresar_respuesta').style.display='block';
	document.getElementById('casa_estrellitas').innerHTML='';
	document.getElementById('vida_1').src= 'imagenes/corazon.gif';
	document.getElementById('vida_2').src= 'imagenes/corazon.gif';
	document.getElementById('vida_3').src= 'imagenes/corazon.gif';



	r = 0;
	errores=0;
	estrellitas=0;
}








