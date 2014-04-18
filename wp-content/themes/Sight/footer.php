<?php global $theme_url, $pl_data ;?>
<div id="footer">
<div class="container">
	<div class="row">
		<div class="twelve columns wrapper">
			<div class="ft_left">&copy; <?php echo date('Y'); ?>  <a href="<?php echo home_url(); ?>/"><?php bloginfo('name'); ?></a> | <?php bloginfo('description'); ?></div>
			<div class="ft_right"><?php echo stripslashes($pl_data['footer_text']); ?></div>
			<div class="clear"></div>
		</div>
	</div>
</div><!-- .container -->	
</div>
<!-- #footer -->

	<?php if($pl_data['switcher']=='yes') include ('_switcher/index.php');?>  
	<div id="toTop"><a href="#"><?php _e('TOP','presslayer');?></a></div>	
	<?php echo stripslashes($pl_data['google_analytics']); ?>
	<?php wp_footer();?>	
</body>
</html>