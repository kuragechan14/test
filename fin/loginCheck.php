<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>麵包零售賣場</title>
<style type="text/css">
body {
background-image: url(login1.jpg);
background-repeat: no-repeat;
background-position: center center;
background-size:cover;
letter-spacing:8px;
font-family:文鼎特毛楷;
font-size:xx-large;
}
</style>
</head>
<body>
<a href="index.php"><span class="glyphicon glyphicon-home"></span>首頁</a>
<div align="center" >
<h1>麵包零售賣場</h1><hr/>
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
</div>
</body>
</html>