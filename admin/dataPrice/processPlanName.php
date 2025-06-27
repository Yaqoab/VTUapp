<?php
require_once '../../db_connect.php';
require_once '../../classes/actions.php';

header('Content-Type: application/json');

$actions = new Actions();

// Sanitize inputs
$network   = trim($_POST['network'] ?? '');
$plan_name = trim($_POST['plan_name'] ?? '');

// Validate input
if (empty($network) || empty($plan_name)) {
    echo json_encode(['status' => 'error', 'message' => 'All fields are required.', 'w'=> $_POST]);
    exit;
}

// Prepare data
$data = [
    'networks_id' => $network,
    'Plan_name'   => $plan_name,
];

// Add new only
$inserted = $actions->addDataToDatabase('dataplantype', $data);

if ($inserted) {
    echo json_encode(['status' => 'success', 'message' => 'Plan added successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to add plan.']);
}
?>
