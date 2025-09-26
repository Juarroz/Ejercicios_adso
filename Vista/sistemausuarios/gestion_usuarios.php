<!-- ================================
vista/sistemausuarios/usuario_index.php
================================ -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <style>
        body { font-family: sans-serif; }
        .card { border:1px solid #ddd; padding:12px; margin:10px 0; border-radius:6px; }
        .row { display:flex; gap:12px; flex-wrap:wrap; }
        .row > div { flex:1 1 280px; }
        form.inline { display:inline; }
        small.meta { color:#555; }
        textarea { width:100%; min-height:70px; }
        input[type="text"], input[type="email"], input[type="password"] { width:100%; }
        select { width:100%; }
        .filters, .create { border:1px solid #eee; padding:12px; border-radius:6px; }
    </style>
</head>
<body>
    <h1>Gestión de Usuarios</h1>

    <?= $mensaje ?? '' ?>

    <!-- Filtros (GET) -->
    <div class="filters">
        <form method="GET">
            <div class="row">
                <div>
                    <label>Rol</label>
                    <select name="rolId">
                        <option value="">(todos)</option>
                        <option value="1" <?= (($_GET['rolId'] ?? '')==='1')?'selected':'' ?>>Usuario</option>
                        <option value="2" <?= (($_GET['rolId'] ?? '')==='2')?'selected':'' ?>>Administrador</option>
                        <option value="3" <?= (($_GET['rolId'] ?? '')==='3')?'selected':'' ?>>Diseñador</option>
                    </select>
                </div>
                <div>
                    <label>Activo</label>
                    <select name="activo">
                        <option value="">(todos)</option>
                        <option value="true" <?= (($_GET['activo'] ?? '')==='true')?'selected':'' ?>>Sí</option>
                        <option value="false" <?= (($_GET['activo'] ?? '')==='false')?'selected':'' ?>>No</option>
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
    <?php if (is_array($usuarios) && isset($usuarios["content"])): ?>
        <?php if (empty($usuarios["content"])): ?>
            <p>No hay usuarios para los filtros seleccionados.</p>
        <?php else: ?>
            <?php foreach ($usuarios["content"] as $u): ?>
                <div class="card">
                    <strong><?= htmlspecialchars($u["nombre"] ?? '') ?></strong>
                    <span> (<?= htmlspecialchars($u["correo"] ?? '') ?>)</span>
                    <?php if (!empty($u["telefono"])): ?>
                        <span> - <?= htmlspecialchars($u["telefono"]) ?></span>
                    <?php endif; ?>
                    <br>
                    <small class="meta">
                        Rol: <?= htmlspecialchars($u["rolNombre"] ?? '') ?> ·
                        Activo: <?= ($u["activo"] ? "Sí" : "No") ?> ·
                        Origen: <?= htmlspecialchars($u["origen"] ?? '') ?>
                    </small>
                    <?php if (!empty($u["docnum"])): ?>
                        <p><em>Documento:</em> <?= htmlspecialchars($u["docnum"]) ?> (<?= htmlspecialchars($u["tipdocNombre"] ?? '') ?>)</p>
                    <?php endif; ?>

                    <div class="row">
                        <!-- Actualizar -->
                        <div>
                            <form method="POST">
                                <input type="hidden" name="accion" value="actualizar">
                                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($u["id"] ?? '')) ?>">
                                <label>Rol</label>
                                <select name="rolId" required>
                                    <option value="1" <?= (($u["rolId"] ?? '')==1)?'selected':'' ?>>Usuario</option>
                                    <option value="2" <?= (($u["rolId"] ?? '')==2)?'selected':'' ?>>Administrador</option>
                                    <option value="3" <?= (($u["rolId"] ?? '')==3)?'selected':'' ?>>Diseñador</option>
                                </select>
                                <label>Activo</label>
                                <select name="activo">
                                    <option value="true" <?= ($u["activo"]?'selected':'') ?>>Sí</option>
                                    <option value="false" <?= (!$u["activo"]?'selected':'') ?>>No</option>
                                </select>
                                <button type="submit">Guardar cambios</button>
                            </form>
                        </div>

                        <!-- Eliminar -->
                        <div>
                            <form method="POST" onsubmit="return confirm('¿Eliminar este usuario?');">
                                <input type="hidden" name="accion" value="eliminar">
                                <input type="hidden" name="id" value="<?= htmlspecialchars((string)($u["id"] ?? '')) ?>">
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

    <h2>Crear nuevo usuario</h2>
    <div class="create">
        <form method="POST">
            <input type="hidden" name="accion" value="crear">
            <div class="row">
                <div>
                    <label>Nombre *</label>
                    <input type="text" name="nombre" required maxlength="150">
                </div>
                <div>
                    <label>Correo *</label>
                    <input type="email" name="correo" required maxlength="100">
                </div>
                <div>
                    <label>Teléfono</label>
                    <input type="text" name="telefono" maxlength="20" placeholder="opcional">
                </div>
                <div>
                    <label>Password *</label>
                    <input type="password" name="password" required minlength="8">
                </div>
                <div>
                    <label>Número documento</label>
                    <input type="text" name="docnum" maxlength="20" placeholder="opcional">
                </div>
                <div>
                    <label>Tipo documento</label>
                    <select name="tipdocId">
                        <option value="">(ninguno)</option>
                        <option value="1">Cédula de ciudadanía</option>
                        <option value="2">Cédula de extranjería</option>
                        <option value="3">Pasaporte</option>
                    </select>
                </div>
                <div>
                    <label>Rol *</label>
                    <select name="rolId" required>
                        <option value="1">Usuario</option>
                        <option value="2">Administrador</option>
                        <option value="3">Diseñador</option>
                    </select>
                </div>
                <div>
                    <label>Activo</label>
                    <select name="activo">
                        <option value="true">Sí</option>
                        <option value="false" selected>No</option>
                    </select>
                </div>
                <div>
                    <label>Origen</label>
                    <select name="origen">
                        <option value="registro">Registro</option>
                        <option value="formulario" selected>Formulario</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <button type="submit">Crear</button>
        </form>
    </div>
</body>
</html>
