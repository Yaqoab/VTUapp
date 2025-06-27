<?php
require_once '../db_connect.php'; // adjust path as needed
require_once '../classes/actions.php';

header('Content-Type: application/json');

$id = $_POST['id'] ?? null;
$column_to_delete = $_POST['column'] ?? null;
$table = $_POST['table'] ?? null;

if (!$id) {
    echo json_encode(['status' => 'error', 'message' => 'Missing plan ID']);
    exit;
}

$actions = new Actions();
$deleted = $actions->delete($table, $column_to_delete.' = '.$id);

if ($deleted) {
    echo json_encode(['status' => 'success', 'message' => 'deleted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to delete']);
}
?>