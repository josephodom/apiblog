<?php

// This function is for ease of access from anywhere
function DB(){
	return $GLOBALS['_DB'];
}

// TODO: Move this to settings.php
$dbHost = 'localhost';
$dbName = 'apiblog';
$dbUser = 'root';
$dbPass = '';

// Try to connect to the database
// If it fails, take the whole site down with a 500 error
try {
	$_DB = new PDO(
		"mysql:host=$dbHost;dbname=$dbName",
		$dbUser,
		$dbPass
	);
}
catch(Exception $e){
	// TODO: A better fatal error system
	die('fatal error');
}

?>