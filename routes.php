<?php

$routes = [
	'' => 'index',
	'index' => 'archive',
	'archive' => function(){
		return template('posts-archive', [ 'posts' => Blog::Read() ]);
	},
	
	'nothing' => function(){
		die('nothing.');
	}
];

?>