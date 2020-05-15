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
include('server_street.php');

// fetch the record to be updated
if(isset($_GET['edit'])) {
	# code ...
	$id = $_GET['edit'];
	//조회수 추가
	//$hitrec = mysqli_query($db,"UPDATE snap set hit=hit+1 WHERE id=$id");
	$edit_state= true;
	// snap 에 있는 get으로 구분한 아이디값을 찾는다.
	$rec = mysqli_query($db,"SELECT * FROM snap WHERE id=$id");
	/* 레코드를 1개씩 리턴해준다. */
	$record = mysqli_fetch_array($rec);
	// 다음은 rec에서 리턴받은 id값의 해당 정보들이다.
	// modal에는 이 정보들이 보여진다.
	$id = $record['id'];
	$name = $record['name'];
	$age = $record['age'];
	$post = $record['post'];
	$district = $record['district'];
	$datetime = $record['created'];
	$snapimg = $record['snapimg'];
	$like = $record['like'];
	$hit = $record['hit'];
	$currentPage = $_GET['page'];

	// modal 창 띄워주기!!!!!!!!!!
	// get으로 modal 하나를 구분해주고
	// 자동으로 창이 클릭되게하였다.
	echo
	"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#auto_modal').trigger('click');

		});
		</script>";
}


//dfine how many results you want per page
$results_per_page = 10;
//find out the number of results in database
$number_of_results = mysqli_num_rows($results);
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
$sql = "SELECT * FROM snap ORDER BY created DESC LIMIT " . $this_page_first_result . ',' . $results_per_page;
$result = mysqli_query($db,$sql);

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

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            	스냅사진 리스트</div>
          <div class="card-body">
           <a  href="#portfolioWrite"
            	class="portfolio-link" data-toggle="modal">게시물등록  &nbsp;</a>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" style="table-layout:fixed">
                <thead>
                  <tr>
                  	<th>Img</th>
                    <th>id</th>
                    <th>Name</th>
                    <th>Age</th>
                    <th>District</th>
                    <th>Post</th>
                    <th>created</th>
                    <th>edit</th>
                  </tr>
                </thead>
                <tbody>
              <?php while ($row = mysqli_fetch_array($result)){?>
                  <tr>
                  <td align="center"><img src="<?php echo $row['snapimg'];?>" width="110" height="60"  ></td>
                 <td><?php echo $row['id'];?></td>
                 <td><?php echo $row['name'];?></td>
                 <td><?php echo $row['age'];?></td>
                 <td><?php echo $row['district'];?></td>
                 <td style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                 <?php echo $row['post'];?></td>
                 <td><?php echo $row['created'];?></td>
                <td><p>
					  <a  href="mypage_admin_street.php?edit=<?php echo$row['id'];?>&page=<?php echo $page;?>" class="portfolio-link" data-toggle="modal">수정  &nbsp;</a>
					<a href="mypage_admin_street.php?del=<?php echo$row['id'];?>">삭제하기</a></p></td>
                  </tr>
                     <?php }?>

                </tbody>
              </table>

              <!-- 클릭하면 modal창이 열림  -->
        		<a id="auto_modal" href="#portfolioModal"
            	class="portfolio-link" data-toggle="modal"></a>

               <!-- 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="mypage_admin_street.php?page=<?php

      if($_GET['page']>1){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']-1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#portfolio">Previous</a>
    </li>
       <?php
    // display the links to the pages
    for ($page=1; $page<=$number_of_pages; $page++) { // 페이지를 db에서 찾아서 전체를 뿌려준다. 위에 계산된대로
    	?>
    <!-- 페이지 숫자버튼  -->
    <li class="page-item"><a class="page-link"
    href="mypage_admin_street.php?page=<?php echo $page;?>"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="mypage_admin_street.php?page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>">Next</a>
    </li>
  </ul>
</nav>

            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>

      </div>
      <!-- /.container-fluid -->




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



		<!-- 스트릿팬션 사진 단일창  -->
  <div class="portfolio-modal modal fade" id="portfolioModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">

        <div class="container">
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="modal-body">
				<!-- 아이디값은 보이지않게 -->
              <input type="hidden" name="postid" value="<?php echo $id; ?>">
                <!-- 이름 -->
                <div>
                <h2 class="text-uppercase"><?php echo $name; ?></h2>
                <!-- 나이 -->
                <h5 class="text-uppercase">(<?php echo $age; ?>)</h5>
                </div>
               	<!-- 지역 -->
                <p class="item-intro text-muted"><?php echo $district; ?></p>
                <!-- 업로드날짜  -->
                <p class="item-intro text-muted"><?php echo $datetime; ?></p>


                <!-- 업로드 이미지 -->
                <img class="img-fluid d-block mx-auto" src="<?php echo $snapimg;?>" alt="">
                <!-- post! -->
                <p><?php echo $post;?></p>

                <ul class="list-inline">
                </ul>

              </div>


<div class="container">
<div class="row">
<div class="col-lg-12 text-center">
<h3 class="section-heading text-uppercase">수정하기</h3>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<form method="post" action="street.php" enctype="multipart/form-data">
<input type="hidden" name="id" value="<?php echo $id;?>">
<input type="hidden" name="page" value="<?php echo $currentPage;?>"> <!-- 현재페이지 -->
<div class="row">
<div class="col-md-6">
<!-- editor  -->

<!-- 이름 -->
<div class="form-group">
<input class="form-control" name="name" type="text" placeholder="Name *"
value="<?php echo $name;?>" >
<p class="help-block text-danger"></p>
</div>

<!-- 나이 -->
<div class="form-group">
<input class="form-control" name="age" type="text" placeholder="Age *"
value="<?php echo $age;?>" >
<p class="help-block text-danger"></p>
</div>

<!-- 지역 -->
<div class="form-group">
<input class="form-control" name="district" type="text" placeholder="District *"
value="<?php echo $district;?>" >
<p class="help-block text-danger"></p>
</div>
</div>

<!-- 포스트 -->
<div class="col-md-6">
<div class="form-group">
<textarea class="form-control" id="message" name="post" cols="30" rows="10"
placeholder="Post *"  style="resize: none;"><?php echo $post;?></textarea>
</div>
</div>
<div class="clearfix"></div>
<div class="col-lg-12 text-center">
<div id="success"></div>

	<!-- 이미지 업로드-->
	<div class= "form-group">
	<input type="file" name="snapimg_edit" accept="image/*" >
	<input type="hidden" name="snapimg_m" value="<?php echo $snapimg;?>">
	</div>


<!-- 수정완료버튼 -->
<button type="submit" name="update" class="btn btn-primary">수정완료</button>
   <!-- 닫기  -->
  <button class="btn btn-primary" data-dismiss="modal" type="button" onclick="history.back(-1);">
					 Close</button>



</div>
</div>
</form>
</div>
</div>
</div>


            </div>
          </div>
        </div>
      </div>
    </div>
  </div>



<!-- write창! 글작성하는 창 -->
<div class="portfolio-modal modal fade" id="portfolioWrite" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">
<div class="close-modal" data-dismiss="modal">
<div class="lr">
<div class="rl"></div>
</div>
</div>
<div class="container">
<div class="row">
<div class="col-lg-8 mx-auto">
<div class="modal-body">
<!-- Project Details Go Here -->
<h2 class="text-uppercase">게시물작성</h2>

<div class="container">
<div class="row">
<div class="col-lg-12 text-center">
</div>
</div>
<div class="row">
<div class="col-lg-12">
<form method="post" action="street.php" enctype="multipart/form-data">
<div class="row">
<div class="col-md-6">
<!-- editor  -->
<input type="hidden" name="id" value="<?php echo $id;?>">
<!-- 이름 -->
<div class="form-group">
<input class="form-control" name="name" type="text" placeholder="Name *"
required="required" data-validation-required-message="이름을 입력해주세요.">
<p class="help-block text-danger"></p>
</div>

<!-- 나이 -->
<div class="form-group">
<input class="form-control" name="age" type="text" placeholder="Age *"
required="required" data-validation-required-message="나이를 입력해주세요.">
<p class="help-block text-danger"></p>
</div>

<!-- 지역 -->
<div class="form-group">
<input class="form-control" name="district" type="text" placeholder="District *"
required="required" data-validation-required-message="지역을 입력해주세요.">
<p class="help-block text-danger"></p>
</div>
</div>

<!-- 포스트 -->
<div class="col-md-6">
<div class="form-group">
<textarea class="form-control" name="post" cols="30" rows="10"
placeholder="Post *"  style="resize: none;"
required="required" data-validation-required-message="포스트를 입력해주세요."
></textarea>
</div>
</div>
<div class="clearfix"></div>
<div class="col-lg-12 text-center">
<div id="success"></div>

	<!-- 이미지 업로드-->
	<div class= "form-group">
	<input type="file" name="snapimg" accept="image/*" >
	</div>


<!-- 수정완료버튼 -->
<button type="submit" name="save" class="btn btn-primary">업로드</button>
<button class="btn btn-primary" data-dismiss="modal" type="button">
Close</button>
</div>
</div>
</form>
</div>
</div>
</div>

</div>
</div>
</div>
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
