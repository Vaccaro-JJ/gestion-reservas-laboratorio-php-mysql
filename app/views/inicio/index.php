<section class="tarjeta hero">
    <h2>Bienvenido al Sistema de Gestión de Reservas de Laboratorio</h2>

    <p>
        Esta aplicación web permite administrar laboratorios académicos y sus reservas
        mediante operaciones CRUD, utilizando PHP, MySQL, HTML, CSS, JavaScript y una
        estructura basada en el patrón Modelo - Vista - Controlador.
    </p>

    <p>
        El sistema fue desarrollado como proyecto del segundo parcial de la materia
        Desarrollo de Aplicaciones Web. Su finalidad es resolver un proceso académico
        real: la organización y control de reservas de laboratorios.
    </p>

    <div class="acciones">
        <a class="boton" href="index.php?controller=laboratorios&action=index">
            Gestionar laboratorios
        </a>

        <a class="boton boton-secundario" href="index.php?controller=reservas&action=index">
            Gestionar reservas
        </a>

        <a class="boton boton-info" href="index.php?controller=inicio&action=probarConexion">
            Probar conexión
        </a>
    </div>
</section>

<section class="grid">
    <article class="tarjeta tarjeta-resumen">
        <h3>Laboratorios</h3>
        <p>
            Permite registrar, consultar, actualizar y eliminar laboratorios disponibles
            para actividades académicas.
        </p>
        <p class="texto-destacado">Entidad principal del sistema.</p>
    </article>

    <article class="tarjeta tarjeta-resumen">
        <h3>Reservas</h3>
        <p>
            Permite administrar reservas asociadas a laboratorios existentes, controlando
            fecha, horario, solicitante, motivo y estado.
        </p>
        <p class="texto-destacado">Entidad relacionada mediante clave foránea.</p>
    </article>

    <article class="tarjeta tarjeta-resumen">
        <h3>Validaciones</h3>
        <p>
            El sistema valida datos en frontend y backend para evitar campos vacíos,
            horarios incorrectos, fechas inválidas y cruces de reservas.
        </p>
        <p class="texto-destacado">HTML5, JavaScript y PHP.</p>
    </article>
</section>

<section class="tarjeta">
    <h3>Flujo general MVC aplicado</h3>

    <div class="flujo-mvc">
        <span>Navegador</span>
        <strong>→</strong>
        <span>public/index.php</span>
        <strong>→</strong>
        <span>Controlador</span>
        <strong>→</strong>
        <span>Modelo</span>
        <strong>→</strong>
        <span>MySQL</span>
        <strong>→</strong>
        <span>Vista</span>
    </div>

    <p>
        Este flujo permite separar responsabilidades: los modelos gestionan datos,
        los controladores coordinan la lógica y las vistas muestran la información al usuario.
    </p>
</section>