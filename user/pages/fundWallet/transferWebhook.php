<?php
 require_once "./../classes/actions.php";
  require_once "./../classes/monifyClass.php";

  
  $act = new Actions;
  
  // IP Whitelist - Verify IP address against Monnify IP 35.242.133.146
  $ip = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['REMOTE_HOST'];
  if ($ip != "35.242.133.146") die("Invalid IP");
  
  // get raw JSON request string
  $raw_request = file_get_contents('php://input');
  
  // your Secret Key found in your Monnify dashboard, developer menu
  $SECRET_KEY = 'YVF4EFP0FH61S4PXMSWJXVUWBD1U1SYT';
  
  // next, we need to compute and compare the hash sent via the header as "monnify-signature"
  $signature = $_SERVER['HTTP_MONNIFY_SIGNATURE'];
  $computedHash = hash_hmac('sha512', $raw_request, $SECRET_KEY);
  if ($computedHash != $signature) {
      error_log("Invalid Hash. Expected: $signature, Computed: $computedHash");
      die("Invalid Hash");
  }
  
  // Log received payload and computed hash
  error_log("Received Payload: $raw_request");
  error_log("Computed Hash: $computedHash");
  error_log("Signature from Header: $signature");
  
  echo "OK";
  
  // parse request to array
  $request_array = json_decode($raw_request);
  
  // Assuming $user is defined somewhere in your code
  $eml = $user['email'];
  $data = ['accountReference' => $request_array];
  
  $act->update('users', $data, "email=" . $eml);
  



?>
