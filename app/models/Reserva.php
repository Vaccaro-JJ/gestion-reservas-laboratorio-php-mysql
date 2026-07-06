<?php

require_once __DIR__ . "/../../config/conexion.php";

class Reserva
{
    private mysqli $conexion;

    public function __construct()
    {
        $this->conexion = Conexion::conectar();
    }

    public function listar(): array
    {
        $sql = "SELECT 
                    reservas.id,
                    reservas.laboratorio_id,
                    laboratorios.nombre AS laboratorio,
                    reservas.solicitante,
                    reservas.fecha_reserva,
                    reservas.hora_inicio,
                    reservas.hora_fin,
                    reservas.motivo,
                    reservas.estado,
                    reservas.fecha_creacion
                FROM reservas
                INNER JOIN laboratorios
                    ON reservas.laboratorio_id = laboratorios.id
                ORDER BY reservas.fecha_reserva DESC, reservas.hora_inicio DESC";

        $resultado = $this->conexion->query($sql);

        if (!$resultado) {
            return [];
        }

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerPorId(int $id): ?array
    {
        $sql = "SELECT 
                    id,
                    laboratorio_id,
                    solicitante,
                    fecha_reserva,
                    hora_inicio,
                    hora_fin,
                    motivo,
                    estado
                FROM reservas
                WHERE id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $reserva = $resultado->fetch_assoc();

        return $reserva ?: null;
    }

    public function listarLaboratoriosParaFormulario(?int $laboratorioActualId = null): array
    {
        if ($laboratorioActualId !== null && $laboratorioActualId > 0) {
            $sql = "SELECT id, nombre, ubicacion, estado
                    FROM laboratorios
                    WHERE estado = 'Disponible' OR id = ?
                    ORDER BY nombre ASC";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param("i", $laboratorioActualId);
            $stmt->execute();

            $resultado = $stmt->get_result();

            return $resultado->fetch_all(MYSQLI_ASSOC);
        }

        $sql = "SELECT id, nombre, ubicacion, estado
                FROM laboratorios
                WHERE estado = 'Disponible'
                ORDER BY nombre ASC";

        $resultado = $this->conexion->query($sql);

        if (!$resultado) {
            return [];
        }

        return $resultado->fetch_all(MYSQLI_ASSOC);
    }

    public function obtenerLaboratorioPorId(int $id): ?array
    {
        $sql = "SELECT id, nombre, estado
                FROM laboratorios
                WHERE id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $resultado = $stmt->get_result();
        $laboratorio = $resultado->fetch_assoc();

        return $laboratorio ?: null;
    }

    public function existeCruceHorario(
        int $laboratorioId,
        string $fechaReserva,
        string $horaInicio,
        string $horaFin,
        ?int $reservaExcluirId = null
    ): bool {
        if ($reservaExcluirId !== null && $reservaExcluirId > 0) {
            $sql = "SELECT COUNT(*) AS total
                    FROM reservas
                    WHERE laboratorio_id = ?
                    AND fecha_reserva = ?
                    AND estado <> 'Cancelada'
                    AND hora_inicio < ?
                    AND hora_fin > ?
                    AND id <> ?";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param(
                "isssi",
                $laboratorioId,
                $fechaReserva,
                $horaFin,
                $horaInicio,
                $reservaExcluirId
            );
        } else {
            $sql = "SELECT COUNT(*) AS total
                    FROM reservas
                    WHERE laboratorio_id = ?
                    AND fecha_reserva = ?
                    AND estado <> 'Cancelada'
                    AND hora_inicio < ?
                    AND hora_fin > ?";

            $stmt = $this->conexion->prepare($sql);
            $stmt->bind_param(
                "isss",
                $laboratorioId,
                $fechaReserva,
                $horaFin,
                $horaInicio
            );
        }

        $stmt->execute();

        $resultado = $stmt->get_result();
        $fila = $resultado->fetch_assoc();

        return (int) ($fila["total"] ?? 0) > 0;
    }

    public function crear(
        int $laboratorioId,
        string $solicitante,
        string $fechaReserva,
        string $horaInicio,
        string $horaFin,
        string $motivo,
        string $estado
    ): bool {
        $sql = "INSERT INTO reservas (
                    laboratorio_id,
                    solicitante,
                    fecha_reserva,
                    hora_inicio,
                    hora_fin,
                    motivo,
                    estado
                )
                VALUES (?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param(
            "issssss",
            $laboratorioId,
            $solicitante,
            $fechaReserva,
            $horaInicio,
            $horaFin,
            $motivo,
            $estado
        );

        return $stmt->execute();
    }

    public function actualizar(
        int $id,
        int $laboratorioId,
        string $solicitante,
        string $fechaReserva,
        string $horaInicio,
        string $horaFin,
        string $motivo,
        string $estado
    ): bool {
        $sql = "UPDATE reservas
                SET laboratorio_id = ?,
                    solicitante = ?,
                    fecha_reserva = ?,
                    hora_inicio = ?,
                    hora_fin = ?,
                    motivo = ?,
                    estado = ?
                WHERE id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param(
            "issssssi",
            $laboratorioId,
            $solicitante,
            $fechaReserva,
            $horaInicio,
            $horaFin,
            $motivo,
            $estado,
            $id
        );

        return $stmt->execute();
    }

    public function eliminar(int $id): bool
    {
        $sql = "DELETE FROM reservas
                WHERE id = ?";

        $stmt = $this->conexion->prepare($sql);
        $stmt->bind_param("i", $id);

        return $stmt->execute();
    }
}