<?php

// Get files with vital classes, settings, etc

foreach([
	'class.blog',
	'db'
] as $file){
	require_once $file . '.php';
}





// Find out what page we want to show

//





// Show the template

require 'template.php';

?>