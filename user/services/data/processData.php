<?php
    require_once "../../../classes/actions.php";
    // require_once "../../../classes/networkAndPlans.php";
    require_once '../../../db_connect.php';

    $processData=new Actions;

   if ($_SERVER['REQUEST_METHOD'] === 'GET') {

    if (isset($_GET['network'])) {
        $network = $_GET['network'];

          $planType = $processData->select("dataPlanType","*","networks_id='$network'","fetchAll");
        
        $response = [
            "status"=>"success",
            "message"=>"message of success",
            "data"=>$planType
        ];
    }elseif(isset($_GET['planId'])){
        $plan_id = $_GET['planId'];

        $processData->join('dataPlanType p','INNER JOIN', 'p.plan_id = l.plan_id');
        $planList = $processData->select("dataPriceList l","*","l.plan_id='$plan_id'","fetchAll");
        $response = [
            "status"=>"success",
            "message"=>"message of success",
            "data"=>$planList,
            "id"=>$plan_id
        ];
    }else{
     
    }

    echo json_encode($response);
   }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userid         = trim($_POST['userId']);
        $cat_id         = $_POST['cat_id'];
        $network        = isset($_POST['network']) ? $_POST['network'] : null;
        $phone_number   = trim($_POST['phone']);
        $plan           = $_POST['data-plan'];
        $amount         = trim($_POST['amount']);
        $pin            = trim($_POST['pin']);
        $ported_number  = true;
        $payment_medium = 'payment_medium';
         
        $phone_validation =$processData->validatePhoneNumber($phone_number, $network);
         //  construct json payload
         $data = json_encode([
            "network" => $network,
            "mobile_number" => $phone_number,
            "plan" => $plan,
            "Ported_number" => $ported_number
        ]);

        $user=$processData->select("users","balance,pin","user_id='$userid'");
        $user_balance = $user['balance'];
        $hash_pin     = $user['pin'];
        $processData->closeConnection();
        $err=[];

        if (empty($network)) {
            $err['network']='please select network';
        }
        if (empty($plan)) {
            $err['dataPlan']='please select data plan';
        }
        if (!$phone_validation['isValid']) {
            $err['phone']=$phone_validation['message'];
        }
        if (empty($amount)) {
            $err['dataPrice']='select price of your plan';
        }elseif ($amount > $user_balance) {
            $err['dataPrice']='insufficient balance';
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
          
        //------------API DOCUMENTATION----------------
             $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://www.gladtidingsdata.com/api/data/',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'POST',
              CURLOPT_POSTFIELDS =>$data,
              CURLOPT_HTTPHEADER => array(
                'Authorization: Token 79cb2d40276c522b90067f3e9a242cf17cab27ac',
                'Content-Type: application/json'
            ),
            ));

            $res = curl_exec($curl);
            curl_close($curl);

            $responseData = json_decode($res, true);

            if (isset($responseData['error'])) {
                $response = ['status' => 'error', 'data' => $responseData['error']];
            } else {
                $deducted_bal = $user_balance - $amount;
                
                $total_deducted = ['balance' => $deducted_bal];
                
                $processData->update("users",$total_deducted,"user_id='$userid'");
                $receiptData = [ 
                    'cat_id'    => $cat_id,
                    'user_id'   => $userid,
                    'ref'       => $responseData['id'],
                    'network'   => $response['plan_network'],
                    'phone'     => $response['mobile_number'],
                    'plan_type' => $response["plan_type"],
                    'data_plan' => $response['plan_name'],
                    'amount'    => $amount,
                    'date'      => date('Y-m-d H:i:s'),
                    'status'    => $responseData['status'],
                ]; 
                
                $processData->addDataToDatabase("users",$getData);

                $response = ['status' => 'success', 'data' => $responseData];
            }

            
            }
            echo json_encode($response);

   }else {
    # code...
   }
   
?>
