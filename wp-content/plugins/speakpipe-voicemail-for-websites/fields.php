<?php

if( !class_exists( 'zelenin_fields' ) ) {

class zelenin_fields {

	private $prefix = 'zf_';

	function __construct( $fields, $fields_type, $fields_id, $fields_name = 'Settings', $object_type, $dev = 0 ) {

		$prefix = $this->prefix;

		$this->fields = isset( $fields ) ? $fields : $defaults;
		$this->fields_type = $fields_type;
		$this->fields_id = $this->slug = $fields_id;
		$this->fields_name = $fields_name;
		$this->object_type = $object_type;
		$this->dev = $dev;

		add_action( 'admin_init', array( $this, 'fields_init' ) );

		if ( $this->fields_type == 2 ) add_action( 'admin_menu', array( $this, 'init_admin_menu' ) );
	}

	function fields_init() {
		foreach ( $this->fields as $tab_fields ) {
			add_settings_section( $tab_fields['id'], $tab_fields['label'], array( $this, 'fields_section_callback' ), $this->slug );
			foreach ( $tab_fields['content'] as $field ) {
				register_setting( $this->slug, $field['label'], array( $this, 'fields_sanitize_callback' ) );
				add_settings_field( $field['id'], $field['label'], array( $this, 'generate_fields_callback' ), $this->slug, $tab_fields['id'], array( 'setting' => $field ) );
			}
		}
		//add_action( 'admin_print_scripts', array( $this, 'add_fields_scripts' ) );
		//add_action( 'admin_print_footer_scripts', array( $this, 'add_footer_scripts' ) );
	}

	function init_admin_menu() {
		$page = add_options_page( $this->fields_name, $this->fields_name, 'manage_options', $this->slug, array( $this, 'generate_page' ), admin_url( 'images/generic.png' ), 999 );
		// add_action( 'admin_head-' . $page, array( $this, 'add_fields_scripts' ) );
		// add_action( 'admin_footer-' . $page, array( $this, 'add_footer_scripts' ) );
	}

	function fields_section_callback() {
		echo 'fields_section_callback';
	}

	function fields_sanitize_callback() {
		echo 'settings_sanitize_callback';
	}

	function generate_fields_callback( $args ) {

		$field = $args['setting'];

		if ( $this->fields_type == 2 ) {
			$value = get_option( $field['id'] );
		}

		switch( $field['type'] ) {

			case 'text':
				echo '<div class="field"><input class="regular-text" type="text" name="' . $field['id'] . '" id="' . $field['id'] . '" value="' . $value . '"></div>';
				echo '<div class="description">' . $field['desc'] . '</div>';
				if ( $this->dev == 1 ) {
					echo '<div class="dev">';
					if ( $this->fields_type == 1 ) echo 'get_post_meta( $post->ID, \'' . $field['id'] . '\', true );';
					if ( $this->fields_type == 2 ) echo 'get_option( \'' . $field['id'] . '\' );';
					if ( $this->fields_type == 3 ) echo 'get_term_meta( $term_id, \'' . $field['id'] . '\', true );';
					echo '</div>';
				}
			break;

			case 'checkbox':
				echo '<div class="field"><input type="checkbox" name="' . $field['id'] . '" id="' . $field['id'] . '" ' . checked( $value, 'on', false ) . '></div>';
				echo '<div class="description">' . $field['desc'] . '</div>';
				if ( $this->dev == 1 ) {
					echo '<div class="dev">';
					if ( $this->fields_type == 1 ) echo 'if ( get_post_meta( $post->ID, \'' . $field['id'] . '\', true ) ) { } else { }';
					if ( $this->fields_type == 2 ) echo 'if ( get_option( \'' . $field['id'] . '\' ) ) { } else { }';
					if ( $this->fields_type == 3 ) echo 'if ( get_term_meta( $term_id, \'' . $field['id'] . '\', true ) ) { } else { }';
					echo '</div>';
				}
				echo '<style>#' . $field['id'] . '{width:auto!important}</style>';
			break;
		}

		//do_action( 'custom_zelenin_fields', $field );

	}

	function generate_page( $type = '' ) {

		if ( $this->fields_type == 2 ) {

			if ( isset( $_POST['speakpipe_id'] ) && empty( $_POST['speakpipe_id'] ) ) {

			} else {
				add_settings_error( 'updated', 'settings_updated', 'Settings saved.', 'updated' );
			}

			if ( isset( $_POST['submit'] ) ) $this->fields_update();

			echo '<div class="wrap">';
				screen_icon( 'options-general' );
				echo '<h2>' . $this->fields_name . '</h2>';
				if ( isset( $_POST['submit'] ) ) settings_errors( 'updated', true, false );
				echo '<form method="post" action="">';
					settings_fields( $this->slug );
					echo '<p><img src="' . plugins_url( 'images/logo.png', __FILE__ ) . '"></p>';
					echo '<p>SpeakPipe allows your customers, podcast listeners, blog readers and fans to send you voice messages (voicemail) right from a browser without any phone calls.</p>';
					// submit_button( 'Save changes', 'primary', 'submit', 'true' );

		}

				if ( $this->fields_type == 1 || $this->fields_type == 2 ) {

					echo '<div id="settings-tabs">';
						if ( count( $this->fields ) > 1 ) {

							echo '<ul>';
							foreach( $this->fields as $tab_fields ) {
								echo '<li><a href="#' . $tab_fields['id'] . '">' . $tab_fields['label'] . '</a></li>';
							} ?>
							<script>
								(function($) {
									$(function() {
										$( '#settings-tabs' ).tabs();
									});
								})(jQuery);
							</script>
							<?php echo '</ul>';

						}

						foreach( $this->fields as $tab_fields ) {
							echo '<div id="' . $tab_fields['id'] . '">';
								echo '<table class="form-table">';
									do_settings_fields( $this->slug, $tab_fields['id'] );
								echo '</table>';
							echo '</div>';
						}

					echo '</div>';

				}

		if ( $this->fields_type == 2 ) {
			echo '<p style="margin-left:10px;">You can configure the appearance of the widget in your SpeakPipe <a href="https://www.speakpipe.com/account/settings/widget" target="_blank">settings</a></p>';
			submit_button( 'Save changes', 'primary', 'submit', 'true' );
			echo '</form>';
			echo '<div class="updated fade"><p><strong>Don\'t have an account? No problem! <a href="http://www.speakpipe.com/" target="_blank">Register for a FREE SpeakPipe account right now!</a></strong></p></div>';
			echo '</div>';

		}
	}

	function do_settings_fields( $page, $section, $type ) {

	}

	function fields_update( $object_id = 0 ) {

		foreach ( $this->fields as $tab_fields ) {

			foreach ( $tab_fields['content'] as $field ) {

				$field_value = isset( $_POST[$field['id']] ) ? $_POST[$field['id']] : '';

				if ( is_array( $field_value ) ) {
					$field_value = array_filter( $field_value );
					$field_value = array_values( $field_value );
				}

				if ( $field['type'] == 'text' ) $field_value = esc_attr( stripslashes( $field_value ) );

				if ( $this->fields_type == 2 ) !empty( $field_value ) ? update_option( $field['id'], $field_value ) : delete_option( $field['id'] );
			}

		}

	}

}

}