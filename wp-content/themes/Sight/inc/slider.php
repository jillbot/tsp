<?php
global $theme_url;
$args = array(
	'post_type' => 'slider',
	'paged' => $paged,
	'orderby'=>'menu_order',
	'order'=>'ASC'
);

$slider = new WP_Query($args);
?>
<div class="slider">
	<div id="homeslider" class="fullwidth flexslider">
		<ul class="slides">
		<?php 
			$str = '';
			$i = 0;	
			while($slider->have_posts()): $slider->the_post();
			$i++;
			$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full-size');
			$link = get_post_meta($post->ID, 'pl_link', true) ;
			
			$str .= '<div class="caption" id="cp_'.$i.'"><h3 class="title" ><a href="'.$link.'">'. get_the_title() .'</a></h3>
	<div class="slider_content_inner">'. get_the_content() .'</div></div>';
			
			?>		
			<li data-height="500" style="position:relative; background: url(<?php echo $image[0];?>) 50% 0">
				<div class="caption_wrapper">
					<div class="caption">
					<h3><a href="<?php echo $link;?>" title="<?php the_title_attribute();?>"><?php the_title();?></a></h3>
					<?php echo get_the_content();?> ... <a href="<?php echo $link;?>" title="<?php the_title_attribute();?>"><?php _e('Read more','presslayer');?> &rarr;</a>
					</div>
				</div>
			</li>
		<?php endwhile;	wp_reset_query(); ?>						
				
		</ul>
	</div>
	
	<script type="text/javascript">
	var $j = jQuery.noConflict();
	$j(document).ready(function(){ 
	  
	  $j('#homeslider').flexslider({
		autoPlay: true,
		pauseOnAction: false,
		animation: "fade",
		start: function(slider){
		 $j('.caption_wrapper').animate({"bottom": '50px', 'opacity': 1 }, 500);
		},
		before: function(slider) {
			$j('.caption_wrapper').animate({"bottom": '0px', 'opacity': 0 }, 500);
		},
		after: function(slider) {
			$j('.caption_wrapper').animate({"bottom": '50px', 'opacity': 1 }, 500);
		}
	  });
	  
	set_slider_height();
	$j(window).resize(function(){
		set_slider_height();
	});
	
	function set_slider_height(){
		var default_height = parseInt($j('#homeslider ul.slides').find('li').attr('data-height'));
		var new_height;
		
		if( $j(window).width() < 1030 ){
			new_height = ( default_height * $j(window).width() ) / 1030;
		}else{
			new_height = default_height;
		}
		$j('#homeslider ul.slides').find('li').height(new_height);	
	}
	  
	});
  </script>
	
</div>

