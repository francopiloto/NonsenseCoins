
<?php
	session_start();
	include "database.php";
	
	if (array_key_exists("username", $_SESSION) && $_SESSION["username"] != "")	{
		header("location:user.php");
	}
	
	$error = "";
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		if ($username == "" || $password == "") {
			$error = "Usename and Password cannot be empty";				
		}
		else 
		{
			$user = findUserByName($username);
			
			if ($user) {
				$error = "Usename already in use. Choose another one";
			}
			else
			{
				addUser($username, $password);
				
				$_SESSION["username"] = $username;				
				header("location:user.php");
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add User</title>
</head>
<body>
	<h1>User Registration</h1>
	<p><?php echo $error; ?></p>
	<form method="POST">
		<div>
			<div>Username: <input type="text" name="username"/></div>
			<div>Password: <input type="password" name="password"/></div>
			<div><button name="signup">Sing Up</button></div>
		</div>		
	</form>
	
	<a href="login.php">Login</a>
</body>
</html>