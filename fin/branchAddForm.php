<?php
session_start();
require("dbconnect.php");
$uid=$_SESSION['uid'];
$cid=$_SESSION['cid'];

$p_sql= "select * from product;";
$p_rs=mysqli_query($conn,$p_sql) or die("DB Error: Cannot retrieve message.");
while ($p_row=mysqli_fetch_assoc($p_rs)) {
	if($p_row['pid']==1){$pname_a=$p_row['pname'];}
	if($p_row['pid']==2){$pname_b=$p_row['pname'];}
	if($p_row['pid']==3){$pname_c=$p_row['pname'];}
}
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
<h3><label>新增分店</label></h3>
<form method="post" action="branchAdd.php" class="form-horizontal">
	<div class="form-group row">
		<div class="col-md-2"><label>分店名：</label></div>
		<div class="col-md-4">
			<input name="bname" type="text" class="form-control" id="bname" />
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label><?php echo $pname_a;?> 庫存上限：</label></div>
		<div class="col-md-4">
		<select name="limit_a" class="form-control">
		<?php
			for ($i=1;$i<=10;$i++)
			{
				if ($i==1)
					echo "<option value='".($i*10)."' select='true' >".($i*10)."　　　　</option>";
				else
					echo "<option value='".($i*10)."'>".($i*10)."　　　　</option>";
			}
		?>
		</select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label><?php echo $pname_b;?> 庫存上限：</label></div>
		<div class="col-md-4">
		<select name="limit_b" class="form-control">
		<?php
			for ($i=1;$i<=10;$i++)
			{
				if ($i==1)
					echo "<option value='".($i*10)."' select='true' >".($i*10)."　　　　</option>";
				else
					echo "<option value='".($i*10)."'>".($i*10)."　　　　</option>";
			}
		?>
		</select>
		</div>
	</div>
	<div class="form-group row">
		<div class="col-md-2"><label><?php echo $pname_c;?> 庫存上限：</label></div>
		<div class="col-md-4">
		<select name="limit_c" class="form-control">
		<?php
			for ($i=1;$i<=10;$i++)
			{
				if ($i==1)
					echo "<option value='".($i*10)."' select='true' >".($i*10)."　　　　</option>";
				else
					echo "<option value='".($i*10)."'>".($i*10)."　　　　</option>";
			}
		?>
		</select>
		</div>
	</div>
	<input type="submit" value="確定新增" class="btn btn-success" />
</form>
</div>
