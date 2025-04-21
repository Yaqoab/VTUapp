<?php
require_once "../../../classes/actions.php";
require_once '../../../db_connect.php';

$usersDetails=new Actions;
// Fetch search query
$query = $_GET['q'];
$userId=$_GET['id'];
$searchUser=new Actions;
$results=[];
$found=false;

$data=$usersDetails->select('users','user_id,username,phone,image',"user_id !='$userId'",'fetchAll');

foreach ($data as $item) {
    if (isset($item['phone']) && strpos($item['phone'],$query) !==false) {
        $results[] =$item;
        $found=true;  
    }
   
}
 if ($found) {
    $response=[
        'status'=>'success',
        'message'=>$results
    ];
 } else {
    $response=[
        'status'=>'error',
        'message'=>'User not found!',
    ];
 }
 

echo json_encode($response);


?>