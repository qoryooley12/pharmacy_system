<?php
session_start();
include_once '../config/conn.php';

header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

if ($action == 'fetch') {

    $stmt = $conn->query("SELECT user_id, username, full_name, role, status, profile, created_data FROM users ORDER BY user_id DESC");
$users = [];

while ($row = $stmt->fetch_assoc()) {
    $name = $row['full_name'];
    $initials = getInitials($name);
    $users[] = [
        'user_id' => $row['user_id'],
        'username' => $row['username'],
        'full_name' => $row['full_name'],
        'role' => $row['role'],
        'status' => $row['status'],
        'profile' => $row['profile'],
        'initials' => $initials,
        'created_date' => $row['created_data'],
    ];
}

echo json_encode([
    'success' => true,
    'data' => $users
]);
exit;

} elseif ($action == 'add') {

    $full_name = $_POST['full_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $role = $_POST['role'] ?? '';
    $status = $_POST['status'] ?? '';
    $created_date = date("Y-m-d");

    // Upload profile image if provided
    $profile = '';
    if (!empty($_FILES['profile']['name'])) {
        $profileName = uniqid() . "_" . basename($_FILES['profile']['name']);
        $targetPath = "../assets/img/profiles/" . $profileName;
        if (move_uploaded_file($_FILES['profile']['tmp_name'], $targetPath)) {
            $profile = $profileName;
        }
    }

    // Insert user
    $stmt = $conn->prepare("INSERT INTO users (full_name, username, password, role, status, profile, created_data)
        VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $full_name,
        $username,
        $password,   // 🚫 plain text (for demo only)! hash it in production!
        $role,
        $status,
        $profile,
        $created_date
    ]);

    echo json_encode([
        'success' => true,
        'message' => 'User added successfully'
    ]);
    exit;

}elseif ($action == 'update') {

    $user_id = $_POST['user_id'] ?? '';
    $full_name = $_POST['full_name'] ?? '';
    $username = $_POST['username'] ?? '';
    $role = $_POST['role'] ?? '';
    $status = $_POST['status'] ?? '';

    if (empty($user_id)) {
        echo json_encode(['success' => false, 'message' => 'Missing user id']);
        exit;
    }

    $stmt = $conn->prepare("UPDATE users SET full_name = ?, username = ?, role = ?, status = ? WHERE user_id = ?");
    $stmt->bind_param("ssssi", $full_name, $username, $role, $status, $user_id);
    $stmt->execute();

    echo json_encode(['success' => true, 'message' => 'User updated successfully']);
    exit;
} elseif ($action == 'delete') {

    $user_id = $_POST['user_id'] ?? null;

    if ($user_id) {
        // Delete user
        $stmt = $conn->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        if ($stmt->execute()) {
            echo json_encode([
                'success' => true,
                'message' => 'User deleted successfully.'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Failed to delete user.'
            ]);
        }
    } else {
        echo json_encode([
            'success' => false,
            'message' => 'Invalid user ID.'
        ]);
    }
    exit;
}elseif ($action == 'fetch_users') {

    $stmt = $conn->query("SELECT user_id, full_name, role FROM users ORDER BY full_name ASC");

    $users = [];
    while ($row = $stmt->fetch_assoc()) {
        $users[] = [
            'user_id' => $row['user_id'],
            'full_name' => $row['full_name'],
            'role' => $row['role'],
        ];
    }

    echo json_encode(['success' => true, 'users' => $users]);
    exit;
}


 else {
    echo json_encode(['success' => false, 'message' => 'Invalid action.']);
    exit;
}


function getInitials($fullName) {
    $words = explode(" ", trim($fullName));
    $first = strtoupper(substr($words[0] ?? '', 0, 1));
    $last = strtoupper(substr(end($words) ?? '', 0, 1));
    return $first . $last;
}
?>
