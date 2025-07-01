<?php
require_once '../../db_connect.php';
require_once '../../classes/actions.php';
session_start();

if ($_SESSION['vtu_role'] !== 'super_admin') {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

$id = $_POST['id'] ?? null;
$role = $_POST['role'] ?? '';

if (!$id || empty($role)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}

$allowedRoles = ['admin', 'super_admin'];
if (!in_array($role, $allowedRoles)) {
    echo json_encode(['status' => 'error', 'message' => 'Invalid role']);
    exit;
}

$actions = new Actions();
$updated = $actions->update('admin', ['role' => $role], "id = '$id'");

if ($updated) {
    echo json_encode(['status' => 'success', 'message' => 'Role updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update role']);
}
?>
