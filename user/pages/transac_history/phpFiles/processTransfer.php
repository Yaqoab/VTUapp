<?php
   require_once "../../../../classes/actions.php";
   require_once '../../../../db_connect.php';
    
   $getReciept=new Actions;
   if ($_SERVER['REQUEST_METHOD'] === 'GET') {
      if (isset($_GET['ref_id']) && isset($_GET['user_id'])) {
         $ref_id=$_GET['ref_id'];
         $userId=$_GET['user_id'];
      }
      $isRead=array(
        'is_read'=>1
         );
        // join tables when slecting
        $getReciept->join('users s','INNER JOIN', 't.sender_id = s.user_id');
        $getReciept->join('users r',' INNER JOIN', 't.receiver_id = r.user_id');

      $reciept=$getReciept->select("transfer t","t.*, s.phone AS senderAcc, s.username AS senderName, r.phone AS receiverAcc, r.username AS receiverName","t.transfer_id='$ref_id'");
      $getReciept->update("notifications",$isRead,"ref_id =".$ref_id);

      $response=[
        'status'=>'success',
        'message'=>$reciept
      ];

      echo json_encode($response);
   }
?>