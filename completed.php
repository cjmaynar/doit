<?php
require_once 'config.php';
require_once 'models/Task.class.php';

$Task = new Task($DBH);

require_once 'header.php';
?>
<h2>My Completed Tasks</h2>
<p>A listing of all the things that you&rsquo;ve acomplished. Well Done.</p>
<ul>
<?php
foreach ($Task->completed($_SESSION['userid']) as $task) {
    echo "<li>" . $task['task'] . "
    <p>Finished: " . date("m/d/y \a\\t g:i a", $task['completed']) . "</p></li>";
}
echo "</ul>";

require_once 'footer.php';
?>
