<?php
session_start();
require_once 'includes/db.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Weak hashing
    
    // Deliberately vulnerable SQL query
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    $result = query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $_SESSION['user'] = $user;
        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid credentials! SQL: " . $sql; // Error shows SQL query (vulnerability)
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FAMJIS BANK</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <img src="assets/images/logo.svg" alt="FAMJIS BANK" class="logo">
            <nav>
                <a href="index.php">Home</a>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="auth-form">
            <h2>Login to Your Account</h2>
            
            <?php if($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <button type="submit" class="btn">Login</button>
            </form>
            
            <p>Don't have an account? <a href="register.php">Register here</a></p>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 FAMJIS BANK. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>