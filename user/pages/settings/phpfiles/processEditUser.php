<?php
require_once "../../../../classes/actions.php";
require_once '../../../../db_connect.php';

$usersDetails=new Actions;


if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Handle the "select" action
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
       
          //query from database in class  
         // select($table,$column,$condition)      
         $details=$usersDetails->select("users","user_id,username,email,phone,image","user_id='$id'");
         $data = array(
            'status' => 'success',
            'message' => $details,
        );

        echo json_encode($data);
    } else {
        echo json_encode(array(
            'status' => 'error',
            'message' => 'Parameter "id" is missing or incorrect for select action'
        ));
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $ids=$_POST['user_id'];
   
         
    $data=array(
        'username'=>$_POST['username'],
        'email'=>$_POST['email'],
        'phone'=>$_POST['phone']
    );
    $uploadDir = '../../../../uploads/';
    $allowedTypes = array('jpg', 'jpeg', 'png', 'gif'); 
    $maxSize = 2097152; 
    $validator=new Validation($data);

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = $_FILES['image'];
        $details=$usersDetails->select("users","image","user_id='$ids'");
        // Get the file extension
        $ext = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
        // Check if the file type is allowed
        if (!in_array($ext, $allowedTypes)) {
            $validator->addError('image',' Only JPG, JPEG, PNG, and GIF files are allowed.');
        } elseif ($image['size'] > $maxSize) {
            $validator->addError('image','File size exceeds the allowed limit (2MB).');
        } else {
            $newName = uniqid() . '.' . $ext;
            if (isset($details['image']) && !empty($details['image'])) {
                $previousImage = $details['image'];
                unlink($uploadDir . $previousImage);
            }
            if ($validator->validateEdit()) {
            move_uploaded_file($image['tmp_name'], $uploadDir . $newName);
            $data['image']=$newName;
            
            }
        }
    } 
             
    if ($validator->validateEdit()) {
        //update data in database table reference from class
         $usersDetails->update("users",$data,"user_id =".$ids);
         $usersDetails->closeConnection();
        $data = array(
            'status' => 'success',
            'message' => 'updated successfully',
        );
    
    }else{
        $err=$validator->getErrors();
        $data = array(
            'status' => 'error',
            'message' => $err,
        );
    }


    echo json_encode($data);
} else {
    echo json_encode(array(
        'status' => 'error',
        'message' => 'Invalid request method'
    ));
}
?>
