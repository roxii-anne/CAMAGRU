<?php
  session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>signup</title>
</head>
<body>
<form action="action_page.php">
  <div class="container">
    <h1>Register</h1>
    <p>Please fill in this form to create an account.</p>
    <hr>

    <label for="email"><b>Email</b></label>
    <input type="text" placeholder="Enter Email" name="email" required>
    <br/>
    <label for="uname"><b>Username</b></label>
    <input type="text" placeholder="Enter Username" name="uname" required>
<br/>
    <label for="psw"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="psw" required>

    <label for="psw-repeat"><b>Repeat Password</b></label>
    <input type="password" placeholder="Repeat Password" name="psw-repeat" required>
    <hr>
    <input name="submit" type="submit" value=" SEND ">
    <span>
    <?php
            echo $_SESSION['error'];
            $_SESSION['error'] = null;
            if (isset($_SESSION['signup_success'])) {
              echo "Signup success please check your mail box";
              $_SESSION['signup_success'] = null;
            }
  ?>
  </span>
  </div>
  <div class="container signin">
    <p>Already have an account? <a href="login.php">log in</a>.</p>
  </div>
  <div class="container" style="background-color:#f1f1f1">
    <button type="button" class="cancelbtn"><a href="index.php">Cancel</a></button>
</form>
</body>
</html>