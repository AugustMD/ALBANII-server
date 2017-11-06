
<?php
include"connect.php";

$no = $_POST['no'];

$sql="select * from reply where no='$no'";

$q=mysql_query($sql); 

while($e=mysql_fetch_assoc($q))

      $output[]=$e;

 
print (json_encode($output));

?>
