<?php
require("dbconnect.php");
date_default_timezone_set("Asia/Taipei");
function check_status($x,$cid){
	//echo "<script>alert('check');</script>";
	global $conn;
	if($x==1){
		$c_sql="select status_a from orders 
				where cid='$cid' and bid='0' 
				order by oid desc limit 1;";
		$c_rs=mysqli_query($conn,$c_sql) or die("DB Error:ck_a");
		while($row=mysqli_fetch_assoc($c_rs))
		{
			if($row['status_a']==0){$status=0;}	//status_a==0表示未到貨
			else{$status=1;}
		}	
	}		
	if($x==2){
		$c_sql="select status_b from orders 
				where cid='$cid' and bid='0' 
				order by oid desc limit 1;";
		$c_rs=mysqli_query($conn,$c_sql) or die("DB Error:ck_b");
		while($row=mysqli_fetch_assoc($c_rs))
		{
			if($row['status_b']==0){$status=0;}
			else{$status=1;}
		}
	}		
	if($x==3){
		$c_sql="select status_c from orders 
				where cid='$cid' and bid='0' 
				order by oid desc limit 1;";
		$c_rs=mysqli_query($conn,$c_sql) or die("DB Error:ck_c");
		while($row=mysqli_fetch_assoc($c_rs))
		{
			if($row['status_c']==0){$status=0;}
			else{$status=1;}
		}
	}
	return $status;
}
//總店資訊
function company($cid){
	global $conn;
	$sql="select * from company where cid='$cid';";
	$rs=mysqli_query($conn,$sql) or die("DB Error:company");
	$row = mysqli_fetch_assoc($rs);
	return $row;
}
//分店資訊
function branch($bid){
	global $conn;
	$sql="select * from branch where bid='$bid';";
	$rs=mysqli_query($conn,$sql) or die("DB Error:company");
	$row = mysqli_fetch_assoc($rs);
	return $row;
}
//商店銷售的商品價格
function product($pid){
	global $conn;
	$sql="select * from product where pid='$pid';";
	$rs=mysqli_query($conn,$sql) or die("DB Error:material");
	while ($row=mysqli_fetch_assoc($rs)){$price=$row['price'];}
	return $price;
}
//商店銷售&庫存更新
function branch_sell($bid){
	//echo "<script>alert('sell');</script>";
	global $conn;
	$row=branch($bid);
	$cid=$row['cid'];
	$sell_a=rand(0,10);
	$sell_b=rand(0,10);
	$sell_c=rand(0,10);
	//庫存check
	if ($row['inventory_a']-$sell_a < 0){$sell_a=$row['inventory_a'];}
	if ($row['inventory_b']-$sell_b < 0){$sell_b=$row['inventory_b'];}
	if ($row['inventory_c']-$sell_c < 0){$sell_c=$row['inventory_c'];}
	$sell_money=$sell_a*product(1)+$sell_b*product(2)+$sell_c*product(3);
	$sql="update branch set income = income + '$sell_money',
			inventory_a = inventory_a - '$sell_a',
			inventory_b = inventory_b - '$sell_b',
			inventory_c = inventory_c - '$sell_c'
			where bid='$bid';";
	$sql2="update company set funds = funds + '$sell_money' where cid='$cid';";
	mysqli_query($conn, $sql) or die("update failed:branch_sell");
	mysqli_query($conn, $sql2) or die("update failed:funds_update");
}
function update_a($cid){
	//echo "<script>alert('update_a');</script>";
	global $conn;
	$o_sql="select * from orders 
			where cid='$cid' and bid='0' 
			order by oid desc limit 1;";
	$o_rs=mysqli_query($conn, $o_sql) or die("select failed:1");	
	while($o_row=mysqli_fetch_assoc($o_rs))
	{
		$add_a=$o_row['a'];
		$oid=$o_row['oid'];
	}
	$sql_a="update company set inventory_a = inventory_a + '$add_a' 
			where cid='$cid';";
	$sql2_a="update orders set status_a=1 where oid='$oid';";
	mysqli_query($conn, $sql_a) or die("Insert failed:1");
	mysqli_query($conn, $sql2_a) or die("Insert failed:1");
}
function update_b($cid){
	//echo "<script>alert('update_b');</script>";
	global $conn;
	$o_sql="select * from orders 
		where cid='$cid' and bid='0' 
		order by oid desc limit 1;";
	$o_rs=mysqli_query($conn, $o_sql) or die("select failed:1");	
	while($o_row=mysqli_fetch_assoc($o_rs))
	{
		$add_b=$o_row['b'];
		$oid=$o_row['oid'];
	}
	$sql_b="update company set inventory_b = inventory_b + '$add_b' 
			where cid='$cid';";
	$sql2_b="update orders set status_b=1 where oid='$oid';";
	mysqli_query($conn, $sql_b) or die("Insert failed:1");
	mysqli_query($conn, $sql2_b) or die("Insert failed:1");
}
function update_c($cid){
	//echo "<script>alert('update_c');</script>";
	global $conn;
	$o_sql="select * from orders 
		where cid='$cid' and bid='0' 
		order by oid desc limit 1;";
	$o_rs=mysqli_query($conn, $o_sql) or die("select failed:1");	
	while($o_row=mysqli_fetch_assoc($o_rs))
	{
		$add_c=$o_row['c'];
		$oid=$o_row['oid'];
	}
	$sql_c="update company set inventory_c = inventory_c + '$add_c' 
			where cid='$cid';";
	$sql2_c="update orders set status_c=1 where oid='$oid';";
	mysqli_query($conn, $sql_c) or die("Insert failed:1");
	mysqli_query($conn, $sql2_c) or die("Insert failed:1");
}
?>