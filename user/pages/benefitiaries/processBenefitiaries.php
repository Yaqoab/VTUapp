<?php
 require_once "../../../classes/actions.php";
 require_once '../../../db_connect.php';
  
 $getBenefitiaries=new Actions;
  if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $id=$_GET['id'];

    $beneficiaries=$getBenefitiaries->select("beneficiaries","*","user_id='$id'","fetchAll");
    
    if (count($beneficiaries) == 0) {
      $response=[
        'status'=>'error',
        'message'=>'beneficiaries is empty',
      ];
    }else{
      $response=[
        'status'=>'success',
        'message'=>$beneficiaries,
    ];
    }
   

    echo json_encode($response);
  }elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jsonData = file_get_contents('php://input'); // Get raw JSON data from the request
    $postData = json_decode($jsonData, true); // Decode JSON data as associative array
     
    if (isset($postData)) {
        $userId = $postData['user_id'];
        $benId= $postData['ben_id'];

        $getBenefitiaries->delete("beneficiaries","ben_id='$benId' AND user_id='$userId'"); 
        $response = [
            'status' => 'success',
            'message' => 'Data received successfully',
        ];
    } else {
        $response = [
            'status' => 'error',
            'message' => 'No ID provided in the data',
        ];
    }

    echo json_encode($response);
} else {
    // Handle other HTTP methods if needed
}



?>