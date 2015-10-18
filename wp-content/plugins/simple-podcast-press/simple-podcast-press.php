<?php

/*
Plugin Name: Simple Podcast Press

Description: A Podcast Player Designed To Grow Your Audience and Build Your Email List On Autopilot.

Version: 1.423

Author: Hani Mourra

Plugin URI: http://www.simplepodcastpress.com/
*/


define( 'SPPRESS_PLUGIN_VERSION', '1.423' );
define( 'SPPRESS_STORE_URL', 'http://simplepodcastpress.com' );
define( 'SPPRESS_ITEM_NAME', 'Simple Podcast Press' );

if( !class_exists( 'SPP_SL_Plugin_Updater' ) ) {
	include( dirname( __FILE__ ) . '/updater/SPP_SL_Plugin_Updater.php' );
}


function spp_sl_sample_plugin_updater() {


global $pagenow;

if ( $pagenow == 'plugin.php' ) {
	
	set_site_transient( 'update_plugins', null );
}

    $license_key = get_option('edd_sppress_license_key');
	
	$edd_updater = new SPP_SL_Plugin_Updater( SPPRESS_STORE_URL, __FILE__, array(
			'version' 	=> SPPRESS_PLUGIN_VERSION,
			'license' 	=> $license_key,
			'item_name' => SPPRESS_ITEM_NAME,
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