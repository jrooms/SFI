<?php include('server_admin.php');
session_start();

// 현재 로그인한 회원이 있으면
if(isset($_SESSION['email'])){
	$guestUser = false;
	if($_SESSION['email']==$admin){
		$adminUser = true;
	}
}
?>
<!DOCTYPE html>
<html lang="">
<head>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<meta name="description" content="Sports brands, Sports fashion, Sports team">
<meta name="author" content="Jeong-Hun Kim">

<title>SFI - Sprots Fshion Item</title>

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
<div class="intro-lead-in">Sports Fashion Item</div>
<div class="intro-heading text-uppercase">SFI</div>
<a class="btn btn-primary btn-xl text-uppercase js-scroll-trigger" href="#services">둘러보기</a>
</div>
</div>
</header>

<!-- Item 소개화면  -->
<section id="services">
<div class="container">
<div class="row">
<div class="col-lg-12 text-center">
<h2 class="section-heading text-uppercase">SFI의 다양한정보</h2>
<h3 class="section-subheading text-muted">쇼핑, 스포츠정보, 스트릿패션을 확인해보세요.</h3>
</div>
</div>
<div class="row text-center">
<div class="col-md-4" OnClick="location.href='shopping.php#shopping'">
<span class="fa-stack fa-4x">
<i class="fas fa-circle fa-stack-2x text-primary"></i>
<i class="fas fa-shopping-cart fa-stack-1x fa-inverse"></i>
</span>
<h4 class="service-heading">Shopping</h4>
<p class="text-muted"></p>
</div>
<div class="col-md-4" OnClick="location.href='info.php#info'">
<span class="fa-stack fa-4x">
<i class="fas fa-circle fa-stack-2x text-primary"></i>
<i class="fas fa-info fa-stack-1x fa-inverse"></i>
</span>
<h4 class="service-heading">Sports Info</h4>
<p class="text-muted"></p>
</div>
<div class="col-md-4" OnClick="location.href='street.php?page=1#portfolio'">
<span class="fa-stack fa-4x">
<i class="fas fa-circle fa-stack-2x text-primary"></i>
<i class="fas fa-camera fa-stack-1x fa-inverse"></i>
</span>
<h4 class="service-heading">Street Fashion</h4>
<p class="text-muted"></p>
</div>
</div>
</div>
</section>

<!-- About -->
<section id="about">
<div class="container">
<div class="row">
<div class="col-lg-12 text-center">
<h2 class="section-heading text-uppercase">ABOUT</h2>
<h3 class="section-subheading text-muted">Sports Fashion Item</h3>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<ul class="timeline">
<li>
<div class="timeline-image">
<img class="rounded-circle img-fluid" src="img/about/1.jpg" alt="">
</div>
<div class="timeline-panel">
<div class="timeline-heading">
<h4 class="subheading">Street Fashion / Sports Item</h4>
</div>
<div class="timeline-body">
<p class="text-muted">SFI에서 소개하고 판매되는 의류, 신발, ACC등의 다양한 아이템들은 스트릿패션 카테고리안에 포함되어있는 제품입니다. 제품의 기능에 기준을 두고 소개하고 판매하지 않습니다. </p>
</div>
</div>
</li>
<li class="timeline-inverted">
<div class="timeline-image">
<img class="rounded-circle img-fluid" src="img/about/2.jpg" alt="">
</div>
<div class="timeline-panel">
<div class="timeline-heading">
<h4 class="subheading">Sports team / Sponsors</h4>
</div>
<div class="timeline-body">
<p class="text-muted">스포츠의 종류, 리그를 구분하지않고 어떠한 곳에서든 의류, 신발, ACC 항목의 스폰서쉽을 계약하고 있는 브랜드의 제품을 소개하고 판매하는 것이 SFI의 방향성입니다.</p>
</div>
</div>
</li>
<li>
<div class="timeline-image">
<img class="rounded-circle img-fluid" src="img/about/3.jpg" alt="">
</div>
<div class="timeline-panel">
<div class="timeline-heading">
<h4 class="subheading">Street Photo / Sports Item</h4>
</div>
<div class="timeline-body">
<p class="text-muted">스포츠 브랜드의 아이템을 1개이상 착용한 분들의 사진을 담아 소개합니다. 센스있는 패션피플들을 만나보세요!</p>
</div>
</div>
</li>
<li class="timeline-inverted">
<div class="timeline-image">
<img class="rounded-circle img-fluid" src="img/about/4.jpg" alt="">
</div>
<div class="timeline-panel">
<div class="timeline-heading">
<h4 class="subheading">Sports Brand / Team News</h4>
</div>
<div class="timeline-body">
<p class="text-muted">스포츠 브랜드와 그들과 계약한 전세계 다양한 리그의 스포츠팀 정보와 뉴스를 확인하세요!</p>
</div>
</div>
</li>
<li class="timeline-inverted">
<div class="timeline-image">
<h4>Sports
<br>Fashion
<br>Item!</h4>
</div>
</li>
</ul>
</div>
</div>
</div>
</section>

<!-- Contact -->
<section id="contact">
<div class="container">
<div class="row">
<div class="col-lg-12 text-center">
<h2 class="section-heading text-uppercase">문의하기</h2>
<h3 class="section-subheading text-muted">여러분들의 문의사항을 보내주세요.</h3>
</div>
</div>
<div class="row">
<div class="col-lg-12">
<form id="contactForm" name="sentMessage" novalidate="novalidate">
<div class="row">
<div class="col-md-6">
<div class="form-group">
<input class="form-control" id="name" type="text" placeholder="Your Name *" required="required" data-validation-required-message="이름을 입력해주세요.">
<p class="help-block text-danger"></p>
</div>
<div class="form-group">
<input class="form-control" id="email" type="email" placeholder="Your Email *" required="required" data-validation-required-message="email주소를 입력해주세요">
<p class="help-block text-danger"></p>
</div>
<div class="form-group">
<input class="form-control" id="phone" type="tel" placeholder="Your Phone *" required="required" data-validation-required-message="전화번호를 입력해주세요.">
<p class="help-block text-danger"></p>
</div>
</div>
<div class="col-md-6">
<div class="form-group">
<textarea class="form-control" id="message" placeholder="Your Message *" required="required" data-validation-required-message="메세지를 입력해주세요."></textarea>
<p class="help-block text-danger"></p>
</div>
</div>
<div class="clearfix"></div>
<div class="col-lg-12 text-center">
<div id="success"></div>
<button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Send Message</button>
</div>
</div>
</form>
</div>
</div>
</div>
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

<!-- Modal 1 -->
<div class="portfolio-modal modal fade" id="portfolioModal1" tabindex="-1" role="dialog" aria-hidden="true">
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
<h2 class="text-uppercase">Project Name</h2>
<p class="item-intro text-muted">Lorem ipsum dolor sit amet consectetur.</p>
<img class="img-fluid d-block mx-auto" src="img/portfolio/01-full.jpg" alt="">
<p>Use this area to describe your project. Lorem ipsum dolor sit amet, consectetur adipisicing elit. Est blanditiis dolorem culpa incidunt minus dignissimos deserunt repellat aperiam quasi sunt officia expedita beatae cupiditate, maiores repudiandae, nostrum, reiciendis facere nemo!</p>
<ul class="list-inline">
<li>Date: January 2017</li>
<li>Client: Threads</li>
<li>Category: Illustration</li>
</ul>
<button class="btn btn-primary" data-dismiss="modal" type="button">
<i class="fas fa-times"></i>
Close Project</button>
</div>
</div>
</div>
</div>
</div>
</div>
</div>

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
