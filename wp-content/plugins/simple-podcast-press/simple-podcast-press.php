<?php

/*
Plugin Name: Simple Podcast Press

Description: A Podcast Player Designed To Grow Your Audience and Build Your Email List On Autopilot.

Version: 1.418

Author: Hani Mourra

Plugin URI: http://www.simplepodcastpress.com/
*/

global $sppress_current_version;
$sppress_current_version = "1.418";

require dirname(__FILE__) . '/updater/plugin-update-checker.php';
$MyUpdateChecker = PucFactory::buildUpdateChecker(
'http://simplepodcastpress.com/updater/?action=get_metadata&slug=simple-podcast-press', 
__FILE__, 
'simple-podcast-press'
);


include_once('spp.php');
include_once(ABSPATH . 'wp-includes/pluggable.php');

$ob_wp_simplepodcastpress=new wp_simplepodcastpress();
	if(isset($ob_wp_simplepodcastpress)){
		register_activation_hook( __FILE__,array(&$ob_wp_simplepodcastpress,'simplepodcastpress_activate'));
		register_deactivation_hook( __FILE__, array(&$ob_wp_simplepodcastpress,'simplepodcastpress_deactivate') );
	}
	


?>
