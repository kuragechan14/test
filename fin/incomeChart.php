<?php
session_start();
require("dbconnect.php");
$uid=$_SESSION['uid'];
$cid=$_SESSION['cid'];
$total=0;
$sql= "select * from branch where cid='$cid';";
$rs=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
while ($row=mysqli_fetch_assoc($rs)) {
	$total+=$row['income'];
}
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
  <script src="https://code.highcharts.com/modules/exporting.js"></script>
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
<div class="col-md-6">
<h3><label>總收入：<?php echo $total;?> 元</label></h3>
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">
				<span class="glyphicon glyphicon-bookmark"></span>
					<label class="panel-title"> 各分店營收</label>
			</h3>
		</div>
		<table class="table table-striped">
			<tr>
				<td><label>分店名稱</label></td>
				<td><label>收入金額</label></td>
				<td><label>百分比</label></td>
			</tr>
			<?php
				$sql= "select * from branch where cid='$cid';";
				$rs=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
				while ($row=mysqli_fetch_assoc($rs)) {
					echo "<tr><td>".$row['bname']."</td>";
					echo "<td>".$row['income']." 元</td>";
					echo "<td>".(round($row['income']/$total,4)*100)." %</td>";
				}
			?>
		</table>
	</div>
</div>
<div class="col-md-6" id="container"> </div>
<script>
	$(function () {
    Highcharts.chart('container', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: '營收分布圖'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.2f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.2f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'black'
                    }
                }
            }
        },
        series: [{
            name: '比例',
            colorByPoint: true,
            data: [
			<?php
				$sql= "select * from branch where cid='$cid';";
				$rs=mysqli_query($conn,$sql) or die("DB Error: Cannot retrieve message.");
				while ($row=mysqli_fetch_assoc($rs)) {
					echo "{name:'".$row['bname']."分店',";
					echo "x:'".$row['income']."元',";
					echo "y:".(round($row['income']/$total,4)*100)."},";
				}
			?>
			]
        }]
    });
});
</script>
</div>
