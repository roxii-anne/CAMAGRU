<?php
    include 'password-email.php';
    include 'security.php';
?>

    <html>

    <head>
        <meta charset="utf8">
        <link href="style/sign_in.css" rel="stylesheet">
        <link href="style/menu.css" rel="stylesheet">
		<link rel="icon" type="image/png" href="photos/homelogo.png"/>

        <link href="style/reset_password.css" rel="stylesheet">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
        <title>Reset Password</title>
    </head>

    <body>

        <div class="site-content">
            <div class="site-cache" id="site-cache">
                <div class="container" alignment="center">

                    <div class="form-content">
                        <img text-alignment="center" src="photos/locked.png" alt="user_logo" class="img_form">
                        <div class="title" alignment="center">Modify password</div>
                        <form alignment="center" class="form" method="post" action="">
                            <div class="item">Login</div>
                            <input style="text-alignment:center;" class="input" type="text" name="login" />
                            <br>
                            <div class="item">Old password</div>
                            <input style="text-alignment:center;" class="input" type="password" name="oldpassword" />
                            <br>
                            <div class="item">New passord</div>
                            <input style="text-alignment:center;" class="input" type="password" name="newpassword" />
                            <br>
                            <div class="item">Confimation</div>
                            <input style="text-alignment:center;" class="input" type="password" name="confirmnewpassword" />
                            <br>
                            <div alignment="center">
                                <div>
                                    <input type="submit" name="button" value="Modify password" class="button" />
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="separator"></div>
                    <a class="back" href="home.php" class="back">Back</a>
                    <div class="separator"></div>
                    <?php
                        if (isset($ret))
                        {
                            echo $ret;
                        }
                    ?>
                </div>
            </div>
        </div>
    </body>

    </html>
