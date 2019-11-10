<?php
    include 'security.php';
?>

    <html>

    <head>
        <meta charset="utf8">
        <meta name="viewport" content="width=device-width initial-scale=1.0" />
        <title>Camagru</title>
        <link href="style/menu.css" rel="stylesheet">
        <link href="style/account.css" rel="stylesheet">
        <link href="style/sign_in.css" rel="stylesheet">
        <link href='https://fonts.googleapis.com/css?family=Roboto:300' rel='stylesheet' type='text/css'>
		<link rel="icon" type="image/png" href="photos/homelogo.png"/>
    </head>

    <body>
        <div class="site-container">
            <div class="site-pusher">
                <header class="header">
                    <a href="#" class="header__icon" id="header__icon" onClick="hide()"></a>
                    <a href="feed.php" class="header__logo">
                        <img src="photos/logo.png" alt="logo">
                    </a>
                    <nav class="menu">
                        <div class="a0" class="fix"></div>
                        <a href="feed.php" class="a2"><img class="logo-menu" src="photos/feed.png" alt="feed"></a>
                        <a href="my_gallery.php" class="a1"><img class="logo-menu" src="photos/mygallery.png" alt="man"></a>
                        <a href="post.php" class="a2"><img class="logo-menu" src="photos/post.png" alt="eye"></a>
                        <a href="home.php" class="a1"><img class="logo-menu" src="photos/account.png"></a>
                        <a href="logout.php" class="a2"><img class="logo-menu" src="photos/logout.png"></a>
                        <?php echo '<p>'.$_SESSION['login'].'@camagru</p>'; ?>
                    </nav>
                </header>

                <div class="site-content">
                    <div class="site-cache" id="site-cache" onClick="hide()">
                        <div class="container" alignment="center" onClick="hide()">



                            <?php
    echo '<div class="user">'.$_SESSION['login'].'</div>';
?>





                                <div class="separator"></div>

                                <div class="box">
                                    <div class="option_a">
                                        <a href="change_password.php"><img src="photos/warning.png" alt="warning">Change Password</a>
                                    </div>
                                    <div class="option_b">
                                        <a href="reset_email.php"><img src="photos/envelope.png" alt="warning">Change e-mail</a>
                                    </div>
                                    <div class="option_a">
                                        <a href="delete_account.php"><img src="photos/garbage.png" alt="garbage">Delete account</a>
                                    </div>

                                </div>

                                <div class="separator"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script language="javascript" src="js/tools.js"></script>
    </body>

    </html>
