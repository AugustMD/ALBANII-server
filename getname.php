
<?php
include"connect.php";

$id = $_POST['id'];

$sql="select name from member where id='$id'";

$q=mysql_query($sql); 

echo mysql_result($q,0);

?>
