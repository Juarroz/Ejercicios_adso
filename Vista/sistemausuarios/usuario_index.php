<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    <link rel="stylesheet" href="Assets/css/estilos.css">
</head>
<body>
    <h1>Gestión de Usuarios con API Spring Boot</h1>

    <?php // Si el usuario ha iniciado sesión, muestra la lista de usuarios ?>
    <?php if (isset($_SESSION['jwt_token']) && !empty($usuarios)): ?>
        
        <h2>Bienvenido</h2>
        <p>Has iniciado sesión correctamente. Aquí está la lista de usuarios:</p>
        
        <table>
            <thead>
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

        <a href="index.php?page=usuarios&accion=logout" class="logout">Cerrar Sesión</a>

    <?php else: ?>
        
        <?php // Si no, muestra los formularios de login y registro ?>
        <div class="container">
            <div class="col">
                <h2>Iniciar Sesión</h2>
                <?php echo $mensajeLogin ?? ''; ?>
                <form action="index.php?page=usuarios" method="POST">
                    <input type="hidden" name="accion" value="login">
                    <label for="login-email">Correo:</label>
                    <input type="email" id="login-email" name="email" required>
                    <label for="login-password">Contraseña:</label>
                    <input type="password" id="login-password" name="password" required>
                    <input type="submit" value="Entrar">
                </form>
            </div>
            <div class="col">
                <h2>Registrar Nuevo Usuario</h2>
                <?php echo $mensajeRegistro ?? ''; ?>
                <form action="index.php?page=usuarios" method="POST">
                    <input type="hidden" name="accion" value="registrar">
                    <label for="reg-nombre">Nombre:</label>
                    <input type="text" id="reg-nombre" name="nombre" required>
                    <label for="reg-email">Correo:</label>
                    <input type="email" id="reg-email" name="correo" required>
                    <label for="reg-password">Contraseña:</label>
                    <input type="password" id="reg-password" name="password" required>
                    <input type="submit" value="Registrar">
                </form>
            </div>
        </div>
        
    <?php endif; ?>

</body>
</html>