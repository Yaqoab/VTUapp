<?php
  require_once "../../../classes/actions.php";
  require_once '../../../db_connect.php';
  
  $usersDetails=new Actions;
  function generateTransactionReference() {
    return 'TXN-' . strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 10));
}
  // get preview user data that display before transfer
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if(isset($_GET['id'])){
        $recieverId=$_GET['id'];
    }
      $details=$usersDetails->select('users','username,phone,image,balance',"user_id='$recieverId'");
       $response=[
         'status'=>'success',
         'message'=>$details
       ];
      echo json_encode($response);
  }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
    $senderId=$_POST['user_id'];
    $receiverId=$_POST['reciever_id'];
    $amount=trim($_POST['amount']);
    $remark=trim($_POST['remark']);
    $pin=trim($_POST['pin']);
    $reference = generateTransactionReference();

    $senderDetails=$usersDetails->select('users','balance,pin',"user_id='$senderId'");
    $recieverDetails=$usersDetails->select('users','balance,username',"user_id='$receiverId'");

    $hashPin=$senderDetails['pin'];
     $errors=[];
     
     if (empty($amount)) {
      $errors['amount']='Empty amount';
     }elseif(!is_numeric($amount)){
      $errors['amount']='it should be numeric';
     }elseif($senderDetails['balance'] < 100 || $amount > $senderDetails['balance']){
      $errors['amount']="insufficient balance remain ₦$senderDetails[balance]";
     }elseif ($amount < 100) {
      $errors['amount']="it should start from ₦100";
     }else{
        
     }
      
     if (empty($pin)) {
      $errors['pin']='Empty pin';
     }elseif (!password_verify($pin, $hashPin)) {
      $errors['pin']='invalid pin';
     }else{
      
     }
    
     if (empty($errors['amount']) && empty($errors['pin'])) {
         $senderBalance=$senderDetails['balance'];
         $recieverBalance=$recieverDetails['balance'];
            
         $senderTotal=['balance'=>$senderBalance - $amount];
         $recieverTotal=['balance'=>$recieverBalance + $amount];
      
        $isSent = $usersDetails->update('users', $senderTotal, "user_id=" . $senderId);
        $isReceived = $usersDetails->update('users', $recieverTotal, "user_id=" . $receiverId);
        $get_user=$usersDetails->select("users","username","user_id='$senderId'");
      
      if ($isSent && $isReceived) {
         $transData=[
          'cat_id'=> 3,
          'sender_id'=>$senderId,
          'receiver_id'=>$receiverId,
          'amount'=>$amount,
          'remark'=>$remark,
          'status'=>'success',
          'reference' => $reference
         ];
         $usersDetails->addDataToDatabase("transfer",$transData);
          $lastId=$connect->lastInsertId();
          $senerNotification=[
            'user_id'=>$senderId,
            'message'=>'Balance sent to '.$recieverDetails['username'],
            'type' => 'transfer',
            'reference'=>$reference
          ];
          $recieverNotification=[
            'user_id'=>$receiverId,
            'message'=>'Balance received from '.$get_user['username'],
            'type' => 'transfer',
            'reference'=>$reference
          ];
          $usersDetails->addDataToDatabase("notification",$senerNotification);
          $usersDetails->addDataToDatabase("notification",$recieverNotification);
          $response = [
              'status' => 'success',
              'message' => 'Transfer successful',
          ];
      } else {
          $response = [
              'status' => 'failed',
              'message' => 'Transfer failed',
          ];
      }
            
     }else{
      $response=[
        'status'=>'error',
        'message'=>$errors,
        'pin'=>$hashPin,
      ];
     }
    
   

    echo json_encode($response);
  }else{

  }
?>