<?php
require_once 'config.php';
require_once 'models/Task.class.php';

$action = $_POST['action'];
unset($_POST['action']);

$Task = new Task($DBH);

error_log(print_r($_POST, true));


$due = explode('/', $_POST['due']);
$_POST['due'] = $due[2] . '-' . $due[0] . '-' . $due[1];
switch ($action) {
    case 'create':
        $Task->create($_POST);
        break;
    case 'delete':
        $Task->delete($_POST['id']);
        break;
    case 'edit':
        $Task->update($_POST);
        break;
}

echo json_encode($_POST);
?>
