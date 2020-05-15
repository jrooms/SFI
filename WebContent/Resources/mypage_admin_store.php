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
$type="";
$name="";
$pirce="";
$size= array();
$post="";
$datetime="";
$id=0;
include('server_store.php');
include('server_store_cart.php');

if(!isset($_GET['wear_edit'])){
	echo
	"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#wear_table').css('display','none');
		});
		</script>";
}

if(!isset($_GET['shoes_edit'])){
	echo
	"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#shoes_table').css('display','none');
		});
		</script>";
}

if(!isset($_GET['acc_edit'])){
	echo
	"
		<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
		<script type='text/javascript'>

		$(document).ready(function(){
		$('#acc_table').css('display','none');
		});
		</script>";
}

// wear 페이징 처리
if(isset($_GET['wear_edit'])){
	//dfine how many results you want per page
	$results_per_page = 10;
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
if(isset($_GET['shoes_edit'])){
	//dfine how many results you want per page
	$results_per_page = 10;
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
if(isset($_GET['acc_edit'])){

	//dfine how many results you want per page
	$results_per_page = 10;
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
<!DOCTYPE html>
<html>
<head>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
//상품등록시 type 선택
function setValues(){
	var sh = document.getElementById("selectType");
	var tt = document.getElementById("textType");
	tt.value = sh.options[sh.selectedIndex].text;
}
//카트에 담을때 사이즈체크  의류일때
function setSize_wValues(){
	var sh = document.getElementById("selectSize_w");
	var tt = document.getElementById("textSize_w");
	tt.value = sh.options[sh.selectedIndex].text;
}
//카트에 담을때 사이즈체크 신발일때
function setSize_sValues(){
	var sh = document.getElementById("selectSize_s");
	var tt = document.getElementById("textSize_s");
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


<?php if(isset($_GET['wear_edit'])){?>
        <!-- DataTables Example -->
        <div class="card mb-3" id="wear_table" >
          <div class="card-header">
            <i class="fas fa-table"></i>
            	Wear</div>
          <div class="card-body">
                      	 <a  href="#uploadItem" class="portfolio-link" data-toggle="modal">상품등록  &nbsp;</a>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" style="table-layout:fixed">
                <thead>
                  <tr>
                  	<th>img</th>
                    <th>id</th>
                    <th>name</th>
                    <th>price</th>
                    <th>size</th>
                    <th>post</th>
                    <th>등록일</th>
                   <th>edit</th>
                  </tr>
                </thead>
                <tbody>

        <?php while ($row = mysqli_fetch_array($wearResults)){?>
                  <tr>
                      <td align="center"><img src="<?php echo $row['itemimg']; ?>" width="130" height="80"></td>
                    <td><?php echo$row['id'];?></td>
                     <td><?php echo$row['name'];?></td>
                    <td><?php echo$row['price'];?></td>
                    <td></td>
                     <td style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;">
                     <?php echo$row['post'];?></td>
                    <td><?php echo$row['datetime'];?></td>
					 <td><p>
					  <a  href="mypage_admin_store.php?item_w=<?php echo$row['id'];?>&type=<?php echo$row['type'];?>" class="portfolio-link" data-toggle="modal">수정  &nbsp;</a>
					<a href="store.php?del_w=<?php echo$row['id'];?>">삭제하기</a></p></td>
                  </tr>
                  <?php }?>

                </tbody>
              </table>


 <!-- wear 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="mypage_admin_store.php?wear_edit=1&page=<?php

      if($_GET['page']>1){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']-1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Previous</a>
    </li>
       <?php
    // display the links to the pages
    for ($page=1; $page<=$number_of_pages; $page++) { // 페이지를 db에서 찾아서 전체를 뿌려준다. 위에 계산된대로
    	?>
    <!-- 페이지 숫자버튼  -->
    <li class="page-item"><a class="page-link"
    href="mypage_admin_store.php?wear_edit=1&page=<?php echo $page;?>"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="mypage_admin_store.php?wear_edit=1&page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Next</a>
    </li>
  </ul>
</nav>

                                 <!-- 클릭하면 modal창이 열림  -->

            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
<?php }?>


    <?php if(isset($_GET['shoes_edit'])){?>
<!-- DataTables Example -->
        <div class="card mb-3" id="shoes_table" >
          <div class="card-header">
            <i class="fas fa-table"></i>
            	Shose</div>
          <div class="card-body">
           <a  href="#uploadItem" class="portfolio-link" data-toggle="modal">상품등록  &nbsp;</a>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" style="table-layout:fixed">
                <thead>
                  <tr>
                  	<th>img</th>
                    <th>id</th>
                    <th>name</th>
                    <th>price</th>
                    <th>size</th>
                    <th>post</th>
                    <th>datetime</th>
                   <th>edit</th>
                  </tr>
                </thead>
                <tbody>

        <?php while ($row = mysqli_fetch_array($shoesResults)){?>
                   <tr>
                      <td align="center"><img src="<?php echo $row['itemimg']; ?>" width="130" height="80"  ></td>
                    <td><?php echo$row['id'];?></td>
                     <td><?php echo$row['name'];?></td>
                    <td><?php echo$row['price'];?></td>
                    <td></td>
                     <td style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><?php echo$row['post'];?></td>
                    <td><?php echo$row['datetime'];?></td>
					 <td><p>
					  <a  href="mypage_admin_store.php?item_s=<?php echo$row['id'];?>&type=<?php echo$row['type'];?>" class="portfolio-link" data-toggle="modal">수정  &nbsp;</a>
					<a href="store.php?del_s=<?php echo$row['id'];?>">삭제하기</a></p>
                  </tr>
                  <?php }?>


                </tbody>
              </table>


           <!-- wear 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="mypage_admin_store.php?shoes_edit=1&page=<?php

      if($_GET['page']>1){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']-1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Previous</a>
    </li>
       <?php
    // display the links to the pages
    for ($page=1; $page<=$number_of_pages; $page++) { // 페이지를 db에서 찾아서 전체를 뿌려준다. 위에 계산된대로
    	?>
    <!-- 페이지 숫자버튼  -->
    <li class="page-item"><a class="page-link"
    href="mypage_admin_store.php?shoes_edit=1&page=<?php echo $page;?>"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="mypage_admin_store.php?shoes_edit=1&page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Next</a>
    </li>
  </ul>
</nav>


            </div>
          </div>



          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
  <?php }?>


 <?php if(isset($_GET['acc_edit'])){?>
<!-- DataTables Example -->
        <div class="card mb-3" id="acc_table" >
          <div class="card-header">
            <i class="fas fa-table"></i>
            	Acc</div>
          <div class="card-body">
          <a  href="#uploadItem" class="portfolio-link" data-toggle="modal">상품등록  &nbsp;</a>
            <div class="table-responsive">
              <table class="table table-bordered" id="dataTable" style="table-layout:fixed">
                <thead>
                  <tr>
                  	<th>img</th>
                    <th>id</th>
                    <th>name</th>
                    <th>price</th>
                    <th>size</th>
                    <th>post</th>
                    <th>datetime</th>
                  <th>edit</th>

                  </tr>
                </thead>
                <tbody>

        <?php while ($row = mysqli_fetch_array($accResults)){?>
                 <tr>
                      <td align="center"><img src="<?php echo $row['itemimg']; ?>" width="130" height="80"  ></td>
                    <td><?php echo$row['id'];?></td>
                     <td><?php echo$row['name'];?></td>
                    <td><?php echo$row['price'];?></td>
                    <td></td>
                     <td style="overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><?php echo$row['post'];?></td>
                    <td><?php echo$row['datetime'];?></td>
					 <td><p>
					  <a  href="mypage_admin_store.php?item_a=<?php echo$row['id'];?>&type=<?php echo$row['type'];?>" class="portfolio-link" data-toggle="modal">수정  &nbsp;</a>
					<a href="store.php?del_a=<?php echo$row['id'];?>">삭제하기</a></p>
                  </tr>
                  <?php }?>


                </tbody>
              </table>

               <!-- wear 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="mypage_admin_store.php?acc_edit=1&page=<?php

      if($_GET['page']>1){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']-1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Previous</a>
    </li>
       <?php
    // display the links to the pages
    for ($page=1; $page<=$number_of_pages; $page++) { // 페이지를 db에서 찾아서 전체를 뿌려준다. 위에 계산된대로
    	?>
    <!-- 페이지 숫자버튼  -->
    <li class="page-item"><a class="page-link"
    href="mypage_admin_store.php?acc_edit=1&page=<?php echo $page;?>"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="mypage_admin_store.php?acc_edit=1&page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Next</a>
    </li>
  </ul>
</nav>

            </div>
          </div>
          <div class="card-footer small text-muted">Updated yesterday at 11:59 PM</div>
        </div>
   <?php }?>
      </div>
      <!-- /.container-fluid -->

                  <!-- 클릭하면 modal창이 열림  -->
        		<a id="auto_a" href="#itemModal"
            	class="portfolio-link" data-toggle="modal"></a>
            	                  <!-- 클릭하면 modal창이 열림  -->
        		<a id="auto_s" href="#itemModal"
            	class="portfolio-link" data-toggle="modal"></a>
            	<a id="auto_w" href="#itemModal"
            	class="portfolio-link" data-toggle="modal"></a>


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


  <!--상품등록 모델 -->
<div class="portfolio-modal modal fade" id="uploadItem" tabindex="-1" role="dialog" aria-hidden="true">
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
<h2 class="text-uppercase">상품등록</h2>

<div class="container">
<div class="row">
<div class="col-lg-12 text-center">
</div>
</div>
<div class="row">
<div class="col-lg-12">
<form method="post" action="store.php" enctype="multipart/form-data">
<div class="row">
<div class="col-md-6">


<!-- 종류 -->
<div class="form-group">
<table>
    <tr>
	<td colspan="1">
	Type
	</td>
    </tr>
    <tr>
	<td valign="top">  <!-- 의류,신발,악세사리중 하나를 고른다.  -->
	<!-- 선택된 값이 자바스크립트에서 setvalues()메소드를 통해 아래에있는 type에 입려된다. -->
		<select id="selectType" size="1" onChange="setValues();">
			<option value="wear">wear</option>
			<option value="shoes">shoes</option>
			<option value="acc">acc</option>
		</select>
	</td>
    </tr>
</table>
</div>
<input type="hidden" name="type" id="textType" value="wear">

<!-- 이름 -->
<div class="form-group">
<input class="form-control" name="name" type="text" placeholder="Name *"
required="required" data-validation-required-message="이름을 입력해주세요.">
<p class="help-block text-danger"></p>
</div>

<!-- 가격 -->
<div class="form-group">
<input class="form-control" name="price" type="number" placeholder="Price *"
required="required" data-validation-required-message="가격을 입력해주세요.">
<p class="help-block text-danger"></p>
</div>

</div>
<input type="hidden" name="size" value="wear">

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
	<input type="file" name="itemimg" accept="image/*" >
	</div>


<!-- 업로드버튼 -->
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




<!--아이템 모델  -->
<div class="portfolio-modal modal fade" id="itemModal" tabindex="-1" role="dialog" aria-hidden="true">
<div class="modal-dialog">
<div class="modal-content">

<div class="close-modal" data-dismiss="modal"  onclick="history.back(-1);">
<div class="lr">
<div class="rl"></div>
</div>
</div>

<div class="container">
<div class="row">
<div class="col-lg-8 mx-auto">
<div class="modal-body">
      <!-- /.col-lg-3 -->
<form method="post" action="store.php" enctype="multipart/form-data">

        <div class="card mt-4">
          <img class="card-img-top img-fluid" src="<?php echo $itemimg; ?>" alt="">
          <div class="card-body">
            <h3 class="card-title"><?php echo $name; ?></h3>
            <h4><?php echo $price; ?> 원</h4>
            <p class="card-text"><?php echo $post; ?></p>

    </div>
        <h3 >수정하기</h3>

<!-- 종류 -->
<div class="form-group">
<table>
    <tr>
	<td colspan="1">
	Type
	</td>
    </tr>
    <tr>
	<td valign="top">  <!-- 의류,신발,악세사리중 하나를 고른다.  -->
	<!-- 선택된 값이 자바스크립트에서 setvalues()메소드를 통해 아래에있는 type에 입려된다. -->
		<select id="selectType" size="1" onChange="setValues();">
			<option value="<?php echo $type;?>"><?php echo $type;?></option>
		</select>
	</td>
    </tr>
</table>
</div>
<input type="hidden" name="type" id="textType" value="<?php echo $type;?>">
<input type="hidden" name="page" value="<?php echo $currentPage; ?>">
<input type="hidden" name="id" value="<?php echo $id; ?>">


<!-- 이름 -->
<div class="form-group">
<input class="form-control" name="name" type="text" placeholder="Name *"
value="<?php echo $name;?>"
required="required" data-validation-required-message="이름을 입력해주세요.">
<p class="help-block text-danger"></p>
</div>

<!-- 가격 -->
<div class="form-group">
<input class="form-control" name="price" type="number" placeholder="Price *"
value="<?php echo $price;?>"
required="required" data-validation-required-message="가격을 입력해주세요.">
<p class="help-block text-danger"></p>
</div>

</div>
<input type="hidden" name="size">

<!-- 포스트 -->

<div class="form-group">
<textarea class="form-control" name="post" cols="80" rows="10"
placeholder="Post *"  style="resize: none;"
><?php echo $post;?></textarea>
</div>



	<!-- 이미지 업로드-->
	<div class= "form-group">
	<input type="file" name="itemimg_edit" accept="image/*" >
	<input type="hidden" name="itemimg_m" value="<?php echo $itemimg;?>">
	</div>

  <button type="submit" name="update" class="btn btn-primary">수정</button>
<button class="btn btn-primary" data-dismiss="modal" type="button" onclick="history.back(-1);">
Close</button>

      <!-- /.col-lg-9 -->
  <!-- /.container -->
</form>
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
