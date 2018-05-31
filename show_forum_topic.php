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

                <div class="col-sm-12 col-md-12 col-lg-7 table-resposive">
                
		            <ul>
                        <li class="active"><a href="forum.php">Return to Forum Topics</a></li>
		            </ul>

<?php
include('database.class.php');
// Connect to database using OOP PHP
$db = Database::getInstance();
$mysqli = $db->getConnection();

//check for required info from the query string
if (!isset($_GET['topic_id'])) {
	header("Location: forum.php");
	exit;
}

//create safe values for use
$safe_topic_id = mysqli_real_escape_string($mysqli, $_GET['topic_id']);

//verify the topic exists
$verify_topic_sql = "SELECT topic_title FROM forum_topics
		WHERE topic_id = '".$safe_topic_id."'";
$verify_topic_res = mysqli_query($mysqli, $verify_topic_sql)
		or die(mysqli_error($mysqli));
if (mysqli_num_rows($verify_topic_res) < 1) {
	//this topic does not exist
	$display_block = "<p><em>You have selected an invalid topic.<br/>
	Please <a href=\"forum.php\">try again</a>.</em></p>";
} else {
	//get the topic title
	while ($topic_info = mysqli_fetch_array($verify_topic_res)) {
		$topic_title = stripslashes($topic_info['topic_title']);
	}

	//gather the posts
	$get_posts_sql = "SELECT post_id, post_title, post_text, 
                DATE_FORMAT(post_create_time, '%b %e %Y<br/>%r') AS fmt_post_create_time, post_owner
				FROM forum_posts WHERE topic_id = '".$safe_topic_id."'
				ORDER BY post_create_time ASC";
	$get_posts_res = mysqli_query($mysqli, $get_posts_sql)
				or die(mysqli_error($mysqli));

	//create the display string
	$display_block = <<<END_OF_TEXT

	<table class="table">
	<tr>
    <th colspan="2">Showing posts from $topic_title:</th>
	</tr>
END_OF_TEXT;

	while ($posts_info = mysqli_fetch_array($get_posts_res)) {
        $post_id = $posts_info['post_id'];
        $post_title = stripslashes($posts_info['post_title']);
		$post_text = nl2br(stripslashes($posts_info['post_text']));
		$post_create_time = $posts_info['fmt_post_create_time'];
		$post_owner = stripslashes($posts_info['post_owner']);

		//add to display
		$display_block .= <<<END_OF_TEXT
		<tr>
        <td><strong>$post_title</strong><br/><br/>
        Created by:<br/>$post_owner<br/>$post_create_time</td>
		<td>$post_text<br/><br/>
		<a href="reply_to_post.php?post_id=$post_id">
		<strong>REPLY TO POST</strong></a></td>
		</tr>
END_OF_TEXT;
	}

	//free results
	mysqli_free_result($get_posts_res);
	mysqli_free_result($verify_topic_res);

	//close connection to database?
	

	//close up the table
	$display_block .= "</table>";
}

echo $display_block;
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