<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>API Blog</title>
<link rel="stylesheet" type="text/css" href="<?=url()?>/assets/css/bulma.min.css">
</head>

<body>

<header>
	<div class="container">
		<h1 class="title is-1">
			APIBlog
		</h1>
	</div>
</header>

<main>
	<?=$yield?>
</main>

<footer>
	<div class="container">
		&copy; Joseph Odom <?=date('Y')?>
	</div>
</footer>

</body>

</html>