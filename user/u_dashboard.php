<?php 
session_start();
  require_once "../classes/actions.php";
  $checkLog=new Actions();
  $checkLog->checkLogin('vtu_user_id','user','../login.php');
  
 // echo $_SESSION['vtu_user_id']."</br>";
 // echo $_SESSION['vtu_email']."</br>";
 // echo $_SESSION['vtu_user_name']."</br>";
 // echo $_SESSION['vtu_role']."</br>";
 ?>
 <!DOCTYPE html>
 <html>
 	 <style type="text/css">
     html body{
      padding: 0;
      margin: 0;
    }
    body{
    display: flex;
    min-height: 100vh;
    flex-direction: column;
    margin: 2rem auto;
   font-family: 'Nunito', sans-serif;
}
#main{
    flex: 1 0 auto;
    height: 100%;
 }

#chart-container, canvas{
  margin:0 auto;
  width:80%;
}
 @media only screen and (max-width:400px){
  #chart-container, canvas{
  width:100%;
}
} 

	</style>
 <body>
   <?php include './navbar.php'; ?>
   <main>
   <div id="main" class="mt-5">
     <div class="balance p-3">
     <div class="container">
          <div class="row p-1">
              <div class="col-sm-4 eye">
                  <span>Balance</span</i> <i class="fa-regular fa-eye fonts small"></i><br>
                  <span>N20,000</span>
              </div>
              <div class="col-sm-4">
                  <a href="#">
                  <i class="fa-regular fa-plus fonts" aria-hidden="true"></i><br>
                  <span>fund wallet</span>
                  </a>
              </div>
              <div class="col-sm-4">
                  <a href="#">
                  <i class="fa fa-money-bill-transfer"></i><br>
                  <span>Transfer</span>
                  </a>
              </div>
            </div>
     </div>
      </div>
      <div class="services mt-4">
        <div class="container">
          <!-- <i class="fa fa-spinner fa-pulse fa-3x fa-fw"></i>
          <span class="sr-only">Loading...</span> -->
          <h5 class="p-2">Our servicecs</h5>
             <div class="row">
            <div class="col-sm-3">
                <a href="#" >
                <i class="fa-sharp fa-regular fa-signal fonts"></i><br>
                <span>Data</span>
                </a>
            </div>
            <div class="col-sm-3">
               <a href="#">
               <i class="fa-regular fa-phone fonts"></i><br>
                <span>Airtime</span>
               </a>
            </div>
            <div class="col-sm-3">
                <a href="#">
                <i class="fa-regular fa-tv fonts" aria-hidden="true"></i><br>
                <span>Tv</span>
                </a>
            </div>
            <div class="col-sm-3">
                <a href="#">
                <i class="fa-regular fa-lightbulb fonts"></i><br>
                <span>Electricity</span>
                </a>
            </div>
            <div class="col-sm-3">
             <a href="#">
             <i class="fa-regular fa-graduation-cap fonts"></i><br>
                <span>Exams</span>
             </a>
            </div>

             </div>
        </div>
      </div>
      <div class="anouncement">
         <h5 class="p-2 text-center">anouncement</h5>
        
      </div>
      <div class="footernavbar">
      <?php include './footernavbar.php'; ?>
      </div>
   	</div>
   </main>
 </body>
 </html>