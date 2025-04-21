<?php
 require_once "../../../classes/actions.php";
 require_once '../../../db_connect.php';
  
 $getNotification=new Actions;
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id=$_GET['id'];
//   join table when selecting
    $getNotification->join('categories c', 'LEFT JOIN', 'n.cat_id = c.cat_id');
    // $getNotification->join('users u', 'n.sender_id = u.user_id');
    // $getNotification->join('users u','LEFT JOIN', 'n.sender_id = u.user_id');

    $notification=$getNotification->select(
          "notifications n","n.*, c.cat_name",
          "(receiver_id='$id' OR sender_id IS NULL) ORDER BY timestamp DESC","fetchAll"
        );
        // $notificationCount=$getNotification->select("notifications n","SUM(is_read)","receiver_id='$id' AND is_read=0");


    if (count($notification) == 0) {
        $response=[
            'status'=>'error',
            'message'=>"No notification yet"
        ];
    }else{
        $response=[
            'status'=>'success',
            'message'=>$notification
        ];
    }

    echo json_encode($response);
 }
?>