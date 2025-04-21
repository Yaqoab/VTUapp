<?php 
  require_once "../classes/actions.php";
  require_once '../db_connect.php';
  
  if (isset($_SESSION['vtu_user_id'])) {
    $userId=$_SESSION['vtu_user_id'];
  }
  $Users=new Actions;
  
  $user=$Users->select("users","*","user_id='$userId'");
  // count user notifications
  $count = $Users->count(
    "notifications",
    "is_read",
    "receiver_id ='$userId' AND is_read=0 OR receiver_id IS NULL "
  );

  $monnify_details=$Users->select("monnifyData","*","id=1");
  
?>
<style>
    .user-img{
        /* position: absolute; */
        height: 27px;
        width: 27px;
        object-fit: cover;
        left: -7%;
        top: -12%;
        border-radius: 50%;
  }
</style>
<div id="mySidenav" class="sidenav" >
<ul class="nav flex-column sidebar-nav fo menu" style="font-size: 20px">
  <li class="nav-item">
    <a class="nav-link" href="index.php">Home</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=pages/transaction">Transaction</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=pages/refferal/refferal">refferal</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=pages/settings/settings">Settings</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=pages/benefitiaries/benefitiaries">Saved beneficiaries</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=pages/pricing">Pricing</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="index.php?page=categories">Calculator</a>
  </li>
  <li class="nav-item">
  <a href="../logout.php" class="btn btn-info mt-2 ml-2"><i class="fas fa-sign-out-alt"></i> log out</a>
  </li>
</ul>
  
</div>
    <nav class="headerside main-header navbar navbar-expand navbar-light text-sm ">
    <ul class="navbar-nav ">
          <li class="nav-item d-sm-inline-block text-white text-">
          <span>
              <img class="user-img" src="<?php
                    if (!empty($user['image'])) {
                      echo "./../uploads/" . $user['image'];
                    } else {
                      echo "./../uploads/defaultpro.png";
                    }
                  ?>" alt="user">
                 <span>HI <?= $user['username'] ?></span>
            </span>
          </li>
        </ul>
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">  
            <!-- <div class="btn-group nav-link">
               <a href="index.php?page=pages/notification/notification" class="text-white">
                <i class="fa-solid fa-bell float-left position-relative">
                  <span class="position-absolute"><?php  //echo $count; ?></span>
                </i>
              </a>
              </div> -->
              <div class="btn-group nav-link ">
                  <a href="index.php?page=pages/notification/notification" class="text-white position-relative">
                    <i class="fa-solid fa-bell float-left">
                      <?php
                      if ($count > 0) {
                        echo '<span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">' . $count . '</span>';
                      }
                      ?>
                    </i>
                  </a>
            </div>

          </li>
        
        </ul>
      </nav>
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script type="text/javascript">
jQuery(function($) {
     var path = window.location.href; // because the 'href' property of the DOM element is the absolute path
     $('.menu a').each(function() {
      if (this.href === path) {
       $(this).addClass('active');
      }
     });
    });

  </script>