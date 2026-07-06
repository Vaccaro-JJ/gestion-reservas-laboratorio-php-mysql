<?php
$tituloPagina = $titulo ?? "Gestión de Reservas de Laboratorio";
$mensaje = $_GET["msg"] ?? "";
$error = $_GET["error"] ?? "";
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($tituloPagina) ?> | Reservas de Laboratorio</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="css/estilos.css">
</head>
<body>

<header class="encabezado">
    <div class="encabezado-contenido">
        <div class="marca">
            <h1>Sistema Web de Gestión de Reservas de Laboratorio</h1>
            <p>Proyecto Segundo Parcial | Desarrollo de Aplicaciones Web</p>
            <p>Integrante: Jonathan Vaccaro</p>
        </div>

        <nav class="menu">
            <a href="index.php">Inicio</a>
            <a href="index.php?controller=laboratorios&action=index">Laboratorios</a>
            <a href="index.php?controller=reservas&action=index">Reservas</a>
            <a href="index.php?controller=inicio&action=probarConexion">Probar conexión</a>
        </nav>
    </div>
</header>

<main class="contenedor">
    <?php if ($mensaje !== ""): ?>
        <div class="alerta exito">
            <?= htmlspecialchars($mensaje) ?>
        </div>
    <?php endif; ?>

    <?php if ($error !== ""): ?>
        <div class="alerta error">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>