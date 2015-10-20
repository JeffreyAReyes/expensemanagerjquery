<?php

$PACTION = intval($_REQUEST['PACTION']);
$PayeeID = intval($_REQUEST['PayeeID']);
$PayeeName = htmlspecialchars($_REQUEST['PayeeName']);

include 'dbconfig.php';

try {
	
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$stmt = $dbh->prepare("CALL SavePayee(?,?,?)"); 	
	
	if ($PACTION==0) {
		//Add data		
		$stmt ->execute(array($PayeeID, $PayeeName,0)); 
		
		echo json_encode(array('PayeeID' => $PayeeID,'PayeeName' => $PayeeName));
	} 
	elseif ($PACTION==1)  {
		//Update data
		$stmt ->execute(array($PayeeID,$PayeeName,1 ));
		
		echo json_encode(array('PayeeID' => $PayeeID,'PayeeName' => $PayeeName));
	}
	else {
		//delete data
		$stmt ->execute(array($PayeeID,$PayeeName,2 ));
		
		echo json_encode(array('PayeeID' => $PayeeID,'PayeeName' => $PayeeName));
	}	
	
	
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

?>