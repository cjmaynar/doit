<?php
require_once 'config.php';

$username = ''; //Empty to prevent need for isset check

if (array_key_exists('username', $_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($username == '' || $password == '') {
        $errorMsg = "You must provide a username and password";
    } elseif ($password2 != $password) {
        $errorMsg = "Your passwords do not match";
    } else {
        $password = hash('sha256', $password);
        $params = Array(
            'username' => $username,
            'password' => $password
        );

        $User = new Models\User($DBH);
        $user = $User->create($params);
        if ($user != false) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['userid'] = $user['id'];

            header("Location: ./");
        } else {
            $errorMsg = "Username already in use";
        }
    }
}

echo $Mustache_Engine->render('register', array(
    'error' => $errorMsg,
    'username' => $username,
    'title' => 'Register for DoIt'
));
?>
