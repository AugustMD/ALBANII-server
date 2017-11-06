<?php
include"connect.php";

$groupname = $_POST['groupname'];
$groupcode = $_POST['groupcode'];
$id = $_POST['id']; 

$sql="select * from makegroup where groupname='$groupname' AND groupcode='$groupcode' ";

$q=mysql_query($sql);

$rows=mysql_num_rows($q);

if(mysql_num_rows(mysql_query("select * from groupmember where id='$id' AND groupname = '$groupname'")) == 1) {
echo -3; // 중복
}

else if($rows == 1) {
echo -1; // 성공

$sq="INSERT INTO groupmember(id, groupname,pay)
VALUES('$id','$groupname','')";

if(!mysql_query($sq,$connect)) {
	die('Error: '.mysql_error());
}

}

else {
echo -2; // 실패
}

?>
