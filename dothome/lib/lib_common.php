<?
    include_once "config_sys.php";    

	// 데이터 베이스 연결
	function db_connect()
	{

		$MYSQL_HOST   = _MYSQL_HOST_;
		$MYSQL_ID     = _MYSQL_ID_;
		$MYSQL_PASSWD = _MYSQL_PASSWD_;
		$MYSQL_DB     = _MYSQL_DB_;

		if (!$db_connect) $db_connect = mysqli_connect($MYSQL_HOST, $MYSQL_ID, $MYSQL_PASSWD, $MYSQL_DB);
		if (!$db_connect)
		{
			echo "mysql(db_connect) 데이터 베이스에 연결할 수 없습니다.\n" . mysqli_connect_error();
			echo "\n관리자에게 연락주세요 (010-9481-2668)";
		  exit;
		}

		$charset="utf8";
		mysqli_set_charset($db_connect,"utf8");
		//mysqli_query("set session character_set_connection=utf8;", $db_connect);
		//mysqli_query("set session character_set_results=utf8;",    $db_connect);
		//mysqli_query("set session character_set_client=utf8;",     $db_connect);
		
		return $db_connect;
	}


	


    //----------------------------
    function debug($str)
    {
		$ip = $_SERVER[REMOTE_ADDR];

		$logfile =  "/home/ezadmin/public_html/navertalk/log/" . date('Ymd').".log";
		$fp = @fopen($logfile, "a+");
		$ip = $_SERVER[REMOTE_ADDR];
		$output = date("Y/m/d H:i:s")." ($ip) " . $str."\n";
		@fwrite($fp, $output);
		@fflush($fp);
		@fclose($fp);
	}

	function debug_array($arr)
	{
		$output = explode("\n", print_r($arr, true));
		foreach ($output as $line) {
			$str .= addslashes($line) . "\n";
		}

		$ip = $_SERVER[REMOTE_ADDR];

		$logfile =  "/home/ezadmin/public_html/navertalk/log/" . date('Ymd').".log";
		$fp = @fopen($logfile, "a+");
		$ip = $_SERVER[REMOTE_ADDR];
		$output = date("Y/m/d H:i:s")." ($ip) " . $str."\n";
		@fwrite($fp, $output);
		@fflush($fp);
		@fclose($fp);
	}

    function get_domain_info($domain)
    {
        $sys_connect = sys_db_connect();

        $sql = "select * from sys_domain where id = '$domain'";
        $list = mysql_fetch_assoc(mysql_query($sql, $sys_connect));

        return $list;
    }

    function get_user_info($d_connect, $user_key)
    {
        $sql = "select a.*, b.match_mobile, b.is_wait
                    from ezdesk_user a, ezdesk_kakao_match b
                        where a.user_key = '$user_key'
						  and a.user_key = b.user_key";
        $list = mysql_fetch_assoc(mysql_query($sql, $d_connect));

        if( $list)
            return $list;
        else
            return null;
    }
?>
