<?php
session_start();

if (isset($_POST['sel_item_id'])) {
	include('database.class.php');
    // Connect to database using OOP PHP
    $db = Database::getInstance();
    $mysqli = $db->getConnection();

	//create safe values for use
	$safe_sel_item_id = mysqli_real_escape_string($mysqli,
		$_POST['sel_item_id']);
	$safe_sel_item_qty = mysqli_real_escape_string($mysqli,
		$_POST['sel_item_qty']);

	//validate item and get title and price
	$get_iteminfo_sql = "SELECT item_title FROM store_items WHERE
				id = '".$safe_sel_item_id."'";
	$get_iteminfo_res = mysqli_query($mysqli, $get_iteminfo_sql)
				or die(mysqli_error($mysqli));

	if (mysqli_num_rows($get_iteminfo_res) < 1) {

		//free result
		mysqli_free_result($get_iteminfo_res);

		//close connection to MySQL
		mysqli_close($mysqli);

		//invalid id, send away
		header("Location: see_store.php");
		exit;
	} else {
		//get info
		while ($item_info = mysqli_fetch_array($get_iteminfo_res)) {
			$item_title = stripslashes($item_info['item_title']);
		}

		//free result
		mysqli_free_result($get_iteminfo_res);

		//add info to cart table
		$addtocart_sql = "INSERT INTO store_shoppertrack
					(session_id, sel_item_id, sel_item_qty, date_added)
					VALUES ('".$_COOKIE['PHPSESSID']."',
					'".$safe_sel_item_id."',
					'".$safe_sel_item_qty."', now())";
		$addtocart_res = mysqli_query($mysqli, $addtocart_sql)
					or die(mysqli_error($mysqli));


		//close connection to MySQL
		mysqli_close($mysqli);

		//redirect to showcart page
		header("Location: show_cart.php");
		exit;
	}

} else {
	//send them somewhere else
	header("Location: see_store.php");
	exit;
}
?>