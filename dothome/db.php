<?php
header('Content-Type: text/html; charset=UTF-8');


$db_host = "localhost"; 

$db_user = "devham76"; 

$db_passwd = "hyemi2668*";

$db_name = "devham76"; 

$conn = mysqli_connect($db_host,$db_user,$db_passwd,$db_name);



if (mysqli_connect_errno($conn)) {

echo "데이터베이스 연결 실패: " . mysqli_connect_error();

} else {

echo "데이터베이스 연결 성공";

}

?>