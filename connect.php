
<?

	// �����ͺ��̽� ���� ���ڿ�. (db��ġ, ���� �̸�, ��й�ȣ)

	$connect=mysql_connect( "localhost", "kjm0818", "dkfqksl") or  

        die( "SQL server�� ������ �� �����ϴ�.");

	mysql_query("set names utf8");    	

	// �����ͺ��̽� ����

	$mysql=mysql_select_db("kjm0818",$connect);


	if(!$connect) {echo "not connect";}
	if(!$mysql) {echo "not connect2";}

	
?>