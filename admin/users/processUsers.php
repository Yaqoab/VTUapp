<?php  
  session_start();
  require_once '../../db_connect.php';
  require_once "../../classes/actions.php";
$getUsers =new Actions();
 $adminName= $_SESSION['vtu_admin_name'];

function generateManualReference($userId = null) {
    $prefix = 'MAN';
    $date = date('Ymd'); // e.g. 20240618
    $uid = $userId ? 'UID' . $userId : '';
    $random = strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));

    return implode('-', array_filter([$prefix, $date, $uid, $random]));
}

if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    $users = $getUsers->select('users','user_id,username,email,image,phone,balance','','fetchAll');
    echo json_encode([
        'status' => 'success',
        'data' => $users
    ]);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_POST['id'] ?? '';
    $adjust = $_POST['adjust_balance'] ?? '';
    $updatedBy = $adminName;
    $reference = generateManualReference($userId);

  
    // Validate input
    if (!$userId || !is_numeric($adjust) || $adjust == 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid adjustment amount.'
        ]);
        exit;
    }

    // Fetch current balance
    $user = $getUsers->select('users', 'balance', "user_id='$userId'", 'fetch');
    if (!$user) {
        echo json_encode([
            'status' => 'error',
            'message' => 'User not found.'
        ]);
        exit;
    }

    $current = floatval($user['balance']);
    $adjust = floatval($adjust);
    $newBalance = $current + $adjust;

    if ($newBalance < 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Balance cannot be negative.'
        ]);
        exit;
    }
    // Update user balance
    $update = $getUsers->update('users', ['balance' => $newBalance], "user_id='$userId'");

    if ($update) {
        $getUsers->addDataToDatabase('deposit_history',[
          'cat_id' => 6,
          'user_id' => $userId,
          'method' => 'manual',
          'amount' => $adjust,  
          'status' => 'success',
          'reference' => $reference  
        ]);
        $getUsers->addDataToDatabase('notification',[
            'user_id' => $userId,
            'message' => $adjust.' by admin: '. $adminName,  
            'type' => 'Deposit',
            'reference' => $reference
        ]);
        // Log adjustment
        $getUsers->addDataToDatabase('balance_logs', [
            'user_id' => $userId,
            'previous_balance' => $current,
            'change_amount' => $adjust,
            'new_balance' => $newBalance,
            'updated_by' => $updatedBy
        ]);
        echo json_encode([
            'status' => 'success',
            'new_balance' => $newBalance,
            'message' => 'Balance updated successfully.'
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to update balance.'
        ]);
    }
}


?>