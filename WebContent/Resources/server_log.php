<?php
include('server_db.php');
session_start();
$username="";
$email="";
$errors=array();

//비회원 장바구니 회원한테 넘겨주기


if(isset($_COOKIE['shopping_cart'])){

$total = 0;
$cookie_data = stripslashes($_COOKIE['shopping_cart']);
$cart_data = json_decode($cookie_data, true);
	foreach($cart_data as $keys => $values) {

		$i_type_id = $values['item_type_id'];
		$i_name = $values['item_name'];
		$i_price = $values['item_price'];
		$i_size = $values['item_size'];
		$i_quantity = $values['item_quantity'];
		$i_page = $values['item_page'];
		$i_img = $values['item_img'];
		$i_t = $values['item_t'];
		$i_id = $values['item_name'];
		$i_type = $values['item_name'];
		$total =$total + $values['item_quantity']*$values['item_price'];

		if(isset($_SESSION['shopping_cart'])){
			$item_array_id = array_column($_SESSION['shopping_cart'], 'item_type_id');
			// in_array함수는 배열에 항목이 있으면 true를 반환한다.
			if(!in_array($i_type_id,$item_array_id)){
				$count = count($_SESSION['shopping_cart']);
				$item_array = array (
						'item_type_id'	=> 		$i_type_id,
						'item_name'		=>  $i_name,
						'item_price'   =>   $i_price,
						'item_img'	=>		$i_img,
						'item_quantity'	 => $i_quantity,
						'item_size'	=>  $i_size,
						'item_type' =>  $i_type,
						'item_id' => $i_id,
						'item_page' => $i_page,
						'item_t' => $i_t
				);
				$_SESSION['shopping_cart'][$count] = $item_array;
			}
		} else {

			$item_array = array (
					'item_type_id'	=> 		$i_type_id,
					'item_name'		=>  $i_name,
					'item_price'   =>   $i_price,
					'item_img'	=>		$i_img,
					'item_quantity'	 => $i_quantity,
					'item_size'	=>  $i_size,
					'item_type' =>  $i_type,
					'item_id' => $i_id,
					'item_page' => $i_page,
					'item_t' => $i_t
			);

			$_SESSION['shopping_cart'][0] = $item_array;

		}

	}

	}


//로그인
	if (isset($_POST['login'])) {
		$email = $db -> real_escape_string($_POST['email']);
		$password = $db -> real_escape_string($_POST['password']);
		// ensure that form fields are filled properly
		if (empty($password)) {
			array_push($errors, "비밀번호를 입력해주세요");
		}
		if(count($errors)==0){

			// encrypt password before comparing with that from database
			$password = md5($password);
			$query = "SELECT * FROM users WHERE email='$email' AND password='$password'";
			$result = mysqli_query($db, $query);
			if (mysqli_num_rows($result)==1) {
				//log user in
				$_SESSION['email'] = $email;
				$_SESSION['success'] = "로그인되었습니다.";
				//장바구니 쿠키 초기화
				setcookie('shopping_cart', '', time() - 3600);

				// 아이디 저장에 체크가 되어있으면
				if(!empty($_POST['remember_id'])){
					//쿠키에 아이디와 비밀번호를 저장한다.
					setcookie('email', $_POST['email'],time()+(10 * 365 * 24 * 60 * 60));
				} else {
					//체크가 되어있지않으면 이메일과 패스워드를 빈값으로한다.
					if(isset($_COOKIE['email'])){
						setcookie('email','');
					}
				}

				header('location: index.php'); //메인페이지로 이동
			}else{
				array_push($errors, "패스워드가 틀렸습니다.");
			}
		}
	}


?>
