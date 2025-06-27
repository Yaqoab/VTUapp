<?php
require_once '../../db_connect.php';
require_once '../../classes/actions.php';

header('Content-Type: application/json');

$actions = new Actions();

// Collect & sanitize
$id       = $_POST['id'] ?? null;
$plan_id  = $_POST['plan_id'] ?? '';
$data_id  = trim($_POST['data_id'] ?? '');
$amount   = floatval($_POST['Amount'] ?? 0);
$size     = trim($_POST['size'] ?? '');
$validity = trim($_POST['Validity'] ?? '');

// Validation
if (empty($plan_id) || empty($data_id) || $amount <= 0 || empty($size) || empty($validity)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.','n'=>$_POST]);
    exit;
}

$data = [
    'plan_id'  => $plan_id,
    'data_id'  => $data_id,
    'Amount'   => $amount,
    'size'     => $size,
    'Validity' => $validity
];

// Update or insert
if (!empty($id)) {
    $updated = $actions->update('datapricelist', $data, "id = '$id'");
    echo json_encode($updated
        ? ['status' => 'success', 'message' => 'Data price updated successfully.']
        : ['status' => 'error', 'message' => 'Failed to update data price.']);
} else {
    $inserted = $actions->addDataToDatabase('datapricelist', $data);
    echo json_encode($inserted
        ? ['status' => 'success', 'message' => 'Data price added successfully.']
        : ['status' => 'error', 'message' => 'Failed to add data price.']);
}
$actions->closeConnection();
?>