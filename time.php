
<?php
include"connect.php";

$id = $_POST['id'];
$groupname = $_POST['groupname'];

$sql="select time from approvetime where id='$id' AND groupname='$groupname' ";

$q=mysql_query($sql); 

if(mysql_num_rows($q) == 0) {
	echo '[{"time":"0"}]';
}
else {
	while($e=mysql_fetch_assoc($q))

	      $output[]=$e;

 
	print (json_encode($output));
}
?>
