-- Borramos el esquema si ya existe y lo creamos
DROP SCHEMA IF EXISTS estudiantes;
CREATE SCHEMA IF NOT EXISTS estudiantes;
USE estudiantes;



-- Tabla 'carrera'
DROP TABLE IF EXISTS carrera;
CREATE TABLE IF NOT EXISTS carrera (
  `codcarrera` INT NOT NULL,
  `nombcarrera` VARCHAR(45) NOT NULL,
  `modalidad` SET('presencial', 'virtual', 'semi-presencial') NOT NULL,
  `titulo_otorgado` VARCHAR(35) NOT NULL,
  `nombdepto` VARCHAR(45) NULL DEFAULT NULL,
  `cupo` INT NOT NULL,
  `bloque` ENUM('mañana', 'tarde', 'noche') NOT NULL,
  `matricula_idmatricula` INT NOT NULL,
  PRIMARY KEY (`codcarrera`),
  INDEX `matricula_idmatricula_idx` (`matricula_idmatricula` ASC) VISIBLE,
  CONSTRAINT `carrera_ibfk_1`
    FOREIGN KEY (`matricula_idmatricula`)
    REFERENCES `matricula` (`idmatricula`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

DROP TABLE IF EXISTS persona;
CREATE TABLE IF NOT EXISTS persona (
  `idpersona` CHAR(8) NOT NULL,  -- Clave primaria para la persona
  `nombre` VARCHAR(50) NOT NULL,  -- Nombre de la persona
  `apellido` VARCHAR(50) NOT NULL,  -- Apellido de la persona
  `departamento` VARCHAR(50) DEFAULT NULL,  -- Departamento (opcional)
  `municipio` VARCHAR(50) NOT NULL,  -- Municipio (obligatorio)
  `nivelacademico` ENUM('Primaria', 'Secundaria', 'Universidad', 'Postgrado') DEFAULT NULL,  -- Nivel académico
  `matricula_idmatricula` INT NOT NULL,  -- Referencia a la tabla de matrícula
  PRIMARY KEY (`idpersona`)  -- Clave primaria
);

-- Tabla 'componentes'
DROP TABLE IF EXISTS componentes;

CREATE TABLE IF NOT EXISTS componentes (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nombre` VARCHAR(200) NOT NULL,
  `codcarrera` VARCHAR(50) NOT NULL,
  `anio` VARCHAR(50) NOT NULL,
  `creditos` INT NOT NULL,
  PRIMARY KEY (`id`)
);
-- Tabla 'matricula'
DROP TABLE IF EXISTS matricula;
CREATE TABLE IF NOT EXISTS matricula (
  `idmatricula` INT NOT NULL AUTO_INCREMENT,
  `codcarrera` VARCHAR(9) NOT NULL,
  `idpersona` VARCHAR(9) NOT NULL,
  `aniolectivo` INT NULL DEFAULT NULL,
  `anio` INT NULL DEFAULT NULL,
  `situacion` VARCHAR(45) NOT NULL,
  PRIMARY KEY (`idmatricula`),
	FOREIGN KEY (`idmatricula`)
    REFERENCES `persona` (`idpersona`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);

DROP TABLE IF EXISTS inscripcion;

CREATE TABLE IF NOT EXISTS inscripcion (
  `id` INT NOT NULL AUTO_INCREMENT,
  `persona_id` CHAR(8) NOT NULL,
  `componente_id` INT NOT NULL,
  PRIMARY KEY (`id`),
  INDEX `persona_id_idx` (`persona_id` ASC) VISIBLE,
  INDEX `componente_id_idx` (`componente_id` ASC) VISIBLE,
  CONSTRAINT `inscripcion_ibfk_1`
    FOREIGN KEY (`persona_id`)
    REFERENCES `persona` (`idpersona`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `inscripcion_ibfk_2`
    FOREIGN KEY (`componente_id`)
    REFERENCES `componentes` (`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE
);


DELIMITER //
CREATE PROCEDURE guardar(
    IN p_Identificacion VARCHAR(50),
    IN p_Nombre VARCHAR(50),
    IN p_Apellido VARCHAR(50),
    IN p_Departamento VARCHAR(50),
    IN p_Municipio VARCHAR(50),
    IN p_NivelAcademico ENUM('Primaria', 'Secundaria', 'Universidad', 'Postgrado')
)
BEGIN
    INSERT INTO persona (idpersona, nombre, apellido, departamento, municipio, nivelacademico)
    VALUES (p_Identificacion, p_Nombre, p_Apellido, p_Departamento, p_Municipio, p_NivelAcademico);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE cargar()
BEGIN
    SELECT idpersona , nombre , apellido FROM persona;
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE FiltrarPersonas(IN p_Filtro VARCHAR(50))
BEGIN
    SELECT *  FROM persona p 
    WHERE nombre LIKE CONCAT('%', p_Filtro, '%') 
       OR idpersona LIKE CONCAT('%', p_Filtro, '%');
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GuardarComponente(
    IN p_Nombre VARCHAR(200),
    IN p_CodCarrera VARCHAR(50),
    IN p_Anio VARCHAR(50),
    IN p_Creditos INT,
    IN p_InscripcionID INT
)
BEGIN
    INSERT INTO componentes (nombre, codcarrera, anio, creditos, inscripcion_id)
    VALUES (p_Nombre, p_CodCarrera, p_Anio, p_Creditos, p_InscripcionID);
END //
DELIMITER ;

DELIMITER //
CREATE PROCEDURE GuardarMatricula(
    IN p_CodCarrera VARCHAR(9),
    IN p_IdPersona VARCHAR(9),
    IN p_AnioLectivo INT,
    IN p_Anio INT,
    IN p_Situacion VARCHAR(45)
)
BEGIN
    INSERT INTO matricula (codcarrera, idpersona, aniolectivo, anio, situacion)
    VALUES (p_CodCarrera, p_IdPersona, p_AnioLectivo, p_Anio, p_Situacion);
END //
DELIMITER ;



INSERT INTO persona (idpersona, nombre, apellido, departamento, municipio, nivelacademico, matricula_idmatricula)
VALUES 
('12345678', 'Juan', 'Pérez', 'San Salvador', 'San Salvador', 'Universidad', 1),
('87654321', 'Ana', 'González', 'La Libertad', 'Santa Tecla', 'Secundaria', 2),
('11223344', 'Luis', 'Martínez', 'Chalatenango', 'Chalatenango', 'Primaria', 3),
('55667788', 'María', 'Rodríguez', 'San Miguel', 'San Miguel', 'Postgrado', 4),
('33445566', 'Carlos', 'López', 'Cuscatlán', 'Cojutepeque', 'Universidad', 5);


INSERT INTO carrera (codcarrera, nombcarrera, modalidad, titulo_otorgado, nombdepto, cupo, bloque, matricula_idmatricula)
VALUES (1, 'Ingeniería Informática', 'presencial', 'Ingeniero en Informática', 'Ciencias Exactas', 50, 'mañana', 1),
       (2, 'Administración de Empresas', 'virtual', 'Licenciado en Administración', 'Ciencias Económicas', 30, 'noche', 2),
       (3, 'Psicología', 'semi-presencial', 'Licenciado en Psicología', 'Ciencias Humanas', 40, 'tarde', 3),
       (4, 'Medicina', 'presencial', 'Doctor en Medicina', 'Ciencias de la Salud', 35, 'mañana', 4),
       (5, 'Derecho', 'presencial', 'Abogado', 'Ciencias Jurídicas', 25, 'tarde', 5);
INSERT INTO matricula (codcarrera, idpersona, aniolectivo, anio, situacion)
VALUES ('CAR001', '12345678', 2024, 2023, 'Activo'),
       ('CAR002', '87654321', 2024, 2023, 'Activo'),
       ('CAR003', '11223344', 2023, 2022, 'Graduado'),
       ('CAR004', '55667788', 2022, 2021, 'Activo'),
       ('CAR005', '33445566', 2023, 2022, 'Retirado');

INSERT INTO componentes (nombre, codcarrera, anio, creditos)
VALUES ('Programación Avanzada', 'CAR001', '2023', 4),
       ('Contabilidad General', 'CAR002', '2023', 3),
       ('Psicología Clínica', 'CAR003', '2022', 5),
       ('Anatomía Humana', 'CAR004', '2021', 6),
       ('Derecho Penal', 'CAR005', '2022', 4);

INSERT INTO inscripcion (persona_id, componente_id) 
VALUES 
('12345678', 1), 
('87654321', 2), 
('11223344', 3), 
('55667788', 4), 
('33445566', 5);
