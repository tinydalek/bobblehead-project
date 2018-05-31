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
    <!--Script for AJAX show hint function-->
    <script src="javascript/AJAX_hint.js"></script>
    <!-- Scripts for Custom Bobblehead Canvas Ad -->
    <script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
    <script src="javascript/custom_canvas.js"></script>
    <!-- Script for Javascript Task 6, Rich Tooltip
    <script src="javascript/tether.min.js"></script>
    <script src="javascript/tooltip.js"></script>
    <link rel="stylesheet" type="text/css" href="css/tooltip.css">-->

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
                            <li class="active"><a href="index.php">Home</a></li>
                            <li><a href="about_us.php">About Us</a></li>
                            <li><a href="custom_made.php">Custom Made</a></li>
                            <li><a href="collections.php">Collections</a></li>
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
                                <input type="text" onkeyup="showHint(this.value)" class="form-control" placeholder="Search" name="search">
                                <div class="input-group-btn">
                                    <button type="submit" class="btn btn-default"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                            <p><span id="txtHint"></span></p>
                        </form>
                    </div>
                    <div class="canvas">
                        <a href="custom_made.php">
                            <canvas class="canvas" id="canvas" width="220" height="470">Custom Bobblehead Ad</canvas>
                        </a>
                    </div>
                </div>

                <div class="col-sm-12 col-md-12 col-lg-7 table-resposive">

<?php

include('database.class.php');
// Connect to database using OOP PHP
$db = Database::getInstance();
$mysqli = $db->getConnection();

// Get categories
$get_cats_sql = "SELECT id, cat_title FROM store_categories ORDER BY id";
$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));

while ($cats = mysqli_fetch_array($get_cats_res)) {
    $cat_id = $cats['id'];
    $cat_title = strtoupper(stripslashes($cats['cat_title']));

    if (isset($_GET['cat_id']) && ($_GET['cat_id'] == $cat_id)) {
        // Create safe value for use
        $safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']);

            // Get items
            $get_items_sql = "SELECT id, item_title, item_price, item_image, item_inventory FROM store_items WHERE cat_id = '".$safe_cat_id."' ORDER BY id";
            $get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));

            while ($items = mysqli_fetch_array($get_items_res)) {
                $item_id = $items['id'];
                $item_title = stripslashes($items['item_title']);
                $item_price = $items['item_price'];
                $item_image = $items['item_image'];
                $item_inventory = $items['item_inventory'];
            }
            mysqli_free_result($get_items_res);
        }
    }

?>

                    <table class="table">
                        <colgroup>
                            <col span="4">
                        </colgroup>
                        <thead>
                            <tr>
                                <th scope="col" colspan="4">Featured Products</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="product-image"><a href="show_item.php?id=1" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 01: STAR WARS, DARTH VADER - The Ultimate Villain!"><img src="images/starwars_darth_vader.jpg" alt="Darth Vader Bobblehead"></a></td>
                                <td class="product-image"><a href="show_item.php?id=2" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 09: STAR WARS, DARTH MAUL - Sith Lord and Master of the Double-bladed Lightsaber"><img src="images/starwars_darth_maul.jpg" alt="Darth Maul Bobblehead"></a></td>
                                <td class="product-image"><a href="show_item.php?id=3" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 02: STAR WARS, YODA - Legendary Jedi Master"><img src="images/starwars_yoda.jpg" alt="Yoda Bobblehead"></a></td>
                                <td class="product-image"><a href="show_item.php?id=4" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 04: STAR WARS, PRINCESS LEIA - The Ultimate Heroine!"><img src="images/starwars_princess_leia.jpg" alt="Princess Leia Bobblehead"></a></td>
                            </tr>
                            <tr>
                                <td class="product-name">Darth Vader</td>
                                <td class="product-name">Darth Maul</td>
                                <td class="product-name">Yoda</td>
                                <td class="product-name">Princess Leia</td>
                            </tr>
                            <tr>
                                <td class="product-price"><a href="show_item.php?id=1"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=2"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=3"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=4"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                            </tr>
                            <tr>
                                <td class="item-image"><a href="show_item.php?id=17" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 06: MARVEL UNIVERSE, CAPTAIN AMERICA - America's One-man Army, fighting for the Red, White and Blue"><img src="images/marvel_universe_captain_america.jpg" alt="Captain America Bobblehead" ></a></td>
                                <td class="item-image"><a href="show_item.php?id=18" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 18; MARVEL UNIVERSE, GHOST RIDER - Stunt Riding Antihero"><img src="images/marvel_universe_ghost_rider.jpg" alt="Ghost Rider Bobblehead"></a></td>
                                <td class="item-image"><a href="show_item.php?id=19" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 20: MARVEL UNIVERSE, DEADPOOL - Superhuman Healer"><img src="images/marvel_universe_deadpool.jpg" alt="Deadpool Bobblehead"></a></td>
                                <td class="item-image"><a href="show_item.php?id=20" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 05: MARVEL UNIVERSE, WOLVERINE - Carnivorous Mutant"><img src="images/marvel_universe_wolverine.jpg" alt="Wolverine Bobblehead"></a></td>
                            </tr>
                            <tr>
                                <td class="product-name">Captain America</td>
                                <td class="product-name">Ghost Rider</td>
                                <td class="product-name">Deadpool</td>
                                <td class="product-name">Wolverine</td>
                            </tr>
                            <tr>
                                <td class="product-price"><a href="show_item.php?id=17"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=18"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=19"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=20"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                            </tr>
                            <tr>
                                <td class="item-image"><a href="show_item.php?id=25" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 70: MARVEL AVENGERS, HAWKEYE - Supremely Talented Archer!"><img src="images/marvel_avengers_hawkeye.jpg" alt="Hawkeye Bobblehead"></a></td>
                                <td class="item-image"><a href="show_item.php?id=26" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 68: MARVEL AVENGERS, HULK - Green-skinned, Mascular Humanoid"><img src="images/marvel_avengers_hulk.jpg" alt="Hulk Bobblehead"></a></td>
                                <td class="item-image"><a href="show_item.php?id=27" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 66: MARVEL AVENGERS, IRON MAN - Ingenious Engineer with a Powered Suit of Armor"><img src="images/marvel_avengers_iron_man.jpg" alt="Iron Man Bobblehead"></a></td>
                                <td class="item-image"><a href="show_item.php?id=28" class="rich" data-toggle="tooltip" data-placement="bottom" data-html="true" data-title="VINYL POP 95: MARVEL AVENGERS, SCARLET WITCH - Reality Altering Mutant"><img src="images/marvel_avengers_scarlet_witch.jpg" alt="Scarlet Witch Bobblehead"></a></td>
                            </tr>
                            <tr>
                                <td class="product-name">Hawkeye</td>
                                <td class="product-name">Hulk</td>
                                <td class="product-name">Iron Man</td>
                                <td class="product-name">Scarlet Witch</td>
                            </tr>
                            <tr>
                                <td class="product-price"><a href="show_item.php?id=25"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=26"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=27"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                                <td class="product-price"><a href="show_item.php?id=28"><button class="btn btn-primary" onclick="show_item">BUY $19.99</button></a></td>
                            </tr>
                        </tbody>
                    </table>
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
                                <li class="active"><a href="index.php">Home</a></li>
                                <li><a href="about_us.php">About Us</a></li>
                                <li><a href="custom_made.php">Custom Made</a></li>
                                <li><a href="collections.php">Collections</a></li>
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
                            <p>Web Design & Development by TinyDalek</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <script src="javascript/like_system.js"></script>
        <script src="bootstrap/js/bootstrap.min.js"></script>

</body>

</html>