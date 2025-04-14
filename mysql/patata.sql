create database if not exists patata;
use patata;
-- crear tablas 
create table if not exists login (
	id int not null auto_increment primary key,
    usuario varchar(50) ,
    contrasena varchar(255)
);

create table if not exists registro(
	user_id int not null auto_increment,
	nombre varchar(20),
    apellido varchar (20),
    nacimiento date,
    usuario varchar (50),
    contrasena varchar(255),
    foreign key (user_id) references login(id) 

);
alter table registro 
add column email varchar(25) after usuario;