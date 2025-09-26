<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f9fa;
        }
        h1, h2 {
            font-weight: bold;
            margin-bottom: 20px;
        }
        .form-container {
            background: #fff;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .logout {
            margin-top: 20px;
            display: inline-block;
        }
    </style>
</head>
<body>
    <div class="container py-4">

        <h1 class="text-center mb-4">Gestión de Usuarios con API Spring Boot</h1>

        <?php if (isset($_SESSION['jwt_token']) && !empty($usuarios)): ?>
            
            <!-- Formulario de agregar usuario -->
            <div class="row justify-content-center mb-4">
                <div class="col-md-6">
                    <div class="form-container">
                        <h2 class="h4">Registrar Nuevo Usuario</h2>
                        <?php echo $mensajeRegistro ?? ''; ?>
                        <form action="index.php?page=usuarios" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="reg-nombre" class="form-label">Nombre</label>
                                <input type="text" id="reg-nombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg-email" class="form-label">Correo</label>
                                <input type="email" id="reg-email" name="correo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg-password" class="form-label">Contraseña</label>
                                <input type="password" id="reg-password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Lista de usuarios -->
            <h2 class="h4">Lista de Usuarios</h2>
            <p>Has iniciado sesión correctamente. Aquí está la lista de usuarios:</p>
            
            <div class="table-responsive">
                <table class="table table-striped table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th>Activo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($usuarios as $usuario): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($usuario['id']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['nombre']); ?></td>
                                <td><?php echo htmlspecialchars($usuario['correo']); ?></td>
                                <td><?php echo $usuario['activo'] ? 'Sí' : 'No'; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <a href="index.php?page=usuarios&accion=logout" class="btn btn-danger logout">Cerrar Sesión</a>

        <?php else: ?>
            
            <!-- Login y Registro lado a lado -->
            <div class="row g-4 justify-content-center">
                <div class="col-md-5">
                    <div class="form-container">
                        <h2 class="h4">Iniciar Sesión</h2>
                        <?php echo $mensajeLogin ?? ''; ?>
                        <form action="index.php?page=usuarios" method="POST">
                            <input type="hidden" name="accion" value="login">
                            <div class="mb-3">
                                <label for="login-email" class="form-label">Correo</label>
                                <input type="email" id="login-email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="login-password" class="form-label">Contraseña</label>
                                <input type="password" id="login-password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Entrar</button>
                        </form>
                    </div>
                </div>
                <div class="col-md-5">
                    <div class="form-container">
                        <h2 class="h4">Registrar Nuevo Usuario</h2>
                        <?php echo $mensajeRegistro ?? ''; ?>
                        <form action="index.php?page=usuarios" method="POST">
                            <input type="hidden" name="accion" value="registrar">
                            <div class="mb-3">
                                <label for="reg-nombre" class="form-label">Nombre</label>
                                <input type="text" id="reg-nombre" name="nombre" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg-email" class="form-label">Correo</label>
                                <input type="email" id="reg-email" name="correo" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label for="reg-password" class="form-label">Contraseña</label>
                                <input type="password" id="reg-password" name="password" class="form-control" required>
                            </div>
                            <button type="submit" class="btn btn-success w-100">Registrar</button>
                        </form>
                    </div>
                </div>
            </div>

        <?php endif; ?>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
