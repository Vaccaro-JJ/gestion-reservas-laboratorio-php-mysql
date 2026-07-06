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
        $sslCa = self::obtenerVariable("DB_SSL_CA", "");

        $conexion = mysqli_init();

        if (!$conexion) {
            die("Error al inicializar la conexión MySQL.");
        }

        if ($sslCa !== "" && file_exists($sslCa)) {
            $conexion->ssl_set(null, null, $sslCa, null, null);
            $conectado = $conexion->real_connect(
                $host,
                $usuario,
                $clave,
                $baseDatos,
                $puerto,
                null,
                MYSQLI_CLIENT_SSL
            );
        } else {
            $conectado = $conexion->real_connect(
                $host,
                $usuario,
                $clave,
                $baseDatos,
                $puerto
            );
        }

        if (!$conectado) {
            die("Error de conexión a la base de datos: " . $conexion->connect_error);
        }

        $conexion->set_charset("utf8mb4");

        return $conexion;
    }
}