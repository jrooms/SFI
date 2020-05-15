<?php
include('server_admin.php');
include('server_db.php');
session_start();
// 현재 로그인한 회원이 있으면
if(isset($_SESSION['email']) != $admin){
	echo
	"<script>
	var con_test_1 = alert('페이지 접근 권한이 없습니다.');
	location.href='login.php';
	</script>";
}

include('server_store.php');
include('server_store_cart.php');

$currentDate = date("Y-m-d");  //오늘
$beforeMonth = date("Y-m-d", strtotime("-1 month", time())); // 전 달
$beforeWeek = date("Y-m-d", strtotime("-1 week", time())); // 전 주
$beforeDay = date("Y-m-d", strtotime("-1 day", time())); // 하루전

if(isset($_GET['orderNum'])){
	$orderNum = $_GET['orderNum'];
  $pay_num_result =	mysqli_query($db, "SELECT * FROM orderlist WHERE orderNum LIKE '$orderNum'");



}else{
	//중복제거 카운트
	$query_pay ="SELECT orderNum, count(*) FROM orderlist WHERE deliveryInfo IS NOT NULL GROUP BY orderNum";
	$pay_result = mysqli_query($db, $query_pay);

	//dfine how many results you want per page
	$results_per_page = 5;
	//find out the number of results in database
	$number_of_results = mysqli_num_rows($pay_result);

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
	$sql = "SELECT id, orderNum, userEmail, userAddress, userName, userPhone, productName, productCount, productImg, productType, paymentCount, datetime, confirm, size, deliveryInfo
	FROM orderlist WHERE deliveryInfo IS NOT NULL GROUP BY orderNum ORDER BY datetime DESC LIMIT $this_page_first_result,$results_per_page";
	$pay_results = mysqli_query($db,$sql);

}

// 배달완료
if(isset($_GET['delivery'])){
	$orderNum = $_GET['delivery'];
	$order = '배송중';
	mysqli_query($db, "UPDATE orderlist SET deliveryInfo=NULL,confirm='$order' WHERE orderNum LIKE '$orderNum'");

	echo
	"<script>
		var con_test_1 = alert('출고완료하였습니다.');
		location.href='mypage_admin_payment.php?page=1&page_n=1#payment2';
		</script>";

}



if(isset($_GET['orderNum_n'])){
	$orderNum = $_GET['orderNum_n'];
	$pay_num_result_n =	mysqli_query($db, "SELECT * FROM orderlist WHERE orderNum LIKE '$orderNum'");

}else{

	//전체리스트
	$query_pay ="SELECT orderNum, count(*) FROM orderlist WHERE confirm IS NOT NULL GROUP BY orderNum";
	$pay_result_n = mysqli_query($db, $query_pay);

	//dfine how many results you want per page
	$results_per_page_n = 5;
	//find out the number of results in database
	$number_of_results_n = mysqli_num_rows($pay_result_n);


	/* while($row = mysqli_fetch_array($result)){
	 echo $row['id'] . ' ' . $row['name'] . '<br>';
	 } */
	//detemine number of total pages available
	$number_of_pages_n = ceil($number_of_results_n/$results_per_page_n);
	//determine which page number visitor is currently on
	if (!isset($_GET['page_n'])){
		$page_n = 1;
	} else {
		$page_n = $_GET['page_n'];
	}
	// determine the sql LIMIT starting number for the results on the displaying page
	$this_page_first_result_n = ($page_n-1)*$results_per_page_n;

	//retrieve selected results from database and display them on page
	$sql_n = "SELECT id, orderNum, userEmail, userAddress, userName, userPhone, productName, productCount, productImg, productType, paymentCount, datetime, confirm, size, deliveryInfo
	FROM orderlist WHERE confirm IS NOT NULL GROUP BY orderNum ORDER BY datetime DESC LIMIT $this_page_first_result_n,$results_per_page_n";
	$pay_results_n = mysqli_query($db,$sql_n);

}




?>
<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
//상품등록시 type 선택
function setValues(){
	var sh = document.getElementById("selectType");
	var tt = document.getElementById("textType");
	tt.value = sh.options[sh.selectedIndex].text;
}
</script>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Sports brands, Sports fashion, Sports team">
<meta name="author" content="Jeong-Hun Kim">
<title >관리자페이지</title>
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

 <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="css/sb-admin.css" rel="stylesheet">

</head>

<body id="page-top">


 <div id="wrapper">


    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>관리</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">목록</h6>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="mypage_admin.php?page_c=1&page_u=1&date=month&page_p=1#comment">Admin Home</a>
          <a class="dropdown-item" href="index.php">Main Home</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="mypage_admin_userlist.php?page_u=1#user">회원관리</a>
          <div class="dropdown-divider"></div>
          <h6 class="dropdown-header">상품관리</h6>
          <a class="dropdown-item" href="mypage_admin_store.php?wear_edit=1&page=1">Wear</a>
          <a class="dropdown-item" href="mypage_admin_store.php?shoes_edit=1&page=1">Shoes</a>
          <a class="dropdown-item" href="mypage_admin_store.php?acc_edit=1&page=1">Acc</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="mypage_admin_street.php?page=1">스냅사진관리</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">Logout</a>
        </div>
      </li>


    </ul>

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">문의사항</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="mypage_admin_comment.php?page=1&page_n=1#comment1">
                <span class="float-left">확인하기</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>

          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5"> 구매요청목록</div>
              </div>
              <a class="card-footer text-white clearfix small z-1" href="mypage_admin_payment.php?page=1&page_n=1#payment1">
                <span class="float-left">확인하기</span>
                <span class="float-right">
                  <i class="fas fa-angle-right"></i>
                </span>
              </a>
            </div>
          </div>
        </div>





      <section id="payment1">
       <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            	배송전 목록</div>
          <div class="card-body">

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td align="right">주문번호</td>
                    <td align="right">주문회원 아이디</td>
                    <td align="right">Img</td>
                    <td align="right">품명</td>
                    <td align="right">사이즈</td>
                    <td align="right">수량</td>
                    <td align="right">가격</td>
                    <td align="right">Total</td>
                  </tr>
                </thead>
                <tbody>

	<?php if(!isset($_GET['orderNum'])){?>
		<?php while ($row = mysqli_fetch_array($pay_results)) {?>
                  <tr>
                  	<td align="right"><a href="mypage_admin_payment.php?orderNum=<?php echo $row['orderNum'];?>#payment1"><?php echo $row['orderNum'];?>
                  	<br>(상세보기)</a><br>결제일 : <?php echo $row['datetime'];?></td>
                 	<td align="right"><?php echo $row['userEmail'];?></td>
                    <td align="center"><img src="<?php echo $row['productImg']; ?>" width="130" height="80"></td>
                    <td align="right"><?php echo$row['productName'];?></td>
                    <td align="right"><?php echo$row['size'];?></td>
                    <td align="right"><?php echo$row['productCount'];?></td>
                    <td align="right"><?php echo$row['paymentCount'];?> 원</td>
                    <td align="right"><?php echo number_format($row['productCount']*$row['paymentCount']);?> 원
                    </td>
                  </tr>

                  <?php
                  $userAddr = $db -> real_escape_string ($row['userAddress']);
                  $receiver = $db -> real_escape_string($row['userName']);
                  $delivery = $db -> real_escape_string($row['deliveryInfo']);
                  $datetime = $db -> real_escape_string($row['datetime']);
                  $phoneNumber = $db -> real_escape_string($row['userPhone']);?>


 <?php }?>
 <?php } else {?>
 			<?php
 			$total = 0;
 			while ($row = mysqli_fetch_array($pay_num_result)) {?>
					<tr>
                  	<td align="right"><?php echo $row['orderNum'];?></td>
                  	<td align="right"><?php echo $row['userEmail'];?></td>
                    <td align="center"><img src="<?php echo $row['productImg']; ?>" width="130" height="80"></td>
                    <td align="right"><?php echo$row['productName'];?></td>
                    <td align="right"><?php echo$row['size'];?></td>
                    <td align="right"><?php echo$row['productCount'];?></td>
                    <td align="right"><?php echo$row['paymentCount'];?> 원</td>
                    <td align="right"><?php echo number_format($row['productCount']*$row['paymentCount']);?> 원
                    </td>
                  </tr>

	<?php 				$total = $total + $row['productCount']*$row['paymentCount'];
						$userAddr = $row['userAddress'];
                  		$receiver = $row['userName'];
                  		$delivery = $row['deliveryInfo'];
                  		$datetime = $row['datetime'];
                  		$phoneNumber = $row['userPhone'];
						$orderNum =  $row['orderNum'];
                  		?>

                  <?php }?>
                  <tr>
				<td colspan="7" align="right">Total</td>
				<td align="right"><?php echo number_format($total);?> 원
				<p style="color:blue;">결제완료일 : <?php echo $datetime;?></td>
				</tr>
				<tr>
				<td colspan="7" align="right">받는분</td>
				<td align="right"><?php echo $receiver;?>
				<p>전화번호 : <?php echo $phoneNumber;?></td>

				</tr>
				<tr>
				<td colspan="7" align="right">배송지 정보</td>
				<td align="right"><?php echo $userAddr;?>
				<p style="color:blue;"><?php echo $delivery;?></p>
				<a class="btn btn-info" href="mypage_admin_payment.php?oderNum=<?php echo $orderNum;?>&delivery=<?php echo $orderNum;?>">출고완료</a>

				<button type="button" name="buy_confirm" class="btn btn-success" OnClick="history.back(-1);"
                >뒤로가기</button>
				</td>
				</tr>


 <?php }?>
                </tbody>
              </table>

<?php if(!isset($_GET['orderNum'])){?>            <!-- 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="mypage_admin_payment.php?page=<?php
      if($_GET['page']>1){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']-1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>&page_n=<?php echo $_GET['page_n']; ?>#payment1">Previous</a>
    </li>
       <?php
    // display the links to the pages
    for ($page=1; $page<=$number_of_pages; $page++) { // 페이지를 db에서 찾아서 전체를 뿌려준다. 위에 계산된대로
    	?>
    <!-- 페이지 숫자버튼  -->
    <li class="page-item"><a class="page-link"
    href="mypage_admin_payment.php?page=<?php echo $page;?>&page_n=<?php echo $_GET['page_n']; ?>#payment1"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="mypage_admin_payment.php?page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>&page_n=<?php echo $_GET['page_n']; ?>#payment1">Next</a>
    </li>
  </ul>
</nav>
<?php }?>
            </div>

          </div>
        </div>
      </section>



<section id="payment2">

<!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            	배송완료 목록</div>
          <div class="card-body">

            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <td align="right">주문번호</td>
                    <td align="right">주문회원 아이디</td>
                    <td align="right">Img</td>
                    <td align="right">품명</td>
                    <td align="right">사이즈</td>
                    <td align="right">수량</td>
                    <td align="right">가격</td>
                    <td align="right">Total</td>
                  </tr>
                </thead>
                <tbody>
	<?php if(!isset($_GET['orderNum_n'])){?>
		<?php while ($row = mysqli_fetch_array($pay_results_n)) {?>
	<tr>
	       <td align="right"><a href="mypage_admin_payment.php?orderNum_n=<?php echo $row['orderNum'];?>#payment2"><?php echo $row['orderNum'];?>
                    <br>(상세보기)</a><br>결제일 : <?php echo $row['datetime'];?></td>
                    <td align="right"><?php echo $row['userEmail'];?></td>
                    <td align="center"><img src="<?php echo $row['productImg']; ?>" width="130" height="80"></td>
                    <td align="right"><?php echo$row['productName'];?></td>
                    <td align="right"><?php echo$row['size'];?></td>
                    <td align="right"><?php echo$row['productCount'];?></td>
                    <td align="right"><?php echo$row['paymentCount'];?> 원</td>
                    <td align="right"><?php echo number_format($row['productCount']*$row['paymentCount']);?> 원
                    </td>
                  </tr>
					<?php
                  $userAddr = $db -> real_escape_string ($row['userAddress']);
                  $receiver = $db -> real_escape_string($row['userName']);
                  $delivery = $db -> real_escape_string($row['deliveryInfo']);
                  $datetime = $db -> real_escape_string($row['datetime']);
                  $phoneNumber = $db -> real_escape_string($row['userPhone']);
                  $numCheck = $db -> real_escape_string($row['orderNum']);?>

<?php }?>
 <?php } else {?>
 			<?php
 			$total = 0;
 			while ($row = mysqli_fetch_array($pay_num_result_n)) {?>
		<?php if($row['confirm']!=null){?>
					<tr>
                  	<td align="right"><?php echo $row['orderNum'];?></td>
                  	<td align="right"><?php echo $row['userEmail'];?></td>
                    <td align="center"><img src="<?php echo $row['productImg']; ?>" width="130" height="80"></td>
                    <td align="right"><?php echo$row['productName'];?></td>
                    <td align="right"><?php echo$row['size'];?></td>
                    <td align="right"><?php echo$row['productCount'];?></td>
                    <td align="right"><?php echo$row['paymentCount'];?> 원</td>
                    <td align="right"><?php echo number_format($row['productCount']*$row['paymentCount']);?> 원
                    </td>
                  </tr>

	<?php 				$total = $total + $row['productCount']*$row['paymentCount'];
						$userAddr = $row['userAddress'];
                  		$receiver = $row['userName'];
                  		$delivery = $row['deliveryInfo'];
                  		$datetime = $row['datetime'];
                  		$phoneNumber = $row['userPhone'];
						$orderNum =  $row['orderNum'];
                  		?>
<?php }?>
                  <?php }?>
                  <tr>
				<td colspan="7" align="right">Total</td>
				<td align="right"><?php echo number_format($total);?> 원
				<p style="color:blue;">결제완료일 : <?php echo $datetime;?></td>
				</tr>
				<tr>
				<td colspan="7" align="right">받는분</td>
				<td align="right"><?php echo $receiver;?>
				<p>전화번호 : <?php echo $phoneNumber;?></td>

				</tr>
				<tr>
				<td colspan="7" align="right">배송지 정보</td>
				<td align="right"><?php echo $userAddr;?>
				<p style="color:blue;"><?php echo $delivery;?></p>
				<button type="button" name="buy_confirm" class="btn btn-success" OnClick="history.back(-1);"
                >뒤로가기</button>
				</td>
				</tr>
                  <?php }?>
                </tbody>
              </table>

              <?php if(!isset($_GET['orderNum_n'])){?>            <!-- 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="mypage_admin_payment.php?page=<?php echo $_GET['page'];?>&page_n=<?php
      if($_GET['page_n']>1){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page_n']-1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page_n']; //아닐경우에는 그대로 둔다.
      }
      ?>#payment2">Previous</a>
    </li>
       <?php
    // display the links to the pages
    for ($page_n=1; $page_n<=$number_of_pages_n; $page_n++) { // 페이지를 db에서 찾아서 전체를 뿌려준다. 위에 계산된대로
    	?>
    <!-- 페이지 숫자버튼  -->
    <li class="page-item"><a class="page-link"
    href="mypage_admin_payment.php?page=<?php echo $_GET['page'];?>&page_n=<?php echo $page_n;?>#payment2"><?php

    if($page_n==$_GET['page_n']){
    	echo '<span style="color:red;">'.$page_n.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page_n; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="mypage_admin_payment.php?page=<?php echo $_GET['page']; ?>&page_n=<?php

      if($_GET['page_n']+1<=$number_of_pages_n){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page_n']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page_n']; //아닐경우에는 그대로 둔다.
      }
      ?>#payment2">Next</a>
    </li>
  </ul>
</nav>
<?php }?>

            </div>

          </div>
        </div>

</section>



      </div>
     </div>

    </div>

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>Copyright © Your Website 2019</span>
          </div>
        </div>
      </footer>


    <!-- /.content-wrapper -->



<!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <!-- Logout Modal-->
  <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">로그아웃 하시겠습니까?</h5>
          <button class="close" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body">로그인페이지로 이동합니다.</div>
        <div class="modal-footer">
          <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
          <a class="btn btn-primary" href="server_logout.php">Logout</a>
        </div>
      </div>
    </div>
  </div>



  <!-- Bootstrap core JavaScript-->
  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

  <!-- Core plugin JavaScript-->
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

  <!-- Page level plugin JavaScript-->
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="vendor/datatables/jquery.dataTables.js"></script>
  <script src="vendor/datatables/dataTables.bootstrap4.js"></script>

  <!-- Custom scripts for all pages-->
  <script src="js/sb-admin.min.js"></script>

  <!-- Demo scripts for this page-->
  <script src="js/demo/datatables-demo.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>
</body>
</html>
