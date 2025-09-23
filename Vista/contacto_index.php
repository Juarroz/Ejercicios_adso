<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Contactos</title>
</head>
<body>
    <h1>Gestión de Contactos</h1>

    <?= $mensaje ?? '' ?>

    <h2>Lista de contactos</h2>
    <?php if (is_array($contactos)): ?>
        <ul>
            <?php foreach ($contactos as $c): ?>
                <li>
                    <?= htmlspecialchars($c["nombre"] ?? '') ?> - 
                    <?= htmlspecialchars($c["correo"] ?? '') ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?= $c["conId"] ?? '' ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p style="color:red;">No se pudieron obtener los contactos.</p>
    <?php endif; ?>

    <h2>Crear nuevo contacto</h2>
    <form method="POST">
        <input type="hidden" name="accion" value="crear">
        <label>Nombre: <input type="text" name="nombre" required></label><br>
        <label>Correo: <input type="email" name="correo" required></label><br>
        <label>Teléfono: <input type="text" name="telefono"></label><br>
        <label>Mensaje: <textarea name="mensaje"></textarea></label><br>
        <button type="submit">Crear</button>
    </form>
</body>
</html>
