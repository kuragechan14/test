<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>模擬麵包零售賣場</title>
</head>
<?php
session_start();
require("dbconnect.php");
//set the login mark to empty
$_SESSION['uid'] = "";
?>
<a href="index.php"><span class="glyphicon glyphicon-home"></span>首頁</a>
<div class="container">
	<h1>模擬麵包零售賣場</h1>
	<hr />
	<h3>用戶登入</h3>
	<form method="post" action="loginCheck.php">
		<div class="form-group row">
			<div class="col-md-1"><label>帳號：</label></div>
			<div class="col-md-4"><input type="text" class="form-control" name="ac"></div>
		</div>
		<div class="form-group row">
			<div class="col-md-1"><label>密碼：</label></div>
			<div class="col-md-4"><input type="password" class="form-control" name="pwd"></div>
		</div>
		<input type="submit" class="btn btn-primary" value="登入">
		<a href="userRegisterForm.php" class="btn btn-success">註冊</a>
	</form>
	
</div>