<?php

// Get files with vital classes, settings, etc

foreach([
	'class.blog',
	'class.db',
	'functions',
] as $file){
	require_once $file . '.php';
}





// Database connection

DB::Init('localhost', 'apiblog', 'root', '');

die('<pre>' . print_r(Blog::Read([ 'limit' => 1, 'page' => 1 ]), true) . '</pre>');





// Find out what page we want to show

//





// Show the template

require 'template.php';

?>