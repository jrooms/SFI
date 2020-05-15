<?php
include('server_db.php');
session_start();
$username="";
$email="";
$password_1="";
$password_2="";
$errors=array();
$confirms=array();

//email - 중복확인
if(isset($_POST['email_check'])) {
	$email = $db -> real_escape_string($_POST['email']);
	// ensure that form fields are filled properly
	if(count($errors)==0){
		$query = "SELECT * FROM users WHERE email='$email'";
		$result = mysqli_query($db, $query);
		if(mysqli_num_rows($result)==1){
			array_push($errors, "중복된 아이디입니다.");
		}else {
			array_push($confirms, "사용가능한 아이디 입니다.");
		}
	}

}


	//if the register button is clicked
	if(isset($_POST['register'])){
		$email = $db -> real_escape_string($_POST['email']);
		$username = $db -> real_escape_string($_POST['username']);
		$password_1 = $db -> real_escape_string($_POST['password_1']);
		$password_2 = $db -> real_escape_string($_POST['password_2']);

		// $email = mysqli_real_escape_string($_POST['email']);
		// ensure that form fields are filled properly
		if(count($errors)==0){
			$query = "SELECT * FROM users WHERE email='$email'";
			$result = mysqli_query($db, $query);
			if(mysqli_num_rows($result)==1){
				array_push($errors, "중복된 아이디입니다.");
			}else {

				//ensure that form fields are filed properly
				if($password_1 != $password_2) {
					array_push($errors,"비밀번호가 일치하지 않습니다.");
				}
				if (empty($email)) {
					array_push($errors, "이메일을 입력해주세요");
				}
				if (empty($username)) {
					array_push($errors, "이름을 입력해주세요");
				}
				if (empty($password_1)) {
					array_push($errors, "비밀번호를 입력해주세요");
				}

				// if there are no errors, save user to database

				if (count($errors)==0){
					$usertype = 'user';
					$password = md5($password_1); // encrypt password before storing in database ( security)
					$sql = "INSERT INTO users (username, email, password, usertype, date)
					VALUES ('$username','$email','$password','$usertype',NOW())";
					mysqli_query($db, $sql);
						echo
						"<script>
			var con_test_1 = alert('회원가입에 성공했습니다.');
					location.href='login.php';
			</script>";

				}

			}

		}

	}




?>
