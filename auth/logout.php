<?php
session_start();

// Destroy the session completely
session_unset();
session_destroy();

// Redirect to login page
header("Location: http://localhost/pharmacy_system/auth/login.php");
exit;
