<?PHP
session_start();
include 'config/setup.php';
?>
    <html>
    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width initial-scale=1.0" />
        <title>Camagru</title>
        <link href="style/sign_in.css" rel="stylesheet">
        <link href="style/menu.css" rel="stylesheet">
        <link href="style/reset_password.css" rel="stylesheet">
        <link href="style/index.css" rel="stylesheet">
		<link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
		<link rel="icon" type="image/png" href="photos/homelogo.png"/>
    </head>
    <body>
        <div class="sign-bar">
            <img src="photos/logme.jpeg" alt="log-logo" width="90px">Welcome
			   <form method="POST" action="" id="sign_in">
                <div>Login</div>
                <input class="input-bar" type="text" name="login2" />
                <div>Password</div>
                <input class="input-bar" type="password" name="password2" />
			<input type="submit" name="connect" value="sign in" id="sign" />
                <div style="font-size:10px" style="display:inline-block">  <a href="reset_password.php">Forgot your Password?</a> </div>
            </form>
        </div>
        <div class="site-content" id="site-content">
            <div class="site-cache" id="site-cache">
                <div class="container" alignment="center">
                    <div class="separator"></div>
                    <div class="welcome">
                        <p class="warm-welcome">New to Camagru ?
                            <br>Create your account here</p>
                        <img src="photos/homelogo.png" alt="homelogo">
                    </div>
                    <div class="form-content">
                        <img text-alignment="center" src="photos/user.png" alt="user_logo" class="img_form">
                        <form alignment="center" method="POST" action="" class="form">
                            <div class="item">Login</div>
                            <input style="text-alignment:center;" class="input" type="text" name="login" />
                            <div class="item">Email</div>
                            <input style="text-alignment:center;" class="input" type="email" name="email" />
                            <div class="item">Password</div>
                            <input style="text-alignment:center;" class="input" type="password" name="password" />
                            <div class="item">Confirm password</div>
                            <input style="text-alignment:center;" class="input" type="password" name="confirmpassword" />
                            <br>
                            <input type="submit" name="inscription" value="signup" class="button" />
                        </form>
                    </div>
                    <?PHP
include 'connection.php';
                ?>
                        <div class="separator">
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