<?php 
  session_start();
  require_once './db_connect.php';
  require_once "./classes/actions.php";

//   $msg=$password="";
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
 $password = trim($_POST['password']);  
 $msg=[];
 $getData=new Actions();
 $validator=new Validation($data='');

  if(!empty($username)&& !empty($password)) {
    $emailverifying=$email;
    $table='users';
    $columns='password';
    $condition="email ='$emailverifying'";
   
     $rows=$getData->select($table,"*","email ='$emailverifying'");
 
     if ($rows) {
        if (password_verify($password, $rows['password'])) {
                $_SESSION['authenticated_user']=true;
                $_SESSION['vtu_user_id']= $rows['user_id'];
                $_SESSION['vtu_role'] = 'user';

          $msg =[
            "status"=>"success",
            "message"=>"logged succcessfully"
          ];
        }else{
          $msg =[
            "status" => "error",
            "message"=>"Your login details is incorrect!"
          ];
        }
     }else{
      $msg =[
        "status" => "error",
        "message"=>"User not found from provided inputs!"
      ];
     }

  } else {
    $msg =[
        "status" => "error",
        "message"=>"Please enter your login details!"
    ];
  }
  echo json_encode($msg);
 }
?>