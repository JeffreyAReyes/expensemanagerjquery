<?php

$CatID = intval($_REQUEST['CatID']);
$CategoryName = htmlspecialchars($_REQUEST['CategoryName']);


include 'conn.php';

$sql = "update category set CategoryName='$CategoryName' where CatID=$CatID";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'CatID' => $CatID,
		'CategoryName' => $CategoryName
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>