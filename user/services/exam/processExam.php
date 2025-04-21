<?php
 require_once "../../../classes/actions.php";
 require_once '../../../db_connect.php';

  $processExam = new Actions();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $exam = trim($_POST["exam"]);
    $quantity = trim($_POST["quantity"]);
    $amount   = trim($_POST["amount"]);
    $pin      = trim($_POST["pin"]);
    $userId   = trim($_POST["userId"]);

    $user=$processExam->select("users","balance,pin","user_id='$userId'");
        $user_balance = $user['balance'];
        $hash_pin     = $user['pin'];
        $processExam->closeConnection();
    $err = [];

    if (empty($exam)) {
        $err["exam"] = "Exam required"; 
    }
    if ($quantity > 5) {
        $err["quantity"] = "Quantity should not exceed 5 unit";
    }
    
    if (empty($pin)) {
        $err['pin']='please enter pin';
     } elseif (!password_verify($pin, $hash_pin)) {
       $err['pin']='incorrect pin';
     }

     if (!empty($err)) {
        $response=[
         'status'=>'error',
         'data'=>$err
        ];
    }else {
    

    }

    echo json_encode($response);
}
?>