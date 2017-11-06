
<?

	// 데이터베이스 접속 문자열. (db위치, 유저 이름, 비밀번호)

	$connect=mysql_connect( "localhost", "kjm0818", "dkfqksl") or  

        die( "SQL server에 연결할 수 없습니다.");

	mysql_query("set names utf8");    	

	// 데이터베이스 선택

	$mysql=mysql_select_db("kjm0818",$connect);


	if(!$connect) {echo "not connect";}
	if(!$mysql) {echo "not connect2";}

	
?>