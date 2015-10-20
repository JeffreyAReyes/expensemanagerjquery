<?php
	$BAID = intval($_REQUEST['BAID']);
	
	//$StartDate = htmlspecialchars($_REQUEST['StartDate']);
	//$EndDate = htmlspecialchars($_REQUEST['EndDate']);
		
	//$dateFormattedStart = split('/', $StartDate);
	//$dateFormattedEnd = split('/', $EndDate);
	
	//$StartDate = $dateFormattedStart[2].'-'.$dateFormattedStart[0].'-'.$dateFormattedStart[1];
	//$EndDate = $dateFormattedEnd[2].'-'.$dateFormattedEnd[0].'-'.$dateFormattedEnd[1];		
	
	include 'dbconfig.php';
	
	try {
	
	
	//# MySQL with PDO_MYSQL
	
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	
	$stmt = $dbh->prepare("CALL GetBankAccountsLedgerByID(?)");
	
	$stmt->bindParam (1, $BAID, PDO::PARAM_INT);	
	
	$stmt->execute();
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);	
	
	echo json_encode($data);		
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

	

?>