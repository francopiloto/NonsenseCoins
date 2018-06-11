<?php
	require "rb-mysql.php";
	
	function connect()
	{
		if (!R::testConnection()) {
			R::setup("mysql:host=localhost;dbname=mad3134_mining","root", "");
		}
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
		$block = R::findOne("blocks", "ORDER BY id DESC LIMIT 1");
		R::close();
		
		return $block;
	}
	
	function loadChain()
	{
		connect();
		$blocks = R::findAll("blocks", "ORDER BY id");
		R::close();
		
		return $blocks;
	}
	
	function addBlock($data, $hash, $username)
	{
		connect();
		$block = R::dispense('blocks');
		
		$block->data = $data;
		$block->hash = $hash;
		$block->username = $username;
		
		R::store($block);
		
		R::close();
	}
	
	function getUserBalance($username)
	{
		connect();
		$blocks = R::findAll("blocks", "username = ?", [$username]);
		R::close();
		
		return $blocks;
	}
?>