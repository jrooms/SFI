<?php
include('server_admin.php');
include('server_db.php');
include('mypage.php');
// 현재 로그인한 회원이 있으면
if(isset($_SESSION['email'])){
	$guestUser = false;
	if($_SESSION['email']==$admin){
		$adminUser = true;
		echo
		"<script>
	location.href='mypage.php#mypage';
	</script>";
	}
}else{

}

include('server_store.php');
include('server_store_cart.php');

foreach ($_SESSION['shopping_cart'] as $keys => $values){

	$now = date("ymdHis"); //오늘의 날짜 년월일시분초
	$item_num = strtoupper(substr(uniqid(sha1(time())),0,4)); //임의의난수발생 앞6자리
	$orderNum = $db -> real_escape_string ($now.$item_num); // 주문번호
	$userEmail = $db -> real_escape_string ($_SESSION['email']); // 유저이메일
	$userAddress = $db -> real_escape_string ($_GET['address']); // 유저주소
	$receiver = $db -> real_escape_string ($_GET['uname']); // 받는사람
	$phone_num = $db -> real_escape_string ($_GET['phone']); //전화번호
	$item_name = $values['item_name']; //아이템이름
	$item_quantity = $values['item_quantity']; // 아이템수량
	$item_price = $values['item_price']; //아이템가격
	$item_img = $values['item_img']; //아이템이미지
	$item_type= $values['item_type']; //아이템타입.
	$size = $values['item_size'];
	$query = "INSERT INTO orderlist (orderNum, userEmail, userAddress, userName, userPhone, productName, productCount
	, productImg, productType, paymentCount, datetime, size)
	VALUES ('$orderNum', '$userEmail', '$userAddress', '$receiver', '$phone_num', '$item_name', '$item_quantity',
	'$item_img', '$item_type', '$item_price', NOW(), '$size')";
	mysqli_query($db, $query);
	unset($_SESSION['shopping_cart']);
}

echo
"<script>
	location.href='mypage.php#mypage';
	</script>";

?>
