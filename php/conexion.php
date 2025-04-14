<?php
$servidor = "localhost";   // o la dirección IP del servidor
$usuario = "root";          // tu nombre de usuario de MySQL
$clave = "123qwe";                // tu contraseña de MySQL
$base_datos = "practica2";  // el nombre de la base de datos a la que te quieres conectar

// Crear conexión
$conn = new mysqli($servidor, $usuario, $clave, $base_datos);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}