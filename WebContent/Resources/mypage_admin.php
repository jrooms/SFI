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
$beforeDay = date("Y-m-d", strtotime("0 day", time())); // 하루전
if(isset($_GET['date'])){
	// 한달동안 새로 등록한 회원 보여줌
	$result = mysqli_query($db,
			"SELECT * FROM users WHERE date BETWEEN '$beforeMonth' and '$currentDate' ORDER BY date DESC");

	if(isset($_GET['page_u'])){

		//dfine how many results you want per page
		$results_per_page = 5;
		//find out the number of results in database
		$number_of_results = mysqli_num_rows($result);


		/* while($row = mysqli_fetch_array($result)){
		 echo $row['id'] . ' ' . $row['name'] . '<br>';
		 } */
		//detemine number of total pages available
		$number_of_pages_u = ceil($number_of_results/$results_per_page);
		//determine which page number visitor is currently on
		if (!isset($_GET['page_u'])){
			$page_u = 1;
		} else {
			$page_u = $_GET['page_u'];
		}
		// determine the sql LIMIT starting number for the results on the displaying page
		$this_page_first_result = ($page_u-1)*$results_per_page;

		//retrieve selected results from database and display them on page
		$sql = "SELECT * FROM users WHERE date BETWEEN '$beforeMonth' and '$currentDate' ORDER BY date DESC LIMIT $this_page_first_result,$results_per_page";
		$results = mysqli_query($db,$sql);

	}

} else {
	$result = mysqli_query($db,
			"SELECT * FROM users WHERE date BETWEEN '$beforeWeek' and '$currentDate' ORDER BY date DESC ");


	if(isset($_GET['page_u'])){

		//dfine how many results you want per page
		$results_per_page = 5;
		//find out the number of results in database
		$number_of_results = mysqli_num_rows($result);


		/* while($row = mysqli_fetch_array($result)){
		 echo $row['id'] . ' ' . $row['name'] . '<br>';
		 } */
		//detemine number of total pages available
		$number_of_pages_u = ceil($number_of_results/$results_per_page);
		//determine which page number visitor is currently on
		if (!isset($_GET['page_u'])){
			$page_u = 1;
		} else {
			$page_u = $_GET['page_u'];
		}
		// determine the sql LIMIT starting number for the results on the displaying page
		$this_page_first_result = ($page_u-1)*$results_per_page;

		//retrieve selected results from database and display them on page
		$sql = "SELECT * FROM users WHERE date BETWEEN '$beforeWeek' and '$currentDate' ORDER BY date DESC LIMIT $this_page_first_result,$results_per_page";
		$results = mysqli_query($db,$sql);

	}



}

$query = "SELECT * FROM comment WHERE date BETWEEN '$beforeWeek' and '$currentDate' ORDER BY date DESC";
$result_c = mysqli_query($db, $query);

if(isset($_GET['page_c'])){

	//dfine how many results you want per page
	$results_per_page = 5;
	//find out the number of results in database
	$number_of_results = mysqli_num_rows($result_c);


	/* while($row = mysqli_fetch_array($result)){
	 echo $row['id'] . ' ' . $row['name'] . '<br>';
	 } */
	//detemine number of total pages available
	$number_of_pages_c = ceil($number_of_results/$results_per_page);
	//determine which page number visitor is currently on
	if (!isset($_GET['page_c'])){
		$page_c = 1;
	} else {
		$page_c = $_GET['page_c'];
	}
	// determine the sql LIMIT starting number for the results on the displaying page
	$this_page_first_result = ($page_c-1)*$results_per_page;

	//retrieve selected results from database and display them on page
	$sql = "SELECT * FROM comment WHERE date BETWEEN '$beforeWeek' and '$currentDate' ORDER BY date DESC LIMIT $this_page_first_result,$results_per_page";
	$comment_result = mysqli_query($db,$sql);

}


$query_pay ="SELECT * FROM orderlist WHERE datetime BETWEEN '$beforeWeek' and '$currentDate' ORDER BY datetime DESC";
$result_p = mysqli_query($db, $query_pay);

if(isset($_GET['page_p'])){

	//dfine how many results you want per page
	$results_per_page = 5;
	//find out the number of results in database
	$number_of_results = mysqli_num_rows($result_p);


	/* while($row = mysqli_fetch_array($result)){
	 echo $row['id'] . ' ' . $row['name'] . '<br>';
	 } */
	//detemine number of total pages available
	$number_of_pages_p = ceil($number_of_results/$results_per_page);
	//determine which page number visitor is currently on
	if (!isset($_GET['page_p'])){
		$page_p = 1;
	} else {
		$page_p = $_GET['page_p'];
	}
	// determine the sql LIMIT starting number for the results on the displaying page
	$this_page_first_result = ($page_p-1)*$results_per_page;

	//retrieve selected results from database and display them on page
	$sql = "SELECT * FROM orderlist WHERE datetime BETWEEN '$beforeWeek' and '$currentDate' ORDER BY datetime DESC LIMIT $this_page_first_result,$results_per_page";
	$pay_result = mysqli_query($db,$sql);

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
			<!--
      <li class="nav-item">
        <a class="nav-link" href="#">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
			-->

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

    </div>
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
