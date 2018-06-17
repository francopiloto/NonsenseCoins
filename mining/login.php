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
				$error = "Invalid username or password";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Login</title>
	<link type='text/css' rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css">
</head>
<body>
	<div class="container box" style="margin-top:30px;">
		<h1 class="title is-3">Login</h1>
		<p><?php echo $error; ?></p>
		<form method="POST">
			<div class="field">
				<label class="label">Username</label>
				<div class="control">
					<input class="input is-success" type="text" name="username"/>
				</div>
			</div>
			
			<div class="field">
				<label class="label">Password</label>
				<div class="control">
					<input class="input is-success" type="password" name="password"/>
				</div>
			</div>
			
			<div><button name="login" class="button is-success">Login</button></div>
		</form>
		
		<div style="margin-top:30px;">
			<a href="signup.php">Sign Up</a>
		</div>
	</div>
</body>
</html>