<?php
 require_once "../../../../classes/actions.php";
 require_once '../../../../db_connect.php';
 
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id=$_POST['user_id'];
    $oldPassword=trim($_POST['old']);
    $data=[
        'unHashPassword'=>$_POST['new'],
        'confirm'=>$_POST['confirm'],
    ];
 
    $validator=new Validation($data);
    $validator->changePassword();
    $usersDetails=new Actions;
    $response=[];
    // select from database from class
    $selectPass=$usersDetails->select("users","password","user_id='$id'");
    $hashPass=$selectPass['password'];

    if (empty($oldPassword)){
        $validator->addError('old','password is empty');
    }elseif(!$hashPass){
        $validator->addError('old','password not found');
    }elseif (!password_verify($oldPassword, $hashPass)) {
        $validator->addError('old','Old password is incorrect');
    }else{

    }
    

    if ($validator -> changePassword()) {
        // get updated data
        $pass=$validator->getData();
        $usersDetails->update('users',$pass,"user_id=".$id);
        $response=[
            'status'=>'success',
            'message'=>'password changed successfully'
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