<?php
require_once "../../../../classes/actions.php";
require_once '../../../../db_connect.php';
  function generateUniqueToken() {
    return bin2hex(random_bytes(32)); // Generates a random token using 32 bytes of data
}
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email=[
        'email'=>$_POST['email']
    ];
    $id=$_POST['user_id'];

    $token = generateUniqueToken(); 
    $currentDateTime = new DateTime();
    $expirationDateTime = $currentDateTime->modify('+30 minutes');
    $expiryTimestamp = $expirationDateTime->format('Y-m-d H:i:s');
    
    $setToken=[
        'user_id'=>$id,
        'token'=>$token,
        'expiration'=>$expiryTimestamp
    ];
           //message to email
    $resetLink="http://localhost/vtuApp/user/pages/settings/updateForgotPin.php?token=" . $token;
    $subject="pin reset link";
    $message="click this link to reset your pin".$resetLink;


   $validator=new Validation($email);
    $usersDetails=new Actions;
    $selectedEmail=$usersDetails->select('users','email',"user_id='$id'");
     
    if ($selectedEmail['email'] !== $email['email']) {
        $validator->addError('email','this email is not related to this account');
    }
    
    if ($validator->validateEmail()) {
        // if (mail($email['email'],$subject,$message)) {
            
            // delete token if user_id exist
            $usersDetails->delete('password_reset_tokens','user_id='.$id);
            // add new tokens
            $usersDetails->addDataToDatabase("password_reset_tokens",$setToken);
            $usersDetails->closeConnection();
        $response=[
          'status'=>'success',
          'message'=>'Reset link sent successfully!'
        ];

        // }else {
        //     $response=[
        //         'status'=>'error',
        //         'message'=>'Failed to send link'
        //     ];
        // }
    }else {
        $err=$validator->getErrors();
        $response=[
            'status'=>'error',
            'message'=>$err
            ];

    }
    echo json_encode($response);
 }
?>