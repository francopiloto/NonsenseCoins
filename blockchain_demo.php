
<?php
	session_start();
	
	include "block.php";
		
	if ($_SERVER["REQUEST_METHOD"] == "POST")
	{	
		$clear = $_POST["action"] == "reset";
		
		if ($_POST["numBlocks"])
		{		
			$blocks = [];
			$numBlocks = $_POST["numBlocks"];			
			
			$block = new Block("nonsense", null);
			$blocks[0] = $block;
			
			for ($i = 1; $i < $numBlocks; $i++)
			{
				$key = "block" . $i;
				$data = $clear ? null : (array_key_exists($key, $_POST) ? $_POST[$key] : null);
				$block = new Block($data, $block);
				$blocks[$i] = $block;
			}
		}
	}	
	
	function createBlocks()
	{
		global $blocks;
		
		if (!$blocks) {
			return;
		}
		
		for ($i = 0; $i < count($blocks); $i++)
		{
			echo "<div class='block'>";
			echo	"<div class='frame'>";
			echo 		"<div>Data: <input type='text' value='" . $blocks[$i]->getData() . "'";
			echo					($i == 0 ? "disabled='disabled'" : "");
			echo					" name='block" . $i . "'/></div>";
			echo 		"<div>";
			echo 			"Previous Block: <br>";
			echo 			"<span class='previous'>" . $blocks[$i]->getPreviousHash() . "</span>";
			echo 		"</div>";
			echo 		"<div>";
			echo 			"Hash: <br>";
			echo 			"<span class='hash'>" . $blocks[$i]->getHash() . "</span>";
			echo 		"</div>";
			echo 	"</div>";
			echo	"<span>#" . ($i+1) . "</span>";
			echo "</div>";
		}	
	}
	
	function numBlocks() 
	{
		global $blocks;
		return $blocks ? count($blocks) : 0;
	}
	
?>

<!DOCTYPE html>
<html>
<head>
	<title>Blockchain Demo</title>
</head>
<body>
	<h1>Block-Chain Demo</h1>
	<form method="POST">
		<div>
			Number o Blocks: <input type="number" value=<?php echo numBlocks();?> step="1" min="1" max="10" name="numBlocks"/>
			<button name="action" id="reset" value="reset">Reset</button>
			<button name="action" id="update" value="update">Update</button>
		</div>

		<?php createBlocks(); ?>	
	</form>	
</body>
</html>

<script  src="https://code.jquery.com/jquery-3.3.1.min.js"
         integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
		 crossorigin="anonymous">
</script>

<script type='text/javascript'>
	$().ready(function()
	{
			
	});
</script>

<style type="text/css">
	.block 
	{
		display: inline-block;
		margin: 20px 0px 20px 20px;
		text-align: center;
	}
	
	.block .frame
	{
		border: 1px solid gray;
		padding: 20px;
		text-align: left;
		margin-bottom: 5px;
	}
	
	.block .frame div {
		padding: 10px;
	}
	
	.block input {
		width: 379px;
	}
	
	.block .frame span 
	{
		font-family: monospace;
		font-size: 12px;
		text-transform: uppercase;
		min-height: 12px;
		display: inline-block;
	}
</style>
