<?php 
session_start();

// Hardcoded credentials for demo
$ADMIN_USERNAME = "admin";
$ADMIN_PASSWORD = "admin123";

if (isset($_SESSION['admin_id'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if ($username === $ADMIN_USERNAME && $password === $ADMIN_PASSWORD) {
        $_SESSION['admin_id'] = 1;
        $_SESSION['admin_username'] = $username;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau password salah!";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - MeowCare Expert</title>
    <link rel="stylesheet" href="../assets/admin/style.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background: linear-gradient(135deg, #FFF8E9 0%, #FFE8CC 100%);
        }
        
        .login-container {
            background: white;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(212, 195, 174, 0.25);
            width: 100%;
            max-width: 400px;
        }
        
        .login-container h1 {
            text-align: center;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="login-container">
    <h1>Login Admin</h1>
    
    <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo $error; ?></div>
    <?php endif; ?>

    <form method="POST" class="form">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Masukkan username" required autofocus>
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Masukkan password" required>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary" style="width: 100%;">Login</button>
        </div>
    </form>

    <p style="text-align: center; margin-top: 20px; color: #999; font-size: 12px;">
        Demo: username: <strong>admin</strong>, password: <strong>admin123</strong>
    </p>
</div>
</body>
</html>
