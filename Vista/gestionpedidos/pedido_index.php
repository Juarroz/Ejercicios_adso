<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Pedidos</title>
    <style>
        body { font-family: sans-serif; }
        .card { border:1px solid #ddd; padding:12px; margin:10px 0; border-radius:6px; }
        .row { display:flex; gap:12px; flex-wrap:wrap; }
        .row > div { flex:1 1 200px; }
        textarea, input[type="text"], input[type="number"] { width:100%; }
    </style>
</head>
<body>
    <h1>Gestión de Pedidos</h1>

    <?= $mensaje ?? '' ?>

    <h2>Listado de Pedidos</h2>
    <?php if (!empty($pedidos)): ?>
        <?php foreach ($pedidos as $p): ?>
            <div class="card">
                <strong><?= htmlspecialchars($p["pedCodigo"] ?? '') ?></strong>
                <small> · ID: <?= htmlspecialchars($p["ped_id"] ?? '') ?></small>
                <br>
                <small>Fecha: <?= htmlspecialchars($p["pedFechaCreacion"] ?? '') ?></small>
                <p><?= nl2br(htmlspecialchars($p["pedComentarios"] ?? '')) ?></p>
                <small>Estado ID: <?= htmlspecialchars($p["estId"] ?? '') ?> | Persona ID: <?= htmlspecialchars($p["perId"] ?? '') ?> | Usuario ID: <?= htmlspecialchars($p["usuId"] ?? '') ?></small>

                <div class="row">
                    <div>
                        <form method="POST">
                            <input type="hidden" name="accion" value="actualizar">
                            <input type="hidden" name="id" value="<?= htmlspecialchars((string)($p["ped_id"] ?? '')) ?>">

                            <label>Código</label>
                            <input type="text" name="pedCodigo" value="<?= htmlspecialchars($p["pedCodigo"] ?? '') ?>" required>

                            <label>Comentarios</label>
                            <textarea name="pedComentarios" required><?= htmlspecialchars($p["pedComentarios"] ?? '') ?></textarea>

                            <label>Estado ID</label>
                            <input type="number" name="estId" value="<?= htmlspecialchars($p["estId"] ?? '') ?>">

                            <label>Persona ID</label>
                            <input type="number" name="perId" value="<?= htmlspecialchars($p["perId"] ?? '') ?>">

                            <label>Usuario ID</label>
                            <input type="number" name="usuId" value="<?= htmlspecialchars($p["usuId"] ?? '') ?>">

                            <button type="submit">Guardar cambios</button>
                        </form>
                    </div>

                    <div>
                        <form method="POST" onsubmit="return confirm('¿Eliminar este pedido?');">
                            <input type="hidden" name="accion" value="eliminar">
                            <input type="hidden" name="id" value="<?= htmlspecialchars((string)($p["ped_id"] ?? '')) ?>">
                            <button type="submit">Eliminar</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No hay pedidos registrados.</p>
    <?php endif; ?>

    <h2>Crear nuevo pedido</h2>
    <form method="POST">
        <input type="hidden" name="accion" value="crear">
        <label>Código *</label>
        <input type="text" name="pedCodigo" required>

        <label>Comentarios *</label>
        <textarea name="pedComentarios" required></textarea>

        <label>Estado ID</label>
        <input type="number" name="estId">

        <label>Persona ID</label>
        <input type="number" name="perId">

        <label>Usuario ID</label>
        <input type="number" name="usuId">

        <button type="submit">Crear pedido</button>
    </form>
</body>
</html>
