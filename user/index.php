<?php 
 session_start();
 require_once "../classes/actions.php";
    $checkLog=new Actions();
    $checkLog->checkLogin('vtu_user_id','user','../login.php');
?>
<!DOCTYPE html>
<html lang="en">
  <style>
 
  </style>
<body>
<?php include "includes/header.php" ?>
<div class="showNavbar"><?php include "includes/navbar.php" ?></div>
<!-----------nav bar for showing name of pages in phone only------------>
<div class="navbarHeader"><?php include "includes/navbarHeader.php" ?></div>
 <main >
 <?php 
          $page = isset($_GET['page']) ? $_GET['page'] : 'home';
        if(!file_exists($page.".php") && !is_dir($page)){
                include '404.html';
            }else{
              if(is_dir($page))
                include $page.'/index.php';
              else
                include $page.'.php';

            }

        ?>
       
 </main>
 <div class="footernavbar">
      <?php include './includes/footernavbar.php'; ?>
      </div>
</body>
</html>