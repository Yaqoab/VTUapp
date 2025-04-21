<?php
   require_once "../../../../classes/actions.php";
   require_once '../../../../db_connect.php';
   
   $usersDetails=new Actions;
   if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
      $id = $_GET['id'];

      $details=$usersDetails->select("users","pin","user_id='$id'");
         $data = array(
            'status' => 'success',
            'message' => $details['pin'],
        );
        echo json_encode($data);
    }else{
      echo json_encode(array(
        'status' => 'error',
        'message' => 'Parameter "id" is missing or incorrect for select action'
    ));
    }

   }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data=[
        'pin'=>$_POST['newpin'],
        'confirmPin'=>$_POST['confirmPin']
      ];
      $id=$_POST['user_id'];
      $oldPin=trim($_POST['oldpin']);

      $validator=new Validation($data);
      $validator->validatePin();
      
      $selectPass=$usersDetails->select("users","pin","user_id='$id'");
      $hashPass=$selectPass['pin'];
      if (empty($oldPin)) {
        $validator->addError("oldPin","pin is empty");
      }elseif (!password_verify($oldPin, $hashPass)) {
        $validator->addError("oldPin","old pin is incorrect");
      }else{

      }
      if ($validator->validatePin()) {
         // get updated pin data
         $pin=$validator->getData();
         $hashPin=password_hash($pin['pin'],PASSWORD_DEFAULT);
         $pinData=['pin'=>$hashPin];
         $usersDetails->update('users',$pinData,"user_id=".$id);

        $response=[
            'status'=>'success',
            'message'=>'transaction pin changed',
            'data'=>$hashPin
        ];
      }else{
        $getErr=$validator->getErrors();
        $response=[
           'status'=>'error',
           'message'=>$getErr
        ];
          }
    echo json_encode($response);
  }
?>