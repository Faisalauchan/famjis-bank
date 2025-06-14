<?php
session_start();
require_once 'includes/db.php';

if (!isset($_SESSION['user'])) {
    header('Location: login.php');
    exit();
}

// Get user data (vulnerable to IDOR)
$user_id = $_GET['id'] ?? $_SESSION['user']['id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$user = query($sql)->fetch_assoc();

// Get transactions
$account_number = $user['account_number'];
$transactions = query("SELECT * FROM transactions WHERE from_user = '$account_number' OR to_user = '$account_number' ORDER BY timestamp DESC LIMIT 5");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - FAMJIS BANK</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/dashboard.css">
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
        <section class="welcome">
            <h2>Welcome, <?= htmlspecialchars($user['username']) ?></h2>
            <p>Last login: <?= date('Y-m-d H:i:s') ?></p>
        </section>

        <section class="balance-card">
            <h3>Account Balance</h3>
            <div class="amount">$<?= number_format($user['balance'], 2) ?></div>
            <div class="account-number">Account: <?= $user['account_number'] ?></div>
        </section>

        <section class="quick-actions">
            <a href="transfer.php" class="action-btn">
                <span>💸</span>
                <span>Transfer</span>
            </a>
            <a href="account.php" class="action-btn">
                <span>👤</span>
                <span>Profile</span>
            </a>
            <a href="statements.php" class="action-btn">
                <span>📊</span>
                <span>Statements</span>
            </a>
        </section>

        <section class="recent-transactions">
            <h3>Recent Transactions</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($tx = $transactions->fetch_assoc()): ?>
                    <tr>
                        <td><?= $tx['timestamp'] ?></td>
                        <td><?= $tx['description'] ?></td>
                        <td class="<?= $tx['from_user'] == $account_number ? 'text-danger' : 'text-success' ?>">
                            <?= $tx['from_user'] == $account_number ? '-' : '+' ?>$<?= number_format($tx['amount'], 2) ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2023 FAMJIS BANK. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>