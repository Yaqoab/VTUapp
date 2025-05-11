<head>
<title>settings</title>
<style>
   .footernavbar{
        display: none;
    }
    .more .column div{
      border: none;
    }
  </style>

</head>
<div id="main" class="mt-5">
  <div class="more p-3">
       <div class="column" style="font-size:17px;">
          <div>
            <a href="index.php?page=pages/settings/editDetails&id=<?= $userId ?>">
               <!-- <i class="fa fa-book"></i> -->
                <span class="fs-4">Edit details</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
          <div>
            <a href="index.php?page=pages/settings/changePass&id=<?= $userId ?>">
                <!-- <i class="fa-solid fa-money-bill"></i> -->
                <span>Change password</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
          <div>
            <a href="index.php?page=pages/settings/managePin">
                <!-- <i class="fa-solid fa-calculator"></i> -->
                <span>Manage pin</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
       </div>
  </div>

   </div>
   <script>
   
   </script>
<!-- </html> -->