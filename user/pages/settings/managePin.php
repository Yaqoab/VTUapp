<head>
  <style>
    .more .column div{
      border: none;
    }
  </style>
<title>manage pins</title>
</head>
<div id="main" class="mt-5">
  <div class="more p-3">
       <div class="column" style="font-size:17px;">
          <div>
            <a href="index.php?page=pages/settings/changePin&id=<?= $userId ?>">
               <!-- <i class="fa fa-book"></i> -->
                <span class="fs-4">Change pin</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
          <div>
            <a href="index.php?page=pages/settings/forgotPin&id=<?= $userId ?>">
                <!-- <i class="fa-solid fa-money-bill"></i> -->
                <span>Forgot pin</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
         
         
       </div>
  </div>

   </div>