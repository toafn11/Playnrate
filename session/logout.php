<?php
require_once '../includes/db-connect.php';
session_start();
session_unset();
session_destroy();
session_start();
$_SESSION['flash_success'] = "You have been logged out successfully!";
header("Location: ../index.php");
exit;
