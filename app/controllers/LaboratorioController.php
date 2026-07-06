<?php

require_once __DIR__ . "/../models/Laboratorio.php";

class LaboratorioController
{
    private Laboratorio $modelo;

    public function __construct()
    {
        $this->modelo = new Laboratorio();
    }

    public function index(): void
    {
        $laboratorios = $this->modelo->listar();

        cargarVista("laboratorios/index", [
            "titulo" => "Gestión de Laboratorios",
            "laboratorios" => $laboratorios
        ]);
    }

    public function crear(): void
    {
        cargarVista("laboratorios/crear", [
            "titulo" => "Registrar Laboratorio",
            "errores" => [],
            "datos" => [
                "nombre" => "",
                "ubicacion" => "",
                "capacidad" => "",
                "estado" => "Disponible"
            ]
        ]);
    }

    public function guardar(): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=Solicitud no válida.");
        }

        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validarDatos($datos);

        if (!empty($errores)) {
            cargarVista("laboratorios/crear", [
                "titulo" => "Registrar Laboratorio",
                "errores" => $errores,
                "datos" => $datos
            ]);
            return;
        }

        $guardado = $this->modelo->crear(
            $datos["nombre"],
            $datos["ubicacion"],
            (int) $datos["capacidad"],
            $datos["estado"]
        );

        if ($guardado) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&msg=Laboratorio registrado correctamente.");
        }

        $this->redireccionar("index.php?controller=laboratorios&action=index&error=No se pudo registrar el laboratorio.");
    }

    public function editar(): void
    {
        $id = (int) ($_GET["id"] ?? 0);

        if ($id <= 0) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=ID de laboratorio no válido.");
        }

        $laboratorio = $this->modelo->obtenerPorId($id);

        if (!$laboratorio) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=El laboratorio solicitado no existe.");
        }

        cargarVista("laboratorios/editar", [
            "titulo" => "Editar Laboratorio",
            "errores" => [],
            "laboratorio" => $laboratorio
        ]);
    }

    public function actualizar(): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=Solicitud no válida.");
        }

        $id = (int) ($_POST["id"] ?? 0);

        if ($id <= 0) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=ID de laboratorio no válido.");
        }

        $datos = $this->obtenerDatosFormulario();
        $errores = $this->validarDatos($datos);

        $laboratorio = [
            "id" => $id,
            "nombre" => $datos["nombre"],
            "ubicacion" => $datos["ubicacion"],
            "capacidad" => $datos["capacidad"],
            "estado" => $datos["estado"]
        ];

        if (!empty($errores)) {
            cargarVista("laboratorios/editar", [
                "titulo" => "Editar Laboratorio",
                "errores" => $errores,
                "laboratorio" => $laboratorio
            ]);
            return;
        }

        $actualizado = $this->modelo->actualizar(
            $id,
            $datos["nombre"],
            $datos["ubicacion"],
            (int) $datos["capacidad"],
            $datos["estado"]
        );

        if ($actualizado) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&msg=Laboratorio actualizado correctamente.");
        }

        $this->redireccionar("index.php?controller=laboratorios&action=index&error=No se pudo actualizar el laboratorio.");
    }

    public function eliminar(): void
    {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=Solicitud de eliminación no válida.");
        }

        $id = (int) ($_POST["id"] ?? 0);

        if ($id <= 0) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=ID de laboratorio no válido.");
        }

        $laboratorio = $this->modelo->obtenerPorId($id);

        if (!$laboratorio) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=El laboratorio no existe.");
        }

        $totalReservas = $this->modelo->contarReservas($id);

        if ($totalReservas > 0) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&error=No se puede eliminar el laboratorio porque tiene reservas asociadas.");
        }

        $eliminado = $this->modelo->eliminar($id);

        if ($eliminado) {
            $this->redireccionar("index.php?controller=laboratorios&action=index&msg=Laboratorio eliminado correctamente.");
        }

        $this->redireccionar("index.php?controller=laboratorios&action=index&error=No se pudo eliminar el laboratorio.");
    }

    private function obtenerDatosFormulario(): array
    {
        return [
            "nombre" => trim($_POST["nombre"] ?? ""),
            "ubicacion" => trim($_POST["ubicacion"] ?? ""),
            "capacidad" => trim($_POST["capacidad"] ?? ""),
            "estado" => trim($_POST["estado"] ?? "")
        ];
    }

    private function validarDatos(array $datos): array
    {
        $errores = [];
        $estadosPermitidos = ["Disponible", "Mantenimiento", "Inactivo"];

        if ($datos["nombre"] === "") {
            $errores[] = "El nombre del laboratorio es obligatorio.";
        } elseif (strlen($datos["nombre"]) > 100) {
            $errores[] = "El nombre del laboratorio no debe superar los 100 caracteres.";
        }

        if ($datos["ubicacion"] === "") {
            $errores[] = "La ubicación del laboratorio es obligatoria.";
        } elseif (strlen($datos["ubicacion"]) > 150) {
            $errores[] = "La ubicación no debe superar los 150 caracteres.";
        }

        $capacidad = filter_var($datos["capacidad"], FILTER_VALIDATE_INT);

        if ($datos["capacidad"] === "") {
            $errores[] = "La capacidad del laboratorio es obligatoria.";
        } elseif ($capacidad === false || $capacidad <= 0) {
            $errores[] = "La capacidad debe ser un número entero mayor que cero.";
        }

        if ($datos["estado"] === "") {
            $errores[] = "El estado del laboratorio es obligatorio.";
        } elseif (!in_array($datos["estado"], $estadosPermitidos, true)) {
            $errores[] = "El estado seleccionado no es válido.";
        }

        return $errores;
    }

    private function redireccionar(string $url): void
    {
        header("Location: " . $url);
        exit;
    }
}