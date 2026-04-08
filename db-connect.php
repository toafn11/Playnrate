<?php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'game_rating');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="font-family:sans-serif;color:red;padding:20px;">
         <strong>Database connection failed:</strong> ' . htmlspecialchars($conn->connect_error) . '
         </div>');
}

$conn->set_charset('utf8mb4');
