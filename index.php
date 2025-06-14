<?php
session_start();
require_once 'includes/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAMJIS BANK - Premium Banking</title>
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
        <section class="hero">
            <h1>Welcome to FAMJIS BANK</h1>
            <p>Your trusted partner in premium banking services</p>
            <div class="cta">
                <a href="register.php" class="btn">Open Account</a>
                <a href="login.php" class="btn btn-outline">Online Banking</a>
            </div>
        </section>

        <!-- XSS vulnerability in search -->
        <div class="search">
            <form action="search.php" method="GET">
                <input type="text" name="q" placeholder="Search...">
                <button type="submit">Go</button>
            </form>
            <?php if(isset($_GET['q'])): ?>
                <p>Search results for: <?= $_GET['q'] ?></p>
            <?php endif; ?>
        </div>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 FAMJIS BANK. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>