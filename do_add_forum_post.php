<?php

include('database.class.php');
// Connect to database using OOP PHP
$db = Database::getInstance();
$mysqli = $db->getConnection();

//check for required fields from the form
if ((!$_POST['topic_id']) ||(!$_POST['post_owner']) || (!$_POST['post_text'])) {
header("Location: add_forum_post.php");
exit;
}

//create safe values for input into the database
$safe_topic_id = mysqli_real_escape_string($mysqli, $_POST['topic_id']);
$clean_post_owner = mysqli_real_escape_string($mysqli, $_POST['post_owner']);
$clean_post_title = mysqli_real_escape_string($mysqli, $_POST['post_title']);
$clean_post_text = mysqli_real_escape_string($mysqli, $_POST['post_text']);

//create and issue the query
$add_post_sql = "INSERT INTO forum_posts
(topic_id, post_title, post_text, post_create_time, post_owner)
VALUES ('".$safe_topic_id."', '".$clean_post_title."', '".$clean_post_text."',
now(), '".$clean_post_owner."')";

$add_post_res = mysqli_query($mysqli, $add_post_sql)
or die(mysqli_error($mysqli));

//redirect user to topic
header("Location: show_forum_topic.php?topic_id=".$_POST['topic_id']);
exit;

?>