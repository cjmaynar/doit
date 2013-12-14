<?php
require_once 'config.php';

//Add the date formater to the filters
$Mustache_Engine->addHelper('date', [
    'format' => function($value) { return date('m/d/Y', strtotime($value)); },
]);

if (isset($_POST) && array_key_exists('username', $_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $User = new Models\User($DBH);
    $params = Array(
        'username' => $username,
        'password' => hash('sha256', $password)
    );

    $user = $User->filter($params);

    if ((count($user)) == 1 && array_key_exists('username', $user[0])) {
        $_SESSION['username'] = $user[0]['username'];
        $_SESSION['userid'] = $user[0]['id'];
    } else {
        $errorMsg = "Incorrect username/password combination.";
    }
}

if (isset($_SESSION['username'])) {
    $Task = new Models\Task($DBH);
    $params = Array(
      'user' => $_SESSION['userid'],
      'completed' => null
    );
    $Tasks = $Task->filter($params);

    $context = Array(
        'tasks' => $Tasks,
        'title' => 'DoIt',
        'userid' => $_SESSION['userid']
    );
} else {
    $context = Array(
        'error' => $errorMsg,
        'title' => 'Login'
    );
}
echo $Mustache_Engine->render('login', $context);
?>
