<?php

$IID = intval($_REQUEST['IID']);
$CatID = intval($_REQUEST['CatID']);
$SubCatID = intval($_REQUEST['SubCatID']);
$RefNum = htmlspecialchars($_REQUEST['RefNum']);
$TransDate = htmlspecialchars($_REQUEST['TransDate']);
$Payee = htmlspecialchars($_REQUEST['Payee']);
$Amount = floatval($_REQUEST['Amount']);
$Remarks = htmlspecialchars($_REQUEST['Remarks']);

$dateFormated = split('/', $TransDate);
$TransDate = $dateFormated[2].'-'.$dateFormated[0].'-'.$dateFormated[1];

include 'dbconfig.php';

try {
	
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	
	$stmt = $dbh->prepare("CALL AddUpdateIncome(?, ?,?,?,?,?,?,?,?)"); 
	
	//$stmt ->execute(array(0, $CatID,$SubCatID,$RefNum,$Payee,$Amount,$Remarks,0)); 
	
	if ($IID==0) {
		
		$stmt ->execute(array(0, $CatID,$SubCatID,$RefNum,$Payee,$Amount,$Remarks,0,$TransDate )); 
	} else {
		
		$stmt ->execute(array(1, $CatID,$SubCatID,$RefNum,$Payee,$Amount,$Remarks,$IID,$TransDate  )); 
		}	
	
	//echo json_encode(array('CatID' => $CatID,'SubCategoryName' => $SubCategoryName));
	echo json_encode(array('CatID' => $CatID,'RefNum' => $RefNum));
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

?>