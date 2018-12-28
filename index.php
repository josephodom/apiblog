<?php

// Get files with vital classes, settings, etc

foreach([
	'class.blog',
	'class.db',
	'functions',
	'routes',
] as $file){
	if(!@include_once($file . '.php')){
		FatalError('File not found: ' . $file . '.php');
	}
}





// Database connection

DB::Init('localhost', 'apiblog', 'root', '');





// Find out what page we want to show

if(empty($route = $_GET['route'])){
	$route = '';
}

do {
	@$route = $routes[$route];
}
while(is_string($route) && !empty($routes[$route]));

if(!is_callable($route)){
	$route = function(){
		http_response_code(404);
		
		return '<div class="container"><h1>Page not Found</h1><p>Could not find the requested page.</p></div>';
	};
}





// Show the template

$yield = $route();

require 'template.php';

?>