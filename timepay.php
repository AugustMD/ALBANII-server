
<?php
include"connect.php";

$id = $_POST['id'];
$groupname = $_POST['groupname'];

$sql="select pay from groupmember where id='$id' AND groupname='$groupname' ";

$q=mysql_query($sql); 

echo mysql_result($q, 0);
//echo 5580;
?>
