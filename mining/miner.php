<?php

	include "../block.php";
	
	class Miner
	{
		private $running = false;
		private $block;
		
		public function __construct($currentBlock) {
			$this->block = new Block("0", $currentBlock);
		}
				
		public function run()
		{
			$this->running = true;
			
			while ($this->running && !$this->isValid()) {
				$this->block->update($this->block->getData() + 1);
			}
		}
		
		public function stop() {
			$this->running = false;
		}
		
		public function isValid() {			
			return substr($this->block->getHash(), 0, strlen(Block::PATTERN)) === Block::PATTERN;
		}
		
		public function getBlock() {
			return $this->block;
		}			
	}
?>