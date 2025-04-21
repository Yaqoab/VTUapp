<?php
  require_once "../../../classes/actions.php";
  require_once '../../../db_connect.php';

  $getDetails = new Actions;
   if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
if (isset($_GET['catname'])) {
    $catName       = $_GET['catname'];
    $userId        = $_GET['uId'];
    $transactionId = $_GET['trId'];    
}
 if ($catName === "data") {
    $data = $getDetails->select('data_history','*',"dt_id='$transactionId'");
    $response=[
        'category'=>$catName,
         'details'=>$data
    ];
 }elseif($catName === "airtime"){
    $data = $getDetails->select('airtime_history','*',"air_id='$transactionId'");
    $response=[
        'category'=>$catName,
         'details'=>$data
    ];
 }elseif ($catName === "transfer") {
    $data = $getDetails->select('transfer','*',"transfer_id='$transactionId'");
    $response=[
        'category'=>$catName,
         'details'=>$data
    ];
 }elseif ($catName === "electricity") {
   $data = $getDetails->select('electric_history','*',"e_id='$transactionId'");
    $response=[
        'category'=>$catName,
         'details'=>$data
    ];
 }else {
   $data = $getDetails->select('tvcable_history','*',"t_id='$transactionId'");
   $response=[
    'category'=>$catName,
     'details'=>$data
   ];
 }
  $getDetails->closeConnection();
    echo json_encode($response);
    
}
?>