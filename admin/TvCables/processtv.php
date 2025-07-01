<?php
require_once '../../db_connect.php';
require_once '../../classes/actions.php';

header('Content-Type: application/json');

$actions = new Actions();

$id           = $_POST['id'] ?? null;
$planName     = trim($_POST['planName'] ?? '');
$cableID      = trim($_POST['cableID'] ?? '');
$cablePlanID  = trim($_POST['cablePlanID'] ?? '');
$amount       = trim($_POST['amount'] ?? '');
// Validate
if (empty($planName) || empty($cableID) || empty($cablePlanID) || empty($amount)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.']);
    exit;
}

$data = [
    'planName'     => $planName,
    'cableID'      => $cableID,
    'cablePlanID'  => $cablePlanID,
    'amount'  => $amount
];

if (!empty($id)) {
    // Update
    $updated = $actions->update('cable_plan_list', $data, "id = '$id'");
    if ($updated) {
        echo json_encode(['status' => 'success', 'message' => 'Cable plan updated successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update cable plan.']);
    }
} else {
    // Insert
    $inserted = $actions->addDataToDatabase('cable_plan_list', $data);
    if ($inserted) {
        echo json_encode(['status' => 'success', 'message' => 'Cable plan added successfully.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to add cable plan.']);
    }
}
