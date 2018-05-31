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
    <link rel="stylesheet" type="text/css" href="css/collections.css">
    <script src="bootstrap/js/jquery-3.2.1.min.js"></script>
    <!--Script for AJAX show hint function-->
    <script src="javascript/AJAX_hint.js"></script>
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
                <div class="col-sm-12 col-md-2 sidenav">
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

                <div class="col-sm-11 col-md-9">

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

                    <div class="row">
                        <h5>Star Wars Collection</h5>
                        <!-- data-interval="false" stops the image gallery from automatically rotating -->
                        <div class="carousel slide media-carousel" data-interval="false" id="starwars">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="<show_item.php?id=1"><img src="images/starwars_darth_vader.jpg" alt="Darth Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=1">Darth Vader<button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=2"><img src="images/starwars_darth_maul.jpg" alt="Darth Maul Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=2">Darth Maul <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=3"><img src="images/starwars_yoda.jpg" alt="Yoda Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=3">Yoda <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=4"><img src="images/starwars_princess_leia.jpg" alt="Princess Leia Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=4">Princess Leia <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=5"><img src="images/starwars_luke_skywalker.jpg" alt="Luke Skywalker Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=5">Luke Skywalker <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=6"><img src="images/starwars_obi_wan.jpg" alt="Obi Wan Kenobi Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=6">Obi Wan Kenobi <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=7"><img src="images/starwars_C3PO.jpg" alt="C3PO Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=7">C3PO <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=8"><img src="images/starwars_R2D2.jpg" alt="R2D2 Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=8">R2D2 <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=9"><img src="images/starwars_chewbacca.jpg" alt="Chewbacca Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=9">Chewbacca <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=10"><img src="images/starwars_jabba.jpg" alt="Jabba the Hutt Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=10">Jabba the Hutt <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=11"><img src="images/starwars_biker_scout.jpg" alt="Biker Scout Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=11">Biker Scout <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=12"><img src="images/starwars_fighter_pilot.jpg" alt="TIE Fighter Pilot Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=12">TIE Fighter Pilot <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=13"><img src="images/starwars_finn.jpg" alt="Finn Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=13">Finn <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=14"><img src="images/starwars_rey.jpg" alt="Rey Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=14">Rey <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=15"><img src="images/starwars_unmasked_vader.jpg" alt="Unmasked Vader Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=15">Unmasked Vader <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=16"><img src="images/starwars_x-wing.jpg" alt="Luke Skywalker (X-Wing Pilot) Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=16">Luke Skywalker <button class="btn btn-primary" onclick="show_item">BUY $19.99</button><br>(X-Wing
                                                Pilot)</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Create the previous and next buttons so the user can cycle through image gallery -->
                            <a data-slide="prev" href="#starwars" class="carousel-control left">&lt;</a>
                            <a data-slide="next" href="#starwars" class="carousel-control right">&gt;</a>
                        </div>
                    </div>
                    <div class="row">
                        <h5>Marvel Universe Collection</h5>
                        <div class="carousel slide media-carousel" id="universe">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=17"><img src="images/marvel_universe_captain_america.jpg" alt="Captain America Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=17">Captain America<button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=18"><img src="images/marvel_universe_ghost_rider.jpg" alt="Ghost Rider Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=18">Ghost Rider <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=19"><img src="images/marvel_universe_deadpool.jpg" alt="Deadpool Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=19">Deadpool <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=20"><img src="images/marvel_universe_wolverine.jpg" alt="Wolverine Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=20">Wolverine <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=21"><img src="images/marvel_universe_dark_phoenix.jpg" alt="Dark Phoenix Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=21">Dark Phoenix <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=22"><img src="images/marvel_universe_spiderman.jpg" alt="Spiderman Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=22">Spiderman <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=23"><img src="images/marvel_universe_silver_surfer.jpg" alt="Silver Surfer Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=23">Silver Surfer <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=24"><img src="images/marvel_universe_thing.jpg" alt="The Thing Bobblead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=24">The Thing <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Create the previous and next buttons so the user can cycle through image gallery -->
                            <a data-slide="prev" href="#universe" class="carousel-control left">&lt;</a>
                            <a data-slide="next" href="#universe" class="carousel-control right">&gt;</a>
                        </div>
                    </div>
                    <div class="row">
                        <h5>Marvel Avengers Collection</h5>
                        <div class="carousel slide media-carousel" id="avengers">
                            <div class="carousel-inner">
                                <div class="item active">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=25"><img src="images/marvel_avengers_hawkeye.jpg" alt="Hawkeye Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=25">Hawkeye <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=26"><img src="images/marvel_avengers_hulk.jpg" alt="Hulk Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=26">Hulk <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=27"><img src="images/marvel_avengers_iron_man.jpg" alt="Iron Man Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=27">Iron Man <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=28"><img src="images/marvel_avengers_scarlet_witch.jpg" alt="Scarlet Witch Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=28">Scarlet Witch <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="item">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=29"><img src="images/marvel_avengers_captain_america.jpg" alt="Captain America Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=29">Captain America <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=30"><img src="images/marvel_avengers_iron_man_unmasked.jpg" alt="Iron Man (Unmasked) Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=30">Iron Man <button class="btn btn-primary" onclick="show_item">BUY $19.99</button><br>(Unmasked)</div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=31"><img src="images/marvel_avengers_black_widow.jpg" alt="Black Widow Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=31">Black Widow <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                        <div class="col-md-3">
                                            <a class="thumbnail" href="show_item.php?id=32"><img src="images/marvel_avengers_thor.jpg" alt="Thor Bobblehead Image" height="143" width="200"></a>
                                            <div class="product-name"><a href="show_item.php?id=32">Thor <button class="btn btn-primary" onclick="show_item">BUY $19.99</button></div></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Create the previous and next buttons so the user can cycle through image gallery -->
                            <a data-slide="prev" href="#avengers" class="carousel-control left">&lt;</a>
                            <a data-slide="next" href="#avengers" class="carousel-control right">&gt;</a>
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