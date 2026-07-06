<section class="tarjeta">
    <div class="encabezado-seccion">
        <div>
            <h2>Gestión de Laboratorios</h2>
            <p>
                Desde este módulo se pueden registrar, visualizar, editar y eliminar
                laboratorios académicos.
            </p>
        </div>

        <a class="boton" href="index.php?controller=laboratorios&action=crear">
            Nuevo laboratorio
        </a>
    </div>

    <?php if (empty($laboratorios)): ?>
        <div class="alerta error">
            No existen laboratorios registrados.
        </div>
    <?php else: ?>
        <div class="tabla-contenedor">
            <table class="tabla-datos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Ubicación</th>
                        <th>Capacidad</th>
                        <th>Estado</th>
                        <th>Fecha creación</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($laboratorios as $laboratorio): ?>
                        <?php
                            $estadoClase = strtolower($laboratorio["estado"]);
                        ?>

                        <tr>
                            <td><?= htmlspecialchars($laboratorio["id"]) ?></td>
                            <td><?= htmlspecialchars($laboratorio["nombre"]) ?></td>
                            <td><?= htmlspecialchars($laboratorio["ubicacion"]) ?></td>
                            <td><?= htmlspecialchars($laboratorio["capacidad"]) ?></td>
                            <td>
                                <span class="estado estado-<?= htmlspecialchars($estadoClase) ?>">
                                    <?= htmlspecialchars($laboratorio["estado"]) ?>
                                </span>
                            </td>
                            <td><?= htmlspecialchars($laboratorio["fecha_creacion"]) ?></td>
                            <td class="acciones-tabla">
                                <a class="boton boton-editar"
                                   href="index.php?controller=laboratorios&action=editar&id=<?= urlencode($laboratorio["id"]) ?>">
                                    Editar
                                </a>

                                <form method="POST"
                                    action="index.php?controller=laboratorios&action=eliminar"
                                    class="form-eliminar"
                                    onsubmit="return confirm('¿Está seguro de eliminar este laboratorio?');">

                                    <input type="hidden" name="id" value="<?= htmlspecialchars($laboratorio["id"]) ?>">

                                    <button type="submit" class="boton boton-eliminar">
                                        Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>

    <a class="boton boton-secundario" href="index.php">Volver al inicio</a>
</section>