<?php
    include_once "lib/lib_common.php";   
    

    foreach($_REQUEST as $key => $val) $$key = $val;
    //$search_id, $search_string
    if ( $_REQUEST['action'] == "attendCheck" ) attendCheck();
    else if ( $_REQUEST['action'] == "attendAdminDetail" ) attendAdminDetail($search_id, $search_string);
    else if ( $_REQUEST['action'] == "attendAdminAll" ) attendAdminAll();
    debug("attendResult.php start...");

    // -- 모든 사람 확인용 , 참여현황
    function attendCheck() {
        global $db_connect;
        // -- table
        $table = "
            <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>학번</th>
                        <th>이름</th>
                        <th>행사</th>
                        <th>뒤풀이</th>
                        <th>+인원</th>
                        <th class='attend_2'>주차</th>
                    </tr>
                </thead>
                <tbody>
            ";


        $sql = "select m.*, a.*
                from `member` m, `attend` a
                where m.seq = a.member_seq 
                order by m.grade asc";
                debug($sql);
        $result = mysqli_query($db_connect, $sql);
    
        $no = 0;
        while ($data = mysqli_fetch_assoc($result)) {
        

            switch ($data['main_event']) {
                case 1 : $attend = 'attend_1'; $attend_string = "참석"; break;
                case 2 : $attend = 'attend_2'; $attend_string = "불참석"; break;
                case 3 : $attend = 'attend_3'; $attend_string = "미정"; break;
            }
        
            switch ($data['after_event']) {
                case 1 : $after_attend = 'attend_1'; $after_attend_string = "참석"; break;
                case 2 : $after_attend = 'attend_2'; $after_attend_string = "불참석"; break;
                case 3 : $after_attend = 'attend_3'; $after_attend_string = "미정"; break;
            }
            switch ($data['parking']) {
                case 0 : $parking =  "x"; break;
                case 1 : $parking =  "o"; break;
            }

            $table .= "<tr>"
                    ."<td>" . ++$no . "</td>"
                    ."<td  class='td_grade'>" . substr($data['grade'], -2, 2) . "</td>"
                    ."<td class='" . $attend . "'>". $data['name'] ."</td>"
                    ."<td class='" . $attend . "'> " . $attend_string . "</td>"
                    ."<td class='" . $after_attend . "'>" . $after_attend_string . "</td>"
                    ."<td>" . $data['extra_member'] . "</td>"
                    ."<td class='attend_2'>" . $parking . "</td>"
                ."</tr>";

                
            if ($data['message'] != "") {
                $table .= " <tr>
                        <td colspan=7>" . $data['message'] . "</td>
                    </tr>";
            }     
        }
    
        $table .= "</tbody></table>";
    
        echo $table;
    }

    //-- 관리자용 테이블 1
    function attendAdminDetail($search_id, $search_string) {
        // -- table
        $table = "
            <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th >No.</th>
                        <th >학번</th>
                        <th >이름</th>
                        <th >행사</th>
                        <th >뒤풀이</th>
                        <th >+인원</th>
                        <th >주차</th>
                        <th width='20%'>제출날짜</th>
                    </tr>
                </thead>
                <tbody>
            ";
        global $db_connect;

        
        if ($search_id == 'search_main') $order_sql = " main_event asc, ";
        else if ($search_id == 'search_after') $order_sql = " after_event asc, ";
        else if ($search_id == 'search_parking') $order_sql = " parking desc, ";
        else if ($search_id == 'search_grade') $add_sql = " and grade like '%${search_string}%' ";
        else if ($search_id == 'search_name') $add_sql = " and name like '%${search_string}%' ";

        $sql = "select m.*, a.*
                from `member` m, `attend` a
                where m.seq = a.member_seq ${add_sql}
                order by ${order_sql} grade asc";
        debug($sql);
        $result = mysqli_query($db_connect, $sql);
    
        $no = 0;
        while ($data = mysqli_fetch_assoc($result)) {
        

            switch ($data['main_event']) {
                case 1 : $attend = 'attend_1'; $attend_string = "참석"; break;
                case 2 : $attend = 'attend_2'; $attend_string = "불참석"; break;
                case 3 : $attend = 'attend_3'; $attend_string = "미정"; break;
            }
        
            switch ($data['after_event']) {
                case 1 : $after_attend = 'attend_1'; $after_attend_string = "참석"; break;
                case 2 : $after_attend = 'attend_2'; $after_attend_string = "불참석"; break;
                case 3 : $after_attend = 'attend_3'; $after_attend_string = "미정"; break;
            }
            switch ($data['parking']) {
                case 0 : $parking =  "x"; $parking_css=""; break;
                case 1 : $parking =  "o"; $parking_css="attend_1"; break;
            }

            $table .= "<tr>"
                    ."<td>" . ++$no . "</td>"
                    ."<td class='td_grade'>" . substr($data['grade'], -2, 2) . "</td>"
                    ."<td class='" . $attend . "'>". $data['name'] ."</td>"
                    ."<td class='" . $attend . "'> " . $attend_string . "</td>"
                    ."<td class='" . $after_attend . "'>" . $after_attend_string . "</td>"
                    ."<td>" . $data['extra_member'] . "</td>"
                    ."<td class='".$parking_css."'>" . $parking . "</td>"
                    ."<td>" . $data['date'] . "</td>"
                ."</tr>";

                
            if ($data['message'] != "") {
                $table .= " <tr>
                        <td colspan=8>" . $data['message'] . "</td>
                    </tr>";
            }     
        }
        $table .= "</tbody></table>";
    
        echo $table;
    }
    //-- 전체
    function attendAdminAll() {
        // -- table
        $table = "
            <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th >No.</th>
                        <th>학번</th>
                        <th>전체</th>
                        <th>행사</th>
                        <th>뒤풀이</th>
                        <th>+인원</th>
                        <th>주차</th>
                    </tr>
                </thead>
                <tbody>
            ";
        global $db_connect;
        $sql = "select grade, count(*) cnt, 
                    sum( IF(main_event = 1, 1, 0)) main, 
                    sum( IF(after_event = 1, 1, 0)) after, 
                    sum(extra_member) extra,
                    sum(parking) parking
                        from `member` m, `attend` a
                    where m.seq = a.member_seq
                        group by grade
                        order by grade asc";
        $result = mysqli_query($db_connect, $sql);
    
        $no = 0;
        $cnt = 0;
        $main = 0;
        $after = 0;
        $extra = 0;
        $parking = 0;
        while ($data = mysqli_fetch_assoc($result)) {
            $cnt += $data['cnt'];
            $main += $data['main'];
            $after += $data['after'];
            $extra += $data['extra'];
            $parking += $data['parking'];
            
            $table .= "<tr>"
                    ."<td>" . ++$no . "</td>"
                    ."<td class='td_grade'>" . substr($data['grade'], -2, 2) . "학번</td>"
                    ."<td class=''>" . $data['cnt'] . "</td>"
                    ."<td class=''>" . $data['main'] . "</td>"
                    ."<td class=''>" . $data['after'] . "</td>"
                    ."<td class=''>" . $data['extra'] . "</td>"
                    ."<td class=''>" . $data['parking'] . "</td>"
                ."</tr>";
  
        }
        $table .= "<tr class='text-import'>"
            ."<td colspan=2 style='text-align:center'> 전 체 </td>"
            ."<td class=''>" . $cnt ."</td>"
            ."<td class=''>" . $main ."</td>"
            ."<td class=''>" . $after . "</td>"
            ."<td class=''>" . $extra . "</td>"
            ."<td class=''>" . $parking . "</td>"
        ."</tr>";
        
        $table .= "</tbody></table>";
    
        echo $table;
    }
?>