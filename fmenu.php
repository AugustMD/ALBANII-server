<?php
include"connect.php";

$id = $_POST['id'];

$sql="select groupname from groupmember where id='$id' ";

$q=mysql_query($sql);

$rows=mysql_num_rows($q);

if($rows == 0) {
echo 0;
}

else {
while($e=mysql_fetch_assoc($q))

      $output[]=$e;

 
print (json_encode($output));
}

//if($rows >= 1) {
//echo mysql_result($q,0,0);
//}

//if($rows >= 2) {
//echo "\n";
//echo mysql_result($q,1,0);
//}

//if($rows == 3) {
//echo "\n";
//echo mysql_result($q,2,0);
//}


?>
