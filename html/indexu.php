<?php
session_start(); 
if (!isset($_SESSION['id']) || $_SESSION['rol'] !== 'user') {
    header("Location: login.php"); 
    exit(); 
}
$id_cliente = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="../css/indexu.css">
    <title>Inicio</title>

</head>
<body>
    <div class="navbar">
        <div>
            <a href="indexu.php"><i class="fas fa-chevron-down"></i>Inicio</a>
            <a href="info.php"><i class="fas fa-chevron-down"></i>Info</a>
            <a href="encuesta.php"><i class="fas fa-chevron-down"></i>Encuesta</a>
            <a href="../php/mostrar_resultados.php"><i class="fas fa-chevron-down"></i>Resultados</a>
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

    <div class="info-container">
        <div class="info-text">
            <h1>ANALFABETISMO EN NICARAGUA</h1>
            <p>
                Nicaragua ha hecho avances significativos en la reducción del analfabetismo en las últimas décadas, pero
                aún enfrenta desafíos importantes en este aspecto. A continuación te proporciono una visión general del
                analfabetismo en el país:
                Tasa de Analfabetismo
            </p>
            <ul>
                <li>Reducción en las últimas décadas: En los años 80, Nicaragua llevó a cabo una campaña nacional de alfabetización, la cual logró reducir drásticamente la tasa de analfabetismo, especialmente en las zonas rurales y entre los adultos. Sin embargo, a pesar de estos avances, aún persisten problemas.</li>
                <li>Estadísticas recientes: Según datos del Instituto Nacional de Información de Desarrollo (INIDE) y otras fuentes, la tasa de analfabetismo en Nicaragua ha disminuido significativamente, pero sigue siendo un desafío. En 2020, la tasa de analfabetismo era aproximadamente del 13.5%. Esta cifra puede variar dependiendo de la fuente y la definición de alfabetización utilizada.</li>
            </ul>
        </div>
        <div class="info-image">
            <img src="../img/alfa.jpeg" alt="Información">
        </div>
    </div>
</body>
</html>