<section class="tarjeta">
    <h2>Prueba de conexión a MySQL</h2>

    <p>
        Esta sección permite comprobar que la aplicación PHP puede conectarse correctamente
        con la base de datos MySQL utilizada por el sistema.
    </p>

    <?php if ($conexionExitosa): ?>
        <div class="alerta exito">
            Conexión realizada correctamente con la base de datos.
        </div>

        <div class="tabla-contenedor">
            <table class="tabla-datos">
                <tbody>
                    <tr>
                        <th>Base de datos</th>
                        <td><?= htmlspecialchars($baseDatos) ?></td>
                    </tr>
                    <tr>
                        <th>Servidor MySQL</th>
                        <td><?= htmlspecialchars($servidor) ?></td>
                    </tr>
                    <tr>
                        <th>Puerto utilizado</th>
                        <td><?= htmlspecialchars($puerto) ?></td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            <span class="estado estado-disponible">Conectado</span>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    <?php else: ?>
        <div class="alerta error">
            No se pudo conectar con la base de datos.
        </div>

        <p><strong>Error:</strong> <?= htmlspecialchars($errorConexion) ?></p>
    <?php endif; ?>

    <a class="boton" href="index.php">Volver al inicio</a>
</section>