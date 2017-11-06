<?php

function db_connect() {
    $connect = mysqli_connect("localhost", "ars", "4rg0sarsadmin", "ars");
    mysqli_query($connect, "set names utf8");

    return $connect;
}

function sql_injection($get_str) {
    $str =  eregi_replace("( script| select| union| insert| update| delete| drop|\"|\'|#)","", $get_str);
    $str = eregi_replace("<","&lt;",$str);
    $str = eregi_replace(">","&gt;",$str);

    return $str;
}

function logging($connect, $id, $type, $reason)
{
    $id=sql_injection($id);
    $type=sql_injection($type);
    $reason=sql_injection($reason);
    $ip=$_SERVER['REMOTE_ADDR'];
    $ip=sql_injection($ip);

    $query = "insert into logs values('$id','$type', '$ip','$reason', now())";

    $result = mysqli_query($connect, $query);
}

function login($connect, $id, $pass)
{
    $id = sql_injection($id);
    $pass = md5($pass);

    $query = "select id,admin from user where id='$id' and pass='$pass'";

    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) == 1) {
        $rvalue = mysqli_fetch_assoc($result);
        logging($connect, $id, 'LOGIN' ,'Login success'); 
        $query = "update user set last_date=now() where id='$id'";
        mysqli_query($connect, $query);
    }
    else {
        $rvalue = 0;
        logging($connect, $id, 'LOGIN' ,'Login failure'); 
    }

    return $rvalue;
}
function insert_user($connect, $id, $pass, $grade, $egg, $email, $info, $adminid)
{
    $id = sql_injection($id);
    $pass = md5($pass);
    $grade = sql_injection($grade);
    $egg = sql_injection($egg);
    $email = sql_injection($email);
    $info = sql_injection($info);
    $adminid = sql_injection($adminid);

    $query = "insert into user values('$id','$pass','$grade', '$egg', '$email', '$info', now(), NULL, NULL)";
    $result = mysqli_query($connect, $query);

    if($result==1) {
        $rvalue = 1;
        logging($connect, $id, 'USER' ,"Sign up new user by $adminid");
    }
    else {
        $rvalue = 0;
    }

    return $rvalue;
}

function modify_user($connect, $id, $pass, $npass, $egg, $email, $info, $admin)
{
    $id = sql_injection($id);
    $pass = md5($pass);
    $npass = md5($npass);
    $egg = sql_injection($egg);
    $email = sql_injection($email);
    $info = sql_injection($info);
    $admin = sql_injection($admin);

    $query = "select id from user where id='$id' and pass='$pass'";
    $result = mysqli_query($connect, $query);
    if(mysqli_num_rows($result) == 1) {
        $query = "update user set pass='$npass', egg='$egg', email='$email', info='$info', admin='$admin' where id='$id' and pass='$pass'";
        $result = mysqli_query($connect, $query);
        if($result == 1) {
            $rvalue=1;
        }
    }

    return $rvalue;
}

function modify_user_admin($connect, $id, $grade, $egg, $email, $info, $admin, $pass)
{
    $id = sql_injection($id);
    $grade = sql_injection($grade);
    $egg = sql_injection($egg);
    $email = sql_injection($email);
    $info = sql_injection($info);
    $admin = sql_injection($admin);

    if($pass!=NULL) {
        $pass = md5($pass);
        $query = "update user set pass='$pass', grade='$grade', egg='$egg', email='$email', info='$info', admin='$admin' where id='$id'";
    }
    else {
        $query = "update user set grade='$grade', egg='$egg', email='$email', info='$info', admin='$admin' where id='$id'";
    }
    $result = mysqli_query($connect, $query);
    if($result == 1) {
        $rvalue=1;
    }

    return $rvalue;
}

function delete_user($connect, $id, $adminid)
{
    $id = sql_injection($id);
    $adminid = sql_injection($adminid);

    $query = "delete from user where id='$id'";
    $result = mysqli_query($connect, $query);

    if($result) {
        $rvalue = 1;
        logging($connect, $id, 'USER' ,"Delete user by $adminid");
    }

    return $rvalue;
}

function get_user($connect, $id)
{
    $id = sql_injection($id);

    $query = "select * from user where id='$id'";

    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) == 1) {
        $rvalue = mysqli_fetch_array($result);
    }

    return $rvalue;
}

function get_problem($connect, $no)
{
    $no = sql_injection($no);

    $query = "select * from problem where pno='$no'";

    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) == 1) {
        $rvalue = mysqli_fetch_array($result);
    }

    return $rvalue;
}

function get_problem_list($connect, $type, $id, $admin)
{
    $type = sql_injection($type);
    $id = sql_injection($id);
    $admin = sql_injection($admin);

    if( $type == 0) {
        if($admin==1)
            $query = "select pno, name, type, point, bopen, (select if(pno, 1, 0) from solved where solved.pno=problem.pno and solved.id='$id') solve from problem";
        else
            $query = "select pno, name, type, point, bopen, (select if(pno, 1, 0) from solved where solved.pno=problem.pno and solved.id='$id') solve from problem where bopen=1";
    }
    else {
        if($admin==1)
            $query = "select pno, name, type, point, bopen, (select if(pno, 1, 0) from solved where solved.pno=problem.pno and solved.id='$id') solve from problem where type='$type'";
        else
            $query = "select pno, name, type, point, bopen, (select if(pno, 1, 0) from solved where solved.pno=problem.pno and solved.id='$id') solve from problem where bopen=1 and type='$type'";
    }

    $result = mysqli_query($connect, $query);

    while( $row = mysqli_fetch_assoc($result) )  {
        $rvalue[] = $row;
    }

    return $rvalue;
}

function get_problem_type($connect, $admin)
{
    $admin=sql_injection($admin);

    if($admin==1) {
        $query = "select no, name, (select count(*) from problem where problem.type=problem_type.no) as count from problem_type";
    }
    else {
        $query = "select no, name, (select count(*) from problem where problem.type=problem_type.no and problem.bopen=1) as count from problem_type";
    }
    $result = mysqli_query($connect, $query);

    while( $row = mysqli_fetch_assoc($result) ) {
        $rvalue[] = $row;
    }

    return $rvalue;
}

function get_problem_type_no($connect, $no)
{
    $no=sql_injection($no);

    $query = "select * from problem_type where no='$no'";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) == 1)
        $rvalue = mysqli_fetch_assoc($result);
    else
        $rvalue = 0;

    return $rvalue;
}

function insert_problem_type($connect, $name) {
    $name = sql_injection($name);

    $query = "insert into problem_type values(NULL, '$name')";

    $result = mysqli_query($connect, $query);
    if($result)
        $rvalue = 1;

    return $rvalue;
}

function delete_problem_type($connect, $id, $no)
{
    $id = sql_injection($id);
    $no = sql_injection($no);

    $query = "delete from problem_type where no='$no'";
    $result = mysqli_query($connect, $query);

    if($result) {
        $rvalue = 1;

        // Realign no
        $query = "alter table problem_type AUTO_INCREMENT=1;";
        $query .= "SET @COUNT=0;";
        $query .= "UPDATE problem_type set no=@COUNT:=@COUNT+1";
        mysqli_multi_query($connect, $query);
    }

    return $rvalue;
}

function modify_problem_type($connect, $no, $name)
{
    $no = sql_injection($no);
    $name = sql_injection($name);

    $query = "update problem_type set name='$name' where no='$no'";

    $result = mysqli_query($connect, $query);
    if($result)
        $rvalue = 1;

    return $rvalue;
}

function get_egg_list($connect) {
    $query = "select * from egg_type";

    $result = mysqli_query($connect, $query);

    while( $row = mysqli_fetch_assoc($result) ) {
        $rvalue[] = $row;
    }

    return $rvalue;
}

function get_egg_no($connect, $no) {
    $no = sql_injection($no);
    $query = "select * from egg_type where no='$no'";

    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) == 1)
        $rvalue = mysqli_fetch_assoc($result);
    else
        $rvalue = 0;

    return $rvalue;
}

function modify_egg($connect, $no, $name)
{
    $no = sql_injection($no);
    $name = sql_injection($name);

    $query = "update egg_type set name='$name' where no='$no'";

    $result = mysqli_query($connect, $query);
    if($result)
        $rvalue = 1;

    return $rvalue;
}

function auth($connect, $pno, $id, $pass, $dc)
{
    $pno=sql_injection($pno);
    $id=sql_injection($id);
    $pass=sql_injection($pass);
    $dc=sql_injection($dc);

    // get problem name
    $query = "select name from problem where pno='$pno'";
    $result = mysqli_query($connect, $query);
    $pname = mysqli_fetch_assoc($result);

    // check duplicate auth
    $query = "select * from solved where pno='$pno' and id='$id'";
    $result = mysqli_query($connect, $query);
    if(mysqli_num_rows($result) == 0) {
        $query = "select * from problem where pno='$pno' and passwd=md5('$pass')";
        $result = mysqli_query($connect, $query);
        if(mysqli_num_rows($result) == 1) {
            $query = "insert into solved values('$pno', '$id', '$dc', now())";
            $result = mysqli_query($connect, $query);
            if($result) {
                $rvalue = 1;
                logging($connect, $id, 'AUTH' ,"Auth success($pname[name])"); 
            }
            else
                $rvalue = 0;
        }
        else
        {
            logging($connect, $id, 'AUTH' ,"Auth failure($pname[name])"); 
            $rvalue = 0;
        }
    }
    else {
        logging($connect, $id, 'AUTH' ,"Duplicate auth($pname[name])"); 
        $rvalue = 0;
    }

    return $rvalue;
}

function check_id($connect, $id)
{
    $id = sql_injection($id);

    $query = "select id from user where id='$id'";
    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) > 0)
        $rvalue = 1;

    return $rvalue;
}

function get_grade_type($connect)
{
    $query = "select LPAD(grade, 2, 0) as grade from user group by grade asc";

    $result = mysqli_query($connect, $query);

    while( $row = mysqli_fetch_assoc($result) ) {
        $rvalue[] = $row;
    }

    return $rvalue;
}

function get_rank_list($connect, $type, $subtype)
{
    $type = sql_injection($type);
    $subtype = sql_injection($subtype);

    if($type=="all") {
        $query ="select id, (select ifnull(sum(problem.point), 0) from problem,solved where solved.id=user.id and solved.pno=problem.pno and problem.bopen=1) as point, last_date from user where not id='admin' order by point desc";
    }
    else if($type=="egg") {
        if($subtype=="") {
            $query = "select egg_type.no as id, sum((select ifnull(sum(problem.point), 0) from problem,solved,user where solved.id=user.id and user.egg=egg_type.no and solved.pno=problem.pno and problem.bopen=1)) as point from egg_type group by egg_type.no order by point desc";
        }
        else {
            $query ="select id, (select ifnull(sum(problem.point), 0) as point from problem,solved where solved.id=user.id and solved.pno=problem.pno and problem.bopen=1) as point from user where not id='admin' and egg='$subtype' order by point desc";
        }
    }
    else if($type=="grade") {
        if($subtype=="") {
            $query ="select LPAD(grade, 2, 0) as id, sum((select ifnull(sum(problem.point), 0) from problem,solved where solved.id=user.id and solved.pno=problem.pno and problem.bopen=1)) as point from user where not id='admin' group by grade order by point desc";
        }
        else {
            $query ="select id, (select ifnull(sum(problem.point), 0) as point from problem,solved where solved.id=user.id and solved.pno=problem.pno and problem.bopen=1) as point from user where not id='admin' and grade='$subtype' order by point desc";
        }
    }
    else if($type=="subgrade") {
        $query ="select id, (select ifnull(sum(problem.point), 0) as point from problem,solved where solved.id=user.id and solved.pno=problem.pno and problem.bopen=1) as point from user where not id='admin' and grade='$subtype' order by point desc";
    }

    $result = mysqli_query($connect, $query);

    while( $row = mysqli_fetch_assoc($result) ) 
    {
        $rvalue[] = $row;
    }

    return $rvalue;
}

function get_solved_problem($connect, $id) {
    $id = sql_injection($id);

    $query = "select problem.name as name, problem.type as type, problem.point as point, solved.date from solved,problem where solved.pno=problem.pno and solved.id='$id' and problem.bopen=1 order by date desc";

    $result = mysqli_query($connect, $query);

    while( $row = mysqli_fetch_assoc($result) ) {
        $rvalue[] = $row;
    }

    return $rvalue;
}

function get_log_list($connect)
{
    $query = "select * from logs order by date desc limit 50";

    $result = mysqli_query($connect, $query);

    while( $row = mysqli_fetch_assoc($result) ) {
        $rvalue[] = $row;
    }

    return $rvalue;
}

function insert_egg($connect, $egg) {
    $rvalue = 0;
    $egg = sql_injection($egg);

    $query = "insert into egg_type values(NULL, '$egg')";

    $result = mysqli_query($connect, $query);
    if($result)
        $rvalue = 1;

    return $rvalue;
}

function delete_egg($connect, $id, $no)
{
    $id = sql_injection($id);
    $no = sql_injection($no);

    $query = "delete from egg_type where no='$no'";

    $result = mysqli_query($connect, $query);
    if($result) {
        $rvalue = 1;

        // Realign no
        $query = "alter table egg_type AUTO_INCREMENT=1;";
        $query .= "SET @COUNT=0;";
        $query .= "UPDATE egg_type set no=@COUNT:=@COUNT+1";
        mysqli_multi_query($connect, $query);
    }

    return $rvalue;
}

function write_notice($connect, $id, $contents)
{
    $id = sql_injection($id);
    $contents = sql_injection($contents);

    $query = "insert into notice values(NULL, '$contents', now())";

    $result = mysqli_query($connect, $query);
    if($result)
    {
        $rvalue = 1;
        logging($connect, $id, 'NOTICE' ,'Post a new notice'); 
    }

    return $rvalue;
}

function modify_notice($connect, $no, $contents)
{
    $no = sql_injection($no);
    $contents = sql_injection($contents);

    $query = "update notice set contents='$contents' where no='$no'";

    $result = mysqli_query($connect, $query);
    if($result)
        $rvalue = 1;

    return $rvalue;
}

function delete_notice($connect, $id, $no)
{
    $id = sql_injection($id);
    $no = sql_injection($no);

    $query = "delete from notice where no='$no'";

    $result = mysqli_query($connect, $query);
    if($result)
    {
        $rvalue = 1;
        logging($connect, $id, 'NOTICE' ,'Delete a notice'); 
    }

    return $rvalue;
}

function modify_problem($connect, $no, $name, $type, $point, $contents, $bopen)
{
    $no = sql_injection($no);
    $name = sql_injection($name);
    $type = sql_injection($type);
    $point= sql_injection($point);
    $contents = sql_injection($contents);
    $bopen= sql_injection($bopen);

    $query = "update problem set name='$name', type='$type', point='$point', contents='$contents', bopen='$bopen' where pno='$no'";

    $result = mysqli_query($connect, $query);
    if($result)
        $rvalue = 1;

    return $rvalue;
}

function insert_problem($connect, $id, $name, $type, $point, $contents, $key, $bopen)
{
    $id = sql_injection($id);
    $name = sql_injection($name);
    $type = sql_injection($type);
    $point= sql_injection($point);
    $contents = sql_injection($contents);
    $key = md5($key);
    $bopen= sql_injection($bopen);

    $query = "insert into problem values(NULL, '$name', '$type', '$point', '$contents', '$key', '$bopen')";

    $result = mysqli_query($connect, $query);
    if($result)
    {
        $rvalue = 1;
        logging($connect, $id, 'PROBLEM' ,"New problem($name)");
    }

    return $rvalue;
}

function delete_problem($connect, $id, $no)
{
    $id = sql_injection($id);
    $no = sql_injection($no);

    $query = "select name from problem where pno='$no'";
    $result = mysqli_query($connect, $query);
    $pname = mysqli_fetch_assoc($result);

    $query = "delete from problem where pno='$no'";

    $result = mysqli_query($connect, $query);
    if($result)
    {
        $rvalue = 1;
        logging($connect, $id, 'PROBLEM' ,"Delete problem($pname[name])");
    }

    return $rvalue;
}

function get_notice($connect)
{
    $query = "select * from notice order by date desc";

    $result = mysqli_query($connect, $query);
    while( $row = mysqli_fetch_assoc($result) ) 
    {
        $rvalue[] = $row;
    }

    return $rvalue;
}

function get_notice_no($connect, $no)
{
    $no = sql_injection($no);

    $query = "select * from notice where no='$no'";

    $result = mysqli_query($connect, $query);

    if(mysqli_num_rows($result) == 1)
        $rvalue = mysqli_fetch_assoc($result);
    else
        $rvalue = 0;

    return $rvalue;
}

function get_admin_list($connect) {
    $query = "select id from user where admin='1'";

    $result = mysqli_query($connect, $query);
    while( $row = mysqli_fetch_assoc($result) ) 
    {
        $rvalue[] = $row;
    }
    return $rvalue;
}
