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
require("dbconnect.php");
$account=mysqli_real_escape_string($conn,$_POST['account']);
$pwd=mysqli_real_escape_string($conn,$_POST['pwd']);
$uname=mysqli_real_escape_string($conn,$_POST['uname']);
$cname=mysqli_real_escape_string($conn,$_POST['cname']);
$funds=mysqli_real_escape_string($conn,$_POST['funds']);
$r_pwd=mysqli_real_escape_string($conn,$_POST['r_pwd']);
$check=0;
if ($pwd == $r_pwd){$check=1;}

if ($check && $account && $pwd && $uname && $cname) { //not empty
	$sql = "insert into user (uname,account,pwd) values ('$uname','$account','$pwd');";
	mysqli_query($conn, $sql) or die("Insert failed, SQL query error:1"); //執行SQL
	
	$sql2="select * from user where account='$account'";
	$result=mysqli_query($conn, $sql2) or die("Search failed, SQL query error:2");//執行SQL2
	while ($rs=mysqli_fetch_assoc($result)){ $uid=$rs['uid'];}	
	
	$sql3= "insert into company (uid,cname,funds) values ('$uid','$cname','$funds');";
	mysqli_query($conn, $sql3) or die("Insert failed, SQL query error:3"); //執行SQL3
	
	echo "<h3>成功新增用戶！</h3><br />";
	echo "<a href='loginForm.php' class='btn btn-success'>返回登入頁面</a>";
} else {
	echo "<h3>請確認所有欄位及密碼！</h3><br />";
	echo "<a href='userRegisterForm.php' class='btn btn-danger'>重新填寫資料</a>";
}

?>
</div>
</body>
</html>