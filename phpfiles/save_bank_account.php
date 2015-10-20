<?php

$PACTION = intval($_REQUEST['PACTION']);
$BID = intval($_REQUEST['BID']);
$BAID = intval($_REQUEST['BAID']);
$AccountType = htmlspecialchars($_REQUEST['AccountType']);
$AccountDetails = htmlspecialchars($_REQUEST['AccountDetails']);

include 'dbconfig.php';

try {
	
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$stmt = $dbh->prepare("CALL AddUpdateDeleteBankAcount(?,?,?,?,?)"); 	
	
	if ($PACTION==0) {
		//Add data		
		$stmt ->execute(array(0,$BID, $AccountType,$AccountDetails,$BAID)); 
		
		echo json_encode(array('BAID' => $BAID,'AccountType' => $AccountType));
	} 
	elseif ($PACTION==1)  {
		//Update data
		$stmt ->execute(array(1,$BID, $AccountType,$AccountDetails,$BAID)); 
		
		echo json_encode(array('BAID' => $BAID,'AccountType' => $AccountType));
	}
	else {
		//delete data
		$stmt ->execute(array(2,$BID, $AccountType,$AccountDetails,$BAID)); 
		
		echo json_encode(array('BAID' => $BAID,'AccountType' => $AccountType));
	}	
	
	
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

?>