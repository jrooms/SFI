<?php
include('server_street.php');
include('server_admin.php');
include('server_db.php');
session_start();
// 현재 로그인한 회원이라면
if(isset($_SESSION['email'])){
	$guestUser = false;
	// 로그인한 회원의 이메일이 관리자 이메일과 동일하다면
	if($_SESSION['email']==$admin){
		$adminUser = true;
	}
}
// fetch the record to be updated
	if(isset($_GET['edit'])) {
		# code ...
		$id = $_GET['edit'];
		//조회수 추가
		$hitrec = mysqli_query($db,"UPDATE snap set hit=hit+1 WHERE id=$id");
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
	$results_per_page = 9;
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

<script type="text/javascript">



/* 좋아요하트 */
var state = 0;
function changeImage() {
	if(state == 0){
		document.like_btn.src = "img/like_false.png"
			state = 1;
		return false;
} else {
		document.like_btn.src = "img/like.png"
		state = 0;
}
}

</script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Sports brands, Sports fashion, Sports team">
<meta name="author" content="Jeong-Hun Kim">

<title>SFI - Street Photo</title>

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



<body id="page-top">

<!-- Navigation 메뉴항목  -->
<nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
<div class="container">
<a class="navbar-brand js-scroll-trigger" href="index.php">Sports Fashion Item</a>
<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
Menu
<i class="fas fa-bars"></i>
</button>

<div class="collapse navbar-collapse" id="navbarResponsive">
<ul class="navbar-nav text-uppercase ml-auto">

<?php if($adminUser != true ) {?>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="mypage.php#mypage">마이페이지</a>
</li>
<?php } else{?>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="mypage.php#mypage" >관리페이지</a>
</li>
<?php }?>

<!-- 패션아이템 -->
<li class="nav-item">
<a class="nav-link js-scroll-trigger"  OnClick="location.href='store.php?wear=1&page=1#store'"
style="cursor:pointer">Fashion Store</a>
</li>
<!--스트릿포토 -->
<li class="nav-item">
<a class="nav-link js-scroll-trigger"  href="street.php#portfolio"
style=color:#fed136>Street Fashion</a>
</li>
<!-- 스포츠인포 -->
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="info.php#info">Sports Info</a>
</li>
<!-- 어바웃 -->
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




 <!-- 스트릿 패션사지 grid 형식으로 3x3 총 9개씩 보여준다. -->
  <section class="bg-light" id="portfolio">
<!-- 제목 -->
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-uppercase">Street Fashion</h2>
          <h3 class="section-subheading text-muted">다양한 사람들을 만나보세요.</h3>
        </div>
     </div>

     <!-- 스냅사진 모델 street 페이지에 표시 -->
     <!-- snap 테이블에 있는 모든 정보를 가져와서 보여준다.  -->
      <div class="row">

      <?php while ($row = mysqli_fetch_array($result)){?>
        <div  class="col-md-4 col-sm-6 portfolio-item">
          <a class="portfolio-link" data-toggle="modal"
          href="street.php?edit=<?php echo$row['id'];?>&page=<?php echo $page; ?>">

 			<div class="portfolio-hover">
              <div class="portfolio-hover-content">
                <i  class="fas fa-plus fa-3x"></i>
              </div>
            </div>
            <!-- 이미지사진 -->
            <img class="img-fluid" src="<?php echo $row['snapimg'];?>" alt="">
          </a>

          <div class="portfolio-caption">
          <!-- 이름,나이,지역,올린날짜  -->
            <h4><?php echo $row['name'];?></h4>
            <h6>(<?php echo $row['age'];?>)</h6>
            <p class="text-muted"><?php echo $row['district'];?></p>
            <p><a><?php echo$row['created'];?></a></p>
          </div>
       			<!-- 클릭하면 modal창이 열림  -->
        		<a id="auto_modal" href="#portfolioModal"
            	class="portfolio-link" data-toggle="modal"></a>

        </div>
       <?php }?>
      </div>


 <!-- 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="street.php?page=<?php

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
    href="street.php?page=<?php echo $page;?>#portfolio"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="street.php?page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#portfolio">Next</a>
    </li>
  </ul>
</nav>

    </div>
  </section>



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

              <button class="btn btn-primary" data-dismiss="modal" type="button" onclick="history.back(-1);">
					 Close</button>


              </div>
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
</body>
</html>
