<?php

// Get files with vital classes, settings, etc

foreach([
	'class.blog',
	'class.db',
] as $file){
	require_once $file . '.php';
}





// Database connection

DB::Init('localhost', 'apiblog', 'root', '');





// Find out what page we want to show

//





// Show the template

require 'template.php';

?>