<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>login</title>
</head>
<body>
<form action="action_page.php" method="post">
  <div class="container">
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>
<br/>
<br/>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>
<br/>
<input name="submit" type="submit" value=" SEND ">
    <label>
      <input type="checkbox" checked="checked" name="remember"> Remember me
    </label>
  </div>
<br/>
  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn"><a href="index.php">Cancel</a></button>
    <br/>
    <span class="psw">Forgot <a href="#">password?</a></span>
  </div>
  <br/>
  <div class="container" style="background-color:#f1f1f1">
    Don't have an account?<button type="button" class="cancelbtn"><a href="signup.php">Sign up</a></button>
    <br/>
  </div>
</form>
</body>
</html>