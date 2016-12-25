<?php
session_start();
require("dbconnect.php");
$uid=$_SESSION['uid'];
$cid=$_SESSION['cid'];
$bid=$_GET['bid'];
$sql = "select * from company where cid='$cid';";
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
background-image: url(Bship1.jpg);
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

<table class="table table-striped">
    <thead>
      <tr>
        <th>產品名稱</th>
        <th>目前總店庫存</th>
        <th>目前本店庫存 / 上限</th>
		<th class='col-md-4'>百分比</th>
      </tr>
    </thead>
    <tbody>
	<?php
		$p_sql= "select * from product;";
		$p_rs=mysqli_query($conn,$p_sql) or die("DB Error: Cannot retrieve message.");
		while ($p_row=mysqli_fetch_assoc($p_rs)) {
			if($p_row['pid']==1){$pname_a=$p_row['pname'];}
			if($p_row['pid']==2){$pname_b=$p_row['pname'];}
			if($p_row['pid']==3){$pname_c=$p_row['pname'];}
		}
		
		$b_sql = "select * from branch where bid='$bid';";
		$rs=mysqli_query($conn,$b_sql) or die("DB Error: Cannot retrieve message.2");
		while ($b_row=mysqli_fetch_assoc($rs)) {
			$b_inventory_a=$b_row['inventory_a'];
			$b_inventory_b=$b_row['inventory_b'];
			$b_inventory_c=$b_row['inventory_c'];
			$b_limit_a=$b_row['limit_a'];
			$b_limit_b=$b_row['limit_b'];
			$b_limit_c=$b_row['limit_c'];
			$bname=$b_row['bname'];
		}
		echo "<h3><label>".$bname." 分店</label></h3>";
		while ($row=mysqli_fetch_assoc($result)) {
			echo "<tr>"
			."<td>".$pname_a."</td>"
			."<td>".$row['inventory_a']."　件</td>"
			."<td>".$b_inventory_a." 件 / ".$b_limit_a." 件</td>"
			."<td>"
			."<div class='progress'>
					<div class='progress-bar progress-bar-success progress-bar-striped active'
					role='progressbar' aria-valuenow='"
				.(round($b_inventory_a/$b_limit_a,2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
				.(round($b_inventory_a/$b_limit_a,2)*100)."%'>"
				.(round($b_inventory_a/$b_limit_a,2)*100)."%</div>"
			."</td>"
			."</tr>";
			echo "<tr>"
			."<td>".$pname_b."</td>"
			."<td>".$row['inventory_b']."　件</td>"
			."<td>".$b_inventory_b." 件 / ".$b_limit_b." 件</td>"
			."<td>"
			."<div class='progress'>
					<div class='progress-bar progress-bar-info progress-bar-striped active'
					role='progressbar' aria-valuenow='"
				.(round($b_inventory_b/$b_limit_b,2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
				.(round($b_inventory_b/$b_limit_b,2)*100)."%'>"
				.(round($b_inventory_b/$b_limit_b,2)*100)."%</div>"
			."</td>"
			."</tr>";
			echo "<tr>"
			."<td>".$pname_c."</td>"
			."<td>".$row['inventory_c']."　件</td>"
			."<td>".$b_inventory_c." 件 / ".$b_limit_c." 件</td>"
			."<td>"
			."<div class='progress'>
					<div class='progress-bar progress-bar-warning progress-bar-striped active'
					role='progressbar' aria-valuenow='"
				.(round($b_inventory_c/$b_limit_c,2)*100)."' aria-valuemin='0' aria-valuemax='100' style='width:"
				.(round($b_inventory_c/$b_limit_c,2)*100)."%'>"
				.(round($b_inventory_c/$b_limit_c,2)*100)."%</div>"
			."</td>"
			."</tr>";
		}
	?>
    </tbody>
</table>

<form method="post" action="BRorder.php" class="form-horizontal">
	<div class='panel panel-primary'>
		<div class="panel-heading"><label class='panel-title'>分店訂單內容</label></div>
		<div class="panel-body">
			<div class="form-group row">
				<div class="col-md-2"><label><?php echo $pname_a;?> 進貨數量：</label></div>
				<div class="col-md-4">
				<select name="a" class="form-control">
				<?php
					for ($i=0;$i<=10;$i++)
					{
						if ($i==0)
							echo "<option value='".($i*10)."' select='true' >".($i*10)."　　　　</option>";
						else
							echo "<option value='".($i*10)."'>".($i*10)."　　　　</option>";
					}
				?>
				</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-2"><label><?php echo $pname_b;?> 進貨數量：</label></div>
				<div class="col-md-4">
				<select name="b" class="form-control">
				<?php
					for ($i=0;$i<=10;$i++)
					{
						if ($i==0)
							echo "<option value='".($i*10)."' select='true' >".($i*10)."　　　　</option>";
						else
							echo "<option value='".($i*10)."'>".($i*10)."　　　　</option>";
					}
				?>
				</select>
				</div>
			</div>
			<div class="form-group row">
				<div class="col-md-2"><label><?php echo $pname_c;?> 進貨數量：</label></div>
				<div class="col-md-4">
				<select name="c" class="form-control">
				<?php
					for ($i=0;$i<=10;$i++)
					{
						if ($i==0)
							echo "<option value='".($i*10)."' select='true' >".($i*10)."　　　　</option>";
						else
							echo "<option value='".($i*10)."'>".($i*10)."　　　　</option>";
					}
				?>
				</select>
				</div>
			</div>
		</div>
	</div>
	<input type="hidden" value="<?php echo $bid;?>" name="bid"/>
	<input type="submit" value="送出訂單" class="btn btn-danger" />
</form>
</div>
<br /><br /><br />
</div>
</body>
</html>
