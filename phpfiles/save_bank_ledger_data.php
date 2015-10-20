<?php

$PACTION = intval($_REQUEST['PACTION']);
$BAID = intval($_REQUEST['BAID']);
$RefNumber = htmlspecialchars($_REQUEST['RefNumber']);
$TransDate = htmlspecialchars($_REQUEST['TransDate']);
$Debit = floatval($_REQUEST['Debit']);
$Credit = floatval($_REQUEST['Credit']);
$Remarks = htmlspecialchars($_REQUEST['Remarks']);
$BALID = intval($_REQUEST['BALID']);

/* Mysql date format */
$dateFormated = split('/', $TransDate);
$TransDate = $dateFormated[2].'-'.$dateFormated[0].'-'.$dateFormated[1];

include 'dbconfig.php';

try {
	
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
	$stmt = $dbh->prepare("CALL SaveBankAccountsLedger(?,?,?,?,?,?,?,?)"); 	
	
	if ($PACTION==0) {
		//Add data		
		$stmt ->execute(array(0,$BAID, $RefNumber,$TransDate,$Debit,$Credit,$Remarks,$BALID)); 
		
		echo json_encode(array('BALID' => $BALID,'RefNumber' => $RefNumber));
	} 
	elseif ($PACTION==1)  {
		//Update data
		$stmt ->execute(array(1,$BAID, $RefNumber,$TransDate,$Debit,$Credit,$Remarks,$BALID)); 
		
		echo json_encode(array('BALID' => $BALID,'RefNumber' => $RefNumber));
	}
	else {
		//delete data
		$stmt ->execute(array(2,$BAID, $RefNumber,$TransDate,$Debit,$Credit,$Remarks,$BALID)); 
		
		echo json_encode(array('BALID' => $BALID,'RefNumber' => $RefNumber));
	}	
	
	
}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

?>