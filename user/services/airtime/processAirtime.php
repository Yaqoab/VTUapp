<?php
   require_once "../../../classes/actions.php";
   require_once '../../../db_connect.php';

   $processAirtime=new Actions;

   if ($_SERVER['REQUEST_METHOD'] === 'POST') {
         $user_id       = trim($_POST['userId']);
         $cat_id        = $_POST['cat_id'];
         $network       = trim($_POST['network']);
         $phone_number  = trim($_POST['phone']);
         $amount        = trim($_POST['amount']);
         $pin           = trim($_POST['pin']);
         $ported_number = true;  // Assuming this is a boolean value, not from the form
         $airtime_type  = "VTU";
          
         
        $phone_validation =$processAirtime->validatePhoneNumber($phone_number, $network);
        //  construct json payload
         $data = json_encode([
            "network" => $network,
            "amount" => $amount,
            "mobile_number" => $phone_number,
            "Ported_number" => $ported_number,
            "airtime_type" => $airtime_type
        ]);
          
         $user=$processAirtime->select("users","balance,pin","user_id='$user_id'");
         $user_balance=$user['balance'];
         $hash_pin=$user['pin'];
         $processAirtime->closeConnection();

         $err=[];
         $response;

         if (empty($network)) {
             $err['network']='please select network';
         }
         if (!$phone_validation['isValid']) {
             $err['phone']=$phone_validation['message'];
         }
         if (empty($amount)) {
             $err['amount']='amount required';
         }elseif ($amount > $user_balance) {
             $err['amount']='insufficient balance ₦'.$user_balance .' only remain in your wallet';
         }else {
             // $err['data']='successfully';
         }   
         if (empty($pin)) {
            $err['pin']='please enter pin';
        } elseif (!password_verify($pin, $hash_pin)) {
            $err['pin']='incorrect pin';
        }else {
            # code...
        }
        
        if (!empty($err)) {
            $response=[
             'status'=>'error',
             'data'=>$err
            ];
        }else {


            //   API DOCUMENTATION

            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://www.gladtidingsdata.com/api/topup/',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>  $data,
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Token 79cb2d40276c522b90067f3e9a242cf17cab27ac',
                    'Content-Type: application/json'
                ),
            ));
            
            $res = curl_exec($curl);
            
            curl_close($curl);

            $responseData = json_decode($res, true);
            
           if (isset($responseData['errorr'])) {
                $response=['status' => 'errorr', 'data' => $responseData['error']];
            } else {
                $response=['status' => 'success', 'data' => $responseData];
            }
    }
         echo json_encode($response);
   }
?>