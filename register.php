<?php
require_once 'config.php';
require_once 'models/User.class.php';

$username = ''; //Empty to prevent need for isset check

if (array_key_exists('username', $_POST)) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if ($username == '' || $password == '') {
        $errorMsg = "You must provide a username and password";
    } elseif ($password2 != $password) {
        $errorMsg = "Your passwords do not match";
    } else {
        $password = hash('sha256', $password);
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
            $errorMsg = "Username already in use";
        }
    }
}

$title = "Register for DoIt";
require_once 'header.php';
?>
<h2>Register New Account</h2>
<p>You must create a user account on DoIt before you can begin creating tasks.</p>

<form action="" method="post">
<fieldset>
    <legend>Create an account to begin tracking your tasks</legend>
      <?php
      if (isset($errorMsg)) {
          echo "<p class='alert alert-error'><strong>Error: $errorMsg</strong></p>";
      }
      ?>
    <div class="form-group">
    <label for="user">Username:</label>
    <input type="text" name="username" id="user" value="<?php echo $username ?>" placeholder="Username" />
    </div>

    <div class="form-group">
    <label for="password">Password:</label>
    <input type="password" name="password" id="password" placeholder="Password" />
    </div>

    <div class="form-group">
    <label for="password2">Confirm Password:</label>
    <input type="password" name="password2" id="password2" placeholder="Once again" />
    </div>

    <p><input type="submit" class="btn btn-primary" value="Register" /></p>
    <p>Already have an account? <a href="./">Login</a>.</p>
</fieldset>
</form>
<?php
require_once 'footer.php';
?>
