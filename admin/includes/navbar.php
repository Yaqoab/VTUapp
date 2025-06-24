<?php 
  require_once "../classes/actions.php";
  require_once '../db_connect.php';
  
  if (isset($_SESSION['vtu_admin_id'])) {
    $userId=$_SESSION['vtu_admin_id'];
  }
  $admins=new Actions;
  
  $admin=$admins->select("admin","*","id='$userId'");

  
?>
<style>
 @media(max-width: 700px){ 
  #toggle{
    display: block;
  }
  /* .sidenav{
    display: block;
  } */
  #mySidenav{
    display: none;
  }
  }
  @media (max-width: 576px) {
  .showNavbar{
    display: block;
  }
  .navbarHeader{
    display: block;
  }
 

}

</style>
<div id="mySidenav" class="sidenav" >
<ul class="nav flex-column sidebar-nav fo menu" style="font-size: 20px">
  <li class="nav-item">
    <a class="nav-link" href="index.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=users/users">Users</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=dataPrice/addPrice">Add data price</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=pages/settings/settings">Settings</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=pages/benefitiaries/benefitiaries">Saved beneficiaries</a>
  </li>
 
  <li class="nav-item">
  <a href="../admin/logout.php" class="btn btn-info mt-2 ml-2"><i class="fas fa-sign-out-alt"></i> log out</a>
  </li>
</ul>
  
</div>
    <nav class="headerside main-header navbar navbar-expand navbar-light text-sm ">
    <ul class="navbar-nav ">

          <li class="nav-item d-sm-inline-block text-white text-">
          <span>HI <?= $admin['username'] ?></span>
          </li>
        </ul>
       <ul class="navbar-nav ml-auto">
          <li class="nav-item">  
              <div class="btn-group nav-link ">
                     <i class="fa-solid text-white fa-bars float-left" id="toggle" ></i>
            </div>
           
          </li>
        
        </ul>
      </nav>
    <!-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script> -->
<script type="text/javascript">
  const sideNav = document.getElementById('mySidenav');
const toggle = document.getElementById('toggle');

if (toggle) {
  toggle.addEventListener('click', () => {
    if (sideNav.style.display === 'none' || sideNav.style.display === '') {
      sideNav.style.display = 'block';
    } else {
      sideNav.style.display = 'none';
    }
  });
}



jQuery(function($) {
     var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('.menu a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
     });
    });


  </script>