<?php

/*
Plugin Name: Simple Podcast Press

Description: A Podcast Player Designed To Grow Your Audience and Build Your Email List On Autopilot.

Version: 1.421

Author: Hani Mourra

Plugin URI: http://www.simplepodcastpress.com/
*/

global $sppress_current_version;
$sppress_current_version = "1.421";

define( 'SPP_STORE_URL', 'http://simplepodcastpress.com' );

global $sppress_current_version;

if( !class_exists( 'SPP_SL_Plugin_Updater' ) ) {
	include( dirname( __FILE__ ) . '/updater/SPP_SL_Plugin_Updater.php' );
}

function spp_sl_sample_plugin_updater() {


global $pagenow;

if ( $pagenow == 'plugin.php' ) {
	
	set_site_transient( 'update_plugins', null );
}

    $license_key = get_option('edd_sppress_license_key');
	
	$edd_updater = new SPP_SL_Plugin_Updater( SPP_STORE_URL, __FILE__, array(
			'version' 	=> $sppress_current_version,
			'license' 	=> $license_key,
			'item_name' => 'Simple Podcast Press',
			'author' 	=> 'Hani Mourra'  
		)
	);

}


 add_action( 'admin_init', 'spp_sl_sample_plugin_updater', 0 );


include_once('spp.php');
include_once(ABSPATH . 'wp-includes/pluggable.php');

$ob_wp_simplepodcastpress=new wp_simplepodcastpress();
	if(isset($ob_wp_simplepodcastpress)){
		register_activation_hook( __FILE__,array(&$ob_wp_simplepodcastpress,'simplepodcastpress_activate'));
		register_deactivation_hook( __FILE__, array(&$ob_wp_simplepodcastpress,'simplepodcastpress_deactivate') );
	}
	


?>