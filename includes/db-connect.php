<?php
session_start();
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'playnrate');

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if ($conn->connect_error) {
    die('<div style="font-family:sans-serif;color:red;padding:20px;">
         <strong>Database connection failed:</strong> ' . htmlspecialchars($conn->connect_error) . '
         </div>');
}

$conn->set_charset('utf8mb4');

// Determine base path for assets (how many levels deep we are)
$projectRoot = str_replace('\\', '/', realpath(dirname(__DIR__)));
$currentScriptDir = str_replace('\\', '/', realpath(dirname($_SERVER['SCRIPT_FILENAME'])));
$depth = max(0, substr_count($currentScriptDir, '/') - substr_count($projectRoot, '/'));
$baseUrl = $depth === 0 ? './' : str_repeat('../', $depth);
