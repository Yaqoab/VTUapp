<?php
session_start();
if (isset($_SESSION['authenticated_user']) || $_SESSION['authenticated_user'] == true) {
  $_SESSION['vtu_user_id']   ="";
  $_SESSION['vtu_email'] ="";
  unset($_SESSION['authenticated_user']);
  unset($_SESSION['vtu_user_name']);
  unset($_SESSION['vtu_role']);
// Redirect the user to the login page
if(empty($_SESSION['vtu_admin_id'])) header("location:login.php");
exit();
}


?>