<section class="tarjeta">
    <h2>Editar reserva</h2>

    <p>
        Modifique los datos de la reserva seleccionada y guarde los cambios.
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

    <form class="formulario"
          method="POST"
          action="index.php?controller=reservas&action=actualizar"
          onsubmit="return validarFormularioReserva();">

        <input type="hidden" name="id" value="<?= htmlspecialchars($reserva["id"]) ?>">

        <div class="campo">
            <label for="laboratorio_id">Laboratorio</label>
            <select id="laboratorio_id" name="laboratorio_id" required>
                <option value="">Seleccione un laboratorio</option>

                <?php foreach ($laboratorios as $laboratorio): ?>
                    <option value="<?= htmlspecialchars($laboratorio["id"]) ?>"
                        <?= ((string) ($reserva["laboratorio_id"] ?? "") === (string) $laboratorio["id"]) ? "selected" : "" ?>>
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
                value="<?= htmlspecialchars($reserva["solicitante"] ?? "") ?>">
        </div>

        <div class="campo">
            <label for="fecha_reserva">Fecha de reserva</label>
            <input
                type="date"
                id="fecha_reserva"
                name="fecha_reserva"
                min="<?= date('Y-m-d') ?>"
                required
                value="<?= htmlspecialchars($reserva["fecha_reserva"] ?? "") ?>">
        </div>

        <div class="campo">
            <label for="hora_inicio">Hora de inicio</label>
            <input
                type="time"
                id="hora_inicio"
                name="hora_inicio"
                required
                value="<?= htmlspecialchars(substr($reserva["hora_inicio"] ?? "", 0, 5)) ?>">
        </div>

        <div class="campo">
            <label for="hora_fin">Hora de fin</label>
            <input
                type="time"
                id="hora_fin"
                name="hora_fin"
                required
                value="<?= htmlspecialchars(substr($reserva["hora_fin"] ?? "", 0, 5)) ?>">
        </div>

        <div class="campo">
            <label for="motivo">Motivo</label>
            <textarea
                id="motivo"
                name="motivo"
                rows="4"
                 maxlength="500"
                required><?= htmlspecialchars($reserva["motivo"] ?? "") ?></textarea>
        </div>

        <div class="campo">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
                <option value="">Seleccione un estado</option>
                <option value="Pendiente" <?= (($reserva["estado"] ?? "") === "Pendiente") ? "selected" : "" ?>>
                    Pendiente
                </option>
                <option value="Aprobada" <?= (($reserva["estado"] ?? "") === "Aprobada") ? "selected" : "" ?>>
                    Aprobada
                </option>
                <option value="Cancelada" <?= (($reserva["estado"] ?? "") === "Cancelada") ? "selected" : "" ?>>
                    Cancelada
                </option>
            </select>
        </div>

        <div class="acciones">
            <button type="submit">Actualizar reserva</button>
            <a class="boton boton-secundario" href="index.php?controller=reservas&action=index">
                Cancelar
            </a>
        </div>
    </form>
</section>