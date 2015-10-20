<?php
	
	//$sql = ($_REQUEST['SPName']);

	$page = isset($_POST['page']) ? intval($_POST['page']) : 1;
	$rows = isset($_POST['rows']) ? intval($_POST['rows']) : 10;
	$offset = ($page-1)*$rows;
	$result = array();

	include 'conn.php';
	
	require_once 'dbconfig.php';
	
        try {
            $conn = new PDO("mysql:host=$dbhost;dbname=$dbname",
                            $dbuser, $dbpass);
            // execute the stored procedure
            $sql = 'CALL GetCategories()';
            $q = $conn->query($sql);
            $q->setFetchMode(PDO::FETCH_ASSOC);
			
			$items = array();
			$row = mysql_fetch_row($q);
			
			while($row = mysql_fetch_object($q)){
				array_push($items, $row);
			}
			
			$result["rows"] = $items;
			
		} catch (PDOException $pe) {
				die("Error occurred:" . $pe->getMessage());
			
	/* $sql = "GetCategories";
	 
	$rs = mysql_query($sql);
	$row = mysql_fetch_row($rs);
	$result["total"] = $row[0];
	$rs = mysql_query("select * from category limit $offset,$rows");
	
	$items = array();
	while($row = mysql_fetch_object($rs)){
		array_push($items, $row);
	}
	$result["rows"] = $items; */

	echo json_encode($result);

	
?>