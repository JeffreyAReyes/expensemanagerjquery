<?php

$conn = @mysql_connect('localhost','root','jikiri');
if (!$conn) {
	die('Could not connect: ' . mysql_error());
}
mysql_select_db('expensemanager', $conn);

?>