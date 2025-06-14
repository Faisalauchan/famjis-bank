<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

$user = $_SESSION['user'];
$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['profile_pic'])) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES['profile_pic']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // No proper file validation!
    
    if (move_uploaded_file($_FILES['profile_pic']['tmp_name'], $target_file)) {
        // Update database with file path (vulnerable to path traversal)
        $sql = "UPDATE users SET profile_pic = '$target_file' WHERE id = {$user['id']}";
        query($sql);
        
        $success = "Profile picture updated successfully!";
        
        // Refresh user data
        $user = query("SELECT * FROM users WHERE id = {$user['id']}")->fetch_assoc();
        $_SESSION['user'] = $user;
    } else {
        $error = "Sorry, there was an error uploading your file.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Picture - FAMJIS BANK</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <header>
        <div class="container">
            <img src="assets/images/logo.svg" alt="FAMJIS BANK" class="logo">
            <nav>
                <a href="dashboard.php">Dashboard</a>
                <a href="transfer.php">Transfer</a>
                <a href="account.php">Account</a>
                <a href="statements.php">Statements</a>
                <a href="logout.php">Logout</a>
            </nav>
        </div>
    </header>

    <main class="container">
        <section class="profile-pic">
            <h2>Update Profile Picture</h2>
            
            <?php if($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <div class="current-pic">
                <?php if($user['profile_pic']): ?>
                    <img src="<?= $user['profile_pic'] ?>" alt="Profile Picture">
                <?php else: ?>
                    <div class="default-pic">👤</div>
                <?php endif; ?>
            </div>
            
            <form method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="profile_pic">Choose a file</label>
                    <input type="file" id="profile_pic" name="profile_pic" required>
                </div>
                
                <button type="submit" class="btn">Upload</button>
            </form>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 FAMJIS BANK. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>