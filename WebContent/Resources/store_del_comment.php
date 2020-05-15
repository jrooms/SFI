<?php
include('server_admin.php');
include('server_db.php');
session_start();
// 현재 로그인한 회원이 있으면
if(isset($_SESSION['email'])){
	$guestUser = false;
	if($_SESSION['email']==$admin){
		$adminUser = true;
	}
}

//delete records
if(isset($_GET['comment_del'])){
	$type = $db -> real_escape_string ($_POST['type']);
	$page = $db -> real_escape_string ($_POST['page']);
	$id = $db -> real_escape_string ($_POST['id']);
	$wear = "wear";
	$shoes ="shoes";
	$acc = "acc";


	$comment_id = $_GET['comment_del'];
	mysqli_query($db, "DELETE FROM comment WHERE comment_id = $comment_id");

	if($type==$wear){
		echo
		"<script>
		var con_test_1 = alert('문의사항을 삭제합니다.');
		location.href='store.php?wear=1&item_w=$id&page=$page';
		</script>";
	}
	if($type==$shoes){
		echo
		"<script>
		var con_test_1 = alert('문의사항을 삭제합니다.');
		location.href='store.php?shoes=1&item_s=$id&page=$page';
		</script>";
	}
	if($type==$acc){
		echo
		"<script>
		var con_test_1 = alert('문의사항을 삭제합니다.');
		location.href='store.php?acc=1&item_a=$id&page=$page';
		</script>";
	}
}


?>
