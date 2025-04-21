<?php 
require_once "../classes/actions.php";
$checkLog=new Actions();
$checkLog->checkLogin('vtu_user_id','user','../login.php');
?>
<title>more</title>
<div id="main" class="mt-5">
  <div class="more p-3">
       <div class="column" style="font-size:17px;">
       <div>
            <a href="index.php?page=pages/settings/settings">
               <i class="fa fa-gear mr-2"></i>
                <span class="fs-4">Setting</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
          <div>
            <a href="index.php?page=pages/benefitiaries/benefitiaries">
               <i class="fa fa-book mr-2"></i>
                <span class="fs-4">Saved benefitiaries</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
          <div>
            <a href="#">
                <i class="fa-solid fa-money-bill mr-2"></i>
                <span>Pricing</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
          <div>
            <a href="#">
                <i class="fa-solid fa-calculator mr-2"></i>
                <span>Calculator</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
       </div>
  </div>
       <div class="container">
         <div class="logout">
           <a href="../logout.php" class="btn btn-info m-4"><i class="fas fa-sign-out-alt"></i> log out</a>
         </div>
       </div>
   </div>
</html>