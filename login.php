<h1>DoIt</h1>
<p>A simple To Do list &mdash; Now you Too Can Do Things.</p>

<?php
if (isset($errorMsg)) {
    echo "<p><strong>Error: $errorMsg</strong></p>";
}
?>
<form action="" method="post" role="form">
<fieldset>
    <legend>Login to see your tasks</legend>
    <div class="form-group">
    <label for="user">Username:</label>
    <input type="text" name="username" id="user" placeholder="Username" />
    </div>

    <div class="form-group">
    <label for="password">Password:</label>
    <input type="text" name="password" id="password" placeholder="Password" />
    </div>

    <p><input type="submit" class="btn btn-primary" value="Login" /></p>
    <p>Don&rsquo;t have an account? <a href="register.php">Register a new account</a>.</p>
</fieldset>
</form>