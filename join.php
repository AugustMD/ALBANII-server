<?php
include"connect.php";

$part = $_POST['part'];
$id = $_POST['id'];
$pw = $_POST['pw'];
$name = $_POST['name'];
$phone = $_POST['phone'];

$sql="select * from member where id='$id' ";

$q=mysql_query($sql);

$rows=mysql_num_rows($q);

if($rows == 1) {
echo 1;
}

else {
echo 0;

$sq="INSERT INTO member(part,id,pw,name,phone)
VALUES('$part','$id','$pw','$name','$phone')";

if(!mysql_query($sq,$connect)) {
	die('Error: '.mysql_error());
}
}

?>
