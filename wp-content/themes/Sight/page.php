<?php get_header();?>
<div class="container">
	<div class="row">
		<div class="twelve columns">
		<div id="leftContent"><div class="inner">
			<div class="post_item post_single white_box">
				<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				<?php
				$title_top_class = ' post_top_element';
				$video_embed = get_post_meta($post->ID, 'pl_video_embed', true) ;
				if($video_embed!=''){
				$title_top_class = '';
				?>
				<div class="fit post_video_wrapper"><?php echo $video_embed;?></div>
				<?php
				} else {?>
					<?php if ( get_the_post_thumbnail() != '' ) { ?>
					<?php 
						$title_top_class = ' post_top_element';
						$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'fulls-size');
						$new_image = aq_resize( $image[0], 800, NULL, FALSE, FALSE );
						$title_top_class = '';
					?>
					<div class="large_thumb thumb_hover">
						<a href="<?php echo $image[0];?>" class="thumb_icon view fancybox"><span></span></a>
						<div class="mask post_top_element"></div>
						<div class="img_wrapper">
						<img src="<?php echo $new_image[0];?>" width="<?php echo $new_image[1];?>" height="<?php echo $new_image[2];?>" alt="<?php the_title_attribute();?>" class="post_top_element thumb" /></div>
					</div>
					<?php }?>
				
				<?php }?>
				<?php social_share();?>
				
				<div class="post_single_inner">
				
				
				<h1><?php the_title(); ?></h1>
				
				<div class="post_entry">
					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
					
					<?php edit_post_link('Edit this entry','<p>','</p>'); ?>
				</div>
				
				
				
				<div class="clear"></div>
				</div>	
				
				
			<?php endwhile; endif; ?>
			</div><!-- post item -->
			
			<?php comments_template(); ?>
			
			</div></div>
			
			<?php get_sidebar('custom');?>
		</div>	
	</div>
</div><!-- .container -->	
<?php get_footer();?>