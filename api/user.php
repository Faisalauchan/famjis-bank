<?php
header('Content-Type: application/json');
require_once '../includes/db.php';

$user_id = $_GET['id']; // No auth check!
$sql = "SELECT * FROM users WHERE id = $user_id";
echo json_encode(query($sql)->fetch_assoc());
?>