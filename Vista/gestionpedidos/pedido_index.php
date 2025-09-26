<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <title>Gestión de Pedidos</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body { font-family: "Inter", "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; }
    .card { border-radius: .5rem; }
    textarea, input[type="text"], input[type="number"] { resize: vertical; }
  </style>
</head>
<body class="container py-4">
  <h1 class="mb-3 text-center">Gestión de Pedidos</h1>

  <div class="mb-3"><?= $mensaje ?? '' ?></div>

  <!-- Form crear nuevo pedido -->
  <div class="card mb-4">
    <div class="card-body">
      <h2 class="h5 mb-3">Crear nuevo pedido</h2>
      <form method="POST" class="row g-3">
        <input type="hidden" name="accion" value="crear">
        <div class="col-md-6">
          <label class="form-label">Código *</label>
          <input class="form-control" type="text" name="pedCodigo" required>
        </div>
        <div class="col-md-6">
          <label class="form-label">Comentarios *</label>
          <textarea class="form-control" name="pedComentarios" required></textarea>
        </div>
        <div class="col-md-4"><label class="form-label">Estado ID</label><input type="number" name="estId" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Personalización ID</label><input type="number" name="perId" class="form-control"></div>
        <div class="col-md-4"><label class="form-label">Usuario ID</label><input type="number" name="usuId" class="form-control"></div>
        <div class="col-12"><button class="btn btn-primary" type="submit">Crear pedido</button></div>
      </form>
    </div>
  </div>

  <h2 class="h5 mb-3">Listado de Pedidos</h2>
  <?php if (!empty($pedidos)): ?>
    <div class="row">
      <?php foreach ($pedidos as $p): 
        $id = htmlspecialchars((string)($p["ped_id"] ?? ''));
        $formUpdId = "formUpdate-{$id}";
        $formDelId = "formDelete-{$id}";
      ?>
      <div class="col-md-6">
        <div class="card shadow-sm mb-3">
          <div class="card-body">
            <h5 class="card-title mb-1"><?= htmlspecialchars($p["pedCodigo"] ?? '') ?></h5>
            <h6 class="card-subtitle text-muted mb-2">ID: <?= $id ?></h6>
            <p class="text-muted mb-2">Fecha: <?= htmlspecialchars($p["pedFechaCreacion"] ?? '') ?></p>
            <p><?= nl2br(htmlspecialchars($p["pedComentarios"] ?? '')) ?></p>
            <small class="text-muted">Estado ID: <?= htmlspecialchars($p["estId"] ?? '') ?> | Persona ID: <?= htmlspecialchars($p["perId"] ?? '') ?> | Usuario ID: <?= htmlspecialchars($p["usuId"] ?? '') ?></small>

            <!-- FORMULARIO DE ACTUALIZAR (forma separada, asociado a botón con attribute form) -->
            <form id="<?= $formUpdId ?>" method="POST" class="mt-3">
              <input type="hidden" name="accion" value="actualizar">
              <input type="hidden" name="id" value="<?= $id ?>">
              <div class="row g-2">
                <div class="col-12 col-sm-6">
                  <label class="form-label form-label-sm">Código</label>
                  <input class="form-control form-control-sm" type="text" name="pedCodigo" value="<?= htmlspecialchars($p["pedCodigo"] ?? '') ?>" required>
                </div>
                <div class="col-12 col-sm-6">
                  <label class="form-label form-label-sm">Estado ID</label>
                  <input class="form-control form-control-sm" type="number" name="estId" value="<?= htmlspecialchars($p["estId"] ?? '') ?>">
                </div>
                <div class="col-12">
                  <label class="form-label form-label-sm">Comentarios</label>
                  <textarea class="form-control form-control-sm" name="pedComentarios" rows="2" required><?= htmlspecialchars($p["pedComentarios"] ?? '') ?></textarea>
                </div>
                <div class="col-6 col-sm-4">
                  <label class="form-label form-label-sm">Personalización ID</label>
                  <input class="form-control form-control-sm" type="number" name="perId" value="<?= htmlspecialchars($p["perId"] ?? '') ?>">
                </div>
                <div class="col-6 col-sm-4">
                  <label class="form-label form-label-sm">Usuario ID</label>
                  <input class="form-control form-control-sm" type="number" name="usuId" value="<?= htmlspecialchars($p["usuId"] ?? '') ?>">
                </div>
              </div>
            </form>

            <!-- FORMULARIO DE ELIMINAR (vacío visualmente) -->
            <form id="<?= $formDelId ?>" method="POST" onsubmit="return confirm('¿Eliminar este pedido?');" class="d-none">
              <input type="hidden" name="accion" value="eliminar">
              <input type="hidden" name="id" value="<?= $id ?>">
            </form>

            <!-- BOTONES (externos, apuntan a cada form usando attribute 'form') -->
            <div class="d-flex gap-2 mt-3">
              <button type="submit" form="<?= $formUpdId ?>" class="btn btn-sm btn-success">Guardar cambios</button>
              <button type="submit" form="<?= $formDelId ?>" class="btn btn-sm btn-danger">Eliminar</button>
            </div>

          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  <?php else: ?>
    <p class="text-muted">No hay pedidos registrados.</p>
  <?php endif; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
