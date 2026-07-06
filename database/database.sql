DROP DATABASE IF EXISTS bd_reservas_laboratorio;

CREATE DATABASE bd_reservas_laboratorio
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE bd_reservas_laboratorio;

CREATE TABLE laboratorios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    ubicacion VARCHAR(150) NOT NULL,
    capacidad INT NOT NULL,
    estado ENUM('Disponible', 'Mantenimiento', 'Inactivo') NOT NULL DEFAULT 'Disponible',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE reservas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    laboratorio_id INT NOT NULL,
    solicitante VARCHAR(120) NOT NULL,
    fecha_reserva DATE NOT NULL,
    hora_inicio TIME NOT NULL,
    hora_fin TIME NOT NULL,
    motivo TEXT NOT NULL,
    estado ENUM('Pendiente', 'Aprobada', 'Cancelada') NOT NULL DEFAULT 'Pendiente',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,

    CONSTRAINT fk_reservas_laboratorios
        FOREIGN KEY (laboratorio_id)
        REFERENCES laboratorios(id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;

INSERT INTO laboratorios (nombre, ubicacion, capacidad, estado) VALUES
('Laboratorio de Software', 'Bloque A - Piso 2', 30, 'Disponible'),
('Laboratorio de Redes', 'Bloque B - Piso 1', 25, 'Disponible'),
('Laboratorio de Base de Datos', 'Bloque C - Piso 3', 28, 'Mantenimiento');

INSERT INTO reservas (
    laboratorio_id,
    solicitante,
    fecha_reserva,
    hora_inicio,
    hora_fin,
    motivo,
    estado
) VALUES
(1, 'Jonathan Vaccaro', '2026-07-10', '08:00:00', '10:00:00', 'Clase práctica de Desarrollo de Aplicaciones Web', 'Aprobada'),
(2, 'Docente de Redes', '2026-07-11', '10:00:00', '12:00:00', 'Práctica de configuración de redes', 'Pendiente'),
(1, 'Coordinación Académica', '2026-07-12', '14:00:00', '16:00:00', 'Evaluación práctica de programación', 'Pendiente');