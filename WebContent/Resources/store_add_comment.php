<?php
include('server_db.php');


$comment_name = $db -> real_escape_string($_POST['name']);
$comment_email = $db -> real_escape_string($_POST['email']);
$comment_comment = $db -> real_escape_string($_POST['comment']);
$typeID = $db -> real_escape_string($_POST['typeID']);
$item = $db -> real_escape_string($_POST['item']);
$id = $db -> real_escape_string($_POST['id']);
$type = $db -> real_escape_string($_POST['type']);


	$query = "INSERT INTO comment
			(comment_sender_email, comment, comment_sender_name, type_id, item_name, id, type, date)
			VALUES ('$comment_email','$comment_comment', '$comment_name','$typeID','$item', '$id', '$type',NOW())";
	mysqli_query($db, $query);

?>
