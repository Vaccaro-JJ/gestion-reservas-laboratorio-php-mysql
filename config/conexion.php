<?php

class Conexion
{
    private static function obtenerVariable(string $nombre, string $valorPorDefecto): string
    {
        $valor = getenv($nombre);

        if ($valor === false || $valor === "") {
            return $valorPorDefecto;
        }

        return $valor;
    }

    public static function conectar(): mysqli
    {
        mysqli_report(MYSQLI_REPORT_OFF);

        $host = self::obtenerVariable("DB_HOST", "127.0.0.1");
        $baseDatos = self::obtenerVariable("DB_NAME", "bd_reservas_laboratorio");
        $usuario = self::obtenerVariable("DB_USER", "root");
        $clave = self::obtenerVariable("DB_PASS", "");
        $puerto = (int) self::obtenerVariable("DB_PORT", "3307");

        $conexion = new mysqli(
            $host,
            $usuario,
            $clave,
            $baseDatos,
            $puerto
        );

        if ($conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $conexion->connect_error);
        }

        $conexion->set_charset("utf8mb4");

        return $conexion;
    }
}