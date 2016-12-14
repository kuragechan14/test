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
if (! isset($_SESSION["uid"]))
	$_SESSION["uid"] = 0;
if ($_SESSION["uid"] <= 0) {
	//header("Location: login.php");
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
	$uid=$_SESSION["uid"];
	$sql= "select * from user where uid='$uid' ;";
	$result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
	while ($rs=mysqli_fetch_assoc($result)) {
		//echo "<h4>".$rs['uname']."，您好！</h4>";
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
	$p_sql= "select * from product;";
	$p_rs=mysqli_query($conn,$p_sql) or die("DB Error: Cannot retrieve message.");
	while ($p_row=mysqli_fetch_assoc($p_rs)) {
		if($p_row['pid']==1){$pname_a=$p_row['pname'];}
		if($p_row['pid']==2){$pname_b=$p_row['pname'];}
		if($p_row['pid']==3){$pname_c=$p_row['pname'];}
	}
?>
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
				<h4><span class="glyphicon glyphicon-list-alt"></span> 總公司資訊</h4></a>
				<button type="button" class="btn btn-success btn-block">
					<h4><span class="glyphicon glyphicon-piggy-bank"></span> 目前資金 <?php echo $funds;?> 元</h4>
				</button>
            </div>
            <div class="col-md-4">
				<a href="#" class="btn btn-danger btn-block" role="button">
					<h4><span class="glyphicon glyphicon-piggy-bank"></span> 總收入 <?php echo $income;?> 元(未完)</h4></a>
				<a href="CPorderForm.php" class="btn btn-primary btn-block" role="button">
					<h4><span class="glyphicon glyphicon-bookmark"></span> 總店庫存訂貨</h4></a>
				<a href="CPorderList.php" class="btn btn-default btn-block" role="button">
					<h4><span class="glyphicon glyphicon-time"></span> 總店訂貨紀錄(未完)</h4></a>
            </div>
            <div class="col-md-4">
				<button type="button" class="btn btn-success btn-block">
					<h4><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo $pname_a;?>庫存：<?php echo $inventory_a;?> 件</h4>
				</button>
				<button type="button" class="btn btn-info btn-block">
					<h4><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo $pname_b;?>庫存：<?php echo $inventory_b;?> 件</h4>
				</button>
				<button type="button" class="btn btn-warning btn-block">
					<h4><span class="glyphicon glyphicon-shopping-cart"></span> <?php echo $pname_c;?>庫存：<?php echo $inventory_c;?> 件</h4>
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
			."<form method='get' action='index.php'>"
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
<?php
	if(!empty($_GET)){
		$bid=$_GET['bid'];
		$s_sql = "select * from branch where bid='$bid';";
		$s_rs=mysqli_query($conn,$s_sql) or die("DB Error: Cannot retrieve message.");
		while ($s_row=mysqli_fetch_assoc($s_rs)) {
			echo "<div class='panel panel-primary'>";
			echo "<div class='panel-heading'><label class='panel-title'>"
				."<span class='glyphicon glyphicon-bookmark'></span> ".$s_row['bname']." 分店</label>"
				
				."<div class='pull-right'><form method='get' action='BRorderForm.php' class='form-horizontal'>"
				."<input type='hidden' value='".$bid."' name='bid'/>"
				."<input type='hidden' value='0' name='from'/>"	//來自index.php
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
	}
	
?>

<?php
	/*
	$uid=$_SESSION["uid"];
	$sql= "select * from user where uid='$uid' ;";
	$result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
	while ($rs=mysqli_fetch_assoc($result)) {
		echo "<h4>".$rs['uname']."，您好！</h4>";
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
			echo "<div class='panel panel-primary'>";
			echo "<div class='panel-heading'>
				<span class='glyphicon glyphicon-home'></span>
				<label class='panel-title'>　".$row['cname']."　總公司資訊</label></div>";
			echo "<table class='table table-striped'>";
			echo "<tr><td>目前資金</td><td>".$row['funds']." 元</td></tr>"
				."<tr><td>收入總和</td><td>".$income." 元</td></tr>";
			echo "</table>";
			echo "</div>";
			
			echo "<div class='panel panel-info'>";
			echo "<div class='panel-heading'>
				<span class='glyphicon glyphicon-shopping-cart'></span>
				<label class='panel-title'>　總公司 商品庫存</label></div>";
			echo "<table class='table table-striped'>";
			echo "<tr><td>甲商品庫存</td><td>".$row['inventory_a']." 件</td></tr>"
				."<tr><td>乙商品庫存</td><td>".$row['inventory_b']." 件</td></tr>"
				."<tr><td>丙商品庫存</td><td>".$row['inventory_c']." 件</td></tr>";
			echo "</table>";
			echo "</div>";
		}
	}
	*/
?>
<br /><br /><br /><br />
</div>
