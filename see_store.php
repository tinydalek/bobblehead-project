<!DOCTYPE html>
<html>
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
<!-- Scripts for Custom Bobblehead Canvas Ad -->
<script src="http://code.createjs.com/easeljs-0.7.1.min.js"></script>
<script src="javascript/custom_canvas.js"></script>
</head>

<?php

include('database.class.php');
// Connect to database using OOP PHP
$db = Database::getInstance();
$mysqli = $db->getConnection();

//show categories first
$get_cats_sql = "SELECT id, cat_title FROM store_categories";
$get_cats_res = mysqli_query($mysqli, $get_cats_sql) or die(mysqli_error($mysqli));

$display_block = "";


    while ($cats = mysqli_fetch_array($get_cats_res)) {
		$cat_id = $cats['id'];
		$cat_title = strtoupper(stripslashes($cats['cat_title']));

		$display_block .= "<p><strong><a href=\"".$_SERVER['PHP_SELF']."?cat_id=".$cat_id."\">".$cat_title."</a></strong></p>";

		if (isset($_GET['cat_id']) && ($_GET['cat_id'] == $cat_id)) {
			//create safe value for use
			$safe_cat_id = mysqli_real_escape_string($mysqli, $_GET['cat_id']);

				//get items
				$get_items_sql = "SELECT id, item_title, item_price, item_image, item_inventory FROM store_items WHERE cat_id = '".$safe_cat_id."' ORDER BY id";
				$get_items_res = mysqli_query($mysqli, $get_items_sql) or die(mysqli_error($mysqli));


					while ($items = mysqli_fetch_array($get_items_res)) {
						$item_id = $items['id'];
						$item_title = stripslashes($items['item_title']);
                        $item_price = $items['item_price'];
                        $item_image = $items['item_image'];
                        $item_inventory = $items['item_inventory'];

                        $display_block .= <<<END_OF_TEXT
                        <strong><a href="see_store.php?cat_id=1">
                        <div class="carousel slide media-carousel" data-interval="false" id="$cat_id">
                        <div class="carousel-inner">
                            <div class="item active">
                                <div class="row">
                                    <div class="col-md-3">
                                        <a class="thumbnail" href="show_item.php?id=1"><img src="images/$item_image" alt="$item_title"/ height="143" width="200"></a>
                                        <div class="item_title"><strong><a href="show_item.php?id=1">
                                        $item_title \$$item_price</strong></a></div>
                                    </div>                                    
                                    <div class="col-md-3">
                                        <a class="thumbnail" href="show_item.php?id=2"><img src="images/$item_image" alt="$item_title"/ height="143" width="200"></a>
                                        <div class="item_title"><strong><a href="show_item.php?id=2">
                                        $item_title \$$item_price</strong></a></div>
                                    </div>
                                </div>
                            </div>
                            <!-- Create the previous and next buttons so the user can cycle through image gallery -->
                            <a data-slide="prev" href="see_store.php?cat_id=$cat_id"" class="carousel-control left">&lt;</a>
                            <a data-slide="next" href="see_store.php?cat_id=$cat_id"" class="carousel-control right">&gt;</a>
                        </div>
                        </div>
END_OF_TEXT;
					}


                
                
/*              <h5>Star Wars Collection</h5>
                <!-- data-interval="false" stops the image gallery from automatically rotating -->
                <div class="carousel slide media-carousel" data-interval="false" id="starwars">
                    <div class="carousel-inner">
                        <div class="item active">
                            <div class="row">
                                <div class="col-md-3">
                                    <a class="thumbnail" href="#"><img src="images/starwars_darth_vader.jpg" alt="Darth Bobblehead Image" height="143" width="200"></a>
                                    <div class="product-name">Darth Vader <button class="btn btn-primary" onclick="addtocart">BUY $19.99</button></div>
                                </div>
                                <div class="col-md-3">
                                    <a class="thumbnail" href="#"><img src="images/starwars_darth_maul.jpg" alt="Darth Maul Bobblehead Image" height="143" width="200"></a>
                                    <div class="product-name">Darth Maul <button class="btn btn-primary" onclick="addtocart">BUY $19.99</button></div>
                                </div>
                                <div class="col-md-3">
                                    <a class="thumbnail" href="#"><img src="images/starwars_yoda.jpg" alt="Yoda Bobblehead Image" height="143" width="200"></a>
                                    <div class="product-name">Yoda <button class="btn btn-primary" onclick="addtocart">BUY $19.99</button></div>
                                </div>
                                <div class="col-md-3">
                                    <a class="thumbnail" href="#"><img src="images/starwars_princess_leia.jpg" alt="Princess Leia Bobblehead Image" height="143" width="200"></a>
                                    <div class="product-name">Princess Leia <button class="btn btn-primary" onclick="addtocart">BUY $19.99</button></div>
                                </div>
                            </div>
                        </div>
*/
				//free results
				mysqli_free_result($get_items_res);
			}
		}

	
//free results
mysqli_free_result($get_cats_res);

//close connection to Database?


?>


<body>
	<div>
		<ul>
			<li><a href="show_cart.php">View Shopping Cart</a></li>
		</ul>
	</div>

	    <?php echo $display_block; ?>

    <script src="bootstrap/js/bootstrap.min.js"></script>
</body>
</html>