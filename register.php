<?php
require_once 'config.php';
require_once 'models/User.class.php';

if (isset($_POST)) {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);

    $params = Array(
        'username' => $username,
        'password' => $password
    );

    $User = new User($DBH);
    $user = $User->create($params);
    if ($user != false) {
        $_SESSION['username'] = $user['username'];
        $_SESSION['userid'] = $user['id'];

        header("Location: ./");
    }
}

require_once 'header.php';
?>
      <h1>DoIt</h1>
      <p>Register an Account</p>
      <form action="" method="post">
        <fieldset>
            <legend>Fill in the form below to create an account</legend>
            <ul>
            <li><label for="user">Username:</label>
            <input type="text" name="username" id="user" /></li>

            <li><label for="password">Password:</label>
            <input type="password" name="password" id="password" /></li>

            <p><input type="submit" class="btn btn-primary" value="Register" /></p>
        </fieldset>
     </form>
  </body>
</html>
