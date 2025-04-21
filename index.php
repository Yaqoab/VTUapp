<!DOCTYPE html>
<html lang="en">
<?php include"includes/header.php" ?>
<body>
<?php include"includes/navbar.php" ?>
</body>
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
 <?php include"includes/footer.php" ?>
</html>