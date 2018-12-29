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

// If there's not an explicit requested route, just make $route blank
if(empty($route = $_GET['route'])){
	$route = 'index';
}

// $uri is used for getting parameters not included in the route string
$uri = explode('/', $route);

// Now, we find a route
// This gets a little complicated
// Start with a simple do {}
// This could be a while, but we want it to run at least once so it'll catch URLs with parameters
do {
	// If $route has a route, then just set it to the value of that route
	if(!empty($routes[$route])){
		$route = $routes[$route];
	// Otherwise, split it by / and knock bits off the end one by one until we either run out or find a route
	}else{
		while(empty($routes[$route]) && !empty($route)){
			$route = explode('/', $route);
			
			array_pop($route);
			
			$route = implode('/', $route);
		}
	}
}
// Keep repeating the code under do {} until either the route is no longer a string, or there's nowhere else to go
while(is_string($route) && !empty($routes[$route]));

// If the route isn't callable, just make $route a callable that gives a 404
if(!is_callable($route)){
	$route = $routes['404'];
}





// Show the template

// Call $route; its return value is the page's content
$yield = $route();

// Pull in the template, which will display the output from the route
require 'template.php';

?>