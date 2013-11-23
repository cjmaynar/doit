<?php
$host = '';
$dbname = '';
$user = '';
$pass = '';

try {  
  $DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);  
} catch(PDOException $e) {  
    echo $e->getMessage();  
} 

//force PDO to throw errors
$DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
