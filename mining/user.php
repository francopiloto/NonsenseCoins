
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
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>User Home</title>
	<link type='text/css' rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.1/css/bulma.css">
</head>
<body>
	<div class="container box" style="margin-top:30px;">
		<h1 class="title is-3">User Home</h1>
		<p>Current User: <?php echo $username; ?></p>
		
		<p>Balance: <?php echo $balance; ?></p>
		
		<form method="POST">
			<div>			
				<button name="action" value="logout" class="button is-danger">Logout</button>
				<button name="action" value="mining" class="button is-success">Start Mining</button>
			</div>		
		</form>
		
		<h3 class="title is-4" style="margin-top:40px;">Your Money!</h3>
		
		<table class="table is-striped is-hoverable">
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
	</div>
</body>
</html>