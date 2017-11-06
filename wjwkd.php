
<?php
include"connect.php";

$groupname = $_POST['groupname'];
$id = $_POST['id'];

$sq = "select name from member where id='$id'";
$s = mysql_query($sq);

$name = mysql_result($s,0);
$time = $_POST['time'];
$date = $_POST['date'];

$sql="INSERT INTO unapprovedtime(no,groupname,id,name,time,date)
VALUES('','$groupname','$id','$name','$time','$date')";

$q=mysql_query($sql); 

?>
