<?php
	
	$CatID = intval($_REQUEST['CatID']);
		
	include 'dbconfig.php';
	
	try {
	
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	
	$stmt = $dbh->prepare("CALL GetSubCategories(?)");
	$stmt->bindValue(1 ,$CatID, PDO::PARAM_INT);
	
	$stmt->execute();
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);	
	
	echo json_encode($data);
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured while processing requests.'));
}

	

?>