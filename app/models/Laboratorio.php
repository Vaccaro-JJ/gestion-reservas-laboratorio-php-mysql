<?php

require_once __DIR__ . "/../../config/conexion.php";

class Laboratorio
{
    private mysqli $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::conectar();
    }

    public function listar(): array
    {
        $sql = "SELECT id, nombre, ubicacion, capacidad, estado, fecha_creacion, fecha_actualizacion
                FROM laboratorios
                ORDER BY id DESC";

        $resultado = $this->conexion->query($sql);

        if (!$resultado) {
            return [];
        }

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT id, nombre, ubicacion, capacidad, estado
                FROM laboratorios
                WHERE id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $laboratorio = $resultado->fetch_assoc();

        return $laboratorio ?: null;
    }

    public function crear(string $nombre, string $ubicacion, int $capacidad, string $estado): bool
    {
        $sql = "INSERT INTO laboratorios (nombre, ubicacion, capacidad, estado)
                VALUES (?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssis", $nombre, $ubicacion, $capacidad, $estado);

        return $stmt->execute();
    }

    public function actualizar(int $id, string $nombre, string $ubicacion, int $capacidad, string $estado): bool
    {
        $sql = "UPDATE laboratorios
                SET nombre = ?, ubicacion = ?, capacidad = ?, estado = ?
                WHERE id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("ssisi", $nombre, $ubicacion, $capacidad, $estado, $id);

        return $stmt->execute();
    }

    public function contarReservas(int $id): int
    {
        $sql = "SELECT COUNT(*) AS total
                FROM reservas
                WHERE laboratorio_id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();

        return (int) ($fila["total"] ?? 0);
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM laboratorios
                WHERE id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}