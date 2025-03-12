<?php  

$sname = "localhost:3307";
$uname = "root";
$password = "12345";

$db_name = "desnutricion";

$conn  = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
	echo "Connection failed!";
}