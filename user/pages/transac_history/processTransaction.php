<?php
  require_once "../../../classes/actions.php";
  require_once '../../../db_connect.php';

  $getDetails = new Actions;
  $notifiData = ['is_read' => 1];
   if ($_SERVER['REQUEST_METHOD'] === 'GET') {
   
if (isset($_GET['catname'])) {
    $catName       = $_GET['catname'];
    $userId        = $_GET['uId'];
    $reference = $_GET['ref'];    
}
 if ($catName === "data") {
    $data = $getDetails->select('data_history','*',"reference='$reference'");
    $response=[
        'category'=>$catName,
         'details'=>$data
    ];
 }elseif($catName === "airtime"){
    $data = $getDetails->select('airtime_history','*',"reference='$reference'");
    $response=[
        'category'=>$catName,
         'details'=>$data
    ];
 }elseif ($catName === "transfer") {
   $getDetails->join('users s','INNER JOIN', 't.sender_id = s.user_id');
   $getDetails->join('users r',' INNER JOIN', 't.receiver_id = r.user_id');
   $data=$getDetails->select("transfer t","t.*, s.phone AS senderAcc, s.username AS senderName, r.phone AS receiverAcc, r.username AS receiverName","t.reference='$reference'");
     $getDetails->update('notification',$notifiData,"user_id='$userId' AND reference='$reference'");
   $response=[
        'category'=>$catName,
         'details'=>$data
    ];
 }elseif ($catName === "electricity") {
   $data = $getDetails->select('electric_history','*',"reference='$reference'");
    $response=[
        'category'=>$catName,
         'details'=>$data
    ];
 }elseif ($catName === "deposit") {
  $data = $getDetails->select('deposit_history','*',"reference='$reference'");
  $getDetails->update('notification',$notifiData,"user_id='$userId' AND reference='$reference'");
   $response=[
       'category'=>$catName,
        'details'=>$data
   ];
}
 else {
   $data = $getDetails->select('tvcable_history','*',"reference='$reference'");
   $response=[
    'category'=>$catName,
     'details'=>$data
   ];
 }
  $getDetails->closeConnection();
    echo json_encode($response);
    
}
?>