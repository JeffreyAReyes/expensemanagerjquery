<?php
	
	$sql_query = ($_REQUEST['sql_query']);	
	
	//$WhatToLoad = htmlspecialchars($_REQUEST['WhatToLoad']);
	 
	include 'dbconfig.php';
	
	try {
	
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $dbh->prepare("CALL $sql_query" );

	$stmt->execute();
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);	
	
	echo json_encode($data);
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>$e->getMessage()));
}

	
?>