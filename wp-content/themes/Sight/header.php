<?php global $theme_url, $pl_data;?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<title><?php
	global $page, $paged;
	wp_title( '|', true, 'right' );
	bloginfo( 'name' );
	$site_description = get_bloginfo( 'description', 'display' );
	if ( $site_description && ( is_home() || is_front_page() ) )
		echo " | $site_description";
	if ( $paged >= 2 || $page >= 2 )
		echo ' | ' . sprintf( __( 'Page %s', 'presslayer' ), max( $paged, $page ) );
	?></title>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->
	
	<?php if($pl_data['custom_favicon']!='') {?>
	<link rel="shortcut icon" href="<?php echo trim($pl_data['custom_favicon']);?>">
	<?php } ?>
	<?php wp_head();?>
<body <?php body_class(''); ?>>
<div class="top_wrapper">
	<div id="header">
	<div class="container">
		<div class="row">
			<div class="twelve columns">
				<div class="header_left">
					<h1 id="logo"><?php if($pl_data['custom_logo']!='') {?><a href="<?php echo home_url();?>" title="<?php bloginfo('name');?>"><img src="<?php echo trim($pl_data['custom_logo']);?>" alt="<?php bloginfo('name');?>" id="header_logo" /><span>The Spawn Point Blog</span></a><?php }?></a></h1>
					<div class="socials">
						<?php if($pl_data['sn_facebook']!=''){?><a href="<?php echo $pl_data['sn_facebook'];?>" class="facebook" title="Facebook">Facebook</a><?php } ?>
						<?php if($pl_data['sn_twitter']!=''){?><a href="http://twitter.com/<?php echo $pl_data['sn_twitter'];?>" class="twitter" title="Twitter">Twitter</a><?php } ?>
						<?php if($pl_data['sn_google_plus']!=''){?><a href="<?php echo $pl_data['sn_google_plus'];?>" class="google_plus" title="Google_plus">Google_plus</a><?php } ?>
						<?php if($pl_data['sn_pinterest']!=''){?><a href="http://pinterest.com/<?php echo $pl_data['sn_pinterest'];?>" class="pinterest" title="Pinterest">Pinterest</a><?php } ?>
						<?php if($pl_data['sn_youtube']!=''){?><a href="http://www.youtube.com/<?php echo $pl_data['sn_youtube'];?>" class="youtube" title="Youtube">Youtube</a><?php } ?>
						<?php if($pl_data['sn_vimeo']!=''){?><a href="http://vimeo.com/<?php echo $pl_data['sn_vimeo'];?>" class="vimeo" title="Vimeo">Vimeo</a><?php } ?>
						<?php if($pl_data['sn_flickr']!=''){?><a href="http://www.flickr.com/<?php echo $pl_data['sn_flickr'];?>" class="flickr" title="Flickr">Flickr</a><?php } ?>
						<?php if($pl_data['sn_tumblr']!=''){?><a href="http://<?php echo $pl_data['sn_tumblr'];?>.tumblr.com/" class="tumblr" title="Tumblr">Tumblr</a><?php } ?>
						<?php if($pl_data['sn_dribbble']!=''){?><a href="http://dribbble.com/<?php echo $pl_data['sn_dribbble'];?>" class="dribbble" title="Dribbble">Dribbble</a><?php } ?>
						<?php if($pl_data['sn_linkedin']!=''){?><a href="<?php echo $pl_data['sn_linkedin'];?>" class="linkedin" title="Linkedin">Linkedin</a><?php } ?>
						<?php if($pl_data['sn_rss']!=''){?><a href="<?php echo $pl_data['sn_rss'];?>" class="rss" title="RSS">RSS</a><?php } ?>
						<div class="clear"></div>
					</div>

				</div>
			
				<div class="header_right">
					<div id="top_menu">
						<?php
						if(function_exists('wp_nav_menu')) {
							wp_nav_menu( 'container=false&depth=3&theme_location=navigation&menu_id=mainmenu&menu_class=sf-menu&fallback_cb=menu_default');
							?>
							<?php
						} else {
							menu_default();
						}
						
						function menu_default()
						{
							?>
							<div class="default_nav">Go to: <a href="<?php echo admin_url(); ?>nav-menus.php" target="_blank">Appearance &raquo; Menus</a> to create Navigation</div>
						<?php } ?>
					
					<div class="header_search"><div class="search_zoom search_btn"></div>
					<div class="search_box">
					<form method="get" id="searchform" action="<?php echo home_url();?>"><input id="s" name="s"   type="text" placeholder="<?php _e('Type & hit enter to search','presslayer');?>" class="search_input" /></form></div></div>	
					</div>							
					
				</div>
			</div>	
		</div>	
		</div><!-- .container -->
	</div><!-- #header -->
	
	<?php if(is_home() and $pl_data['enable_slider']!='no') get_template_part('inc/slider');?>	
	
</div> <!--.top_wrapper -->
