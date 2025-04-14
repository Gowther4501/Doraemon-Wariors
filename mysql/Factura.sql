DROP SCHEMA IF EXISTS Factura;
Create schema Factura;
USE Factura ;

DROP TABLE IF EXISTS Factura;
CREATE TABLE IF NOT EXISTS Factura(
  `id` INT NOT NULL auto_increment,
  `Nombre_cliente` VARCHAR(45) NULL,
  `fecha` VARCHAR(45) NOT NULL,
  `Formpago` INT NULL,
  `TipoTarjeta` INT NULL,
  `Nombrebanco` VARCHAR(45) NULL,
  `Numtarjeta` VARCHAR(45) NULL,
  Numcuenta VARCHAR(45) NULL,
  PRIMARY KEY (`id`));


DROP TABLE IF EXISTS Productos;
CREATE TABLE IF NOT EXISTS Productos (
  `ProductosId` INT NOT NULL auto_increment,
  `Nombre` VARCHAR(45) NULL,
  `Precio` FLOAT NULL,
  `Descripcion` VARCHAR(200) NULL,
  PRIMARY KEY (`ProductosId`));

DROP TABLE IF EXISTS detallefactura ;
CREATE TABLE IF NOT EXISTS detallefactura (
  `Detalleid` INT NOT NULL auto_increment,
  `Cantidad` VARCHAR(45) NULL,
  `Montoporproducto` VARCHAR(45) NULL,
  `Productos_ProdcutosID` INT NOT NULL,
  `Factura_FacturaID` INT NOT NULL,
  PRIMARY KEY (`Detalleid`),
  CONSTRAINT `Factura_FacturaID` 
  FOREIGN KEY (`Factura_FacturaID`)REFERENCES Factura(`id`)
    ON DELETE CASCADE
    ON UPDATE CASCADE,
  CONSTRAINT `Productos_ProdcutosID`
    FOREIGN KEY (`Productos_ProdcutosID`) REFERENCES Productos (`ProductosId`)
    ON DELETE CASCADE
    ON UPDATE CASCADE)
;

INSERT INTO Productos (Nombre, Precio, Descripcion) VALUES
('Laptop', 799.99, 'Laptop de 15 pulgadas con 16GB de RAM'),
('Smartphone', 499.99, 'Smartphone con cámara de 48MP y 128GB de almacenamiento'),
('Tablet', 299.99, 'Tablet de 10 pulgadas ideal para leer y navegar'),
( 'Auriculares', 89.99, 'Auriculares inalámbricos con cancelación de ruido'),
( 'Teclado mecánico', 129.99, 'Teclado mecánico RGB para gamers');



INSERT INTO Factura (id, Nombre_cliente, fecha, Formpago, TipoTarjeta, Nombrebanco, Numtarjeta, Numcuenta) 
VALUES (1, 'Juan Pérez', '2024-10-08', 1, NULL, NULL, NULL, NULL);
INSERT INTO detallefactura (Cantidad, Montoporproducto, Productos_ProdcutosID, Factura_FacturaID) 
VALUES (2, 500.00, 1, 1);

DELIMITER $$
CREATE PROCEDURE MostrarTodasLasFacturas()
BEGIN
    SELECT id as Idfactura, Nombre_Cliente as Cliente, Formpago as Forma_De_Pago,
    TipoTarjeta as tarjeta , Nombrebanco as Banco ,Numtarjeta as Numero_de_tarjeta,
    Numcuenta as Cuenta FROM Factura;
END$$
DELIMITER ;

DELIMITER $$
CREATE PROCEDURE filtrar(IN nombreProducto VARCHAR(100))
BEGIN
    SELECT Factura.*
    FROM Factura
    INNER JOIN detallefactura ON Factura.id = detallefactura.Factura_FacturaID
    INNER JOIN Productos ON detallefactura.Productos_ProdcutosID = Productos.ProductosId
    WHERE Productos.Nombre LIKE CONCAT('%', nombreProducto, '%');
END$$
DELIMITER ;



DELIMITER //
CREATE PROCEDURE InsertarProducto(
    IN p_Nombre VARCHAR(45),
    IN p_Precio FLOAT,
    IN p_Descripcion VARCHAR(200)
)
BEGIN
    INSERT INTO Productos (
        Nombre, Precio, Descripcion
    ) VALUES (
        p_Nombre, p_Precio, p_Descripcion
    );
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE InsertarFactura(
    IN p_NombreCliente VARCHAR(45),
    IN p_Fecha DATE,
    IN p_FormPago INT,
    IN p_TipoTarjeta INT,
    IN p_NombreBanco VARCHAR(45),
    IN p_NumTarjeta VARCHAR(45),
    IN p_NumCuenta varchar(45)
)
BEGIN
    -- Insertar la factura en la base de datos
    INSERT INTO Factura (Nombre_cliente, fecha, Formpago, TipoTarjeta, Nombrebanco, Numtarjeta, Numcuenta)
    VALUES (p_NombreCliente, p_Fecha, p_FormPago, p_TipoTarjeta, p_NombreBanco, p_NumTarjeta, p_NumCuenta);
    
    -- Obtener el último ID insertado
    SELECT LAST_INSERT_ID() AS FacturaID;
END //
DELIMITER ;


DELIMITER //
CREATE PROCEDURE InsertarDetalleFactura(
    IN p_Cantidad INT,                       -- Cambiado a tipo INT
    IN p_Montoporproducto DECIMAL(10, 2),    -- Cambiado a tipo DECIMAL
    IN Nom VARCHAR(45),
    IN p_Factura_FacturaID INT
)
BEGIN
    -- Declarar variable para el ID del producto
    DECLARE p_ProductosID INT;
    
    -- Obtener el ID del producto basado en el nombre
    SELECT ProductosID 
    INTO p_ProductosID 
    FROM productos 
    WHERE Nombre = Nom;
    
    -- Insertar el detalle de la factura
    INSERT INTO detallefactura (
        Cantidad, Montoporproducto, Productos_ProdcutosID, Factura_FacturaID
    ) 
    VALUES (
        p_Cantidad, p_Montoporproducto, p_ProductosID, p_Factura_FacturaID
    );
END //

DELIMITER ;



CALL InsertarFactura('Juan Perez', '2024-10-01', 2, 1, 'BDF', '1234567890123456', 987654321);
CALL InsertarProducto('Mayonesa', 100.00, 'Ella me bate como si fuera');
drop procedure ObtenerProductosPorFactura;
DELIMITER //
CREATE PROCEDURE ObtenerProductosPorFactura(
    IN p_FacturaID INT
)
BEGIN
    SELECT p.Nombre, df.Cantidad, df.Montoporproducto
    FROM detallefactura df
    JOIN productos p ON df.Productos_ProdcutosID = p.ProductosId
    WHERE df.Factura_FacturaID = p_FacturaID;
END //
DELIMITER ;






