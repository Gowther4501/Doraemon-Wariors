-- Crear la base de datos

CREATE DATABASE if not exists practica2;
USE practica2;

-- Crear la tabla persona
CREATE TABLE if not exists usuario (
    id_cliente INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombres VARCHAR(40),
    apellidos varchar(40),
    fecha_nacimiento DATE,
    sexo VARCHAR(10)
);

-- Crear la tabla login
CREATE TABLE if not exists login (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    Usuario VARCHAR(50),
    Contraseña VARCHAR(255),
	rol enum ('root','user') default 'user', 
    FOREIGN KEY (id_cliente) REFERENCES usuario(id_cliente)
);
CREATE TABLE IF NOT EXISTS perfil (
    id INT NOT NULL  primary key,
    foto VARCHAR(255),
    email varchar(50),
	telefono VARCHAR(20),
    FOREIGN KEY (id) REFERENCES usuario(id_cliente) ON DELETE CASCADE
);

-- Crear la tabla respuestas
CREATE TABLE if not exists respuestas (
    id_respuesta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id INT NOT NULL,
    Nivelacademic varchar(15),
    Centro_de_estudio VARCHAR(100),
	pregunta1 VARCHAR(15),
	pregunta2 VARCHAR(15),
	pregunta3 VARCHAR(15),
	pregunta4 VARCHAR(15),
	pregunta5 VARCHAR(15),
	pregunta6 VARCHAR(15),
	pregunta7 VARCHAR(10),
    comentario varchar(255),
    fecha Date,
    FOREIGN KEY (id) REFERENCES usuario(id_cliente)
);


