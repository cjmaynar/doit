<?php
require_once 'config.php';
require_once 'models/Task.class.php';

$Task = new Task($DBH);

require_once 'header.php';
?>
<h1>My Completed Tasks</h1>
<ul>
    <?php
    foreach ($Task->completed($_SESSION['userid']) as $task) {
        echo "<li>" . $task['task'] . "</li>";
    }
    ?>

</ul>
</body>
</html>
