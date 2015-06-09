<?php
/*
Plugin Name: SpeakPipe - Voicemail for Websites
Plugin URI: http://www.speakpipe.com
Description: SpeakPipe allows your customers, podcast listeners, blog readers and fans to send you voice messages (voicemail) right from a browser without any phone calls.
Version: 0.1
Author: SpeakPipe Team
Author URI: http://www.speakpipe.com
Author Email: support@speakpipe.com
License: GPLv2 or later
*/

class SpeakPipe {

	private $plugin_name = 'SpeakPipe';
	private $plugin_slug = 'speakpipe';

	function __construct() {

		add_action( 'init', array( $this, 'init_settings' ) );
		add_action( 'admin_notices', array( $this, 'speakpipe_notice' ) );
		add_action( 'wp_footer', array( $this, 'add_footer_script' ) );
		add_filter( 'plugin_action_links', array( $this, 'options_links' ), 10, 2 );
	}

	function init_settings() {
		include( plugin_dir_path( __FILE__ ) . '/options.php' );
		include( plugin_dir_path( __FILE__ ) . '/fields.php' );
		new zelenin_fields( $options, 2, $this->plugin_slug, $this->plugin_name, '', 0 );
	}

	function options_links( $links, $file ) {
		if ( $file != plugin_basename( __FILE__ )) return $links;
		$settings_link = '<a href="options-general.php?page=' . $this->plugin_slug . '">Settings</a>';
		array_unshift( $links, $settings_link );
		return $links;
	}

	function speakpipe_notice() {
		if ( isset( $_POST['speakpipe_id'] ) && !empty( $_POST['speakpipe_id'] ) ) {
			if ( !preg_match( '/^[a-zA-Z0-9]+$/', $_POST['speakpipe_id'] ) ) {
				$_POST['speakpipe_id'] = get_option( 'speakpipe_id' );
				$error = 1;
				echo '<div class="error fade"><p><strong>SpeakPipe account ID is invalid. Please enter a valid ID.</strong></p></div>';
			}
		}
		if (
			!get_option( 'speakpipe_id' ) && !isset( $_POST['speakpipe_id'] ) ||
			!get_option( 'speakpipe_id' ) && $_POST['speakpipe_id'] == '' && isset( $_POST['speakpipe_id'] ) ||
			get_option( 'speakpipe_id' ) && $_POST['speakpipe_id'] == '' && isset( $_POST['speakpipe_id'] ) ||			
			get_option( 'speakpipe_id' ) == '' && !isset( $_POST['speakpipe_id'] )
		) {
			echo '<div class="error fade"><p><strong>SpeakPipe is disabled. Please go to the <a href="options-general.php?page=' . $this->plugin_slug . '">plugin page</a> and enter a valid account ID to enable it.</strong></p></div>';
		}
	}

	function add_footer_script() {

		$script = '
			<!-- Begin SpeakPipe code -->
			<script type="text/javascript">
				(function(d){
					var app = d.createElement(\'script\');
					app.type = \'text/javascript\';
					app.async = true;
					var pt = (\'https:\' == document.location.protocol ? \'https://\' : \'http://\');
					app.src = pt + \'www.speakpipe.com/loader/' . get_option( 'speakpipe_id' ) . '.js?wp-plugin=1\';
					var s = d.getElementsByTagName(\'script\')[0];
					s.parentNode.insertBefore(app, s);
				})(document);
			</script>
			<!-- End SpeakPipe code -->';

		if ( get_option( 'speakpipe_id' ) ) {
			if ( get_option( 'speakpipe_front' ) ) {
				if ( !is_front_page() ) echo $script;
			} else {
				echo $script;

			}
		}

	}

}

new SpeakPipe();
