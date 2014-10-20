<?php

// If we are not deploying wordpress on a shared server
// Then remove Mojo Market Place and cleanup the Wordpress Config to remove
// Our Affliate ID

$hostname = php_uname('n');
$pattern = '/hostgator\.com$/';

if ( preg_match( $pattern, $hostname) ) {
	//print "[ !! ] Shared System Detected\n[ !! ] Process for Shared.\n";
        // Start Session and Load Wordpress Core
        // Thank you John South for making this part easy by way of sak-cli
        ob_start();
        if (file_exists("wp-load.php")) {
                 require_once("wp-load.php");
        } else {
                 require_once("wp-config.php");
        }
        require_once('wp-admin/includes/file.php');
        require_once('wp-admin/includes/misc.php');
        $output = ob_get_contents();
        ob_end_clean();
        // Clear the Output buffer and Load the Wordpress Plugin API
        require_once('wp-admin/includes/plugin.php');
        // Set array of plugins to remove and process them though the API
        $plugin_to_delete=array('mojo-marketplace/mojo-marketplace.php', 'mojo-marketplace-dedi/mojo-marketplace.php', 'mojo-marketplace-vps/mojo-marketplace.php');
        deactivate_plugins($plugin_to_delete,true);
        delete_plugins($plugin_to_delete);
        // Set array of plugins to activate
        $plugin='mojo-marketplace-hg/mojo-marketplace.php';
        activate_plugin($plugin,'mojo-marketplace-hg',false,true);
        wp_clean_plugins_cache();
} elseif ( preg_match( '/websitewelcome\.com/', $hostname) ) {
	//print "[ !! ] Shared System NOT Detected\n[ !! ] Process for Non-Brand.\n";
	// Start Session and Load Wordpress Core
	// Thank you John South for making this part easy by way of sak-cli
	ob_start();
	if (file_exists("wp-load.php")) {
		 require_once("wp-load.php");
	} else {
		 require_once("wp-config.php");
	}
	require_once('wp-admin/includes/file.php');
	require_once('wp-admin/includes/misc.php');
	$output = ob_get_contents();
	ob_end_clean();
	// Clear the Output buffer and Load the Wordpress Plugin API
	require_once('wp-admin/includes/plugin.php');
	// Set array of plugins to remove and process them though the API
	$plugin_to_delete=array('mojo-marketplace-hg/mojo-marketplace.php', 'mojo-marketplace-dedi/mojo-marketplace.php', 'mojo-marketplace-vps/mojo-marketplace.php');
	deactivate_plugins($plugin_to_delete,true);
	delete_plugins($plugin_to_delete);
        // Set array of plugins to activate
        $plugin='mojo-marketplace/mojo-marketplace.php';
        activate_plugin($plugin,'mojo-marketplace',false,true);
	wp_clean_plugins_cache();
} elseif (file_exists('/proc/user_beancounters'))  {
        ob_start();
        if (file_exists("wp-load.php")) {
                 require_once("wp-load.php");
        } else {
                 require_once("wp-config.php");
        }
        require_once('wp-admin/includes/file.php');
        require_once('wp-admin/includes/misc.php');
        $output = ob_get_contents();
        ob_end_clean();
        // Clear the Output buffer and Load the Wordpress Plugin API
        require_once('wp-admin/includes/plugin.php');
        // Set array of plugins to remove and process them though the API
        $plugin_to_delete=array('mojo-marketplace-hg/mojo-marketplace.php', 'mojo-marketplace-dedi/mojo-marketplace.php', 'mojo-marketplace/mojo-marketplace.php');
        deactivate_plugins($plugin_to_delete,true);
        delete_plugins($plugin_to_delete);
        // Set array of plugins to activate
        $plugin='mojo-marketplace-vps/mojo-marketplace.php';
        activate_plugin($plugin,'mojo-marketplace-vps',false,true);
        wp_clean_plugins_cache();
} else {
        ob_start();
        if (file_exists("wp-load.php")) {
                 require_once("wp-load.php");
        } else {
                 require_once("wp-config.php");
        }
        require_once('wp-admin/includes/file.php');
        require_once('wp-admin/includes/misc.php');
        $output = ob_get_contents();
        ob_end_clean();
        // Clear the Output buffer and Load the Wordpress Plugin API
        require_once('wp-admin/includes/plugin.php');
        // Set array of plugins to remove and process them though the API
        $plugin_to_delete=array('mojo-marketplace-hg/mojo-marketplace.php', 'mojo-marketplace/mojo-marketplace.php', 'mojo-marketplace-vps/mojo-marketplace.php');
        deactivate_plugins($plugin_to_delete,true);
        delete_plugins($plugin_to_delete);
        // Set array of plugins to activate
        $plugin='mojo-marketplace-dedi/mojo-marketplace.php';
        activate_plugin($plugin,'mojo-marketplace-dedi',false,true);
        wp_clean_plugins_cache();
}

?>
