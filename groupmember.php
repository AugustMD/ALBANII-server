<?php
include"connect.php";

$groupname = $_POST['groupname'];
$groupcode = $_POST['groupcode'];
$id = $_POST['id']; 

$sql="select * from group where groupname='$groupname AND groupcode=$groupcode' ";

$q=mysql_query($sql);

$rows=mysql_num_rows($q);

if($rows == 1) {
echo -1; // 참여

$sq="INSERT INTO groupmember(id,groupname,pay)
VALUES('$id','$groupname','')";

if(!mysql_query($sq,$connect)) {
	die('Error: '.mysql_error());
}
}

else {
echo -2; // 참여 실패
}

?>
