<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos</title>
</head>
<body>
    <h1>Gestión de Pedidos</h1>

    <?= $mensaje ?? '' ?>

    <h2>Lista de pedidos</h2>
    <?php if (is_array($pedidos)): ?>
        <ul>
            <?php foreach ($pedidos as $p): ?>
                <li>
                    <?= htmlspecialchars($p["pedCodigo"] ?? '') ?> - 
                    <?= htmlspecialchars($p["pedComentarios"] ?? '') ?>
                    <form method="POST" style="display:inline;">
                        <input type="hidden" name="accion" value="eliminar">
                        <input type="hidden" name="id" value="<?= $p["pedId"] ?? '' ?>">
                        <button type="submit">Eliminar</button>
                    </form>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <p style="color:red;">No se pudieron obtener los pedidos.</p>
    <?php endif; ?>

    <h2>Crear nuevo pedido</h2>
    <form method="POST">
        <input type="hidden" name="accion" value="crear">
        <label>Código: <input type="text" name="pedCodigo" required></label><br>
        <label>Comentarios: <input type="text" name="pedComentarios" required></label><br>
        <label>Estado ID: <input type="number" name="estId" required></label><br>
        <label>Persona ID: <input type="number" name="perId" required></label><br>
        <label>Usuario ID: <input type="number" name="usuId" required></label><br>
        <button type="submit">Crear</button>
    </form>
</body>
</html>