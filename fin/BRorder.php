<?php
session_start();
require("dbconnect.php");
$uid=$_SESSION['uid'];
$cid=$_SESSION['cid'];
$a=$_POST['a'];
$b=$_POST['b'];
$c=$_POST['c'];
$bid=$_POST['bid'];
$from=$_POST['from'];
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
$c_sql="select * from company where cid='$cid';";
$c_rs=mysqli_query($conn,$c_sql) or die("DB Error:company");
while ($c_row=mysqli_fetch_assoc($c_rs)) {
	$c_inventory_a=$c_row['inventory_a'];
	$c_inventory_b=$c_row['inventory_b'];
	$c_inventory_c=$c_row['inventory_c'];
}
$b_sql="select * from branch where bid='$bid';";
$b_rs=mysqli_query($conn,$b_sql) or die("DB Error:branch");
while ($b_row=mysqli_fetch_assoc($b_rs)) {
	$b_inventory_a=$b_row['inventory_a'];
	$b_inventory_b=$b_row['inventory_b'];
	$b_inventory_c=$b_row['inventory_c'];
	$b_limit_a=$b_row['limit_a'];
	$b_limit_b=$b_row['limit_b'];
	$b_limit_c=$b_row['limit_c'];
}
$check=0;
if($a+$b+$c==0){
	$check=1;
	echo "<h4><label>請輸入訂貨數量！</label></h4>"
	."<form method='get' action='BRorderForm.php' class='form-horizontal'>"
	."<input type='hidden' value='".$bid."' name='bid'/>"
	."<input type='hidden' value='".$from."' name='from'/>"
	."<input type='submit' value='重填分店訂單' class='btn btn-danger' />"
	."</form>";
}
if($a > $c_inventory_a || $b > $c_inventory_b || $c > $c_inventory_c){
	$check=2;
	echo "<h4><label>您的總店庫存不足，<br/><br/>請重新填寫或至總店訂貨！</label></h4>"
	."<form method='get' action='BRorderForm.php' class='form-horizontal'>"
	."<input type='hidden' value='".$bid."' name='bid'/>"
	."<input type='hidden' value='".$from."' name='from'/>"
	."<input type='submit' value='重填分店訂單' class='btn btn-danger' />"
	."</form>"
	."<a href='CPorderForm.php' class='btn btn-warning'>填寫總店訂單</a>";
}
if($check==0 && (($a+$b_inventory_a) > $b_limit_a || ($b+$b_inventory_b) > $b_limit_b 
	|| ($c+$b_inventory_c) > $b_limit_c))
{
	$check=3;
	echo "<h4><label>進貨數量超出分店上限，<br/><br/>請確認並重新填寫！</label></h4>"
	."<form method='get' action='BRorderForm.php' class='form-horizontal'>"
	."<input type='hidden' value='".$bid."' name='bid'/>"
	."<input type='hidden' value='".$from."' name='from'/>"
	."<input type='submit' value='重填分店訂單' class='btn btn-danger' />"
	."</form>"
	."<a href='CPorderForm.php' class='btn btn-warning'>填寫總店訂單</a>";
}
if ($check==0) {
	$sql="insert into orders (cid,bid,a,b,c) values ('$cid','$bid','$a','$b','$c');";
	mysqli_query($conn, $sql) or die("Insert failed, SQL query error:1"); //執行SQL
	
	$b_inventory_a+=$a;
	$b_inventory_b+=$b;
	$b_inventory_c+=$c;
	$sql_br= "update branch set
	inventory_a='$b_inventory_a',
	inventory_b='$b_inventory_b',
	inventory_c='$b_inventory_c' 
	where bid='$bid';";
	mysqli_query($conn, $sql_br) or die("Insert failed, SQL query error:br"); //執行SQL2
	
	$c_inventory_a-=$a;
	$c_inventory_b-=$b;
	$c_inventory_c-=$c;
	$sql_cp= "update company set
	inventory_a='$c_inventory_a',
	inventory_b='$c_inventory_b',
	inventory_c='$c_inventory_c' 
	where cid='$cid';";
	mysqli_query($conn, $sql_cp) or die("Insert failed, SQL query error:cp"); //執行SQL2
	
	echo "<h3><label>分店進貨成功！</label></h3>";
	if($from==0)//from index.php
	{
		echo "<form method='get' action='index.php'>"
			."<input type='hidden' value='".$bid."' name='bid'/>"
			."<input type='submit' value='回到總店' class='btn btn-danger' />"
			."</form>";
	}
	if($from==1)//from branchList.php
	{
		echo "<a href='branchList.php' class='btn btn-danger'>查看所有分店</a>";
	}
}

?>