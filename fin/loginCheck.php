<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>模擬麵包零售賣場</title>
</head>
<a href="index.php"><span class="glyphicon glyphicon-home"></span>首頁</a>
<div class="container">
<h1>模擬麵包零售賣場</h1><hr/>
<?php
session_start();
require("dbconnect.php");
$ac=mysqli_real_escape_string($conn,$_POST['ac']);
$pwd=mysqli_real_escape_string($conn,$_POST['pwd']);

$sql = "SELECT * FROM user WHERE account='$ac'";
if ($result = mysqli_query($conn,$sql)) {
	if ($row=mysqli_fetch_assoc($result)) {
		if ($row['pwd'] == $pwd) {
			$_SESSION['uid'] = $row['uid'];
			echo "<h3>登入成功！</h3><br/>
				<a href='index.php' class='btn btn-success'>前往用戶首頁</a>";
		} else {
			echo "<h3>用戶帳號或密碼錯誤，請再試一次！</h3><br />
				<a href='loginForm.php' class='btn btn-danger'>重新登入</a>";
		}
	}
}
else {echo "用戶帳號或密碼錯誤，請再試一次！<br>";}
?>
