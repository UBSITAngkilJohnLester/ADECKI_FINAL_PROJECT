<?php
	$host = "localhost";
	$user = "root";
	$pass = "";
	$db = "adecki";
	$charset = "utf8mb4";
	$port = 3308; //comment this line and remove from $dsn if personal computer

	$dsn = "mysql:host=$host;dbname=$db;charset=$charset;port=$port";
	$attributes = [
		PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
		PDO::ATTR_DEFAULT_FETCH_MODE => PDO:: FETCH_ASSOC,
		PDO::ATTR_EMULATE_PREPARES => false
	];

	try {
		$pdo = new PDO($dsn, $user, $pass, $attributes);		
	} catch (PDOException $e) {
		die("Connection Failed..." . $e.getmessage());
	}

?>