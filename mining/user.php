
<?php
	session_start();	
	
	require "miner.php";	
	
	if (array_key_exists("username", $_SESSION) && $_SESSION["username"] != "")
	{
		$username = $_SESSION["username"];
	}
	else {
		header("location:login.php");
	}
	
	$coins = getUserBalance($username);
	$balance = count($coins);
	
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
				$data = $block->data;
				$hash = $block->hash;
				
				$block = new Block($data, null);
				$block->setHash($hash);			
			}
			
			$miner = new Miner($block);
			$miner->run();
			
			$block = $miner->getBlock();			
			
			if (Admin::evaluate($block, $username)) 
			{			
				$coins = getUserBalance($username);
				$balance = count($coins);
			}
		}
	}
	
	function showCoins()
	{
		global $coins;
		
		foreach ($coins as $coin)
		{
			echo "<tr>";
			echo "<td>" . $coin->data . "</td>";
			echo "<td>" . $coin->hash . "</td>";
			echo "</tr>";
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
	<p>Current User: <?php echo $username; ?></p>
	
	<p>Balance: <?php echo $balance; ?></p>
	
	<form method="POST">
		<div>			
			<div><button name="action" value="logout">Logout</button></div>
			<div><button name="action" value="mining">Start Mining</button></div>
		</div>		
	</form>
	
	<h3>Your Money!</h3>
	
	<table>
		<thead>
			<tr>
				<th>Data</th>
				<th>Hash</th>
			</tr>
		</thead>
		<tbody>
			<?php echo showCoins(); ?>
		</tbody>
	</table>
</body>
</html>