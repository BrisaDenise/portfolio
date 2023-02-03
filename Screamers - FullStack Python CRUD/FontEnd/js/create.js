function guardar() {
 
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
    
    let url = "http://brisadeniseleon.pythonanywhere.com/videojuegos"
    var options = {
        body: JSON.stringify(videojuego),
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
       // redirect: 'follow'
    }
    fetch(url, options)
        .then(function () {
            console.log("creado")
            alert("Videojuego agregado")
            window.location.href = "index.html";  //NUEVO  
            // Handle response we get from the API
        })
        .catch(err => {
            //this.errored = true
            alert("Error al grabar" )
            console.error(err);
        })
 
}
