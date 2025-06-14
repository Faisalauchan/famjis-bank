<?php
// No admin check!
session_start();
require_once '../includes/db.php';

// SQLi-vulnerable search
$search = $_GET['search'] ?? '';
$sql = "SELECT * FROM users WHERE username LIKE '%$search%'";
$users = query($sql);
?>

<table>
  <?php while($user = $users->fetch_assoc()): ?>
  <tr>
    <td><?= $user['username'] ?></td>
    <td><?= $user['email'] ?></td>
    <td><?= $user['balance'] ?></td>
    <!-- IDOR: Edit any user -->
    <td><a href="../account.php?id=<?= $user['id'] ?>">Edit</a></td>
  </tr>
  <?php endwhile; ?>
</table>