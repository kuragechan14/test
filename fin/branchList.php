<?php
session_start();
require("dbconnect.php");
$uid=$_SESSION['uid'];
$cid=$_SESSION['cid'];
$sql = "select * from branch where cid='$cid';";
$result=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
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
<a href='branchAddForm.php' class='btn btn-default'><span class='glyphicon glyphicon-plus'></span> 新增分店</a><br /><br />
<?php
	// sleep(5);
	// echo date('h:i:s')."<br>";
	// sleep(5);
	// echo date('h:i:s')."<br>";
?>
<?php
	$p_sql= "select * from product;";
	$p_rs=mysqli_query($conn,$p_sql) or die("DB Error: Cannot retrieve message.");
	while ($p_row=mysqli_fetch_assoc($p_rs)) {
		if($p_row['pid']==1){$pname_a=$p_row['pname'];}
		if($p_row['pid']==2){$pname_b=$p_row['pname'];}
		if($p_row['pid']==3){$pname_c=$p_row['pname'];}
	}
	
	while ($row=mysqli_fetch_assoc($result)) {
		$bid=$row['bid'];
		echo "<div class='panel panel-primary'>";
		echo "<div class='panel-heading'><label class='panel-title'>".$row['bname']." 分店</label>"
			."<div class='pull-right'><form method='get' action='BRorderForm.php' class='form-horizontal'>"
			."<input type='hidden' value='".$bid."' name='bid'/>"
			."<input type='hidden' value='1' name='from'/>"	//來自branchList.php
			."<button type='submit' class='btn btn-default btn-sm btn-filter'>"
			."<span class='glyphicon glyphicon-sort'></span> 分店訂貨</button>"
			."</form></div></div>";
		echo "<div class='panel-body'>";
		echo "<h4><label>【".$row['bname']."】分店收入：".$row['income']."元</label></h4>";
		echo $pname_a." 庫存：".$row['inventory_a']." 件 / ".$row['limit_a']." 件";
		echo "<div class='progress'>
				<div class='progress-bar progress-bar-success progress-bar-striped active'
				role='progressbar' aria-valuenow='"
			.(round($row['inventory_a']/$row['limit_a'],2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
			.(round($row['inventory_a']/$row['limit_a'],2)*100)."%'>"
			.(round($row['inventory_a']/$row['limit_a'],2)*100)."%</div></div>";
		echo $pname_b." 庫存：".$row['inventory_b']." 件 / ".$row['limit_b']." 件";
		echo "<div class='progress'>
				<div class='progress-bar progress-bar-info progress-bar-striped active'
				role='progressbar' aria-valuenow='"
			.(round($row['inventory_b']/$row['limit_b'],2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
			.(round($row['inventory_b']/$row['limit_b'],2)*100)."%'>"
			.(round($row['inventory_b']/$row['limit_b'],2)*100)."%</div></div>";
		echo $pname_c." 庫存：".$row['inventory_c']." 件 / ".$row['limit_c']." 件";
		echo "<div class='progress'>
				<div class='progress-bar progress-bar-warning progress-bar-striped active'
				role='progressbar' aria-valuenow='"
			.(round($row['inventory_c']/$row['limit_c'],2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
			.(round($row['inventory_c']/$row['limit_c'],2)*100)."%'>"
			.(round($row['inventory_c']/$row['limit_c'],2)*100)."%</div></div>";
		echo "</div></div>";
	}
?>
</div>
