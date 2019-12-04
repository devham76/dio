<?php
    include_once "lib/lib_common.php";    

    foreach ($_REQUEST as $key => $val) $$key = $val;
        
    $db_connect = db_connect();
    /*
    // 1. member 테이블에 해당 사람 있는지 확인
    $sql = "select count(*) cnt from member where grade = '$grade' and name='$name'";
    debug("db conn : " . $db_connect);
    debug($sql);
    $result = mysqli_query( $db_connect, $sql);
    debug("result : ". $result);
    //$data = mysqli_fetch_array($result);
    //debug_array($data);
    
    // 1.1 member에 데이터가 없으면 추가
    /*
    if ($data['cnt'] == 0){
        $ins_sql = "insert into member (name, grade) values ('$name', '$grade')";
    }

    $select_sql = "select seq from member where grade = '$grade' and name='$name'";
    $result = mysqli_query( $db_connect, $select_sql );
    $data = mysqli_fetch_assoc($result);
    $member_seq = $data['seq'];
    // 2. attend에 데이터 추가

       // $ins_sql ="insert into attend 
                          member_seq = '$member_seq'
                        , main_event = 
                        , after_event = 
                        , extra_member = '$extraPeoples'
                        , message = '$message'
                        , data = '" . data . "'";


       	seq int not null auto_increment,
	member_seq int not null,
	main_event int not null,
	after_event int not null,
	extra_member int default 0,
	message text,
	date date not null,
	primary key (seq)
    */
        
    echo "submit php";
?>