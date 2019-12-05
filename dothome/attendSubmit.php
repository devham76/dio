<?php
    include_once "lib/lib_common.php";    

    foreach ($_REQUEST as $key => $val) $$key = $val;
        
    //$db_connect = db_connect();
    
    // 1. member 테이블에 해당 사람 있는지 확인
    $sql = "select count(*) cnt from `member` where grade = '$grade' and name='$name'";
    debug("-----attendSubmit php -----");
    debug($sql);
    $result = mysqli_query( $db_connect, $sql); // $result 또는 $db_connect를 echo하거나 debug를 찍으면 값이 안나올수있음
    $cnt = mysqli_fetch_assoc($result);
    // 1.1 member에 데이터가 없으면 추가
    if ($cnt['cnt'] == '0'){
        echo "cnt == 0 ";
        $ins_sql = "INSERT INTO `member` (name, grade) VALUES ('$name', '$grade')";
        debug($ins_sql);
        $r = mysqli_query( $db_connect, $ins_sql );
        //debug("member insert : " + $ins_result);
    }
    
    // member의 seq가져오기
    $select_sql = "select seq from `member` where grade = '$grade' and name='$name'";
    $result = mysqli_query( $db_connect, $select_sql );
    $data = mysqli_fetch_assoc($result);
    $member_seq = $data['seq'];

    if(!$member_seq) {
        echo "오류발생..";
        exit;
    }
    // 2. attend에 이미 있으면 삭제
    $del_sql = "delete from `attend` where member_seq = '$member_seq'";
    mysqli_query($db_connect, $del_sql);
    debug($del_sql);

    // 3. attend에 데이터 추가

    //-- main 행사 1:참여 2:불참 3:미정
    //-- after 행사 1:참여 2:불참 3:미정
    $extraPeople = $extraPeople ? $extraPeople : 0;
    $ins_sql ="insert into `attend` set
                          member_seq = '$member_seq'
                        , main_event = '$attend'
                        , after_event = '$after_attend'
                        , extra_member = '$extraPeople'
                        , message = '$message'
                        , date = '" . date('Y-m-d H:i:s') . "'";
    debug($ins_sql);
    $result = mysqli_query( $db_connect, $ins_sql );
    debug("attend insert : " + $result);
    
    echo "submit php!!";
?>