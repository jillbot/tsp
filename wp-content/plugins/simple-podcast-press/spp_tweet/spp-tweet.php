<?php
/*************************************************************************************************************
file spp-tweet.php is a part of Simple Podcast Press and contains proprietary code - simplepodcastpress.com
*************************************************************************************************************/
// Check for existing class
if ( ! class_exists( 'spp_clicktotweet' ) ) {
/**
	 * Main Class
	 */
	class spp_clicktotweet  {

		/**
		 * Class constructor: initializes class variables and adds actions and filters.
		 */
		public function __construct() {
			$this->spp_clicktotweet();
			//add_shortcode( 'spp-tweet', array( $this, 'spp_clicktotweet' ) );
			add_shortcode( 'spp-tweet', array( $this, 'spp_clicktotweet_params' ) );
		}

		public function spp_clicktotweet_params($atts) {
			if ( isset ( $atts['tweet'] ) )
			{
            	
			global $post;
			global $wpdb;
			$handle_code = '';
			$spp_episode = '';
			$table_spp_links	=  $wpdb->prefix . "spp_links";

		    $handle = get_option('spp-twitter-handle');
		    if (!empty($handle)) {
		        $handle_code = "&via=".$handle."&related=".$handle;
		    }
		    
			$text = $atts['tweet'];
			
		    $short = $this->shorten($text, 100);
		    $tweetshort = $short . " - ";

			$url = get_site_url(); 
			

		 	$spp_slug	= $wpdb->get_row("SELECT spp_slug FROM " . $table_spp_links . " WHERE spp_post_id = '$post->ID'");

			if (isset($spp_slug))
			{
						
				$disable_url_shortner = get_option('disable_url_shortner');

				if ($disable_url_shortner)
						$url = wp_get_shortlink();
				else
					$url = $url . '/' . $spp_slug->spp_slug;
			}
			else
				$url = wp_get_shortlink();


		    return "<div class='spp-tweet-clear'></div><div class='spp-click-to-tweet'><div class='spp-ctt-text'><a href='https://twitter.com/share?text=".urlencode($short).$handle_code."&url=".$url."' target='_blank'>".$text."</a></div><a href='https://twitter.com/share?text=".urlencode($tweetshort)."".$handle_code."&url=".$url."' target='_blank' class='spp-ctt-btn'>Tweet This</a><div class='spp-ctt-tip'></div></div>";
			}

		}
			
		public function spp_clicktotweet() {			
			register_activation_hook( __FILE__, array( __CLASS__, 'activation' ) );
			register_deactivation_hook( __FILE__, array( __CLASS__, 'deactivation' ) );

			// Register global hooks
			$this->register_global_hooks();

		}

		/**
		 * Print the contents of an array
		 */
		public function debug($array) {
			echo '<pre>';
			print_r($array);
			echo '</pre>';
		}

		/**
		 * Handles activation tasks, such as registering the uninstall hook.
		 */
		public function activation() {
			register_uninstall_hook( __FILE__, array( __CLASS__, 'uninstall' ) );
		}

		/**
		 * Handles deactivation tasks, such as deleting plugin options.
		 */
		public function deactivation() {

		}

		/**
		 * Handles uninstallation tasks, such as deleting plugin options.
		 */
		public function uninstall() {
			delete_option('spp-twitter-handle');
		}

		/**
		 * Registers global hooks, these are added to both the admin and front-end.
		 */
		public function register_global_hooks() {
			if ( is_admin() ) {
				
				// Cache bust tinymce
				add_filter('tiny_mce_version', array($this, 'refresh_mce'));

				// Add button plugin to TinyMCE
				add_action('init', array($this, 'tinymce_button'));
			}
			
			else 
				add_filter('the_content', array($this, 'replace_tags'),1);
		}


		public function tinymce_button() {
			
			if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
				return;
			}

			if (get_user_option('rich_editing') == 'true') {
				add_filter('mce_external_plugins', array($this, 'tinymce_register_plugin'));
				add_filter('mce_buttons', array($this, 'tinymce_register_button'));
			}
			
		}

		public function tinymce_register_button($buttons) {
		   array_push($buttons, "|", "spptweet");
			array_push($buttons, "|", "clammrit");
		   array_push($buttons, "|", "sppplayer");
		   array_push($buttons, "|", "sppoptin");
		   array_push($buttons, "|", "spptranscript");
		   array_push($buttons, "|", "spptranscriptclose");
		   array_push($buttons, "|", "sppctabuttons");
		   array_push($buttons, "|", "spptimestamp");
		   array_push($buttons, "|", "sppepisodes");
		   array_push($buttons, "|", "sppreviews");
		   


		   return $buttons;
		}

		public function tinymce_register_plugin($plugin_array) {
		   $plugin_array['spptweet'] = plugins_url( '/assets/js/spptweet_plugin.js', __FILE__);
		   $plugin_array['clammrit'] = plugins_url( '/assets/js/clammrit_plugin.js', __FILE__);
		   $plugin_array['sppplayer'] = plugins_url( '/assets/js/sppplayer_plugin.js', __FILE__);
		   $plugin_array['sppoptin'] = plugins_url( '/assets/js/sppoptin_plugin.js', __FILE__);
		   $plugin_array['spptranscript'] = plugins_url( '/assets/js/spptranscript_plugin.js', __FILE__);
			$plugin_array['spptranscriptclose'] = plugins_url( '/assets/js/spptranscriptclose_plugin.js', __FILE__);
		   $plugin_array['sppctabuttons'] = plugins_url( '/assets/js/sppctabuttons_plugin.js', __FILE__);
		   $plugin_array['spptimestamp'] = plugins_url( '/assets/js/spptimestamp_plugin.js', __FILE__);
			$plugin_array['sppepisodes'] = plugins_url( '/assets/js/sppepisodes_plugin.js', __FILE__);
			$plugin_array['sppreviews'] = plugins_url( '/assets/js/sppreviews_plugin.js', __FILE__);

		   return $plugin_array;
		}

		/**
		 * Admin: Add settings link to plugin management page
		 */
		public function plugin_settings_link($actions, $file) {
			if(false !== strpos($file, 'spp-tweet-click-to-tweet')) {
				$actions['settings'] = '<a href="admin.php?page=spp-podcast-settings">Settings</a>';
			}
			return $actions;
		}

		
		/**
		 * Admin: Validate settings
		 */
		public function validate_settings($input) {
			return str_replace('@', '', strip_tags(stripslashes($input)));
		}

		
		/**
		 * Shorten text lenth to 100 characters.
		 */
		public function shorten($input, $length, $ellipses = true, $strip_html = true) {
		    if ($strip_html) {
		        $input = strip_tags($input);
		    }
		    if (strlen($input) <= $length) {
		        return $input;
		    }
		    $last_space = strrpos(substr($input, 0, $length), ' ');
		    $trimmed_text = substr($input, 0, $last_space);
		    if ($ellipses) {
		        $trimmed_text .= '...';
		    }
		    return $trimmed_text;
		}

		/**
		 * Replacement of Tweet tags with the correct HTML
		 */
		public function tweet($matches) {

			global $post;
			global $wpdb;
			$handle_code = '';
			$spp_episode = '';
			$table_spp_links	=  $wpdb->prefix . "spp_links";

		    $handle = get_option('spp-twitter-handle');
		    if (!empty($handle)) {
		        $handle_code = "&via=".$handle."&related=".$handle;
		    }
		    
			$text = $matches[1];
						
		    $short = $this->shorten($text, 100);
		    $tweetshort = $short . " - ";

			$url = get_site_url(); 
			

		 	$spp_slug	= $wpdb->get_row("SELECT spp_slug FROM " . $table_spp_links . " WHERE spp_post_id = '$post->ID'");

			if (isset($spp_slug))
			{
						
				$disable_url_shortner = get_option('disable_url_shortner');

				if ($disable_url_shortner)
						$url = wp_get_shortlink();
				else
					$url = $url . '/' . $spp_slug->spp_slug;
			}
			else
				$url = wp_get_shortlink();


		    return "<div class='spp-tweet-clear'></div><div class='spp-click-to-tweet'><div class='spp-ctt-text'><a href='https://twitter.com/share?text=".urlencode($short).$handle_code."&url=".$url."' target='_blank'>".$text."</a></div><a href='https://twitter.com/share?text=".urlencode($tweetshort)."".$handle_code."&url=".$url."' target='_blank' class='spp-ctt-btn'>Tweet This</a><div class='spp-ctt-tip'></div></div>";
		}

		/**
		 * Replacement of Tweet tags with the correct HTML for a rss feed
		 */
		public function tweet_feed($matches) {
		    $handle = get_option('spp-twitter-handle');
		    if (!empty($handle)) {
		        $handle_code = "&via=".$handle."&related=".$handle;
		    }
		    $text = $matches[1];
		    $short = $this->shorten($text, 100);
		    $tweetshort = $short . " - ";
		    return "<hr /><p><em>".$short."</em><br /><a href='https://twitter.com/share?text=".urlencode($tweetshort).$handle_code."&url=".wp_get_shortlink()."' target='_blank'>Tweet This</a></p><hr />";
		}

		/**
		 * Regular expression to locate tweet tags
		 */
		public function replace_tags($content) {
			if (!is_feed()) {
				$content = preg_replace_callback("/\[spp-tweet \"(.*?)\"]/i", array($this, 'tweet'), $content);
			} else {
				$content = preg_replace_callback("/\[tweet \"(.*?)\"]/i", array($this, 'tweet_feed'), $content);
			}
			return $content;
		}

		/**
		 * Cache bust tinymce
		 */
		public function refresh_mce($ver) {
			$ver += 3;
			return $ver;
		}
	} // End spp_clicktotweet class

	// Init Class
	new spp_clicktotweet();

}

?>