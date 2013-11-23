<?php
require_once 'header.php';
require_once 'models/User.class.php';

if (array_key_exists('username', $_POST)) {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);

    if ($username == '' || $password == '') {
        $errorMsg = "You must provide a username and password";
    } else {
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
        } else {
            $errorMsg = "Unable to create account";
        }
    }
}
?>
      <h1>DoIt</h1>
      <p>You must create a user account on DoIt before you can begin creating tasks.</p>

      <form action="" method="post">
        <fieldset>
            <legend>Fill in the form below to create an account</legend>
              <?php
              if (isset($errorMsg)) {
                  echo "<p><strong>Error: $errorMsg</strong></p>";
              }
              ?>
            <div class="form-group">
            <label for="user">Username:</label>
            <input type="text" name="username" id="user" placeholder="Username" />
            </div>

            <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" placeholder="Password" />
            </div>

            <p><input type="submit" class="btn btn-primary" value="Register" /></p>
        </fieldset>
     </form>
  </body>
</html>
