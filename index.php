<?php
require_once 'config.php';
require_once 'models/Task.class.php';
require_once 'models/User.class.php';

if (isset($_POST) && array_key_exists('username', $_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $User = new User($DBH);
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

require_once 'header.php';

if (isset($_SESSION['username'])) {
?>
<h2>My Tasks</h2>
<p>Keep track of what needs to get done! Add, modify and complete your tasks below.</p>
<table id="tasks" class="table table-bordered">
<tr>
    <th scope="col">Task</th>
    <th scope="col">Due</th>
    <th scope="col">Actions</th>
</tr>
<?php
$curDate = date('m/d/y');
$params = Array(
  'user' => $_SESSION['userid'],
  'completed' => null
);
$Task = new Task($DBH);
foreach ($Task->filter($params) as $task) {
    $due = date('m/d/Y', strtotime($task['due']));
    echo "<tr ";
    if ($due < $curDate) {
        echo "class='alert alert-error' ";
    }
    echo "id='task-" . $task['id'] . "'><td class='task-name'>" . $task['task'] . "</td><td class='task-due'>" . $due;
    echo '<td class="actions"><a class="btn complete-task">Complete</a> <a class="btn edit-task">Edit</a> <a class="btn del-task">Delete</a></td></tr>';
}
?>
</table>

<div id="add-form">
<h3>Add Task</h3>
<p>Have some work to do? Write it down here!</p>
<form id="new-task">
    <fieldset>
        <legend>Make yourself a task</legend>
        <label for="task">What needs to get done?</label>
        <input type="text" id="task" name="task" />

        <label for="due">When does this need to be finished?</label>
        <input type="text" id="due" name="due" />

        <p><input type="hidden" name="action" value="create" /><input type="submit" class="btn" value="Create" /></p>
    </fieldset>
  </form>
</div>

<p><a id="add-task" class="btn">Add Task</a></p>
<?php
} else {
  require_once 'login.php';
}
require_once 'footer.php';
?>
