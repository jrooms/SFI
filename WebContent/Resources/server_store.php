<?php
include('server_db.php');
// if save button is cliked
if(isset($_POST['save'])){
	$type = $db -> real_escape_string ($_POST['type']);
	$wear = "wear";
	$shoes ="shoes";
	$acc = "acc";
	//셀렉트에서 의류를 선택한 경우
	if($type==$wear){

		$name = $db -> real_escape_string ($_POST['name']);
		$price = $db -> real_escape_string ($_POST['price']);
		/* 		$size = mysql_real_escape_string ($_POST['size']); */
		$post = $db -> real_escape_string ($_POST['post']);
		$currentPage = $db -> real_escape_string($_GET['page']); //현재페이지
		//이미지 파일 업로드
		$itemimg = $db -> real_escape_string('img/store/wear/'.$_FILES['itemimg']['name']);
		$file_type = $_FILES['itemimg']['type'];
		$file_size = $_FILES['itemimg']['size'];
		$file_tmp_name = $_FILES['itemimg']['tmp_name'];
		move_uploaded_file($file_tmp_name, $itemimg);

		$query = "INSERT INTO wear (type, name, price, post, itemimg, datetime)
		VALUES ('$type','$name','$price','$post','$itemimg',NOW())";
		mysqli_query($db, $query);

		echo
		"<script>
			var con_test_1 = alert('업로드에 성공하였습니다.');
					location.href='mypage_admin_store.php?wear_edit=1&page=1';
			</script>";

	}else if($type==$shoes){ // 셀렉트에서 신발을 선택한경우

		$name = $db -> real_escape_string ($_POST['name']);
		$price = $db -> real_escape_string ($_POST['price']);
		/* 		$size = mysql_real_escape_string ($_POST['size']); */
		$post = $db -> real_escape_string ($_POST['post']);
		$currentPage = $db -> real_escape_string($_GET['page']); //현재페이지
		//이미지 파일 업로드
		$itemimg = $db -> real_escape_string('img/store/shoes/'.$_FILES['itemimg']['name']);
		$file_type = $_FILES['itemimg']['type'];
		$file_size = $_FILES['itemimg']['size'];
		$file_tmp_name = $_FILES['itemimg']['tmp_name'];
		move_uploaded_file($file_tmp_name, $itemimg);

		$query = "INSERT INTO shoes (type, name, price, post, itemimg, datetime)
		VALUES ('$type','$name','$price','$post','$itemimg',NOW())";
		mysqli_query($db, $query);

		echo
		"<script>
			var con_test_1 = alert('업로드에 성공하였습니다.');
					location.href='mypage_admin_store.php?shoes_edit=1&page=1';
			</script>";


	}else if($type==$acc){
		$name = $db -> real_escape_string ($_POST['name']);
		$price = $db -> real_escape_string ($_POST['price']);
		$post = $db -> real_escape_string ($_POST['post']);
		$currentPage = $db -> real_escape_string($_GET['page']); //현재페이지
		//이미지 파일 업로드
		$itemimg = $db -> real_escape_string('img/store/acc/'.$_FILES['itemimg']['name']);
		$file_type = $_FILES['itemimg']['type'];
		$file_size = $_FILES['itemimg']['size'];
		$file_tmp_name = $_FILES['itemimg']['tmp_name'];
		move_uploaded_file($file_tmp_name, $itemimg);

		$query = "INSERT INTO acc (type, name, price, post, itemimg, datetime)
		VALUES ('$type','$name','$price','$post','$itemimg',NOW())";
		mysqli_query($db, $query);

		echo
		"<script>
			var con_test_1 = alert('업로드에 성공하였습니다.');
					location.href='mypage_admin_store.php?acc_edit=1&page=1';
			</script>";
	}
}


// 업데이트 .. 수정
if(isset($_POST['update'])){
	$type = $db -> real_escape_string ($_POST['type']);
	$wear = "wear";
	$shoes ="shoes";
	$acc = "acc";
	if($type==$wear){
		$id = $db -> real_escape_string($_POST['id']); // 현재 화면의 아이디
		$name = $db -> real_escape_string($_POST['name']); // 변경할이름
		$price = $db -> real_escape_string($_POST['price']); //변경할 가격
		/* 		$size = mysql_real_escape_string ($_POST['size']); */
		$post = $db -> real_escape_string($_POST['post']); //변경할 포스트
		$currentPage = $db -> real_escape_string($_GET['page']); //현재페이지
		//이미지 파일 업로드
		$itemimg=  $db -> real_escape_string($_POST['itemimg_m']); //변경할 포스트
		$changeimg = $db -> real_escape_string('img/store/wear/'.$_FILES['itemimg_edit']['name']);

		if($_FILES['itemimg_edit']['name']==null) {
			mysqli_query($db, "UPDATE wear SET type='$type', name='$name', price='$price'
					,post='$post',itemimg='$itemimg' WHERE id=$id");

			echo
		"<script>
			var con_test_1 = alert('수정에 성공하였습니다.');
					location.href='mypage_admin_store.php?wear_edit=1&page=1';
			</script>";

		} else {
			$file_tmp_name = $_FILES['itemimg_edit']['tmp_name'];
			move_uploaded_file($file_tmp_name, $changeimg);
			mysqli_query($db, "UPDATE wear SET type='$type', name='$name', price='$price'
					,post='$post',itemimg='$changeimg' WHERE id=$id");
			echo
			"<script>
			var con_test_1 = alert('수정에 성공하였습니다.');
					location.href='mypage_admin_store.php?wear_edit=1&page=1';
			</script>";
		}

	}else if($type==$shoes){

		$id = $db -> real_escape_string($_POST['id']); // 현재 화면의 아이디
		$name = $db -> real_escape_string($_POST['name']); // 변경할이름
		$price = $db -> real_escape_string($_POST['price']); //변경할 가격
		/* 		$size = mysql_real_escape_string ($_POST['size']); */
		$post = $db -> real_escape_string($_POST['post']); //변경할 포스트
		$currentPage = $db -> real_escape_string($_GET['page']); //현재페이지
		//이미지 파일 업로드
		$itemimg= $db -> real_escape_string($_POST['itemimg_m']); //변경할 포스트
		$changeimg = $db -> real_escape_string('img/store/shoes/'.$_FILES['itemimg_edit']['name']);

		if($_FILES['itemimg_edit']['name']==null) {
			mysqli_query($db, "UPDATE shoes SET type='$type', name='$name', price='$price'
					,post='$post',itemimg='$itemimg' WHERE id=$id");

			echo
			"<script>
			var con_test_1 = alert('수정에 성공하였습니다.');
					location.href='mypage_admin_store.php?shoes_edit=1&page=1';
			</script>";
		} else {
			$file_tmp_name = $_FILES['itemimg_edit']['tmp_name'];
			move_uploaded_file($file_tmp_name, $changeimg);
			mysqli_query($db, "UPDATE shoes SET type='$type', name='$name', price='$price'
					,post='$post',itemimg='$changeimg' WHERE id=$id");
			echo
			"<script>
			var con_test_1 = alert('업로드에 성공하였습니다.');
					location.href='mypage_admin_store.php?shoes_edit=1&page=1';
			</script>";
		}

	}else if($type==$acc){

		$id = $db -> real_escape_string($_POST['id']); // 현재 화면의 아이디
		$name = $db -> real_escape_string($_POST['name']); // 변경할이름
		$price = $db -> real_escape_string($_POST['price']); //변경할 가격
		/* 		$size = mysql_real_escape_string ($_POST['size']); */
		$post = $db -> real_escape_string($_POST['post']); //변경할 포스트
		$currentPage = $db -> real_escape_string($_GET['page']); //현재페이지
		//이미지 파일 업로드
		$itemimg=  $db -> real_escape_string($_POST['itemimg_m']); //변경할 포스트
		$changeimg = $db -> real_escape_string('img/store/acc/'.$_FILES['itemimg_edit']['name']);

		if($_FILES['itemimg_edit']['name']==null) {
			mysqli_query($db, "UPDATE acc SET type='$type', name='$name', price='$price'
					,post='$post',itemimg='$itemimg' WHERE id=$id");

			echo
			"<script>
			var con_test_1 = alert('수정에 성공하였습니다.');
					location.href='mypage_admin_store.php?acc_edit=1&page=1';
			</script>";
		} else {
			$file_tmp_name = $_FILES['itemimg_edit']['tmp_name'];
			move_uploaded_file($file_tmp_name, $changeimg);
			mysqli_query($db, "UPDATE acc SET type='$type', name='$name', price='$price'
					,post='$post',itemimg='$changeimg' WHERE id=$id");
			echo
			"<script>
			var con_test_1 = alert('수정에 성공하였습니다.');
					location.href='mypage_admin_store.php?acc_edit=1&page=1';
			</script>";
		}


	}
}

//delete records
if(isset($_GET['del_w'])){
		$id = $_GET['del_w'];
		mysqli_query($db, "DELETE FROM wear WHERE id=$id");
		echo
		"<script>
			var con_test_1 = alert('삭제하였습니다.');
					location.href='mypage_admin_store.php?wear_edit=1&page=1';
			</script>";
}

//delete records
if(isset($_GET['del_s'])){
	$id = $_GET['del_s'];
	mysqli_query($db, "DELETE FROM shoes WHERE id=$id");
	echo
	"<script>
			var con_test_1 = alert('삭제하였습니다.');
					location.href='mypage_admin_store.php?shoes_edit=1&page=1';
			</script>";
}

//delete records
if(isset($_GET['del_a'])){
	$id = $_GET['del_a'];
	mysqli_query($db, "DELETE FROM acc WHERE id=$id");
	echo
	"<script>
			var con_test_1 = alert('삭제하였습니다.');
					location.href='mypage_admin_store.php?acc_edit=1&page=1';
			</script>";
}




//retrieve records
// DESC역순 정렬  ASC 순차정렬
$wearResult = mysqli_query($db, "SELECT * FROM wear ORDER BY datetime DESC");
$shoesResult = mysqli_query($db, "SELECT * FROM shoes ORDER BY datetime DESC");
$accResult = mysqli_query($db, "SELECT * FROM acc ORDER BY datetime DESC");
$bannerResult = mysqli_query($db, "SELECT * FROM banner");
$bannerRecord = mysqli_fetch_array($bannerResult);
$bannerimg1 = $bannerRecord['bannerimg1'];
$bannerimg2 = $bannerRecord['bannerimg2'];
$bannerimg3 = $bannerRecord['bannerimg3'];

//update banner img
if(isset($_POST['update_banner'])){
	//변경될이미지
	$bannerChange1 = $db -> real_escape_string('img/store/'.$_FILES['bannerimg1']['name']);
	$bannerChange2 = $db -> real_escape_string('img/store/'.$_FILES['bannerimg2']['name']);
	$bannerChange3 = $db -> real_escape_string('img/store/'.$_FILES['bannerimg3']['name']);

	if($_FILES['bannerimg1']['name']!=null){
		if($bannerimg1!=$bannerChange1){
			$file_tmp_name = $_FILES['bannerimg1']['tmp_name'];
			move_uploaded_file($file_tmp_name, $bannerChange1);
			mysqli_query($db, "UPDATE banner SET bannerimg1='$bannerChange1'");
		}
	}
	if($_FILES['bannerimg2']['name']!=null){
		if($bannerimg2!=$bannerChange2){
			$file_tmp_name = $_FILES['bannerimg2']['tmp_name'];
			move_uploaded_file($file_tmp_name, $bannerChange2);
			mysqli_query($db, "UPDATE banner SET bannerimg2='$bannerChange2'");
		}
	}
	if($_FILES['bannerimg3']['name']!=null){
		if($bannerimg3!=$bannerChange3){
			$file_tmp_name = $_FILES['bannerimg3']['tmp_name'];
			move_uploaded_file($file_tmp_name, $bannerChange3);
			mysqli_query($db, "UPDATE banner SET bannerimg3='$bannerChange3'");
		}
	}

	echo "<script>
	var con_test_1 = alert('수정에 성공하였습니다.');
	location.href='store.php?wear=1&page=1#store';
	</script>";

}


// 의류 개별아이템 깔아주기
if(isset($_GET['item_w'])){
	$id = $_GET['item_w'];

	$rec = mysqli_query($db,"SELECT * FROM wear WHERE id=$id");
	$record = mysqli_fetch_array($rec);
	$id = $record['id'];
	$type = $record['type'];
	$name = $record['name'];
	$price = $record['price'];
	$post = $record['post'];
	$datetime = $record['datetime'];
	$itemimg = $record['itemimg'];


	echo
	"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#auto_w').trigger('click');

		});
		</script>";
}

// 신발 개별아이템 깔아주기
// 의류 개별아이템 깔아주기
if(isset($_GET['item_s'])){
	$id = $_GET['item_s'];

	$rec = mysqli_query($db,"SELECT * FROM shoes WHERE id=$id");
	$record = mysqli_fetch_array($rec);
	$id = $record['id'];
	$name = $record['name'];
	$type = $record['type'];
	$price = $record['price'];
	$post = $record['post'];
	$datetime = $record['datetime'];
	$itemimg = $record['itemimg'];

	echo
	"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#auto_s').trigger('click');

		});
		</script>";
}
// 악세사리 개별아이템 깔아주기
// 의류 개별아이템 깔아주기
if(isset($_GET['item_a'])){
	$id = $_GET['item_a'];

	$rec = mysqli_query($db,"SELECT * FROM acc WHERE id=$id");
	$record = mysqli_fetch_array($rec);
	$id = $record['id'];
	$name = $record['name'];
	$type = $record['type'];
	$price = $record['price'];
	$post = $record['post'];
	$datetime = $record['datetime'];
	$itemimg = $record['itemimg'];


	echo
	"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#auto_a').trigger('click');

		});
		</script>";
}
// wear 페이징 처리
if(isset($_GET['wear'])){
	//dfine how many results you want per page
	$results_per_page = 6;
	//find out the number of results in database
	$number_of_results = mysqli_num_rows($wearResult);
	/* while($row = mysqli_fetch_array($result)){
	 echo $row['id'] . ' ' . $row['name'] . '<br>';
	 } */
	//detemine number of total pages available
	$number_of_pages = ceil($number_of_results/$results_per_page);

	//determine which page number visitor is currently on
	if (!isset($_GET['page'])){
		$page = 1;
	} else {
		$page = $_GET['page'];
	}
	// determine the sql LIMIT starting number for the results on the displaying page
	$this_page_first_result = ($page-1)*$results_per_page;

	//retrieve selected results from database and display them on page
	$sql = "SELECT * FROM wear ORDER BY datetime DESC LIMIT " . $this_page_first_result . ',' . $results_per_page;
	$wearResults = mysqli_query($db,$sql);
}
// shoes 페이징처리
if(isset($_GET['shoes'])){
	//dfine how many results you want per page
	$results_per_page = 6;
	//find out the number of results in database
	$number_of_results = mysqli_num_rows($shoesResult);
	/* while($row = mysqli_fetch_array($result)){
	 echo $row['id'] . ' ' . $row['name'] . '<br>';
	 } */
	//detemine number of total pages available
	$number_of_pages = ceil($number_of_results/$results_per_page);

	//determine which page number visitor is currently on
	if (!isset($_GET['page'])){
		$page = 1;
	} else {
		$page = $_GET['page'];
	}
	// determine the sql LIMIT starting number for the results on the displaying page
	$this_page_first_result = ($page-1)*$results_per_page;

	//retrieve selected results from database and display them on page
	$sql = "SELECT * FROM shoes ORDER BY datetime DESC LIMIT " . $this_page_first_result . ',' . $results_per_page;
	$shoesResults = mysqli_query($db,$sql);
}
// acc 페이징처리
if(isset($_GET['acc'])){
	//dfine how many results you want per page
	$results_per_page = 6;
	//find out the number of results in database
	$number_of_results = mysqli_num_rows($accResult);
	/* while($row = mysqli_fetch_array($result)){
	 echo $row['id'] . ' ' . $row['name'] . '<br>';
	 } */
	//detemine number of total pages available
	$number_of_pages = ceil($number_of_results/$results_per_page);

	//determine which page number visitor is currently on
	if (!isset($_GET['page'])){
		$page = 1;
	} else {
		$page = $_GET['page'];
	}
	// determine the sql LIMIT starting number for the results on the displaying page
	$this_page_first_result = ($page-1)*$results_per_page;

	//retrieve selected results from database and display them on page
	$sql = "SELECT * FROM acc ORDER BY datetime DESC LIMIT " . $this_page_first_result . ',' . $results_per_page;
	$accResults = mysqli_query($db,$sql);
}

?>
