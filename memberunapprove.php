<?php
include"connect.php";

$id = $_POST['id'];
$groupname = $_POST['groupname'];

$sql="select * from unapprovedtime where id = '$id' and groupname = '$groupname' ";

$q=mysql_query($sql);

$rows=mysql_num_rows($q);
 
print '[{"rows":"'.$rows.'"}]';

