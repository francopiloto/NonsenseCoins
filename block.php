
<?php

class Block
{
	public const PATTERN = "00000";
	
	private $data;
	private $hash;
	private $previousBlock;
	
	public function __construct($data, $previousBlock)
	{
		$this->data = $data;
		$this->previousBlock = $previousBlock;
		$this->hash = $this->calculateHash();
	}
	
	public function getData() {
		return $this->data;
	}
	
	public function getPreviousHash() {
		return $this->previousBlock != null ? $this->previousBlock->hash : null;
	}
	
	public function getHash() {
		return $this->hash;
	}
	
	public function setHash($hash) {
		$this->hash = $hash;
	}
	
	public function update($data)
	{
		$this->data = $data;		
		$this->hash = $this->calculateHash();
	}
		
	// recursively check if the calculated hash matches the stored hash
	public function validate()
	{
		$block = $this;
		
		do 
		{
			if ($block->hash != $block->calculateHash()) {
				return false;
			}
			
			$block = $block->previousBlock;
		}
		while ($block != null);
		
		return true;
	}
	
	// calculate the hash of this block using the data combined with
	// the previous block's hash, if exists
	private function calculateHash()
	{
		if ($this->data != null)
		{
			$message = $this->data;
			
			if ($this->previousBlock != null) {
				$message .= $this->previousBlock->hash;
			}
		}
		else if ($this->previousBlock != null) {
			$message = $this->previousBlock->hash;
		}
		else {
			echo "ERROR";
		}		
		
		// using PHP built-in function to calculate the hash
		return hash("sha256", $message);
	}
}

?>