<?php
#Bring in the Composer autoload files
require_once 'vendor/autoload.php';

#Our own autoloader
function model_loader($class) {
    $base = dirname(__FILE__);
    $class = explode('\\', $class);
    require $base . "/" . strtolower($class[0]) . "/$class[1].class.php";
}
spl_autoload_register('model_loader');

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

//Create a Mustache instance
$Mustache_Engine = new Mustache_Engine(array(
    'loader' => new Mustache_Loader_FilesystemLoader(
        dirname(__FILE__) . '/templates'
    ),
));
?>
