<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	
	include 'dbconfig.php';
	
	try {
	//# MS SQL Server and Sybase with PDO_DBLIB
	//$DBH = new PDO("mssql:host=$host;dbname=$dbname, $user, $pass");
	//$DBH = new PDO("sybase:host=$host;dbname=$dbname, $user, $pass");
 
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 
	//# SQLite Database
	//$DBH = new PDO("sqlite:my/database/path/database.db");
  
	$stmt = $dbh->query("CALL GetAllPayee()");
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);
	echo json_encode($data);
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

	

?>