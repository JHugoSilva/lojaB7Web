<?php
require 'environment.php';

$config = array();
if(ENVIRONMENT == 'development') {
	define("BASE_URL", "http://localhost/loja2.0_b7web/");
	$config['dbname'] = 'loja2';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'hugox';
	$config['dbpass'] = '123';
} else {
	define("BASE_URL", "http://localhost/nova_loja_painel/");
	$config['dbname'] = 'loja2';
	$config['host'] = 'localhost';
	$config['dbuser'] = 'root';
	$config['dbpass'] = 'root';
}

$config['default_lang'] = 'en';

global $db;
try {
	$db = new PDO("mysql:dbname=".$config['dbname'].";host=".$config['host'], $config['dbuser'], $config['dbpass']);
} catch(PDOException $e) {
	echo "ERRO: ".$e->getMessage();
	exit;
}