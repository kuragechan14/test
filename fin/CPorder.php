<?php
session_start();
require("dbconnect.php");
$uid=$_SESSION['uid'];
$cid=$_SESSION['cid'];
$a=$_POST['a'];
$b=$_POST['b'];
$c=$_POST['c'];
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
           <li><a href="branchList.php">查看分店</span></a></li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
            <li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> 登出</a></li>
        </ul>
    </div>
</nav>
<br />
<?php
$c_sql="select * from company where uid='$uid';";
$c_rs=mysqli_query($conn,$c_sql) or die("DB Error:2");
while ($c_row=mysqli_fetch_assoc($c_rs)) {
	$funds=$c_row['funds'];
	$pay=$c_row['pay'];
	$inventory_a=$c_row['inventory_a'];
	$inventory_b=$c_row['inventory_b'];
	$inventory_c=$c_row['inventory_c'];
}
$m_sql="select * from material";
$m_rs=mysqli_query($conn,$m_sql) or die("DB Error:3");
$order_price=0;
while ($m_row=mysqli_fetch_assoc($m_rs))
{
	if($m_row['mid']==1){$order_price+=$m_row['price']*$a;}
	if($m_row['mid']==2){$order_price+=$m_row['price']*$b;}
	if($m_row['mid']==3){$order_price+=$m_row['price']*$c;}
}
$check=0;
if($order_price > $funds){
	$check=1;
	echo "<h4>您填寫的訂單金額：".$order_price."元</h4>"
	."<h4>您目前的總店資金：".$funds."元</h4>"
	."<h3><label>您的總資金不足，請確認金額並重新填寫！</label></h3>"
	."<a href='CPorderForm.php' class='btn btn-danger'>重填訂單</a>";
}
if($a+$b+$c==0)
{
	$check=1;
	echo "<h4><label>訂單數量填寫錯誤，請確認並重新填寫！</label></h4>"
	."<a href='CPorderForm.php' class='btn btn-danger'>重填訂單</a>";
}
if ($check==0) {
	
	date_default_timezone_set('Asia/Taipei');	//時區設定
	$otime=date("Y-m-d H:i:s");
	
	$sql="insert into orders (cid,bid,otime,a,b,c) values ('$cid','0','$otime','$a','$b','$c');";
	mysqli_query($conn, $sql) or die("Insert failed, SQL query error:1"); //執行SQL
	$funds-=$order_price;
	$pay+=$order_price;
	$sql2 = "update company set funds='$funds',pay='$pay' where cid='$cid';";
	mysqli_query($conn, $sql2) or die("Insert failed, SQL query error:2"); //執行SQL2
	
	echo "<h4>訂單送出時間：".$otime."</h4>"
		."<h4>訂單金額：".$order_price."元</h4>"
		."<h4>剩餘資金：".$funds."元</h4>"
		."<h3><label>訂購成功！</label></h3>";
	echo "<a href='index.php' class='btn btn-danger'>查看總店</a>";
}

?>