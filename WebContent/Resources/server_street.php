<?php
include('server_db.php');
//initialize variables
$name = "";
$age = "";
$district = "";
$post = "";
$datetime = "";
$id = 0;
$edit_state = false;


// if save button is cliked
if(isset($_POST['save'])) {
	$name = $db -> real_escape_string ($_POST['name']);
	$age = $db -> real_escape_string ($_POST['age']);
	$district = $db -> real_escape_string ($_POST['district']);
	$post = $db -> real_escape_string ($_POST['post']);

	//이미지 파일 업로드
	$snapimg = $db -> real_escape_string('img/snapimg/'.$_FILES['snapimg']['name']);
	$file_type = $_FILES['snapimg']['type'];
	$file_size = $_FILES['snapimg']['size'];
	$file_tmp_name = $_FILES['snapimg']['tmp_name'];
	move_uploaded_file($file_tmp_name, $snapimg);

	$query = "INSERT INTO snap (name, age, district, post, created, snapimg)
			VALUES ('$name','$age','$district','$post',NOW(),'$snapimg')";
	mysqli_query($db, $query);

	echo
	"<script>
			var con_test_1 = alert('업로드에 성공하였습니다.');
					location.href='mypage_admin_street.php?page=1';
			</script>";
}

//update records
if(isset($_POST['update'])){
	$id = $db -> real_escape_string($_POST['id']); // 현재 화면의 아이디
	$name = $db -> real_escape_string($_POST['name']); //변경할이름
	$age = $db -> real_escape_string($_POST['age']); // 변경할나이
	$district = $db -> real_escape_string($_POST['district']); // 변경할지역명
	$post = $db -> real_escape_string($_POST['post']); //변경할 포스트
	$snapimg = $db -> real_escape_string($_POST['snapimg_m']); //변경한 스냅이미지
	$changeimg = $db -> real_escape_string('img/snapimg/'.$_FILES['snapimg_edit']['name']);
	$currentPage = $db -> real_escape_string($_POST['page']); //현재페이지
	if($_FILES['snapimg_edit']['name']==null){
		mysqli_query($db,"UPDATE snap SET name='$name',age='$age'
				,district='$district',post='$post',snapimg='$snapimg' WHERE id=$id");
		echo
		"<script>
			var con_test_1 = alert('수정에 성공했습니다.');
					location.href='mypage_admin_street.php?page=$currentPage';
			</script>";
	} else {

			$file_tmp_name = $_FILES['snapimg_edit']['tmp_name'];
			move_uploaded_file($file_tmp_name, $changeimg);
			mysqli_query($db,"UPDATE snap SET name='$name',age='$age'
					,district='$district',post='$post',snapimg='$changeimg' WHERE id=$id");
			echo
			"<script>
		 		var con_test_1 = alert('수정에 성공했습니다.');
				location.href='mypage_admin_street.php?page=$currentPage';
		 	</script>";
	}
}

//delete records
if(isset($_GET['del'])){
	$id = $_GET['del'];
 mysqli_query($db, "DELETE FROM snap WHERE id=$id");
	echo
	"<script>
			var con_test_1 = alert('삭제하였습니다.');
			location.href='mypage_admin_street.php';

			</script>";
}


//retrieve records
// DESC역순 정렬  ASC 순차정렬
$results = mysqli_query($db, "SELECT * FROM snap ORDER BY created DESC");
// SNAP 테이블에서 CREATED = DATETIME 을 역순으로 정렬한

?>
