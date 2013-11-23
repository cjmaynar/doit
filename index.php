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
?>
      <h1>DoIt</h1>
      <p>For when you don&rsquo;t know what to do.</p>

      <?php
      if (isset($_SESSION['username'])) {
      ?>
      <h2>My Tasks</h2>
      <p>Do these things first!</p>
      <table id="tasks" class="table table-bordered">
        <tr>
            <th scope="col">Task</th>
            <th scope="col">Due</th>
            <th scope="col">Actions</th>
        </tr>
      <?php
      $Task = new Task($DBH);

      $params = Array(
          'user' => $_SESSION['userid'],
          'completed' => null
      );
      $tasks = $Task->filter($params);
      foreach ($tasks as $task) {

        $due = date('m/d/Y', strtotime($task['due']));
        echo "<tr id='task-" . $task['id'] . "'><td class='task-name'>" . $task['task'] . "</td><td class='task-due'>" . $due;
        echo '<td class="actions"><a class="btn complete-task">Complete</a> <a class="btn edit-task">Edit</a> <a class="btn del-task">Delete</a></td></tr>';
      }
      ?>
      </table>

      <div id="add-form">
        <h2>Add Task</h2>
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
    ?>
        <h3>Login</h3>
        <?php
        if (isset($errorMsg)) {
            echo "<p><strong>Error: $errorMsg</strong></p>";
        }
        ?>
        <form action="" method="post">
        <fieldset>
            <legend>Login to see your tasks</legend>
            <ul>
            <li><label for="user">Username:</label>
            <input type="text" name="username" id="user" /></li>

            <li><label for="password">Password:</label>
            <input type="text" name="password" id="password" /></li>
            </ul>

            <p><input type="submit" class="btn btn-primary" value="Login" /></p>
            <p>Don&rsquo;t have an account? <a href="register.php">Register a new account</a>.</p>
        </fieldset>
        </form>
    <?php
      }
      ?>
    </div>

    <script src="bootstrap/js/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/doit.js"></script>
  </body>
</html>
