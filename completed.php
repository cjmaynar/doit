<?php
require_once 'config.php';

if (!isset($_SESSION['userid'])) {
    header("Location: .");
}

$Task = new Models\Task($DBH);
$Tasks = $Task->completed($_SESSION['userid']);
echo $Mustache_Engine->render('completed', array(
    'error' => $errorMsg,
    'username' => $username,
    'userid' => $_SESSION['userid'],
    'tasks' => $Tasks,
    'title' => 'Completed Tasks'
));
?>
