<?php
require_once 'config.php';

// Insecure database connection
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Vulnerable query function
function query($sql) {
    global $conn;
    return $conn->query($sql);
}

// Vulnerable escape function (doesn't properly prevent SQLi)
function escape($str) {
    global $conn;
    return $conn->real_escape_string($str);
}
?>