<?php
session_start();
  require_once "../../../../classes/actions.php";
  require_once '../../../../db_connect.php';
 $tokens=new Actions;
 
 if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   if (isset($_GET['token'])) {
      $token=$_GET['token'];
      
      $selectTokens = $tokens->select("password_reset_tokens", "user_id, expiration", "token='$token'");
        $currentTimestamp = new DateTime();
        $expireTime = $currentTimestamp->format('Y-m-d H:i:s');
        if (!$selectTokens || $selectTokens['expiration'] < $expireTime) {
          $response = [
              'status' => 'expired',
              'message' => "Invalid token or expire after 30mins. Please request another pin reset.",
              'time' => $currentTimestamp
          ];
          // exit;
      } else {
        $_SESSION['userId']=$selectTokens['user_id'];
          $response = [
              'status' => 'success',
              'message' => "Token is valid.",
          ];
      }

      echo json_encode($response);
   }else{

   }
 }elseif($_SERVER['REQUEST_METHOD'] === 'POST'){
  $data=[
    'pin'=>$_POST['newpin'],
    'confirmPin'=>$_POST['confirmPin']
  ];
  $validator=new Validation($data);
  
   if (isset($_SESSION['userId'])) {
    $id=$_SESSION['userId'];   
      if ($validator->validatePin()) {
        $pin=$validator->getData();
        $hashPin=password_hash($pin['pin'],PASSWORD_DEFAULT);
        $pinData=['pin'=>$hashPin];
        // updaate new pin
        $tokens->update('users',$pinData,"user_id=".$id);
        // delete token by user id if exist
        $tokens->delete('password_reset_tokens','user_id='.$id);
        // delete id in session set after getting token
        unset($_SESSION['userId']);
        $response=[
          'status'=>'success',
          'message'=>'transaction pin changed'
        ];
       }else{
        $err=$validator->getErrors();
        $response=[
          'status'=>'error',
          'message'=>$err
        ];
      }    
   }else{
     $response=[
      'status'=>'expired',
     ];
    }
     
    


   echo json_encode($response);
 }

?>