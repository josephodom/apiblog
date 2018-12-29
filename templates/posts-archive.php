<div class="container">
	<?php if(count($posts)): ?>
		<ul class="list-posts"><?php foreach($posts as $post): ?>
			<li>
				<?=template('post-small', (array)$post)?>
			</li>
		<?php endforeach; ?></ul>
		
		<?=template('pagination', [ 'page' => $page, 'pageCount' => 2])?>
	<?php else: ?>
		<p class="title is-3">
			No posts found
		</p>
	<?php endif; ?>
</div>