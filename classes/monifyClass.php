<?php 
class MonifyToken {
    private $api_key;
    private $secret_key;
    private $access_token;
    private $token_url = 'https://sandbox.monnify.com/api/v1/auth/login';

    public function __construct($api_key, $secret_key) {
        $this->api_key = $api_key;
        $this->secret_key = $secret_key;
        $this->access_token = null;
    }

    public function getAccessToken() {
        if ($this->access_token !== null) {
            return $this->access_token;
        }

        $ch = curl_init();
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode($this->api_key . ":" . $this->secret_key)
        );

        curl_setopt_array($ch, array(
            CURLOPT_URL => $this->token_url,
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => json_encode([]),
            CURLOPT_HTTPHEADER => $headers,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 5, // Set a reasonable timeout
        ));

        $output = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($output, true);

        if (isset($json['responseBody']['accessToken'])) {
            $this->access_token = $json['responseBody']['accessToken'];
            return $this->access_token;
        } else {
            return null;
        }
    }
}


class MonnifyWebhookHandler {
    private $secretKey;

    public function __construct($secretKey) {
        $this->secretKey = $secretKey;
    }

    public function handleWebhook() {
        $ip = ($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : $_SERVER['REMOTE_HOST'];
        if ($ip != "35.242.133.146") {
            $this->respondWithError("Invalid IP");
        }

        $rawRequest = file_get_contents('php://input');
        $signature = $_SERVER['HTTP_MONNIFY_SIGNATURE'];
        
        if (!$this->verifySignature($rawRequest, $signature)) {
            $this->respondWithError("Invalid Hash");
        }

        // Parse request to array
        $requestArray = json_decode($rawRequest, true);

        // Handle the request further if needed
        // $this->handleRequest($requestArray);

        $this->respondWithSuccess();
        return $requestArray;
    }

    private function verifySignature($rawRequest, $signature) {
        $computedHash = hash_hmac('sha512', $rawRequest, $this->secretKey);
        return ($computedHash === $signature);
    }

    // public function handleRequest($requestArray) {
    //     return $requestArray;
    //     // Your logic to handle the parsed request array
    //     // Implement logic to update your database or take other actions based on the webhook payload
    // }

    private function respondWithError($message) {
        http_response_code(403); // Forbidden
        die($message);
    }

    private function respondWithSuccess() {
        echo "OK";
    }
}

// Example usage



?>