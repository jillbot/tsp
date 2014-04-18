<?php
require_once ('admin/index.php');
$pl_data = $smof_data;
require_once ('libs/multiple_sidebars.php');
require_once ('libs/metaboxes/class-usage.php');
require_once ('libs/metronet-reorder-posts/index.php');
require_once ('libs/shortcodes/shortcodes.php');
require_once ('libs/custom_functions.php');
require_once ('libs/aq_resizer.php');
require_once ('libs/likethis.php');

// Widgets
require_once ('libs/widgets/tabs.php');
require_once ('libs/widgets/recent_posts.php');
require_once ('libs/widgets/ads.php');
require_once ('libs/widgets/flickr.php');
require_once ('libs/widgets/facebook_box.php');
require_once ('libs/widgets/social.php');
require_once ('libs/widgets/tweet.php');
require_once ('libs/widgets/newsletter.php');


$theme_url = get_template_directory_uri();
global  $pl_data, $theme_url;

// Localization
load_theme_textdomain('presslayer', get_template_directory() . '/languages/');

// Get scripts
add_action('wp_enqueue_scripts','theme_scripts_function');

function theme_scripts_function() {
	global $post, $pl_data, $theme_url;
	
	//CSS
	wp_enqueue_style('Oswald', 'http://fonts.googleapis.com/css?family=Oswald:700,300');
	wp_enqueue_style('Titillium Web', 'http://fonts.googleapis.com/css?family=Titillium+Web:400,300italic,200italic');
	wp_enqueue_style('reset', $theme_url . '/css/reset.css');
	wp_enqueue_style('responsive', $theme_url . '/css/responsive.css');
	wp_enqueue_style('font-awesome.min', $theme_url . '/css/font-awesome.min.css');
	wp_enqueue_style('flexslider', $theme_url . '/css/flexslider.css');
	wp_enqueue_style('superfish', $theme_url . '/css/superfish.css');
	wp_enqueue_style('mediaelement', $theme_url . '/js/mediaelement/build/mediaelementplayer.min.css');
	wp_enqueue_style('style', get_bloginfo('stylesheet_url'));
	wp_enqueue_style('fancybox', $theme_url . '/js/fancybox/jquery.fancybox-1.3.4.css');
	wp_enqueue_style('skin', $theme_url . '/css/'.$pl_data['skin'].'.css');
	
	//JS
	wp_enqueue_script('jquery');
	wp_enqueue_script('easing', $theme_url . '/js/jquery.easing-1.3.js',array('jquery'), '1.0', true);
	wp_enqueue_script('masonry', $theme_url . '/js/jquery.masonry.min.js',array('jquery'), '1.0', true);
	wp_enqueue_script('imagesloaded', $theme_url . '/js/jquery.imagesloaded.min.js',array('jquery'), '1.0', true);
	wp_enqueue_script('infinitescroll', $theme_url . '/js/jquery.infinitescroll.min.js',array('jquery'), '1.0', true);
	wp_enqueue_script('superfish', $theme_url . '/js/superfish.js',array('jquery'), '1.0', true);
	wp_enqueue_script('hoverIntent', $theme_url . '/js/hoverIntent.js',array('jquery'), '1.0', true);
	wp_enqueue_script('mediaelement', $theme_url . '/js/mediaelement/build/mediaelement-and-player.min.js',array('jquery'), '1.0', true);
	wp_enqueue_script('fancybox', $theme_url . '/js/fancybox/jquery.fancybox-1.3.4.pack.js',array('jquery'), '1.0', true);
	wp_enqueue_script('mobilemenu', $theme_url . '/js/jquery.mobilemenu.js',array('jquery'), '1.0', true);
	wp_enqueue_script('fitvids', $theme_url . '/js/jquery.fitvids.js',array('jquery'), '1.0', true);
	wp_enqueue_script('flexslider', $theme_url . '/js/jquery.flexslider-min.js',array('jquery'), '1.0', true);
	wp_enqueue_script('placeholder', $theme_url . '/js/jquery.placeholder.min.js',array('jquery'), '1.0', true);
	wp_enqueue_script('jflickrfeed', $theme_url . '/js/jflickrfeed.min.js',array('jquery'), '1.0', true);
	wp_enqueue_script('custom', $theme_url . '/js/custom.js',array('jquery'), '1.0', true);
	
	if ( is_singular() ) wp_enqueue_script( "comment-reply" );
	
	
}

// Custom styles
add_action('wp_head', 'theme_css_function');
function theme_css_function() {
	global $post, $pl_data, $theme_url;
	
	echo '<style type="text/css">';
	if($pl_data['custom_bg']!='') echo 'body{ background-image: url('.$pl_data['custom_bg'].')}';
	if($pl_data['body_background']!='') echo 'body{ background-color: '.$pl_data['body_background'].'}';	
	
	// Custom page background 
	if(is_page() or is_single()){
	$background = get_post_meta($post->ID, 'pl_background', true);
	$bg_align = get_post_meta($post->ID, 'pl_bg_align', true);
	$bg_attachment = get_post_meta($post->ID, 'pl_bg_attachment', true);
	$bg_repeat = get_post_meta($post->ID, 'pl_bg_repeat', true);
	$bg_size = get_post_meta($post->ID, 'pl_bg_size', true);
	
		if($background!='') {
			echo 'body.page-id-'.$post->ID.'{ background-image: url('.$background.'); background-position: '.$bg_align.'; background-repeat: '.$bg_repeat.'; background-attachment: '.$bg_attachment.';';
			if($bg_size!='none') echo 'background-size: '.$bg_size.'!important';
			echo '}';
		}
	}
	
	if(!empty($pl_data['custom_css'])) echo stripslashes($pl_data['custom_css']);
	echo '</style>';
}

// Menu
register_nav_menu('navigation', 'Navigation'); 

// Add theme support
add_theme_support('post-thumbnails');
add_theme_support('custom-background');
add_theme_support('automatic-feed-links');
add_theme_support( 'post-formats', array( 'audio','video', 'quote') );

if ( ! isset( $content_width ) ) $content_width = 1030;


/*-----------------------------------------------------------------------------------*/
/*	Custom Post Types
/*-----------------------------------------------------------------------------------*/

add_action( 'init', 'create_post_types' );
function create_post_types() {
	
		
	// Slider Post Type
	register_post_type( 'slider',
		array(
		  'labels' => array(
			'name' => __( 'Slider','presslayer' ),
			'singular_name' => __( 'Slider','presslayer' )
		  ),
		  'public' => true,
		  'supports' => array('title','editor','thumbnail')
		)
	);
	
}


/*-----------------------------------------------------------------------------------*/
/*	Register Sidebars
/*-----------------------------------------------------------------------------------*/

if ( function_exists('register_sidebar') ){

	// Default sidebar
	register_sidebar(array(
		'name' => 'Sidebar',
		'id' => 'sidebar',
		'description' => 'Widgets in this area will be shown in the sidebar on the blog and regular posts.',
		'before_widget' => '<div id="%1$s" class="widget %2$s white_box">',
		'after_widget' => '<div class="clear"></div></div>',
		'before_title' => '<h3 class="widget_title">',
		'after_title' => '</h3>',
	));
	
} //function_exists('register_sidebar')


?>