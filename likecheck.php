
<?php
include"connect.php";

$groupname = $_POST['groupname'];
$id = $_POST['id'];

$sql="select no from boardlike where id='$id' AND no in (select no from board where groupname='$groupname') ";

$q=mysql_query($sql); 

while($e=mysql_fetch_assoc($q))

      $output[]=$e;

 
print (json_encode($output));

?>
