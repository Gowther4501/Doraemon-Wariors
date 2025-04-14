drop database  if exists DBLogin;
create database DBLogin;
Use DBLogin;

create table Usuario(
IdUsuario int primary key AUTO_INCREMENT,
NombreUsuario varchar(50),
Correo varchar(50),
Clave varchar(100)
);
create table productos(
	id int not null,
    nombre varchar(25),
    cantidad int ,
    precio float
	
);

create table proveedor(
id_proveedor int ,
nombre varchar(25) ,
productos varchar(35)
);
INSERT INTO productos (id, nombre, cantidad, precio) VALUES
(1, 'Laptop', 10, 999.99),
(2, 'Mouse', 50, 25.50),
(3, 'Teclado', 30, 45.75),
(4, 'Monitor', 15, 199.99),
(5, 'Auriculares', 20, 79.99),
(6, 'Impresora', 5, 129.99),
(7, 'Webcam', 12, 59.99),
(8, 'Parlantes', 25, 89.99),
(9, 'Cable HDMI', 40, 15.99),
(10, 'Disco Duro', 8, 120.00);
INSERT INTO proveedor (id_proveedor, nombre, productos) VALUES
(1, 'ElectroWorld', 'Laptop, Mouse, Teclado'),
(2, 'Gadgets Inc.', 'Monitor, Auriculares, Webcam'),
(3, 'Tech Supplies', 'Impresora, Cable HDMI, Disco Duro'),
(4, 'Computer Central', 'Laptop, Monitor, Disco Duro'),
(5, 'AudioGear', 'Auriculares, Parlantes'),
(6, 'ScreenVision', 'Monitor, Webcam'),
(7, 'PeripheralPlus', 'Mouse, Teclado, Cable HDMI'),
(8, 'TechZone', 'Webcam, Auriculares'),
(9, 'GizmoMart', 'Parlantes, Mouse, Teclado'),
(10, 'Digital Dynamics', 'Laptop, Disco Duro, Cable HDMI');
