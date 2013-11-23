<?php
require_once 'config.php';
require_once 'models/Task.class.php';

$Task = new Task($DBH);

$tasks = $Task->get('user', 1);
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>DoIt</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="js/jquery-ui/css/ui-lightness/jquery-ui-1.10.3.custom.min.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="bootstrap/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="bootstrap/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="bootstrap/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="bootstrap/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="bootstrap/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="bootstrap/ico/favicon.png">
  </head>

  <body>

    <div class="navbar navbar-inverse navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="brand" href="#">DoIt</a>
          <div class="nav-collapse collapse">
            <ul class="nav">
              <li class="active"><a href="#">Home</a></li>
              <li><a href="#about">About</a></li>
              <li><a href="#contact">Contact</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div>
      </div>
    </div>

    <div class="container">
      <h1>DoIt</h1>
      <p>For when you don&rsquo;t know what to do.</p>

      <h2>My Tasks</h2>
      <p>Do these things first!</p>
      <table id="tasks" class="table table-bordered">
        <tr>
            <th scope="col">Task</th>
            <th scope="col">Due</th>
            <th scope="col">Actions</th>
        </tr>
      <?php
      foreach ($tasks as $task) {

        $due = date('m/d/Y', strtotime($task['due']));
        echo "<tr id='task-" . $task['id'] . "'><td class='task-name'>" . $task['task'] . "</td><td class='task-due'>" . $due;
        echo '<td class="actions"><a class="btn edit-task">Edit</a> <a class="btn del-task">Delete</a></td></tr>';
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
    </div>

    <script src="bootstrap/js/jquery-1.10.2.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/jquery-ui/js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="js/doit.js"></script>
  </body>
</html>
