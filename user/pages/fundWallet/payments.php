<?php
require_once "./../classes/monifyClass.php";


$api_key = "MK_TEST_S3ZK8R2KTH";
$secret_key = "YVF4EFP0FH61S4PXMSWJXVUWBD1U1SYT";

$monify = new MonifyToken($api_key, $secret_key);
$accessToken = $monify->getAccessToken();


?>
<head>
    <style>
         .footernavbar{
        display: none;
       }
   </style>
   <title>Monify methods</title>
</head>

    <?php
        // $webhookHandler = new MonnifyWebhookHandler('YVF4EFP0FH61S4PXMSWJXVUWBD1U1SYT');
        // $webhookHandler->handleWebhook();
    ?>
<div id="main" class="mt-5">
  <div class="more p-3">
       <div class="column" style="font-size:17px;">
       <div>
            <a href="index.php?page=pages/fundWallet/atm">
               <i class="fa fa-credit-card mr-2"></i>
                <span class="fs-4">Monnify ATM</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
          <div>
            <a href="index.php?page=pages/fundWallet/automatedBanks">
               <i class="fa fa-building-columns mr-2"></i>
                <span class="fs-4">Automated Bank Transfer</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
          <div>
            <a href="#">
                <i class="fa-solid fa-money-bill-transfer mr-2"></i>
                <span>Manual Bank Transfer</span>
                <i class="fa-solid fa-angle-right float-right"></i>
            </a>
          </div>
       </div>
  </div>
     
   </div>