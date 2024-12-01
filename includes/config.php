<?php
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'loginsystem');

$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

if (!$con) {
    error_log("Database connection failed: " . mysqli_connect_error(), 0);
    die("Sorry, we are experiencing technical difficulties. Please try again later.");
}
?>
