<?php

require_once __DIR__ . "/../models/Reserva.php";

class ReservaController
{
    private Reserva $modelo;

    public function __construct()
    {
        $this->modelo = new Reserva();
    }

    public function index(): void
    {
        $reservas = $this->modelo->listar();

        cargarVista("reservas/index", [
            "titulo" => "Gestión de Reservas",
            "reservas" => $reservas
        ]);
    }

    public function crear(): void
    {
        $laboratorios = $this->modelo->listarLaboratoriosParaFormulario();

        cargarVista("reservas/crear", [
            "titulo" => "Registrar Reserva",
            "errores" => [],
            "datos" => [
                "laboratorio_id" => "",
                "solicitante" => "",
                "fecha_reserva" => "",
                "hora_inicio" => "",
                "hora_fin" => "",
                "motivo" => "",
                "estado" => "Pendiente"
            ],
            "laboratorios" => $laboratorios
        ]);
    }

    public function guardar(): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("Solicitud no válida."));
        }

        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validarDatos($datos);

        if (!empty($errores)) {
            $laboratorios = $this->modelo->listarLaboratoriosParaFormulario();

            cargarVista("reservas/crear", [
                "titulo" => "Registrar Reserva",
                "errores" => $errores,
                "datos" => $datos,
                "laboratorios" => $laboratorios
            ]);
            return;
        }

        $guardado = $this->modelo->crear(
            (int) $datos["laboratorio_id"],
            $datos["solicitante"],
            $datos["fecha_reserva"],
            $datos["hora_inicio"],
            $datos["hora_fin"],
            $datos["motivo"],
            $datos["estado"]
        );

        if ($guardado) {
            $this->redireccionar("index.php?controller=reservas&action=index&msg=" . urlencode("Reserva registrada correctamente."));
        }

        $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("No se pudo registrar la reserva."));
    }

    public function editar(): void
    {
        $id = (int) ($_GET["id"] ?? 0);

        if ($id <= 0) {
            $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("ID de reserva no válido."));
        }

        $reserva = $this->modelo->obtenerPorId($id);

        if (!$reserva) {
            $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("La reserva solicitada no existe."));
        }

        $laboratorios = $this->modelo->listarLaboratoriosParaFormulario((int) $reserva["laboratorio_id"]);

        cargarVista("reservas/editar", [
            "titulo" => "Editar Reserva",
            "errores" => [],
            "reserva" => $reserva,
            "laboratorios" => $laboratorios
        ]);
    }

    public function actualizar(): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("Solicitud no válida."));
        }

        $id = (int) ($_POST["id"] ?? 0);

        if ($id <= 0) {
            $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("ID de reserva no válido."));
        }

        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validarDatos($datos, $id);

        $reserva = [
            "id" => $id,
            "laboratorio_id" => $datos["laboratorio_id"],
            "solicitante" => $datos["solicitante"],
            "fecha_reserva" => $datos["fecha_reserva"],
            "hora_inicio" => $datos["hora_inicio"],
            "hora_fin" => $datos["hora_fin"],
            "motivo" => $datos["motivo"],
            "estado" => $datos["estado"]
        ];

        if (!empty($errores)) {
            $laboratorios = $this->modelo->listarLaboratoriosParaFormulario((int) $datos["laboratorio_id"]);

            cargarVista("reservas/editar", [
                "titulo" => "Editar Reserva",
                "errores" => $errores,
                "reserva" => $reserva,
                "laboratorios" => $laboratorios
            ]);
            return;
        }

        $actualizado = $this->modelo->actualizar(
            $id,
            (int) $datos["laboratorio_id"],
            $datos["solicitante"],
            $datos["fecha_reserva"],
            $datos["hora_inicio"],
            $datos["hora_fin"],
            $datos["motivo"],
            $datos["estado"]
        );

        if ($actualizado) {
            $this->redireccionar("index.php?controller=reservas&action=index&msg=" . urlencode("Reserva actualizada correctamente."));
        }

        $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("No se pudo actualizar la reserva."));
    }

    public function eliminar(): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("Solicitud de eliminación no válida."));
        }

        $id = (int) ($_POST["id"] ?? 0);

        if ($id <= 0) {
            $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("ID de reserva no válido."));
        }

        $reserva = $this->modelo->obtenerPorId($id);

        if (!$reserva) {
            $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("La reserva no existe."));
        }

        $eliminado = $this->modelo->eliminar($id);

        if ($eliminado) {
            $this->redireccionar("index.php?controller=reservas&action=index&msg=" . urlencode("Reserva eliminada correctamente."));
        }

        $this->redireccionar("index.php?controller=reservas&action=index&error=" . urlencode("No se pudo eliminar la reserva."));
    }

    private function obtenerDatosFormulario(): array
    {
        return [
            "laboratorio_id" => trim($_POST["laboratorio_id"] ?? ""),
            "solicitante" => trim($_POST["solicitante"] ?? ""),
            "fecha_reserva" => trim($_POST["fecha_reserva"] ?? ""),
            "hora_inicio" => trim($_POST["hora_inicio"] ?? ""),
            "hora_fin" => trim($_POST["hora_fin"] ?? ""),
            "motivo" => trim($_POST["motivo"] ?? ""),
            "estado" => trim($_POST["estado"] ?? "")
        ];
    }

    private function validarDatos(array $datos, ?int $reservaId = null): array
    {
        $errores = [];
        $estadosPermitidos = ["Pendiente", "Aprobada", "Cancelada"];

        $laboratorioId = filter_var($datos["laboratorio_id"], FILTER_VALIDATE_INT);

        if ($laboratorioId === false || $laboratorioId <= 0) {
            $errores[] = "Debe seleccionar un laboratorio válido.";
        } else {
            $laboratorio = $this->modelo->obtenerLaboratorioPorId((int) $laboratorioId);

            if (!$laboratorio) {
                $errores[] = "El laboratorio seleccionado no existe.";
            } elseif ($laboratorio["estado"] !== "Disponible") {
                $errores[] = "Solo se pueden registrar reservas en laboratorios disponibles.";
            }
        }

        if ($datos["solicitante"] === "") {
            $errores[] = "El nombre del solicitante es obligatorio.";
        } elseif (strlen($datos["solicitante"]) > 120) {
            $errores[] = "El nombre del solicitante no debe superar los 120 caracteres.";
        }

        if ($datos["fecha_reserva"] === "") {
            $errores[] = "La fecha de reserva es obligatoria.";
        } elseif (!$this->fechaValida($datos["fecha_reserva"])) {
            $errores[] = "La fecha de reserva no tiene un formato válido.";
        } elseif ($datos["fecha_reserva"] < date("Y-m-d")) {
            $errores[] = "La fecha de reserva no puede ser anterior al día actual.";
        }

        if ($datos["hora_inicio"] === "") {
            $errores[] = "La hora de inicio es obligatoria.";
        }

        if ($datos["hora_fin"] === "") {
            $errores[] = "La hora de fin es obligatoria.";
        }

        if ($datos["hora_inicio"] !== "" && $datos["hora_fin"] !== "") {
            if (!$this->horaValida($datos["hora_inicio"]) || !$this->horaValida($datos["hora_fin"])) {
                $errores[] = "Las horas ingresadas no tienen un formato válido.";
            } elseif ($datos["hora_fin"] <= $datos["hora_inicio"]) {
                $errores[] = "La hora de fin debe ser mayor que la hora de inicio.";
            }
        }

        if ($datos["motivo"] === "") {
            $errores[] = "El motivo de la reserva es obligatorio.";
        } elseif (strlen($datos["motivo"]) > 500) {
            $errores[] = "El motivo no debe superar los 500 caracteres.";
        }

        if ($datos["estado"] === "") {
            $errores[] = "El estado de la reserva es obligatorio.";
        } elseif (!in_array($datos["estado"], $estadosPermitidos, true)) {
            $errores[] = "El estado seleccionado no es válido.";
        }

        if (
            empty($errores) &&
            $laboratorioId !== false &&
            $laboratorioId > 0
        ) {
            $existeCruce = $this->modelo->existeCruceHorario(
                (int) $laboratorioId,
                $datos["fecha_reserva"],
                $datos["hora_inicio"],
                $datos["hora_fin"],
                $reservaId
            );

            if ($existeCruce) {
                $errores[] = "Ya existe una reserva activa para ese laboratorio en el horario seleccionado.";
            }
        }

        return $errores;
    }

    private function fechaValida(string $fecha): bool
    {
        $fechaObj = DateTime::createFromFormat("Y-m-d", $fecha);

        return $fechaObj && $fechaObj->format("Y-m-d") === $fecha;
    }

    private function horaValida(string $hora): bool
    {
        return preg_match("/^\d{2}:\d{2}(:\d{2})?$/", $hora) === 1;
    }

    private function redireccionar(string $url): void
    {
        header("Location: " . $url);
        exit;
    }
}