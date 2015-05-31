<div class="date">
	<?php if(!mkd_post_has_title()) { ?>
		<a href="<?php the_permalink() ?>">
	<?php }
	
	the_time(get_option('date_format'));
	
	if(!mkd_post_has_title()) { ?>
		</a>
	<?php } ?>
</div>