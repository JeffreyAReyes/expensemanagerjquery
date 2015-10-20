


<?PHP

// Initialize the session.
// If you are using session_name("something"), don't forget it now!
session_start();

//echo "<h3> PHP List All Session Variables- before session_destroy</h3>";
//    foreach ($_SESSION as $key=>$val)
//    echo $key." ".$val."<br/>";

// Unset all of the session variables.
$_SESSION = array();

// If it's desired to kill the session, also delete the session cookie.
// Note: This will destroy the session, and not just the session data!
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(session_name(), '', time() - 42000,
        $params["path"], $params["domain"],
        $params["secure"], $params["httponly"]
    );
}

// Finally, destroy the session.
session_destroy();

//echo "<h3> PHP List All Session Variables - after session_destroy</h3>";
//    foreach ($_SESSION as $key=>$val)
//    echo $key." ".$val."<br/>";
?>

<!DOCTYPE html>

<html>
	<head>
		<title>Expense Manager</title>
		<meta name="robots" content="noindex, nofollow">
		<!-- Include CSS File Here -->
		<link rel="stylesheet" href="views/style.css"/>
		<!-- Include CSS File Here -->
		<script src="jsfiles/jquery.min.js"></script>
		<script type="text/javascript" src="jsfiles/login.js"></script>
		<link rel="stylesheet" type="text/css" href="themes/default/easyui.css">
		<link rel="stylesheet" type="text/css" href="themes/icon.css">
		<link rel="stylesheet" type="text/css" href="views/demo.css">
		
		<script type="text/javascript" src="jsfiles/jquery.easyui.min.js"></script>
		
		
	</head>

	<body>
	
	<div class="easyui-panel" style="padding:1px;width:100%;height:105%;background:#DAE3F2;">
		<h2>Expense Manager</h2>
		 <p>Manage your finances intelligently.</p>
        
    </div>
	
		<div class="main"  >
				<form class="form" method="post" action="#">
				<h2>Please Login</h2>
				<label>Login Name :</label>
				<input type="text" name="loginname" id="loginname">
				<label>Password :</label>
				<input type="password" name="password" id="password">
				<input type="button" name="login" id="login" value="Login">
				</form>
			</div>

</body>
</html>

