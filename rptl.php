<?php
include"connect.php";

$groupname = $_POST['groupname'];
$contents = $_POST['contents'];

$sql="INSERT INTO board(no,groupname,contents)
VALUES('','$groupname','$contents')";

if(!mysql_query($sql,$connect)) {
	die('Error: '.mysql_error());
}
?>
