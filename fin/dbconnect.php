<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'se_fin_demo';
$conn = mysqli_connect($host, $user, $pass, $db) or die('Error with MySQL connection'); //跟MyMSQL連線並登入
mysqli_query($conn,"SET NAMES utf8"); //選擇編碼
?>