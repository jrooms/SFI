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

//retrieve records
// DESC역순 정렬  ASC 순차정렬
$result = mysqli_query($db, "SELECT * FROM users ORDER BY date DESC");
// SNAP 테이블에서 CREATED = DATETIME 을 역순으로 정렬한
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
	$sql = "SELECT * FROM users ORDER BY date DESC LIMIT $this_page_first_result,$results_per_page";
	$results = mysqli_query($db,$sql);

}
?>
<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
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



<section id="user">

<!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            	회원리스트</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>가입날짜</th>

                  </tr>
                </thead>
                <tbody>
                <?php while ($row = mysqli_fetch_array($results)) {?>
                  <tr>
                    <td><?php echo $row['username'];?></td>
                    <td><?php echo $row['email'];?></td>
                    <td><?php echo $row['date'];?></td>
                  </tr>
                        <?php }?>

                </tbody>
              </table>

<?php if(isset($_GET['page_u'])){?>
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">
	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="mypage_admin_userlist.php?page_u=<?php
      if($_GET['page_u']>1){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page_u']-1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page_u']; //아닐경우에는 그대로 둔다.
      }
      ?>#user">Previous</a>
    </li>
       <?php
    // display the links to the pages
    for ($page_u=1; $page_u<=$number_of_pages_u; $page_u++) { // 페이지를 db에서 찾아서 전체를 뿌려준다. 위에 계산된대로
    	?>
    <!-- 페이지 숫자버튼  -->
    <li class="page-item"><a class="page-link"
    href="mypage_admin_userlist.php?page_u=<?php echo $page_u;?>#user"><?php

    if($page_u==$_GET['page_u']){
    	echo '<span style="color:red;">'.$page_u.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page_u; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="mypage_admin_userlist.php?page_u=<?php

      if($_GET['page_u']+1<=$number_of_pages_u){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page_u']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page_u']; //아닐경우에는 그대로 둔다.
      }
      ?>#user">Next</a>
    </li>
  </ul>
</nav>
<?php }?>

            </div>
          </div>
        </div>

</section>
      </div>
      <!-- /.container-fluid -->





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

  </div>

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
