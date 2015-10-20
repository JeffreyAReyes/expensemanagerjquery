<?php
	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	
	$StartDate = htmlspecialchars($_REQUEST['StartDate']);
	$EndDate = htmlspecialchars($_REQUEST['EndDate']);
	
	//$EndDate = ($_REQUEST['EndDate']);
	//$SStartDate = ($_REQUEST['StartDate']);
	//If your MySQL column is DATE type:
	// $date = date('Y-m-d', strtotime(str_replace('-', '/', $date)));
	
	//$StartDate = date ('Y-m-d');
	//$EndDate = date ('Y-m-d');
	
	//$StartDate = date('Y-m-d', strtotime(str_replace('-', '/', $StartDate)));
	//$EndDate = date('Y-m-d', strtotime(str_replace('-', '/', $EndDate)));
	
	$dateFormattedStart = split('/', $StartDate);
	$dateFormattedEnd = split('/', $EndDate);
	
	$StartDate = $dateFormattedStart[2].'-'.$dateFormattedStart[0].'-'.$dateFormattedStart[1];
	$EndDate = $dateFormattedEnd[2].'-'.$dateFormattedEnd[0].'-'.$dateFormattedEnd[1];		
	
	include 'dbconfig.php';
	
	try {
	
	
	//# MySQL with PDO_MYSQL
	
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	
	$stmt = $dbh->prepare("CALL GetExpense(?, ?)");
	
	$stmt->bindParam (1, $StartDate, PDO::PARAM_STR);
	$stmt->bindParam (2, $EndDate, PDO::PARAM_STR);
	
	$stmt->execute();
	$data = $stmt->fetchAll(PDO::FETCH_ASSOC);	
	
	echo json_encode($data);
	
	
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

	

?>