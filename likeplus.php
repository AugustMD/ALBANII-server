
<?php
include"connect.php";

$no = $_POST['no'];
$id = $_POST['id'];

$sql="UPDATE board SET likeplus=likeplus+1 WHERE no='$no' ";

mysql_query($sql); 

$sq="insert into boardlike(no,id)
VALUES('$no','$id')";

mysql_query($sq);
?>