<?php 
 require_once './db_connect.php';
 require_once "./classes/actions.php";
 require_once "./classes/monifyClass.php";
 
 $addData=new Actions();
 function generateReferralCode($prefix = 'REF') {
  return $prefix . strtoupper(substr(md5(uniqid()), 0, 6));
}

 if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $data=[
        'username'=>$_POST['username'],
        'email'=>$_POST['email'],
        'phone'=>$_POST['phone'],
        'referred_by'=>$_POST['referralCode'],
        'unHashPassword'=>$_POST['password'],
        'confirm'=>$_POST['confirm']
    ];

    $nameParts = explode(' ', $data['username']);
    $nameParts[0];

    $table = 'users';
    $validator=new Validation($data);
      
      //generate monify Api token
      $monnify_details=$addData->select("monnifydata","*","id=1");
    $api_key = $monnify_details['api'];
    $secret_key = $monnify_details['secret'];
    $monify = new MonifyToken($api_key, $secret_key);
    $accessToken = $monify->getAccessToken();


    $validator->validatePhone(true);


    if ($validator-> validate()) {
       
        //   MONNIFY RESERVINNG ACCOUNT
                $url2 = 'https://sandbox.monnify.com/api/v2/bank-transfer/reserved-accounts';

                $NAME = $data['username'];
                $EMAIL = $data['email'];
                $CONTRACT_CODE = $monnify_details['contractCode'];
                $ACCOUNT_NAME = $nameParts[0];
                $CURRENCY_CODE = 'NGN';
                $reference = rand(time(), 9999);

                $headers = [
                    'Content-Type: application/json',
                'Authorization: Bearer '. $accessToken
                ];

                $payload = [
                    'accountReference' => $reference,
                    'accountName' => $ACCOUNT_NAME,
                    'currencyCode' => $CURRENCY_CODE,
                    'contractCode' => $CONTRACT_CODE,
                    'customerEmail' => $EMAIL,
                    'customerName' => $NAME,
                    'getAllAvailableBanks' => false,
                    'preferredBanks' => ['232', '035'],
                ];

                // Make a POST request to reserve the account
                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $url2);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch2, CURLOPT_POST, true);
                curl_setopt($ch2, CURLOPT_POSTFIELDS, json_encode($payload));
                curl_setopt($ch2, CURLOPT_HTTPHEADER, $headers);
                $res = curl_exec($ch2);
                curl_close($ch2);

                $data2 = json_decode($res, true);

                if($data2["requestSuccessful"] === true && $data2["responseMessage"] == "success"){
                    $date=date('Y-m-d');
                    $time=date('h:i:sa');
                    $date_time=$date.' / '.$time;

                    
                    $getData=$validator->getData();
                    $getData['accountReference']= $data2["responseBody"]["accountReference"];
                    $getData['referral_code'] = generateReferralCode();
                    

                      // Insert new user
                      $addData->addDataToDatabase("users", $getData);
                      $referee_id = $connect->lastInsertId();

                      // Check if referral code was used and is valid
                      if (!empty($data['referred_by'])) {
                          $referrer = $addData->select("users", "*", "referral_code = '{$data['referred_by']}'");
                          
                          if ($referrer) {
                              $referrer_id = $referrer['user_id'];
                              $referralData = [
                                  'referrer_id' => $referrer_id,
                                  'referee_id' => $referee_id,
                                  'deposited' => 0,
                                  'commission' => 0,
                                  'referral_date' => $date_time
                              ];
                              $addData->addDataToDatabase("referrals", $referralData);
                          }
                      }

                     

                $response = array(
                  "status"=>'success',
                  "message"=>"registered successfully",
                  "data"=>$getData,
                );
              } else {
                // Monnify failed, so respond with error
                $response = array(
                  "status" => "error",
                  "message" => "Monnify failed to reserve account",
                  "raw_response" => $data2
                );
             }
    }else{
      $err=$validator->getErrors();
      $response=array(
        "status"=>'error',
        "message"=>$err,
       );
    }
      echo json_encode($response);
}

?>