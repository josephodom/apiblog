<article class="box">
	<h2 class="title is-4">
		<a href="<?=url()?>/post/<?=$pid?>-<?=toSlug($title)?>/">
			<?=$title?>
		</a>
		
		<small>
			Posted <?=date('Y-m-d h:i:sa', $date_created)?>
			
			<?php if(!empty($date_last_edited)): ?>
				(Edited <?=date('Y-m-d h:i:sa', $date_last_edited)?>)
			<?php endif; ?>
		</small>
	</h2>
	
	<div class="content">
		<?=excerpt($message)?>
	</div>
</article>