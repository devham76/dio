<?php
header('Content-Type: text/html; charset=UTF-8');


$db_host = "localhost"; 

$db_user = "root"; 

$db_passwd = "hyemi2668";

$db_name = "dio"; 


$conn = mysqli_connect($db_host, $db_user, $db_passwd);
$r = mysqli_select_db($conn, $db_name);
//$result = mysqli_query($conn, "SELECT * FROM topic");

echo "result : " . $r. "\n";

$conn = mysqli_connect($db_host,$db_user,$db_passwd,$db_name);



if (mysqli_connect_errno($conn)) {

echo "\n데이터베이스 연결 실패: " . mysqli_connect_error();

} else {

echo "데이터베이스 연결 성공";

}

?>