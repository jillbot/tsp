<?php

add_action('init','of_options');

if (!function_exists('of_options'))
{
	function of_options()
	{
		//Access the WordPress Categories via an Array
		$of_categories 		= array();  
		$of_categories_obj 	= get_categories('hide_empty=0');
		foreach ($of_categories_obj as $of_cat) {
		    $of_categories[$of_cat->cat_ID] = $of_cat->cat_name;}
		$categories_tmp 	= array_unshift($of_categories, "Select a category:");    
	       
		//Access the WordPress Pages via an Array
		$of_pages 			= array();
		$of_pages_obj 		= get_pages('sort_column=post_parent,menu_order');    
		foreach ($of_pages_obj as $of_page) {
		    $of_pages[$of_page->ID] = $of_page->post_name; }
		$of_pages_tmp 		= array_unshift($of_pages, "Select a page:");       
	
		//Testing 
		$of_options_select 	= array("one","two","three","four","five"); 
		$of_options_radio 	= array("one" => "One","two" => "Two","three" => "Three","four" => "Four","five" => "Five");
		
		//Sample Homepage blocks for the layout manager (sorter)
		$of_options_homepage_blocks = array
		( 
			"disabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_one"		=> "Block One",
				"block_two"		=> "Block Two",
				"block_three"	=> "Block Three",
			), 
			"enabled" => array (
				"placebo" 		=> "placebo", //REQUIRED!
				"block_four"	=> "Block Four",
			),
		);


		//Stylesheets Reader
		$alt_stylesheet_path = LAYOUT_PATH;
		$alt_stylesheets = array();
		
		if ( is_dir($alt_stylesheet_path) ) 
		{
		    if ($alt_stylesheet_dir = opendir($alt_stylesheet_path) ) 
		    { 
		        while ( ($alt_stylesheet_file = readdir($alt_stylesheet_dir)) !== false ) 
		        {
		            if(stristr($alt_stylesheet_file, ".css") !== false)
		            {
		                $alt_stylesheets[] = $alt_stylesheet_file;
		            }
		        }    
		    }
		}


		//Background Images Reader
		$bg_images_path = get_stylesheet_directory(). '/images/bg/'; // change this to where you store your bg images
		$bg_images_url = get_template_directory_uri().'/images/bg/'; // change this to where you store your bg images
		$bg_images = array();
		
		if ( is_dir($bg_images_path) ) {
		    if ($bg_images_dir = opendir($bg_images_path) ) { 
		        while ( ($bg_images_file = readdir($bg_images_dir)) !== false ) {
		            if(stristr($bg_images_file, ".png") !== false || stristr($bg_images_file, ".jpg") !== false) {
		                $bg_images[] = $bg_images_url . $bg_images_file;
		            }
		        }    
		    }
		}
		

		/*-----------------------------------------------------------------------------------*/
		/* TO DO: Add options/functions that use these */
		/*-----------------------------------------------------------------------------------*/
		
		//More Options
		$uploads_arr 		= wp_upload_dir();
		$all_uploads_path 	= $uploads_arr['path'];
		$all_uploads 		= get_option('of_uploads');
		$other_entries 		= array("Select a number:","1","2","3","4","5","6","7","8","9","10","11","12","13","14","15","16","17","18","19");
		$body_repeat 		= array("no-repeat","repeat-x","repeat-y","repeat");
		$body_pos 			= array("top left","top center","top right","center left","center center","center right","bottom left","bottom center","bottom right");
		
		// Image Alignment radio box
		$of_options_thumb_align = array("alignleft" => "Left","alignright" => "Right","aligncenter" => "Center"); 
		
		// Image Links to Options
		$of_options_image_link_to = array("image" => "The Image","post" => "The Post"); 


/*-----------------------------------------------------------------------------------*/
/* The Options Array */
/*-----------------------------------------------------------------------------------*/

// Set the Options Array
global $of_options;
$of_options = array();


$of_options[] = array( 	"name" 		=> "General Settings",
						"type" 		=> "heading"
				);
					
$url =  ADMIN_DIR . 'assets/images/';

$of_options[] = array( 	"name" 		=> "Custom Logo",
						"desc" 		=> "Upload your site logo.",
						"id" 		=> "custom_logo",
						"std" 		=> get_template_directory_uri()."/images/logo_skin1.png",
						"type" 		=> "upload"
				); 

$of_options[] = array( 	"name" 		=> "Custom Favicon",
						"desc" 		=> "Upload a 16px x 16px Png/Gif image that will represent your website's favicon.",
						"id" 		=> "custom_favicon",
						"std" 		=> get_template_directory_uri()."/images/favicon.ico",
						"type" 		=> "upload"
				); 
				
$of_options[] = array( 	"name" 		=> "Tracking Code",
						"desc" 		=> "Paste your Google Analytics (or other) tracking code here. This will be added into the footer template of your theme.",
						"id" 		=> "google_analytics",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
				
$of_options[] = array( 	"name" 		=> "Footer Text",
						"desc" 		=> "You can use the following shortcodes in your footer text: [wp-link] [theme-link] [loginout-link] [blog-title] [blog-link] [the-year]",
						"id" 		=> "footer_text",
						"std" 		=> "Powered by <a href=\"http://wordpress.org/\">WordPress</a> | Designed by <a href=\"http://www.presslayer.com/\">PressLayer.com</a>",
						"type" 		=> "textarea"
				);

$of_options[] = array( 	"name" 		=> "Enable/Disbale switcher",
						"id" 		=> "switcher",
						"std" 		=> "no",
						"type" 		=> "radio",
						"options" 	=> array('yes'=>'Enable','no'=>'Disable')
				);					

$of_options[] = array( 	"name" 		=> "Social Network",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> "Facebook",
						"desc" 		=> "Enter Facebook url",
						"id" 		=> "sn_facebook",
						"std" 		=> "https://www.facebook.com/presslayer",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Twitter",
						"desc" 		=> "Enter Twitter username",
						"id" 		=> "sn_twitter",
						"std" 		=> "PressLayer",
						"type" 		=> "text"
				);				
$of_options[] = array( 	"name" 		=> "Google plus",
						"desc" 		=> "Enter Google plus url",
						"id" 		=> "sn_google_plus",
						"std" 		=> "",
						"type" 		=> "text"
				);								
$of_options[] = array( 	"name" 		=> "Pinterest",
						"desc" 		=> "Enter Pinterest username",
						"id" 		=> "sn_pinterest",
						"std" 		=> "PressLayer",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Youtube",
						"desc" 		=> "Enter Youtube username",
						"id" 		=> "sn_youtube",
						"std" 		=> "presslayer",
						"type" 		=> "text"
				);	
				
$of_options[] = array( 	"name" 		=> "Vimeo",
						"desc" 		=> "Enter Vimeo username",
						"id" 		=> "sn_vimeo",
						"std" 		=> "PressLayer",
						"type" 		=> "text"
				);
$of_options[] = array( 	"name" 		=> "Flickr",
						"desc" 		=> "Enter Flickr username",
						"id" 		=> "sn_flickr",
						"std" 		=> "PressLayer",
						"type" 		=> "text"
				);	
$of_options[] = array( 	"name" 		=> "Dribbble",
						"desc" 		=> "Enter Dribbble username",
						"id" 		=> "sn_dribbble",
						"std" 		=> "PressLayer",
						"type" 		=> "text"
				);	

$of_options[] = array( 	"name" 		=> "Tumblr",
						"desc" 		=> "Enter Tumblr username",
						"id" 		=> "sn_tumblr",
						"std" 		=> "presslayer",
						"type" 		=> "text"
				);	

$of_options[] = array( 	"name" 		=> "Linkedin",
						"desc" 		=> "Enter Linkedin url",
						"id" 		=> "sn_linkedin",
						"std" 		=> "",
						"type" 		=> "text"
				);														

$of_options[] = array( 	"name" 		=> "RSS Feed",
						"desc" 		=> "Enter RSS Feed url",
						"id" 		=> "sn_rss",
						"std" 		=> "",
						"type" 		=> "text"
				);
					
$of_options[] = array( 	"name" 		=> "Home Settings",
						"type" 		=> "heading"
				);


				
$of_options[] = array( 	"name" 		=> "Enable slider",
						"desc" 		=> "Enable/Disable slider",
						"id" 		=> "enable_slider",
						"std" 		=> "yes",
						"type" 		=> "radio",
						"options" 	=> array('yes'=>'Enable','no'=>'Disable')
				);				
					
$of_options[] = array( 	"name" 		=> "Blog Settings",
						"type" 		=> "heading"
				);	
$of_options[] = array( 	"name" 		=> "Excerpt length",
						"desc" 		=> "Enter number of words for  excerpt length. ",
						"id" 		=> "ex_length",
						"std" 		=> "25",
						"type" 		=> "text"
				);

$of_options[] = array( 	"name" 		=> "Enable related posts",
						"id" 		=> "enable_related_posts",
						"std" 		=> "yes",
						"type" 		=> "radio",
						"options" 	=> array('yes'=>'Enable','no'=>'Disable')
				);	
$of_options[] = array( 	"name" 		=> "Captcha in comment form",
						"id" 		=> "captcha",
						"std" 		=> "yes",
						"type" 		=> "radio",
						"options" 	=> array('yes'=>'Enable','no'=>'Disable')
				);										
				
$of_options[] = array( 	"name" 		=> "Styling Options",
						"type" 		=> "heading"
				);

$of_options[] = array( 	"name" 		=> "Skin",
						"id" 		=> "skin",
						"std" 		=> "skin1",
						"type" 		=> "select",
						"options" 	=> array('skin1','skin2','skin3','skin4','skin5','skin6','skin7')
				);				
				
$of_options[] = array( 	"name" 		=> "Body Background Color",
						"desc" 		=> "Pick a background color for the theme (default: #fff).",
						"id" 		=> "body_background",
						"std" 		=> "",
						"type" 		=> "color"
				);
$of_options[] = array( 	"name" 		=> "Background Images",
						"desc" 		=> "Select a background pattern.",
						"id" 		=> "custom_bg",
						"std" 		=> $bg_images_url."white_wall.png",
						"type" 		=> "tiles",
						"options" 	=> $bg_images,
				);
				
$of_options[] = array( 	"name" 		=> "Custom CSS",
						"desc" 		=> "Quickly add some CSS to your theme by adding it to this block.",
						"id" 		=> "custom_css",
						"std" 		=> "",
						"type" 		=> "textarea"
				);
				
// Backup Options
$of_options[] = array( 	"name" 		=> "Backup Options",
						"type" 		=> "heading"
				);
				
$of_options[] = array( 	"name" 		=> "Backup and Restore Options",
						"id" 		=> "of_backup",
						"std" 		=> "",
						"type" 		=> "backup",
						"desc" 		=> 'You can use the two buttons below to backup your current options, and then restore it back at a later time. This is useful if you want to experiment on the options but would like to keep the old settings in case you need it back.',
				);
				
$of_options[] = array( 	"name" 		=> "Transfer Theme Options Data",
						"id" 		=> "of_transfer",
						"std" 		=> "",
						"type" 		=> "transfer",
						"desc" 		=> 'You can tranfer the saved options data between different installs by copying the text inside the text box. To import data from another install, replace the data in the text box with the one from another install and click "Import Options".',
				);
				
	}//End function: of_options()
}//End chack if function exists: of_options()
?>
