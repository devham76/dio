<?php
    include_once "lib/lib_common.php";   
    
    global $db_connect;

    $_REQUEST['action']();
    /*
    if ( $_REQUEST['action'] == "attendCheck" ) attendCheck();
    else if ( $_REQUEST['action'] == "attendAdminDetail" ) attendAdminDetail();
    else if ( $_REQUEST['action'] == "attendAdminAll" ) attendAdminAll();
*/

    function attendCheck() {
        // -- table
        $table = "
            <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th width='3%'>No.</th>
                        <th width='20%'>학번</th>
                        <th width='20%'>이름</th>
                        <th width='16%'>행사</th>
                        <th width='16%'>뒷풀이</th>
                        <th width='25%'>제출날짜</th>
                    </tr>
                </thead>
                <tbody>
            ";
        global $db_connect;
        $sql = "select m.*, a.*
                from `member` m, `attend` a
                where m.seq = a.member_seq
                order by m.seq asc";
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

            $table .= "<tr>"
                    ."<td>" . ++$no . "</td>"
                    ."<td>" . substr($data['grade'], -2, 2) . "학번</td>"
                    ."<td class='" . $attend . "'>". $data['name'] ."</td>"
                    ."<td class='" . $attend . "'> " . $attend_string . "</td>"
                    ."<td class='" . $after_attend . "'>" . $after_attend_string . "</td>"
                    ."<td>" . $data['date'] . "</td>"
                ."</tr>";

                
            if ($data['message'] != "") {
                $table .= " <tr>
                        <td colspan=4>" . $data['message'] . "</td>
                    </tr>";
            }     
        }
    
        $table .= "</tbody></table>";
    
        echo $table;
    }

    //-- 관리자용
    function attendAdminDetail() {
        // -- table
        $table = "
            <table class='table table-striped table-sm'>
                <thead>
                    <tr>
                        <th >No.</th>
                        <th >학번</th>
                        <th >이름</th>
                        <th >행사</th>
                        <th >뒷풀이</th>
                        <th >+인원</th>
                        <th width='20%'>제출날짜</th>
                    </tr>
                </thead>
                <tbody>
            ";
        global $db_connect;
        $sql = "select m.*, a.*
                from `member` m, `attend` a
                where m.seq = a.member_seq
                order by grade asc";
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

            $table .= "<tr>"
                    ."<td>" . ++$no . "</td>"
                    ."<td>" . substr($data['grade'], -2, 2) . "학번</td>"
                    ."<td class='" . $attend . "'>". $data['name'] ."</td>"
                    ."<td class='" . $attend . "'> " . $attend_string . "</td>"
                    ."<td class='" . $after_attend . "'>" . $after_attend_string . "</td>"
                    ."<td>" . $data['extra_member'] . "</td>"
                    ."<td>" . $data['date'] . "</td>"
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
                        <th>뒷풀이</th>
                        <th>+인원</th>
                    </tr>
                </thead>
                <tbody>
            ";
        global $db_connect;
        $sql = "select grade, count(*) cnt, 
                    sum( IF(main_event = 1, 1, 0)) main, 
                    sum( IF(after_event = 1, 1, 0)) after, 
                    sum(extra_member) extra
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
        while ($data = mysqli_fetch_assoc($result)) {
            $cnt += $data['cnt'];
            $main += $data['main'];
            $after += $data['after'];
            $extra += $data['extra'];
            
            $table .= "<tr>"
                    ."<td>" . ++$no . "</td>"
                    ."<td>" . substr($data['grade'], -2, 2) . "학번</td>"
                    ."<td class=''>" . $data['cnt'] . "</td>"
                    ."<td class=''>" . $data['main'] . "</td>"
                    ."<td class=''>" . $data['after'] . "</td>"
                    ."<td class=''>" . $data['extra'] . "</td>"
                ."</tr>";
  
        }
        $table .= "<tr class='text-import'>"
            ."<td colspan=2 style='text-align:center'> 전 체 </td>"
            ."<td class=''>" . $cnt ."</td>"
            ."<td class=''>" . $main ."</td>"
            ."<td class=''>" . $after . "</td>"
            ."<td class=''>" . $extra . "</td>"
        ."</tr>";
        
        $table .= "</tbody></table>";
    
        echo $table;
    }
    //-- 제출 퍼센트
    function getAttend() {
        global $db_connect;
        $sql = "select grade, count(*) cnt, 
                    sum( IF(main_event = 1, 1, 0)) main, 
                    sum( IF(after_event = 1, 1, 0)) after, 
                    sum(extra_member) extra
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
        while ($data = mysqli_fetch_assoc($result)) {
            $cnt += $data['cnt'];
            $main += $data['main'];
            $after += $data['after'];
            $extra += $data['extra'];
  
        }
        
        echo $cnt;
    }
?>