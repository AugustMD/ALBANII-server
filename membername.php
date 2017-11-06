<?php
include"connect.php";

$groupname = $_POST['groupname'];

$sql="select name,id from member where id in (select id from groupmember where groupname='$groupname') ";

$q=mysql_query($sql);

$rows=mysql_num_rows($q);

while($e=mysql_fetch_assoc($q))

      $output[]=$e;

 
print (json_encode($output));

