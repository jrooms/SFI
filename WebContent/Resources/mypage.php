<?php
include('server_admin.php');
include('server_db.php');
session_start();
// 현재 로그인한 회원이 있으면
if(isset($_SESSION['email'])){
		$guestUser = false;
	if($_SESSION['email']==$admin){
		$adminUser = true;
		echo
		"<script>
	location.href='mypage_admin.php';
	</script>";
	}
}else{

}

$type="";
$name="";
$pirce="";
$size= array();
$post="";
$datetime="";
$id=0;

include('server_store.php');
include('server_store_cart.php');


// get 액션에 값이들어오고
if(isset($_GET['action'])) {
	//들어온 값이 delete이면
	if($_GET['action'] == 'delete') {
		// 추가되었던 백슬래쉬를 제거해주는 함수이다.  stripslashes.
		$cookie_data = stripslashes($_COOKIE['shopping_cart']);
		// 전달받은 json형식의 문자열을 php 변수로 반환한다.
		$cart_data = json_decode($cookie_data, true);
		foreach($cart_data as $keys => $values) {
			if($cart_data[$keys]['item_type_id'] == $_GET['type_id']){
				// 해당값을 지운다.
				unset($cart_data[$keys]);
				$item_data = json_encode($cart_data);
				//  쿠키 셋                   키                            값                  만료시간
				setcookie('shopping_cart', $item_data, time() + (86400 * 30));
				echo
				"<script>
			var con_test_1 = alert('삭제되었습니다.');
					location.href='mypage.php#mypage';
			</script>";
			}
		}
	}
	if($_GET['action'] == 'clear') {
		setcookie('shopping_cart', '', time() - 3600);
		echo
		"<script>
			var con_test_1 = alert('모두 삭제되었습니다.');
					location.href='mypage.php#mypage';
			</script>";
	}
}

if(isset($_GET['buy'])){
	echo
			"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#auto_buyModal').trigger('click');

		});
		</script>";
}


if(isset($_GET['action'])){
	if($_GET['action'] == 'delete_user'){
		foreach($_SESSION['shopping_cart'] as $keys => $values){
			if($values['item_type_id']==$_GET['type_id']){
				unset($_SESSION['shopping_cart'][$keys]);
				echo
				"<script>
			var con_test_1 = alert('삭제되었습니다.');
					location.href='mypage.php#mypage';
			</script>";
			}
		}
	}
	if($_GET['action'] == 'clear_user') {
		unset($_SESSION['shopping_cart']);
		echo
		"<script>
			var con_test_1 = alert('모두 삭제되었습니다.');
					location.href='mypage.php#mypage';
			</script>";
	}
}


if(isset($_GET['buy_user'])){
	echo
	"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#auto_buy_userModal').trigger('click');

		});
		</script>";
}


if(isset($_SESSION['email'])){
$session_email = $db -> real_escape_string($_SESSION['email']);
$query = "SELECT * FROM comment DESK WHERE comment_sender_email LIKE '$session_email' ORDER BY date DESC";
$result=mysqli_query($db, $query);
}

//delete records
if(isset($_GET['comment_del'])){
	$comment_id = $_GET['comment_del'];
	mysqli_query($db, "DELETE FROM comment WHERE comment_id = $comment_id");

	echo
	"<script>
		var con_test_1 = alert('문의사항을 삭제합니다.');
		location.href='javascript:history.back(-1)';
		</script>";

}


$payemail = $_SESSION['email'];
$payquery = "SELECT * FROM orderlist WHERE userEmail='$payemail' ORDER BY datetime DESC";
$payresult = mysqli_query($db, $payquery);
$userAddr = '';
$receiver = '';
$delivery = '';
$datetime = '';
$phoneNumber = '';

if(isset($_GET['orderNum'])){
	$orderNum = $_GET['orderNum'];
	$pay_num_result =	mysqli_query($db, "SELECT * FROM orderlist WHERE orderNum LIKE '$orderNum'");

}


?>
<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
//페이타입 결정
function setValues(){
	var sh = document.getElementById("select_pay");
	var tt = document.getElementById("textPay");
	tt.value = sh.options[sh.selectedIndex].text;
}
</script>

<!-- iamport.payment.js -->
<script type="text/javascript" src="https://cdn.iamport.kr/js/iamport.payment-1.1.5.js"></script>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Sports brands, Sports fashion, Sports team">
<meta name="author" content="Jeong-Hun Kim">

<title>SFI - Mypage</title>

<!-- Bootstrap core CSS -->
<link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

<!-- Custom fonts for this template -->
<link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href='https://fonts.googleapis.com/css?family=Kaushan+Script' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Droid+Serif:400,700,400italic,700italic' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700' rel='stylesheet' type='text/css'>

<!-- Custom styles for this template -->
<link href="css/agency.min.css" rel="stylesheet">
</head>
<body>
<!-- Navigation 메뉴항목4  -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
<div class="container">
<a class="navbar-brand js-scroll-trigger" href="index.php">Sports Fashion Item</a>
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
Menu
<i class="fas fa-bars"></i>
</button>
<div class="collapse navbar-collapse" id="navbarResponsive">
<ul class="navbar-nav text-uppercase ml-auto">
<!-- 게스트가 아닐때만 활성화된다. -->
<?php if($adminUser != true ) {?>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="mypage.php#mypage" style=color:#fed136;>마이페이지</a>
</li>
<?php } else{?>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="mypage.php#mypage" style=color:#fed136;>관리페이지</a>
</li>
<?php }?>
<li class="nav-item">
<li class="nav-item">
<a class="nav-link js-scroll-trigger" OnClick="location.href='store.php?wear=1&page=1#store'"
style="cursor:pointer">Fashion Store</a>
</li>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" OnClick="location.href='street.php?page=1#portfolio'"
style="cursor:pointer">Street Fashion</a>
</li>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="info.php#info">Sports Info</a>
</li>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="index.php#about">About</a>
</li>
</ul>
</div>
</div>
</nav>

<!-- Header 메인페이지 시작사진  -->
<header class="masthead">
<div class="container">
<div class="intro-text">
</div>
</div>
</header>
<section class="bg-light" id="mypage">
<!-- ------------------------회원들이 보는 테이블--------------------------- -->
<?php if($guestUser == false){ //게스트유저가 아니면 ?>
<!-- 장바구니 테이블   -->
 <p align="right"><?php echo $_SESSION['email'];?></p>
<div align="right"><a href="server_logout.php">Logout</a></div>
<?php } else { //게스트유저일때 ?>
<div align="center"><a href="login.php">로그인/회원가입</a></div>
<?php }?>

<!-- 문의리스트  -->
<?php if($guestUser == false){ //게스트유저가 아닐때  ?>


 <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">나의 문의사항</div>
          <div class="card-body">
            <div class="table-responsive">
             <form method="post" action="store.php" enctype="multipart/form-data">
              <table class="table table-bordered" id="dataTable" >
                <thead>
                  <tr>
                    <td align="right">사용자</td>
                    <td align="right">상품명</td>
                    <td align="right">문의내용</td>
                    <td align="right">등록날짜</td>
                  </tr>
                </thead>
				<tbody>

<?php if(mysqli_num_rows($result)>0){ ?>
<?php 	while($row=mysqli_fetch_object($result)){
		$type = $row->type;
		$id = $row->id;
		$wear = "wear";
		$shoes ="shoes";
		$acc = "acc";
		?>
                  <tr>
                    <td align="right"><?php echo $row->comment_sender_name;?></td>

                    <?php if($type==$wear){?>
                    <td align="right"><a href="store.php?wear=1&item_w=<?php echo $id;?>&page=1">
                    <?php echo $row->item_name;?></a></td>

                    <?php } else if ($type==$shoes) {?>
                    <td align="right"><a href="store.php?shoes=1&item_s=<?php echo $id;?>&page=1"><?php echo $row->item_name;?></a></td>

                    <?php } else if ($type==$acc){?>
                    <td align="right"><a href="store.php?acc=1&item_a=<?php echo $id;?>&page=1"><?php echo $row->item_name;?></a></td>
                    <?php }?>

                    <td align="right"><?php echo $row->comment;?></td>
                    <td align="right"><?php echo $row->date;?><br>
                    <?php if($row->comment_sender_email==$_SESSION['email']){?>
					<a href="mypage.php?comment_del=<?php echo $row->comment_id;?>">삭제</a><br>
                    <?php }?>
                    </td>
                  </tr>

                  <?php if($row->reply_comment != null){?>
                  <tr>
               		<td colspan="2" align="right">└ 관리자 답변</td>
               		<td align="right"><?php echo $row->reply_comment;?></td>
                  </tr>
                   		<?php }?>
<?php }?>
<?php } else {?>

<?php }?>

                </tbody>
              </table>
              </form>
            </div>
          </div>
        </div>


<?php }else{?>

<?php }?>


<!-- 장바구니 -->
<?php if($guestUser == false){ //게스트유저가 아닐때  ?>
<?php if(!empty($_SESSION['shopping_cart'])){ //세션에 값이 세팅되었을대  ?>
 <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">장바구니</div>
          <div class="card-body">
            <div class="table-responsive">
             <form method="post" action="store.php" enctype="multipart/form-data">
              <table class="table table-bordered" id="dataTable" >
                <thead>
                  <tr>
                    <td align="right">Img</td>
                    <td align="right">품명</td>
                    <td align="right">사이즈</td>
                    <td align="right">수량</td>
                    <td align="right">가격</td>
                    <td align="right">Total</td>
                  </tr>
                </thead>
				<tbody>
		<?php
		$total = 0;
		foreach ($_SESSION['shopping_cart'] as $keys => $values){ // 쇼핑카트 세션에서 값을 가져와 뿌린다.?>
                  <tr>
                    <td align="center"><a href="store.php?<?php echo $values['item_type'];?>=1&
						<?php echo $values['item_t'];?>=<?php echo $values['item_id'];?>&
						page=<?php echo $values['item_page'];?>">
					<img src="<?php echo $values['item_img']; ?>" width="150" height="100" alt="" ></a>
					</td>
                    <td align="right"><?php echo $values['item_name']; ?></td>
                    <td align="right"><?php echo $values['item_size']; ?></td>
                    <td align="right"><?php echo $values['item_quantity']; ?></td>
                    <td align="right"><?php echo $values['item_price']; ?> 원</td>
                    <td align="right"><?php echo number_format($values['item_quantity']*$values['item_price']);?> 원<br>
					<a href="mypage.php?action=delete_user&type_id=<?php echo $values['item_type_id']; ?>">
					<span class="text-danger">삭제하기</span></a></td>
                  </tr>
                  <?php $total =$total + $values['item_quantity']*$values['item_price']; ?>
                </tbody>
              <?php } // 쇼핑카트 세션에서 값을가져와 뿌린다 ?>
                <tr>
				<td colspan="5" align="right">Total</td>
				<td align="right"><?php echo number_format($total);?> 원</td>
				</tr>
              </table>
              </form>
 				<!-- 클릭하면 modal창이 열림  -->
        		<a id="auto_buy_userModal" href="#buyModal" class="portfolio-link" data-toggle="modal"></a>
                <p align="right">
                <a  href="mypage.php?action=clear_user">비우기</a>
                </p>
                <p align="right"><button type="submit" name="buy_button" class="btn btn-success"
                OnClick="location.href='mypage.php?buy_user=1'"
                >구매하기</button></p>
            </div>
          </div>
        </div>
<?php } // 세션 쇼핑카트가 비어있지 않으면 ?>
<?php } else { //게스트유저일때 ?>
<?php if(isset($_COOKIE['shopping_cart'])) { //쇼핑카트 쿠키에 값이 들어왔을때  ?>

	        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">장바구니</div>
          <div class="card-body">
            <div class="table-responsive">
             <form method="post" action="store.php" enctype="multipart/form-data">
              <table class="table table-bordered" id="dataTable" >
                <thead>
                  <tr>
                    <td align="right">Img</td>
                    <td align="right">품명</td>
                    <td align="right">사이즈</td>
                    <td align="right">수량</td>
                    <td align="right">가격</td>
                    <td align="right">Total</td>
                  </tr>
                </thead>
                <tbody>

						<?php
						$total = 0;
						// 추가되었던 백슬래쉬를 제거해주는 함수이다.  stripslashes.
						$cookie_data = stripslashes($_COOKIE['shopping_cart']);
						// 전달받은 json형식의 문자열을 php 변수로 반환한다.
						$cart_data = json_decode($cookie_data, true);
						foreach($cart_data as $keys => $values) { ?>
                  <tr>
                    <td align="center"><a href="store.php?<?php echo $values['item_type'];?>=1&
						<?php echo $values['item_t'];?>=<?php echo $values['item_id'];?>&
						page=<?php echo $values['item_page'];?>">
					<img src="<?php echo $values['item_img']; ?>" width="150" height="100" alt="" ></a>
					</td>
                    <td align="right"><?php echo $values['item_name']; ?></td>
                    <td align="right"><?php echo $values['item_size']; ?></td>
                    <td align="right"><?php echo $values['item_quantity']; ?></td>
                    <td align="right"><?php echo $values['item_price']; ?> 원</td>
                    <td align="right"><?php echo number_format($values['item_quantity']*$values['item_price']);?> 원<br>
					<a href="mypage.php?action=delete&type_id=<?php echo $values['item_type_id']; ?>">
					<span class="text-danger">삭제하기</span></a></td>
                  </tr>
                  <?php $total =$total + $values['item_quantity']*$values['item_price']; ?>
                </tbody>

		 <?php }// 쿠키에서 데이터 불러와서 깔아준다. ?>
		  		<tr>
				<td colspan="5" align="right">Total</td>
				<td align="right"><?php echo number_format($total);?> 원</td>
				</tr>
              </table>
              </form>
              <!-- 클릭하면 modal창이 열림  -->
        		<a id="auto_buyModal" href="#buyModal" class="portfolio-link" data-toggle="modal"></a>
                <p align="right">
                <a id="auto_buyModal" href="mypage.php?action=clear">비우기</a>
                </p>
                <p align="right"><button type="submit" name="buy_button" class="btn btn-success"
                OnClick="location.href='login.php'"
                >로그인/회원가입</button></p>
            </div>
          </div>
        </div>
       <?php }// 쿠키에  장바구니에담은 아이템 정보고 담겨있는가  ?>
<?php }//게스트일때 ?>



<section id="payment">
<!-- 결제완료 아이템들 보여주기  -->
 <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">결제완료</div>
          <div class="card-body">
            <div class="table-responsive">
             <form method="post" action="store.php" enctype="multipart/form-data">
              <table class="table table-bordered" id="dataTable" >
                <thead>
                  <tr>
                    <td align="right">주문번호</td>
                    <td align="right">Img</td>
                    <td align="right">품명</td>
                    <td align="right">사이즈</td>
                    <td align="right">수량</td>
                    <td align="right">가격</td>
                    <td align="right">Total</td>
                  </tr>
                </thead>
				<tbody>


	<?php if(isset($_SESSION['email'])){?>
<?php if(mysqli_num_rows($payresult)!=0) { ?>
	<?php if(!isset($_GET['orderNum'])){?>
	<?php $numCheck ='';
	$total = 0;
	while ($row = mysqli_fetch_array($payresult)) {
		$delivery = $row['deliveryInfo'];
		$confirm = $row['confirm'];?>
                  <tr>
                  <?php if($numCheck==null){?>
                  	<td align="right"><a href="mypage.php?orderNum=<?php echo $row['orderNum'];?>#payment"><?php echo $row['orderNum'];?>
                  	<br>(상세보기)</a><p align="right" style="color:blue;"><br>결제일 : <?php echo $row['datetime'];?></p>
                  	</td>
                  	<?php }else{?>
                  	<?php if($numCheck!=$row['orderNum']){?>
                  	<td align="right"><a href="mypage.php?orderNum=<?php echo $row['orderNum'];?>#payment"><?php echo $row['orderNum'];?>
                  	<br>(상세보기)</a><p align="right" style="color:blue;"><br>결제일 : <?php echo $row['datetime'];?></p>
                  	</td>
                  	<?php }else{?>
                  	<td align="right"></td>
                  	<?php }?>
                  	<?php }?>
                    <td align="center"><img src="<?php echo $row['productImg'];?>" width="130" height="80"></td>
                    <td align="right"><?php echo$row['productName'];?></td>
                    <td align="right"><?php echo$row['size'];?></td>
                    <td align="right"><?php echo$row['productCount'];?></td>
                    <td align="right"><?php echo$row['paymentCount'];?> 원</td>
                    <td align="right"><?php echo number_format($row['productCount']*$row['paymentCount']);?> 원</td>
                  </tr>
                  <?php $total =$total + $row['productCount']*$row['paymentCount'];
                  		$userAddr = $row['userAddress'];
                  		$receiver = $row['userName'];
                  		$datetime = $row['datetime'];
                  		$phoneNumber = $row['userPhone'];
                  		$numCheck = $row['orderNum'];
                  ?>





                  <?php }?>


    <?php } else {?>
    			<?php $total = 0;
    			while ($row = mysqli_fetch_array($pay_num_result)) {?>
    			 <tr>
                  	<td align="right"><?php echo $row['orderNum'];;?></td>
                    <td align="center"><img src="<?php echo $row['productImg'];?>" width="130" height="80"></td>
                    <td align="right"><?php echo$row['productName'];?></td>
                    <td align="right"><?php echo$row['size'];?></td>
                    <td align="right"><?php echo$row['productCount'];?></td>
                    <td align="right"><?php echo$row['paymentCount'];?> 원</td>
                    <td align="right"><?php echo number_format($row['productCount']*$row['paymentCount']);?> 원
                    <p align="right"><button type="button" name="buy_confirm" class="btn btn-info"
                >리뷰작성</button></p>
                    </td>
                  </tr>
                  <?php $total =$total + $row['productCount']*$row['paymentCount'];
                  		$userAddr = $row['userAddress'];
                  		$receiver = $row['userName'];
                  		$delivery = $row['deliveryInfo'];
						$confirm = $row['confirm'];
                  		$datetime = $row['datetime'];
                  		$phoneNumber = $row['userPhone'];
                  ?>
    <?php }?>
    			<tr>
				<td colspan="6" align="right">Total</td>
				<td align="right"><?php echo number_format($total);?> 원
				<p style="color:blue;">결제완료일 : <?php echo $datetime;?></td>
				</tr>
				<tr>
				<td colspan="6" align="right">받는분</td>
				<td align="right"><?php echo $receiver;?>
				<p>전화번호 : <?php echo $phoneNumber;?></td>

				</tr>
				<tr>
				<td colspan="6" align="right">배송지 정보</td>
				<td align="right"><?php echo $userAddr;?>
				<p style="color:blue;"><?php echo $delivery;?><?php echo $confirm;?>
				<p align="right"><button type="button" name="buy_confirm" class="btn btn-info"
                >구매확정</button>
                <button type="button" name="buy_confirm" class="btn btn-success" OnClick="history.back(-1);"
                >뒤로가기</button>
                </p>
				</td>
				</tr>

    <?php }?>

    	        <?php }?>
    	        <?php }?>

                </tbody>

              </table>
              </form>
            </div>
          </div>
        </div>
</section>



</section>



<!-- -----------------------------------------회원 구매하기 모델  -->
<div class="portfolio-modal modal fade" id="buyModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="close-modal" data-dismiss="modal" onclick="history.back(-1);">
<div class="lr">
<div class="rl"></div>
</div>
</div>
<div class="container">
<div class="row">

<div class="modal-body">
<form method="post" action="store.php" enctype="multipart/form-data">

<!-- 배송정보입력 -->
<div class="container">
    <div class="card card-register mx-auto mt-5">
      <div class="card-header">배송정보입력</div>
      <div class="card-body">

         <!-- 우편번호 검색버튼 -->
          <div class="form-group">
              <div class="col-md-6">
                <div class="form-label-group">
                  <p align="left"><input type="text"  id="sample4_postcode" name="number_add" placeholder="우편번호">
				  <input type="button" onclick="sample4_execDaumPostcode()" value="우편번호 찾기"></p>
                </div>
              </div>

              <!-- 위에서 검색한 주소가 들어감  -->
              <div class="col-md-6">
                <div class="form-label-group">
                 <p align="left"><input type="text" name="address_r" style=" width:500px;"
                 id="sample4_roadAddress" placeholder="도로명주소">
                 </p>
                 <p align="left"><input type="text" name="address_n"style=" width:500px;"
                 id="sample4_jibunAddress" placeholder="지번주소">
                 </p>
                </div>
              </div>
              <!-- 나머지주소 -->
              <div class="col-md-6">
               <div class="form-group">
            	<div class="form-label-group">
             	 <p align="left"><input type="text"  name="address_re" style=" width:500px;" placeholder="나머지주소"></p>
             	 <span id="guide" style="color:#999"></span>
             	 <p align="left"><input type="text"	name="receiver" placeholder="수령인"></p>
             	 <p align="left"><input type="text" name="phone_num" placeholder="전화번호"></p>
            	</div>
          	   </div>
          	 </div>
         <div class="col-md-6" >
          <div class="form-group">
         <table style="float:left;">
    			<tr>
				<td colspan="1">
				</td>
    			</tr>
    			<tr>
				<td valign="top" >  <!-- 의류,신발,악세사리중 하나를 고른다.  -->
	<!-- 선택된 값이 자바스크립트에서 setvalues()메소드를 통해 아래에있는 type에 입려된다. -->
			<select id="select_pay" size="1" onChange="setValues();">
						<option value="card">카드결제</option>
						<option value="account">무통장입금</option>
					</select>
				</td>
    			</tr>
			</table> <br>
          	</div>
          	 	<p><input type="hidden" name="pay_type" id="textPay" value="카드결제"></p>
          </div>
          </div>
   <!-- ------------------------회원들이 보는 테이블--------------------------- -->

<?php if($guestUser == false){ //게스트유저가 아닐때  ?>
<?php if(!empty($_SESSION['shopping_cart'])){ //세션에 값이 세팅되었을대  ?>
 <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" >
                <thead>
                  <tr>
                    <td align="right">Img</td>
                    <td align="right">품명</td>
                    <td align="right">사이즈</td>
                    <td align="right">수량</td>
                    <td align="right">가격</td>
                    <td align="right">Total</td>
                  </tr>
                </thead>
				<tbody>
		<?php
		$total = 0;
		$session_count = 0;
		foreach ($_SESSION['shopping_cart'] as $keys => $values){
			$session_count++;
			$item_name = $values['item_name'];
			// 쇼핑카트 세션에서 값을 가져와 뿌린다.?>
                  <tr>
                    <td align="center"><a href="store.php?<?php echo $values['item_type'];?>=1&
						<?php echo $values['item_t'];?>=<?php echo $values['item_id'];?>&
						page=<?php echo $values['item_page'];?>">
					<img src="<?php echo $values['item_img']; ?>" width="150" height="100" alt="" ></a>
					</td>
                    <td align="right"><?php echo $item_name;?></td>
                    <td align="right"><?php echo $values['item_size']; ?></td>
                    <td align="right"><?php echo $values['item_quantity']; ?></td>
                    <td align="right"><?php echo $values['item_price']; ?> 원</td>
                    <td align="right"><?php echo number_format($values['item_quantity']*$values['item_price']);?> 원<br></td>
                  </tr>
                  <?php $total =$total + $values['item_quantity']*$values['item_price']; ?>
                </tbody>
              <?php } // 쇼핑카트 세션에서 값을가져와 뿌린다 ?>
                <tr>
				<td colspan="5" align="right">Total</td>
				<td align="right"><?php echo number_format($total);?> 원</td>
				</tr>
              </table>
            </div>
          </div>
        </div>
          <!-- 클릭하면 modal창이 열림  -->
                <p align="right"><button type="button" id="payment_btn" class="btn btn-success"
                >결제하기</button><button class="btn btn-primary" data-dismiss="modal" type="button" onclick="history.back(-1);">
		Close</button></p>
<?php } // 세션 쇼핑카트가 비어있지 않으면 ?>
<?php } else { //게스트유저일때 ?>
<?php if(isset($_COOKIE['shopping_cart'])) { //쇼핑카트 쿠키에 값이 들어왔을때  ?>

	        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" >
                <thead>
                  <tr>
                    <td align="right">Img</td>
                    <td align="right">품명</td>
                    <td align="right">사이즈</td>
                    <td align="right">수량</td>
                    <td align="right">가격</td>
                    <td align="right">Total</td>
                  </tr>
                </thead>
                <tbody>

						<?php
						$total = 0;
						// 추가되었던 백슬래쉬를 제거해주는 함수이다.  stripslashes.
						$cookie_data = stripslashes($_COOKIE['shopping_cart']);
						// 전달받은 json형식의 문자열을 php 변수로 반환한다.
						$cart_data = json_decode($cookie_data, true);
						foreach($cart_data as $keys => $values) { ?>
                  <tr>
                    <td align="center"><a href="store.php?<?php echo $values['item_type'];?>=1&
						<?php echo $values['item_t'];?>=<?php echo $values['item_id'];?>&
						page=<?php echo $values['item_page'];?>">
					<img src="<?php echo $values['item_img']; ?>" width="150" height="100" alt="" ></a>
					</td>
                    <td align="right"><?php echo $values['item_name']; ?></td>
                    <td align="right"><?php echo $values['item_size']; ?></td>
                    <td align="right"><?php echo $values['item_quantity'];?></td>
                    <td align="right"><?php echo $values['item_price']; ?> 원</td>
                    <td align="right"><?php echo number_format($values['item_quantity']*$values['item_price']);?> 원<br></td>
                  </tr>
                  <?php $total = $total + $values['item_quantity']*$values['item_price']; ?>
                </tbody>



		 <?php }// 쿠키에서 데이터 불러와서 깔아준다. ?>
		  		<tr>
				<td colspan="5" align="right">Total</td>
				<td align="right"><?php echo number_format($total);?> 원</td>
				</tr>
              </table>
            </div>
          </div>
        </div>
       <?php }// 쿠키에  장바구니에담은 아이템 정보고 담겨있는가  ?>
         <!-- 클릭하면 modal창이 열림  -->
                <p align="right"><a href="register.php"><button type="button" class="btn btn-success"
                >회원가입</button></a><button class="btn btn-primary" data-dismiss="modal" type="button" onclick="history.back(-1);">
		Close</button></p>
<?php }//게스트일때 ?>

          <input type="hidden" name="product_name" id="product_name" value="<?php echo $item_name; ?>">
          <input type="hidden" name="hd_amount" id="pay_amount" value="<?php echo $total; ?>">
          <input type="hidden" name="hd_email" id="pay_email" value="<?php echo $_SESSION['email']; ?>">
      </div>
    </div>
  </div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>





<!-- Footer -->
<footer>
<div class="container">
<div class="row">
<div class="col-md-4">
<span class="copyright">Copyright &copy; SFI 2019</span>
</div>
<!--         <div class="col-md-4">
<ul class="list-inline social-buttons">
<li class="list-inline-item">
<a href="#">
<i class="fab fa-twitter"></i>
</a>
</li>
<li class="list-inline-item">
<a href="#">
<i class="fab fa-facebook-f"></i>
</a>
</li>
<li class="list-inline-item">
<a href="#">
<i class="fab fa-linkedin-in"></i>
</a>
</li>
</ul>
</div> -->
<div class="col-md-4">
<ul class="list-inline quicklinks">
<li class="list-inline-item">
<a href="#">Privacy Policy</a>
</li>
<li class="list-inline-item">
<a href="#">Terms of Use</a>
</li>
</ul>
</div>
</div>
</div>
</footer>
<script>
$("#payment_btn").click(function () {

	var amount_var = $("#pay_amount").val();
	var product_name = $("#product_name").val();
	var phone_var = $("input[name=phone_num]").val();
	var email_var = $("#pay_email").val();
	var addr_var = $("input[name=address_r]").val();
	var addr2_var =  $("input[name=address_re]").val();
	var postcode_var = $("#sample4_postcode").val();
	var name_var = $("input[name=receiver]").val();

	/* var IMP = window.IMP; // 생략가능 */
   IMP.init('imp01240654');  // 가맹점 식별 코드

   IMP.request_pay({
      pg : 'kakao', // 결제방식
      pay_method : 'card',	// 결제 수단
      merchant_uid : 'merchant_' + new Date().getTime(),
      name : product_name,// order 테이블에 들어갈 주문명 혹은 주문 번호
      amount : amount_var,	// 결제 금액
      buyer_email : email_var,	// 구매자 email
      buyer_name: name_var, //구매자 이름
      buyer_tel : phone_var,	// 구매자 전화번호
      buyer_addr : addr_var + '-' + addr2_var,	// 구매자 주소
      buyer_postcode : postcode_var	// 구매자 우편번호
   }, function(rsp) {
	if ( rsp.success ) { // 성공시
		var msg = '결제가 완료되었습니다.';
		msg += '고유ID : ' + rsp.imp_uid;
		msg += '상점 거래ID : ' + rsp.merchant_uid;
		msg += '결제 금액 : ' + rsp.paid_amount;
		msg += '카드 승인번호 : ' + rsp.apply_num;
		var con_test_1 = alert('결제완료하였습니다.');
		location.href='mypage_pay_com.php?address='+postcode_var+','+addr_var+','+addr2_var+'&uname='+name_var+'&phone='+phone_var;
	} else { // 실패시
		var msg = '결제에 실패하였습니다.';
		msg += '에러내용 : ' + rsp.error_msg;
	}
});
});
</script>

<script src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
    //본 예제에서는 도로명 주소 표기 방식에 대한 법령에 따라, 내려오는 데이터를 조합하여 올바른 주소를 구성하는 방법을 설명합니다.
    function sample4_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                // 법정동명이 있을 경우 추가한다. (법정리는 제외)
                // 법정동의 경우 마지막 문자가 "동/로/가"로 끝난다.
                if(data.bname !== '' && /[동|로|가]$/g.test(data.bname)){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있고, 공동주택일 경우 추가한다.
                if(data.buildingName !== '' && data.apartment === 'Y'){
                   extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if(fullRoadAddr !== ''){
                    fullRoadAddr += extraRoadAddr;
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('sample4_postcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('sample4_roadAddress').value = fullRoadAddr;
                document.getElementById('sample4_jibunAddress').value = data.jibunAddress;

                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    //예상되는 도로명 주소에 조합형 주소를 추가한다.
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    document.getElementById('guide').innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById('guide').innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

                } else {
                    document.getElementById('guide').innerHTML = '';
                }
            }
        }).open();
    }
</script>


<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

<!-- Plugin JavaScript -->
<script src="vendor/jquery-easing/jquery.easing.min.js"></script>

<!-- Contact form JavaScript -->
<script src="js/jqBootstrapValidation.js"></script>
<script src="js/contact_me.js"></script>

<!-- Custom scripts for this template -->
<script src="js/agency.min.js"></script>
</body>
</html>
