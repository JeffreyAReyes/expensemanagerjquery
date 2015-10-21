<?PHP
session_start();

if (!(isset($_SESSION['login']) && $_SESSION['login'] != '')) {
	header ("Location: index.php");
}

?>