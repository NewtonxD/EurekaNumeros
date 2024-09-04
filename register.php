<?php
session_start();
require('includesphp/conexion.php');

// Process registration form submission
$error = '';
$success = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $inputUsername = trim($_POST['username']);
    $inputEmail = trim($_POST['email']);
    $inputPassword = trim($_POST['password']);
    $inputConfirmPassword = trim($_POST['confirm_password']);

    // Basic validation
    if (empty($inputUsername) || empty($inputEmail) || empty($inputPassword) || empty($inputConfirmPassword)) {
        $error = 'Todos los campos son obligatorios.';
    } elseif (!filter_var($inputEmail, FILTER_VALIDATE_EMAIL)) {
        $error = 'Email Invalido.';
    } elseif ($inputPassword !== $inputConfirmPassword) {
        $error = 'Las contraseñas no encajan.';
    } else {
        // Check if username or email already exists
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE username = :username OR email = :email");
        $stmt->execute(['username' => $inputUsername, 'email' => $inputEmail]);
        if ($stmt->fetchColumn() > 0) {
            $error = 'Usuario o correo existente, intente con otro.';
        } else {
            // Hash the password
            $hashedPassword = password_hash($inputPassword, PASSWORD_DEFAULT);

            // Insert user into the database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, active) VALUES (:username, :email, :password, false)");
            if ($stmt->execute(['username' => $inputUsername, 'email' => $inputEmail, 'password' => $hashedPassword])) {
                $success = 'Registro exitoso! Ahora puedes iniciar sesion. <a href="login.php">LOG IN</a>.';
            } else {
                $error = 'Registro fallido! intentelo nuevamente.';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .register-container {
            width: 100%;
            max-width: 400px;
            padding: 15px;
            background-color: white;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>

<div class="register-container">
    <h2 class="text-center">Register</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($success): ?>
        <div class="alert alert-success" role="alert">
            <?php echo $success; ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="register.php">
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar Contraseña</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Registrar</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
