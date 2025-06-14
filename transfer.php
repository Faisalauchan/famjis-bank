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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $to_account = $_POST['to_account'];
    $amount = $_POST['amount'];
    $description = $_POST['description'];
    
    // No CSRF protection!
    // No proper validation!
    
    // Check if recipient exists
    $sql = "SELECT * FROM users WHERE account_number = '$to_account'";
    $recipient = query($sql)->fetch_assoc();
    
    if (!$recipient) {
        $error = "Recipient account not found!";
    } elseif ($amount > $user['balance']) {
        $error = "Insufficient funds!";
    } else {
        // Perform transfer (vulnerable to XSS in description)
        $from_account = $user['account_number'];
        
        $sql = "INSERT INTO transactions (from_user, to_user, amount, description) 
                VALUES ('$from_account', '$to_account', $amount, '$description')";
        query($sql);
        
        // Update balances (vulnerable to race condition)
        query("UPDATE users SET balance = balance - $amount WHERE account_number = '$from_account'");
        query("UPDATE users SET balance = balance + $amount WHERE account_number = '$to_account'");
        
        $success = "Transfer successful!";
        
        // Refresh user data
        $user = query("SELECT * FROM users WHERE id = {$user['id']}")->fetch_assoc();
        $_SESSION['user'] = $user;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transfer - FAMJIS BANK</title>
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
        <section class="transfer-form">
            <h2>Transfer Funds</h2>
            
            <?php if($error): ?>
                <div class="alert alert-danger"><?= $error ?></div>
            <?php endif; ?>
            
            <?php if($success): ?>
                <div class="alert alert-success"><?= $success ?></div>
            <?php endif; ?>
            
            <form method="POST">
                <div class="form-group">
                    <label for="from_account">From Account</label>
                    <input type="text" id="from_account" value="<?= $user['account_number'] ?>" readonly>
                </div>
                
                <div class="form-group">
                    <label for="to_account">To Account</label>
                    <input type="text" id="to_account" name="to_account" required>
                </div>
                
                <div class="form-group">
                    <label for="amount">Amount</label>
                    <input type="number" id="amount" name="amount" min="0.01" step="0.01" max="<?= $user['balance'] ?>" required>
                </div>
                
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea id="description" name="description"></textarea>
                </div>
                
                <button type="submit" class="btn">Transfer</button>
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