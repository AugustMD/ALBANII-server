<?php
include"connect.php";

$groupname = $_POST['groupname'];

$sql="select id,name,phone,part from member where id in (select id from groupmember where groupname='$groupname' UNION select id from makegroup where groupname='$groupname') ";

$q=mysql_query($sql);

while($e=mysql_fetch_assoc($q))

      $output[]=$e;

 
print (json_encode($output));

?>
