<?php 
session_start();	
$guestUser = true;
$admin = "admin@admin.com";
$adminUser = false;
// 현재 로그인한 회원이 있으면
if(isset($_SESSION['email'])){
	$guestUser = false;
	if($_SESSION['email']==$admin){
		$adminUser = true;
	}
}
?>
<!DOCTYPE html>
<html>
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Sports brands, Sports fashion, Sports team">
<meta name="author" content="Jeong-Hun Kim">

<title>SFI - Sprots Info</title>

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
<a class="nav-link js-scroll-trigger" href="mypage.php#mypage">마이페이지</a>
</li>
<?php } else{?>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="mypage.php#mypage" >관리페이지</a>
</li>
<?php }?>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" OnClick="location.href='store.php?wear=1&page=1#store'"
style="cursor:pointer">Fashion Store</a>
</li>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" OnClick="location.href='street.php?page=1#portfolio'"
style="cursor:pointer">Street Fashion</a>
</li>
<li class="nav-item">
<a class="nav-link js-scroll-trigger" href="info.php#info"style=color:#fed136;>Sports Info</a>
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

<!-- Team -->
<section class="bg-light" id="info">
info page
</section>

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