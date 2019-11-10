<?php
session_start();
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'obakeng21', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));

if ($_GET['id_post'])
{
	$_SESSION['id_post'] = $_GET['id_post'];
}

if ($_POST['send']  == 'send')
{
	if (!empty($_POST['comment']))
	{
		$id_post = $_SESSION['id_post'];
		$login = $_SESSION['login'];
		$comment = htmlentities($_POST['comment']);
        if ($_SESSION['old_message'] != $comment) {
            
		try {
			$req_com = $conn->prepare("INSERT INTO comments(id_post, login, value) VALUES(?, ?, ?)");
			$req_com->execute(array($id_post, $login, $comment));
            $_SESSION['old_message'] = $comment;
			$find_user = $conn->prepare("SELECT * FROM post WHERE id = ?");
			$find_user->execute(array($id_post));
			$post = $find_user->fetch();
			$login_to_find = $post['login'];
			$find_mail = $conn->prepare("SELECT * FROM users WHERE login = ?");
			$find_mail->execute(array($login_to_find));
			$mail = $find_mail->fetch();
			if ($login != $login_to_find)
				send_email($mail['email'], $login, $login_to_find);
		}
		catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
        }
	} else {$ret = "Please enter a comment";}
}

if ($_GET['delete-com'])
{
	$com_id = $_GET['delete-com'];
	try {
		$req_del_com = $conn->prepare("DELETE FROM comments WHERE id = ?");
		$req_del_com->execute(array($com_id));
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
}

if ($_POST['like'] == "Like")
{
	$id_post = $_SESSION['id_post'];
	$login = $_SESSION['login'];
	try{
		$req_like = $conn->prepare("SELECT * FROM like_dislike WHERE id_post = ? AND login = ?");
		$req_like->execute(array($id_post, $login));
		$verif = $req_like->rowCount();
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
	if ($verif == 0)
	{
		$confirm = 1;
		try{
			$like = $conn->prepare("INSERT INTO like_dislike(id_post, login, confirm) VALUES(?, ?, ?)");
			$like->execute(array($id_post, $login, $confirm));
		}
		catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
	}
	try {
		$req_nb_like = $conn->prepare("SELECT * FROM like_dislike WHERE id_post = ?");
		$req_nb_like->execute(array($id_post));
		$like_set = $req_nb_like->fetchAll();
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
	$j = 0;
	while ($like_set[$j])
	{
		$j++;
	}
	try {
		$update_nb_like = $conn->prepare("UPDATE post SET nb_likes = ? WHERE id = ?");
		$update_nb_like->execute(array($j, $id_post));
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
}

if ($_POST['like'] == "Unlike")
{
	$id_post = $_SESSION['id_post'];
	$login = $_SESSION['login'];
	try {
		$req_del_like = $conn->prepare("DELETE FROM like_dislike WHERE id_post = ? AND login = ?");
		$req_del_like->execute(array($id_post, $login));
		$req_nb_like = $conn->prepare("SELECT * FROM like_dislike WHERE id_post = ?");
		$req_nb_like->execute(array($id_post));
		$like_set = $req_nb_like->fetchAll();
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
	$j = 0;
	while ($like_set[$j])
	{
		$j++;
	}
	try{
		$update_nb_like = $conn->prepare("UPDATE post SET nb_likes = ? WHERE id = ?");
		$update_nb_like->execute(array($j, $id_post));
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
}

if ($_POST['delete-post'] == "Delete post")
{
	try{
		$req_name = $conn->prepare("SELECT * FROM post WHERE id = ?");
		$req_name->execute(array($_SESSION[id_post]));
		$post = $req_name->fetch();
		unlink('./photos/'.$post['image']);
		$req_delete_post = $conn->prepare("DELETE FROM post WHERE id = ?");
		$req_delete_post->execute(array($_SESSION['id_post']));
		$req_delete_com = $conn->prepare("DELETE FROM comments WHERE id_post = ?");
		$req_delete_com->execute(array($_SESSION['id_post']));
		$req_delete_like = $conn->prepare("DELETE FROM like_dislike WHERE id_post = ?");
		$req_delete_like->execute(array($_SESSION['id_post']));
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
}

if ($_SESSION['id_post'])
{
	try{
		$id_post = $_SESSION['id_post'];
		$req_image = $conn->prepare("SELECT * FROM post WHERE id = ?");
		$req_com_set = $conn->prepare("SELECT * FROM comments WHERE id_post = ?");
		$req_com_set->execute(array($id_post));
		$com_set = $req_com_set->fetchAll();
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
	$i = 0;
	while ($com_set[$i])
	{
		$i++;
	}
	try {
		$update_nb_com = $conn->prepare("UPDATE post SET nb_com  = ? WHERE id = ?");
		$update_nb_com->execute(array($i, $id_post));
		$req_image->execute(array($id_post));
		$style = "b1";
		$verif = $req_image->rowCount();
	}
	catch (PDOexception $e) {
		print "Error : ".$e->getMessage()."";
		die();
	}
	if ($verif == 1)
	{
		$post = $req_image->fetch();
		echo '<div class="post">';
		echo '<img src="./images/'.$post['image'].'">';
		echo '<div class="post-container">';
		echo '<div class="marks">';
		echo '<div class="num">'.$post['nb_likes'].'</div><img src="photos/like.png">';
		echo '<div class="num">'.$post['nb_com'].'</div><img src="photos/flag.png">';
		echo '<div class="info">Posted by : '.$post['login'].' '.$post['date_post'].' </div>';
		echo '</div>';

		$i = 0;
		while ($com_set[$i])
		{
			if ($i % 2 == 1)
			{
				$style = "b2";
			}
			else {$style = "b1";}
				echo '<div class="comment" id="'.$style.'">';
			if ($com_set[$i]['login'] == $_SESSION['login'])
			{
				echo '<a class="delete-com"  href="comment_like.php?delete-com='.$com_set[$i]["id"].'"><img src="photos/delete.png" id="delete-logo"></a>';
			}
			echo '<div class="login">'.$com_set[$i][login].'</div>';
			echo '<p>'.$com_set[$i]['value'].'</p>';

			echo '<br>';
			echo '</div>';
			$i++;
		}



		echo '<form method="post" action="" class="comment">';
		echo '<br>';
		echo '<textarea type="text" name="comment"></textarea>';
		echo '<br/>';
		echo '<input type="submit" name="send" value="send" class="send">';
		try {
			$req_liked = $conn->prepare("SELECT * FROM like_dislike WHERE id_post = ? AND login = ?");
			$req_liked->execute(array($id_post, $_SESSION['login']));
			$already_liked = $req_liked->rowCount();
		}
		catch (PDOexception $e) {
			print "Error : ".$e->getMessage()."";
			die();
		}
		if ($already_liked == 0)
		{
			$value = "Like";
		} else {$value = "Unlike";}
			echo '<input type="submit" name="like" value="'.$value.'" class="send">';
		if ($post['login'] == $_SESSION['login'])
		{
			echo '<input type="submit" name="delete-post" value="Delete post" class="delete-button" onMouseHover="buttonHover()"/>';
		}
		echo '<br><br>';
		echo '<a class="back" href="feed.php">Return</a>';
		echo '</form>';
		echo '</div>';
		echo '</div>';
		echo '<div class="separator"></div>';

		echo '<div class="separator"></div>';

	} else {$ret = "This post was deleted, or doesn't exist";
	}
} else {$ret = "Error when trying to find this post";}
echo $ret;
if ($ret === "This post was deleted, or doesn't exist")
{
	echo '<br><br>';
	echo '<a href="my_gallery.php">Return</a>';
}
function send_email($mail, $login, $login_to_find)
{
	if (!preg_match("#^[a-z0-9._-]+@(hotmail|live|msn).[a-z]{2,4}$#", $mail))
		$passage_line = "\r\n";
	else
		$passage_line = "\n";
	$message_txt = "Hi, here is an e-mail sent by a PHP script.";
	$message_html = "<html><head></head><body><b>Bonjour ".$login_to_find.",</b><br/>Un nouveau comment vient d'etre ecrit par ".$login." sur une de vos photos!</body></html>";
	$boundary = "-----=".md5(rand());
	$subjet = "Commented photo";
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


?>