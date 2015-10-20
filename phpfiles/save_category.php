<?php

$CategoryName = htmlspecialchars($_REQUEST['CategoryName']);

include 'conn.php';

$sql = "insert into category(CategoryName) values('$CategoryName')";
$result = @mysql_query($sql);
if ($result){
	echo json_encode(array(
		'CatID' => mysql_insert_id(),
		'CategoryName' => $CategoryName
	));
} else {
	echo json_encode(array('errorMsg'=>'Some errors occured.'));
}
?>