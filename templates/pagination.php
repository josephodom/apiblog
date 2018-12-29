<section class="pagination-container">
	<div class="pagination-binary-button">
		<?php if($page > 1): ?>
			<a href="<?=url()?>/archive/page/<?=$page - 1?>" class="button">
				&laquo;
				Previous
			</a>
		<?php else: ?>
			<button class="button" disabled>
				&laquo;
				Previous
			</button>
		<?php endif; ?>
	</div>
	
	<div class="pagination-page-numbers">
		<ul class="list-pagination-page-numbers"><?php for($i=1; $i < $pageCount + 1; $i++): ?>
			<li>
				<?php if($i != $page): ?>
					<a href="<?=url()?>/archive/page/<?=$i?>" class="button">
						<?=$i?>
					</a>
				<?php else: ?>
					<button class="button" disabled>
						<?=$i?>
					</button>
				<?php endif; ?>
			</li>
		<?php endfor; ?></ul>
	</div>
	
	<div class="pagination-binary-button">
		<?php if($page < $pageCount): ?>
			<a href="<?=url()?>/archive/page/<?=$page + 1?>" class="button">
				Next
				&raquo;
			</a>
		<?php else: ?>
			<button class="button" disabled>
				Next
				&raquo;
			</button>
		<?php endif; ?>
	</div>
</section>