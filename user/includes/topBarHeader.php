<?php 
 include "includes/header.php";
?>

<style>
  .user-img{
        position: absolute;
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
        border-radius: 50%;
  }
  .btn-rounded{
        border-radius: 50px;
  }
  .main-header{
  position: fixed;
  width: 100%; 
  left: 0px;
  margin-top: -20px;
  background-color:#d0e4ba;
  z-index: 100;
  margin-left: -20px;

  }
  @media (max-width: 768px) {
    .main-header{
      width: 100%; 

     }

  }
</style>
      <nav class="main-header navbar navbar-expand navbar-light text-sm ">
        <ul class="navbar-nav">
          <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars" id="sidebarToggle"></i></a>
          </li>
          <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">User dashboard</a>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">  
            <div class="btn-group nav-link ">
            <b><?= $_SESSION['vtu_user_name']; ?></b>
                  <button type="button" class="btn btn-rounded badge badge-light dropdown-toggle dropdown-icon" data-toggle="dropdown">
                    <span><img src="./../uploads/<?php //$_SESSION['farmer_avatar']?>"
                     class="img-circle elevation-2 user-img" alt="User Image"></span>
                     <span class="ml-3"></span>
                     <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <div class="dropdown-menu dropdown-menu-right" role="menu">
                    <a class="dropdown-item" href="index.php?page=manage_profile&id=<?= $_SESSION['vtu_user_id'] ?>"><span class="fa fa-user"></span> My Account</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="./../logout.php"><span class="fas fa-sign-out-alt"></span> Logout</a>
                  </div>
              </div>
          </li>
          <li class="nav-item"> 
          </li>
        </ul>
      </nav>
      <script>
       document.addEventListener('DOMContentLoaded', function() {
    var dropdownToggle = document.querySelector('.dropdown-toggle');
    dropdownToggle.addEventListener('click', function() {
      dropdownToggle.nextElementSibling.classList.toggle('show');
    });
  });
      </script>
      <!-- /.navbar -->