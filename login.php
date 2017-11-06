<?php
include"connect.php";

$id = $_POST['id'];
$pw = $_POST['pw'];

$sql="select id,part from member where id='$id' AND pw='$pw' ";

$q=mysql_query($sql);

$rows=mysql_num_rows($q);

if($rows == 1) {
echo mysql_result($q, 0, 0);//id
echo "\n";
echo mysql_result($q, 0, 1);//part
}
else {
echo 0;
}


//while($e=mysql_fetch_assoc($q))

//      $output[]=$e;

 
//print (json_encode($output));
 

?>
