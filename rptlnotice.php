<?php
include"connect.php";

$groupname = $_POST['groupname'];
$title = $_POST['title'];
$contents = $_POST['contents'];
$date = $_POST['date'];

$sql="INSERT INTO notice(no,groupname,title,contents,date,replynum)
VALUES('','$groupname','$title','$contents','$date','')";

if(!mysql_query($sql,$connect)) {
	die('Error: '.mysql_error());
}
else {
echo 0;
}
?>
