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
    <!-- Scripts for google map -->
    <script src="javascript/map.js"></script>
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBVZ6Lawi20pQe-RSiVg08kZmJg0XoVuvU&callback=myMap" type="text/javascript"></script>

</head>

<body>

<?php

session_start();

?>
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
                            <li class="active"><a href="collections.php">Collections</a></li>
                            <li><a href="forum.php">Forum</a></li>
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

                <div id="checkout" class="col-sm-12 col-md-12 col-lg-7 container">
                    <div>
		                <ul>
			                <li><a href="show_cart.php">Return to Shopping Cart</a></li>
		                </ul>
                    </div>
                    <div class="col-sm-12 col-md-12 col-lg-10 table-resposive">

<?php

include('database.class.php');
// Connect to database using OOP PHP
$db = Database::getInstance();
$mysqli = $db->getConnection();

$display_block = "<h2>Review Your Order</h2>";

//check for cart items based on user session id
$get_cart_sql = "SELECT st.id, si.item_title, si.item_price,
			st.sel_item_qty FROM
			store_shoppertrack AS st LEFT JOIN store_items AS si ON
			si.id = st.sel_item_id WHERE session_id =
			'".$_COOKIE['PHPSESSID']."'";
$get_cart_res = mysqli_query($mysqli, $get_cart_sql)
			or die(mysqli_error($mysqli));

if (mysqli_num_rows($get_cart_res) < 1) {
	//print message
	$display_block .= "<p>You have no items in your cart.
	Please <a href=\"see_store.php\">continue to shop</a>!</p>";
} else {
	//get info and build cart display
    $display_block .= <<<END_OF_TEXT

	    <table class="table" id='cart'>
		    <tr>
			    <th><h4>Item</h4></th>
			    <th><h4>Price</h4></th>
                <th><h4>Qty</h4></th>
                <th></th>
			<th><h4>Total</h4></th>

		</tr>
END_OF_TEXT;

        $cart_total = 0;

	    while ($cart_info = mysqli_fetch_array($get_cart_res)) {
		    $id = $cart_info['id'];
		    $item_title = stripslashes($cart_info['item_title']);
		    $item_price = $cart_info['item_price'];
		    $item_qty = $cart_info['sel_item_qty'];
            $item_total = sprintf("%.02f", $item_price * $item_qty);
            $cart_total = sprintf("%.02f", $item_total + $cart_total);
		    $display_block .= <<<END_OF_TEXT
		    <tr>
			    <td>$item_title <br></td>
			    <td>\$ $item_price <br></td>
                <td>$item_qty <br></td>
                <td><a href="remove_from_cart.php?id=$id">remove</a><br></td>
			    <td>\$ $item_total</td>	
            </tr>
END_OF_TEXT;
        }
        $display_block .= <<<END_OF_TEXT
        <tr>
            <td colspan="4"><h4>Total Amount Due</h4></td>
            <td><h4>$ $cart_total</h4></td>
        </tr>
END_OF_TEXT;

        $display_block .= "</table><br>";
}
//free result
mysqli_free_result($get_cart_res);

echo $display_block;
?>
                    </div>
                </div>
                <div id="checkout" class="col-sm-12 col-md-12 col-lg-7 container">
                    <h2>Delivery Information</h2><br>
                    <form class="form-horizontal" id="checkoutForm" onsubmit="return validateForm()" method="POST" action="order_processed.php">
                        <div class="form-group">
                            <label class="col-sm-2 col-md-2 control-label" for="order_name">Full Name:</label>
                            <div class="col-sm-10 col-md-8">
                                <input class="form-control" type="text" id="order_name" name="order_name" maxlength="150" autofucus required>
                            </div>
                        </div>
                        <div class="form-group">
		                    <label class="col-sm-2 col-md-2 control-label" for="order_addess">Address:</label>
                            <div class="col-sm-10 col-md-8">
			                    <input class="form-control" type="text" id="order_address" name="order_address" maxlength="150" required>
                            </div>
                        </div>
                        <div class="form-group">
		                    <label class="col-sm-2 col-md-2 control-label" for="order_city">City:</label>
                            <div class="col-sm-10 col-md-8">
			                    <input class="form-control" type="text" id="order_city" name="order_city" maxlength="150" required>
                            </div>
                        </div>
                        <div class="form-group">
		                    <label class="col-sm-2 col-md-2 control-label" for="order_state">State:</label>
                            <div class="col-sm-4 col-md-3">
			                    <input class="form-control" type="text" id="order_state" name="order_state" maxlength="50" required>
                            </div>
                            <label class="col-sm-1 col-md-1 control-label" for="order_postcode">Postcode:</label>
                            <div class="col-sm-5 col-md-4">
		                        <input class="form-control" type="text" id="order_postcode" name="order_postcode" maxlength="50" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-md-2 control-label" for="order_country">Country:</label>
                            <div class="col-sm-10 col-md-8">
			                        <input class="form-control" type="text" id="order_country" name="order_country" maxlength="150" required>
                            </div>
                        </div>
                        <div class="form-group">
		                    <label class="col-sm-2 col-md-2 control-label" for="order_tel">Phone Number:</label>
                            <div class="col-sm-4 col-md-3">
			                    <input class="form-control" type="text" id="order_tel" name="order_tel" maxlength="50" required>
                            </div>
		                    <label class="col-sm-1 col-md-1 control-label" for="order_email">Email:</label>
                            <div class="col-sm-5 col-md-4">
		                        <input class="form-control" type="email" id="order_email" name="order_email" maxlength="150" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 col-md-2 control-label" for="order_comments">Comments:</label>
                            <div class="col-sm-10 col-md-8">
                                <textarea class="form-control" rows="3" id="order_comments" name="order_comments" 
                                placeholder="Provide any extra comments or delivery information here."></textarea>
                            </div>
                        </div>

                        <h2>Billing information</h2>
                        <?php echo $display_block = "<h3>Total Amount Due: $ $cart_total</h3><br>";?>
                        <div class="form-group">
                            <label class="col-sm2 col-md-2 control-label">Card Type:</label>
                            <div id="radio" class="radio col-sm-10 col-md-10">
                                <label id="visa" class="radio-inline"><input type="radio" name="card_type" value="visa" checked="checked">Visa</label>
                                <label id="mastercard" class="radio-inline"><input type="radio" name="card_type" value="mastercard">Mastercard</label>
                            </div>
                        </div>
                        <div class="form-group">
		                    <label class="col-sm-2 col-md-2 control-label" for="order_card_name">Credit Card:</label>
                            <div class="col-sm-5 col-md-4">
			                    <input class="form-control" type="text" id="order_first_name" name="order_first_name" maxlength="50" placeholder="First Name" required>
                            </div>
                            <div class="col-sm-5 col-md-4">
			                    <input class="form-control" type="text" id="order_last_name" name="order_last_name" maxlength="50" placeholder="Last Name" required>
                            </div>
                        </div>
                        <div class="form-group">
		                    <label class="col-sm-2 col-md-2 control-label" for="order_card_number"></label>
                            <div class="col-sm-5 col-md-4">
			                    <input class="form-control" type="text" id="order_card_number" name="order_card_number" maxlength="50" placeholder="Card Number" required>
                            </div>
                            <label class="col-sm-0 col-md-0 control-label" for="card_expiry_month"></label>
                            <div class="col-sm-2 col-md-2">
			                    <input class="form-control" type="text" id="card_expiry_month" name="car_expiry_month" maxlength="2" placeholder="MM" required>
                            </div>
                            <label class="col-sm-0 col-md-0 control-label" for="card_expiry_year"></label>
                            <div class="col-sm-2 col-md-2">
			                    <input class="form-control" type="text" id="card_expiry_year" name="card_expiry_year" maxlength="4" placeholder="YY" required><br>
                            </div>
                        </div>
                    	<button class="btn btn-primary btn-lg" id="submit" type="submit" name="submit" value="submit">Submit Order</button>
                        </form><br>
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
                                    <li><a href="custom_made.php">Custom Made</a></li>
                                    <li class="active"><a href="collections.php">Collections</a></li>
                                    <li><a href="forum.php">Forum</a></li>
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