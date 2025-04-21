<?php
 require_once "../../../classes/actions.php";
 require_once '../../../db_connect.php';
  $processElectric = new Actions();
 if ($_SERVER['REQUEST_METHOD'] === 'POST') {
   $userId    = trim($_POST['userId']);
   $cable     = trim($_POST['cableName']);
   $amount    = trim($_POST['amount']);
   $meter     = trim($_POST['meter']);
   $meterType = trim($_POST['meterType']);
   $phone     = trim($_POST['phone']);
   $pin       = trim($_POST['pin']);
    
   $user=$processElectric->select("users","balance,pin","user_id='$userId'");
        $user_balance = $user['balance'];
        $hash_pin     = $user['pin'];
        $processElectric->closeConnection();
    $err = [];

     $data = json_encode([
      "disco_id" => $cable,
      "amount" => $amount,
      "meter_number" => $meter, 
      "meter_type" => $meterType
     ]);
   //  ------------VALIDATE METER-------------

               $curl = curl_init();
               
            curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.gladtidingsdata.com/api/v2/validatemeter/?disco_id=$meter&meter_type=$meterType&meter_number=$meter",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $meterRes = curl_exec($curl);
            curl_close($curl);
            $meterResDecoded = json_decode($meterRes, true);

    if (empty($cable)) {
      $err["cable"] = "cable required";
  }
  if (empty($amount)) {
   $err["amount"] = "amount required";
   }elseif($amount > $user_balance){
      $err['amount']='insufficient balance';
   }else{

   }
if (empty($meter)) {
   $err["meter"] = "Meter required";
} else {
   if (isset($meterResDecoded['invalid'])) {
      if ($meterResDecoded['invalid'] === false) {
          // Meter is valid
          $err['meter'] = "Meter is valid: " . $meterResDecoded['name'] . ", " . $meterResDecoded['address'];
      } else {
          // Meter is invalid
          $err['meter'] = "Meter is invalid.";
      }
  } else {
      // Handle unexpected response
      $err['meter'] = stripslashes($meterRes);
  }
 
}
if (empty($meterType)) {
   $err["meterType"] = "Meter type required";
}
   if (empty($pin)) {
      $err['pin']='please enter pin';
   } elseif (!password_verify($pin, $hash_pin)) {
         $err['pin']='incorrect pin';
   }

   if (!empty($err)) {
      $response=[
       'status'=>'error',
       'data'=>$err
      ];
  }else {
      
     
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://www.gladtidingsdata.com/api/v2/billpayment/',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$data,
));

$res = curl_exec($curl);
curl_close($curl);
$responseData = json_decode($res, true);
   
   $response = [
      "status" => "successful",
      "data" => $responseData
  ];

  }
    echo json_encode($response);
 }
?>