<?php
    include_once "lib/lib_common.php";   
    
    foreach($_REQUEST as $key => $val) $$key = $val;

    if ( $_REQUEST['action'] == "table_support" ) table_support();
    else if ( $_REQUEST['action'] == "count_visitor" ) count_visitor();
    else if ( $_REQUEST['action'] == "get_visitor" ) get_visitor();

    // -- 후원해 주신 분들 목록
    function table_support() {
        global $db_connect;
        $sql = "select *   
                    from `support`
                order by grade asc";
        $result = mysqli_query($db_connect, $sql);
        $no = 0;
        while ($data = mysqli_fetch_assoc($result)) {

            if ($no % 2 == 0)   $table .= "<tr>";
            $table .= "<td>" . substr($data['grade'], -2, 2) . " &nbsp;&nbsp;" . $data['name'] . "</td>";
            if ($no % 2 == 1)   $table .= "</tr>";

            ++$no;
        }
    
        echo $table;
    }

    // --  방문자 카운트
    function count_visitor() {
        global $db_connect;

        $sql = "select * 
                    from `visitor` 
                where ip = '".$_SERVER['REMOTE_ADDR']."' 
                  and date like '".date("Y-m-d")."%'";
        $result = mysqli_query($db_connect, $sql);
        $data = mysqli_num_rows($result);
        echo "data cnt: "+$data;
        if($data != 0) return;

        $sql = "insert into `visitor` (ip, date) values ('" . $_SERVER['REMOTE_ADDR']."', '". date("Y/m/d H:i:s") ."')";
        echo "data:".$data." / sql : ".$sql;
        mysqli_query($db_connect, $sql);
     
    }
    
    // -- 방문자 수 가져오기
    function get_visitor() {
        
        global $db_connect;
        $sql = "select * 
                    from `visitor`";
                
        $result = mysqli_query($db_connect, $sql);
        $day = 0;          // 오늘 방문자수
        $all_people = 0;   // 전체 방문자수

        
        while ($data = mysqli_fetch_assoc($result)) {
            ++$all_people;
            if (substr($data['date'],0,10) == date('Y-m-d')) $day++;
        }
        /*
        $all_cnt = 0;
        $sql2 = "select count(*) cnt  
                    from `visitor`";
     
                    
        $result2 = mysqli_query($db_connect, $sql2);
        $data2 = mysqli_fetch_assoc($result2);
        
        $all_cnt = $data2['cnt'];
*/
        echo $day . " / " . $all_people ;
        
    }
    

?>