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
				
				<div class="post_meta">
					<span class="user"><?php _e('by','presslayer');?> <?php the_author_posts_link(); ?></span> 
					<span class="time"><?php the_time(get_option('date_format')) ?></span>
					<span class="comment"><?php comments_popup_link(__('No Comments','presslayer'), __('1 Comment','presslayer'), __('% Comments','presslayer'),'post_comment'); ?></span>
					<span class="cats"><?php the_category(', ') ?></span>
				</div>
				<div class="post_entry">
					<?php the_content(); ?>
					<?php wp_link_pages(array('before' => 'Pages: ', 'next_or_number' => 'number')); ?>
					
					<?php edit_post_link('Edit this entry','<p>','</p>'); ?>
				</div>
				
				<div class="post_single_bottom_wrapper">	
					<div class="post_tag"><?php the_tags( 'Tags: ', ' ', ''); ?></div>
					<span class="like_post"><?php printLikes(get_the_ID()); ?></span>
				</div>
				
				<div class="clear"></div>
				</div>	
				
			<div class="post_author">
					<div class="author_avatar">
					<div class="small_thumb"><?php echo get_avatar(get_the_author_meta('email'), '100'); ?></div>
					</div>
					<div class="author_wrapper">
					<h4><?php _e('About author', 'presslayer'); ?>: <?php the_author_posts_link(); ?></h4>
					<p><?php the_author_meta("description"); ?></p></div>
					<div class="clear"></div>
				</div>	
			<?php endwhile; endif; ?>
			</div><!-- post item -->
			
			<?php
			if(get_post_meta($post->ID, 'pl_related', true)=='default' or get_post_meta($post->ID, 'pl_related', true)==''){
				$related = $pl_data['enable_related_posts'];
			}else{
				$related = get_post_meta($post->ID, 'pl_related', true);
			}
			if($related!='no') get_template_part( 'inc/related_posts');
			?>
					
			<?php comments_template(); ?>
			
			</div></div>
			
			<?php get_sidebar('custom');?>
		</div>	
	</div>
</div><!-- .container -->	
<?php get_footer();?>