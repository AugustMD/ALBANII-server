
<?php
include"connect.php";

$id = $_POST['id'];
$groupname = $_POST['groupname'];

$sql="select * from wage where id='$id' AND groupname='$groupname' order by date DESC ";

$q=mysql_query($sql); 

while($e=mysql_fetch_assoc($q))

      $output[]=$e;

 
print (json_encode($output));

?>
