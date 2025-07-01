<?php
require_once '../../db_connect.php';
require_once '../../classes/actions.php';
session_start();

// Sanitize input
$username        = trim($_POST['username'] ?? '');
$email        = trim($_POST['email'] ?? '');
$newPassword     = $_POST['new_password'] ?? '';
$confirmPassword = $_POST['confirm_password'] ?? '';
$adminId         = $_SESSION['vtu_admin_id'] ?? null;

$validate = new Validation(['email' => $email]);
// Check if user is logged in
if (!$adminId) {
    echo json_encode(['status' => 'error', 'message' => 'Session expired or unauthorized']);
    exit;
}

// Validate username
if (empty($username)) {
    echo json_encode(['status' => 'error', 'message' => 'Username is required']);
    exit;
}

if (!$validate->validateEmail()) {
    $errors = $validate->getErrors();
   echo json_encode(['status' => 'error', 'message' => $errors['email']]);
   exit;
}

// Prepare update data
$updateData = ['username' => $username];
$updateData = ['email'    => $email];

// If password is provided, validate it
if (!empty($newPassword)) {
    // Check confirm match
    if ($newPassword !== $confirmPassword) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
        exit;
    }

    // Validate strength
    $hasNumber = preg_match('@[0-9]@', $newPassword);
    $hasSpecial = preg_match('@[^\w]@', $newPassword);
    $hasMinLength = strlen($newPassword) >= 8;

    if (!$hasNumber || !$hasSpecial || !$hasMinLength) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Password must include at least one number, one special character, and be at least 8 characters long.'
        ]);
        exit;
    }

    // Hash password
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $updateData['password'] = $hashedPassword;
}

// Update in database
$actions = new Actions();
$updated = $actions->update('admin', $updateData, "id = '$adminId'");

if ($updated) {
    echo json_encode(['status' => 'success', 'message' => 'Admin updated successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to update admin']);
}
?>
