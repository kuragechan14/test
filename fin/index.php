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
font-size:large;
}
</style>
</head>
<body>
<a href="index.php"><span class="glyphicon glyphicon-home"></span>首頁</a>
<div align="center" >
<div class="container">
<h1>麵包零售賣場</h1><hr/>
<?php
session_start();
require("dbconnect.php");
require("check.php");
date_default_timezone_set('Asia/Taipei');	//時區設定
if (! isset($_SESSION["uid"]))
	$_SESSION["uid"] = 0;
if ($_SESSION["uid"] <= 0) {
	echo "<h3>尚未登入！</h3><br/>
	<a href='loginForm.php' class='btn btn-primary'>用戶登入</a>";
	exit(0);
}
?>
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
	$uid=$_SESSION["uid"];
	$sql= "select * from user where uid='$uid' ;";
	$result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
	while ($rs=mysqli_fetch_assoc($result)) {
		$c_sql="select * from company where uid='$uid';";
		$c_rs=mysqli_query($conn,$c_sql) or die("DB Error:2");
		while($row=mysqli_fetch_assoc($c_rs))
		{
			$_SESSION['cid']=$row['cid'];
			$cid=$row['cid'];
			$b_sql="select * from branch where cid='$cid';";
			$b_rs=mysqli_query($conn,$b_sql) or die("DB Error:2");
			$income=0;
			while($b_row=mysqli_fetch_assoc($b_rs))
			{$income+=$b_row['income'];}
			$cname=$row['cname'];
			$funds=$row['funds'];
			$inventory_a=$row['inventory_a'];
			$inventory_b=$row['inventory_b'];
			$inventory_c=$row['inventory_c'];
		}
	}
	$company_info=company($cid);
	
	$p_sql= "select * from product;";
	$p_rs=mysqli_query($conn,$p_sql) or die("DB Error: Cannot retrieve message.");
	while ($p_row=mysqli_fetch_assoc($p_rs)) {
		if($p_row['pid']==1){$pname_a=$p_row['pname'];}
		if($p_row['pid']==2){$pname_b=$p_row['pname'];}
		if($p_row['pid']==3){$pname_c=$p_row['pname'];}
	}
	
	$m_sql= "select * from material;";
	$m_rs=mysqli_query($conn,$m_sql) or die("DB Error: Cannot retrieve message.");
	while ($m_row=mysqli_fetch_assoc($m_rs)) {
		if($m_row['mid']==1){$delay_a=$m_row['delay'];}
		if($m_row['mid']==2){$delay_b=$m_row['delay'];}
		if($m_row['mid']==3){$delay_c=$m_row['delay'];}
	}
	
?>
<?php
$i=0; //counter
$cporder_switch=1;
$o_sql="select * from orders where cid='$cid' and bid='0' order by oid desc limit 1;";
//只取最新一筆訂單
$o_rs=mysqli_query($conn,$o_sql) or die("DB Error: Cannot retrieve message.");
$arr = array();
while ($o_row=mysqli_fetch_assoc($o_rs)) {
	$arr[] = $o_row;
	$o_a=$o_row['a'];	//訂單商品數量
	$o_b=$o_row['b'];
	$o_c=$o_row['c'];
	$oid=$o_row['oid'];
	$s_a=$o_row['status_a'];	//商品是否送達狀況
	$s_b=$o_row['status_b'];
	$s_c=$o_row['status_c'];
	if (($o_a==0 || $s_a==1) && ($o_b==0 || $s_b==1) && ($o_c==0 || $s_c==1))
	{$cporder_switch=1;}
	else{$cporder_switch=0;}	//上一筆訂單未送完，不開放總店訂貨
}	
?>
<script>
<?php echo "var myArray=" . json_encode($arr);?>
</script>

<script type="text/javascript">
var t,x1,x2,x3;
var i1,i2,i3;
var d1=<?php echo $delay_a*5;?>;	//五秒一期
var d2=<?php echo $delay_b*5;?>;
var d3=<?php echo $delay_c*5;?>;
var o1=<?php echo $o_a;?>;
var o2=<?php echo $o_b;?>;
var o3=<?php echo $o_c;?>;
var s1=<?php echo $s_a;?>;
var s2=<?php echo $s_b;?>;
var s3=<?php echo $s_c;?>;
function initial(){
	x1=document.getElementById("counter_A");
	x2=document.getElementById("counter_B");
	x3=document.getElementById("counter_C");
	i1=document.getElementById("inventory_a");
	i2=document.getElementById("inventory_b");
	i3=document.getElementById("inventory_c");
	//計算各產品的到貨時間
	tday=new Date(myArray[0]['otime']);
	tday_1=new Date(tday);
	tday_1.setSeconds(tday.getSeconds()+d1);
	tday_2=new Date(tday);
	tday_2.setSeconds(tday.getSeconds()+d2);
	tday_3=new Date(tday);
	tday_3.setSeconds(tday.getSeconds()+d3);
	t=window.setInterval(test,1000);
}

function test(){
	now=new Date();
	if(o1!=0 && s1==0){
		if (tday_1<=now){
			location.href="function.php?act=orders_a&cid="+<?php echo $cid;?>;
		}
		else{
			cd_1=new Date(tday_1-now);
			x1.innerHTML=cd_1.getSeconds();
		}
	}
	if(o2!=0 && s2==0){
		if (tday_2<=now){
			location.href="function.php?act=orders_b&cid="+<?php echo $cid;?>;
		}
		else{
			cd_2=new Date(tday_2-now);
			x2.innerHTML=cd_2.getSeconds();
		}
	}
	if (o3!=0 && s3==0){
		if (tday_3<=now){
			location.href="function.php?act=orders_c&cid="+<?php echo $cid;?>;
		}
		else{
			cd_3=new Date(tday_3-now);
			x3.innerHTML=cd_3.getSeconds();
		}
	}
}
window.onload = function () {
	initial();
};
</script>

<div class="panel panel-primary">
    <div class="panel-heading">
        <h3 class="panel-title">
			<span class="glyphicon glyphicon-bookmark"></span>
				<label class="panel-title"> 總公司資訊</label>
		</h3>
    </div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<a href="#" class="btn btn-default btn-block" role="button">
				<h1><?php echo $cname;?></h1>
				<h4><span class="glyphicon glyphicon-list-alt"></span> 總店資訊</h4></a>
				<button type="button" class="btn btn-success btn-block">
					<h4><span class="glyphicon glyphicon-piggy-bank"></span> 目前資金 <?php echo $company_info['funds'];?> 元</h4>
				</button>
            </div>
            <div class="col-md-4">
				<a href="incomeChart.php" class="btn btn-danger btn-block" role="button">
					<h4><span class="glyphicon glyphicon-piggy-bank"></span> 營業收入 <?php echo $income;?> 元</h4></a>
				<?php
					if ($cporder_switch==1){
						echo "<a href='CPorderForm.php' class='btn btn-primary btn-block' role='button'>
							<h4><span class='glyphicon glyphicon-bookmark'></span> 總店庫存訂貨</h4></a>";
					}
					else{
						echo "<a href='CPorderForm.php' class='btn btn-primary btn-block disabled' role='button'>
							<h4><span class='glyphicon glyphicon-bookmark'></span> 物流運送中</h4></a>";
					}
				?>
				
				<a href="CPorderList.php" class="btn btn-default btn-block" role="button">
					<h4><span class="glyphicon glyphicon-time"></span> 總店訂貨紀錄</h4></a>
            </div>
            <div class="col-md-4">
				<button type="button" class="btn btn-success btn-block">
					<div id="inventory_a"><h4>
					<span class="glyphicon glyphicon-shopping-cart">
					</span> <?php echo $pname_a;?>庫存：
					<?php echo $company_info['inventory_a'];?> 件</h4></div>
				</button>
				<button type="button" class="btn btn-info btn-block">
					<div id="inventory_b"><h4>
					<span class="glyphicon glyphicon-shopping-cart">
					</span> <?php echo $pname_b;?>庫存：
					<?php echo $company_info['inventory_b'];?> 件</h4></div>
				</button>
				<button type="button" class="btn btn-warning btn-block">
					<div id="inventory_c"><h4>
					<span class="glyphicon glyphicon-shopping-cart">
					</span> <?php echo $pname_c;?>庫存：
					<?php echo $company_info['inventory_c'];?> 件</h4></div>
				</button>
            </div>
			<div class="col-md-1">
				<button type="button" class="btn btn-default btn-block">
					<h4 id="counter_A">-</h4>
				</button>
				<button type="button" class="btn btn-default btn-block">
					<h4 id="counter_B">-</h4>
				</button>
				<button type="button" class="btn btn-default btn-block">
					<h4 id="counter_C">-</h4>
				</button>
            </div>
        </div>
	</div>
</div>
<div class="row">
<?php 
	$b_sql = "select * from branch where cid='$cid';";
	$b_rs=mysqli_query($conn,$b_sql) or die("DB Error: Cannot retrieve message.");
	while ($b_row=mysqli_fetch_assoc($b_rs)) {
		$bid=$b_row['bid'];
		$bname=$b_row['bname'];
		echo "<div class='col-md-2 form-group'>"
			."<form method='get' action='branchList.php'>"
			."<input type='hidden' value='".$bid."' name='bid'/>"
			."<button type='submit' class='btn btn-info btn-lg'>
			<span class='glyphicon glyphicon-search'></span> ".$bname." 分店</button>"
			."</div></form>";
	}
?>
	<div class='col-md-2'>
		<a href='branchAddForm.php' class='btn btn-default btn-lg'>
			<span class='glyphicon glyphicon-plus'></span> 新增分店
		</a>
	</div>
</div>
<br /><br /><br /><br />
</div>
</div>
</body>
</html>