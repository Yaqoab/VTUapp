<?php
 // ---------- CLASSS THAT CONTAIN SQL DATABASE FOR SELECT, UPDATE, JOIN AND SO ON----------//
 define('PW_SALT_LENGTH', 7);
 class Actions{
    private $db;
    private $joins = [];
    public function __construct(){
        global $connect;
        $this->db=$connect;
    }

  public function addDataToDatabase($table,$data){
   $columns=implode(', ',array_keys($data));
   $placeHolder=':'.implode(', :', array_keys($data));
   try {
    $sql="INSERT INTO $table ($columns) VALUES($placeHolder)";
    $stmt=$this->db->prepare($sql);

    foreach($data as $key => $value){
      $stmt->bindValue(':'.$key, $value);
    }
    $stmt->execute();
   return true;
   } catch (Exception $e) {
    echo "akwai matsala a nan".$e->getMessage();
   }
  }

public function update($table, $data, $condition) {
    $setClause = "";
    foreach ($data as $key => $value) {
        $setClause .= "$key = :$key, ";
    }
    $setClause = rtrim($setClause, ", ");

    $sql = "UPDATE $table SET $setClause WHERE $condition";

    try {
        $stmt = $this->db->prepare($sql);

        // Bind values to named placeholders
        foreach ($data as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return true;
    } catch (Exception $e) {
        echo "akwai matsala a nan" . $e->getMessage();
        return false;  // Return false to indicate failure
    }
}




  public function select($table,$column='*',$condition='',$fetchMode='fetch'){
    try {
    //   RAW_QUERY na nufin kayi nomarl query ba tare da kayi amfani da columns ba
        $sql = $table === 'RAW_QUERY' ? $column : "SELECT $column FROM $table";

        if (!empty($this->joins) && $table !== 'RAW_QUERY') {
            $sql .= ' ' . implode(' ', $this->joins);
        }
        if (!empty($condition) && $table !== 'RAW_QUERY') {
            $sql .= " WHERE $condition";
        }
        
        $result = $this->db->query($sql);
    
        if ($fetchMode === 'fetch') {
            $data = $result->fetch(PDO::FETCH_ASSOC);
        } elseif ($fetchMode === 'fetchAll') {
            $data = $result->fetchAll(PDO::FETCH_ASSOC);
        } else {
            throw new Exception("Invalid fetch mode.");
        }

        $this->joins = [];
    
        return $data;
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
    
  }


  public function join($table, $type, $condition)
  {
      // Add a JOIN clause to the SELECT query
      // Example usage: $db->join('other_table', 'your_table.column_name = other_table.column_name');
      $this->joins[] = "$type $table ON $condition";
  }
  public function count($table,$columns='*', $condition = '') {
    try {
        $sql = "SELECT COUNT($columns) FROM $table";
        
        if (!empty($condition)) {
            $sql .= " WHERE $condition";
        }
        
        $result = $this->db->query($sql);
        
        // Fetch the count as a single value
        $count = $result->fetchColumn();
        
        return $count;
    } catch (Exception $e) {
        echo "An error occurred: " . $e->getMessage();
    }
}

  public function delete($table,$condition){
    try {
        $stmt = $this->db->prepare("DELETE FROM $table WHERE $condition");
        $stmt->execute();
        return true; 
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        return false;
    }
  }


public function checkLogin($id, $allowedRoles, $url) {
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    if (!is_array($allowedRoles)) {
        $allowedRoles = [$allowedRoles];
    }

    if (
        isset($_SESSION[$id]) &&
        !empty($_SESSION[$id]) &&
        isset($_SESSION['vtu_role']) &&
        in_array($_SESSION['vtu_role'], $allowedRoles)
    ) {
        return true; // Authorized
    } else {
        header('Location: ' . $url);
        exit;
    }
}



     public function closeConnection() {
        if ($this->db) {
            $this->db=null;
        }
    }

    public function validatePhoneNumber($phoneNumber, $networkId) {
        // Remove any non-digit characters
        $cleanedNumber = preg_replace('/\D/', '', $phoneNumber);
        if (empty($cleanedNumber)) {
            return ['isValid' => false, 'message' => 'Phone number required'];
        }
        // Validate if it is a Nigerian number with correct length
        if (!preg_match('/^(234\d{10}|0\d{10})$/', $cleanedNumber)) {
            return ['isValid' => false, 'message' => 'Invalid Nigerian phone number format'];
        }
    
        // Define regex patterns for each network with their corresponding IDs
        //  i use numers as key you can change it depending on your API provider
        $networkPatterns = [
            '1' => '/^(234|0)(803|806|703|706|810|813|814|816|903|906)\d{7}$/', // MTN
            '2' => '/^(234|0)(805|807|705|811|815|905)\d{7}$/', // Glo
            '3' => '/^(234|0)(802|808|708|812|902|907|901)\d{7}$/', // Airtel
            '4' => '/^(234|0)(809|817|818|908|909)\d{7}$/' // 9Mobile
        ];
    
        // Check if the provided network ID matches the phone number pattern
        if (isset($networkPatterns[$networkId]) && preg_match($networkPatterns[$networkId], $cleanedNumber)) {
            return ['isValid' => true, 'network' => $networkId];
        }
    
        return ['isValid' => false, 'message' => 'Phone number does not match the selected network'];
    }
}
// ----------VALIDATION CLASS  FOR REGISTER AND SETTINGS SECTIONS----------//
class Validation extends Actions{
   private $data;
   private $db;
   private $errors;
    public function __construct($data){
      global $connect;
     $this->data=$data;
     $this->errors=[];
     $this->db=$connect;
    }
    // validation when register
    public function validate(){
       $this->userName();
       $this->validateEmail();
       $this->validatePhone();
       $this->validateRefferal();
       $this->validatePassword();
       $this->confirmPassword();

        return empty($this->errors);
    }
    // validation when edit user  
    public function validateEdit(){
        $this->userName();
        $this->validateEmail();
        $this->validatePhone();

        return empty($this->errors);
    }
    // Validation when changin password
    public function changePassword(){
         $this->validatePassword();
         $this->confirmPassword();
         
        return empty($this->errors);
    }
     // Validation when changin pin
     public function validatePin(){
        $this->pinNumber();
        $this->confirmPin();
        
       return empty($this->errors);
   }
    private function userName(){
        $username=$this->data['username'];
        if (empty($username)) {
            $this->addError('username','username required');
        }else{
           $this->testInput($username);
        }
    }
    public function validateEmail(){
        $email=$this->data['email'];
       
        if (empty($email)) {
            $this->addError('email','email is required');
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->addError('email','email is not valid');
        }else{
            $this->testInput($email);
         }
         return empty($this->errors);
     }
     public function validatePhone($checkDatabase=false){
        $phone=$this->data['phone'];
        if (empty($phone)) {
            $this->addError('phone','enter Phone number');
        }elseif (!is_numeric($phone)) {
            $this->addError('phone','please use numerics');
        }elseif (!preg_match('/^080/', $phone) and !preg_match('/^070/', $phone) and !preg_match('/^090/', $phone) and !preg_match('/^081/', $phone) and !preg_match('/^091/', $phone)) {
            $this->addError('phone','invalid phone number');
        }elseif(strlen($phone)!==11) {
            $this->addError('phone','phone number should be 11 character');
        }else{
            if ($checkDatabase) {    
         $query = "SELECT phone FROM `users` WHERE `phone`=:phone";
              $stmt = $this->db->prepare($query);
              $stmt->bindParam('phone', $phone);
              $stmt->execute();
              $count = $stmt->rowCount();
               $row   = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row > 1) {
                    $this->addError('phone','this phone number already registered with us');
              }
            }
               $this->testInput($phone);
    
        }
     }
    private function validateRefferal(){
        $referred_by = $this->data['referred_by'];
        $query = "SELECT phone, email FROM `users` WHERE `referral_code`=:referred_by";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam('referred_by', $referred_by);
        $stmt->execute();
         $referrerUserData   = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$referrerUserData) {
            $this->addError('referred_by','Invalid referral code. '.$referred_by);
        }
        if ($referrerUserData && $referrerUserData['email'] === $this->data['email']) {
            $this->addError('referred_by','You cannot refer yourself.');
        }
        
     }
     private function validatePassword(){
        $Password=$this->data['unHashPassword'];
        $numbers=preg_match('@[0-9]@', $Password);
        $specialChars=preg_match('@[^\w]@', $Password);
        //pass hash
            $pass=$Password;  
             $pwHash=password_hash($pass, PASSWORD_DEFAULT);
            if (empty($Password)) {
                $this->addError('password','empty password');
            }else{
            if (!$numbers || !$specialChars || strlen($Password) < 8) {
                $this->addError('password','Password should contain atleast one character like(@>*&...), numberand  not lessthan 8 characters');
            }else{
                $this->testInput($pwHash);
                $this->data['password']=$pwHash;
            }
            }

     }
     private function confirmPassword(){
            $Password=$this->data['unHashPassword'];
            $confirm=$this->data['confirm'];
            if (empty($confirm) || $Password !== $confirm) {
                $this->addError('confirm','please password confirmation does not match');
            }
     }
    // validate pin number
     private function pinNumber(){
       $pin=$this->data['pin'];
       $numbers=preg_match('@^[0-9]+$@', $pin);
       $numberAsString = strval($pin);
       $length = strlen($numberAsString);

       if (empty($pin)) {
          $this->addError('pin','pin is empty');
       }elseif(!$numbers){
        $this->addError('pin','use only numbers');
       }elseif($length !== 4){
        $this->addError('pin','pin length is ' .$length. ' it should be only 4 characters');
       }else {
        
       }
     }
    //   confirm pin number
    private function confirmPin(){
        $confirmPin=$this->data['confirmPin'];
        $pin=$this->data['pin'];
        if (empty($confirmPin) || $pin !== $confirmPin) {
            $this->addError('confirm','please pin confirmation does not match');
        }

    }
        public function addError($key,$value){
            return $this->errors[$key]=$value;
        }
        public function getErrors(){
           return $this->errors;
        }
        private function testInput($data){
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        public function dateTime(){
            $date=date('Y-m-d');
            $time=date('h:i:sa');
            $date_time=$date.' / '.$time;
            return $date_time;
         }
        public function getData(){
            // $this->data['role']=0;
            $excludeKeys=['unHashPassword','confirm'];
            $result = array_filter($this->data, function($key) use ($excludeKeys) {
                return !in_array($key, $excludeKeys);
            }, ARRAY_FILTER_USE_KEY);
           return $result;
        }
  

}



?>