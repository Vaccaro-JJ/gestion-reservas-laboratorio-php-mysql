document.addEventListener("DOMContentLoaded", function () {
    console.log("Sistema de reservas de laboratorio cargado correctamente.");
});

function validarFormularioLaboratorio() {
    const nombre = document.getElementById("nombre")?.value.trim() || "";
    const ubicacion = document.getElementById("ubicacion")?.value.trim() || "";
    const capacidad = document.getElementById("capacidad")?.value || "";
    const estado = document.getElementById("estado")?.value || "";

    if (nombre === "") {
        alert("Ingrese el nombre del laboratorio.");
        return false;
    }

    if (nombre.length > 100) {
        alert("El nombre del laboratorio no debe superar los 100 caracteres.");
        return false;
    }

    if (ubicacion === "") {
        alert("Ingrese la ubicación del laboratorio.");
        return false;
    }

    if (ubicacion.length > 150) {
        alert("La ubicación no debe superar los 150 caracteres.");
        return false;
    }

    if (capacidad === "" || Number(capacidad) <= 0 || !Number.isInteger(Number(capacidad))) {
        alert("Ingrese una capacidad válida mayor que cero.");
        return false;
    }

    if (estado === "") {
        alert("Seleccione el estado del laboratorio.");
        return false;
    }

    return true;
}

function validarFormularioReserva() {
    const laboratorioId = document.getElementById("laboratorio_id")?.value || "";
    const solicitante = document.getElementById("solicitante")?.value.trim() || "";
    const fechaReserva = document.getElementById("fecha_reserva")?.value || "";
    const horaInicio = document.getElementById("hora_inicio")?.value || "";
    const horaFin = document.getElementById("hora_fin")?.value || "";
    const motivo = document.getElementById("motivo")?.value.trim() || "";
    const estado = document.getElementById("estado")?.value || "";

    const hoy = new Date();
    hoy.setHours(0, 0, 0, 0);

    if (laboratorioId === "") {
        alert("Seleccione un laboratorio.");
        return false;
    }

    if (solicitante === "") {
        alert("Ingrese el nombre del solicitante.");
        return false;
    }

    if (solicitante.length > 120) {
        alert("El nombre del solicitante no debe superar los 120 caracteres.");
        return false;
    }

    if (fechaReserva === "") {
        alert("Seleccione la fecha de reserva.");
        return false;
    }

    const fechaSeleccionada = new Date(fechaReserva + "T00:00:00");

    if (fechaSeleccionada < hoy) {
        alert("La fecha de reserva no puede ser anterior al día actual.");
        return false;
    }

    if (horaInicio === "") {
        alert("Seleccione la hora de inicio.");
        return false;
    }

    if (horaFin === "") {
        alert("Seleccione la hora de fin.");
        return false;
    }

    if (horaFin <= horaInicio) {
        alert("La hora de fin debe ser mayor que la hora de inicio.");
        return false;
    }

    if (motivo === "") {
        alert("Ingrese el motivo de la reserva.");
        return false;
    }

    if (motivo.length > 500) {
        alert("El motivo no debe superar los 500 caracteres.");
        return false;
    }

    if (estado === "") {
        alert("Seleccione el estado de la reserva.");
        return false;
    }

    return true;
}

function confirmarEliminacion(nombreLaboratorio) {
    return confirm("¿Está seguro de eliminar el laboratorio: " + nombreLaboratorio + "?");
}

function confirmarEliminacionReserva(nombreSolicitante) {
    return confirm("¿Está seguro de eliminar la reserva del solicitante: " + nombreSolicitante + "?");
}