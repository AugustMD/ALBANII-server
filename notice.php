
<?php
include"connect.php";

$groupname = $_POST['groupname'];

$sql="select * from notice where groupname='$groupname' order by no DESC ";

$q=mysql_query($sql); 

while($e=mysql_fetch_assoc($q))

      $output[]=$e;
 
print (json_encode($output));

?>
