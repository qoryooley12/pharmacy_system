<?php
// session_start();

if (!isset($_SESSION['user'])) {
    header("Location: http://localhost/pharmacy_system/auth/login.php");
    exit;
}

/**
 * Check if the logged-in user has permission to view this page.
 *
 * @param string $required_permission
 */
function requirePermission($required_permission) {
    if (!in_array($required_permission, $_SESSION['user']['permissions'])) {
        // Optional: show an error message or redirect
        header("Location: http://localhost/pharmacy_system/no-permission.php");
        exit;
    }
}
?>
