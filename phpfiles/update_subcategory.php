<?php

$CatID = intval($_REQUEST['CatID']);
$SubCatID = intval($_REQUEST['SubCatID']);
$SubCategoryName = htmlspecialchars($_REQUEST['SubCategoryName']);

include 'dbconfig.php';

try {
	
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 	
	$stmt = $dbh->prepare("CALL AddSubCategory(?, ?,?,?)"); 
	$stmt ->execute(array($CatID, $SubCategoryName,1,$SubCatID)); 
	
	//$result='1';	
	echo json_encode(array('CatID' => $CatID,'SubCategoryName' => $SubCategoryName));

}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

?>