<?PHP

include 'dbconfig.php';

$uname = "";
$pword = "";
$errorMessage = "";
$num_rows = 0;
$priv = "";

//==========================================
//	ESCAPE DANGEROUS SQL CHARACTERS
//==========================================
function quote_smart($value, $handle) {

   if (get_magic_quotes_gpc()) {
       $value = stripslashes($value);
   }

   if (!is_numeric($value)) {
       $value = "'" . mysql_real_escape_string($value, $handle) . "'";
   }
   return $value;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	$loginname = $_POST['login_name1'];
	$password = $_POST['password1'];

	$loginname = htmlspecialchars($loginname);
	$password = htmlspecialchars($password);

	//==========================================
	//	CONNECT TO THE LOCAL DATABASE
	//==========================================
	$user_name = "root";
	$pass_word = "jikiri";
	$database = "expensemanager";
	$server = "127.0.0.1";
	
	try {
		$db_handle = new PDO('mysql:host=localhost;dbname=expensemanager', $user_name, $pass_word);
		$db_handle->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	
		$stmt = $db_handle->prepare("CALL GetSystemUserLogin(?,?)");
	
		$stmt->bindParam (1, $loginname, PDO::PARAM_STR);	
		$stmt->bindParam (2, $password, PDO::PARAM_STR);
	
		$stmt->execute();
		
		# Get array containing all of the result rows
		$result = $stmt->fetchAll();
		
		$num_rows = count($result);
		
	//====================================================
	//	CHECK TO SEE IF THE $result VARIABLE IS TRUE
	//====================================================

		if ($result) {
			if ($num_rows > 0) {
				session_start();
				$_SESSION['login'] = "1";
				$_SESSION['priv'] = "1";
				$_SESSION['fname'] = "1";
				$_SESSION['lname'] = "1";
								
				foreach($result as $row) {
					$priv=$row['priv'];
					$_SESSION['fname']=$row['first_name'];
					$_SESSION['lname']=$row['last_name'];
				}

				$_SESSION['priv'] = $priv;
				echo "Successfully Logged in...";
				
			}
			else {
				
				session_start();
				$_SESSION['login'] = "";
				$_SESSION['priv'] = "";
				$_SESSION['fname'] = "";
				$_SESSION['lname'] = "";
				
				echo "Login name or Password is wrong...";
			}	
		}
		else {
			$errorMessage = "Error logging on";
		}
		
		} catch(PDOException $e) {
			echo 'ERROR: ' . $e->getMessage();
	}

	
}

?>