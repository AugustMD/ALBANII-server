<?php
include"connect.php";

$id = $_POST['id'];
$groupname = $_POST['groupname'];
$pay = $_POST['pay'];

mysql_query("update groupmember set pay='$pay' where id='$id' and groupname='$groupname' ");

?>
