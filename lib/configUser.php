<?php
//users DB filepath
$root = realpath(__DIR__.'/..');
$database = $root . '/data/users.sqlite';
$dsn = 'sqlite:' . $database;
//dsn = sqlite:realpath(__DIR__)/data/users.sqlite
$sn = 'sqlite:/home/dglarocc/public_html/forum/data/users.sqlite';

//SWAP DSN AND SN FOR LOCAL AND LIVE

try{
	$pdo = new PDO($dsn);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				
	} catch(PDOException $e){
		print "Error in open ".$e->getMessage();
}
?>