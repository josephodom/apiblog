<?php

function FatalError($e){
	$errorFile = 'apiblog_error_log';
	
	$errorsSoFar = '';
	
	if(file_exists($errorFile)){
		$errorsSoFar = file_get_contents($errorFile);
	}
	
	file_put_contents($errorFile, $errorsSoFar . '[ ' . date('Y-m-d g:i:sa') . ' ]' . $e . "\n\n");
	
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

?>