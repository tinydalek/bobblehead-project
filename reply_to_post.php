<!DOCTYPE html>
<html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Bobbleshop Website</title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap-theme.min.css">
    <link rel="stylesheet" type="text/css" href="css/main_layout.css">
     <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <!-- Scripts for Custom Bobblehead Canvas Ad -->
    <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
    <script src="javascript/custom_canvas.js"></script>
</head>

<body>
        <header>

            <div class="fill fixed-section">
                <div id="banner" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                        <li data-target="#myCarousel" data-slide-to="1"></li>
                        <li data-target="#myCarousel" data-slide-to="2"></li>
                        <li data-target="#myCarousel" data-slide-to="3"></li>
                    </ol>

                    <!-- Wrapper for banners -->
                    <div class="carousel-inner" role="listbox">
                        <div class="item active">
                            <a href="collections.php"><img src="images/banner_starwars.jpg" alt="Star Wars Banner Ad"></a>
                        </div>
                        <div class="item">
                            <a href="collections.php"><img src="images/banner_avengers.jpg" alt="Marvel Avengers Banner Ad"></a>
                        </div>
                        <div class="item">
                            <a href="collections.php"><img src="images/banner_shipping.jpg" alt="Free Shipping Banner Ad"></a>
                        </div>
                        <div class="item">
                            <a href="collections.php"><img src="images/banner_marvel.jpg" alt="Marvel Banner Ad"></a>
                        </div>
                    </div>
                </div>
            </div>

            <nav id="main-nav" class="navbar">
                <div class="container-fluid">
                    <div class="navbar">
                        <ul class="nav nav-pills nav-justified">
                            <li><a href="index.php">Home</a></li>
                            <li><a href="about_us.php">About Us</a></li>
                            <li><a href="custom_made.php">Custom Made</a></li>
                            <li><a href="collections.php">Collections</a></li>
                            <li class="active"><a href="forum.php">Forum</a></li>
                            <li><a href="contact_us.php">Contact Us</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>

        <div class="container-fluid">
            <div class="row content">
                <div class="col-sm-12 col-md-12 col-lg-2 sidenav">
                    <div class="well">
                        <form action="#">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search" name="search">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="canvas">
                        <a href="custom_made.php">
                            <canvas class="canvas" id="canvas" width="220" height="470">Custom Bobblehead Ad</canvas>
                        </a>
                    </div>
                </div>

                <div id="custom_form" class="col-sm-12 col-md-12 col-lg-7 container">
                
<?php

include('database.class.php');
// Connect to database using OOP PHP
$db = Database::getInstance();
$mysqli = $db->getConnection();

//check to see if we’re showing the form or adding the post
if (!$_POST) {
	//showing the form; check for required item in query string
	if (!isset($_GET['post_id'])) {
		header("Location: forum.php");
		exit;
}

	//create safe values for use
	$safe_post_id = mysqli_real_escape_string($mysqli, $_GET['post_id']);

	//still have to verify post details
	$verify_sql = "SELECT fp.topic_id, fp.post_text, fp.post_owner FROM forum_posts
			AS fp LEFT JOIN forum_topics AS ft ON ft.topic_id =
			fp.topic_id WHERE fp.post_id = '".$safe_post_id."'";
	$verify_res = mysqli_query($mysqli, $verify_sql)
			or die(mysqli_error($mysqli));

	if (mysqli_num_rows($verify_res) < 1) {
		//this post or topic does not exist
		header("Location: forum.php");
		exit;
	} else {
		//get the post id and title
		while($post_info = mysqli_fetch_array($verify_res)) {
			$topic_id = $post_info['topic_id'];
            $post_text = stripslashes($post_info['post_text']);
            $post_owner = stripslashes($post_info['post_owner']);
		}
?>
		            <ul>
                        <li class="active"><a href="forum.php">Return to Forum Topics</a></li>
		            </ul>
                    <h4><strong>Post Your Reply to:</strong><br><?php echo $post_text; ?><br/> from <?php echo $post_owner; ?></h4>

	                <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <div class="form-group">
                            <label class="col-sm-2 col-md-2 control-label" for="post_owner">Your Email Address:</label><br/>
		                    <input type="email" id="post_owner" name="post_owner" size="40" maxlength="150" autofocus required>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-md-2 control-label" for="post_text">Post Text:</label><br/>
	                        <textarea id="post_text" name="post_text" rows="8" cols="40" required></textarea>
                        </div>
                            <input type="hidden" name="topic_id" value="<?php echo $topic_id; ?>">
		                <button class="btn btn-primary btn-lg" type="submit" name="submit" value="submit" onsubmit="forum.php">Add Post</button>
	                </form>
                    
<?php
    }
	//free result
	mysqli_free_result($verify_res);

    

} else if ($_POST) {
	//check for required items from form
	if ((!$_POST['topic_id']) || (!$_POST['post_text']) ||
	(!$_POST['post_owner'])) {
		header("Location: forum.php");
		exit;
	}

	//create safe values for use
	$safe_topic_id = mysqli_real_escape_string($mysqli, $_POST['topic_id']);
	$safe_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);
	$safe_post_owner = mysqli_real_escape_string($mysqli, $_POST['post_owner']);

	//add the post
	$add_post_sql = "INSERT INTO forum_posts (topic_id,post_text,
			post_create_time,post_owner) VALUES
			('".$safe_topic_id."', '".$safe_post_text."',
			now(),'".$safe_post_owner."')";
	$add_post_res = mysqli_query($mysqli, $add_post_sql)
			or die(mysqli_error($mysqli));

	//redirect user to topic
	//header("Location: showtopic.php?topic_id=".$_POST['topic_id']);

}
?>

                </div>

                <div class="col-sm-12 col-md-12 col-lg-3 sidenav">
                    <div class="well">
                        <img class="img-responsive" src="images/bobbleshop_news.jpg" alt="Bobbleshop News Banner" height="100" width="315">

                        <div class="panel-group" id="accordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
                                Coming Soon: Pop! Games - Destiny Pop!s</a>
                                    </h4>
                                </div>
                                <div id="collapse1" class="panel-collapse collapse in">
                                    <div class="panel-body">
                                        <p><small>Friday 14<sup>th</sup> April, 2017.</small></p>
                                        <p>The hit video game Destiny is joining the Bobbleshop family!</p>
                                        <p>From the upcoming video game Destiny 2, releasing September 8th, 2017.</p>
                                        <p>You can now add your favorite Guardians Cayde-6, Ikora and Zavala to your Pop! vinyl
                                            collection.
                                        </p>
                                        <p>Collect them all this Summer!</p>
                                        <img class="img-responsive" src="images/news_destiny.jpg" alt="Destiny Bobblehead Image" height="143" width="200">
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse2">
                                Coming Soon: Pop! Keychains!</a>
                                    </h4>
                                </div>
                                <div id="collapse2" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p><small>Monday 10<sup>th</sup> April, 2017.</small></p>
                                        <p>Now you can take your favorite Overwatch heroes with you on the go with these Reaper
                                            and Tracer Pop! Keychains.</p>
                                        <p>Snap them up and slide them on to your key ring this Summer!</p>
                                        <img class="img-responsive" src="images/news_keychain.jpg" alt="Overwatch Keychain Image" height="143" width="150">
                                    </div>
                                </div>
                            </div>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h4 class="panel-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse3">
                                Pop! Anime: My Hero Academia</a>
                                    </h4>
                                </div>
                                <div id="collapse3" class="panel-collapse collapse">
                                    <div class="panel-body">
                                        <p><small>Thursday 6<sup>th</sup> April, 2017.</small></p>
                                        <p>Living in a world where quirks are the norm. Deku is often bullied for not having
                                            a quirk of his own!</p>
                                        <p>That’s okay, because Deku is now receiving the Pop! vinyl treatment!</p>
                                        <p>The series would not be complete without Deku’s childhood bully, Katsuki! Tenya and
                                            Ochaco join the series as well!</p>
                                        <p>In addition, the extremely tall and overly-muscular All Might arrives as a super-sized
                                            6-inch Pop! vinyl!</p>
                                        <p>Collect them this Summer!</p>
                                        <img class="img-responsive" src="images/news_anime.jpg" alt="Deku Bobblehead Image" height="143" width="200">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <footer class="container-fluid text-center">
            <div class="row content">

                <div class="col-sm-4">
                    <h4>Connect with us:</h4>
                    <div class="social">
                        <img class="img-responsive" src="images/social_media_grey.jpg" alt="Social Media Icons" height="60" width="230">
                    </div>
                    <div class="logo">
                        <a href="index.php"><img class="img-responsive" src="images/bobbleshop_logo_grey.jpg" alt="Bobbleshop Logo" height="132" width="350"></a>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="privacy">
                        <h4>Privacy Notice</h4>

                        <p>We take precautions to protect your information. When you submit sensitive information via our website,
                            your information is protected both online and offline.</p>

                        <p>Wherever we collect sensitive information (such as credit card data), that information is encrypted
                            and transmitted to us in a secure way.</p>

                        <p>If you feel that we are not abiding by this privacy policy, you should contact us immediately via
                            telephone at 1800-000-000 or via email contact@bobbleshop.com.</p>

                    </div>
                </div>

                <div class="col-sm-4">
                    <nav id="footerNav" class="navbar">
                        <div class="navbar">
                            <ul class="nav">
                                <li><a href="index.php">Home</a></li>
                                <li><a href="about_us.php">About Us</a></li>
                                <li class="active"><a href="custom_made.php">Custom Made</a></li>
                                <li><a href="collections.php">Collections</a></li>
                                <li class="active"><a href="forum.php">Forum</a></li>
                                <li><a href="contact_us.php">Contact Us</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
        </footer>

        <div class="footer-bottom">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="copyright">
                            <p>&copy; Copyright 2017, All rights reserved.</p>
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="design">
                            <a target="_blank" href="#">Web Design & Development by TinyDalek</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
      
        <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>