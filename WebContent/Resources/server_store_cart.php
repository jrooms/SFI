<?php

// 게스트유저도 아니고 관리자 유저도 아닐때는
if($guestUser == false && $adminUser != true ) {

	//쇼핑 카트에 담기
	if(isset($_POST['add_to_cart_user'])){

		$type = $db -> real_escape_string ($_POST['hd_type']);
		$page = $db -> real_escape_string ($_POST['hd_page']);
		$wear = "wear";
		$shoes ="shoes";
		$acc = "acc";
// 회원일때는 세션에 담는다 .
		if(isset($_SESSION['shopping_cart'])){


			$item_array_id = array_column($_SESSION['shopping_cart'], 'item_type_id');

			// in_array함수는 배열에 항목이 있으면 true를 반환한다.
			if(!in_array($_POST['hd_type_id'],$item_array_id)){
				$count = count($_SESSION['shopping_cart']);


				if($type==$wear){
					$item_array = array (
							'item_type_id'	=> 		$_POST['hd_type_id'],
							'item_name'		=>  $_POST['hd_name'],
							'item_price'   =>   $_POST['hd_price'],
							'item_img'	=>		$_POST['hd_itemimg'],
							'item_quantity'	 => $_POST['quantity'],
							'item_size'	=>  $_POST['size_w'],
							'item_type' =>  $_POST['hd_type'],
							'item_id' => $_POST['hd_id'],
							'item_page' =>$_POST['hd_page'],
							'item_t' => 'item_w'
					);
				}else if($type==$shoes){
					$item_array = array (
							'item_type_id'	=> 		$_POST['hd_type_id'],
							'item_name'		=>  $_POST['hd_name'],
							'item_price'   =>   $_POST['hd_price'],
							'item_img'	=>		$_POST['hd_itemimg'],
							'item_quantity'	 => $_POST['quantity'],
							'item_size'	=>  $_POST['size_s'],
							'item_type' =>  $_POST['hd_type'],
							'item_id' => $_POST['hd_id'],
							'item_page' =>$_POST['hd_page'],
							'item_t' => 'item_s'
					);
				}else if($type==$acc){
					$item_array = array (
							'item_type_id'	=> 		$_POST['hd_type_id'],
							'item_name'		=>  $_POST['hd_name'],
							'item_price'   =>   $_POST['hd_price'],
							'item_img'	=>		$_POST['hd_itemimg'],
							'item_quantity'	 => $_POST['quantity'],
							'item_size'	=>  'free',
							'item_type' =>  $_POST['hd_type'],
							'item_id' => $_POST['hd_id'],
							'item_page' =>$_POST['hd_page'],
							'item_t' => 'item_a'
					);
				}
				$_SESSION['shopping_cart'][$count] = $item_array;

				echo
				"<script>
		 		var UP;
		 		UP=confirm('장바구니에 추가했습니다. 장바구니로 이동하시겠습니까?');

		 		if(UP)
		 		{
		 		location.href='mypage.php#mypage';
		 		}else{
		 		history.back(-1);
		 		}

		 		</script>";

			} else {
				echo '<script>alert("이미 장바구니에 추가한 상품입니다.");
		 					history.back(-1);
		 					</script>';
			}

		} else {
			if($type==$wear){
				$item_array = array (
						'item_type_id'	=> 		$_POST['hd_type_id'],
						'item_name'		=>  $_POST['hd_name'],
						'item_price'   =>   $_POST['hd_price'],
						'item_img'	=>		$_POST['hd_itemimg'],
						'item_quantity'	 => $_POST['quantity'],
						'item_size'	=>  $_POST['size_w'],
						'item_type' =>  $_POST['hd_type'],
						'item_id' => $_POST['hd_id'],
						'item_page' =>$_POST['hd_page'],
						'item_t' => 'item_w'
				);
			}else if($type==$shoes){
				$item_array = array (
						'item_type_id'	=> 		$_POST['hd_type_id'],
						'item_name'		=>  $_POST['hd_name'],
						'item_price'   =>   $_POST['hd_price'],
						'item_img'	=>		$_POST['hd_itemimg'],
						'item_quantity'	 => $_POST['quantity'],
						'item_size'	=>  $_POST['size_s'],
						'item_type' =>  $_POST['hd_type'],
						'item_id' => $_POST['hd_id'],
						'item_page' =>$_POST['hd_page'],
						'item_t' => 'item_s'
				);
			}else if($type==$acc){
				$item_array = array (
						'item_type_id'	=> 		$_POST['hd_type_id'],
						'item_name'		=>  $_POST['hd_name'],
						'item_price'   =>   $_POST['hd_price'],
						'item_img'	=>		$_POST['hd_itemimg'],
						'item_quantity'	 => $_POST['quantity'],
						'item_size'	=>  'free',
						'item_type' =>  $_POST['hd_type'],
						'item_id' => $_POST['hd_id'],
						'item_page' =>$_POST['hd_page'],
						'item_t' => 'item_a'
				);
			}
			$_SESSION['shopping_cart'][0] = $item_array;
			echo
			"<script>
		 		var UP;
		 		UP=confirm('장바구니에 추가했습니다. 장바구니로 이동하시겠습니까?');

		 		if(UP)
		 		{
		 		location.href='mypage.php#mypage';
		 		}else{
		 		history.back(-1);
		 		}

		 		</script>";
		}
	}

	//ㅋ
}else if($guestUser == true  && $adminUser != true) {


// 비회원 쿠키에 저장하는 코드
if (isset($_POST['add_to_cart'])) {

	//쇼핑카트 쿠키에 값이 들어오면
	if(isset($_COOKIE['shopping_cart'])) {
		$cookie_data = stripslashes($_COOKIE['shopping_cart']);
		$cart_data = json_decode($cookie_data, true);
	} else {
		$cart_data = array();
	}

	// array의 형태를 colum을 기준으로 새로운 array를 만들어준다   array_map과 비슷
	$item_id_list = array_column($cart_data, 'item_type_id');

	//in_array 배열내에 값을찾아서 인덱스로 반환한다.
	if(in_array($_POST['hd_type_id'],$item_id_list)){

		echo '<script>alert("이미 장바구니에 추가한 상품입니다.");
		 					history.back(-1);
		 					</script>';

		//foreach를 사용하여 키와 밸류를 가져온다.  // foreach ($array as $value)  -> 값만 가져오는 경우이다.
		foreach($cart_data as $keys => $values) {
			//찾아온 값이 포스트로 받아온 값과 같으면
			if($car_data[$keys]['item_type_id'] == $_POST['hd_type_id']){
				$cart_data[$keys]['item_quantity'] =
				$cart_data[$keys]['item_quantity'] + $_POST['quantity'];
			}
		}
	} else {

		// 아이템을 타입별로 구분하여서 쿠키에 저장하기 위함이다.
		$type = $db -> real_escape_string ($_POST['hd_type']);
		$page = $db -> real_escape_string ($_GET['page']);
		$wear = "wear";
		$shoes ="shoes";
		$acc = "acc";

		if($type==$wear){
			$item_array = array (
					'item_type_id'	=> 		$_POST['hd_type_id'],
					'item_name'		=>  $_POST['hd_name'],
					'item_price'   =>   $_POST['hd_price'],
					'item_img'	=>		$_POST['hd_itemimg'],
					'item_quantity'	 => $_POST['quantity'],
					'item_size'	=>  $_POST['size_w'],
					'item_type' =>  $_POST['hd_type'],
					'item_id' => $_POST['hd_id'],
					'item_page' =>$_GET['page'],
					'item_t' => 'item_w'
			);
		}else if($type==$shoes){
			$item_array = array (
					'item_type_id'	=> 		$_POST['hd_type_id'],
					'item_name'		=>  $_POST['hd_name'],
					'item_price'   =>   $_POST['hd_price'],
					'item_img'	=>		$_POST['hd_itemimg'],
					'item_quantity'	 => $_POST['quantity'],
					'item_size'	=>  $_POST['size_s'],
					'item_type' =>  $_POST['hd_type'],
					'item_id' => $_POST['hd_id'],
					'item_page' =>$_GET['page'],
					'item_t' => 'item_s'
			);
		}else if($type==$acc){
			$item_array = array (
					'item_type_id'	=> 		$_POST['hd_type_id'],
					'item_name'		=>  $_POST['hd_name'],
					'item_price'   =>   $_POST['hd_price'],
					'item_img'	=>		$_POST['hd_itemimg'],
					'item_quantity'	 => $_POST['quantity'],
					'item_size'	=>  'free',
					'item_type' =>  $_POST['hd_type'],
					'item_id' => $_POST['hd_id'],
					'item_page' =>$_GET['page'],
					'item_t' => 'item_a'
			);
		}
		$cart_data[] = $item_array;

		echo
		"<script>
		 		var UP;
		 		UP=confirm('장바구니에 추가했습니다. 장바구니로 이동하시겠습니까?');

		 		if(UP)
		 		{
		 		location.href='mypage.php#mypage';
		 		}else{
		 		history.back(-1);
		 		}

		 		</script>";

	}

	//json_encode  제이슨 표현을 반환한다.
	$item_data = json_encode($cart_data);
	//  쿠키 셋                   키                            값                  만료시간
	setcookie('shopping_cart', $item_data, time() + (86400 * 30));


}

}




?>
