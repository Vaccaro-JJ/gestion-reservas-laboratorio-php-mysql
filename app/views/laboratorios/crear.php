<section class="tarjeta">
    <h2>Registrar nuevo laboratorio</h2>

    <p>
        Complete el formulario para agregar un laboratorio disponible para reservas académicas.
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
          action="index.php?controller=laboratorios&action=guardar"
          onsubmit="return validarFormularioLaboratorio();">

        <div class="campo">
            <label for="nombre">Nombre del laboratorio</label>
            <input
                type="text"
                id="nombre"
                name="nombre"
                maxlength="100"
                required
                value="<?= htmlspecialchars($datos["nombre"] ?? "") ?>"
                placeholder="Ejemplo: Laboratorio de Software">
        </div>

        <div class="campo">
            <label for="ubicacion">Ubicación</label>
            <input
                type="text"
                id="ubicacion"
                name="ubicacion"
                maxlength="150"
                required
                value="<?= htmlspecialchars($datos["ubicacion"] ?? "") ?>"
                placeholder="Ejemplo: Bloque A - Piso 2">
        </div>

        <div class="campo">
            <label for="capacidad">Capacidad</label>
            <input
                type="number"
                id="capacidad"
                name="capacidad"
                min="1"
                required
                value="<?= htmlspecialchars($datos["capacidad"] ?? "") ?>"
                placeholder="Ejemplo: 30">
        </div>

        <div class="campo">
            <label for="estado">Estado</label>
            <select id="estado" name="estado" required>
                <option value="">Seleccione un estado</option>
                <option value="Disponible" <?= (($datos["estado"] ?? "") === "Disponible") ? "selected" : "" ?>>
                    Disponible
                </option>
                <option value="Mantenimiento" <?= (($datos["estado"] ?? "") === "Mantenimiento") ? "selected" : "" ?>>
                    Mantenimiento
                </option>
                <option value="Inactivo" <?= (($datos["estado"] ?? "") === "Inactivo") ? "selected" : "" ?>>
                    Inactivo
                </option>
            </select>
        </div>

        <div class="acciones">
            <button type="submit">Guardar laboratorio</button>
            <a class="boton boton-secundario" href="index.php?controller=laboratorios&action=index">
                Cancelar
            </a>
        </div>
    </form>
</section>