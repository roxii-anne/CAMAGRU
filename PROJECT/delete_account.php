<?php
    session_start();
    $polite = "Hello ".$_SESSION['login'];
    $sure =  "You are about to delete your account.<br>This action will be permanent and will erase all the data you saved on Camagru, are you sure you want to delete your account ? <b>If yes please click under the link below";

?>

<html>
    <head>
        <link href="style/delete.css" rel="stylesheet">
        <link href="style/menu.css" rel="stylesheet"> 
		<link rel="icon" type="image/png" href="photos/homelogo.png"/>
        <meta charset="utf-8">
    </head>
    <body>
        <div class="separator"></div>
        <center>
        <div class="all">
        <?php 
            echo '<h1>'.$polite.'</h1>';
            echo '<h4>'.$sure.'</h4>';
            echo "<br>";
            echo '<a href="delete.php?login='.$_SESSION['login'].' class="salam-link"> Delete account</a>';       
        ?>
        </div>
            <img src="photos/homelogo.png" alt="camagru-logo" width="300px">
			<div class="separator"></div>
            <a class="back" href="home.php" class="back">Back</a>
            <div class="separator"></div>
		</center>
    </body>
</html>
