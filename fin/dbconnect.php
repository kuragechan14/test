<?php
$host = 'localhost';
$user = 'se_final';
$password = '123';
$db = 'se_final';
$conn = mysqli_connect($host,$user,$password,$db) or die ('Error with MySQL connection');
mysqli_query($conn,"SET NAMES utf8");
?>