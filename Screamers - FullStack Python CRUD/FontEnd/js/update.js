

console.log(location.search)     // lee los argumentos pasados a este formulario
var args = location.search.substr(1).split('&');  
//separa el string por los “&” creando una lista [“id=3” , “nombre=’tv50’” , ”precio=1200”,”stock=20”]
console.log(args)
var parts = []
for (let i = 0; i < args.length; ++i) {
    parts[i] = args[i].split('=');
}
//decodeUriComponent elimina los caracteres especiales que recibe en la URL 
document.getElementById("txtId").value = decodeURIComponent(parts[0][1])
document.getElementById("txtNombre").value = decodeURIComponent(parts[1][1])
document.getElementById("txtFecha").value = decodeURIComponent(parts[2][1])
document.getElementById("txtDescripcion").value =decodeURIComponent(parts[3][1])
document.getElementById("txtImagen").value =decodeURIComponent(parts[4][1])
document.getElementById("txtSitioWeb").value =decodeURIComponent(parts[5][1])

//var ret = decodeURIComponent(parts[4][1]).replace('imagenes/','');
//document.getElementById("txtImagen").files[0].name = ret





function modificar() {
    let id = document.getElementById("txtId").value
    let n = document.getElementById("txtNombre").value
    let f = document.getElementById("txtFecha").value
    let d = document.getElementById("txtDescripcion").value
    let i = document.getElementById("txtImagen").value
    let s = document.getElementById("txtSitioWeb").value
    //let i = "imagenes/" + document.getElementById("txtImagen").files[0].name 


    let videojuego = {
        nombre: n,
        fecha_publicacion:f,
        descripcion:d,
        imagen:i,
        sitio_web:s
    }


    let url = "http://brisadeniseleon.pythonanywhere.com/videojuegos/"+id
    var options = {
        body: JSON.stringify(videojuego),
        method: 'PUT',
        headers: { 'Content-Type': 'application/json' },
        redirect: 'follow'
    }

    fetch(url, options)
        .then(function () {
            console.log("modificado")
            alert("Videojuego actualizado")
            window.location.href = "index.html";  //NUEVO 
        })
        .catch(err => {
            //this.errored = true
            console.error(err);
            alert("Error al Modificar")
        })      
}
