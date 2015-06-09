<?php
class Mikado_Sticky_Sidebar extends WP_Widget {

	public function __construct() {
		parent::__construct(
			'mkd_sticky_sidebar', // Base ID
			'Mikado Sticky Sidebar', // Name
			array( 'description' => __( 'Use this widget to make the sidebar sticky. Drag it into the sidebar above the widget which you want to be the first element in the sticky sidebar.', 'mkd' ), ) // Args
		);
	}

	public function widget( $args, $instance ) {
		echo '<div class="widget widget_sticky-sidebar"></div>';
	}


	public function update( $new_instance, $old_instance ) {
		$instance = array();
		return $instance;
	}

}
add_action( 'widgets_init', create_function( '', 'register_widget( "Mikado_Sticky_Sidebar" );' ) );
