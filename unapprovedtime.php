
<?php
include"connect.php";

$groupname = $_POST['groupname'];
$id = $_POST['id'];

$sql="select * from unapprovedtime where groupname='$groupname' AND id='$id' order by no DESC ";

$q=mysql_query($sql); 

if(mysql_num_rows($q) == 0) {
	echo '[{"time":"0","no":"0","groupname":"0","id":"0","name":"0","date":"0"}]';
}
else {
	while($e=mysql_fetch_assoc($q))

	      $output[]=$e;
 
	print (json_encode($output));
}

?>
