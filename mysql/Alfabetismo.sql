-- Crear la base de datos
CREATE DATABASE if not exists Analfabetismo;
USE Analfabetismo;

-- Crear la tabla persona
CREATE TABLE if not exists persona (
    id_cliente INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    Nombrecompleto VARCHAR(80),
    edad INT,
    sexo VARCHAR(10),
    departamento VARCHAR(20),
    municipio VARCHAR(20),
    encuestado TINYINT(1) DEFAULT 0
);

-- Crear la tabla respuestas
CREATE TABLE if not exists respuestas (
    id_respuesta INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
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
    FOREIGN KEY (id_cliente) REFERENCES persona(id_cliente)
);

-- Crear la tabla login
CREATE TABLE if not exists login (
    id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_cliente INT NOT NULL,
    Usuario VARCHAR(50),
    Contraseña VARCHAR(255),
    rol enum ('admin','user'),
    FOREIGN KEY (id_cliente) REFERENCES persona(id_cliente)
);
CREATE TABLE IF NOT EXISTS perfil (
    id_cliente INT NOT NULL,
    foto VARCHAR(255),
    email varchar(50),
     telefono VARCHAR(20),
    direccion VARCHAR(255),
    fecha_nacimiento DATE,
    descripcion TEXT,
    PRIMARY KEY (id_cliente),
    FOREIGN KEY (id_cliente) REFERENCES persona(id_cliente) ON DELETE CASCADE
);


INSERT INTO persona (Nombrecompleto, edad, sexo, departamento, municipio) VALUES 
('Juan Pérez', 25, 'Masculino', 'Managua', 'Managua'),
('María Gómez', 32, 'Femenino', 'Chinandega', 'Chinandega'),
('Carlos López', 45, 'Masculino', 'Granada', 'Granada'),
('Ana Martínez', 28, 'Femenino', 'León', 'León'),
('José García', 37, 'Masculino', 'Rivas', 'San Juan del Sur'),
('Laura Rodríguez', 40, 'Femenino', 'Matagalpa', 'Matagalpa'),
('Pedro Fernández', 23, 'Masculino', 'Carazo', 'Diriamba'),
('Sofía Hernández', 29, 'Femenino', 'Estelí', 'Estelí'),
('Luis Castro', 31, 'Masculino', 'Boaco', 'Boaco'),
('Valeria Morales', 34, 'Femenino', 'Nuevas Segovia', 'Jinotega');

INSERT INTO persona (Nombrecompleto, edad, sexo, departamento, municipio) VALUES 
('Ricardo Silva', 26, 'Masculino', 'Managua', 'Tipitapa'),
('Isabel Torres', 30, 'Femenino', 'Chinandega', 'El Viejo'),
('Andrés Morales', 33, 'Masculino', 'León', 'Chinandega'),
('Paola Jiménez', 27, 'Femenino', 'Granada', 'Nandaime'),
('Samuel Martínez', 38, 'Masculino', 'Rivas', 'Rivas');

INSERT INTO login (id_cliente, Usuario, Contraseña) VALUES 
(9, 'juanperez', '5e884898da28047151d0e56f8dc6292773603d0d4e0b9e0e5c47a68e0d8c80a7'), -- hashed 'password'
(10, 'mariagomez', '6b3a55e026d4a4d3b79b383c9c1d1b6454ae56a2b99ad7e9f1f3a8a6716dc5c8'), -- hashed '123456'
(11, 'carloslopez', '8d969eef6ecad3c29a3a629280e686cf'), -- hashed 'password1'
(12, 'anamartinez', '202cb962ac59075b964b07152d234b70'), -- hashed '123'
(13, 'josegarcia', '25d55ad283aa400af464c76d713c07ad'), -- hashed 'password123'
(14, 'laurarodriguez', '6b4f2b2cb0b04a56e72d3d6c8d0c42f8'), -- hashed 'abc123'
(15, 'pedrofernandez', '1d2d2d4b2e8ddf4a2f5e2c3b765e3b39'), -- hashed 'letmein'
(16, 'sofiahernandez', 'ecb64bba1c2481a2b689c63d11fc0439'), -- hashed 'qwerty'
(17, 'luiscastro', '7c6a180b36896a0a8c02787eeafb0e4c'), -- hashed 'welcome'
(18, 'valeriamorales', '5f4dcc3b5aa765d61d8327deb882cf99'), -- hashed 'password'
(19, 'ricardosilva', '6c5e84f6e4c6b9f3c7cbb74b4a5b3b1b'), -- hashed 'mysecurepassword'
(20, 'isabeltorres', '2e4fdf6f72b4b4a0dd5c9b72e4b9b76d'), -- hashed 'admin123'
(21, 'andresmorales', '4b8a8e4d3a4b6b7a4c4d0d546a8e3b6e'), -- hashed 'userpassword'
(22, 'paolajimenez', '5a5a9e4a6c6b8b6c4d0d6b9e3d3e7f3c'), -- hashed 'securepass'
(23, 'samuelmartinez', 'e1d6dcd92f6e42d22a62b7b8f1b77b3d'); -- hashed 'password2024'


INSERT INTO respuestas (id_cliente, Nivelacademic, Centro_de_estudio, pregunta1, pregunta2, pregunta3, pregunta4, pregunta5, pregunta6, pregunta7, comentario) VALUES
(9, 'Universidad', 'Universidad Nacional de Nicaragua', 'frecuentemente', 'excelente', 'si', 'si', 'si', 'generalmente', 'buena', 'Muy buen formulario'),
(10, 'Secundaria', 'Instituto Nacional de Chinandega', 'ocasionalmente', 'buena', 'no', 'si', 'no', 'a menudo', 'buena', 'Necesita más preguntas'),
(11, 'Primaria', 'Colegio San Francisco', 'nunca', 'deficiente', 'si', 'no', 'no', 'casi nunca', 'regular', 'Buena para empezar'),
(12, 'técnico', 'Centro Técnico de León', 'frecuentemente', 'buena', 'no', 'si', 'si', 'generalmente', 'excelente', 'Recomiendo agregar más opciones'),
(13, 'Universidad', 'Universidad de León', 'ocasionalmente', 'regular', 'si', 'no', 'si', 'a menudo', 'buena', 'El formulario es claro'),
(14, 'Secundaria', 'Instituto de Estelí', 'rara_vez', 'excelente', 'no', 'si', 'no', 'casi nunca', 'regular', 'Podría ser más detallado'),
(15, 'Primaria', 'Colegio San Juan', 'nunca', 'deficiente', 'si', 'si', 'no', 'generalmente', 'deficiente', 'Falta más información'),
(16, 'técnico', 'Centro de Formación Técnica de Rivas', 'frecuentemente', 'buena', 'no', 'no', 'si', 'a menudo', 'buena', 'Preguntas bastante acertadas'),
(17, 'Universidad', 'Universidad Nacional Autónoma de Nicaragua', 'ocasionalmente', 'buena', 'si', 'si', 'no', 'casi nunca', 'regular', 'Un formulario completo'),
(18, 'Secundaria', 'Colegio de Managua', 'rara_vez', 'regular', 'no', 'no', 'si', 'a menudo', 'excelente', 'Muy útil para entender habilidades'),
(19, 'Primaria', 'Colegio San Pedro', 'frecuentemente', 'buena', 'si', 'si', 'si', 'generalmente', 'buena', 'Excelente encuesta, muy completa'),
(20, 'técnico', 'Instituto Técnico de Jinotepe', 'ocasionalmente', 'regular', 'no', 'no', 'si', 'a menudo', 'regular', 'Interesante, pero podría ser más extensa'),
(21, 'Secundaria', 'Colegio Los Robles', 'rara_vez', 'deficiente', 'si', 'si', 'no', 'casi nunca', 'deficiente', 'Falta más claridad en algunas preguntas'),
(22, 'Universidad', 'Universidad Nacional de Ingeniería', 'frecuentemente', 'excelente', 'no', 'si', 'si', 'generalmente', 'excelente', 'Formulario muy útil para evaluar habilidades'),
(23, 'Primaria', 'Colegio Santa Teresa', 'nunca', 'buena', 'si', 'no', 'no', 'a menudo', 'buena', 'Buen diseño, pero faltan opciones para algunos campos');

SET SQL_SAFE_UPDATES = 0;
UPDATE login
SET rol = 'user'
WHERE rol IS NULL;
SET SQL_SAFE_UPDATES = 1;
