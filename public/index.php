<?php

require_once __DIR__ . "/../config/conexion.php";

$controller = $_GET["controller"] ?? "inicio";
$action = $_GET["action"] ?? "index";

function cargarVista(string $vista, array $datos = []): void
{
    extract($datos);

    require __DIR__ . "/../app/views/layout/header.php";
    require __DIR__ . "/../app/views/" . $vista . ".php";
    require __DIR__ . "/../app/views/layout/footer.php";
}

switch ($controller) {
    case "inicio":
        if ($action === "index") {
            cargarVista("inicio/index", [
                "titulo" => "Inicio"
            ]);
            break;
        }

        if ($action === "probarConexion") {
            $conexionExitosa = false;
            $baseDatos = "bd_reservas_laboratorio";
            $servidor = "";
            $puerto = "3307";
            $errorConexion = "";

            try {
                $conexion = Conexion::conectar();
                $conexionExitosa = true;
                $servidor = $conexion->server_info;
                $conexion->close();
            } catch (Throwable $e) {
                $errorConexion = $e->getMessage();
            }

            cargarVista("inicio/conexion", [
                "titulo" => "Prueba de conexión",
                "conexionExitosa" => $conexionExitosa,
                "baseDatos" => $baseDatos,
                "servidor" => $servidor,
                "puerto" => $puerto,
                "errorConexion" => $errorConexion
            ]);
            break;
        }

        http_response_code(404);
        cargarVista("inicio/index", [
            "titulo" => "Acción no encontrada"
        ]);
        break;

    case "laboratorios":
        require_once __DIR__ . "/../app/controllers/LaboratorioController.php";

        $laboratorioController = new LaboratorioController();

        $accionesPermitidas = [
            "index",
            "crear",
            "guardar",
            "editar",
            "actualizar",
            "eliminar"
        ];

        if (in_array($action, $accionesPermitidas, true)) {
            $laboratorioController->$action();
            break;
        }

        http_response_code(404);
        cargarVista("inicio/index", [
            "titulo" => "Acción de laboratorios no encontrada"
        ]);
        break;

    case "reservas":
    require_once __DIR__ . "/../app/controllers/ReservaController.php";

    $reservaController = new ReservaController();

    $accionesPermitidas = [
        "index",
        "crear",
        "guardar",
        "editar",
        "actualizar",
        "eliminar"
    ];

    if (in_array($action, $accionesPermitidas, true)) {
        $reservaController->$action();
        break;
    }

    http_response_code(404);
    cargarVista("inicio/index", [
        "titulo" => "Acción de reservas no encontrada"
    ]);
    break;
}