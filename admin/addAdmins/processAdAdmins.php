<?php
require_once '../../db_connect.php';
require_once '../../classes/actions.php';

header('Content-Type: application/json');

// Sanitize input
$username    = trim($_POST['username'] ?? '');
$email       = trim($_POST['email'] ?? '');
$password    = $_POST['password'] ?? '';
$role       = trim($_POST['role'] ?? '');
$confirmPass = $_POST['confirm_password'] ?? '';

$validate = new Validation(['email' => $email]);

// Validate input
if (empty($username) || empty($email) || empty($password) || empty($confirmPass)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
    exit;
}
if (!$validate->validateEmail()) {
     $errors = $validate->getErrors();
    echo json_encode(['status' => 'error', 'message' => $errors['email']]);
    exit;
}
if ($password !== $confirmPass) {
    echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
    exit;
}

if (!preg_match('@[0-9]@', $password) || !preg_match('@[^\w]@', $password) || strlen($password) < 8) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Password must include at least one number, one special character, and be 8+ characters.'
    ]);
    exit;
}

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insert admin
$actions = new Actions();
$inserted = $actions->addDataToDatabase('admin', [
    'username' => $username,
    'email' => $email,
    'password' => $hashedPassword,
    'role' => $role
]);

if ($inserted) {
    echo json_encode(['status' => 'success', 'message' => 'Admin added successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add admin']);
}
?>
