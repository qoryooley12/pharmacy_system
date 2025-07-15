<?php
session_start();
include_once '../config/conn.php';
header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

if ($action == 'fetch_permissions') {
    $user_id = $_POST['user_id'] ?? 0;

    $stmt = $conn->prepare("SELECT permissions FROM users WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    $permissions = explode(",", $row['permissions'] ?? '');

    echo json_encode(["permissions" => $permissions]);
    exit;
}

elseif ($action == 'save_permissions') {
    $user_id = $_POST['user_id'] ?? 0;
    $permissions = $_POST['permissions'] ?? [];

    $permissions_string = implode(",", $permissions);

    $stmt = $conn->prepare("UPDATE users SET permissions = ? WHERE user_id = ?");
    $stmt->bind_param("si", $permissions_string, $user_id);
    $stmt->execute();

    echo json_encode(["success" => true, "message" => "Permissions updated"]);
    exit;
}

else {
    echo json_encode(["success" => false, "message" => "Invalid action."]);
    exit;
}
