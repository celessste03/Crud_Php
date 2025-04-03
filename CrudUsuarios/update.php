<?php 
include("connection.php");
$con = connection();
$id = isset($_GET['id']) ? $_GET['id'] : null;

if (!$id) {
    die("ID de usuario no proporcionado");
}

$sql = "SELECT * FROM users WHERE id = ?";
$stmt = mysqli_prepare($con, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$query = mysqli_stmt_get_result($stmt);

if (!$row = mysqli_fetch_array($query)) {
    die("Usuario no encontrado");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Usuario</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #7b2cbf;
            --primary-light: #9d4edd;
            --secondary: #5a189a;
            --dark: #10002b;
            --light: #f8f9fa;
            --success: #b5179e;
            --danger: #f72585;
            --warning: #ff9e00;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Roboto', sans-serif;
            background-color: #f8f0fc;
            color: var(--dark);
            line-height: 1.6;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .edit-container {
            max-width: 800px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 30px;
        }

        h1 {
            color: var(--dark);
            font-weight: 500;
            font-size: 1.8rem;
            margin-bottom: 20px;
            text-align: center;
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            color: var(--dark);
        }

        input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e0aaff;
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: var(--transition);
            background-color: #f8f0ff;
        }

        input:focus {
            border-color: var(--primary-light);
            outline: none;
            box-shadow: 0 0 0 3px rgba(123, 44, 191, 0.2);
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            text-align: center;
            width: 100%;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--secondary);
            transform: translateY(-2px);
        }

        .btn-secondary {
            background-color: white;
            color: var(--primary);
            border: 1px solid var(--primary);
            margin-top: 10px;
        }

        .btn-secondary:hover {
            background-color: #f8f0ff;
        }

        @media (max-width: 768px) {
            .form-grid {
                grid-template-columns: 1fr;
            }
            
            body {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="edit-container">
        <div class="card">
            <h1><i class="fas fa-user-edit"></i> Editar Usuario</h1>
            
            <form action="edit_user.php" method="POST">
                <input type="hidden" name="id" value="<?= htmlspecialchars($row['id']) ?>">
                
                <div class="form-grid">
                    <div class="form-group">
                        <label for="name">Nombre</label>
                        <input type="text" id="name" name="name" placeholder="Nombre" 
                               value="<?= htmlspecialchars($row['name']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="lastname">Apellidos</label>
                        <input type="text" id="lastname" name="lastname" placeholder="Apellidos" 
                               value="<?= htmlspecialchars($row['lastname']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" id="username" name="username" placeholder="Username" 
                               value="<?= htmlspecialchars($row['username']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Contraseña</label>
                        <input type="password" id="password" name="password" placeholder="••••••••" 
                               value="<?= htmlspecialchars($row['password']) ?>" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Correo Electrónico</label>
                        <input type="email" id="email" name="email" placeholder="Email" 
                               value="<?= htmlspecialchars($row['email']) ?>" required>
                    </div>
                </div>
                
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Guardar Cambios
                </button>
                
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Volver al Listado
                </a>
            </form>
        </div>
    </div>
</body>
</html>