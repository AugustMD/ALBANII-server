<?php
include"connect.php";

$groupname = $_POST['groupname'];
$id = $_POST['id'];
$date = $_POST['date'];
$time = $_POST['time'];
$mpay = $_POST['mpay'];

$sql="INSERT INTO wage(groupname,id,date,time,mpay)
VALUES('$groupname','$id','$date','$time','$mpay')";

mysql_query("delete from approvetime where groupname='$groupname' and id='$id' "); 

if(!mysql_query($sql,$connect)) {
	die('Error: '.mysql_error());
}
else {
echo 0;
}
?>
