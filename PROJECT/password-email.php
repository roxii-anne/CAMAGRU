<?php
session_start();
if ($_POST['button'] == "Send mail")
{
	$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'obakeng21', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	if (!empty($_POST['login']) AND !empty($_POST['email']))
	{
		$login = htmlentities($_POST['login']);
		$email = htmlentities($_POST['email']);
		try {
			$req_user = $conn->prepare("SELECT * FROM users WHERE login= ?");
		$req_user->execute(array($login));
		$user_info = $req_user->fetch();
		$user_check = $req_user->rowCount();
		}
		catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
		if ($user_check == 1)
		{
		if ($email == $user_info['email'])
			{
				send_email($email, $login);
				$_SESSION['login'] = $login;
				$ret = "An email has been send to reset your password";
			} else {$ret = "This email doesn't match your email";}
		} else {$ret = "This login doesn't exist";}
	} else {$ret = "Please Type all the areas";}
}
if ($_POST['button'] == "Modify password")
{
	$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'obakeng21', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	if (!empty($_POST['login']) AND !empty($_POST['oldpassword']) AND !empty($_POST['newpassword']) AND !empty($_POST['confirmnewpassword']))
	{
		$login = htmlentities($_POST['login']);
		$oldpassword = sha1(htmlentities($_POST['oldpassword']));
		$newpassword = sha1(htmlentities($_POST['newpassword']));
		$conf = sha1(htmlentities($_POST['confirmnewpassword']));
		try {
			$req_user = $conn->prepare("SELECT * FROM users WHERE id= ?");
		$req_user->execute(array($_SESSION['id']));
		$user_info = $req_user->fetch();
		}
		catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
		if ($login == $_SESSION['login'])
		{
			if ($oldpassword == $user_info['password'])
			{
				if ($newpassword == $conf)
				{
					if (testpassword($_POST['confirmnewpassword'])) {
						try{
							$insert_new_passwwd = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
					$insert_new_passwwd->execute(array($conf, $_SESSION['id']));
							$ret = "Password updated";
						}
		catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
					} else {$ret = "Password is too weak";}
				} else {$ret = "Your new password doesn 't match with the confirm one";}
			} else {$ret = "Please verify your old password";}
		} else {$ret = "This login doesn't exist";}
	} else {$ret = "Please type all the areas";}
}
if ($_POST['button'] == "Change Password")
{
	$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'obakeng21', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	if (!empty($_POST['login'])  AND !empty($_POST['email']) AND !empty($_POST['newpassword']) AND !empty($_POST['confirmnewpassword']))
	{
		$login = htmlentities($_POST['login']);
		$email = htmlentities($_POST['email']);
		$newpassword = sha1(htmlentities($_POST['newpassword']));
		$conf = sha1(htmlentities($_POST['confirmnewpassword']));
		try {
		$req_user = $conn->prepare("SELECT * FROM users WHERE login= ? AND email = ?");
		$req_user->execute(array($login, $email));
		$user_info = $req_user->rowCount();
		}
		catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
		if ($user_info)
		{
				if ($newpassword == $conf)
				{
					if (testpassword($_POST['confirmnewpassword'])) {
						try {
							$insert_new_passwwd = $conn->prepare("UPDATE users SET password = ? WHERE login = ?");
					$insert_new_passwwd->execute(array($conf, $login));
							$ret = "Password updated";
						}
								catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
					}		else {$ret = "Password is too weak";}
				} else {$ret = "Your new password doesn 't match with the confirm one";}
			} else {$ret = "Incorrect login or email";}
	} else {$ret = "Please type all the areas";}
}

if ($_POST['reset'] == "Change email")
{
	$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'root', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
	if (!empty($_POST['newemail']) AND !empty($_POST['confirmnewemail']))
	{
		$newemail = htmlentities($_POST['newemail']);
		$conf = htmlentities($_POST['confirmnewemail']);
		try {
			$req_user = $conn->prepare("SELECT * FROM users WHERE id= ?");
		$req_user->execute(array($_SESSION['id']));
			$user_info = $req_user->fetch();
		}
		catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
		if ($newemail == $conf)
		{
			try {
				$check_emails = $conn->prepare("SELECT * FROM users WHERE email = ?");
			$check_emails->execute(array($conf));
				$valid = $check_emails->rowCount();
			}
					catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
			if (!$valid) 
			{
				try {
					$insert_new_email = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
					$insert_new_email->execute(array($conf, $_SESSION['id']));
				}
						catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
				$_SESSION['email'] = $conf;
				header("Location: reset_email.php");
			} else {$ret = "Email already used by another account";}
		} else {$ret = "Emails dosen't match";}
	} else {$ret = "Please type all the areas";}
}

function send_email($mail, $login)
{
	$url = str_replace("reset_password.php", "" , $_SERVER['REQUEST_URI']);
	$url = str_replace("index.php", "" , $url);
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
		$passage_line = "\r\n";
	else
		$passage_line = "\n";
	$message_txt = "Hi, here is an e-mail sent by a PHP script.";
	$message_html = "<html><head></head><body><b>Welcome ".$login.",</b><br/>You have just requested the reset of your password. <br/>To change your password click on the following link: <br/> <a href='http://".$_SERVER['HTTP_HOST']."".$url."change_password.php'>Change Password</a></body></html>";
	$boundary = "-----=".md5(rand());
	$subjet = "Changing the password for your Camagru account";
	$header = "From: \"Camagru\"<NoReply@camagru.com>".$passage_line;
	$header.= "Reply-to: \"Camagru\" <NoReply@camagru.com>".$passage_line;
	$header.= "MIME-Version: 1.0".$passage_line;
	$header.= "Content-Type: multipart/alternative;".$passage_line." boundary=\"$boundary\"".$passage_line;
	$message = $passage_line."--".$boundary.$passage_line;
	$message.= "Content-Type: text/plain; charset=\"UTF-8\"".$passage_line;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_line;
	$message.= $passage_line.$message_txt.$passage_line;
	$message.= $passage_line."--".$boundary.$passage_line;
	$message.= "Content-Type: text/html; charset=\"UTF-8\"".$passage_line;
	$message.= "Content-Transfer-Encoding: 8bit".$passage_line;
	$message.= $passage_line.$message_html.$passage_line;
	$message.= $passage_line."--".$boundary."--".$passage_line;
	$message.= $passage_line."--".$boundary."--".$passage_line;
	mail($mail,$subjet,$message,$header);
}

function testpassword($mdp)	
{
$length = strlen($mdp);
if ($length >= 5) {
	for($i = 0; $i < $length; $i++) 	{
		$letter = $mdp[$i];
		if ($letter>='a' && $letter<='z'){
			$point = $point + 1;
			$point_min = 1;
		}
		else if ($letter>='A' && $letter <='Z'){
			$point = $point + 2;
			$point_max = 2;
		}
		else if ($letter>='0' && $letter<='9'){
			$point = $point + 3;
			$point_figure = 3;
		}
		else {
			$point = $point + 5;
			$point_character = 5;
		}
	}
}
else 
	return (0);
$etape1 = $point / $length;
$etape2 = $point_min + $point_max + $point_figure + $point_character;
$result = $etape1 * $etape2;
$final = $result * $length;
if ($final >= 50)
	return (1);
else
	return (0);
}
?>
