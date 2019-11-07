<?php
    session_start();

function log_user($userMail, $password) {
  require '../config/database.php';

  try {
      $dbh = new PDO($DB_DSN, $DB_USER, $DB_PASSWORD);
      $dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $query= $dbh->prepare("SELECT id, username FROM users WHERE mail=:mail AND password=:password AND verified='Y'");
      $userMail = strtolower($userMail);
      $password = hash("whirlpool", $password);
      $query->execute(array(':mail' => $userMail, ':password' => $password));

      $val = $query->fetch();
      if ($val == null) {
          $query->closeCursor();
          return (-1);
      }
      $query->closeCursor();

      return ($val);
    } catch (PDOException $e) {
      $v['err'] = $e->getMessage();
      return ($v);
    }
}
// retreive values
$mail = $_POST['email'];
$password = $_POST['password'];

if (($val = log_user($mail, $password)) == -1) {
  $_SESSION['error'] = "user not found";
} else if (isset($val['err'])) {
  $_SESSION['error'] = $val['err'];
} else {
  $_SESSION['id'] = $val['id'];
  $_SESSION['username'] = $val['username'];
}

header("Location: ../login.php");
?>