<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Formularios</title>
    <style>
        body { font-family: sans-serif; }
        .card { border:1px solid #ddd; padding:12px; margin:10px 0; border-radius:6px; }
        .row { display:flex; gap:12px; flex-wrap:wrap; }
        .row > div { flex:1 1 320px; }
        form.inline { display:inline; }
        small.meta { color:#555; }
        textarea { width:100%; min-height:70px; }
        input[type="text"], input[type="email"] { width:100%; }
        select { width:100%; }
        .filters, .create { border:1px solid #eee; padding:12px; border-radius:6px; }
    </style>
</head>
<body>
    <h1>Gestión de Formularios</h1>

    <?= $mensaje ?? '' ?>

    <!-- Filtros (GET) -->
    <div class="filters">
        <form method="GET">
            <div class="row">
                <div>
                    <label>Vía</label>
                    <select name="via">
                        <option value="">(todas)</option>
                        <option value="formulario" <?= (($_GET['via'] ?? '')==='formulario')?'selected':'' ?>>Formulario</option>
                        <option value="whatsapp"   <?= (($_GET['via'] ?? '')==='whatsapp')?'selected':'' ?>>WhatsApp</option>
                    </select>
                </div>
                <div>
                    <label>Estado</label>
                    <select name="estado">
                        <option value="">(todos)</option>
                        <option value="pendiente" <?= (($_GET['estado'] ?? '')==='pendiente')?'selected':'' ?>>Pendiente</option>
                        <option value="atendido"  <?= (($_GET['estado'] ?? '')==='atendido')?'selected':''  ?>>Atendido</option>
                        <option value="archivado" <?= (($_GET['estado'] ?? '')==='archivado')?'selected':'' ?>>Archivado</option>
                    </select>
                </div>
                <div style="align-self:end;">
                    <button type="submit">Aplicar filtros</button>
                    <a href="./">Limpiar</a>
                </div>
            </div>
        </form>
    </div>

    <h2>Listado</h2>
    <?php if (is_array($contactos)): ?>
        <?php if (empty($contactos)): ?>
            <p>No hay contactos para los filtros seleccionados.</p>
        <?php else: ?>
            <?php foreach ($contactos as $c): ?>
                <div class="card">
                    <strong><?= htmlspecialchars($c["nombre"] ?? '') ?></strong>
                    <span> (<?= htmlspecialchars($c["correo"] ?? '') ?>)</span>
                    <?php if (!empty($c["telefono"])): ?>
                        <span> - <?= htmlspecialchars($c["telefono"]) ?></span>
                    <?php endif; ?>
                    <br>
                    <small class="meta">
                        Vía: <?= htmlspecialchars($c["via"] ?? '') ?> ·
                        Estado: <?= htmlspecialchars($c["estado"] ?? '') ?> ·
                        Fecha: <?= htmlspecialchars($c["fechaEnvio"] ?? '') ?>
                    </small>
                    <p><?= nl2br(htmlspecialchars($c["mensaje"] ?? '')) ?></p>

                    <?php if (!empty($c["notas"])): ?>
                        <p><em>Notas:</em> <?= nl2br(htmlspecialchars($c["notas"])) ?></p>
                    <?php endif; ?>

                    <div class="row">
                        <!-- Actualizar -->
                        <div>
                            <form method="POST">
                                <input type="hidden" name="accion" value="actualizar">
                                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($c["id"] ?? '')) ?>">
                                <label>Estado</label>
                                <select name="estado" required>
                                    <option value="pendiente" <?= (($c["estado"] ?? '')==='pendiente')?'selected':'' ?>>Pendiente</option>
                                    <option value="atendido"  <?= (($c["estado"] ?? '')==='atendido')?'selected':''  ?>>Atendido</option>
                                    <option value="archivado" <?= (($c["estado"] ?? '')==='archivado')?'selected':'' ?>>Archivado</option>
                                </select>
                                <label>Notas</label>
                                <textarea name="notas" maxlength="500" placeholder="Añade una anotación para seguimiento..."></textarea>
                                <button type="submit">Guardar cambios</button>
                            </form>
                        </div>

                        <!-- Eliminar -->
                        <div>
                            <form method="POST" onsubmit="return confirm('¿Eliminar este contacto?');">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($c["id"] ?? '')) ?>">
                                <button type="submit">Eliminar</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    <?php else: ?>
        <p style="color:red;">No se pudo obtener la lista desde la API.</p>
    <?php endif; ?>

    <h2>Crear nuevo contacto</h2>
    <div class="create">
        <form method="POST">
            <input type="hidden" name="accion" value="crear">
            <div class="row">
                <div>
                    <label>Nombre *</label>
                    <input type="text" name="nombre" required maxlength="150">
                </div>
                <div>
                    <label>Correo</label>
                    <input type="email" name="correo" maxlength="100" placeholder="opcional">
                </div>
                <div>
                    <label>Teléfono</label>
                    <input type="text" name="telefono" maxlength="30" placeholder="opcional">
                </div>
                <div>
                    <label>Vía</label>
                    <select name="via">
                        <option value="">(por defecto: formulario)</option>
                        <option value="formulario">Formulario</option>
                        <option value="whatsapp">WhatsApp</option>
                    </select>
                </div>
            </div>
            <div>
                <label>Mensaje *</label>
                <textarea name="mensaje" required></textarea>
            </div>
            <div>
                <label>
                    <input type="checkbox" name="terminos" value="1" required>
                    Acepto los términos
                </label>
            </div>
            <button type="submit">Crear</button>
        </form>
    </div>
</body>
</html>

