<?php
    session_start();

    function signup($mail, $username, $password, $host) {
        include_once '../config/database.php';
        include_once 'mail.php';
      
        $mail = strtolower($mail);
      
        try {
                $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
                $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $query= $dbh->prepare("SELECT id FROM users WHERE username=:username OR mail=:mail");
                $query->execute(array(':username' => $username, ':mail' => $mail));
      
                if ($val = $query->fetch()) {
                  $_SESSION['error'] = "user already exist";
                  $query->closeCursor();
                  return(-1);
                }
                $query->closeCursor();
      
                // encrypt password
                $password = hash("whirlpool", $password);
      
                $query= $dbh->prepare("INSERT INTO users (username, mail, password, token) VALUES (:username, :mail, :password, :token)");
                $token = uniqid(rand(), true);
                $query->execute(array(':username' => $username, ':mail' => $mail, ':password' => $password, ':token' => $token));
                send_verification_email($mail, $username, $token, $host);
      
                $_SESSION['signup_success'] = true;
                return (0);
            } catch (PDOException $e) {
                $_SESSION['error'] = "ERROR: ".$e->getMessage();
            }
      }      

// retreive values
$mail = $_POST['email'];
$username = $_POST['username'];
$password = $_POST['password'];

$_SESSION['error'] = null;

if ($mail == "" || $mail == null || $username == "" || $username == null || $password == "" || $password == null) {
  $_SESSION['error'] = "You need to fill all fields";
  header("Location: ../signup.php");
  return;
}

if(!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
  $_SESSION['error'] = "You need to enter a valid email";
  header("Location: ../signup.php");
  return;
}

if (strlen($username) > 50 || strlen($username) < 3) {
  $_SESSION['error'] = "Username should be beetween 3 and 50 characters";
  header("Location: ../signup.php");
  return;
}

if (strlen($password) < 3) {
  $_SESSION['error'] = "Password should be beetween 3 and 255 characters";
  header("Location: ../signup.php");
  return;
}
$url = $_SERVER['HTTP_HOST'] . str_replace("signup.php", "", $_SERVER['REQUEST_URI']);

signup($mail, $username, $password, $url);

header("Location: ../signup.php");
?>
