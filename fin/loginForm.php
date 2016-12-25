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
<?php
session_start();
require("dbconnect.php");
//set the login mark to empty
$_SESSION['uid'] = "";
?>

<a href="index.php"><span align="right" class="glyphicon glyphicon-home"></span>首頁</a>
<div align="center" >
<div class="container">
	<h1 style="font-weight:bold;color:#444444;">麵包零售賣場</h1>
	<hr />
	<h3 style="font-size:xx-large;color:#444444;">用戶登入</h3>
	<form method="post" action="loginCheck.php" >
		<div class="form-group row">
			<div style="color:#444444;"class="col-md-6"><label>帳號：</label></div>
			<div class="col-md-4"><input type="text" class="form-control" name="ac"></div>
		</div>
		<div class="form-group row">
			<div class="col-md-6"style="color:#444444;"><label>密碼：</label></div>
			<div class="col-md-4"><input type="password" class="form-control" name="pwd"></div>
		</div>
		<input type="submit" class="btn btn-primary" value="登入">
		<a href="userRegisterForm.php" class="btn btn-success">註冊</a>
	</form>
	
</div>
</div>
</body>
</html>