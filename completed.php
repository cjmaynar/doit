<?php
$title = "Completed Tasks";
require_once 'config.php';
require_once 'models/Task.class.php';

$Task = new Task($DBH);

require_once 'header.php';
?>
<h2>My Completed Tasks</h2>
<p>A listing of all the things that you&rsquo;ve acomplished. Well Done.</p>
<?php
$tasks = $Task->completed($_SESSION['userid']);
if (count($tasks) > 0) {
    echo "<ul>";
    foreach ($tasks as $task) {
        echo "<li>" . $task['task'] . "
        <p>Finished: " . date("m/d/y g:i a", strtotime($task['completed'])) . "</p></li>";
    }
    echo "</ul>";
} else {
    echo "<p>You haven&rsquo;t completed anything yet! Go <a href='./'>Make some tasks!</a></p>";
}

require_once 'footer.php';
?>
