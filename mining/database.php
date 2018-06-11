<?php
	require "rb-mysql.php";
	
	function connect() {
		R::setup("mysql:host=localhost;dbname=mad3134_mining","root", "");
	}
	
	function findUserByName($name) 
	{
		connect();
		$user = R::findOne("users", "name = ?", [$name]);
		R::close();
		
		return $user;
	}
	
	function addUser($username, $password)
	{
		$user = R::dispense('users');
		
		$user->name = $username;
		$user->password = hash("sha1", $password);
		
		R::store($user);
	}

	function authenticate($username, $password)
	{
		$user = findUserByName($username);
		return $user && ($user->password == hash("sha1", $password));
	}
	
	function getLastBlock() 
	{
		connect();
		$block = R::findOne("blocks", "ORDER BY id LIMIT 1");
		R::close();
		
		return $block;
	}
	
	function addBlock($data, $hash)
	{
		$block = R::dispense('blocks');
		
		$block->data = $data;
		$block->hash = $hash;
		
		R::store($block);
	}
?>