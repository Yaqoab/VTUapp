<?php
 require_once "../../../classes/actions.php";
 require_once '../../../db_connect.php';
  $processTv = new Actions();
 if ($_SERVER["REQUEST_METHOD"] === "GET") {
     if (isset($_GET["tv"])) {
        $tvCableId  = $_GET['tv'];
        $getTvPlans = $processTv->select("cable_plan_list","*","cableId='$tvCableId'","fetchAll");
                      $processTv->closeConnection();
        $response = [
            "status" => "success",
            "data" => $getTvPlans
        ];
       echo json_encode($response);
     }
 }elseif ($_SERVER["REQUEST_METHOD"] === "POST") {
    $userId     = trim($_POST['userId']);
    $cat_id     = $_POST['cat_id'];
    $cable      = trim($_POST['cable-name']); //as ID
    $cablePlan  = trim($_POST['cable-plan']);
    $iuc        = trim($_POST['iuc']);
    $amount     = trim($_POST['amount']);
    $pin        = trim($_POST['pin']);

     //  construct json payload
     $data = json_encode([
        "cablename" => $cable,
        "cableplan" => $cablePlan,
        "smart_card_number" => $iuc
    ]);
     
    $user=$processTv->select("users","balance,pin","user_id='$userId'");
        $user_balance = $user['balance'];
        $hash_pin     = $user['pin'];
        $processTv->closeConnection();
    $err = [];
        //   -------------VALIDATE IUC --------------------
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "https://www.gladtidingsdata.com/api/v2/validateiuc/?cable_id=$cable&smart_card_number=$iuc",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
        ));

                $iucRes = curl_exec($curl);

                curl_close($curl);
                $iucResDecoded = json_decode($iucRes, true);

    if (empty($cable)) {
        $err["cable"] = "cable name required";
    }
    if (empty($cablePlan)) {
        $err["cablePlan"] = "cable plan required";
    }
    if (empty($iuc)) {
        $err["iuc"] = "ICU number required";
    }else{
            if (isset($iucResDecoded['invalid']) && $iucResDecoded['invalid'] === true) {
            $err['iuc'] =  $iucResDecoded['name'];
            }elseif ($iucResDecoded && isset($iucResDecoded['name'])) {
                # code...
            }else{
                $err['iuc'] =  "Unable to validate UIC";
            }
    }
    if (empty($amount)) {
        $err["amount"] = "amount required";
    }elseif($amount > $user_balance){
        $err['amount']='insufficient balance';
    }else{

    }
    if (empty($pin)) {
        $err['pin']='please enter pin';
    } elseif (!password_verify($pin, $hash_pin)) {
        $err['pin']='incorrect pin';
    }

    if (!empty($err)) {
        $response=[
         'status'=>'error',
         'data'=>$err,
         'ct' =>$cat_id
        ];
    }else {
        
        //    ------------ SUBSCRIBE TV----------------
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => 'https://www.gladtidingsdata.com/api/cablesub/',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 0,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => $data,
        ));

        $subRes = curl_exec($curl);

        curl_close($curl);

        $subResDecoded = json_decode($subRes, true);
        if ($subResDecoded["status"] === "successful") {
            // $processTv->addDataToDatabase();
            // $response = [
            //     "status" => "success",
            //     "data" => $_POST
            // ];
        }else {
            // $response = [
            //     "status" => "successful",
            //     "data" => $_POST
            // ];
        }
    } 
   
   echo json_encode($response);
 }
// 7525456800
?>