<?php
   require_once "../../../../classes/actions.php";
   require_once '../../../../db_connect.php';
   
   if($_SERVER['REQUEST_METHOD'] === "POST") {
      $data=[
        'pin'=>$_POST['pin'],
        'confirmPin'=>$_POST['confirm']
      ];
      $id=$_POST['user_id'];
      $password=trim($_POST['password']);
      
      $usersDetails=new Actions;
      $validator=new Validation($data);
      $validator->validatePin();
      
        // select from database from class reference
    $selectPass=$usersDetails->select("users","password","user_id='$id'");
    $hashPass=$selectPass['password'];
       // select pin to check if not empty
    $checkPin=$usersDetails->select("users","pin","user_id='$id'");
  
    if(empty($password)) {
      $validator->addError('passwords','password is empty');
  }elseif (empty($hashPass)) {
      $validator->addError('passwords','password not found');
      
  }elseif(!password_verify($password, $hashPass)) {
      $validator->addError('passwords','password is incorrect');
  }else{
     
      }
     
      if ($validator->validatePin()) {
        $dat=$validator->getData();
        $newPin=password_hash($dat['pin'], PASSWORD_DEFAULT);
        $newPinData=['pin'=>$newPin];
         //update pin in database table reference from class
         $usersDetails->update("users",$newPinData,"user_id =".$id);
        $response=[
          'status'=>'success',
          'message'=>'new pin created successfully'
        ];
      }else{
      $err=$validator->getErrors();
      $response=[
        'status'=>'error',
        'message'=>$err
      ];
      }
      echo json_encode($response);
  }
?>