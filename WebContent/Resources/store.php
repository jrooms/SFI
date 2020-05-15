<?php
include('server_admin.php');
include('server_db.php');
session_start();
// 현재 로그인한 회원이 있으면
if(isset($_SESSION['email'])){
	$guestUser = false;
	if($_SESSION['email']==$admin){
		$adminUser = true;
	}
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


//댓글
$(function(){

	setInterval(function(){
		var id = $('.id').val();
		var type = $('.type').val();
		var page = $('.page').val();
			$.ajax({
				url:'store_fetch_comment.php',
				data:'typeID='+type+id+'&type='+type+'&id='+id+'&page='+page,
				type:'post',
					success:function(res){
						$('.comment_listing').html(res);
						}
			})
		},100); // n초뒤 실행
	$('.submit').click(function() {
		var email = $('.email').val();
		var name = $('.name').val();
		var comment = $('.comment').val();
		var id = $('.id').val();
		var type = $('.type').val();
		var item = $('.item').val();
		$.ajax({
			url:'store_add_comment.php',
			data:'email='+email+'&name='+name+'&comment='+comment+'&typeID='+type+id+'&item='+item+'&id='+id+'&type='+type,
			type:'post',
			success:function(){
				alert("문의글을 작성하였습니다.");
				$.ajax({
					url:'store_fetch_comment.php',
						success:function(res){
							$('.comment_listing').html(res);
							}
				})
			}
		})
	})
})
</script>


<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Sports brands, Sports fashion, Sports team">
<meta name="author" content="Jeong-Hun Kim">

<title >SFI - Shopping</title>

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
<a class="nav-link js-scroll-trigger" href="mypage.php#mypage" >마이페이지</a>
</li>
<?php } else{?>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="mypage.php#mypage" >관리페이지</a>
</li>
<?php }?>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="store.php#store" style=color:#fed136;>Fashion Store</a>
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

<li class="nav-item">
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


<!-- Team -->
<section class="bg-light" id="store">

<!-- Page Content -->
  <div class="container">

    <div class="row">

      <div class="col-lg-3">

        <h1 class="my-4">SFI Store</h1>
 <div class="list-group" >
         <!-- WEAR 버튼 -->
	 <a href="store.php?wear=1&page=1#store" class="list-group-item"
	 <?php if(isset($_GET['wear'])){?>
	 style="background-color:#212529;"<?php }?> >
        Wear
          </a>
          <!-- SHOES버튼 -->
           <a href="store.php?shoes=1&page=1#store" class="list-group-item"
	 <?php if(isset($_GET['shoes'])){?>
	 style="background-color:#212529;"<?php }?> >
        Shoes
          </a>
          <!-- ACC버튼 -->
           <a href="store.php?acc=1&page=1#store" class="list-group-item"
	 <?php if(isset($_GET['acc'])){?>
	 style="background-color:#212529;"<?php }?> >
        ACC
          </a>
        </div>

      </div>
      <!-- /.col-lg-3 -->
		<!-- 광고판 -->
      <div class="col-lg-9">
                <?php if($adminUser == true) {?>
				<a  href="#mainBannerEdit"
            	class="portfolio-link" data-toggle="modal">광고이미지 변경  &nbsp;</a>
            	<?php }?>
        <div id="carouselExampleIndicators" class="carousel slide my-4" data-ride="carousel">
          <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
          </ol>

          <div class="carousel-inner" role="listbox">
            <div class="carousel-item active">
              <img class="d-block img-fluid" style="display: block; margin: 0 auto; width: 100%;" src="<?php echo $bannerimg1;?>" alt="First slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" style="display: block; margin: 0 auto; width: 100%;" src="<?php echo $bannerimg2;?>" alt="Second slide">
            </div>
            <div class="carousel-item">
              <img class="d-block img-fluid" style="display: block; margin: 0 auto; width: 100%;" src="<?php echo $bannerimg3;?>" alt="Third slide">
            </div>
          </div>
          <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
          </a>
          <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
          </a>
        </div>

<!-- 아이템   -->
        <div class="row">
<!-- wear -->
<!-- 의류 리스트 깔아주기  -->
<?php if(isset($_GET['wear'])) {?>

 <?php while ($row = mysqli_fetch_array($wearResults)){?>

          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
             <a class="portfolio-link" data-toggle="modal"
          href="store.php?wear=1&item_w=<?php echo$row['id'];?>&page=<?php echo $page;?>">
              <img class="card-img-top" src="<?php echo $row['itemimg'];?>" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
              <?php echo$row['name'];?>
                </h4>
                <h5><?php echo$row['price'];?>원</h5>

              </div>
              <!-- 클릭하면 modal창이 열림  -->
        		<a id="auto_w" href="#itemModal"
            	class="portfolio-link" data-toggle="modal"></a>
<!--               <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div> -->
            </div>
          </div>
	<?php }?>
	<!-- shoes리스트 깔아주기  -->
	<?php } else if(isset($_GET['shoes'])){?>

<?php while ($row = mysqli_fetch_array($shoesResults)){?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
             <a class="portfolio-link" data-toggle="modal"
          href="store.php?shoes=1&item_s=<?php echo$row['id'];?>&page=<?php echo $page;?>">
              <img class="card-img-top" src="<?php echo $row['itemimg'];?>" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                 <?php echo$row['name'];?>
                </h4>
                <h5><?php echo$row['price'];?>원</h5>

              </div>
              <a id="auto_s" href="#itemModal"
            	class="portfolio-link" data-toggle="modal"></a>
<!--               <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div> -->
            </div>
          </div>
	<?php }?>

	<?php } else if(isset($_GET['acc'])){?>

	<?php while ($row = mysqli_fetch_array($accResults)){?>
          <div class="col-lg-4 col-md-6 mb-4">
            <div class="card h-100">
           <a class="portfolio-link" data-toggle="modal"
          href="store.php?acc=1&item_a=<?php echo$row['id'];?>&page=<?php echo $page;?>">
              <img class="card-img-top" src="<?php echo $row['itemimg'];?>" alt=""></a>
              <div class="card-body">
                <h4 class="card-title">
                <?php echo$row['name'];?>
                </h4>
                <h5><?php echo$row['price'];?>원</h5>

              </div>
              <a id="auto_a" href="#itemModal"
            	class="portfolio-link" data-toggle="modal"></a>
<!--               <div class="card-footer">
                <small class="text-muted">&#9733; &#9733; &#9733; &#9733; &#9734;</small>
              </div> -->
            </div>
          </div>
	<?php }?>

	<?php }?>
        </div>

      </div>
      <!-- /.col-lg-9 -->

    </div>


    <!-- /.row -->

    <?php if(isset($_GET['wear'])) {?>
 <!-- wear 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="store.php?wear=1&page=<?php

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
    href="store.php?wear=1&page=<?php echo $page;?>#store"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="store.php?wear=1&page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Next</a>
    </li>
  </ul>
</nav>
<?php }?>



    <?php if(isset($_GET['shoes'])) {?>
 <!-- shoes 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="store.php?shoes=1&page=<?php

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
    href="store.php?shoes=1&page=<?php echo $page;?>#store"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="store.php?shoes=1&page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Next</a>
    </li>
  </ul>
</nav>
<?php }?>

<!--  -->
    <?php if(isset($_GET['acc'])) {?>
 <!-- acc 패이지 분리  -->
<nav aria-label="Page navigation example">
  <ul class="pagination justify-content-end">

	<!-- 이전페이지 -->
	 <li class="page-item">
      <a class="page-link" href="store.php?acc=1&page=<?php

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
    href="store.php?acc=1&page=<?php echo $page;?>#store"><?php

    if($page==$_GET['page']){
    	echo '<span style="color:red;">'.$page.'</span><br />'; // 현재페이지와 숫자가 같으면 색상이 빨간색이된다.
    }else{
    	echo $page; // 아니면 그대로 파란색으로
    }
   	?></a></li>

      <?php  }?>
      <!-- 다음페이지  -->
    <li class="page-item">
      <a class="page-link" href="store.php?acc=1&page=<?php

      if($_GET['page']+1<=$number_of_pages){ //현재페이지가 전체페이지보다 작거나 같을때에만
      	echo $_GET['page']+1; // 현재페이지에서 1을 더해주고
      }else{
      	echo $_GET['page']; //아닐경우에는 그대로 둔다.
      }
      ?>#store">Next</a>
    </li>
  </ul>
</nav>
<?php }?>


  </div>
  <!-- /.container -->


</section>




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

 <?php if( $adminUser != true) {?>
        <div class="card card-outline-secondary my-4">
          <div class="card-header">
            	구매하기
          </div>
          <div class="card-body">
         <!--    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Omnis et enim aperiam inventore, similique necessitatibus neque non! Doloribus, modi sapiente laboriosam aperiam fugiat laborum. Sequi mollitia, necessitatibus quae sint natus.</p>
            <small class="text-muted">Posted by Anonymous on 3/1/17</small>
            <hr> -->
            <!-- 종류 -->
		<table style="margin:auto; ">
    			<tr>
				<td colspan="1">
				</td>
    			</tr>
    			<tr>
				<td valign="top">  <!-- 의류,신발,악세사리중 하나를 고른다.  -->
	<!-- 선택된 값이 자바스크립트에서 setvalues()메소드를 통해 아래에있는 type에 입려된다. -->
					상품명  <select id="selectName" size="1" >
						<option value="<?php echo $name;?>"><?php echo $name;?></option>
					</select>
				</td>
    			</tr>
			</table>
<!-- 사이즈선택   -->
<!-- 의류일때  -->
<?php if($type=="wear") {?>
		<table style="margin:auto; ">
    			<tr>
				<td colspan="1">
				</td>
    			</tr>
    			<tr>
				<td valign="top">  <!-- 의류,신발,악세사리중 하나를 고른다.  -->
	<!-- 선택된 값이 자바스크립트에서 setvalues()메소드를 통해 아래에있는 type에 입려된다. -->
					SIZE  <select id="selectSize_w" size="1" onChange="setSize_wValues();">
						<option value="S">S</option>
						<option value="M">M</option>
						<option value="L">L</option>
						<option value="XL">XL</option>
						<option value="XXL">XXL</option>
					</select>
				</td>
    			</tr>
			</table>
<?php }?>
<!-- 신발일때  -->
<?php if($type=="shoes") {?>
		<table style="margin:auto; ">
    			<tr>
				<td colspan="1">
				</td>
    			</tr>
    			<tr>
				<td valign="top">  <!-- 의류,신발,악세사리중 하나를 고른다.  -->
	<!-- 선택된 값이 자바스크립트에서 setvalues()메소드를 통해 아래에있는 type에 입려된다. -->
					SIZE  <select id="selectSize_s" size="1" onChange="setSize_sValues();">
						<option value="220">220</option>
						<option value="220">230</option>
						<option value="220">240</option>
						<option value="220">250</option>
						<option value="220">260</option>
						<option value="220">270</option>
						<option value="220">280</option>
						<option value="220">290</option>
					</select>
				</td>
    			</tr>
			</table>
<?php }?>
			<input type="hidden" name="hd_page" value="<?php echo $_GET['page'];?>">
 			<input type="hidden" name="hd_type_id" value="<?php echo $type;?><?php echo $id;?>">
 			<input type="hidden" name="hd_id" value="<?php echo $id;?>">
 			<input type="hidden" name="hd_name" value="<?php echo $name; ?>">
 			<input type="hidden" name="hd_type" value="<?php echo $type;?>">
 			<input type="hidden" name="hd_itemimg" value="<?php echo $itemimg; ?>">
 			<input type="hidden" name="hd_price" value="<?php echo $price; ?>">
			<input type="hidden" name="size_w" id="textSize_w" value="S">
            <input type="hidden" name="size_s" id="textSize_s" value="220">
         <p> 수량  <input type="number" min="0" max="100" name="quantity" value="1"></p>
         <?php if($guestUser == false && $adminUser != true ){?>
         <button type="submit" name="add_to_cart_user" class="btn btn-success">Cart</button>
          <?php } else {?>
		<button type="submit" name="add_to_cart" class="btn btn-success">Cart</button>
			<?php }?>
          </div>
        </div>
<?php }?>
		<!-- 문의하기  -->


<?php  if($guestUser == false && $adminUser != true) { ?>
		<div class="comment_listing"></div>
		<input type="text" class="email form-control" value="<?php echo $_SESSION['email'];?>" readonly>
		<input type="hidden" class="name form-control" value="
		<?php
		$e = $_SESSION['email'];
		$r = mysqli_query($db,
				"SELECT * FROM users WHERE email = '".$e."'");
					while($row=mysqli_fetch_object($r)){
						echo $row->username;
					}
		?>">
		<input type="hidden" class="type form-control" value="<?php echo $type;?>">
		<input type="hidden" class="id form-control" value="<?php echo $id;?>">
		<input type="hidden" class="item form-control" value="<?php echo $name;?>">
		<input type="hidden" class="page form-control" value="<?php echo $_GET['page'];?>">
		<textarea class="comment form-control" placeholder="Enter Comment" rows="5"></textarea>
		<a class="submit" href="javascript:void(0)" style="align:right;">문의하기</a>
        <div class="clearfix"></div>
        <?php } else {?>
        <div class="comment_listing"></div>
		<input type="hidden" class="type form-control" value="<?php echo $type;?>">
		<input type="hidden" class="id form-control" value="<?php echo $id;?>">
	<?php }?>
</div>
</div>
</form>
<button class="btn btn-primary" data-dismiss="modal" type="button" onclick="history.back(-1);">
Close</button>



</div>
</div>
</div>
</div>
</div>
</div>
</div>



<!--광고베너 변경 모델  -->
<div class="portfolio-modal modal fade" id="mainBannerEdit" tabindex="-1" role="dialog" aria-hidden="true">
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
<form method="post" action="store.php" enctype="multipart/form-data">
<div class="modal-body">
<!-- Project Details Go Here -->
<h2 class="text-uppercase">광고이미지변경</h2>

	<!-- 이미지 업로드3-->
	<img class="card-img-top img-fluid" src="<?php echo $bannerimg1;?>" alt="">
	<div class= "form-group">
	첫번째이미지
	<input type="file" name="bannerimg1" accept="image/*" >
	</div>

<!-- 이미지 업로드2-->
	<img class="card-img-top img-fluid" src="<?php echo $bannerimg2;?>" alt="">
	<div class= "form-group">
	두번째이미지
	<input type="file" name="bannerimg2" accept="image/*" >
	</div>
	<!-- 이미지 업로드4-->
	<img class="card-img-top img-fluid" src="<?php echo $bannerimg3;?>" alt="">
	<div class= "form-group">
	세번째이미지
	<input type="file" name="bannerimg3" accept="image/*" >
	</div>

<button type="submit" name="update_banner" class="btn btn-primary">완료</button>
<button class="btn btn-primary" data-dismiss="modal" type="button">
Close</button>
</div>
</form>
</div>
</div>
</div>
</div>
</div></div>


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
</html>
