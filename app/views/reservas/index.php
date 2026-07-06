<section class="tarjeta">
    <div class="encabezado-seccion">
        <div>
            <h2>Gestión de Reservas</h2>
            <p>
                Desde este módulo se pueden registrar, visualizar, editar y eliminar
                reservas asociadas a los laboratorios académicos.
            </p>
        </div>

        <a class="boton" href="index.php?controller=reservas&action=crear">
            Nueva reserva
        </a>
    </div>

    <?php if (empty($reservas)): ?>
        <div class="alerta error">
            No existen reservas registradas.
        </div>
    <?php else: ?>
        <div class="tabla-contenedor">
            <table class="tabla-datos">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Laboratorio</th>
                        <th>Solicitante</th>
                        <th>Fecha</th>
                        <th>Horario</th>
                        <th>Motivo</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach ($reservas as $reserva): ?>
                        <?php
                            $estadoClase = strtolower($reserva["estado"]);
                            $horaInicio = substr($reserva["hora_inicio"], 0, 5);
                            $horaFin = substr($reserva["hora_fin"], 0, 5);
                        ?>

                        <tr>
                            <td><?= htmlspecialchars($reserva["id"]) ?></td>
                            <td><?= htmlspecialchars($reserva["laboratorio"]) ?></td>
                            <td><?= htmlspecialchars($reserva["solicitante"]) ?></td>
                            <td><?= htmlspecialchars($reserva["fecha_reserva"]) ?></td>
                            <td>
                                <?= htmlspecialchars($horaInicio) ?>
                                -
                                <?= htmlspecialchars($horaFin) ?>
                            </td>
                            <td><?= htmlspecialchars($reserva["motivo"]) ?></td>
                            <td>
                                <span class="estado estado-<?= htmlspecialchars($estadoClase) ?>">
                                    <?= htmlspecialchars($reserva["estado"]) ?>
                                </span>
                            </td>
                            <td class="acciones-tabla">
                                <a class="boton boton-editar"
                                   href="index.php?controller=reservas&action=editar&id=<?= urlencode($reserva["id"]) ?>">
                                    Editar
                                </a>

                                <<form method="POST"
                                    action="index.php?controller=reservas&action=eliminar"
                                    class="form-eliminar"
                                    onsubmit="return confirm('¿Está seguro de eliminar esta reserva?');">

                                    <input type="hidden" name="id" value="<?= htmlspecialchars($reserva["id"]) ?>">

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