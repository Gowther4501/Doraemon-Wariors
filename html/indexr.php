<?php
session_start();
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'root') {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panel de Administrador</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/indexu.css">
</head>
<body>
<div class="navbar">
        <div>
            <a href="indexr.php"><i class="fas fa-chevron-down"></i>Inicio</a>
            <a href="encuesta.php"><i class="fas fa-chevron-down"></i>Realizar Encuesta</a>
            <a href="datos.php"><i class="fas fa-chevron-down"></i>Datos Encuesta</a>
            <a href="reportes.php"><i class="fas fa-chevron-down"></i>Reportes</a>
            <a href="login.php"><i class="fas fa-chevron-down"></i>Nuevo Usuario</a>
        </div>

        <div id="cerrar">
            <form method="post" action="../php/cerrar.php">
                <button type="submit"><i class="fas fa-sign-out-alt"></i></button>
            </form>
        </div>
        <div>
            <a href="perfil.php" class="user"><i class="fas fa-user"></i></a>
        </div>

        <div class="logo">
            <img src="../img/logo_momen.ico" alt="Logo"> 
        </div>
    </div>

    <br><br><br>
   <center> <h1>Bienvenido, Administrador</h1></center>
    
</body>
</html>
