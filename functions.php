<?php

/**
 * Gets debug text for however many parameters you give it
 *
 * @return string print_r for each param wrapped in <pre>
 */
function debug(){
	ob_start();
	
	echo '<pre>';
	
	foreach(func_get_args() as $arg){
		echo print_r($arg, true) . "\n";
	}
	
	echo '</pre>';
	
	return ob_get_clean();
}

/**
 * Get an excerpt of a passage of text
 *
 * @param string $text The passage of text
 * @param integer $wordLimit The word limit. Default 50
 * @return string The passage of text trimmed down to the given word limit
 */
function excerpt($text, $wordLimit = 50){
	$text = htmlentities($text);
	
	$text = explode(' ', $text);
	
	$return = [];
	
	for($i=0; $i<$wordLimit; $i++){
		if(empty($text[$i])){
			break;
		}
		
		$return[] = $text[$i];
		
		if($i >= $wordLimit - 1){
			$return[] = ' [...]';
		}
	}
	
	return implode(' ', $return);
}

/**
 * Kills the page and gives a 500 error page; logs the error if one is given
 *
 * @param mixed $e An exception, string, etc to be logged to the error file
 * @return void
 */
function FatalError($e = false){
	if(!empty($e)){
		$errorFile = 'apiblog_error_log';
		
		$errorsSoFar = '';
		
		if(file_exists($errorFile)){
			$errorsSoFar = file_get_contents($errorFile);
		}
		
		file_put_contents($errorFile, $errorsSoFar . '[ ' . date('Y-m-d g:i:sa') . ' ] ' . $e . "\n\n");
	}
	
	http_response_code(500);
	
	die('<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width-device-width, initial-scale=1">
<title>Error</title>
<style type="text/css">
html,
body
{
	height: 100%;
	margin: 0;
}

body {
	align-items: center;
	background-color: #F5F5F5;
	color: #000;
	display: flex;
	font-family: sans-serif;
}

h1 {
	margin: 0 0 1em 0;
	text-align: center;
}

main {
	background-color: #FFF;
	box-shadow: 0 2px 4px rgba(0, 0, 0, 0.25);
	margin: auto;
	max-width: 50%;
	padding: 2em;
	width: 800px;
}
</style>
</head>
<body>
<main>
	<h1>Fatal Error</h1>
	<p>This web page has experienced a fatal error. If the problem persists, please contact the website administrators to let them know.</p>
</main>
</body>
</html>');
}

/**
 * Turn formatted text into HTML paragraphs. Removes redundant spacing
 *
 * @param string $content The passage of text
 * @return string The text turned into HTML paragraphs
 */
function nl2p($content){
	// First, let's drop any return characters that might cause confusion
	$content = str_replace("\r", '', $content);
	
	// Second, remove redundant spaces from the content
	// We're gonna limit the content to one space between words
	// Note: if you replace two spaces with nothing, then an even number of spaces will turn into nothing!
	do {
		$oldContent = $content;
		$content = str_replace("\n\n", "\n", $content);
	}
	while($content != $oldContent);
	
	// Third, break it into paragraphs by spaces
	$content = explode("\n", $content);
	
	// Fourth, form it into <p> paragraphs
	$content = '<p>' . implode('</p><p>', $content) . '</p>';
	
	// Finally, return the formatted content
	return $content;
}

/**
 * Gets a template parts, makes given variables local to the file
 *
 * @param string $file The path of the template part past ./templates/ and before .php
 * @param array $vars Associative array of variables to make local to the template file
 * @return string The output of the template file
 */
function template($file, $vars = []){
	// Make sure the requested template exists
	// If it doesn't, just return false
	if(!file_exists($file = './templates/' . $file . '.php')){
		return false;
	}
	
	// We extract $vars so that any values inside of it are now local vars to the template we're importing
	extract($vars);
	
	// Start recording any output
	ob_start();
	// Include the requested template
	// Using include rather than require just means it won't crash if the file doesn't exist
	// We already did error handling so there shouldn't be a difference in this context, but just in case
	include $file;
	// Now, return all of the recorded output
	return ob_get_clean();
}

/**
 * Turns a string into a URL-safe slug
 *
 * @param string $string The string to be make URL-safe
 * @return string The URL-safe slug
 */
function toSlug($string){
	// Make everything lowercase
	$string = strtolower($string);
	
	// Turn anything not alpha-numberic into a space
	$string = preg_replace('/[^a-z0-9]/', ' ', $string);
	
	// Drop redundant spaces
	do {
		$oldString = $string;
		$string = str_replace('  ', ' ', $string);
	}
	while($string != $oldString);
	
	// Replace spaces with dashes
	$string = str_replace(' ', '-', $string);
	
	// Return the slug
	return $string;
}

/**
 * Gets the base URL to the CMS. Use this for links, asset including, etc. Relative linking isn't safe due to the Clean URLs
 *
 * @return string The URL
 */
function url(){
	return
		'http' . (
			!empty($_SERVER['HTTPS']) ?
				's'
			:
				''
		)
		. 
		'://' . $_SERVER['SERVER_NAME'] . @array_shift(
			explode(
				'/index.php',
				$_SERVER['SCRIPT_NAME']
			)
		)
	;
}

?>