<?php
if ( !defined( 'ABSPATH' ) ) die( 'Eh! What you doin in here?' );
require( 'class-reorder.php' );
define( 'REORDER_DIR', ''); // Plugin folder DIR
define( 'REORDER_URL', get_template_directory_uri(). '/libs/metronet-reorder-posts' ); // Plugin folder URL
add_action( 'wp_loaded', 'mn_reorder_posts_init', 100 ); //Load low priority in init for other plugins to generate their post types

function mn_reorder_posts_init() {
	new Reorder(
		array(
			'post_type'   => 'slider',
			'order'       => 'ASC',
			'heading'     =>  'Reorder slides',
			'final'       => '',
			'initial'     => '',
			'menu_label'  => 'Reorder',
			'icon'        => REORDER_URL . '/reorder_icon.png',
			'post_status' => 'publish',
		)
	);
} //end mt_reorder_posts_init

