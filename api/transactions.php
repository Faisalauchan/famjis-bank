<?php
header('Content-Type: application/json');
require_once '../includes/db.php';

$account = $_GET['account'];
// No rate limiting or auth check
$sql = "SELECT * FROM transactions WHERE from_user = '$account' OR to_user = '$account'";
echo json_encode(query($sql)->fetch_all(MYSQLI_ASSOC));
?>