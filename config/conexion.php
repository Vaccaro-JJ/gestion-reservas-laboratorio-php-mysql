<?php

class Conexion
{
    private static string $host = "127.0.0.1";
    private static string $baseDatos = "bd_reservas_laboratorio";
    private static string $usuario = "root";
    private static string $clave = "";
    private static int $puerto = 3307;

    public static function conectar(): mysqli
    {
        mysqli_report(MYSQLI_REPORT_OFF);

        $conexion = new mysqli(
            self::$host,
            self::$usuario,
            self::$clave,
            self::$baseDatos,
            self::$puerto
        );

        if ($conexion->connect_error) {
            die("Error de conexión a la base de datos: " . $conexion->connect_error);
        }

        $conexion->set_charset("utf8mb4");

        return $conexion;
    }
}