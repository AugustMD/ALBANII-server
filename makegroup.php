<?php
include"connect.php";

$groupname = $_POST['groupname'];
$groupcode = $_POST['groupcode'];
$id = $_POST['id']; //���� Ȯ�ο� id

$sql="select * from makegroup where groupname='$groupname' ";

$q=mysql_query($sql);

$rows=mysql_num_rows($q);

if($rows == 1) {
echo 1; // ����
}

else {
echo 0; // ����

$sq="INSERT INTO makegroup(id, groupname,groupcode)
VALUES('$id','$groupname','$groupcode')";

if(!mysql_query($sq,$connect)) {
	die('Error: '.mysql_error());
}
}

?>
