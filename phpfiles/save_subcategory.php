<?php

$CatID = intval($_REQUEST['CatID']);
$SubCategoryName = htmlspecialchars($_REQUEST['SubCategoryName']);

include 'dbconfig.php';

try {
	//# MS SQL Server and Sybase with PDO_DBLIB
	//$DBH = new PDO("mssql:host=$host;dbname=$dbname, $user, $pass");
	//$DBH = new PDO("sybase:host=$host;dbname=$dbname, $user, $pass");
 
	//# MySQL with PDO_MYSQL
	$dbh = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
 
	//# SQLite Database
	//$DBH = new PDO("sqlite:my/database/path/database.db");
  
	//$stmt = $dbh->query("CALL AddSubCategory(?,?,?,?)");
	
	//$stmt->bindParam($CatID, $SubCatName,0,0 ); 

	// call the stored procedure
	//$stmt->execute();
	
	$stmt = $dbh->prepare("CALL AddSubCategory(?, ?,?,?)"); 
	$stmt ->execute(array($CatID, $SubCategoryName,0,0)); 
	
	//$result='1';	
	echo json_encode(array('CatID' => $CatID,'SubCategoryName' => $SubCategoryName));

}
catch(PDOException $e) {
    //echo $e->getMessage();
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}

?>