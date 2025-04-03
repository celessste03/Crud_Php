<?php
include("connection.php");
$con = connection();

try {
    $sql = "SELECT * FROM users";
    $query = mysqli_query($con, $sql);
    if (!$query) throw new Exception(mysqli_error($con));
} catch (Exception $e) {
    $error = "Error al cargar usuarios: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Usuarios</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="CSS/style.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>Sistema de Gestión de Usuarios</h1>
            <p>Administración completa de usuarios registrados</p>
        </header>

        <main>
            <?php if (isset($error)): ?>
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <section class="card">
                <h2><i class="fas fa-user-plus"></i> Crear Nuevo Usuario</h2>
                <form action="insert_user.php" method="POST">
                    <div class="form-grid">
                        <div class="form-group">
                            <label for="name">Nombre</label>
                            <input type="text" id="name" name="name" placeholder="Ej: Juan" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="lastname">Apellidos</label>
                            <input type="text" id="lastname" name="lastname" placeholder="Ej: Pérez García" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="username">Usuario</label>
                            <input type="text" id="username" name="username" placeholder="Ej: juanpg" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="password">Contraseña</label>
                            <input type="password" id="password" name="password" placeholder="••••••••" required>
                        </div>
                        
                        <div class="form-group">
                            <label for="email">Correo Electrónico</label>
                            <input type="email" id="email" name="email" placeholder="Ej: juan@example.com" required>
                        </div>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Usuario
                    </button>
                </form>
            </section>

            <section class="card">
                <h2><i class="fas fa-users"></i> Usuarios Registrados</h2>
                
                <?php if (isset($query) && mysqli_num_rows($query) > 0): ?>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellidos</th>
                                <th>Usuario</th>
                                <th>Contraseña</th>
                                <th>Email</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row = mysqli_fetch_assoc($query)): ?>
                                <tr>
                                    <td><?= htmlspecialchars($row['id']) ?></td>
                                    <td><?= htmlspecialchars($row['name']) ?></td>
                                    <td><?= htmlspecialchars($row['lastname']) ?></td>
                                    <td><?= htmlspecialchars($row['username']) ?></td>
                                    <td class="password-cell">••••••••</td>
                                    <td><?= htmlspecialchars($row['email']) ?></td>
                                    <td class="actions">
                                        <a href="update.php?id=<?= $row['id'] ?>" class="btn-icon btn-edit" title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_user.php?id=<?= $row['id'] ?>" class="btn-icon btn-delete" title="Eliminar">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> No hay usuarios registrados en el sistema.
                    </div>
                <?php endif; ?>
            </section>
        </main>
    </div>
</body>
</html>