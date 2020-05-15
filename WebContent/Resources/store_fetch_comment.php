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


$typeID = $db -> real_escape_string($_POST['typeID']);
$query = "SELECT * FROM comment DESK WHERE type_id LIKE '$typeID'";
$result=mysqli_query($db, $query);


?>

      <div class="container-fluid">

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            	문의 게시판</div>
          <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th>사용자</th>
                    <th>문의내용</th>
                    <th>등록날짜</th>
                  </tr>
                </thead>
                <tbody>
                <?php if(mysqli_num_rows($result)>0){
									while($row=mysqli_fetch_object($result)){?>
                  <tr>
                    <td><?php echo $row->comment_sender_name;?></td>
                    <td><?php echo $row->comment;?></td>
                    <td><?php echo $row->date;?><br></td>
                  </tr>

                  <?php if($row->reply_comment != null){?>
                  <tr>
               		<td colspan="1" align="right">└ 관리자 답변</td>
               		<td><?php echo $row->reply_comment;?></td>
                  </tr>
                   		<?php }?>
<?php
	}
} else {
}
?>
               </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
      <!-- /.container-fluid -->
