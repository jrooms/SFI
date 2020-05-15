<?php
$conn = mysqli_connect(
		'localhost',
		'root',
		'111111',
		'registration');
$sql = "SELECT * FROM topic WHERE id = 2";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result);
echo '<h1>'.$row['title'].'</h1>';
echo $row['description'];
