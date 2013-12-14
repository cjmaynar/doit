<?php
function __autoload($class) {
    $base = dirname(__FILE__);
    $class = explode('\\', $class);
    require $base . "/" . strtolower($class[0]) . "/$class[1].class.php";
}

session_start();

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
