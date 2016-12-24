<?php
session_start();
require("dbconnect.php");
?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
<title>模擬麵包零售賣場</title>
</head>
<body>
<a href="index.php"><span class="glyphicon glyphicon-home"></span>首頁</a>
<div class="container">
	<h1>模擬麵包零售賣場－註冊新帳號</h1><hr>
	<h3>用戶基本資料</h3>
		<form method="post" action="userRegister.php" class="form-horizontal">
		<div class="form-group row">
			<div class="col-md-1"><label>帳號：</label></div>
			<div class="col-md-4">
				<input name="account" type="text" class="form-control" id="account" />
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-1"><label>密碼：</label></div>
			<div class="col-md-4">
				<input name="pwd" type="password" class="form-control" id="pwd" />
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-1"><label>確認密碼：</label></div>
			<div class="col-md-4">
				<input name="r_pwd" type="password" class="form-control" id="r_pwd" />
			</div>
		</div>	
		<div class="form-group row">
			<div class="col-md-1"><label>用戶姓名：</label></div>
			<div class="col-md-4">
				<input name="uname" type="text" class="form-control" id="uname" />
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-1"><label>公司名稱：</label></div>
			<div class="col-md-4">
				<input name="cname" type="text" class="form-control" id="cname" />
			</div>
		</div>
		<div class="form-group row">
			<div class="col-md-1"><label>起始資本額：</label></div>
			<div class="col-md-4">
			<select name="funds" class="form-control">
			<?php
				for ($i=1;$i<=10;$i++)
				{
					if ($i==1)
						echo "<option value='".($i*100000)."' select='true' >".($i*100000)."　　　　</option>";
					else
						echo "<option value='".($i*100000)."'>".($i*100000)."　　　　</option>";
				}
			?>
			</select>
			</div>
		</div>
		<input type="submit" name="Submit" value="註冊" class="btn btn-success" />
		</form>
</div>
</body>
</html>
