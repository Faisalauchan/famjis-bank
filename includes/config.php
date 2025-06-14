<?php
// Deliberately insecure configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'famjisbank');

// Hardcoded admin credentials (vulnerability)
define('ADMIN_USER', 'admin');
define('ADMIN_EMAIL', 'admin@famjisbank.com');
define('ADMIN_PASS', 'admin123');

// Insecure encryption key (vulnerability)
define('ENC_KEY', 'thisisnotsecure123');

// Session configuration (insecure)
ini_set('session.cookie_httponly', 0);
ini_set('session.cookie_secure', 0);
?>