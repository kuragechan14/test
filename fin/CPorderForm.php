<?php
session_start();
require("dbconnect.php");
$uid=$_SESSION['uid'];
$cid=$_SESSION['cid'];
//原料價格
$m_price[0]=rand(30,70);
$m_price[1]=rand(50,100);
$m_price[2]=rand(70,120);
//產品價格
$p_price[0]=rand(100,150);
$p_price[1]=rand(120,200);
$p_price[2]=rand(200,300);
for ($i=0;$i<3;$i++)
{
	$j=$i+1;
	//更新原料價格
	$price_m=$m_price[$i];
	$m_sql="update material set price='$price_m' where mid ='$j';";
	mysqli_query($conn, $m_sql) or die("Insert failed, SQL query error:m_sql");
	//更新產品價格
	$price_p=$p_price[$i];
	$p_sql="update product set price='$price_p' where mid ='$j';";
	mysqli_query($conn, $p_sql) or die("Insert failed, SQL query error:p_sql");
}

$sql = "select * from product;";
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
background-image: url(Cform.jpg);
background-repeat: no-repeat;
background-position: center center;
background-size:cover;
letter-spacing:8px;
font-family:文鼎特毛楷;
font-size:large;
}
.div{
font-size:medium;
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

<h3><label>總店庫存訂貨</label></h3>
<table class="table table-striped">
    <thead>
      <tr>
        <th>產品名稱</th>
        <th>目前原料價格</th>
        <th>目前銷售價格</th>
		<th>運送延遲</th>
      </tr>
    </thead>
    <tbody>
	<?php
		while ($row=mysqli_fetch_assoc($result)) {
			$mid=$row['mid'];
			$sql2= "select * from material where mid='$mid';";
			$rs=mysqli_query($conn,$sql2) or die("DB Error: Cannot retrieve message.");
			while ($row2=mysqli_fetch_assoc($rs)) {
				$m_price=$row2['price'];
				$m_delay=$row2['delay'];
			}
			echo "<tr>"
			."<td>".$row['pname']."</td>"
			."<td>".$m_price."</td>"
			."<td>".$row['price']."</td>"
			."<td>".$m_delay." 天</td>"
			."</tr>";
			if($row['pid']==1){$pname_a=$row['pname'];}
			if($row['pid']==2){$pname_b=$row['pname'];}
			if($row['pid']==3){$pname_c=$row['pname'];}
		}
	?>
    </tbody>
</table>
<h3><label>目前總店資金：
<?php
	$c_sql="select * from company where uid='$uid';";
	$c_rs=mysqli_query($conn,$c_sql) or die("DB Error:2");
	while ($c_row=mysqli_fetch_assoc($c_rs)) {
		echo $c_row['funds']."元。";
	}
?>
</label></h3>
<form method="post" action="CPorder.php" class="form-horizontal">
	<div class='panel panel-primary'>
	<div class="panel-heading"><label class='panel-title'>總店訂單內容</label></div>
	<div class="panel-body">
		<div class="form-group row">
			<div class="col-md-6"><label><?php echo $pname_a;?> 進貨數量：</label></div>
			<div class="col-md-4">
			<select name="a" class="form-control">
			<?php
				for ($i=0;$i<=10;$i++)
				{
					if ($i==0)
						echo "<option value='".($i*100)."' select='true' >".($i*100)."　　　　</option>";
					else
						echo "<option value='".($i*100)."'>".($i*100)."　　　　</option>";
				}
			?>
			</select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-6"><label><?php echo $pname_b;?> 進貨數量：</label></div>
			<div class="col-md-4">
			<select name="b" class="form-control">
			<?php
				for ($i=0;$i<=10;$i++)
				{
					if ($i==0)
						echo "<option value='".($i*100)."' select='true' >".($i*100)."　　　　</option>";
					else
						echo "<option value='".($i*100)."'>".($i*100)."　　　　</option>";
				}
			?>
			</select>
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-6"><label><?php echo $pname_c;?> 進貨數量：</label></div>
			<div class="col-md-4">
			<select name="c" class="form-control">
			<?php
				for ($i=0;$i<=10;$i++)
				{
					if ($i==0)
						echo "<option value='".($i*100)."' select='true' >".($i*100)."　　　　</option>";
					else
						echo "<option value='".($i*100)."'>".($i*100)."　　　　</option>";
				}
			?>
			</select>
			</div>
		</div>
	</div></div>
	<input type="submit" value="送出訂單" class="btn btn-danger" />
</form>
</div>
<br /><br /><br />
</div>
</body>
</html>
