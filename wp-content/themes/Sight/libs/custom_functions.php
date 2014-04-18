<?php

function text_trim($text, $words = 50, $more = '...'){ 
	$matches = preg_split("/\s+/", $text, $words + 1);
	$sz = count($matches);
	if ($sz > $words) 
	{
		unset($matches[$sz-1]);
		return implode(' ',$matches)." ".$more;
	}
	return $text;
}

function comment_list( $comment, $args, $depth ) {
	$GLOBALS['comment'] = $comment;
	switch ( $comment->comment_type ) :
		case 'pingback' :
		case 'trackback' :
	?>
	<li class="post pingback">
		<p><?php _e( 'Pingback:', 'presslayer' ); ?> <?php comment_author_link(); ?> | <?php edit_comment_link( __( 'Edit', 'presslayer' ), '<span class="edit-link">', '</span>' ); ?></li>
	<?php
			break;
		default :
	?>
	<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
		<div class="comment_context">
			<?php echo get_avatar( $comment, 50 );?>
			<div class="comment_content">
				<div class="content_inner white_box">
					<h4><?php echo get_comment_author_link() ?> <span class="comment_time"><?php echo get_comment_date(get_option('date_format'));?> <?php _e('at','presslayer');?> <?php echo get_comment_time(get_option('time_format'));?></span></h4>
				
				<?php if ( $comment->comment_approved == '0' ) : ?>
					<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'presslayer' ); ?></em>
				<?php endif; ?>
				<?php comment_text(); ?>
				
				<div class="comment-reply">
				<?php edit_comment_link( __( 'Edit', 'presslayer' ), '<span class="edit-link">', '</span>' ); ?>
				<?php comment_reply_link( array_merge( $args, array( 'reply_text' => __( 'Reply', 'presslayer' ), 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></div>
				</div>
				
			</div>
			<div class="clear"></div>
		</div>
	<?php
		break;
	endswitch;
}

// Recent post (for widgets)
function recent_post($cat, $post_count, $title_length, $show_excerpt, $excerpt_length, $show_time, $exclude = null){
	$recent_posts = new WP_Query(array('showposts' => $post_count,'post_type' => 'post','cat' => $cat, 'post__not_in' => $exclude));
	global $post, $theme_url;
	$out = '<ul>';
	while($recent_posts->have_posts()): $recent_posts->the_post(); 
	$out .= '<li>';
	if ( has_post_thumbnail()){
		$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full-size');
		$thumb[0] = aq_resize($image[0],50, 50, true);
		$out .= '<a href="'.get_permalink().'" title="'.the_title_attribute('echo=0').'" class="small_thumb">';
		$out .= '<img src="'.$thumb[0].'" width="50" height="50" alt="'.the_title_attribute('echo=0').'"></a>';
	}else{
		$out .= '<a href="'.get_permalink().'" title="'.the_title_attribute('echo=0').'" class="small_thumb">';
		$out .= '<img src="'.$theme_url.'/images/noimage_small.png" width="50" height="50" alt="'.the_title_attribute('echo=0').'"></a>';
	}
	$out .= '<a href="'.get_permalink().'" title="'.the_title_attribute('echo=0').'" class="title">'.text_trim(get_the_title(),$title_length,'...').'</a>';
	if($show_time == 'on')	$out .= '<em>'.get_the_time(get_option('date_format')).'</em>';
	if($show_excerpt == 'on')	$out .= text_trim(get_the_excerpt(),$excerpt_length,'...');
	

	$out .= '<div class="clear"></div></li>';
	endwhile;wp_reset_query();
	$out.= '</ul>';
	
	return $out;
}

// Custom recent comment
function recent_comment($number, $comment_length, $show_comment_time){
	global $wpdb;
	$recent_comments = "SELECT DISTINCT ID, post_title, post_password, comment_ID, comment_post_ID, comment_author, comment_author_email, comment_date_gmt, comment_approved, comment_type, comment_author_url, SUBSTRING(comment_content,1,110) AS com_excerpt FROM $wpdb->comments LEFT OUTER JOIN $wpdb->posts ON ($wpdb->comments.comment_post_ID = $wpdb->posts.ID) WHERE comment_approved = '1' AND comment_type = '' AND post_password = '' ORDER BY comment_date_gmt DESC LIMIT $number";
	$the_comments = $wpdb->get_results($recent_comments);
	$out = '<ul>';
	foreach ($the_comments as $comment) {
		$out.= '<li>'.get_avatar($comment, '50');
		$out.= '<p><cite>'.strip_tags($comment->comment_author).':</cite>';
			
		$out.= ' <a href="'.get_permalink($comment->ID).'#comment-'.$comment->comment_ID.'" title="'.strip_tags($comment->comment_author).' on '.$comment->post_title.'">';
		$out.= text_trim(strip_tags($comment->com_excerpt), $comment_length,'...').'</a>';
		
		if($show_comment_time == 'on') {
			$time_ago = sprintf(__('%s ago', 'presslayer'), human_time_diff(strtotime($comment->comment_date_gmt)));
			$out.= ' <em>('.$time_ago.')</em>';
		}
		
		$out .= '</p><div class="clear"></div></li>';	
	}
	$out.= '</ul>';
	
	return $out; 
}

// Tag cloud
function tag_cloud($count, $show_count){
	$tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => $count));
	$out = '<ul>';
	foreach ((array) $tags as $tag) {
		$out .= '<li><a href="' . get_tag_link ($tag->term_id) . '" title="'.$tag->count.' '. __('toptic','presslayer').'">' . $tag->name . '';
		if($show_count == 'on') $out .= ' ('.$tag->count.')';
		$out .= '</a></li>';
	}
	$out .= '</ul>';
	
	return $out; 
}


function social_share(){
global $theme_url, $post;
$image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'fulls-size');
?>
<div class="social_share"><ul>
<li>
<a href="http://www.facebook.com/share.php?u=<?php the_permalink();?>" target="_blank">
<img src="<?php echo $theme_url;?>/images/social_share/facebook.png" /></a>
</li><li>
<a href="http://twitter.com/home?status=<?php the_title();?> - <?php the_permalink();?>" target="_blank"><img src="<?php echo $theme_url;?>/images/social_share/twitter.png"></a>
</li>
<li>
<a href="https://plus.google.com/share?url=<?php the_permalink();?>" onClick="javascript:window.open(this.href,&#39;&#39;, &#39;menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=320,width=620&#39;);return false;">
<img class="no-preload" src="<?php echo $theme_url;?>/images/social_share/google_plus.png" alt="google-share"></a>
</li>
<li>
<a href="http://www.linkedin.com/shareArticle?mini=true&url=<?php the_permalink();?>&title=<?php the_title();?>" target="_blank">
<img class="no-preload" src="<?php echo $theme_url;?>/images/social_share/linkedin.png"></a>
</li>
<li>
<a href="http://www.stumbleupon.com/submit?url=<?php the_permalink();?>&title=<?php the_title();?>" target="_blank"><img src="<?php echo $theme_url;?>/images/social_share/stumbleupon.png"></a>
</li><li>
<a href="http://www.myspace.com/Modules/PostTo/Pages/?u=<?php the_permalink();?>" target="_blank">
<img src="<?php echo $theme_url;?>/images/social_share/myspace.png"></a>
</li><li>
<a href="http://delicious.com/post?url=<?php the_permalink();?>&title=<?php the_title();?>" target="_blank"><img src="<?php echo $theme_url;?>/images/social_share/delicious.png"></a>
</li><li>
<a href="http://digg.com/submit?url=<?php the_permalink();?>&title=<?php the_title();?>" target="_blank">
<img src="<?php echo $theme_url;?>/images/social_share/digg.png"></a>
</li><li>
<a href="http://pinterest.com/pin/create/button/?url=<?php the_permalink();?>&media=<?php echo $image[0];?>" class="pin-it-button" count-layout="horizontal" onClick="javascript:window.open(this.href,&#39;&#39;, &#39;menubar=no,toolbar=no,resizable=yes,scrollbars=yes,height=320,width=620&#39;);return false;">
<img class="no-preload" src="<?php echo $theme_url;?>/images/social_share/pinterest.png"></a></li>

</ul>	
</div>

<?php 
}

global $pl_data;
if($pl_data['captcha']!='no'){		
	global $comment;
	session_start();
	if (isset( $_POST['captcha_code'] )) {
		if ( "" ==  $_POST['captcha_code'] ) wp_die( __('Please fill the form.', 'presslayer' ) );
		if (empty($_SESSION['captcha']) || trim(strtolower($_POST['captcha_code'])) != $_SESSION['captcha']) {
			wp_die( __('Error: You have entered an incorrect CAPTCHA value. Click the BACK button on your browser, and try again.', 'presslayer'));
		}else{
			return($comment);
		}
	} else {
		$captcha_file = get_template_directory_uri() . '/libs/captcha/captcha.php'; 
	}
}
?>