<?php
include"connect.php";

$id = $_POST['id'];
$groupname = $_POST['groupname'];

$sql="select pay from groupmember where id='$id' and groupname='$groupname'";

$q=mysql_query($sql);
 
while($e=mysql_fetch_assoc($q))

      $output[]=$e;

print (json_encode($output));


