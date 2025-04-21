<?php
 require_once "../db_connect.php";
  require_once "./../classes/Actions.php";


class CustomTransactionHashUtil {
    public static function computeSHA512TransactionHash($stringifiedData, $clientSecret) {
        $computedHash = hash_hmac('sha512', $stringifiedData, $clientSecret);
        return $computedHash;
    }
}

$DEFAULT_MERCHANT_CLIENT_SECRET = '91MUDL9N6U3BQRXBQ2PJ9M0PW4J22M1Y';
// IP Whitelist - Verify IP address against monnify IP  35.242.133.146
$ip = ($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:$_SERVER['REMOTE_HOST'];
if($ip != "35.242.133.146"){
  die("invalid ID");
}

$data = file_get_contents("php://input");

$providedSignature = isset($_SERVER['HTTP_SIGNATURE']) ? $_SERVER['HTTP_SIGNATURE'] : '';

// Compute the expected signature
$computedHash = CustomTransactionHashUtil::computeSHA512TransactionHash($data, $DEFAULT_MERCHANT_CLIENT_SECRET);

// Check if the computed signature matches the one provided in the request
if ($computedHash === $providedSignature) {
    // Signature is valid, process the webhook data
    $decodedData = json_decode($data, true);
    print_r($decodedData);
    // Your webhook processing logic goes here
    
    http_response_code(200); // Respond with a 200 status to acknowledge receipt
} else {
    // Invalid signature, reject the request
    http_response_code(400); // Respond with a 400 status to reject the request
}







?>
