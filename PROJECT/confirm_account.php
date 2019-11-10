<?php
$conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'obakeng21', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
$login = (isset($_GET["login"])) ? htmlentities($_GET["login"]) : NULL;
$token = (isset($_GET["token"])) ? htmlentities($_GET["token"]) : NULL;
try
{
$req_user = $conn->prepare("UPDATE users SET confirmation = 1 WHERE login = ? AND token = ?");
$req_user->execute(array($login, $token));
$req_user = $conn->prepare("SELECT 1 FROM users WHERE login = ? AND token = ?");
$req_user->execute(array($login, $token));
if ($user_info = $req_user->fetch()) {
	$ret = "Your account has been validated!";
}
else
{
	$ret ="A mistake occured please try again, your account hasn't been validated";
}
$req_user = $conn->prepare("UPDATE users SET token = 0 WHERE login = ?");
$req_user->execute(array($login));
echo $ret;
}
catch (PDOexception $e)
{
	print "Error : ".$e->getMessage()."";
	die();
}
?>
<script language="JavaScript">
setTimeout(function(){
document.location.href="index.php";
}, 4000);
</script>

