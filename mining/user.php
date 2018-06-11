
<?php
	session_start();
	
	include "database.php";
	include "miner.php";
	
	if (array_key_exists("username", $_SESSION) && $_SESSION["username"] != "")
	{
		$user = $_SESSION["username"];
	}
	else {
		header("location:login.php");
	}
	
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{
		if ($_POST["action"] == "logout") 
		{
			unset($_SESSION["username"]);
			header("location:login.php");
		}
		if ($_POST["action"] == "mining") 
		{
			$block = getLastBlock();
			
			if ($block)
			{
				$data = $block->getData();
				$hash = $block->getHash();
				
				$block = new Block($data, null);
				$block->setHash($hash);
			}
			
			$miner = new Miner($block);
			$miner->run();
			
			if ($miner->isValid())
			{
				$block = $miner->getBlock();
				
				echo "DATA: " . $block->getData() . "<br>";
				echo "HASH: " . $block->getHash() . "<br>";
			}
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>User Home</title>
</head>
<body>
	<h1>User Home</h1>
	<p>Current User: <?php echo $user; ?></p>
	
	<form method="POST">
		<div>			
			<div><button name="action" value="logout">Logout</button></div>
			<div><button name="action" value="mining">Start Mining</button></div>
		</div>		
	</form>	
</body>
</html>