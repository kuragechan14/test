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
background-image: url(income.jpg);
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
<div class="panel panel-info">
    <div class="panel-heading">
        <h3 class="panel-title">
			<span class="glyphicon glyphicon-bookmark"></span>
				<label class="panel-title"> 總店訂貨紀錄</label>
		</h3>
    </div>
	<table class="table table-striped">
		<tr>
			<td>訂單日期</td>
			<td><?php echo $pname_a;?>進貨數量</td>
			<td><?php echo $pname_b;?>進貨數量</td>
			<td><?php echo $pname_c;?>進貨數量</td>
		</tr>
		<?php
			$sql= "select * from orders where bid='0' and cid='$cid';";
			$rs=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
			while ($row=mysqli_fetch_assoc($rs)) {
				echo "<tr><td>".$row['otime']."</td>";
				echo "<td>".$row['a']." 件</td>";
				echo "<td>".$row['b']." 件</td>";
				echo "<td>".$row['c']." 件</td></tr>";
			}
		?>
	</table>
</div>
</div>
</div>
</body>
</html>
