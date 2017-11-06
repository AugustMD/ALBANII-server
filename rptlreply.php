<?php
include"connect.php";

$no = $_POST['no'];
$id = $_POST['id'];
$name = $_POST['name'];
$contents = $_POST['contents'];
$date = $_POST['date'];

$sql="INSERT INTO reply(no,id,name,contents,date)
VALUES('$no','$id','$name','$contents','$date')";

mysql_query("update notice set replynum=replynum+1 where no='$no' ");

if(!mysql_query($sql,$connect)) {
	die('Error: '.mysql_error());
}
else {
echo 0;
}
?>
