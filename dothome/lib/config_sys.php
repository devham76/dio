<?

define ("_MYSQL_HOST_",   "localhost");	
// 닷홈
if ($_SERVER['SERVER_NAME'] == "devham76.dothome.co.kr" ){
  define ("_MYSQL_ID_",     "devham76");
  define ("_MYSQL_PASSWD_", "hyemi2668*");
  define ("_MYSQL_DB_",     "devham76");
}
// 로컬 (이클립스에서도 해당 정보로 사용하고 있음)
else {
  define ("_MYSQL_ID_",     "root");
  define ("_MYSQL_PASSWD_", "devham7676");
  define ("_MYSQL_DB_",     "dio");
}

?>
