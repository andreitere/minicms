<?php

	global $bitdb; 

	$user = 'root';
	$pass = '';
	$host = 'localhost';
	$database = 'newdb';

	$bitdb = new mysqli($host, $user, $pass, $database);
	
	if ($bitdb->connect_errno) {
		printf("Connection failed: %s \n", $bitdb->connect_error);
		exit();
	}
	$bitdb->set_charset("utf8");
		

?>