<?php
// No admin permission check!
session_start();
require_once '../includes/db.php';

$logfile = $_GET['logfile'] ?? 'app.log';
$logs = file_get_contents("../logs/" . $logfile); // LFI possible
?>

<pre><?= htmlspecialchars($logs) ?></pre>