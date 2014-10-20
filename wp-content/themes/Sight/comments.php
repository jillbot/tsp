<?php if ( post_password_required() ) : ?>
<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'presslayer' ); ?></p>
<?php
	return;
endif;
?>

<?php // You can start editing here -- including this comment! ?>
<?php if ( have_comments() ) : ?>
<div id="comments">
	<?php
		if(get_comments_number() == 1) $cm_str = __('One comment','presslayer');
		else $cm_str = get_comments_number(). __(' comments','presslayer');
	?>
	<h3 class="block_title mb10"><span class="block_title_label"><?php echo $cm_str;?></span></h3>
	<ol class="commentlist"><?php wp_list_comments( array( 'callback' => 'comment_list' ) );?></ol>
	
	<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : // are there comments to navigate through ?>
		<div id="comment_nav"> 
			<?php previous_comments_link( '&larr; '.__( 'Older Comments', 'presslayer' ) ); ?>
			<?php next_comments_link( __( 'Newer Comments', 'presslayer' ).' &rarr;' ); ?>
		</div>
	<?php endif; // check for comment navigation ?>
	
</div>	
<?php endif; ?>

<?php 
$commenter = wp_get_current_commenter();
$req = get_option( 'require_name_email' );
$aria_req = ( $req ? " aria-required='true'" : '' );
global $captcha_file, $pl_data;

$comment_form_fields =  array(
		'author' => '<div class="comment_field comment_form_author"><label for="author">' . __( 'Name', 'presslayer' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="50" ' . $aria_req . ' /></div>', 
		
		'email'  => '<div class="comment_field comment_form_email"><label for="email">' . __( 'Email', 'presslayer' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="50"' . $aria_req . ' /></div>',
		
		'url'    => '<div class="comment_field comment_form_url '. ( $pl_data['captcha']!='no' ? '' : 'fullwidth' ) .'"><label for="url">' . __( 'Website', 'presslayer' ) . '</label><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '" size="50" /></div>');

if($pl_data['captcha']!='no'){		
	$comment_form_fields['captcha'] = '<div class="comment_field comment_form_captcha"><label for="captcha_code">' . __( 'Anti spam', 'presslayer' ) . ' <span class="required">*</span></label><input id="captcha_code" name="captcha_code" type="text" value="" size="50" class="cap_input" autocomplete="off" /><img src="'.$captcha_file.'" id="captcha" alt="captcha" class="captcha_img" /> <a href="#" onclick="
    document.getElementById(\'captcha\').src=\''.get_template_directory_uri().'/libs/captcha/captcha.php?\'+Math.random();
    document.getElementById(\'captcha_code\').focus(); return false;"
    id="change-image">Refresh?</a></div>';		
}

$comment_form = array( 
	'fields' => apply_filters( 'comment_form_default_fields', $comment_form_fields),
		
		'comment_field' => '<div class="comment_field comment_form_comment"><label for="comment">' . __( 'Comment', 'presslayer' ) . ( $req ? ' <span class="required">*</span>' : '' ) . '</label><textarea row="10" id="comment" name="comment" ' . $aria_req . '></textarea>' .'</div>',
		'comment_notes_before' => '',
		'comment_notes_after' => '<em class="respond_info">Required fields are marked (<span class="required">*</span>)</em>',
		'title_reply' => '<span class="block_title_label">'.__('Leave a reply','presslayer').'</span>',
	); 
	
comment_form($comment_form, $post->ID); 
?>
