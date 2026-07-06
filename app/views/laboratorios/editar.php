<section class="tarjeta">
    <h2>Editar laboratorio</h2>

    <p>
        Modifique los datos del laboratorio seleccionado y guarde los cambios.
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
          action="index.php?controller=laboratorios&action=actualizar"
          onsubmit="return validarFormularioLaboratorio();">

        <input type="hidden" name="id" value="<?= htmlspecialchars($laboratorio["id"]) ?>">

        <div class="campo">
            <label for="nombre">Nombre del laboratorio</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                maxlength="100"
                required
                value="<?= htmlspecialchars($laboratorio["nombre"] ?? "") ?>">
        </div>

        <div class="campo">
            <label for="ubicacion">Ubicación</label>
            <input
                type="text"
                id="ubicacion"
                name="ubicacion"
                maxlength="150"
                required
                value="<?= htmlspecialchars($laboratorio["ubicacion"] ?? "") ?>">
        </div>

        <div class="campo">
            <label for="capacidad">Capacidad</label>
            <input
                type="number"
                id="capacidad"
                name="capacidad"
                min="1"
                required
                value="<?= htmlspecialchars($laboratorio["capacidad"] ?? "") ?>">
        </div>

        <div class="campo">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
                <option value="">Seleccione un estado</option>
                <option value="Disponible" <?= (($laboratorio["estado"] ?? "") === "Disponible") ? "selected" : "" ?>>
                    Disponible
                </option>
                <option value="Mantenimiento" <?= (($laboratorio["estado"] ?? "") === "Mantenimiento") ? "selected" : "" ?>>
                    Mantenimiento
                </option>
                <option value="Inactivo" <?= (($laboratorio["estado"] ?? "") === "Inactivo") ? "selected" : "" ?>>
                    Inactivo
                </option>
            </select>
        </div>

        <div class="acciones">
            <button type="submit">Actualizar laboratorio</button>
            <a class="boton boton-secundario" href="index.php?controller=laboratorios&action=index">
                Cancelar
            </a>
        </div>
    </form>
</section>