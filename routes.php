<?php

$routes = [
	'' => 'index',
	'index' => 'archive',
	'archive' => function(){
		global $uri;
		
		$page = 1;
		
		if(count($uri) >= 3 && is_numeric($uri[2]) && $uri[2] > 0){
			$page = $uri[2];
		}
		
		return template('posts-archive', [ 'page' => $page, 'posts' => Blog::Read([ 'page' => $page ]) ]);
	},
	
	'nothing' => function(){
		die('nothing.');
	}
];

?>