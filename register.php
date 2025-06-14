<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = md5($_POST['password']); // Weak hashing
    $email = $_POST['email'];
    $account_number = rand(10000000, 99999999);

    // No password complexity check
    $sql = "INSERT INTO users (username, password, email, account_number) 
            VALUES ('$username', '$password', '$email', '$account_number')";
    query($sql);
}
?>
<!-- Form with no client-side validation -->