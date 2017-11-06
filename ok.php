<?php
include"connect.php";

$no = $_POST['no'];
$groupname = $_POST['groupname'];
$id = $_POST['id'];
$name = $_POST['name'];
$date = $_POST['date'];
$time = $_POST['time'];
$approvedate = $_POST['approvedate'];

$sql="INSERT INTO approvetime(no,groupname,id,name,time,date,approvedate)
VALUES('$no','$groupname','$id','$name','$time','$date','$approvedate')";

mysql_query("delete from unapprovedtime where no='$no' and groupname='$groupname' and id='$id' "); 

if(!mysql_query($sql,$connect)) {
	die('Error: '.mysql_error());
}
else {
echo 0;
}
?>
