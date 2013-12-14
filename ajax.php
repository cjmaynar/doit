<?php
/**
 * Handle all AJAX requests for creating, deleting,
 * editing, and completing tasks
 */
require_once 'config.php';

if (!array_key_exists('action', $_POST)) {
    error_log("Direct access to ajax.php");
    header("Location: ./");
}

$action = $_POST['action'];
unset($_POST['action']);

$Task = new Models\Task($DBH);
switch ($action) {
    case 'create':
        $_POST['user'] = $_SESSION['userid'];
        $result = $Task->create($_POST);
        break;
    case 'delete':
        $result = $Task->delete($_POST['id']);
        break;
    case 'edit':
        $result = $Task->update($_POST);
        break;
    case 'complete':
        $result = $Task->complete($_POST['id']);
        break;
}
echo json_encode($result);
?>
