<?php
session_start();

include('database.class.php');

if (isset($_GET['id'])) {
    // Connect to database using OOP PHP
    $db = Database::getInstance();
    $mysqli = $db->getConnection();

	//create safe values for use
	$safe_id = mysqli_real_escape_string($mysqli, $_GET['id']);

	$delete_item_sql = "DELETE FROM store_shoppertrack WHERE
				id = '".$safe_id."' and session_id =
				'".$_COOKIE['PHPSESSID']."'";
	$delete_item_res = mysqli_query($mysqli, $delete_item_sql)
				or die(mysqli_error($mysqli));

	//close connection to Database
	

	//redirect to showcart page
	header("Location: show_cart.php");
	exit;
} else {
	//send them somewhere else
	header("Location: sees_store.php");
	exit;
}
?>