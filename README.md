# Sistema Web de Gestión de Reservas de Laboratorio

## Descripción

Aplicación web desarrollada con PHP y MySQL para gestionar laboratorios académicos y sus reservas mediante operaciones CRUD.

El sistema permite administrar dos entidades relacionadas:

- Laboratorios
- Reservas

La relación aplicada es:

Un laboratorio puede tener muchas reservas y una reserva pertenece a un solo laboratorio.

## Integrante

Jonathan Vaccaro

## Materia

Desarrollo de Aplicaciones Web

## Proyecto

Proyecto Segundo Parcial

## Tecnologías utilizadas

- PHP
- MySQL
- HTML
- CSS
- JavaScript
- XAMPP
- HeidiSQL
- Git
- GitHub

## Arquitectura

El proyecto aplica el patrón MVC:

- Modelo: acceso y gestión de datos.
- Vista: interfaz gráfica.
- Controlador: lógica de negocio y coordinación del flujo.

## Funcionalidades principales

### Laboratorios

- Registrar laboratorio.
- Listar laboratorios.
- Editar laboratorio.
- Eliminar laboratorio.
- Evitar eliminación si tiene reservas asociadas.

### Reservas

- Registrar reserva.
- Listar reservas.
- Editar reserva.
- Eliminar reserva.
- Mostrar nombre del laboratorio asociado.
- Validar cruces de horario.
- Validar fecha, hora, solicitante, motivo y estado.

## Validaciones

El sistema aplica validaciones en:

- HTML5
- JavaScript
- PHP
- Base de datos MySQL

Ejemplos de validaciones:

- No permitir campos vacíos.
- Capacidad mayor que cero.
- Fecha de reserva no anterior al día actual.
- Hora de fin mayor que hora de inicio.
- Estados permitidos mediante listas controladas.
- Evitar reservas cruzadas en un mismo laboratorio.

## Base de datos

Nombre de la base:

```text
bd_reservas_laboratorio
```

Tablas principales:

```text
laboratorios
reservas
```

Archivo SQL:

```text
database/database.sql
```

## Ejecución local

1. Copiar el proyecto dentro de:

```text
C:\xampp\htdocs\gestion_reservas_laboratorio
```

2. Iniciar Apache y MySQL desde XAMPP.

3. Importar la base de datos desde HeidiSQL o phpMyAdmin usando:

```text
database/database.sql
```

4. Verificar que MySQL de XAMPP esté usando el puerto 3307.

5. Abrir en el navegador:

```text
http://localhost/gestion_reservas_laboratorio/public/
```

## Configuración de conexión

Archivo:

```text
config/conexion.php
```

Configuración local utilizada:

```text
Host: 127.0.0.1
Base de datos: bd_reservas_laboratorio
Usuario: root
Contraseña: vacía
Puerto: 3307
```

## Estructura general del proyecto

```text
gestion_reservas_laboratorio/
│
├── app/
│   ├── controllers/
│   ├── models/
│   └── views/
│
├── config/
│   └── conexion.php
│
├── database/
│   └── database.sql
│
├── public/
│   ├── index.php
│   ├── css/
│   └── js/
│
├── README.md
└── .gitignore
```

## Flujo MVC aplicado

```text
Usuario
↓
Navegador
↓
public/index.php
↓
Controlador
↓
Modelo
↓
Base de datos MySQL
↓
Controlador
↓
Vista
↓
Navegador
```

## Estado del proyecto

Proyecto funcional con CRUD completo de dos entidades relacionadas, validaciones frontend/backend y conexión a base de datos MySQL.