from flask import Flask ,jsonify ,request
# del modulo flask importar la clase Flask y los métodos jsonify,request
from flask_cors import CORS       # del modulo flask_cors importar CORS
from flask_sqlalchemy import SQLAlchemy
from flask_marshmallow import Marshmallow


app=Flask(__name__)  # crear el objeto app de la clase Flask

CORS(app) #modulo cors es para que me permita acceder desde el frontend al backend
# configuro la base de datos, con el nombre el usuario y la clave

app.config['SQLALCHEMY_DATABASE_URI']='mysql+pymysql://root:root@localhost/videojuegos'
# URI de la BBDD                      driver de la BD  user:clave@URL/nombreBBDD

app.config['SQLALCHEMY_TRACK_MODIFICATIONS']=False #none
db= SQLAlchemy(app)
ma=Marshmallow(app)
 


# defino la tabla
class Videojuego(db.Model):   # la clase Producto hereda de db.Model     
    id=db.Column(db.Integer, primary_key=True)   #define los campos de la tabla
    nombre=db.Column(db.String(200))
    fecha_publicacion=db.Column(db.String(50))
    descripcion=db.Column(db.String(1000))
    imagen = db.Column(db.String(500))
    sitio_web = db.Column(db.String(500))


    def __init__(self,nombre,fecha_publicacion,descripcion, imagen, sitio_web):   #crea el  constructor de la clase
        self.nombre=nombre   # no hace falta el id porque lo crea sola mysql por ser auto_incremento
        self.fecha_publicacion = fecha_publicacion
        self.descripcion=descripcion
        self.imagen=imagen
        self.sitio_web=sitio_web
 
 
 
with app.app_context():
    db.create_all()  # crea las tablas




#  ************************************************************


class VideojuegoSchema(ma.Schema):
    class Meta:
        fields=('id','nombre','fecha_publicacion','descripcion','imagen', 'sitio_web')
videojuego_schema=VideojuegoSchema()            # para crear un producto
videojuegos_schema=VideojuegoSchema(many=True)  # multiples registros



# crea los endpoint o rutas (json)
@app.route('/videojuegos',methods=['GET'])
def get_Videojuegos():
    all_videojuegos=Videojuego.query.all()     # query.all() lo hereda de db.Model
    result=videojuegos_schema.dump(all_videojuegos)  # .dump() lo hereda de ma.schema
    return jsonify(result)
 


@app.route('/videojuegos/<id>',methods=['GET'])
def get_videojuego(id):
    producto=Videojuego.query.get(id)
    return videojuego_schema.jsonify(producto)




#ELIMINAR
@app.route('/videojuegos/<id>',methods=['DELETE'])
def delete_videojuego(id):
    videojuego=Videojuego.query.get(id)
    db.session.delete(videojuego)
    db.session.commit()
    return videojuego_schema.jsonify(videojuego)


#ACTUALIZAR
@app.route('/videojuegos/<id>' ,methods=['PUT'])
def update_videojuego(id):
    videojuego=Videojuego.query.get(id)
   
    nombre=request.json['nombre']
    fecha_publicacion=request.json['fecha_publicacion']
    descripcion=request.json['descripcion']
    imagen=request.json['imagen']
    sitio_web=request.json['sitio_web']
 
    videojuego.nombre=nombre
    videojuego.fecha_publicacion=fecha_publicacion
    videojuego.descripcion=descripcion
    videojuego.imagen = imagen
    videojuego.sitio_web = sitio_web

    db.session.commit()
    return videojuego_schema.jsonify(videojuego)


#CREAR UNO NUEVO
@app.route('/videojuegos', methods=['POST']) # crea ruta o endpoint
def create_videojuego():
    print(request.json)  # request.json contiene el json que envio el cliente
    
    nombre=request.json['nombre']
    fecha_publicacion=request.json['fecha_publicacion']
    descripcion=request.json['descripcion']
    imagen=request.json['imagen']
    sitio_web=request.json['sitio_web']
   
    new_videojuego=Videojuego(nombre,fecha_publicacion,descripcion,imagen,sitio_web)
    db.session.add(new_videojuego)
    db.session.commit()
    return videojuego_schema.jsonify(new_videojuego)

 
# programa principal *******************************
if __name__=='__main__':  
    app.run(debug=True, port=5000)