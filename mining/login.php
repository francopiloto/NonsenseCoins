<?php
	session_start();
	require "database.php";
		
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
			if (authenticate($username, $password))
			{				
				$_SESSION["username"] = $username;
				header("location:user.php");
			}
			else {
				$error = "Invalid user or password";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
</head>
<body>
	<h1>Login</h1>
	<p><?php echo $error; ?></p>
	<form method="POST">
		<div>
			<div>Username: <input type="text" name="username"/></div>
			<div>Password: <input type="password" name="password"/></div>
			<div><button name="login">Login</button></div>
		</div>		
	</form>
	
	<a href="signup.php">Sign Up</a>
</body>
</html>