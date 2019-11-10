<?php
    session_start();
    $conn = new PDO('mysql:host=localhost;dbname=camagru', 'root', 'obakeng21', array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION ));
    $login = $_SESSION['login'];
     try {
    $req = $conn->prepare("SELECT * FROM post WHERE login = ? ORDER BY posix DESC");

    $req->execute(array($login));
	$image_set = $req->fetchAll();
	 }
	catch (PDOexception $e)
	{
		print "Error  : ".$e->getMessage()."";
		die();
	}
    $i = 0;
    if (!$image_set)
    {
        echo '<br>';
		echo '<center><h4>Your gallery is empty</h4></center>';
        echo '<br><br>';
        echo '<center><img src="photos/sad.png" alt="sad face" class="sad-face"></div></center>';
        echo '<br><br>';
        echo '<style> .feed {background-color: transparent;} .sad-face { filter: invert(100%); -webkit-filter: invert(100%);} </style>';
    }
    while ($image_set[$i])
    {
        $encode_image = $image_set[$i]['image'];
      echo '<div class="post">'; 
	  echo '<div class="montage">';
        echo '<img src="./images/'.$encode_image.'">'; 
		echo '</div>';
        echo '<div class="post-container">';
        echo '<div class="marks">';
        echo '<div class="num">'.$image_set[$i]['nb_likes'].'</div><img id="like" src="photos/like.png">';
        echo '<div class="num">'.$image_set[$i]['nb_com'].'</div><img id="com" src="photos/flag.png">';        
        echo '</div>';
        echo '<a class="interact" href="comment_like.php?id_post='.$image_set[$i]['id'].'">interact</a>';
        echo '<div class="date">'.$image_set[$i]['date_post'].' </div>';
        echo '<br>';
        echo '<center><div class="info">Posted by : '.$image_set[$i]['login'].' </div></center>';        
        echo '</div>';
        echo '</div>';
        $i++;
    }
    ?>
