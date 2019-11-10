<?php
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'obakeng21', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
if ($_POST['connect'] == "sign in")
{
	if (!empty($_POST['login2']) AND !empty($_POST['password2']))
	{
		$login2 = htmlentities($_POST['login2']);
		$mdp3 = sha1(htmlentities($_POST['password2']));
		try {
			$req_user = $conn->prepare("SELECT * FROM users WHERE login= ? AND password = ? AND confirmation= 1");
			$req_user->execute(array($login2, $mdp3));
			$user_exist = $req_user->rowCount();
		}
		catch (PDOexception $e)
		{
			print "Error : ".$e->getMessage()."";
			die();
		}
		if ($user_exist == 1)
		{
			$user_info = $req_user->fetch();
			$_SESSION['id'] = $user_info['id'];
			$_SESSION['login'] = $user_info['login'];
			$_SESSION['email'] = $user_info['email'];
			$_SESSION['password'] = $mdp3;
			$_SESSION['x_origin'] = 100;
			$_SESSION['y_origin'] = 100;
			echo '<script language="javascript">
				document.location.href="post.php";
</script>';
		} else {$ret = "User not registered or wrong password";}
	} else {$ret = "Please complete all the areas";}
}
if (($_POST['inscription'] == "signup"))
{
	if (!empty($_POST['login']) AND !empty($_POST['email']) AND !empty($_POST['password']) AND !empty($_POST['confirmpassword']))
	{
		$login = trim(htmlentities($_POST['login']));
		$email = trim(htmlentities($_POST['email']));
		try {
		$check_email = $conn->prepare("SELECT * FROM users WHERE email= ?");
		$check_email->execute(array($email));
		$email_exist =$check_email->rowCount();
		$check_login = $conn->prepare("SELECT * FROM users WHERE login= ?");
		$check_login->execute(array($login));
		$login_exist =$check_login->rowCount();
		}
		catch (PDOexception $e)
		{
	print "Error : ".$e->getMessage()."";
			die();
		}
		if ($login_exist == 0)
		{    
			if ($email_exist == 0)
			{	
				if (testpassword($_POST['password']))
				{
					$mdp = sha1(htmlentities($_POST['password']));
					$mdp2 = sha1(htmlentities($_POST['confirmpassword']));
					$token = sha1(uniqid());
					if (preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/", $email))
					{
						if ($mdp == $mdp2)
						{
							try {
							$insert_user = $conn->prepare("INSERT INTO users(login,confirmation, email, password, token) VALUES(?, 0, ?, ?, ?)");
							$insert_user->execute(array($login, $email, $mdp, $token));
							send_email($email, $login, $token);
							$ret = "Account created, check your email to confirm your account !";
							}
							catch (PDOexception $e) {
								print "Error : ".$e->getMessage()."";
								die();
							}
						} else {$ret = "Passwords doesn't match !";}
					} else {$ret = "Invalid Email format";}
				}	else {$ret = "Password is too weak !";}
			} else {$ret = "This email is already registred.";}
		} else {$ret = "This login is already used, please try another one.";}
	} else {$ret = "Please complete all the areas.";}
}

function send_email($mail, $login, $token)
{
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
		$passage_line = "\r\n";
	else
		$passage_line = "\n";
	$url = str_replace("index.php", "", $_SERVER['REQUEST_URI']);
	$message_txt = "Hi, here is an e-mail sent by a PHP script";
	$message_html = "<html><head></head><body><b>Hello".$login.",</b><br/>You have registered on the Camagru ! <br/> To validate your account click on the following link: <br/> <a href='http://".$_SERVER['HTTP_HOST']."".$url."script/confirm_account.php?login=".$login."&token=".$token."'>Account validation</a></body></html>";
	$boundary = "-----=".md5(rand());
	$subjet = "Validation to Camagru";
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
			$point_charcters = 5;
		}
	}
}
else 
	return (0);
$etape1 = $point / $length;
$etape2 = $point_min + $point_max + $point_figure + $point_characters;
$result = $etape1 * $etape2;
$final = $result * $length;
if ($final >= 50)
	return (1);
else
	return (0);
}
?>
