<section class="tarjeta">
    <h2>Registrar nueva reserva</h2>

    <p>
        Complete el formulario para registrar una reserva asociada a un laboratorio disponible.
    </p>

    <?php if (!empty($errores)): ?>
        <div class="alerta error">
            <strong>Revise los siguientes errores:</strong>
            <ul>
                <?php foreach ($errores as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <?php if (empty($laboratorios)): ?>
        <div class="alerta error">
            No existen laboratorios disponibles para registrar reservas.
            Primero debe crear o activar un laboratorio con estado Disponible.
        </div>

        <a class="boton boton-secundario" href="index.php?controller=reservas&action=index">
            Volver al listado
        </a>
    <?php else: ?>
        <form class="formulario"
              method="POST"
              action="index.php?controller=reservas&action=guardar"
              onsubmit="return validarFormularioReserva();">

            <div class="campo">
                <label for="laboratorio_id">Laboratorio</label>
                <select id="laboratorio_id" name="laboratorio_id" required>
                    <option value="">Seleccione un laboratorio</option>

                    <?php foreach ($laboratorios as $laboratorio): ?>
                        <option value="<?= htmlspecialchars($laboratorio["id"]) ?>"
                            <?= ((string) ($datos["laboratorio_id"] ?? "") === (string) $laboratorio["id"]) ? "selected" : "" ?>>
                            <?= htmlspecialchars($laboratorio["nombre"]) ?>
                            -
                            <?= htmlspecialchars($laboratorio["ubicacion"]) ?>
                            |
                            <?= htmlspecialchars($laboratorio["estado"]) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="campo">
                <label for="solicitante">Solicitante</label>
                <input
                    type="text"
                    id="solicitante"
                    name="solicitante"
                    maxlength="120"
                    required
                    value="<?= htmlspecialchars($datos["solicitante"] ?? "") ?>"
                    placeholder="Ejemplo: Jonathan Vaccaro">
            </div>

            <div class="campo">
                <label for="fecha_reserva">Fecha de reserva</label>
                <input
                    type="date"
                    id="fecha_reserva"
                    name="fecha_reserva"
                    min="<?= date('Y-m-d') ?>"
                    required
                    value="<?= htmlspecialchars($datos["fecha_reserva"] ?? "") ?>">
            </div>

            <div class="campo">
                <label for="hora_inicio">Hora de inicio</label>
                <input
                    type="time"
                    id="hora_inicio"
                    name="hora_inicio"
                    required
                    value="<?= htmlspecialchars($datos["hora_inicio"] ?? "") ?>">
            </div>

            <div class="campo">
                <label for="hora_fin">Hora de fin</label>
                <input
                    type="time"
                    id="hora_fin"
                    name="hora_fin"
                    required
                    value="<?= htmlspecialchars($datos["hora_fin"] ?? "") ?>">
            </div>

            <div class="campo">
                <label for="motivo">Motivo</label>
                <textarea
                    id="motivo"
                    name="motivo"
                    rows="4"
                    maxlength="500"
                    required
                    placeholder="Ejemplo: Clase práctica de Desarrollo de Aplicaciones Web"><?= htmlspecialchars($datos["motivo"] ?? "") ?></textarea>
            </div>

            <div class="campo">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="">Seleccione un estado</option>
                    <option value="Pendiente" <?= (($datos["estado"] ?? "") === "Pendiente") ? "selected" : "" ?>>
                        Pendiente
                    </option>
                    <option value="Aprobada" <?= (($datos["estado"] ?? "") === "Aprobada") ? "selected" : "" ?>>
                        Aprobada
                    </option>
                    <option value="Cancelada" <?= (($datos["estado"] ?? "") === "Cancelada") ? "selected" : "" ?>>
                        Cancelada
                    </option>
                </select>
            </div>

            <div class="acciones">
                <button type="submit">Guardar reserva</button>
                <a class="boton boton-secundario" href="index.php?controller=reservas&action=index">
                    Cancelar
                </a>
            </div>
        </form>
    <?php endif; ?>
</section>
