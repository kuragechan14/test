<?php
session_start();
require("dbconnect.php");
$cid=$_SESSION['cid'];
$bname=mysqli_real_escape_string($conn,$_POST['bname']);
$limit_a=$_POST['limit_a'];
$limit_b=$_POST['limit_b'];
$limit_c=$_POST['limit_c'];
?>
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
<nav class="nav navbar-default">
    <div class="container-fluid">
		<div class="navbar-header">
            <a class="navbar-brand" href="index.php">
			<span class="glyphicon glyphicon-user"></span> Home</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="branchList.php">所有分店</span></a></li>
            <li><a href="CPorderForm.php">總店庫存訂貨</a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> 登出</a></li>
        </ul>
    </div>
</nav>
<br />
<?php
if ($bname && $limit_a && $limit_b && $limit_c) { //not empty
	$sql = "insert into branch (cid,bname,limit_a,limit_b,limit_c) 
	values ('$cid','$bname','$limit_a','$limit_b','$limit_c');";
	mysqli_query($conn, $sql) or die("Insert failed, SQL query error:1"); //執行SQL
	echo "<h3>成功新增分店！</h3><br />";
	echo "<a href='index.php' class='btn btn-danger'>回到總店</a>";
} else {
	echo "<h3>請確認所有欄位！</h3><br />";
	echo "<a href='branchAddForm.php' class='btn btn-danger'>重新填寫</a>";
}

?>