<?php
session_start();
if (isset($_SESSION['authenticated_admin']) || $_SESSION['authenticated_admin'] == true) {
    $_SESSION['vtu_admin_id']   ="";
    $_SESSION['vtu_email'] ="";
    unset($_SESSION['authenticated_admin']);
    unset($_SESSION['vtu_admin_name']);
    unset($_SESSION['vtu_role']);
  // Redirect the user to the login page
  if(empty($_SESSION['vtu_admin_id'])) header("location:../admin/adminlogin.php");
  exit();
}


?>