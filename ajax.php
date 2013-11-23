<?php
require_once 'config.php';
require_once 'models/Task.class.php';

$action = $_POST['action'];
unset($_POST['action']);

$Task = new Task($DBH);

switch ($action) {
    case 'create':
        $result = $Task->create($_POST);
        break;
    case 'delete':
        $result = $Task->delete($_POST['id']);
        break;
    case 'edit':
        $result = $Task->update($_POST);
        break;
}

echo json_encode($result);
?>
