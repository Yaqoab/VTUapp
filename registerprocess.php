<?php 
 require_once './db_connect.php';
 require_once "./classes/actions.php";
 require_once "./classes/monifyClass.php";
 
 $addData=new Actions();
 
 if ($_SERVER["REQUEST_METHOD"] === "POST") {
 
    $data=[
        'username'=>$_POST['username'],
        'email'=>$_POST['email'],
        'phone'=>$_POST['phone'],
        'unHashPassword'=>$_POST['password'],
        'confirm'=>$_POST['confirm']
    ];
      
    // $referred_by = ($_POST['referred_by'] === null) ? $referred_by="" : $referred_by=$_POST['referred_by'] ;
    $referred_by="";
    $get_referred_by=$_POST['referred_by'];
    
    $referred_by=($get_referred_by === "null") ? $referred_by="" : $referred_by=$get_referred_by;
    // if ($get_referred_by === 'null') {
    //   $as="";
    // }else{
    //   $as=$vr;
    // }

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

                     $referalData=[
                        'deposited'=>0,
                        'referral_date'=>$date_time
                      ];
                   
                    if (!empty($referred_by)) {
                      $referrerUserData=$addData->select("users","*","phone=$referred_by");
                      $getData['referred_by']=$referrerUserData['user_id'];
                      $referalData['referrer_id']=$referrerUserData['user_id'];
                    }else{
                      $getData['referred_by']="";
                      $referalData['referrer_id']="";
                    }
                    
                     $addData->addDataToDatabase("users",$getData);
                    $referalData['referee_id']=$connect->lastInsertId();
                   
                  if (!empty($referalData['referrer_id'])) {
                    $addData->addDataToDatabase("referrals",$referalData);
                  }
                  
                    
                $response=array(
                  "status"=>'success',
                  "message"=>"registered successfully",
                  "data"=>$getData,
                  "r"=>$referalData
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