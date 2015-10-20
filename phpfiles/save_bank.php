<?php

$PACTION = intval($_REQUEST['PACTION']);
$BID = intval($_REQUEST['BID']);
$BankSymbol = htmlspecialchars($_REQUEST['BankSymbol']);
$CompanyName = htmlspecialchars($_REQUEST['CompanyName']);

include 'dbconfig.php';

try {
	
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$stmt = $dbh->prepare("CALL AddUpdateDeleteBank(?,?,?,?)"); 	
	
	if ($PACTION==0) {
		//Add data		
		$stmt ->execute(array(0, $BID,$BankSymbol,$CompanyName)); 
		//echo json_encode(array('CatID' => $CatID,'SubCategoryName' => $SubCategoryName));
		echo json_encode(array('BID' => $BID,'BankSymbol' => $BankSymbol));
	} 
	elseif ($PACTION==1)  {
		//Update data
		$stmt ->execute(array(1, $BID,$BankSymbol,$CompanyName ));
		//echo json_encode(array('CatID' => $CatID,'SubCategoryName' => $SubCategoryName));
		echo json_encode(array('BID' => $BID,'BankSymbol' => $BankSymbol));
	}
	else {
		//delete data
		$stmt ->execute(array(2, $BID,$BankSymbol,$CompanyName)); 
		//echo json_encode(array('CatID' => $CatID,'SubCategoryName' => $SubCategoryName));
		echo json_encode(array('BID' => $BID,'BankSymbol' => $BankSymbol));
	}	
	
	
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

?>