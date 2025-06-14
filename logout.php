<?php
session_start();
// Doesn't regenerate session ID
session_destroy();
header('Location: login.php');
?>