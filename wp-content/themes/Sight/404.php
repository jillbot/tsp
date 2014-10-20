<?php get_header();?>
<div class="container">
	<div class="row">
		<div class="twelve columns">
			<div id="leftContent">
				<div class="inner">
				<div class="white_box">
					<div class="white_box_inner">
						<h1><?php _e('Page Not Found', 'presslayer'); ?></h1>
						<p><?php _e('Sorry, the page you are looking for could not be found. Try using the search box below!', 'presslayer'); ?></p>
						<?php get_search_form(); ?>
					</div>
				</div>	
				</div>
			</div>
			<?php get_sidebar();?>	
		</div>	
	</div>
</div>
<?php get_footer();?>