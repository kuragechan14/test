<?php
require "dbconnect.php";
require "check.php";
$act = $_REQUEST['act'];
switch($act){
	case "orders_a":	//�`���w�sA��s
		$cid = $_REQUEST['cid'];
		if(check_status(1,$cid)==0){
			update_a($cid);
		};
		header("Location: index.php");
		break;
	case "orders_b":	//�`���w�sB��s
		$cid = $_REQUEST['cid'];
		if(check_status(2,$cid)==0){
			update_b($cid);
		};
		header("Location: index.php");
		break;
	case "orders_c":	//�`���w�sC��s
		$cid = $_REQUEST['cid'];
		if(check_status(3,$cid)==0){
			update_c($cid);
		};
		header("Location: index.php");
		break;
	case "branch":	//�����P��
		$bid = $_REQUEST['bid'];
		branch_sell($bid);
		header("Location: branchList.php?bid=$bid");
		break;
}
?>