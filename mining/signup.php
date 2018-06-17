
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
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Add User</title>
	<link type='text/css' rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css">
</head>
<body>
	<div class="container box" style="margin-top:30px;">
		<h1 class="title is-3">User Registration</h1>
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
			
			<div><button class="button is-success" name="signup">Sing Up</button></div>
		</form>
		
		<div style="margin-top:30px;">
			<a href="login.php">Login</a>
		</div>
	</div>
</body>
</html>