<?php 
  session_start();
  require_once '../db_connect.php';
  require_once "../classes/actions.php";


 if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
 $password = trim($_POST['password']);  
 $msg=[];
 $getData=new Actions();
 $validator=new Validation($data='');

  if(!empty($username)&& !empty($password)) {
    $emailverifying=$email;
    $table='admin';
    $columns='password';
    $condition="email ='$emailverifying'";
  
     $rows=$getData->select($table,"*","email ='$emailverifying'");
 
     if ($rows) {
        if (password_verify($password, $rows['password'])) {
                $_SESSION['authenticated_admin']=true;
                $_SESSION['vtu_admin_id']= $rows['id'];
                $_SESSION['vtu_admin_name']= $rows['username'];
                $_SESSION['vtu_role'] = 'admin';

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