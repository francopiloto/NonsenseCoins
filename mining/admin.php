<?php
	require "database.php";
	require "../block.php";
	
	class Admin
	{	
		private const PATTERN = "00000";

		static function evaluate($block, $userId)
		{
			if (!Admin::isPatternValid($block)){
				return false;
			}
			
			$dbChain = loadChain();
			$objChain = null;
			
			if ($dbChain)
			{
				foreach ($dbChain as $dbBlock){
					$objChain = new Block($dbBlock->data, $objChain);
				}
			}
			
			$objChain = new Block($block->getData(), $objChain);
			
			if (Admin::isPatternValid($block))
			{
				addBlock($block->getData(), $block->getHash(), $userId);
				return true;
			}

			return false;
		}
		
		static function isPatternValid($block) {
			return substr($block->getHash(), 0, strlen(Admin::PATTERN)) === Admin::PATTERN;
		}
	}
?>