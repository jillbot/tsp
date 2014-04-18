<?php 
global $pl_data, $theme_url;
if (have_posts()) :?>
<div class="row">

	<?php $post = $posts[0]; // Hack. Set $post so that the_date() works. ?>
	<?php /* If this is a category archive */ if (is_category()) { ?>
	<div class="twelve columns"><h3 class="heading_title white_box"><?php single_cat_title(); ?></h3></div>
	<?php /* If this is a tag archive */ } elseif( is_tag() ) { ?>
	<div class="twelve columns"><h3 class="heading_title white_box"><?php _e('Posts Tagged','presslayer');?>: <?php single_tag_title(); ?></h3></div>
	<?php /* If this is a daily archive */ } elseif (is_day()) { ?><a href="js">js</a>
	<div class="twelve columns"><h3 class="heading_title white_box"><?php _e('Archive for','presslayer');?> <?php the_time('F jS, Y'); ?></h3></div>
	<?php /* If this is a monthly archive */ } elseif (is_month()) { ?>
	<div class="twelve columns"><h3 class="heading_title white_box"><?php _e('Archive for','presslayer');?> <?php the_time('F, Y'); ?></h3></div>
	<?php /* If this is a yearly archive */ } elseif (is_year()) { ?>
	<div class="twelve columns"><h3 class="heading_title white_box"><?php _e('Archive for','presslayer');?> <?php the_time('Y'); ?></h3></div>
	<?php /* If this is a paged archive */ } elseif (isset($_GET['paged']) && !empty($_GET['paged'])) { ?>
	<div class="twelve columns"><h3 class="heading_title white_box"><?php _e('Blog Archives','presslayer');?></h3></div>
	<?php } elseif (is_search()){ ?>
	<div class="twelve columns"><h3 class="heading_title white_box"><?php _e('Search Results','presslayer');?></h3></div>
	<?php } ?>
</div>
<div id="post_grids" class="row">
	
	<?php 
	$post_video_content = '';
	while (have_posts()) : the_post();
	$audio = get_post_meta($post->ID, 'pl_audio', true) ;
	$audio_embed = get_post_meta($post->ID, 'pl_audio_embed', true) ;
	$video_embed = trim( get_post_meta($post->ID, 'pl_video_embed', true) );
	$lightbox = get_post_meta($post->ID, 'pl_lightbox', true);
	?>
	<div class="four columns post_col masonry-brick">
	<?php if(get_post_format()!='quote'){?>
		<div id="post-<?php the_ID(); ?>" <?php post_class('post_item white_box'); ?>>
		
			<?php if ( get_the_post_thumbnail() != '' ) {
				$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'fulls-size');
				$new_image = aq_resize( $image[0], 710, NULL, FALSE, FALSE );
			?>
				<div class="large_thumb thumb_hover">
					<?php if($video_embed !='' ){
					$post_video_content .= '<div id="post-video-'.$post->ID.'">'.$video_embed.'</div>';
					?>
					
					<div style="display:none">
						<?php echo $post_video_content;?>
					</div>
						<a href="#post-video-<?php echo $post->ID;?> " class="thumb_icon video fancybox"><span></span></a>
					<?php } else if($lightbox !='no' ){?>
						<a href="<?php echo $image[0];?>" class="thumb_icon view fancybox"><span></span></a>
					<?php } else {?>
						<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="thumb_icon post"><span></span></a>
					<?php }?>
					
					<div class="mask post_top_element"></div> 
					<div class="img_wrapper">
					<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><img src="<?php echo $new_image[0];?>" width="<?php echo $new_image[1];?>" height="<?php echo $new_image[2];?>" alt="<?php the_title_attribute();?>" class="post_top_element thumb" /></a></div>
						
				</div>

			<?php } else {?> 
				<?php if($video_embed!='') echo '<div class="fit post_video_wrapper post_top_element">'.$video_embed.'</div>'; ?>
			<?php } ?>
			
			<?php get_template_part( 'content', 'audio'); ?>
			
			<?php 
			if(get_the_post_thumbnail()=='' && $audio=='' && $audio_embed=='' && $video_embed=='' ) $title_top_class = 'post_top_element';
			else $title_top_class = '';
			?>  
			
			<h3 class="post_item_title"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="<?php echo $title_top_class;?>"><?php the_title(); ?></a></h3>
	
			<div class="post_meta">
				<span class="user"><?php _e('by','presslayer');?> <?php the_author_posts_link(); ?></span> 
				<span class="time"><?php the_time(get_option('date_format')) ?></span>
			</div>
			<div class="post_item_inner">
					
				<p><?php 
				$ex_length = $pl_data['ex_length'];
				if($ex_length=='') $ex_length = 35;
				echo text_trim(get_the_excerpt(), $ex_length, '...');?></p>
				<a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="button normal"><?php _e('Read More','presslayer');?></a>
				
				<span class="like_post"><?php printLikes(get_the_ID()); ?></span>
			
			</div>
		</div>
	<?php } else {
		get_template_part( 'content', get_post_format());
	}?>		
	</div><!-- // post col -->
<?php endwhile; ?>		
			
	
<div class="clear"></div>	
		
</div>



<script>
	var $j = jQuery.noConflict();
	$j(document).ready(function(){ 
		var $container = $j('#post_grids');
		
		$container.imagesLoaded(function(){
		  $container.masonry({
			itemSelector : '.post_col'
		  });
		});

		$j('#post_grids').masonry({
		  itemSelector: '.post_col',
		  gutterWidth:0,
		  // set columnWidth a fraction of the container width
		  columnWidth: function( containerWidth ) {
			return containerWidth / 3;
		  }
		});
		
		$container.infinitescroll({
		  navSelector  : '#page-nav',    // selector for the paged navigation 
		  nextSelector : '#page-nav a',  // selector for the NEXT link (to page 2)
		  itemSelector : '.post_col',     // selector for all items you'll retrieve
		  loading: {
			msgText  : '<?php _e('Loading new posts','presslayer');?> ...',      
			  finishedMsg: '<?php _e('No more pages to load','presslayer');?>.',
			  img: '<?php echo get_template_directory_uri();?>/images/loader.gif'
			}
		  },

		  function( newElements ) {
			// hide new items while they are loading
			var $newElems = $j( newElements ).css({ opacity: 0 });
			// ensure that images load before adding to masonry layout
			$newElems.imagesLoaded(function(){
			  // show elems now they're ready
			  $newElems.animate({ opacity: 1 });

			$container.masonry( 'appended', $newElems, true ); 
			theme_init();
	
			});
		  }
		);

	  });
</script>
		
				
<!-- infinite scroll -->
<div class="load_more">	
	<nav id="page-nav">
		<?php next_posts_link(__('Load more posts','presslayer').' ...') ?>	</nav>
</div>
<!-- end infinite scroll -->

<?php else : ?>
	<div class="row">
<div class="twelve columns"><?php get_search_form(); ?></div></div>
<?php endif; ?>  
