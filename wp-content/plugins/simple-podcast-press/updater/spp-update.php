<?php
/*************************************************************************************************************
file spp-update.php is a part of Simple Podcast Press and contains proprietary code - simplepodcastpress.com
*************************************************************************************************************/
// this is the URL our updater / license checker pings. This should be the URL of the site with EDD installed
define( 'SPP_STORE_URL', 'http://simplepodcastpress.com' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file

// the name of your product. This should match the download name in EDD exactly
define( 'SPP_ITEM_NAME', 'Simple Podcast Press' ); // you should use your own CONSTANT name, and be sure to replace it throughout this file


/************************************
* the code below is just a standard
* options page. Substitute with 
* your own.
*************************************/

function edd_sppress_license_menu() {
	//add_plugins_page( 'Plugin License', 'Plugin License', 'manage_options', 'pluginname-license', 'edd_sppress_license_page' );
    add_submenu_page( 'spp-podcast-settings', 'Simple Podcast Press', 'License', 'manage_options', 'spp-license', 'edd_sppress_license_page');
}
add_action('admin_menu', 'edd_sppress_license_menu');

function edd_sppress_license_page() {
	$license 	= get_option( 'edd_sppress_license_key' );
	$status 	= get_option( 'sppress_ls' );
	?>
	<div class="wrap">
		<h2><?php _e('Simple Podcast Press License Activator'); ?></h2>
		<form method="post" action="options.php">
		
			<?php settings_fields('edd_sppress_license'); ?>
			
			<table class="form-table">
				<tbody>
					<tr valign="top">	
						<th scope="row" valign="top">
							<?php _e('License Key'); ?>
						</th>
						<td>
							<input id="edd_sppress_license_key" name="edd_sppress_license_key" type="text" class="regular-text" value="<?php esc_attr_e( $license ); ?>" />
							<label class="description" for="edd_sppress_license_key"><?php _e('Enter your license key'); ?></label>
						</td>
					</tr>
					<?php if( false !== $license ) { ?>
						<tr valign="top">	
							<th scope="row" valign="top">
								<?php _e('Activate License'); ?>
							</th>
							<td>
								<?php if( $status !== false && $status == 'valid' ) { ?>
									<span style="color:green;"><?php _e('active'); ?></span>
									<?php wp_nonce_field( 'edd_sppress_nonce', 'edd_sppress_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_deactivate" value="<?php _e('Deactivate License'); ?>"/>
								<?php } else {
									wp_nonce_field( 'edd_sppress_nonce', 'edd_sppress_nonce' ); ?>
									<input type="submit" class="button-secondary" name="edd_license_activate" value="<?php _e('Activate License'); ?>"/>
								<?php } ?>
							</td>
						</tr>
					<?php } ?>
				</tbody>
			</table>	
			<?php submit_button(); ?>
		
		</form>
	<?php
}

function edd_sppress_register_option() {
	// creates our settings in the options table
	register_setting('edd_sppress_license', 'edd_sppress_license_key', 'edd_sppress_sanitize_license' );
}
add_action('admin_init', 'edd_sppress_register_option');

function edd_sppress_sanitize_license( $new ) {
	$old = get_option( 'edd_sppress_license_key' );
	if( $old && $old != $new ) {
		delete_option( 'sppress_ls' ); // new license has been entered, so must reactivate
	}
	return $new;
}



/************************************
* this illustrates how to activate 
* a license key
*************************************/

function edd_sppress_activate_license() {

	
	

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_activate'] ) ) {

		// run a quick security check 
	 	if( ! check_admin_referer( 'edd_sppress_nonce', 'edd_sppress_nonce' ) )
			return; // get out if we didn't click the Activate button
		
	
		


		// retrieve the license from the database
		$license = trim( get_option( 'edd_sppress_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'activate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( SPP_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);
		

		
		//update_option ('lic_check_response_fail', TRUE);

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, esc_url_raw(SPP_STORE_URL) ), array( 'timeout' => 15, 'sslverify' => false ) );
	
		update_option ('lic_check_response_fail', $response);

		// make sure the response came back okay
		if ( is_wp_error( $response ) ) {
			return false;
		}

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "valid" or "invalid"

		update_option( 'sppress_ls', $license_data->license );

	}
}
add_action('admin_init', 'edd_sppress_activate_license');


/***********************************************
* Illustrates how to deactivate a license key.
* This will decrease the site count
***********************************************/

function edd_sppress_deactivate_license() {

	// listen for our activate button to be clicked
	if( isset( $_POST['edd_license_deactivate'] ) ) {

		// run a quick security check 
	 	if( ! check_admin_referer( 'edd_sppress_nonce', 'edd_sppress_nonce' ) ) 	
			return; // get out if we didn't click the Activate button

		// retrieve the license from the database
		$license = trim( get_option( 'edd_sppress_license_key' ) );
			

		// data to send in our API request
		$api_params = array( 
			'edd_action'=> 'deactivate_license', 
			'license' 	=> $license, 
			'item_name' => urlencode( SPP_ITEM_NAME ), // the name of our product in EDD
			'url'       => home_url()
		);
		

		// Call the custom API.
		$response = wp_remote_get( add_query_arg( $api_params, esc_url_raw(SPP_STORE_URL) ), array( 'timeout' => 15, 'sslverify' => false ) );

		// make sure the response came back okay
		if ( is_wp_error( $response ) )
			return false;

		// decode the license data
		$license_data = json_decode( wp_remote_retrieve_body( $response ) );
		
		// $license_data->license will be either "deactivated" or "failed"
		if( $license_data->license == 'deactivated' )
			delete_option( 'sppress_ls' );

	}
}
add_action('admin_init', 'edd_sppress_deactivate_license');


/************************************
* this illustrates how to check if 
* a license key is still valid
* the updater does this for you,
* so this is only needed if you
* want to do something custom
*************************************/

function edd_sppress_check_license() {

	global $wp_version;

	$license = trim( get_option( 'edd_sppress_license_key' ) );
		
	$api_params = array( 
		'edd_action' => 'check_license', 
		'license' => $license, 
		'item_name' => urlencode( SPP_ITEM_NAME ),
		'url'       => home_url()
		
	);

 

	// Call the custom API.
	$response = wp_remote_get( add_query_arg( $api_params, esc_url_raw(SPP_STORE_URL) ), array( 'timeout' => 15, 'sslverify' => false ) );


	if ( is_wp_error( $response ) )
		return false;

	$license_data = json_decode( wp_remote_retrieve_body( $response ) );

	if( $license_data->license == 'valid' ) {
		echo 'valid'; exit;
		// this license is still valid
	} else {
		echo 'invalid'; exit;
		// this license is no longer valid
	}
}