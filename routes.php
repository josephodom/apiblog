<?php

$routes = [
	'404' => function(){
		http_response_code(404);
		
		return '<div class="container"><h1 class="title is-2">Page not Found</h1><p>Could not find the requested page.</p></div>';
	},
	
	'500' => function(){
		FatalError();
	},
	
	'index' => 'archive',
	'archive' => function(){
		global $uri;
		
		$page = 1;
		
		if(count($uri) >= 3 && is_numeric($uri[2]) && $uri[2] > 0){
			$page = $uri[2];
		}
		
		return template('posts-archive', [ 'page' => $page, 'posts' => Blog::Read([ 'page' => $page ]) ]);
	},
	
	'post' => function(){
		global $uri;
		
		$pid = false;
		
		if(count($uri) >= 2){
			$pid = @array_shift(explode('-', $uri[1]));
		}
		
		if(!$pid || !is_numeric($pid) || empty($post = Blog::Read([ 'where'=> [ [ 'key' => 'pid', 'value' => $pid ], ], ]))){
			return $GLOBALS['routes']['404']();
		}
		
		return template('post-single', (array)$post);
	},
	
	'about' => function(){
		return template('page-about');
	},
	
	'populate' => function(){
		require_once './vendor/autoload.php';
		
		$faker = Faker\Factory::create();
		
		Blog::Create([
			'title' => $faker->realText(25),
			'message' => $faker->realText(1000),
			'date_created' => time(),
		]);
		
		die('Success');
	},
];

?>