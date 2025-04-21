<?php
require_once "./../classes/monifyClass.php";

$api_key = $monnify_details['api'];
$secret_key = $monnify_details['secret'];
$reference=$user['accountReference'];

$monify = new MonifyToken($api_key, $secret_key);
$accessToken = $monify->getAccessToken();

// echo $accessToken;
$headers = [
    'Content-Type: application/json',
    'Authorization: Bearer '. $accessToken
];

$ch2 = curl_init();
$url="https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts/$reference";
curl_setopt($ch2, CURLOPT_URL, $url);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
$res = curl_exec($ch2);
curl_close($ch2);

$data2 = json_decode($res, true);
$success=false;


if($data2["requestSuccessful"] === true && $data2["responseMessage"] == "success"){
  
  $account_name=$data2["responseBody"]["accountName"];
  $banks=$data2["responseBody"]["accounts"];
  // var_dump($banks);
  
}else{
  $success=false;
}


?>
<head>
    <style>

         .footernavbar{
        display: none;
       }
       .atm-card{
        background-size:cover;
        background-repeat:no-repeat;
        background-position: center center;
        width: auto;
        height: 200px;
        border-radius: 15px;
       }
       .card1{
        background-image: url("./../images/atmcard1.svg");
       }
       .card2{
        background-image: url("./../images/atmcard2.svg");
       }
      /* CSS for the blinking effect */
@keyframes blink {
    0% { opacity: 1; }
    50% { opacity: 0; }
    100% { opacity: 1; }
}

.blink-text {
    animation: blink 0.5s infinite; /* Adjust the animation duration as needed */
}



   </style>
   <title>Automated Banks</title>
</head>
<div id="main" class="box">
   <div class="d-flex justify-content-center mt-5">
      <div class="container mt-3">
      <div class="alert alert-success alert-dismissible fade show">
  <button type="button" class="close" data-dismiss="alert">
    <span>&times;</span>
  </button>
  <h3>Automated funding </h3>
  <p>Pay into one of these accounts below your wallet will be funded automatically</p>
</div>       
        <?php 
        foreach ($banks as $bank) { 
          ?>
    <div class="col-sm-6 mx-auto mb-2 w-100 atm-card text-white <?php echo ($bank['bankCode'] === '035') ? 'card1' : 'card2'; ?> ;">
       <div class="p-2">
       <span class="p-0.5 text-secondary bg-white rounded" style="float:right"><?= $bank['bankName'] ?></span>
        <p class="mt-4">
          <strong>account Number: </strong><br>
           <span class="acctNumber"><?= $bank['accountNumber'] ?>  </span><i class="fas fa-copy copyButton"></i>
        </p>
        <p>
          <strong>account Name: </strong><br>
           <span><?= $account_name ?></span>
        </p>
        <span style="float:right">charge N50</span>
       </div>

    </div>
<?php } ?>

       
     </div>
   </div>
</div>
<script>

// Add click event listener to each copy button individually
const copyButtons = document.querySelectorAll('.copyButton');
copyButtons.forEach(button => {
    button.addEventListener('click', function() {
        const parentElement = this.parentElement;
        const acctNumberElement = parentElement.querySelector('.acctNumber');
        
        const range = document.createRange();
        range.selectNode(acctNumberElement);
        window.getSelection().removeAllRanges();
        window.getSelection().addRange(range);
        document.execCommand('copy');
        window.getSelection().removeAllRanges();
        
        // Add a class to make the text blink
        acctNumberElement.classList.add('blink-text');
        
        // Remove the blink class after a short delay (e.g., 1 second)
        setTimeout(function() {
            acctNumberElement.classList.remove('blink-text');
        }, 1000); // 1000 milliseconds = 1 second
    });
});

</script>