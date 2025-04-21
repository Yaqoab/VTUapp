<?php
$servername="localhost";
$username="root";
$password="";
$dbname="vtuapp";

 try {
    $connect=new
     PDO("mysql:host=$servername;dbname=$dbname;charset=utf8",$username,$password);
     $connect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
    //  echo "connected";
  } catch (PDOException $e) {
    echo "not connect".$e->getMessage();
  }

 ?>