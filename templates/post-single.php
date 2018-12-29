<div class="container">
	<article class="box">
		<h2 class="title is-4">
			<?=$title?>
			
			<small>
				Posted <?=date('Y-m-d h:i:sa')?>
				
				<?php if(!empty($date_last_edited)): ?>
					(Edited <?=date('Y-m-d h:i:sa', $date_last_edited)?>)
				<?php endif; ?>
			</small>
		</h2>
		
		<div class="content">
			<?=nl2p(htmlentities($message))?>
		</div>
	</article>
</div>