<?php
session_start();

// Process login form submission
$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    include('includesphp/conexion.php');
    $inputUsername = trim($_POST['username']);
    $inputPassword = trim($_POST['password']);

    // Query to find user by username
    $pdo = connect_pdo();
    $stmt = $pdo->prepare("SELECT id, username, password FROM users WHERE username = :username and active");
    $stmt->execute(['username' => $inputUsername]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($inputPassword, $user['password'])) {
        // Password is correct, log the user in
        session_regenerate_id();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => 'localhost', // Set your domain here
            //'secure' => true,  // Ensure this is true for HTTPS
            'httponly' => true,
            'samesite' => 'Strict',  // or 'Lax'
        ]);
        header("Location: index.php");
        exit();
    } else {
        $error = 'Invalid username or password.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link  href="./src/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .login-container {
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

<div class="login-container">
    <h2 class="text-center">Login</h2>

    <?php if ($error): ?>
        <div class="alert alert-danger" role="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <form method="POST" action="login.php">
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" class="form-control" id="username" name="username" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Contraseña</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
    <p>No tienes usuario? <a href="register.php">Registrate</a></p>
</div>

<script src="./src/js/bootstrap.bundle.min.js" ></script>
</body>
</html>
