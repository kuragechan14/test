<?php
session_start();
require("dbconnect.php");
require("check.php");
$uid=$_SESSION['uid'];
$cid=$_SESSION['cid'];
$sql = "select * from branch where cid='$cid';";
$result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
?>
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
background-image: url(Bform.jpg);
background-repeat: no-repeat;
background-position: center center;
background-size:cover;
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
<div class="row">
<?php 
	$b_sql = "select * from branch where cid='$cid';";
	$b_rs=mysqli_query($conn,$b_sql) or die("DB Error: Cannot retrieve message.");
	while ($b_row=mysqli_fetch_assoc($b_rs)) {
		$list_bid=$b_row['bid'];
		$bname=$b_row['bname'];
		echo "<div class='col-md-2 form-group'>"
			."<form method='get' action='branchList.php'>"
			."<input type='hidden' value='".$list_bid."' name='bid'/>"
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
<?php
	if(!empty($_GET)){
		$bid=$_GET['bid'];
	}
?>
<script type="text/javascript">
var t,x;
var cd=5;
function initial(){
	x=document.getElementById("counter");
	x.innerHTML="更新倒數 : "+cd;
	t=window.setInterval(sell,1000);
}
function sell(){
	cd--;
	x.innerHTML="更新倒數 : "+cd;
	if (cd==0){
		location.href="function.php?act=branch&bid="+<?php echo $bid;?>;
		cd=5;	//重新
	}
}
</script>
<?php
	if(!empty($_GET)){
		echo "<div id='counter'> </div><br />";
		$p_sql= "select * from product;";
		$p_rs=mysqli_query($conn,$p_sql) or die("DB Error: Cannot retrieve message.");
		while ($p_row=mysqli_fetch_assoc($p_rs)) {
			if($p_row['pid']==1){$pname_a=$p_row['pname'];}
			if($p_row['pid']==2){$pname_b=$p_row['pname'];}
			if($p_row['pid']==3){$pname_c=$p_row['pname'];}
		}
		$s_sql = "select * from branch where bid='$bid';";
		$s_rs=mysqli_query($conn,$s_sql) or die("DB Error: Cannot retrieve message.");
		while ($s_row=mysqli_fetch_assoc($s_rs)) {
			echo "<div class='panel panel-primary'>";
			echo "<div class='panel-heading'><label class='panel-title'>"
				."<span class='glyphicon glyphicon-bookmark'></span> ".$s_row['bname']." 分店</label>"
				
				."<div class='pull-right'><form method='get' action='BRorderForm.php' class='form-horizontal'>"
				."<input type='hidden' value='".$bid."' name='bid'/>"
				."<input type='hidden' value='1' name='from'/>"	//來自index.php
				."<button type='submit' class='btn btn-default btn-sm btn-filter'>"
				."<span class='glyphicon glyphicon-sort'></span> 分店訂貨</button>"
				."</form></div></div>";
				
			echo "<div class='panel-body'>";
			echo "<h4><label>【".$s_row['bname']."】分店收入：".$s_row['income']."元</label></h4>";
			echo "<div class='row'><div class='col-md-3'>".$pname_a."商品庫存："
				.$s_row['inventory_a']." 件 / ".$s_row['limit_a']." 件</div>";
			echo "<div class='col-md-8'><div class='progress'>
					<div class='progress-bar progress-bar-success progress-bar-striped active'
					role='progressbar' aria-valuenow='"
				.(round($s_row['inventory_a']/$s_row['limit_a'],2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
				.(round($s_row['inventory_a']/$s_row['limit_a'],2)*100)."%'>"
				.(round($s_row['inventory_a']/$s_row['limit_a'],2)*100)."%</div></div></div></div>";
			echo "<div class='row'><div class='col-md-3'>".$pname_b."商品庫存："
				.$s_row['inventory_b']." 件 / ".$s_row['limit_b']." 件</div>";
			echo "<div class='col-md-8'><div class='progress'>
					<div class='progress-bar progress-bar-info progress-bar-striped active'
					role='progressbar' aria-valuenow='"
				.(round($s_row['inventory_b']/$s_row['limit_b'],2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
				.(round($s_row['inventory_b']/$s_row['limit_b'],2)*100)."%'>"
				.(round($s_row['inventory_b']/$s_row['limit_b'],2)*100)."%</div></div></div></div>";
			echo "<div class='row'><div class='col-md-3'>".$pname_c."商品庫存："
				.$s_row['inventory_c']." 件 / ".$s_row['limit_c']." 件</div>";
			echo "<div class='col-md-8'><div class='progress'>
					<div class='progress-bar progress-bar-warning progress-bar-striped active'
					role='progressbar' aria-valuenow='"
				.(round($s_row['inventory_c']/$s_row['limit_c'],2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
				.(round($s_row['inventory_c']/$s_row['limit_c'],2)*100)."%'>"
				.(round($s_row['inventory_c']/$s_row['limit_c'],2)*100)."%</div></div></div></div>";
			echo "</div></div>";
		}
		echo "<script>initial();</script>";
	}
	
?>
</div>
</div>
</body>
</html>