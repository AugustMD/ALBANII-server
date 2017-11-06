
<?php
include"connect.php";

$groupname = $_POST['groupname'];
$id = $_POST['id'];

$sql="select * from approvetime where groupname='$groupname' AND id='$id' order by no DESC ";

$q=mysql_query($sql); 

while($e=mysql_fetch_assoc($q))

      $output[]=$e;
 
print (json_encode($output));

?>
