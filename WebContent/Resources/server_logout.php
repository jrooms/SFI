<?php
session_start();
//세션종료
session_destroy();
unset($_SESSION['email']);
echo
"<script>
			var con_test_1 = alert('로그아웃합니다.');
					location.href='login.php';
			</script>";
?>