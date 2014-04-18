<?php
global $theme_url;

$categories = get_the_category();

if(!empty($categories) and is_array($categories)){
	foreach( $categories as $category) $array_ID[] = $category->cat_ID;
	$cats = implode(",", $array_ID);
}else{
	$cats = 0;
}


$posts = get_posts('numberposts=4&exclude='.$post->ID.'&orderby=rand&category=' . $cats . '');
if($posts) {
?>
<div class="related_posts white_box">
	<h3 class="rp_title"><?php _e('Related Posts','presslayer'); ?></h3>
	<div class="rp_col_wrapper clearfix">
		<?php foreach($posts as $post) {?>
		<div class="rp_col">
		<?php
		if ( has_post_thumbnail()){
		$image = wp_get_attachment_url(get_post_thumbnail_id($post->ID), 'full');
		$thumb = aq_resize( $image, 550, 400, true );
		$title_top_class = '';
		?>
		<div class="small_thumb"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><img src="<?php echo $thumb;?>" width="550" height="400" alt="<?php the_title_attribute();?>" class="post_top_element thumb" /></a></div>
		<?php } else { ?>
		<div class="small_thumb"><a href="<?php the_permalink() ?>" rel="bookmark" title="<?php the_title_attribute(); ?>"><img src="<?php echo $theme_url;?>/images/noimage_big.jpg" width="550" height="400" alt="<?php the_title_attribute();?>" class="post_top_element thumb" /></a></div>
		<?php }?>
			<h4><a href="<?php the_permalink() ?>" title="<?php the_title_attribute(); ?>" class="title"><?php the_title(); ?></a></h4>
		</div>
		<?php } wp_reset_postdata(); ?>
		
	</div>
</div>
<?php } ?>