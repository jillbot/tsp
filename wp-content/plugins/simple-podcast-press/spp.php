<?php
/*************************************************************************************************************
file spp.php is a part of Simple Podcast Press and contains proprietary code - simplepodcastpress.com
*************************************************************************************************************/
global $spp_db_version;
$spp_db_version = "1.1";

class wp_simplepodcastpress{
      //	Define constructor
      
      function wp_simplepodcastpress(){
			
            
            define( 'SPPRESS_PLUGIN_URL', WP_PLUGIN_URL . '/simple-podcast-press');
			@ini_set('max_execution_time', 300);
			//define('WP_MEMORY_LIMIT', '64M');
			$dir = plugin_dir_path( __FILE__ );
			define( 'SPPRESS_PLUGIN_PATH',  $dir);
             

                        
            if ( is_admin() ) {    
            
                  add_action('admin_menu',array($this,'spp_admin_menu'));
                  add_action("wp_ajax_save_spp_settings", array( $this, "spp_save_podcast_settings" ));
                  add_action("wp_ajax_spp_url_shortner", array( $this, "spp_url_shortner_func" ));
                  add_action( 'admin_enqueue_scripts', array( $this, 'register_spp_admin_scripts' ) );
                  add_action( "add_meta_boxes", array( $this, "spp_metaboxes" ) );
                  add_action( 'save_post',  array( $this, "spp_metabox_save" ) );
                  // Actions to take when plugin is updated
                  add_action( 'admin_init', array( $this, 'spp_plugin_update'), 1 );
                  add_action('draft_to_publish', array($this,'preserve_draft_date'), 10, 1);
                  add_action('draft_to_private', array($this,'preserve_draft_date'), 10, 1);
			      add_action('draft_to_pending', array($this,'preserve_draft_date'), 10, 1);
                  add_action('wp_dashboard_setup', array($this,'reviews_dashboard_widgets'));
                  add_action( 'publish_post', array($this, 'manual_spp_action'), 10, 1 ); 
			      add_action( 'save_post', array($this, 'manual_spp_action'), 1, 1 ); 
                  
                  
                  $disable_url_shortner = get_option('disable_url_shortner');
                  if (!$disable_url_shortner)
                        add_action( 'save_post',  array( $this, "spp_link_metabox_save" ) );
            }
              
            else {

                  // Add shortcode support in widgets
                  add_filter('widget_text', 'do_shortcode', 11);
                  
                  if (!$disable_url_shortner)
                        add_action('init', array($this,'spp_redirect')); // Redirect
                  
                  // Force player on home page
                  $spp_force_player_home = get_option('spp_force_player_home');
                  if ($spp_force_player_home)
                        add_filter('the_excerpt', array($this,'spp_the_content'));
                  
                  
                  add_filter('the_content', array($this, 'spp_the_content'));
			      add_filter( 'wp_audio_shortcode_override', array($this,'spp_wp_audio_override'), 10, 4 );
                  add_action( "wp_head", array( $this, "spp_open_graph" ),1,1 );

            }
            
            add_action('simplepodcastpress_reviews_fetch',array($this,'spp_save_reviews'));

            // Set cron regardless since we dont know what type of feed it is at this point
            add_action('simplepodcastpress_fetch',array($this,'generate_post_with_cron'));
                
            if( !wp_next_scheduled( 'simplepodcastpress_fetch' ) ) {
			    wp_schedule_event( time() + 60, 'hourly', 'simplepodcastpress_fetch' ); 
			}
			     
            if( !wp_next_scheduled( 'simplepodcastpress_reviews_fetch' ) ) {
            wp_schedule_event( time(), 'daily', 'simplepodcastpress_reviews_fetch' ); 
			}
              
            require_once( "updater/spp-update.php" );
            require_once("draftnotify/draft-notify.php");
			require_once("spp_tweet/spp-tweet.php");
			require_once("widget/spp-widget.php");
			require_once ("responsive_audio_player/responsive-audio-player.php");
			require_once ("spp_reviews/spp-reviews.php");

		}//	End of defining constructor
  
              
              
function get_excerpt_by_id($post_id){
      $the_post = get_post($post_id);
      $postcontent = strip_shortcodes($the_post->post_content);
      $postcontent = str_replace("&nbsp;","", $postcontent);
      $postcontent = preg_replace("/[\r\n]+/", "\n", $postcontent);
	  $postcontent = preg_replace("/\s+/", ' ', $postcontent);
      $postcontent = html_entity_decode(strip_tags($postcontent));
      $postcontent = substr(esc_attr($postcontent), 0, 500);
      return $postcontent;
}
      
      
function spp_open_graph(){

      $disable_opengraph = get_option('disable_opengraph');
 
      if (!$disable_opengraph AND is_single()) {
          $post_id = get_the_ID();
          $sppogp = get_post_meta($post_id, 'OGP', true);
          $sppogpImage = $sppogp["image"];
          $sppogpDesc = $this->get_excerpt_by_id( $post_id );
            
          print( PHP_EOL.PHP_EOL."<!-- Simple Podcast Press Open Graph Meta -->".PHP_EOL );
          print( "<meta property='og:url' content='".get_permalink( $post_id)."'/>".PHP_EOL );
          print( "<meta property='og:site_name' content='".get_bloginfo("site_name")."'/>".PHP_EOL );
          print( "<meta property='og:type' content='website' />".PHP_EOL );
          print( "<meta property='og:title' content='".get_the_title( $post_id )."'/>".PHP_EOL );
          print( "<meta property='og:description' content='".$sppogpDesc."'/>".PHP_EOL );
          print( "<meta property='og:image' content='".$sppogpImage."'/>".PHP_EOL );
          print( "<meta property='og:image:type' content='image/jpeg' />".PHP_EOL );
          print( "<!-- END of Simple Podcast Press Open Graph Meta -->".PHP_EOL.PHP_EOL );
      }
}

 

      
function spp_wp_audio_override( $return = '', $attr, $content, $instances ) 
{
      
      global $post;
      $MetaData = get_post_meta($post->ID, 'enclosure', true);
      if (!empty($MetaData))
         return;
             
      $duration = unserialize($MetaParts[3]);
      $duration = $duration['duration'];  
      
      $SPP_with_pp = get_option('replace_pp_with_spp');
       $SPP_exclude_wp = get_option('replace_wp_with_spp');  
       if ( ($SPP_with_pp == 0) || (($SPP_with_pp == 1) && ($SPP_exclude_wp == 1)) )
             return $content;
       else          
       {

             
             $spp_autoplay_podcast = get_option('spp_autoplay_podcast');
		global $post;
        if ($spp_autoplay_podcast)
            $spp_autoplay = 'autoplay';
        else
            $spp_autoplay = '';
		$container_width  = 'max-width:' . $container_width . 'px';
        $mp3 = $attr['src'];
	 	$mp3 = '<source src="' . $mp3  .'" />';
        if ($duration)
            $duration = '('.$duration.')';
            
        
        $spp_pre_roll_checkbox = get_option('spp_pre_roll_checkbox');
        $spp_pre_roll_url = get_option('spp_pre_roll_url');
       
        if ($spp_pre_roll_checkbox)
              $spp_preroll = "preroll=" . $spp_pre_roll_url;
        else
              $spp_preroll = '';
       
        
             
        $spp_remove_timecode = get_option('spp_remove_timecode');
        $spp_listen_text = get_option('spp_listen_text');
        if ($spp_remove_timecode OR !$spp_listen_text)
              $duration = '';
             
        $listen_text = get_option('spp_listen_text');
        $listen_text = '<div><b>'.$listen_text.' '. $duration.' </b></div>';

        $html .= '<div class="player_container">'.$listen_text.'
		<div><audio class="sppaudioplayer" controls preload="none"' . $spp_preroll . $spp_autoplay .'>'. $mp3 .'</audio></div>';
             
		$btn_ClammrIT_checkbox = get_option('btn_ClammrIT_checkbox'); 
        $itunes_url = get_option('btn_itunes_url');
        if (empty($itunes_url) )
            $itunes_url = get_option('itunes_url');
		$btn_spplisten = get_option('btn_spplisten');
        $btn_spprss = get_option('btn_spprss');
        $btn_sppreview = get_option('btn_sppreview');
        $btn_sppandroid = get_option('btn_sppandroid');
        $btn_download = get_option('btn_download');             
		$btn_itunes = get_option('btn_itunes');
		$btn_stiticher = get_option('btn_stiticher');
		$btn_soundcloud = get_option('btn_soundcloud');
		$btn_stiticher_url = get_option('btn_stiticher_url');
		$btn_soundcloud_url = get_option('btn_soundcloud_url');
		$btn_spp_custom1 = get_option('btn_spp_custom1');
		$btn_spp_custom2 = get_option('btn_spp_custom2');
		$btn_spp_custom3 = get_option('btn_spp_custom3');
        $btn_spp_custom4 = get_option('btn_spp_custom4');
		$btn_spp_custom5 = get_option('btn_spp_custom5');
		$btn_spp_custom6 = get_option('btn_spp_custom6');
        $spp_LeadBox_btn_code = '';
		$btn_sppleadbox_checkbox = get_option('spp_LeadBox_btn_checkbox');
		if ($btn_sppleadbox_checkbox) {
			$spp_LeadBox_btn_code = get_option('spp_LeadBox_btn_code');
			$spp_LeadBox_btn_code = htmlspecialchars_decode($spp_LeadBox_btn_code, ENT_QUOTES) ;
			$spp_LeadBox_btn_code = str_replace('<a','<a class="spp-button-leadbox"', $spp_LeadBox_btn_code);
		}
            
        if ( has_post_thumbnail() ) {
              $channel_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        }
        else{
              $channel_image =  get_option('channel_image');
        }
        
        $link = get_permalink($post->ID);  
        $posttitle = htmlspecialchars(rawurlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
        
            
        $postcontent = $post->post_content;
        $postcontent = $link . ' - ' . strip_shortcodes($postcontent);
        $postcontent = str_replace("&nbsp;","", $postcontent);
        $postcontent = preg_replace("/[\r\n]+/", "\n", $postcontent);
		$postcontent = preg_replace("/\s+/", ' ', $postcontent);
		$postcontent = html_entity_decode(strip_tags($postcontent));
        $postcontent = substr($postcontent,0,540).' ...';
        $postcontent = rawurlencode($postcontent);
             
             
             
             
        if (($btn_download == 0) AND ($btn_itunes == 0) AND ($btn_stiticher == 0) AND ($btn_soundcloud == 0) AND ($btn_spplisten == 0) AND ($btn_spprss == 0) AND ($btn_sppreview == 0) AND ($btn_sppandroid == 0)AND ($btn_spp_custom1 == 0) AND ($btn_spp_custom2 == 0) AND ($btn_spp_custom3 == 0) AND ($btn_spp_custom4 == 0) AND ($btn_spp_custom5 == 0) AND ($btn_spp_custom6 == 0))
            $allbtn_onoff = 'display:none !important;';
        else
            $allbtn_onoff = '';
        
        // spp_wp_audio_override
        $DownloadText = 'Download';
        $iTunesText = 'iTunes';
        $StitcherText = 'Stitcher';
        $SoundCloudText = 'SoundCloud';
        $ListenText = 'Listen in a New Window';
        $ReviewText = 'Leave a Review';
        $RSSText = 'Subscribe via RSS';
        $AndroidText = 'Subscribe on Android';
            
        $btn_stiticher =($btn_stiticher == 0) ? 'display:none !important;' : '';
        $btn_download =($btn_download == 0) ? 'display:none !important;' : '';
        $btn_itunes =($btn_itunes == 0) ? 'display:none !important;' : '';
        $btn_soundcloud =($btn_soundcloud == 0) ? 'display:none !important;' : '';
        $btn_spplisten =($btn_spplisten == 0) ? 'display:none !important;' : '';
        $btn_sppreview =($btn_sppreview == 0) ? 'display:none !important;' : '';
        $btn_ClammrIT_checkbox =($btn_ClammrIT_checkbox == 0) ? 'display:none !important;' : '';
        $btn_spprss =($btn_spprss == 0) ? 'display:none !important;' : '';
        $btn_sppandroid =($btn_sppandroid == 0) ? 'display:none !important;' : '';
             
		$btn_spp_custom1_display =($btn_spp_custom1 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom2_display =($btn_spp_custom2 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom3_display =($btn_spp_custom3 == 0) ? 'display:none !important;' : '';
        $btn_spp_custom4_display =($btn_spp_custom4 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom5_display =($btn_spp_custom5 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom6_display =($btn_spp_custom6 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom_name1 = get_option('btn_spp_custom_name1');
		$btn_spp_custom_name2 = get_option('btn_spp_custom_name2');
		$btn_spp_custom_name3 = get_option('btn_spp_custom_name3');
        $btn_spp_custom_name4 = get_option('btn_spp_custom_name4');
		$btn_spp_custom_name5 = get_option('btn_spp_custom_name5');
		$btn_spp_custom_name6 = get_option('btn_spp_custom_name6');
		$btn_spp_custom_url1 = get_option('btn_spp_custom_url1');
		$btn_spp_custom_url2 = get_option('btn_spp_custom_url2');
		$btn_spp_custom_url3 = get_option('btn_spp_custom_url3');
        $btn_spp_custom_url4 = get_option('btn_spp_custom_url4');
		$btn_spp_custom_url5 = get_option('btn_spp_custom_url5');
		$btn_spp_custom_url6 = get_option('btn_spp_custom_url6');
        
		$audio_file =  $attr['src'];
		$direct_download_button = get_option('direct_download_button');
         if ($direct_download_button) {
            $audiodownloadurl = SPPRESS_PLUGIN_URL . '/responsive_audio_player/downloadaudio.php?file=' . $audio_file;
            $spp_download_target = '';
         }
         else {
            $audiodownloadurl = $audio_file;
            $spp_download_target = '_blank';
         }
        
         $itunes_ID = get_option('itunes_id');
         $rss_feed = get_option('podcast_url');
             
         $btn_sppreview_url = 'http://getpodcast.reviews/id/'.$itunes_ID;
         $btn_spprss_url = $rss_feed;
		 $android_rss_feed = parse_url($rss_feed);  
         $btn_sppandroid_url = 'http://subscribeonandroid.com/'.$android_rss_feed['host'].$android_rss_feed['path'];
             
		$html .= <<<HTML
<div class="sppbuttons" style="$allbtn_onoff">
				<a class="button-download" target="$spp_download_target" style="$btn_download" href="$audiodownloadurl">$DownloadText</a>
				<a class="button-spplisten" style="$btn_spplisten" href="javascript:void(0);" onclick="window.open('$audio_file', '', 'width=300, height=200');">$ListenText</a>
				<a class="button-itunes" target="_blank" style="$btn_itunes" href="$itunes_url">$iTunesText</a>
				<a class="button-stitcher" target="_blank" style="$btn_stiticher" href="$btn_stiticher_url">$StitcherText</a>
				<a class="button-soundcloud" target="_blank" style="$btn_soundcloud" href="$btn_soundcloud_url">$SoundCloudText</a>
                <a class="button-sppreview" target="_blank" style="$btn_sppreview" href="$btn_sppreview_url">$ReviewText</a>
                <a class="button-clammr" href="javascript:sppClammrIt_$post->ID();"  style="$btn_ClammrIT_checkbox">Clammr It</a>
				<a class="button-spprss" target="_blank" style="$btn_spprss" href="$btn_spprss_url">$RSSText</a>		
				<a class="button-sppandroid" target="_blank" style="$btn_sppandroid" href="$btn_sppandroid_url">$AndroidText</a>	
                <a class="spp-button-custom1" target="_blank" style="$btn_spp_custom1_display" href="$btn_spp_custom_url1">$btn_spp_custom_name1</a>
				<a class="spp-button-custom2" target="_blank" style="$btn_spp_custom2_display" href="$btn_spp_custom_url2">$btn_spp_custom_name2</a>
				<a class="spp-button-custom3" target="_blank" style="$btn_spp_custom3_display" href="$btn_spp_custom_url3">$btn_spp_custom_name3</a>
				<a class="spp-button-custom4" target="_blank" style="$btn_spp_custom4_display" href="$btn_spp_custom_url4">$btn_spp_custom_name4</a>
				<a class="spp-button-custom5" target="_blank" style="$btn_spp_custom5_display" href="$btn_spp_custom_url5">$btn_spp_custom_name5</a>
				<a class="spp-button-custom6" target="_blank" style="$btn_spp_custom6_display" href="$btn_spp_custom_url6">$btn_spp_custom_name6</a>
                $spp_LeadBox_btn_code
			</div>


<script type="text/javascript">
function sppClammrIt_$post->ID() {
    var sppCurrentTime = document.getElementsByClassName("audioplayer-time audioplayer-time-current");
    var sppCurStartTime = sppCurrentTime.item(0).innerHTML;
    var sppReferralName = 'SimplePodcastPress';
    
    var p = sppCurStartTime.split(':'),
        s = 0, m = 1;

    while (p.length > 0) {
        s += m * parseInt(p.pop(), 10);
        m *= 60;
    }

   var sppCurStartTimeMs = s * 1000;
   var sppCurEndTimeMs = sppCurStartTimeMs + 18000;

var clammrUrlEncoded = "http://www.clammr.com/app/clammr/crop";
clammrUrlEncoded += "?audioUrl=" + encodeURIComponent("$audio_file");
clammrUrlEncoded += "&imageUrl=" + encodeURIComponent("$channel_image");
clammrUrlEncoded += "&audioStartTime=" + encodeURIComponent(sppCurStartTimeMs);
clammrUrlEncoded += "&audioEndTime=" + encodeURIComponent(sppCurEndTimeMs);
clammrUrlEncoded += "&title=" + "$posttitle";
clammrUrlEncoded += "&description=" + "$postcontent";
clammrUrlEncoded += "&referralName=" + encodeURIComponent("SimplePodcastPress");
       
  jQuery('.sppaudioplayer').trigger("pause");
                       
    window.open(clammrUrlEncoded, 'cropPlugin', 'width=1000, height=750, top=50, left=200');
}
</script>

HTML;

  	$spp_auto_resp_url_get = get_option('spp_auto_resp_url');
    $spp_auto_resp_heading_get = get_option('spp_auto_resp_heading');
    $spp_auto_resp_sub_heading_get = get_option('spp_auto_resp_sub_heading');
    $spp_auto_resp_hidden_get = get_option('spp_auto_resp_hidden');
    $spp_auto_resp_name_get = get_option('spp_auto_resp_name');
    $spp_auto_resp_email_get = get_option('spp_auto_resp_email');
    $spp_auto_resp_email_submitt = get_option('spp_auto_resp_submitt');
    $spp_optin_box = get_option('spp_optin_box');
	$spp_two_step_optin = get_option('spp_two_step_optin');
					 switch ( $spp_two_step_optin ) {
						 case 1 :
								$hide_first_name = '';
						 break;
						 case 2 :
								$hide_first_name = 'display:none !important;';
						 break;
						 case 3 :
								$hide_first_name = 'display:none !important;';
								$hide_email = 'display:none !important;';
						 break;
						 case 4 :
								$hide_first_name = 'display:none !important;';
								$hide_email = 'display:none !important;';
								$hide_first_name_two_step = 'display:none !important;';
						 break;
					}
    if ($spp_optin_box == 1){
         $html .= '<div id="spp-box-below-video" class="spp-optin-box">
				<div class="spp-optin-box-padding">
				<div class="spp-optin-box-content">
				<div class="spp-optin-box-headline">' . stripslashes($spp_auto_resp_heading_get) .'</div>
				<div class="spp-optin-box-subheadline">' . stripslashes($spp_auto_resp_sub_heading_get) . '</div>
				<div class="spp-optin-box-form-wrap">
				<form accept-charset="utf-8" action="'. $spp_auto_resp_url_get .'" method="post" target="_blank">
				'. htmlspecialchars_decode($spp_auto_resp_hidden_get, ENT_QUOTES) . '
				<div class="spp-optin-box-field" style="'.$hide_first_name.'">
				 <input placeholder="First Name" type="text" name="'. $spp_auto_resp_name_get .'"></div>
				<div class="spp-optin-box-field" style="'.$hide_email.'">
				 <input placeholder="Email" type="text" name="'. $spp_auto_resp_email_get .'"></div>';
				if ($spp_two_step_optin == 3 or  $spp_two_step_optin == 4){	
					$html .= '<a class="spp-optin-box-submit" data-reveal-id="spp-two-step-optin"  href="#">'. stripslashes($spp_auto_resp_email_submitt).'</a>';
				}else{
					$html .= '<div class="spp-optin-box-field-submit"><input type="submit" name="submit" class="spp-optin-box-submit" value=" ' . stripslashes($spp_auto_resp_email_submitt) . '"></div>';					
				}
			$html .= '
				</form>
				</div>
				</div>
				</div>
				</div>
                ';			
				
								
						
        }
            
    //Powered by
    $disablePoweredBy = get_option('spp_disable_poweredby');
    $refUrl = get_option('spp_poweredby_url');
    
    if ($refUrl)
        $refUrl = "/?ref=".$refUrl;
    else
        $refUrl = "";
    
    if (!$disablePoweredBy) {
            $html .= '
            <div style="font-size:12px;"><center>Powered by the <a target="_blank" href="http://simplepodcastpress.com'.$refUrl.'">Simple Podcast Press</a> Player</center></div>
            ';
        }
    
    // Closing Div
    $html .= '</div>';
	
               return $html;
       }
}
function spp_get_links() {
    global $wpdb;
	$tablespplinks = $wpdb->prefix . "spp_links";
    $spp_links = $wpdb->get_results("SELECT * FROM {$tablespplinks} ORDER BY spp_slug ASC");
    return $spp_links;
}

function spp_get_link($spp_id) {
    global $wpdb;
	$tablespplinks = $wpdb->prefix . "spp_links";
    $the_link = $wpdb->get_results("SELECT * FROM {$tablespplinks} WHERE spp_id='".$spp_id."'");
    if(!empty($the_link[0])) {
        return $the_link[0];
    }
    return;
}
function spp_links_meta_box() {
    global $edit_spp_link;
?>
    <p>Post Name: <input type="text" name="spp_name" value="<?php if(isset($edit_spp_link)) echo $edit_spp_link->spp_name;?>" /></p>
    <p>Post Url: <input type="text" name="spp_url" value="<?php if(isset($edit_spp_link)) echo $edit_spp_link->spp_url;?>" /></p>
    <p>Episode Number: <input type="text" name="spp_slug" value="<?php if(isset($edit_spp_link)) echo $edit_spp_link->spp_slug;?>" /></p>
    <p>Post ID: <input type="text" name="spp_post_id" value="<?php if(isset($edit_spp_link)) echo $edit_spp_link->spp_post_id;?>" /</p>
<?php
}
function spp_links(){
    global $wpdb;
	$tablespplinks = $wpdb->prefix . "spp_links";
 
    if(isset($_GET['delete'])) {
        $_GET['delete'] = absint($_GET['delete']);
        $wpdb->query("DELETE FROM {$tablespplinks} WHERE spp_id='" .$_GET['delete']."'");
    }
    
    if(isset($_POST['spp_add_link']) and isset($_POST['spp_name']) and isset($_POST['spp_url']) and isset($_POST['spp_slug']) and isset($_POST['spp_post_id']) ) {   
        
        $spp_name = $_POST['spp_name'];
        $spp_url = $_POST['spp_url'];
        $spp_slug = $_POST['spp_slug'];
        $spp_post_id = $_POST['spp_post_id'];
        if(empty($_POST['spp_id'])) {
            $wpdb->query("INSERT INTO {$tablespplinks} (spp_name,spp_url,spp_slug,spp_post_id) VALUES('" .$spp_name ."','" .$spp_url."','" .$spp_slug."','" .$spp_post_id ."');");
        } else {
       
            $spp_id = $_POST['spp_id'];
            $wpdb->query("UPDATE {$tablespplinks} SET spp_name='" .$spp_name ."', spp_url='" .$spp_url ."', spp_slug='" .$spp_slug ."', spp_post_id='" .$spp_post_id ."' WHERE spp_id='" .$spp_id ."'");
			$admin_url = get_admin_url() .'admin.php?page=spp-url-shortner';
        }
    }  
}
function spp_add_link(){
    $spp_id =0;
    if($_GET['spp_id']) $spp_id = $_GET['spp_id'];
    
    global $edit_spp_link;
    if ($spp_id) $edit_spp_link = $this->spp_get_link($spp_id);  
    
    add_meta_box('spp-links-meta', __('SPP Links'), array($this,'spp_links_meta_box'), 'bor', 'normal', 'core' );
?>
    <div class="wrap">
      <div id="faq-wrapper">
        <form method="post" action="">
          <h2>
          <?php if( $spp_id == 0 ) {
                $tf_title = __('Create New Shortened URL');
          }else {
                $tf_title = __('Update Shortened URL');
          }
          echo $tf_title;
          ?>
          </h2>
          <div id="poststuff" class="metabox-holder">
            <?php do_meta_boxes('bor', 'normal','low'); ?>
          </div>
          <input type="hidden" name="spp_id" value="<?php echo $spp_id; ?>" />
          <input type="submit" value="<?php echo $tf_title;?>" name="spp_add_link" id="spp_add_link" class="button-secondary">
        </form>
      </div>
    </div>
<?php
}
function spp_manage_links(){
?>
<div class="wrap">
  <div class="icon32" id="icon-edit"><br></div>
  <form method="post" action="" id="spp_form_action">
    <p>
        <select name="spp_action">
            <option value="actions"><?php _e('Actions')?></option>
            <option value="delete"><?php _e('Delete')?></option>
      </select>
      <input type="submit" name="spp_form_action_changes" class="button-secondary" value="<?php _e('Apply')?>" />
        <input type="button" class="button-secondary" value="<?php _e('Add new shortened link')?>" onclick="window.location='?page=spp-url-shortner&amp;edit=true'" />
    </p>
    <table class="widefat page fixed" cellpadding="0">
      <thead>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
          <th class="manage-column"><?php _e('Post Name')?></th>
          <th class="manage-column"><?php _e('Post Url')?></th>
          <th class="manage-column"><?php _e('Episode Number')?></th>
          <th class="manage-column"><?php _e('Post ID')?></th>
        </tr>
      </thead>
      <tfoot>
        <tr>
        <th id="cb" class="manage-column column-cb check-column" style="" scope="col">
          <input type="checkbox"/>
        </th>
 	  <th class="manage-column"><?php _e('Post Name')?></th>
          <th class="manage-column"><?php _e('Post Url')?></th>
          <th class="manage-column"><?php _e('Episode Number')?></th>
          <th class="manage-column"><?php _e('Post ID')?></th>
        </tr>
      </tfoot>
      <tbody>
        <?php
          $table = $this->spp_get_links();
          if($table){
           $i=0;
           foreach($table as $link) {
               $i++;
        ?>
      <tr class="<?php echo (ceil($i/2) == ($i/2)) ? "" : "alternate"; ?>">
        <th class="check-column" scope="row">
          <input type="checkbox" value="<?php echo $link->spp_id; ?>" name="spp_id[]" />
        </th>
          <td>
          <strong><?php echo $link->spp_name; ?></strong>
          <div class="row-actions-visible">
          <span class="edit"><a href="?page=spp-url-shortner&amp;spp_id=<?php echo $link->spp_id; ?>&amp;edit=true">Edit</a> | </span>
          <span class="delete"><a href="?page=spp-url-shortner&amp;delete=<?php echo $link->spp_id; ?>" onclick="return confirm('Are you sure you want to delete this link?');">Delete</a></span>
          </div>
          </td>
          <td><?php echo $link->spp_url; ?></td>
          <td><?php echo $link->spp_slug; ?></td>
          <td><?php echo $link->spp_post_id; ?></td>
        </tr>
        <?php
           }
        }
        else{  
      ?>
        <tr><td colspan="4"><?php _e('There are no data.')?></td></tr>  
        <?php
      }
        ?>  
      </tbody>
    </table>
    <p>
        <select name="spp_action-2">
            <option value="actions"><?php _e('Actions')?></option>
            <option value="delete"><?php _e('Delete')?></option>
        </select>
        <input type="submit" name="spp_form_action_changes-2" class="button-secondary" value="<?php _e('Apply')?>" />
        <input type="button" class="button-secondary" value="<?php _e('Add a new link')?>" onclick="window.location='?page=spp-url-shortner&amp;edit=true'" />
    </p>
  </form>
</div>
<?php
}
function spp_url_shortner_func(){

	$nonce = $_POST['wpnonce_urlshortner']; 
	if ( ! wp_verify_nonce( $nonce, 'urlshortner_settings' ) ) {
	 
		die( 'Security check' ); 
	} else {
	
	
	global $wpdb;
	$tablespplinks = $wpdb->prefix . "spp_links";
	$tableposts = $wpdb->prefix . "posts";
	$results = $wpdb->get_results("SELECT * FROM {$tablespplinks} ORDER BY `spp_post_id`");
	
	foreach ($results as $result){
	
		$spp_post_id = $result->spp_post_id; 
		$check_post_exists = $wpdb->query("SELECT * FROM {$tableposts} WHERE ID = {$spp_post_id}");
		if (!$check_post_exists){
		$delete_record = $wpdb->query("DELETE FROM {$tablespplinks} WHERE spp_post_id = {$spp_post_id}");
		}
		$spp_slug = $result->spp_slug; 
			$results_slug = $wpdb->get_results("SELECT * FROM {$tablespplinks} WHERE spp_slug = '".$spp_slug."' ORDER BY `spp_post_id`");
		$records_count = count($results_slug);
	
		if($records_count > 1)
		{
		$counter = 1;
			foreach($results_slug as $slug_record)
			{
				$spp_post_id = $slug_record->spp_post_id; 
					$check_record = $wpdb->get_row("SELECT * FROM {$tableposts} WHERE ID = {$spp_post_id}");
					if($check_record->post_status != 'publish' or $counter > 1)
					{
						$delete_record = $wpdb->query("DELETE FROM {$tablespplinks} WHERE spp_post_id = {$spp_post_id}");
					}else{
				
					$counter++;
					}
			}
		}
	
	}//end foreach
	update_option('spp_links_table_fixed', 1);
    echo 'done';
 }//end if nonce check
}//end function
      
      
function content($limit,$content) {
		 $content = explode(' ', $content, $limit);
		 if (count($content)>=$limit) {
		 array_pop($content);
		 $content = implode(" ",$content).'...';
		 } else {
		 $content = implode(" ",$content);
		 }
		 $content = preg_replace('/[.+]/','', $content);
		 $content = str_replace(']]>', ']]&gt;', $content);
		 return $content;
}
      
function spp_the_content($content){
$html = '';
$hide_email = '';
$duration = '';
      

    // Problem: If the_excerpt is used instead of the_content, both the_exerpt and the_content will be called here.
	// Important to note, get_the_excerpt will be called before the_content is called, so we add a simple little hack
    $hide_player_from_excerpt = get_option('spp_hide_player_from_excerpt');
    $spp_disable_spp_player_script = get_option('spp_disable_spp_player_script');
    

    //Assume we are showing the player
    $spp_disable_all_players = get_option('spp_disable_all_players');
    $spp_force_player_home = get_option('spp_force_player_home');
    $spp_insert_feat_image	= get_option('spp_insert_feat_image');
    $spp_player_over_image = get_option('spp_player_over_image');
    
	$show_player = true;

    if ( ($hide_player_from_excerpt) || ($spp_disable_spp_player_script) ) {
        //If on post page and not home, blog, or archive page then show player
        if( is_single() && is_main_query() ) { 
            $show_player = true;
        }
        else {
            $show_player = false;
        }
    }
      
      
      if ($spp_force_player_home)
            $show_player = true;

      
    if ($spp_disable_all_players)
	{
          $show_player = false;
    }
    
    $isLicenseValid = get_option('sppress_ls');
        
    if ($isLicenseValid !== 'valid') 
    {
        return $content; 
    }
 
	
   //check if shortcode already on there or not, if yes then ...
	if (preg_match_all('/(.?)\[(spp-player)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', $content, $matches) OR preg_match_all('/(.?)\[(powerpress)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', $content, $matches) OR preg_match_all('/(.?)\[(smart_track_player)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', $content, $matches) OR preg_match_all('/(.?)\[(display_podcast)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', $content, $matches)  )
	{
    
		$SPP_with_pp = get_option('replace_pp_with_spp');
        
	
        // Strip out the shortcode before displaying if player is off
	    if ($show_player == false){
            $content = preg_replace('/\[powerpress.*?\]/', '', $content);
            $content = preg_replace('/\[spp-player.*?\]/', '', $content);

	        return $content;
        }
              
        // Only if Replace PowerPress with SimplePodcastPress Player option is set
	    elseif ($SPP_with_pp == 1){
			
            //This avoids replacing the [powerpress_playlist] shortcode
            $content = str_replace("[powerpress]","[spp-player]",$content);
            $content = str_replace("[powerpress ","[spp-player ",$content);
            $content = str_replace("[display_podcast]","[spp-player]",$content);
      
              
            $SPP_exclude_stp = get_option('replace_stp_with_spp'); 
            if (!$SPP_exclude_stp)
                  $content =  str_replace("[smart_track_player ","[spp-player ",$content);
            
	        return $content;
		}
        
        else{
              return $content;
		}
    }
    
    // Appendipity app_audio shortcode replacement.  Disable for now since new App pro themes handle this
    //if (preg_match_all('/(.?)\[(app_audio)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', $content, $matches))
    //{
    //$SPP_with_pp = get_option('replace_pp_with_spp');
	
	// Only if Replace PowerPress with SimplePodcastPress Player option is set
    //if ($SPP_with_pp == 1){
            //$content =	str_replace("[app_audio src=","[spp-player url=",$content);
    //return $content;
    //}else{
       //return $content;
	//}
    //}
      
     // WP Audio Player Plugin shortcode replacement.
    if (preg_match_all('/(.?)\[(audio:)\b(.*?)(?:(\/))?\](?:(.+?)\[\/\2\])?(.?)/s', $content, $matches))
    {
       $SPP_with_pp = get_option('replace_pp_with_spp');
       $SPP_exclude_wp = get_option('replace_wp_with_spp');  
       
	     
	     // Only if Replace PowerPress with SimplePodcastPress Player option is set
          if ( (($SPP_with_pp == 1) && ($SPP_exclude_wp == 0)) ) {
            $content =	str_replace("[audio:","[spp-player url=",$content);
            
            return $content;
               
         }
         else
    	    return $content;
    }
      
    if ($show_player) {        
		global $post;
		$audio_player_position = get_option('audio_player_position');
        $width = isset( $atts['width'] ) ? " style='max-width:{$atts['width']}'" : '';
        $audio_file =  get_post_meta( $post->ID, '_audiourl', true );  

        
        // Assume post doesn't contain Powerpress enclosure
        $Powerpress_active_on_post = false;
        if (empty($audio_file)){
			$PPGeneral= get_option('powerpress_general');
            $MetaData = get_post_meta($post->ID, 'enclosure', true);
            $MetaParts = explode("\n", $MetaData, 4);
            $audio_file = trim($MetaParts[0]);
            
            if (empty($audio_file)){
                return $content;
            }
            
            $Powerpress_active_on_post = true;
            $audio_url_parts = parse_url($audio_file);
            if (!empty($PPGeneral['redirect1'])){
                $audio_file = $PPGeneral['redirect1'] . $audio_url_parts['host'] . $audio_url_parts['path'];
            }
            
                
            if ($PPGeneral['display_player'] == 2)
                $audio_player_position = 'above';
        
            elseif ($PPGeneral['display_player'] == 1)
                $audio_player_position = 'below';  
                
            else
                $audio_player_position = 'disabled';
                
            $duration = unserialize($MetaParts[3]);
            $duration = $duration['duration'];           

                
        }
      

            
        $SPP_with_pp = get_option('replace_pp_with_spp');
    
        if ( ($Powerpress_active_on_post == true) && ($SPP_with_pp == 0) ) {
            return $content;
        }
            
        else {
	    $spp_autoplay_podcast = get_option('spp_autoplay_podcast');
        if ($spp_autoplay_podcast)
            $spp_autoplay = 'autoplay';
        else
            $spp_autoplay = '';
            
        $container_width = get_option('container_width');
		$container_width  = 'max-width:' . $container_width . 'px';
            
        $mp3 = '<source src="' . $audio_file  .'" />';
        if ($duration)
            $duration = '('.$duration.')';
            
        $spp_pre_roll_checkbox = get_option('spp_pre_roll_checkbox');
        $spp_pre_roll_url = get_option('spp_pre_roll_url');
       
        if ($spp_pre_roll_checkbox)
              $spp_preroll = "preroll=" . $spp_pre_roll_url;
        else
              $spp_preroll = "";
                      
        
        $spp_remove_timecode = get_option('spp_remove_timecode');
        $spp_listen_text = get_option('spp_listen_text');
        if ($spp_remove_timecode OR !$spp_listen_text)
              $duration = '';
              
              
        $listen_text = get_option('spp_listen_text');

        $listen_text = '<div><b>'.$listen_text.' '. $duration.' </b></div>';
              
        $html .= '<div class="player_container">'.$listen_text.'
		<div>
            <audio class="sppaudioplayer" controls preload="none"' . $spp_preroll . $spp_autoplay .'>'. $mp3 .'
			</audio>
		</div>
        ';
              
        $itunes_url = get_option('btn_itunes_url');
        if (empty($itunes_url) )
            $itunes_url = get_option('itunes_url');
		$btn_spplisten = get_option('btn_spplisten');
        $btn_spprss = get_option('btn_spprss');
        $btn_sppreview = get_option('btn_sppreview');
		$btn_ClammrIT_checkbox = get_option('btn_ClammrIT_checkbox'); 
        $btn_sppandroid = get_option('btn_sppandroid');
        $btn_download = get_option('btn_download');             
		$btn_itunes = get_option('btn_itunes');
		$btn_stiticher = get_option('btn_stiticher');
		$btn_soundcloud = get_option('btn_soundcloud');
		$btn_stiticher_url = get_option('btn_stiticher_url');
		$btn_soundcloud_url = get_option('btn_soundcloud_url');
		$btn_spp_custom1 = get_option('btn_spp_custom1');
		$btn_spp_custom2 = get_option('btn_spp_custom2');
		$btn_spp_custom3 = get_option('btn_spp_custom3');
        $btn_spp_custom4 = get_option('btn_spp_custom4');
		$btn_spp_custom5 = get_option('btn_spp_custom5');
		$btn_spp_custom6 = get_option('btn_spp_custom6');
             
        if (($btn_download == 0) AND ($btn_itunes == 0) AND ($btn_stiticher == 0) AND ($btn_soundcloud == 0) AND ($btn_spplisten == 0) AND ($btn_spprss == 0) AND ($btn_sppreview == 0) AND ($btn_sppandroid == 0)AND ($btn_spp_custom1 == 0) AND ($btn_spp_custom2 == 0) AND ($btn_spp_custom3 == 0) AND ($btn_spp_custom4 == 0) AND ($btn_spp_custom5 == 0) AND ($btn_spp_custom6 == 0))
            $allbtn_onoff = 'display:none !important;';
        else
            $allbtn_onoff = '';
              
              
        //spp_the_content
        $DownloadText = 'Download';
        $iTunesText = 'iTunes';
        $StitcherText = 'Stitcher';
        $SoundCloudText = 'SoundCloud';
        $ListenText = 'Listen in a New Window';
        $ReviewText = 'Leave a Review';
        $RSSText = 'Subscribe via RSS';
        $AndroidText = 'Subscribe on Android';
            
        $btn_stiticher =($btn_stiticher == 0) ? 'display:none !important;' : '';
        $btn_download =($btn_download == 0) ? 'display:none !important;' : '';
        $btn_itunes =($btn_itunes == 0) ? 'display:none !important;' : '';
        $btn_soundcloud =($btn_soundcloud == 0) ? 'display:none !important;' : '';
        $btn_spplisten =($btn_spplisten == 0) ? 'display:none !important;' : '';
        $btn_sppreview =($btn_sppreview == 0) ? 'display:none !important;' : '';
        $btn_ClammrIT_checkbox =($btn_ClammrIT_checkbox == 0) ? 'display:none !important;' : '';
        $btn_spprss =($btn_spprss == 0) ? 'display:none !important;' : '';
        $btn_sppandroid =($btn_sppandroid == 0) ? 'display:none !important;' : '';
             
		$btn_spp_custom1_display =($btn_spp_custom1 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom2_display =($btn_spp_custom2 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom3_display =($btn_spp_custom3 == 0) ? 'display:none !important;' : '';
        $btn_spp_custom4_display =($btn_spp_custom4 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom5_display =($btn_spp_custom5 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom6_display =($btn_spp_custom6 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom_name1 = get_option('btn_spp_custom_name1');
		$btn_spp_custom_name2 = get_option('btn_spp_custom_name2');
		$btn_spp_custom_name3 = get_option('btn_spp_custom_name3');
        $btn_spp_custom_name4 = get_option('btn_spp_custom_name4');
		$btn_spp_custom_name5 = get_option('btn_spp_custom_name5');
		$btn_spp_custom_name6 = get_option('btn_spp_custom_name6');
		$btn_spp_custom_url1 = get_option('btn_spp_custom_url1');
		$btn_spp_custom_url2 = get_option('btn_spp_custom_url2');
		$btn_spp_custom_url3 = get_option('btn_spp_custom_url3');
        $btn_spp_custom_url4 = get_option('btn_spp_custom_url4');
		$btn_spp_custom_url5 = get_option('btn_spp_custom_url5');
		$btn_spp_custom_url6 = get_option('btn_spp_custom_url6');
        $spp_LeadBox_btn_code = '';
		$btn_sppleadbox_checkbox = get_option('spp_LeadBox_btn_checkbox');
		if ($btn_sppleadbox_checkbox) {
			$spp_LeadBox_btn_code = get_option('spp_LeadBox_btn_code');
			$spp_LeadBox_btn_code = htmlspecialchars_decode($spp_LeadBox_btn_code, ENT_QUOTES) ;
			$spp_LeadBox_btn_code = str_replace('<a','<a class="spp-button-leadbox"', $spp_LeadBox_btn_code);
		}
		

        if ( has_post_thumbnail() ) {
              $channel_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        }
        else{
              $channel_image =  get_option('channel_image');
        }
	
        $link = get_permalink($post->ID);
        $posttitle = htmlspecialchars(rawurlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
              
        $postcontent = $link . ' - ' . strip_shortcodes($content);
        $postcontent = str_replace("&nbsp;","", $postcontent);
        $postcontent = preg_replace("/[\r\n]+/", "\n", $postcontent);
		$postcontent = preg_replace("/\s+/", ' ', $postcontent);
		$postcontent = html_entity_decode(strip_tags($postcontent));
        $postcontent = substr($postcontent,0,540).' ...';
        $postcontent = rawurlencode($postcontent);
      
		$direct_download_button = get_option('direct_download_button');
         if ($direct_download_button) {
            $audiodownloadurl = SPPRESS_PLUGIN_URL . '/responsive_audio_player/downloadaudio.php?file=' . $audio_file;
            $spp_download_target = '';
         }
         else {
            $audiodownloadurl = $audio_file;
            $spp_download_target = '_blank';
         }
        
         $itunes_ID = get_option('itunes_id');
         $rss_feed = get_option('podcast_url');
             
         $btn_sppreview_url = 'http://getpodcast.reviews/id/'.$itunes_ID;
         $btn_spprss_url = $rss_feed;
		 $android_rss_feed = parse_url($rss_feed);  
         $btn_sppandroid_url = 'http://subscribeonandroid.com/'.$android_rss_feed['host'].$android_rss_feed['path'];
                   
      
              
		$html .= <<<HTML
<div class="sppbuttons" style="$allbtn_onoff">
				<a class="button-download" target="$spp_download_target" style="$btn_download" href="$audiodownloadurl">$DownloadText</a>
				<a class="button-spplisten" style="$btn_spplisten" href="javascript:void(0);" onclick="window.open('$audio_file', '', 'width=300, height=200');">$ListenText</a>
				<a class="button-itunes" target="_blank" style="$btn_itunes" href="$itunes_url">$iTunesText</a>
				<a class="button-stitcher" target="_blank" style="$btn_stiticher" href="$btn_stiticher_url">$StitcherText</a>
				<a class="button-soundcloud" target="_blank" style="$btn_soundcloud" href="$btn_soundcloud_url">$SoundCloudText</a>
                <a class="button-sppreview" target="_blank" style="$btn_sppreview" href="$btn_sppreview_url">$ReviewText</a>
                <a class="button-clammr" href="javascript:sppClammrIt_$post->ID();"  style="$btn_ClammrIT_checkbox">Clammr It</a>
				<a class="button-spprss" target="_blank" style="$btn_spprss" href="$btn_spprss_url">$RSSText</a>		
				<a class="button-sppandroid" target="_blank" style="$btn_sppandroid" href="$btn_sppandroid_url">$AndroidText</a>	
                <a class="spp-button-custom1" target="_blank" style="$btn_spp_custom1_display" href="$btn_spp_custom_url1">$btn_spp_custom_name1</a>
				<a class="spp-button-custom2" target="_blank" style="$btn_spp_custom2_display" href="$btn_spp_custom_url2">$btn_spp_custom_name2</a>
				<a class="spp-button-custom3" target="_blank" style="$btn_spp_custom3_display" href="$btn_spp_custom_url3">$btn_spp_custom_name3</a>
				<a class="spp-button-custom4" target="_blank" style="$btn_spp_custom4_display" href="$btn_spp_custom_url4">$btn_spp_custom_name4</a>
				<a class="spp-button-custom5" target="_blank" style="$btn_spp_custom5_display" href="$btn_spp_custom_url5">$btn_spp_custom_name5</a>
				<a class="spp-button-custom6" target="_blank" style="$btn_spp_custom6_display" href="$btn_spp_custom_url6">$btn_spp_custom_name6</a>
                $spp_LeadBox_btn_code
                
</div>


<script type="text/javascript">
function sppClammrIt_$post->ID() {
    var sppCurrentTime = document.getElementsByClassName("audioplayer-time audioplayer-time-current");
    var sppCurStartTime = sppCurrentTime.item(0).innerHTML;
    var sppReferralName = 'SimplePodcastPress';
    
    var p = sppCurStartTime.split(':'),
        s = 0, m = 1;

    while (p.length > 0) {
        s += m * parseInt(p.pop(), 10);
        m *= 60;
    }

   var sppCurStartTimeMs = s * 1000;
   var sppCurEndTimeMs = sppCurStartTimeMs + 18000;

var clammrUrlEncoded = "http://www.clammr.com/app/clammr/crop";
clammrUrlEncoded += "?audioUrl=" + encodeURIComponent("$audio_file");
clammrUrlEncoded += "&imageUrl=" + encodeURIComponent("$channel_image");
clammrUrlEncoded += "&audioStartTime=" + encodeURIComponent(sppCurStartTimeMs);
clammrUrlEncoded += "&audioEndTime=" + encodeURIComponent(sppCurEndTimeMs);
clammrUrlEncoded += "&title=" + "$posttitle";
clammrUrlEncoded += "&description=" + "$postcontent";
clammrUrlEncoded += "&referralName=" + encodeURIComponent("SimplePodcastPress");
                  
  jQuery('.sppaudioplayer').trigger("pause");
                       
    window.open(clammrUrlEncoded, 'cropPlugin', 'width=1000, height=750, top=50, left=200');
}
</script>
HTML;
  	$spp_auto_resp_url_get = get_option('spp_auto_resp_url');
    $spp_auto_resp_heading_get = get_option('spp_auto_resp_heading');
    $spp_auto_resp_sub_heading_get = get_option('spp_auto_resp_sub_heading');
    $spp_auto_resp_hidden_get = get_option('spp_auto_resp_hidden');
    $spp_auto_resp_name_get = get_option('spp_auto_resp_name');
    $spp_auto_resp_email_get = get_option('spp_auto_resp_email');
    $spp_auto_resp_email_submitt = get_option('spp_auto_resp_submitt');
    $spp_optin_box = get_option('spp_optin_box');
	$spp_two_step_optin = get_option('spp_two_step_optin');
					 switch ( $spp_two_step_optin ) {
						 case 1 :
								$hide_first_name = '';
						 break;
						 case 2 :
								$hide_first_name = 'display:none !important;';
						 break;
						 case 3 :
								$hide_first_name = 'display:none !important;';
								$hide_email = 'display:none !important;';
						 break;
						 case 4 :
								$hide_first_name = 'display:none !important;';
								$hide_email = 'display:none !important;';
								$hide_first_name_two_step = 'display:none !important;';
						 break;
					}
     if ($spp_optin_box == 1){
         $html .= '<div id="spp-box-below-video" class="spp-optin-box">
				<div class="spp-optin-box-padding">
				<div class="spp-optin-box-content">
				<div class="spp-optin-box-headline">' . stripslashes($spp_auto_resp_heading_get) .'</div>
				<div class="spp-optin-box-subheadline">' . stripslashes($spp_auto_resp_sub_heading_get) . '</div>
				<div class="spp-optin-box-form-wrap">
				<form accept-charset="utf-8" action="'. $spp_auto_resp_url_get .'" method="post" target="_blank">
				'. htmlspecialchars_decode($spp_auto_resp_hidden_get, ENT_QUOTES) . '
				<div class="spp-optin-box-field" style="'.$hide_first_name.'">
				 <input placeholder="First Name" type="text" name="'. $spp_auto_resp_name_get .'"></div>
				<div class="spp-optin-box-field" style="'.$hide_email.'">
				 <input placeholder="Email" type="text" name="'. $spp_auto_resp_email_get .'"></div>';
				if ($spp_two_step_optin == 3 or  $spp_two_step_optin == 4){	
					$html .= '<a class="spp-optin-box-submit" data-reveal-id="spp-two-step-optin"  href="#">'. stripslashes($spp_auto_resp_email_submitt).'</a>';
				}else{
					$html .= '<div class="spp-optin-box-field-submit"><input type="submit" name="submit" class="spp-optin-box-submit" value=" ' . stripslashes($spp_auto_resp_email_submitt) . '"></div>';					
				}
			$html .= '
				</form>
				</div>
				</div>
				</div>
				</div>
                ';			
				
								
						
        }
            
    //Powered by
    $disablePoweredBy = get_option('spp_disable_poweredby');
    $refUrl = get_option('spp_poweredby_url');
    
    if ($refUrl)
        $refUrl = "/?ref=".$refUrl;
    else
        $refUrl = "";
    
    if (!$disablePoweredBy) {
            $html .= '
            <div style="font-size:12px;"><center>Powered by the <a target="_blank" href="http://simplepodcastpress.com'.$refUrl.'">Simple Podcast Press</a> Player</center></div>
            ';
        }
    
    // closing div
    $html .= '</div>';
}

    
          if(in_array('the_excerpt', $GLOBALS['wp_current_filter'])) {
                if ( ! has_excerpt( $post->ID ) ) 
                      //$content = get_the_excerpt();
                      $content = get_the_content("");
                      
                $content = strip_shortcodes( $content );
                
                $filter_html = wp_strip_all_tags($html, true);
                $content = str_replace($filter_html, '', $content);
                
                $content = wp_trim_words( $content );
          }
          
          
          if ( has_post_thumbnail() && $spp_insert_feat_image ) {

                $spp_imgsize_select = get_option('spp_imgsize_select');
                $spp_imgalign_select = get_option('spp_imgalign_select');
                
                if ($spp_imgsize_select == 'thumbnail')
                  $spp_imgsize = '150';
                else if ($spp_imgsize_select == 'medium')
                  $spp_imgsize = '300';
                else if ($spp_imgsize_select == 'large')
                  $spp_imgsize = '640';
                else
                  $spp_imgsize = '';
                
                $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'single-post-thumbnail' );

                $spp_featured_image = '<img width="'.$spp_imgsize.'"';
                $spp_featured_image .= ' height="'.$spp_imgsize.'"';
                $spp_featured_image .= ' class="'.$spp_imgalign_select.' wp-post-image"';
                $spp_featured_image .= ' src="'.$image[0].'" >';
          }
          
          
          
          else
                $spp_featured_image = '';
          
          switch($audio_player_position){
		
				case 'above' :
		
                if ($spp_player_over_image) {
                      if( ( is_single() && is_main_query() ) || is_page() )
                            $content =  $html.$spp_featured_image.$content.PHP_EOL;
                      else
                            $content =  $html.$content.PHP_EOL;
                }
                else {  
                      if( ( is_single() && is_main_query() ) || is_page() )
                            $content =  $spp_featured_image.$html.PHP_EOL.$content;
                      else
                            $content =  $html.PHP_EOL.$content;
                }
		
				break;
		
				case 'below' :
                  if( ( is_single() && is_main_query() ) || is_page() )
                        $content =  $spp_featured_image.$content.PHP_EOL.$html;	
                  else
                        $content =  $content.PHP_EOL.$html;	
		
				break;
              
                case 'disabled' :
                
                if( ( is_single() && is_main_query() ) || is_page() )
                      $content =  $spp_featured_image.$content.PHP_EOL;
                else
                      $content =  $content.PHP_EOL;
                
		
				break;
                
                default:
                if( ( is_single() && is_main_query() ) || is_page() )
                      $content =  $spp_featured_image.$content.PHP_EOL;	
                else
                      $content =  $content.PHP_EOL;
		
			}
    } // end of if show_player
    
	return $content;
}
      
function spp_plugin_update () {
    require_once(ABSPATH . 'wp-admin/includes/file.php');
    global $sppress_current_version;

   $last_savedcss_version = get_option('spp-currentcss-version');
       
    if ( $last_savedcss_version !== $sppress_current_version ) {      
         update_option('spp-currentcss-version', $sppress_current_version);
         $this->generate_options_css();
         $isClammrButtonOn = get_option('btn_ClammrIT_checkbox');
          if ($isClammrButtonOn === FALSE)
                update_option('btn_ClammrIT_checkbox', 1);
    }

      
      
    return;
}
    
function linkify_text($text) {
  $url_re = '@(https?://([-\w\.]+)+(:\d+)?(/([\w/_\.]*(\?\S+)?)?)?)@';
  $url_replacement = "<a href='$1' target='_blank'>$1</a>";
  return preg_replace($url_re, $url_replacement, $text);
}
      
function clicky($text) {
    $text = eregi_replace('(((f|ht){1}tp://)[-a-zA-Z0-9@:%_+.~#?&//=]+)', '<a href="$1">$1</a>', $text);
    $text = eregi_replace('([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_+.~#?&//=]+)', '$1<a href="http://$2">$2</a>', $text);
    $text = eregi_replace('([_.0-9a-z-]+@([0-9a-z][0-9a-z-]+.)+[a-z]{2,3})', '<a href="mailto:$1">$1</a>', $text);
    return $text;
}
    
    

    
function generate_options_css() {
      
        /** Define some vars **/
		//require_once(ABSPATH . 'wp-admin/includes/file.php');
        $uploads = wp_upload_dir();
		$css_dir = dirname( __FILE__ ). '/responsive_audio_player/css/'; // Shorten code, save 1 call
        
        //$css_dir =  WP_PLUGIN_URL . '/simple-podcast-press/responsive_audio_player/css/'; // Shorten code, save 1 call
		/** Save on different directory if on multisite **/
		if(is_multisite()) {
		  $aq_uploads_dir = trailingslashit($uploads['basedir']);
		} else {
		  $aq_uploads_dir = $css_dir;
		}
		/** Capture CSS output **/
		ob_start();
		require($css_dir . 'audio-player.php');
		$css = ob_get_clean();
		/** Write to options.css file **/
		
      global $wp_filesystem;
      // protect if the the global filesystem isn't setup yet
      if( is_null( $wp_filesystem ) ) 
            WP_Filesystem();
      if ( ! $wp_filesystem->put_contents( $aq_uploads_dir . 'audio-player.css', $css) ) {
		  update_option('spp_writecss', FALSE);
          return false;   
      }
              
      update_option('spp_writecss', TRUE);
      return true;

}


function spp_css_failed() {
    ?>
    <div class="error">
        <p><?php _e( 'ERROR!', 'CSS Failed' ); ?></p>
    </div>
    <?php
}

function spp_css_passed() {
    ?>
    <div class="updated">
        <p><?php _e( 'UPDATED!', 'CSS Success' ); ?></p>
    </div>
    <?php
}

function manual_spp_action() {
    $post_id = get_the_ID();
	$sppogp = get_post_meta($post_id,'OGP', true );
    
    if ( has_post_thumbnail($post_id) )
        $fbChannelImage = wp_get_attachment_url( get_post_thumbnail_id($post_id) );
    else
        $fbChannelImage =  get_option('channel_image');
      
    $sppogp["image"] = $fbChannelImage;
    update_post_meta( $post_id,'OGP', $sppogp );
}
      

function spp_admin_menu(){
			$iconImage = WP_PLUGIN_URL . '/simple-podcast-press/icons/spp_icon.png';
			add_menu_page('SimplePodcastPress', 'Simple Podcast Press', 'manage_options','spp-podcast-settings',array($this,'spp_plugin_view'),$iconImage);
			add_submenu_page('spp-podcast-settings', 'Simple Podcast Press', 'Settings', 'manage_options','spp-podcast-settings',array($this,'spp_plugin_view'));
			add_submenu_page( 'spp-podcast-settings', 'Simple Podcast Press', 'iTunes Reviews', 'manage_options' , 'spp_reviews', array($this,'spp_plugin_review_page') );
			add_submenu_page( 'spp-podcast-settings', 'Simple Podcast Press', 'URL Shortener', 'manage_options' , 'spp-url-shortner', array($this,'spp_url_shortner_page') );
            
		}

//	End of adding menu to admin sidebar
function reviews_dashboard_widgets() {
	    global $wp_meta_boxes, $wpdb;
		$table_spp_reviews	=  $wpdb->prefix . "spp_reviews";
		$spp_reviews = $wpdb->get_results("SELECT * FROM " . $table_spp_reviews );
		$dashboard_current = $wp_meta_boxes['dashboard']['normal']['core'];
$totalitunesreviewscount = count($spp_reviews);
$itunesreviewstitle = 'International iTunes Reviews' . ' (' . $totalitunesreviewscount .')';
	    wp_add_dashboard_widget('spp_reviews_widget', $itunesreviewstitle, array($this,'rw_widget_fn'));
		
		$dashboard_current = $wp_meta_boxes['dashboard']['normal']['core'];
			if( isset( $dashboard_current['spp_reviews_widget'] ) )
			{
				$dashboard_podcast['spp_reviews_widget'] = $dashboard_current['spp_reviews_widget'];
				unset($dashboard_current['spp_reviews_widget']);
			}
		if( count($dashboard_podcast) > 0 )
			{
				$wp_meta_boxes['dashboard']['normal']['core'] = array_merge($dashboard_podcast, $dashboard_current);
			}
	    }
	
function rw_widget_fn() {
		global $wpdb;
		$table_spp_reviews	=  $wpdb->prefix . "spp_reviews";
		$spp_reviews = $wpdb->get_results("SELECT * FROM " . $table_spp_reviews . " ORDER BY rw_published_date DESC");
		$counter = 0;
		echo '<table>';
			foreach ($spp_reviews as $spp_review){
			
				echo '<tr><td>';
				echo  '<strong>'. $spp_review->rw_title . '</strong>' . '&nbsp;&nbsp;&nbsp;&nbsp;'
;
				$rating = $spp_review->rw_ratings;
				switch ($rating){
			
					case 5 :
					echo '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/5star.png" />';
					break;
					case 4 :
					echo '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/4star.png" />';
					break;
					case 3 :
					echo '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/3star.png" />';
					break;
					case 2 :
					echo '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/2star.png" />';
					break;
					case 1 :
					echo '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/1star.png" />';
					break;
					default:
					echo '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/00star.png" />';
					break;
				}
					$publishedat = $spp_review->rw_published_date;
					$PublishDate = date("F j, Y", strtotime($publishedat));
				echo '</td></tr><tr><td>';
				echo $PublishDate  . ' by '. '<b>' .  $spp_review->rw_author . '</b>' . ' from ' . $this->get_full_country_name($spp_review->rw_coutry);	
				echo '</td></tr><tr><td>';
				echo  $spp_review->rw_text . '</br></br>';	
				echo '</td></tr>';
			if ($counter == 4){
				break; 
				}
			$counter++;
	
			}//end foreach
			echo '<tr><td><a href="admin.php?page=spp_reviews" style="float:right;">See All Reviews</a></td></tr>';
			echo '</table>';
			
	    }
		function spp_plugin_view(){
			include("spp_view/spp_plugin_view.php");
		}
function spp_metaboxes (){
	$args = array(
	   'public'   => true,
	   '_builtin' => false
	);
	
	$array1 = array("post" => "post");
	$array2 = get_post_types( $args); 
	$post_types = array_merge($array1, $array2);
	foreach ( $post_types  as $post_type ) {
			$disable_url_shortner = get_option('disable_url_shortner');
			if (!$disable_url_shortner){
			add_meta_box( 'spp_link_metabox', 'Podcast Episode URL Shortener', array($this,'spp_link_metabox_fn'), $post_type, 'normal', 'high' );
			}
			add_meta_box( 'spp_metabox', 'Simple Podcast Press Clutter-Free Transcript', array($this,'spp_metabox_fn'), $post_type, 'normal', 'high' );
			global $wp_meta_boxes;
	
			$current_metaboxes = $wp_meta_boxes['post']['normal']['high'];
			if( isset( $current_metaboxes['spp_metabox'] ) )
			{
				$spp_metabox['spp_metabox'] = $current_metaboxes['spp_metabox'];
				unset($current_metaboxes['spp_metabox']);
			}
			if( count($spp_metabox) > 0 )
			{
				$current_metaboxes = array_merge($spp_metabox, $current_metaboxes);
			}
	}//end foreach
	
}
	function spp_link_metabox_fn( $post ){
		
		global $wpdb;
		$table_spp_links	=  $wpdb->prefix . "spp_links";
		
		$spp_slug = '';
		$spp_slug	= $wpdb->get_row("SELECT * FROM " . $table_spp_links . " WHERE spp_post_id = '$post->ID'");
		
        if (isset($spp_slug))  
            $spp_slug_number = $spp_slug->spp_slug;
        else
            $spp_slug_number = '';
        
?>
		
	     
		
		<div class="mab-spp-link">
		
			<p><b><?php echo get_site_url() ?>/</b><input type="text" name="spp_slug" value="<?php echo $spp_slug_number; ?>" style="width:100px;"  /></p>
		</div>

<?php
      
    }
      
      
		function spp_link_metabox_save( $post_id )
		{
			global $wpdb;
			$table_spp_links	=  $wpdb->prefix . "spp_links";
	
			
			// if our current user can't edit this post, bail
			if( !current_user_can( 'edit_post' ) ) 
                           return;
			
			// Bail if we're doing an auto save
   			if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
     			   return;
  			// Prevent quick edit from clearing custom fields
  			if (defined('DOING_AJAX') && DOING_AJAX)
  			   return;
			$is_revision = wp_is_post_revision( $post_id );
  			if ($is_revision)
  			   return;
			$post_status = get_post_status ( $post_id );
			if ( $post_status == 'auto-draft' or $post_status == 'pending' )
  			   return;
			// now we can actually save the data
			$post_title = get_the_title($post_id);
			
			$slugarray = preg_split("/[\s,]+/", $post_title);
			
			foreach ($slugarray as $slugelement) {
    				$slug = preg_replace('~[^0-9]~','',$slugelement);
				$slug = intval($slug);
				if ($slug !== 0)
				   break;
			}
			
		if(empty($_POST['spp_slug'])){
			$slug = get_option('episode_short_link') . $slug;
		}else{
			$slug = $_POST['spp_slug'];
		}

			$is_available = $this->spp_slugIsAvailable($slug);
			$permellink = get_permalink( $post_id ); 
			
			$table_spp_links	=  $wpdb->prefix . "spp_links";
		    $query = $wpdb->prepare("SELECT spp_post_id FROM {$table_spp_links} WHERE spp_post_id=%s", $post_id);
		  
		    $is_in_db = $wpdb->get_var($query);
		if (!$is_in_db){		
			if( $is_available OR !empty($slug)) {
				
				$data = array(
							'spp_name' => $post_title,
							'spp_url' => $permellink,
							'spp_slug' => $slug,
							'spp_post_id' => $post_id
							
							);
										
							$wpdb->insert($table_spp_links, $data );
			}
		}else{
				$data = array(
							'spp_name' => $post_title,
							'spp_url' => $permellink,
							'spp_slug' => $slug,
							'spp_post_id' => $post_id
							
							); 
																		
				$where	=	array(
							'spp_post_id' => $post_id,
							);
										
							$wpdb->update($table_spp_links, $data, $where );
		}
				
		
		}
    
    
function url_get_contents ($url) {
    $getresponse = wp_remote_get($url, array( 'timeout' => 60, 'redirection' => 20, 'sslverify' => false, ) );
    $response = wp_remote_retrieve_body($getresponse);
    return $response;
} 
    
    
function curl( $url ) {
	$curl = curl_init( $url );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $curl, CURLOPT_HEADER, 0 );
	curl_setopt( $curl, CURLOPT_USERAGENT, '' );
	curl_setopt( $curl, CURLOPT_TIMEOUT, 10 );
	$response = curl_exec( $curl );
	if( 0 !== curl_errno( $curl ) || 200 !== curl_getinfo( $curl, CURLINFO_HTTP_CODE ) ) {
		$response = null;
	} // end if
	curl_close( $curl );
	return $response;
} // end curl
    
    
function spp_slugIsAvailable( $full_slug, $id = '' )
  {
		    global $wpdb;
		  
		    $slug = $full_slug;
		  
		    // Check slug uniqueness against posts, pages and categories
		    $postname = $wpdb->get_var($wpdb->prepare("SELECT post_name FROM {$wpdb->posts} WHERE post_name=%s LIMIT 1",$slug));
		    $taxonomy = $wpdb->get_var($wpdb->prepare("SELECT taxonomy FROM {$wpdb->term_taxonomy} WHERE taxonomy=%s LIMIT 1",$slug));
		  
		    // If anything was returned for these two calls then the slug has been taken
		    if( $postname or $taxonomy )
		      return false;
		  
		    // Check slug against files on the root wordpress install
		    $root_dir = opendir(ABSPATH); 
		  
		    while (($file = readdir($root_dir)) !== false) {
		      $haystack = strtolower($file);
		      if($haystack == $slug)
		        return false;
		    }
		  
			$table_spp_links	=  $wpdb->prefix . "spp_links";
		    if(!is_null($id) and !empty($id) and is_numeric($id))
		      $query = $wpdb->prepare("SELECT spp_slug FROM {$table_spp_links} WHERE spp_slug=%s AND id <> %d", $full_slug, $id);
		    else
		      $query = $wpdb->prepare("SELECT spp_slug FROM {$table_spp_links} WHERE spp_slug=%s", $full_slug);
		  
		    $link_slug = $wpdb->get_var($query);
		  
		    if( $link_slug == $full_slug )
		      return false;
		  
		    $pre_slug_slug = $this->get_permalink_pre_slug_uri(true,true);
		
		    if($full_slug == $pre_slug_slug)
		      return false;
		
		    // TODO: Check permalink structure to avoid the ability of creating a year or something as a slug
		  
		    return true;
  }
function get_permalink_pre_slug_uri($force=false,$trim=false)
  {
    if($force)
    {
      preg_match('#^([^%]*?)%#', get_option('permalink_structure'), $struct);
      $pre_slug_uri = $struct[1];
      if($trim)
      {
        $pre_slug_uri = trim($pre_slug_uri);
        $pre_slug_uri = preg_replace('#^/#','',$pre_slug_uri);
        $pre_slug_uri = preg_replace('#/$#','',$pre_slug_uri);
      }
      return $pre_slug_uri;
    }
    else
      return '/';
  }
	
		function spp_metabox_fn( $post ){
		$spptranscript = get_post_meta( $post->ID, '_spptranscript', true );
		?>
		
		<div class="mab-spp-transcript">
			<p>Enter your transcript or show notes here. To insert the transcript on your page, add the [spp-transcript] shortcode in the main post editor above.</p>
			<textarea name="_spptranscript" rows="10" style="width: 100%"><?php echo wpautop($spptranscript); ?></textarea>

		</div>
<?php
		}
		
		function spp_metabox_save( $post_id )
		{
			// Bail if we're doing an auto save
			if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) return;
			
			// if our current user can't edit this post, bail
			if( !current_user_can( 'edit_post' ) ) return;
			
			// now we can actually save the data
			if (isset($_POST['_spptranscript']))
            {
                  $transcript_text = wpautop($_POST['_spptranscript']);
				
				  update_post_meta( $post_id, '_spptranscript',  $transcript_text );
            }
              
		
		}
	
    function get_itunes_ID($url){
	$idstyles = array(
			    '?id=',
			    '&id=',
			    '/id'
			    );
			
			  for ($counter = 0; $counter < count($idstyles); $counter++):
			  
			    if (strpos($url, $idstyles[$counter])):
			    
			      $idstyle = $idstyles[$counter]; 
			      $validID = "So, how are you holding up? Because I'm a potato!";
			      break;
			      endif;
			   	 endfor;
			
			preg_match("/[0-9]+/", $url, $podid, 0, strpos($url, $idstyle)); 
			return $podid[0];
	}
    
    
        
 
    
function spp_save_podcast_settings() {
		global $wpdb;
  	
        $table_spp_podcast	=  $wpdb->prefix . "spp_podcast";
		$variable = $_POST["yourpostname"];

		$nonce = $_POST['wpnonce']; 

	if ( !wp_verify_nonce( $nonce, 'settings' ) ) {
			// This nonce is not valid.
		die( 'Security check' ); 

	} else {
        
        if($variable == 'Save') {
            $itunes_url = $_POST["podcast_url"]; 
            $podcast_xml = $_POST["podcast_xml"]; 
            
            if (!empty($itunes_url)){
                $headers = get_headers($itunes_url, 1);
                $itunes_url_redirect = $headers["Location"][1];
                if ($itunes_url_redirect)
                     $itunes_url = $itunes_url_redirect;
                $itunes_ID = $this->get_itunes_ID($itunes_url); 
                update_option('itunes_id',$itunes_ID);
				$btn_itunes_url = $_POST["btn_itunes_url"]; 
				update_option('btn_itunes_url',$btn_itunes_url);
                update_option('itunes_url', $itunes_url);
                

				// Json Parsing
                $get_podcast = 'https://itunes.apple.com/lookup?id='.$itunes_ID; 
                $jsonOBJ = $this->url_get_contents($get_podcast);      
				$jsonOBJ = json_decode($jsonOBJ);

               	$podcastURL = $jsonOBJ->results[0]->feedUrl;
                update_option('podcast_url',$podcastURL );
                
            }
            elseif (!empty($podcast_xml)){
                update_option('podcast_url',$podcast_xml );
                $podcastURL = $podcast_xml;
            }
            
            if ($podcastURL){
                $parse = parse_url($podcastURL);
                $domain_name =  $parse['host']; 

                if(is_multisite()) {
                    $spp_current_site = get_current_site();
                    $spp_current_site_domain = $spp_current_site->domain;
                }
                else {
                    $spp_current_site_domain = $_SERVER['SERVER_NAME'];
                }
                update_option('spp_site_domain',$spp_current_site_domain );
                update_option('spp_feed_domain',$domain_name );
                // Install DB and Build Table of Episodes for all types of feeds  
                $this->install_spp_db();
                // Check if Feed domain matches current domain of site (self hosted). Set flag to FALSE
                if($domain_name == $spp_current_site_domain)
                    update_option('is_third_party_feed', 0 );
                else
                    update_option('is_third_party_feed', 1 );
            }
            else {
                die('1'); 
                exit;
            }
            //	Start of getting and saving podcast channel art
            $xml = $this->url_get_contents($podcastURL);
            
            $itunes_xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
            $podcastXML = simplexml_load_string($itunes_xml);
            $channel_image_url = (string)$podcastXML->channel->image->url; 
                       
            $upload_dir=wp_upload_dir();

            $image_data = $this->url_get_contents($channel_image_url);
            $image_array=explode('.',$channel_image_url);
            $total_img=count( $image_array );
            $ext=end( $image_array );
              if ($ext == null)
                  $ext = 'png';
            unset($image_array[$total_img-1]);
            $new_file='podcast_channel_artwork.' . $ext;
            $filename=basename($new_file);
            if(wp_mkdir_p($upload_dir['path']))$file = $upload_dir['path'] . '/' . $filename; else $file = $upload_dir['basedir'] . '/' . $filename;
             $spp_channelart_upload = file_put_contents($file, $image_data);
             if (!$spp_channelart_upload) {
                   global $wp_filesystem;
                   // protect if the the global filesystem isn't setup yet
                   if( is_null( $wp_filesystem ) )
                        WP_Filesystem();
                   $wp_filesystem->put_contents($file, $image_data, FS_CHMOD_FILE);
              }      
              
            $wp_filetype = wp_check_filetype($filename, null );
            $attachment = array('post_mime_type' => $wp_filetype['type'],'post_title' => sanitize_file_name($filename),'post_content' => '','post_status' => 'inherit');
            $attach_id = wp_insert_attachment( $attachment, $file, $post_id );
            require_once(ABSPATH . 'wp-admin/includes/image.php');
            $attach_data = wp_generate_attachment_metadata( $attach_id, $file );
            wp_update_attachment_metadata( $attach_id, $attach_data );
           
            $channel_image = wp_get_attachment_url( $attach_id );
            update_option('channel_image',$channel_image);
              
            //	End of getting and saving podcast channel art
            $this->spp_save_podcast_xml($podcastURL);
            
            // Must do at the end.  If iTunes URL entered, then Save Reviews
            if ($itunes_url)
                $this->spp_save_reviews($itunes_ID);
        }
   
		if($variable == 'Save Changes'){
		 	$this->save_spp_settings();
			$this->generate_options_css(); 
			}
	
		if($variable == 'Import New Podcasts Now'){
		 	$this->save_spp_settings();
            $this->generate_post_from_spp_table(); 
		}
    
        if($variable == 'Check For New Reviews Now'){
		 	$this->save_spp_settings();
            $this->$this->spp_save_reviews(); 
		}
	}
}
function generate_post_with_cron(){
        
    
        $isLicenseValid = get_option('sppress_ls');
        
        if ($isLicenseValid !== 'valid') 
        {
          exit;  
        }
    
        
        
	
        $noImport = get_option('spp_import_select');
	$noImportLegacy = get_option('spp_no_import');
	// If the legacy no import option is enabled then override new import setting to disable
	if ($noImportLegacy)
		$noImport = 1;
	
		$btn_itunes_url = get_option('btn_itunes_url');
		
    $podcastURL_Feed = get_option('is_third_party_feed');
    $podcast_URL = get_option('podcast_url');
		
        $this->spp_save_podcast_xml($podcast_URL);
    
        // Only generate posts for Third Party Feeds and No Import option is OFF
        if ( ($podcastURL_Feed) && ($noImport == 0 or $noImport == 2) ){
            $this->generate_post_from_spp_table(); 
	
        }
  
}
    
    function delete_spp_settings(){
		delete_option('reviews_activated');
        delete_option('itunes_id');
        delete_option('itunes_url');
        delete_option('btn_itunes_url');
        delete_option('channel_image');
        delete_option('channel_keywords');
        delete_option('podcast_url');
        delete_option('is_third_party_feed');
		delete_option('podcast_url_feed');
	}
    
    function delete_all_spp_settings(){
		delete_option('reviews_activated');
        delete_option('itunes_id');
        delete_option('itunes_url');
        delete_option('channel_image');
        delete_option('channel_keywords');
        delete_option('podcast_url');
        delete_option('is_third_party_feed');
		delete_option('podcast_url_feed');
		delete_option('transcript_position');
		delete_option('audio_player_position');
		delete_option('spp-twitter-handle');
		delete_option('episode_short_link');
        delete_option('spp_author');
        delete_option('spp_post_category');
		delete_option('spp_cpt_select');
		delete_option('optin_old_code');
		delete_option('spp_auto_resp_url');
		delete_option('spp_auto_resp_heading');
		delete_option('spp_auto_resp_sub_heading');
		delete_option('spp_auto_resp_hidden');
		delete_option('spp_auto_resp_name');
		delete_option('spp_auto_resp_email');
		delete_option('spp_auto_resp_submitt');
		delete_option('select_audio_player');
		delete_option('replace_pp_with_spp');
		delete_option('replace_stp_with_spp');
        delete_option('replace_ppplayer_with_spp');
        delete_option('replace_wp_with_spp');
        delete_option('select_audio_player');
        delete_option('spp_optin_box');
		delete_option('btn_download');
        delete_option('btn_download_color');
        delete_option('btn_spprss');
        delete_option('btn_spprss_color');
        delete_option('btn_sppreview');
        delete_option('btn_sppreview_color');
        delete_option('btn_spplisten');
        delete_option('btn_spplisten_color');
        delete_option('btn_sppandroid');
        delete_option('btn_sppandroid_color');
        delete_option('btn_itunes');
		delete_option('btn_itunes_color');
		delete_option('transcript');
		delete_option('transcript_txt');
        delete_option('spp_listen_text');
		delete_option('transcript_color');
		delete_option('btn_stiticher_color');
		delete_option('btn_stiticher_url');
		delete_option('btn_stiticher');
		delete_option('btn_soundcloud_color');
		delete_option('btn_soundcloud_url');
		delete_option('btn_soundcloud');
		delete_option('spp_auto_publish');
        delete_option('spp_insert_feat_image'); 
		delete_option('spp_email_on_draft');
        delete_option('spp_player_over_image');
		delete_option('spp_description');
		delete_option('spp_disable_thumbs');
		delete_option('spp_sync_description');
        delete_option('ep_art_select');
        delete_option('disable_url_shortner');
        delete_option('disable_opengraph');
        delete_option('twitter_text_color');
        delete_option('submit_button_color');
        delete_option('submit_button_text');
        delete_option('opt-container_color');
        delete_option('btn_style_round');
        delete_option('spp_remove_timecode');
        delete_option('spp_flat_player');
        delete_option('spp_post_inserted');
        delete_option('spp_featured_image_detected');
        delete_option('spp_db_version');
        delete_option('spp_check_shortcode');
        delete_option('spp_site_domain');
        delete_option('spp_feed_domain');
        delete_option('is_third_party_feed');
        delete_option('spp_channel_image');
        delete_option('spp_hide_player_from_excerpt');
        delete_option('container_width');
        delete_option('minbutton_width');
        delete_option('spp_disable_poweredby');
        delete_option('spp_disable_spp_player_script');
        delete_option('spp_autoplay_podcast');
        delete_option('spp_poweredby_url');
        delete_option('spp_force_player_home');
    }
	function save_spp_settings(){
		global $wpdb;
        $btn_spp_custom1 = '';
        $btn_spp_custom2 = '';
        $btn_spp_custom3 = '';
        $btn_spp_custom4 = '';
        $btn_spp_custom5 = '';
        $btn_spp_custom6 = '';
        $transcript_position = '';
        $disable_url_shortner = false;
        $disable_opengraph = false;
        $replace_pp_with_spp = false;
        $replace_wp_with_spp = false;
        $replace_stp_with_spp = false;
        $replace_ppplayer_with_spp = false;
        $select_audio_player = 'simplepodcastpressblack';
        $powered_by_svp_link = 'on';
        $spp_force_player_home = false;
          
      
		if (isset($_POST["spp_two_step_optin"])) {
            $spp_two_step_optin = $_POST['spp_two_step_optin'];
		    update_option('spp_two_step_optin', $spp_two_step_optin);
        }
	    if (isset($_POST["replace_ppplayer_with_spp"]))
             $replace_ppplayer_with_spp = $_POST["replace_ppplayer_with_spp"];
        if (isset($_POST["replace_wp_with_spp"]))
           $replace_wp_with_spp = $_POST["replace_wp_with_spp"];
        if (isset($_POST["replace_stp_with_spp"]))
           $replace_stp_with_spp = $_POST["replace_stp_with_spp"];
        if (isset($_POST["btn_spp_custom1"]))
            $btn_spp_custom1 = $_POST["btn_spp_custom1"];
		if (isset($_POST["btn_spp_custom2"]))
              $btn_spp_custom2 = $_POST["btn_spp_custom2"];
		if (isset($_POST["btn_spp_custom3"]))
              $btn_spp_custom3 = $_POST["btn_spp_custom3"];
        if (isset($_POST["btn_spp_custom4"]))
            $btn_spp_custom4 = $_POST["btn_spp_custom4"];
		if (isset($_POST["btn_spp_custom5"]))
              $btn_spp_custom5 = $_POST["btn_spp_custom5"];
		if (isset($_POST["btn_spp_custom6"]))
              $btn_spp_custom6 = $_POST["btn_spp_custom6"];
		if (isset($_POST["spp_LeadBox_btn_checkbox"]))
              $spp_LeadBox_btn_checkbox = $_POST["spp_LeadBox_btn_checkbox"];
          
        if (isset($_POST["transcript_color"]))
              $transcript_color = $_POST["transcript_color"];
        if (isset($_POST["btn_spp_custom_color1"]))
              $btn_spp_custom_color1 = $_POST["btn_spp_custom_color1"];
        if (isset($_POST["btn_spp_custom_color2"]))
              $btn_spp_custom_color2 = $_POST["btn_spp_custom_color2"];
		if (isset($_POST["btn_spp_custom_color3"]))
              $btn_spp_custom_color3 = $_POST["btn_spp_custom_color3"];
        if (isset($_POST["btn_spp_custom_color4"]))
              $btn_spp_custom_color4 = $_POST["btn_spp_custom_color4"];
        if (isset($_POST["btn_spp_custom_color5"]))
              $btn_spp_custom_color5 = $_POST["btn_spp_custom_color5"];
		if (isset($_POST["btn_spp_custom_color6"]))
              $btn_spp_custom_color6 = $_POST["btn_spp_custom_color6"];
		if (isset($_POST["spp_LeadBox_btn_color"]))
              $spp_LeadBox_btn_color = $_POST["spp_LeadBox_btn_color"];
		
		if (isset($_POST["btn_spp_custom_name1"]))
              $btn_spp_custom_name1 = $_POST["btn_spp_custom_name1"]; 
		if (isset($_POST["btn_spp_custom_name2"]))
              $btn_spp_custom_name2 = $_POST["btn_spp_custom_name2"];
		if (isset($_POST["btn_spp_custom_name3"]))
              $btn_spp_custom_name3 = $_POST["btn_spp_custom_name3"];
        if (isset($_POST["btn_spp_custom_name4"]))
              $btn_spp_custom_name4 = $_POST["btn_spp_custom_name4"]; 
		if (isset($_POST["btn_spp_custom_name5"]))
              $btn_spp_custom_name5 = $_POST["btn_spp_custom_name5"];
		if (isset($_POST["btn_spp_custom_name6"]))
              $btn_spp_custom_name6 = $_POST["btn_spp_custom_name6"];
          
		if (isset($_POST["btn_spp_custom_url1"]))
              $btn_spp_custom_url1 = $_POST["btn_spp_custom_url1"]; 
		if (isset($_POST["btn_spp_custom_url2"]))
              $btn_spp_custom_url2 = $_POST["btn_spp_custom_url2"];
		if (isset($_POST["btn_spp_custom_url3"]))
              $btn_spp_custom_url3 = $_POST["btn_spp_custom_url3"];
        if (isset($_POST["btn_spp_custom_url4"]))
              $btn_spp_custom_url4 = $_POST["btn_spp_custom_url4"]; 
		if (isset($_POST["btn_spp_custom_url5"]))
              $btn_spp_custom_url5 = $_POST["btn_spp_custom_url5"];
		if (isset($_POST["btn_spp_custom_url6"]))
              $btn_spp_custom_url6 = $_POST["btn_spp_custom_url6"];
		if (isset($_POST["spp_LeadBox_btn_code"]))
              $spp_LeadBox_btn_code = stripslashes(htmlspecialchars($_POST["spp_LeadBox_btn_code"], ENT_QUOTES));


          //Saving Custom Button 1
		if ($replace_ppplayer_with_spp == 'on')
		{
			update_option('replace_ppplayer_with_spp', 1);
		}else{
			update_option('replace_ppplayer_with_spp', 0);
		}
          
        if ($replace_wp_with_spp == 'on')
		{
			update_option('replace_wp_with_spp', 1);
		}else{
			update_option('replace_wp_with_spp', 0);
		}
          
        if ($replace_stp_with_spp == 'on')
		{
			update_option('replace_stp_with_spp', 1);
		}else{
			update_option('replace_stp_with_spp', 0);
		}
          
          if ($btn_spp_custom1 == 'on')
		{
			update_option('btn_spp_custom1', 1);
			update_option('btn_spp_custom_color1', $btn_spp_custom_color1);
			update_option('btn_spp_custom_name1', $btn_spp_custom_name1);
			update_option('btn_spp_custom_url1', $btn_spp_custom_url1);
		}else{
			update_option('btn_spp_custom1', 0);
		}
//Saving Custom Button 2
		if ($btn_spp_custom2 == 'on')
		{
			update_option('btn_spp_custom2', 1);
			update_option('btn_spp_custom_color2', $btn_spp_custom_color2);
			update_option('btn_spp_custom_name2', $btn_spp_custom_name2);
			update_option('btn_spp_custom_url2', $btn_spp_custom_url2);
		}else{
			update_option('btn_spp_custom2', 0);
		}
//Saving Custom Button 3
		if ($btn_spp_custom3 == 'on')
		{
			update_option('btn_spp_custom3', 1);
			update_option('btn_spp_custom_color3', $btn_spp_custom_color3);
			update_option('btn_spp_custom_name3', $btn_spp_custom_name3);
			update_option('btn_spp_custom_url3', $btn_spp_custom_url3);
		}else{
			update_option('btn_spp_custom3', 0);
		}
        //Saving Custom Button 4
        if ($btn_spp_custom4 == 'on')
		{
			update_option('btn_spp_custom4', 1);
			update_option('btn_spp_custom_color4', $btn_spp_custom_color4);
			update_option('btn_spp_custom_name4', $btn_spp_custom_name4);
			update_option('btn_spp_custom_url4', $btn_spp_custom_url4);
		}else{
			update_option('btn_spp_custom4', 0);
		}
//Saving Custom Button 5
		if ($btn_spp_custom5 == 'on')
		{
			update_option('btn_spp_custom5', 1);
			update_option('btn_spp_custom_color5', $btn_spp_custom_color5);
			update_option('btn_spp_custom_name5', $btn_spp_custom_name5);
			update_option('btn_spp_custom_url5', $btn_spp_custom_url5);
		}else{
			update_option('btn_spp_custom5', 0);
		}
//Saving Custom Button 6
		if ($btn_spp_custom6 == 'on')
		{
			update_option('btn_spp_custom6', 1);
			update_option('btn_spp_custom_color6', $btn_spp_custom_color6);
			update_option('btn_spp_custom_name6', $btn_spp_custom_name6);
			update_option('btn_spp_custom_url6', $btn_spp_custom_url6);
		}else{
			update_option('btn_spp_custom6', 0);
		}

//Saving  SPP LeadBox Button
		if ($spp_LeadBox_btn_checkbox == 'on')
		{

			update_option('spp_LeadBox_btn_checkbox', 1);
			update_option('spp_LeadBox_btn_color', $spp_LeadBox_btn_color);
			update_option('spp_LeadBox_btn_code', $spp_LeadBox_btn_code);
		}else{
			update_option('spp_LeadBox_btn_checkbox', 0);
		}

		if (isset($_POST['btn_itunes_url'])) {
            $itunes_url = $_POST['btn_itunes_url'];
		    update_option('btn_itunes_url', $itunes_url);
        }
		if (isset($_POST['container_width'])) {
            $container_width = $_POST['container_width'];
		    update_option ('container_width',$container_width);
        }
        if (isset($_POST['minbutton_width'])) {
            $minbutton_width = $_POST['minbutton_width'];
		    update_option ('minbutton_width',$minbutton_width);
        }
        if (isset($_POST['ep_art_select'])) {
            $ep_art_select = $_POST['ep_art_select'];
		    update_option ('ep_art_select', $ep_art_select);
        }
        if (isset($_POST['spp_import_select'])) {
            $spp_import_select = $_POST['spp_import_select'];
		    update_option ('spp_import_select', $spp_import_select);
        }
        if (isset($_POST['spp_imgsize_select'])) {
            $spp_imgsize_select = $_POST['spp_imgsize_select'];
		    update_option ('spp_imgsize_select', $spp_imgsize_select);
        }        
          
        if (isset($_POST['spp_imgalign_select'])) {
            $spp_imgalign_select = $_POST['spp_imgalign_select'];
		    update_option ('spp_imgalign_select', $spp_imgalign_select);
        }
        if (isset($_POST['ep_specific_date'])) {
            $ep_specific_date = $_POST['ep_specific_date'];
		    update_option ('ep_specific_date', $ep_specific_date);
        }
        $podcastURL_Feed = get_option('is_third_party_feed');
		if (isset($_POST['transcript_position'])) {
            $transcript_position = $_POST['transcript_position'];
		    update_option('transcript_position', $transcript_position);
        }
		if (isset($_POST['audio_player_position'])) {
            $audio_player_position = $_POST['audio_player_position'];
		    update_option('audio_player_position', $audio_player_position);
        }
		if (isset($_POST['spp-twitter-handle'])) {
            $spptwitterhandle = $_POST['spp-twitter-handle'];
		    $spptwitterhandle = str_replace('@', '', strip_tags(stripslashes($spptwitterhandle)));
		    update_option('spp-twitter-handle', $spptwitterhandle);
        }
		if (isset($_POST['episode_short_link'])) {
            $episode_short_link = $_POST['episode_short_link'];
		    update_option('episode_short_link', $episode_short_link);
        }
		if (isset($_POST["spp_cat"])) {
              $spp_category = $_POST["spp_cat"]; 
              update_option('spp_post_category', $spp_category);
        }
		if (isset($_POST["spp_author"])) {
            $spp_author = $_POST["spp_author"];
		    update_option('spp_author', $spp_author);
        }
		if (isset($_POST["spp_cpt_select"])) {
            $spp_cpt_select	= $_POST["spp_cpt_select"];
		    update_option('spp_cpt_select', $spp_cpt_select);
        }
		if (isset($_POST["btn_download_color"])) {
            $btn_download_color	= $_POST["btn_download_color"];
		    update_option('btn_download_color', $btn_download_color);
        }
        if (isset($_POST["btn_spplisten_color"])) {
            $btn_spplisten_color = $_POST["btn_spplisten_color"];
		    update_option('btn_spplisten_color', $btn_spplisten_color);
        }
        if (isset($_POST["btn_spprss_color"])) {
            $btn_spprss_color = $_POST["btn_spprss_color"];
		    update_option('btn_spprss_color', $btn_spprss_color);
        }
        if (isset($_POST["btn_sppreview_color"])) {
            $btn_sppreview_color = $_POST["btn_sppreview_color"];
		    update_option('btn_sppreview_color', $btn_sppreview_color);
        }  
		if (isset($_POST["btn_ClammrIT_color"])) {
            $btn_ClammrIT_color = $_POST["btn_ClammrIT_color"];
		    update_option('btn_ClammrIT_color', $btn_ClammrIT_color);
        }  
        if (isset($_POST["btn_sppandroid_color"])) {
            $btn_sppandroid_color = $_POST["btn_sppandroid_color"];
		    update_option('btn_sppandroid_color', $btn_sppandroid_color);
        }  
		if (isset($_POST["player_bar_color"])) {
            $player_bar_color = $_POST["player_bar_color"];
		    update_option('player_bar_color', $player_bar_color);
        }
		if (isset($_POST["progress_bar_color"])) {
            $progress_bar_color	= $_POST["progress_bar_color"];
		    update_option('progress_bar_color', $progress_bar_color);
        }
		if (isset($_POST["player_text_color"])) {
            $player_text_color	= $_POST["player_text_color"];
		    update_option('player_text_color', $player_text_color);
        }
	 	if (isset($_POST["optin_old_code"])) {
              $optin_old_code = stripslashes(htmlspecialchars($_POST["optin_old_code"], ENT_QUOTES));
              update_option('optin_old_code', $optin_old_code);
        }
	 	if (isset($_POST["spp_auto_resp_url"])) {
              $spp_auto_resp_url = htmlspecialchars($_POST["spp_auto_resp_url"], ENT_QUOTES);
              update_option('spp_auto_resp_url', $spp_auto_resp_url);
        }
	 	if (isset($_POST["spp_auto_resp_heading"])) {
              $spp_auto_resp_heading = $_POST["spp_auto_resp_heading"];
              update_option('spp_auto_resp_heading', stripslashes($spp_auto_resp_heading));
        }
	 	if (isset($_POST["spp_auto_resp_sub_heading"])) {
              $spp_auto_resp_sub_heading = $_POST["spp_auto_resp_sub_heading"];
              update_option('spp_auto_resp_sub_heading', stripslashes($spp_auto_resp_sub_heading));
        }     
	 	if (isset($_POST['spp_auto_resp_hidden'])) {
              $spp_auto_resp_hidden = stripslashes(htmlspecialchars($_POST['spp_auto_resp_hidden'], ENT_QUOTES)); 
              update_option('spp_auto_resp_hidden', $spp_auto_resp_hidden);
        }
	 	if (isset($_POST["spp_auto_resp_name"])) {
              $spp_auto_resp_name = $_POST["spp_auto_resp_name"];
              update_option('spp_auto_resp_name', $spp_auto_resp_name);
        }
	 	if (isset($_POST["spp_auto_resp_email"])) {
              $spp_auto_resp_email = $_POST["spp_auto_resp_email"]; 
              update_option('spp_auto_resp_email', $spp_auto_resp_email);
        }
	 	if (isset($_POST["spp_auto_resp_submitt"])) {
              $spp_auto_resp_submitt = $_POST["spp_auto_resp_submitt"]; 
              update_option('spp_auto_resp_submitt', stripslashes($spp_auto_resp_submitt));
        }
		
		
			if (isset($_POST["disable_url_shortner"]) AND ($_POST["disable_url_shortner"] == 'on'))
			{
			update_option('disable_url_shortner', 1);
			}else{
			update_option('disable_url_shortner', 0);
			}
          
            if (isset($_POST["spp_force_player_home"]) AND ($_POST["spp_force_player_home"] == 'on'))
			{
			update_option('spp_force_player_home', 1);
			}else{
			update_option('spp_force_player_home', 0);
			}
          
          
			if (isset($_POST["disable_opengraph"]) AND $_POST["disable_opengraph"] == 'on')
			{
			update_option('disable_opengraph', 1);
			}else{
			update_option('disable_opengraph', 0);
			}
	
          $select_audio_player = 'simplepodcastpressblack';
          
	if (isset($_POST["select_audio_player"]))
          $select_audio_player =  $_POST["select_audio_player"];
          
   


      
            
            
      switch($select_audio_player){
		case 'powerpressplayer'	:
		    update_option('select_audio_player',$select_audio_player);
		    update_option('replace_pp_with_spp', 0);
		
		break;
		case 'simplepodcastpressblack';
		update_option('select_audio_player',$select_audio_player);
		
		// If Raw podcast URL is Libsyn or Soundcloud, just update colour of player and break
		if ($podcastURL_Feed){
			update_option('replace_pp_with_spp', 0);
            //break;
		}
        else {
            update_option('replace_pp_with_spp', 1);
            
        }
		break; 	
		case 'simplepodcastpresswhite' :
		update_option('select_audio_player',$select_audio_player);
		
	
		// If Raw podcast URL is Libsyn or Soundcloud, just update colour of player and break
		if ($podcastURL_Feed){
			update_option('replace_pp_with_spp', 0);
            
		}
		else {
            update_option('replace_pp_with_spp', 1);
            
        }   
            
        break; 
        case 'simplepodcastpresscustomcolor' :
		update_option('select_audio_player',$select_audio_player);
		
	
		// If Raw podcast URL is Libsyn or Soundcloud, just update colour of player and break
		if ($podcastURL_Feed){
			update_option('replace_pp_with_spp', 0);
            //break;
		}
		else {
            update_option('replace_pp_with_spp', 1);
            
        }   
            
        break;     
			
		
		}

        if (isset($_POST["replace_pp_with_spp"]) AND $_POST["replace_pp_with_spp"] == 'on')
		{
            update_option('replace_pp_with_spp', 1);
            
		}
        
        
        elseif (isset($_POST["replace_pp_with_spp"]) AND $_POST["replace_pp_with_spp"] == 'off')
        {

                
            update_option('replace_pp_with_spp', 0);

      if (isset($_POST["powered_by_svp_link"]))
       $powered_by_svp_link = $_POST["powered_by_svp_link"];
		

		}
		if (isset($_POST["spp_optin_box"]) AND $_POST["spp_optin_box"] == 'on')
		{
		update_option('spp_optin_box', 1);
		}else{
		update_option('spp_optin_box', 0);
		}
		if (isset($_POST["btn_download"]) AND $_POST["btn_download"] == 'on')
		{
		update_option('btn_download', 1);
		}else{
		update_option('btn_download', 0);
		}
        
        if (isset($_POST["btn_spplisten"]) AND $_POST["btn_spplisten"] == 'on')
		{
		update_option('btn_spplisten', 1);
		}else{
		update_option('btn_spplisten', 0);
		}  
        if (isset($_POST["btn_spprss"]) AND $_POST["btn_spprss"] == 'on')
		{
		update_option('btn_spprss', 1);
		}else{
		update_option('btn_spprss', 0);
		}  

		if (isset($_POST["btn_sppreview"]) AND $_POST["btn_sppreview"] == 'on')
		{
		update_option('btn_sppreview', 1);
		}else{
		update_option('btn_sppreview', 0);
		}  
        if (isset($_POST["btn_ClammrIT_checkbox"]) AND $_POST["btn_ClammrIT_checkbox"] == 'on')
		{
		update_option('btn_ClammrIT_checkbox', 1);
		}else{
		update_option('btn_ClammrIT_checkbox', 0);
		}  
        if (isset($_POST["btn_sppandroid"]) AND $_POST["btn_sppandroid"] == 'on')
		{
		update_option('btn_sppandroid', 1);
		}else{
		update_option('btn_sppandroid', 0);
		}  
          
		if (isset($_POST["btn_itunes_color"])) {
            $btn_itunes_color	= $_POST["btn_itunes_color"];
		    update_option('btn_itunes_color', $btn_itunes_color);
        }
	if (isset($_POST["transcript"]) AND $_POST["transcript"] == 'on')
		{
		update_option('transcript', 1);
		}else{
		update_option('transcript', 0);
		}
		if (isset($_POST["transcript_txt"])) {
            $transcript_txt	= $_POST["transcript_txt"];
		    update_option('transcript_txt', stripslashes($transcript_txt));
        }
        if (isset($_POST["spp_listen_text"])) {
            $spp_listen_text	= $_POST["spp_listen_text"];
		    update_option('spp_listen_text', stripslashes($spp_listen_text));
        }
		if (isset($_POST["transcript_color"])) {
            $transcript_color = $_POST["transcript_color"];
		    update_option('transcript_color', $transcript_color);
        }
		if (isset($_POST["btn_itunes"]) AND $_POST["btn_itunes"] == 'on')
		{
		update_option('btn_itunes', 1);
		}else{
		update_option('btn_itunes', 0);
		}
		if (isset($_POST["btn_stiticher_color"])) {
            $btn_stiticher_color = $_POST["btn_stiticher_color"];
            update_option('btn_stiticher_color', $btn_stiticher_color);
        }
        if (isset($_POST["btn_stiticher_url"])) {
            $btn_stiticher_url	= $_POST["btn_stiticher_url"];
            update_option('btn_stiticher_url', $btn_stiticher_url);
        }
		if (isset($_POST["btn_stiticher"]) AND $_POST["btn_stiticher"] == 'on')
		{
		update_option('btn_stiticher', 1);
		}else{
		update_option('btn_stiticher', 0);
		}
        
        if (isset($_POST["spp_poweredby_url"])) {
            $spp_poweredby_url = $_POST["spp_poweredby_url"];
		    update_option('spp_poweredby_url', $spp_poweredby_url);
        }
		if (isset($_POST["spp_disable_poweredby"]) AND $_POST["spp_disable_poweredby"] == 'on')
		{
		update_option('spp_disable_poweredby', 1);
		}else{
		update_option('spp_disable_poweredby', 0);
		}



        if (isset($_POST["spp_pre_roll_checkbox"]) AND $_POST["spp_pre_roll_checkbox"] == 'on')
		{

		update_option('spp_pre_roll_checkbox', 1);
        if (isset($_POST["spp_pre_roll_url"])) {
            $spp_pre_roll_url = $_POST["spp_pre_roll_url"];
		    update_option('spp_pre_roll_url', $spp_pre_roll_url);
        }

		}else{

		update_option('spp_pre_roll_checkbox', 0);
		update_option('spp_pre_roll_url', '');
		}


        if (isset($_POST["spp_disable_spp_player_script"]) AND $_POST["spp_disable_spp_player_script"] == 'on')
		{
		update_option('spp_disable_spp_player_script', 1);
		}else{
		update_option('spp_disable_spp_player_script', 0);
		}
		if (isset($_POST["direct_download_button"]) AND $_POST["direct_download_button"] == 'on')
		{
		update_option('direct_download_button', 1);
		}else{
		update_option('direct_download_button', 0);
		}
        
        if (isset($_POST["spp_import_html_desc"]) AND $_POST["spp_import_html_desc"] == 'on')
		{
		update_option('spp_import_html_desc', 1);
		}else{
		update_option('spp_import_html_desc', 0);
		}
          
        if (isset($_POST["spp_autoplay_podcast"]) AND $_POST["spp_autoplay_podcast"] == 'on')
		{
		update_option('spp_autoplay_podcast', 1);
		}else{
		update_option('spp_autoplay_podcast', 0);
		}
		
        if (isset($_POST["twitter_text_color"])) {
            $twitter_text_color	= $_POST["twitter_text_color"];
		    update_option('twitter_text_color', $twitter_text_color);
        }
		if (isset($_POST["submit_button_color"])) {
            $submit_button_color	= $_POST["submit_button_color"];
		    update_option('submit_button_color', $submit_button_color);
        }
		if (isset($_POST["submit_button_text"])) {
            $submit_button_text	= $_POST["submit_button_text"];
		    update_option('submit_button_text', $submit_button_text);
        }
		if (isset($_POST["opt_container_color"])) {
            $opt_container_color	= $_POST["opt_container_color"];
		    update_option('opt_container_color', $opt_container_color);
        }
		if (isset($_POST["btn_soundcloud_color"])) {
              $btn_soundcloud_color	= $_POST["btn_soundcloud_color"];
             update_option('btn_soundcloud_color', $btn_soundcloud_color);
        }
       if (isset($_POST["btn_soundcloud_url"])) {
             $btn_soundcloud_url = $_POST["btn_soundcloud_url"];
             update_option('btn_soundcloud_url', $btn_soundcloud_url);
       }
		
        if (isset($_POST["btn_style_round"]) AND $_POST["btn_style_round"] == 'on')
		{
		update_option('btn_style_round', 1);
		}else{
		update_option('btn_style_round', 0);
        }
          
          
        if (isset($_POST["spp_remove_timecode"]) AND $_POST["spp_remove_timecode"] == 'on')
		{
		update_option('spp_remove_timecode', 1);
		}else{
		update_option('spp_remove_timecode', 0);
        }
            
        if (isset($_POST["spp_flat_player"]) AND $_POST["spp_flat_player"] == 'on')
		{
		update_option('spp_flat_player', 1);
		}else{
		update_option('spp_flat_player', 0);
        }
          
          
        if (isset($_POST["disable_player_excerpt"]) AND $_POST["disable_player_excerpt"] == 'on')
		{
		update_option('spp_hide_player_from_excerpt', 1);
		}else{
		update_option('spp_hide_player_from_excerpt', 0);
		}
		if (isset($_POST["btn_soundcloud"]) AND $_POST["btn_soundcloud"] == 'on')
		{
		update_option('btn_soundcloud', 1);
		}else{
		update_option('btn_soundcloud', 0);
		}
	
		if (isset($_POST["spp_auto_publish"]) AND $_POST["spp_auto_publish"] == 'on')
		{
		update_option('spp_auto_publish', 1);
		}else{
		update_option('spp_auto_publish', 0);
		}
          
       if (isset($_POST["spp_insert_feat_image"]) AND $_POST["spp_insert_feat_image"] == 'on')
		{
		update_option('spp_insert_feat_image', 1);
		}else{
		update_option('spp_insert_feat_image', 0);
		}
          
          
	if (isset($_POST["spp_email_on_draft"]) AND $_POST["spp_email_on_draft"] == 'on')
		{
		update_option('spp_email_on_draft', 1);
		}else{
		update_option('spp_email_on_draft', 0);
		}
        
      if (isset($_POST["spp_player_over_image"]) AND $_POST["spp_player_over_image"] == 'on')
		{
		update_option('spp_player_over_image', 1);
		}else{
		update_option('spp_player_over_image', 0);
		}
          
          
        if (isset($_POST["spp_description"]) AND $_POST["spp_description"] == 'on')
		{
		update_option('spp_description', 1);
		}else{
		update_option('spp_description', 0);
		}
	// Disabling of option to turn on and off thumbnail import
    //  For now never import thumbnail - set it to 1 always
     
	if (isset($_POST["spp_sync_description"]) AND $_POST["spp_sync_description"] == 'on')
		{
		update_option('spp_sync_description', 1);
		}else{
		update_option('spp_sync_description', 0);
		}
		
    $useSppInsteadOfPp = get_option('replace_pp_with_spp');
 
        
        // Keep this check for backwards compatibility to revert back all [spp-player] with [powerpress] 
        if (!$useSppInsteadOfPp) 
        {
                
            $powerpress_posts = $wpdb->get_results("SELECT post_id, meta_value FROM " . $wpdb->prefix . "postmeta WHERE meta_key = 'enclosure'");
            foreach ($powerpress_posts as $ppost){
                if ($ppost->meta_value){
                    $wpdb->query("UPDATE {$wpdb->posts} SET post_content = replace(post_content, '[spp-player]', '[powerpress]') WHERE ID = '$ppost->post_id'");
                }
			 }
		}
        
        
        
        
        
        
        // Only save reviews when the user first types in iTunes URL
        $itunes_url_exists = get_option('itunes_url');
        
        if ( (!empty($itunes_url)) && (empty($itunes_url_exists) ) ) {
            $itunes_ID = $this->get_itunes_ID($itunes_url); 
            update_option('itunes_id',$itunes_ID);
            
            update_option('itunes_url', $itunes_url);    
            $this->spp_save_reviews($itunes_ID);
        }
	
	}
	function get_last_page($pageurl){
		$pageurl = explode('/', $pageurl);
		$pageurl = $pageurl[6];
		$page_number = str_replace("page=","",$pageurl); 
		return $page_number;
	}
	function get_full_country_name($short){
		switch($short){
			case 'us':
				$fullname = 'United States';
			break;
			case 'ca':
				$fullname = 'Canada';
			break;
			case 'la':
				$fullname = 'Puerto Rico"';
			break;
			case 'mx':
				$fullname = 'Mexico';
			break;
			case 'gb':
				$fullname = 'United Kingdom';
			break;
			case 'br':
				$fullname = 'Brazil';
			break;
			case 'tr':
				$fullname = 'Turkey';
			break;
			case 'se':
				$fullname = 'Sweden';
			break;
			case 'fi':
				$fullname = 'Finland';
			break;
			case 'ch':
				$fullname = 'Switzerland';
			break;
			case 'si':
				$fullname = 'Slovenia';
			break;
			case 'at':
				$fullname = 'Austria';
			break;
			case 'pl':
				$fullname = 'Poland';
			break;
			case 'pt':
				$fullname = 'Portugal';
			break;
			case 'ro':
				$fullname = 'Romania';
			break;
			case 'ru':
				$fullname = 'Russia';
			break;
			case 'sk':
				$fullname = 'Slovak Republic';
			break;
			case 'no':
				$fullname = 'Norway';
			break;
			case 'nl':
				$fullname = 'Netherlands';
			break;
			case 'md':
				$fullname = 'Moldova';
			break;
			case 'mt':
				$fullname = 'Malta';
			break;
			case 'hu':
				$fullname = 'Hungary';
			break;
			case 'mk':
				$fullname = 'Macedonia';
			break;		
			case 'lu':
				$fullname = 'Luxembourg';
			break;		
			case 'lt':
				$fullname = 'Lithuania';
			break;		
			case 'lv':
				$fullname = 'Latvia';
			break;		
			case 'it':
				$fullname = 'Italy';
			break;		
			case 'ie':
				$fullname = 'Ireland';
			break;		
			case 'hr':
				$fullname = 'Croatia';
			break;		
			case 'gr':
				$fullname = 'Greece';
			break;		
			case 'fr':
				$fullname = 'France';
			break;		
			case 'es':
				$fullname = 'Spain';
			break;		
			case 'ee':
				$fullname = 'Estonia';
			break;		
			case 'de':
				$fullname = 'Germany';
			break;		
			case 'dk':
				$fullname = 'Denmark';
			break;		
			case 'cz':
				$fullname = 'Czech Republic';
			break;		
			case 'bg':
				$fullname = 'Bulgaria';
			break;		
			case 'be':
				$fullname = 'Belgium';
			break;		
			case 'vn':
				$fullname = 'Vietnam';
			break;		
			case 'th':
				$fullname = 'Thailand';
			break;		
			case 'tw':
				$fullname = 'Taiwan';
			break;		
			case 'sg':
				$fullname = 'Singapore';
			break;		
			case 'ph':
				$fullname = 'Philippines';
			break;		
			case 'nz':
				$fullname = 'New Zealand';
			break;		
			case 'my':
				$fullname = 'Malaysia';
			break;		
			case 'kr':
				$fullname = 'South Korea';
			break;		
			case 'jp':
				$fullname = 'Japan';
			break;		
			case 'id':
				$fullname = 'Indonesia';
			break;		
			case 'hk':
				$fullname = 'Hong Kong';
			break;		
			case 'cn':
				$fullname = 'China';
			break;		
			case 'au':
				$fullname = 'Australia';
			break;		
			case 'ae':
				$fullname = 'United Arab Emirates';
			break;		
			case 'ug':
				$fullname = 'Uganda';
			break;		
			case 'tn':
				$fullname = 'Tunisia';
			break;		
			case 'za':
				$fullname = 'South Africa';
			break;		
			case 'sn':
				$fullname = 'Senegal';
			break;		
			case 'sa':
				$fullname = 'Saudi Arabia';
			break;		
			case 'om':
				$fullname = 'Oman';
			break;		
			case 'ng':
				$fullname = 'Nigeria';
			break;		
			case 'ne':
				$fullname = 'Niger';
			break;		
			case 'mz':
				$fullname = 'Mozambique';
			break;		
			case 'mu':
				$fullname = 'Mauritius';
			break;		
			case 'ml':
				$fullname = 'Mali';
			break;		
			case 'mg':
				$fullname = 'Madagascar';
			break;		
			case 'kw':
				$fullname = 'Kuwait';
			break;		
			case 'ke':
				$fullname = 'Kenya';
			break;		
			case 'jo':
				$fullname = 'Jordan';
			break;		
			case 'il':
				$fullname = 'Israel';
			break;		
			case 'in':
				$fullname = 'India';
			break;		
			case 'gw':
				$fullname = 'Guinea Bissau';
			break;		
			case 'eg':
				$fullname = 'Egypt';
			break;		
			case 'bw':
				$fullname = 'Botswana';
			break;		
			case 'bh':
				$fullname = 'Bahrain';
			break;	
			case 'am':
				$fullname = 'Armenia';
			break;	
	
		}//end switch
	return $fullname;
	}
	function spp_save_reviews($podcastID = ''){
    $isLicenseValid = get_option('sppress_ls');
        
    if ($isLicenseValid !== 'valid') 
    {
        exit;
    }
        
	global $wpdb;
	 $table_spp_reviews	=  $wpdb->prefix . "spp_reviews";
	 $podcastID = get_option('itunes_id'); 
	$countries = 'us, ca, la, br, tr, se, fi, ch, si, at, pl, pt, ro, ru, sk, no, nl, md, mt, hu, mk, lu, lt, lv, it, ie, hr, gr, fr, es, ee, de, dk, cz, bg, be, vn, th, tw, sg, ph, nz, my, kr, jp, id, hk, cn, ae, ug, tn, za, sn, sa, om, ng, ne, mz, mu, ml, mg, kw, ke, jo, il, in, gw, eg, bw, bh, am, gb, mx, au';
    //$countries = 'us';
    
    $countries = explode(',',$countries);
foreach($countries as $country){
		$country = trim(str_replace(" ","",$country));

    $reviews_url = 'http://itunes.apple.com/'.$country.'/rss/customerreviews/id='.$podcastID.'/sortBy=mostRecent/xml';
    

        $xml = $this->url_get_contents($reviews_url);

        
        $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
		$podcast_reviews = simplexml_load_string($xml);
	            
        
        $entry_count_check = 0;
        foreach ($podcast_reviews->entry as $entry){
            $entry_count_check++;
            break; // found an entry which means that url worked
        }
    
        // If first URL didnt work then try with page=1 version of it
        if ($entry_count_check == 0) {

            $reviews_url = 'http://itunes.apple.com/'.$country.'/rss/customerreviews/page=1/id='.$podcastID.'/sortBy=mostRecent/xml';
            
            
            
            $xml = $this->url_get_contents($reviews_url);
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
            $podcast_reviews = simplexml_load_string($xml);
            
            foreach ($podcast_reviews->entry as $entry){
                $entry_count_check++;
                break; // found an entry which means that url worked
            }
            
            
            // If second iTunes URL version failed, try the third version
            if ($entry_count_check == 0) {
               
                $reviews_url = 'http://itunes.apple.com/'.$country.'/rss/customerreviews/id='.$podcastID.'/sortBy=mostRecent/xml?urlDesc=/customerreviews/page=1/id='.$podcastID.'/sortby=mostrecent/xml';
                
                $xml = $this->url_get_contents($reviews_url);
                $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
                $podcast_reviews = simplexml_load_string($xml);
                foreach ($podcast_reviews->entry as $entry){
                    $entry_count_check++;
                    break; // found an entry which means that url worked
                }
            }
        }
    
        
        $pd_last_page = $this->get_last_page($podcast_reviews->link[3]->attributes()->href);
 
            
    
    
	for($i=1; $i <= $pd_last_page; $i++){ 
           
        if ( ( $entry_count_check = 0) || ($i > 1) ) {
     
            $reviews = 'http://itunes.apple.com/'.$country.'/rss/customerreviews/page='.$i.'/id='.$podcastID.'/sortBy=mostRecent/xml';
            $xml = $this->url_get_contents($reviews);
            $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
            $podcast_reviews = simplexml_load_string($xml);
            
            $entry_count_check = 0;
            
            foreach ($podcast_reviews->entry as $entry){
                $entry_count_check++;
                break; // found an entry which means that url worked
            }
            
            
            // If second iTunes URL version failed, try the 2nd version
            if ($entry_count_check == 0) {
                
                // Sleep for a second before trying the next URL
                usleep(1000000);
                
                $reviews = 'http://itunes.apple.com/'.$country.'/rss/customerreviews/page='.$i.'/id='.$podcastID.'/sortBy=mostRecent/xml?urlDesc=/customerreviews/page='.$i.'/id='.$podcastID.'/sortby=mostrecent/xml';
                
                $xml = $this->url_get_contents($reviews);
                $xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
                $podcast_reviews = simplexml_load_string($xml);
                foreach ($podcast_reviews->entry as $entry){
                    $entry_count_check++;
                    break; // found an entry which means that url worked
                }

            }

        }
        $entry_count = 0;
        
        
        foreach ($podcast_reviews->entry as $entry){  
		  
            $rw_id  = $entry->id;
            
            if ($entry_count > 0)   
					{
						$query = $wpdb->prepare("SELECT rw_id FROM {$table_spp_reviews} WHERE rw_id=%s", $rw_id);	  
						$is_in_db = $wpdb->get_var($query);
						if(!$is_in_db){ 
							$updated  = $entry->updated;
							$title  = $entry->title;
							$content  = $entry->content[0];
							$imrating  = $entry->imrating; 
							$author  = $entry->author->name;
								
								$data = array(
											'rw_id' => $rw_id,
											'rw_coutry' => $country,
											'rw_published_date' => $updated,
											'rw_title' => $title,
											'rw_text' => $content,
											'rw_ratings' => $imrating,
											'rw_author' => $author
											);
																
							$inserted = $wpdb->insert($table_spp_reviews, $data );
						} //end if
				 }//endif
            
            $entry_count = $entry_count + 1;
            
			}//end foreach podcast_review
		}//end for
	}//end foreach countries
	}
    
	 
    function spp_save_podcast_xml($podcastURL, $manul_import = false){
		global $wpdb;
		$inserted  = false;
        $duplicate = false;
        $html = '';
          
        $table_spp_podcast	=  $wpdb->prefix . "spp_podcast";

        // Clammr button on by default
        update_option('btn_ClammrIT_checkbox', 1);    

        $xml = $this->url_get_contents($podcastURL);
        
        $itunes_xml = preg_replace("/(<\/?)(\w+):([^>]*>)/", "$1$2$3", $xml);
		$podcastXML = simplexml_load_string($itunes_xml);
        $channel_keywords = $podcastXML->channel->ituneskeywords;
		$channel_keywords =	explode(',' , $channel_keywords); 
		$channel_keywords = serialize ($channel_keywords);
		update_option('channel_keywords',$channel_keywords);
		$channel_image = (string)$podcastXML->channel->image->url; 
		$channel_image_url = (string)$podcastXML->channel->image->url;
        $import_html_desc = get_option('spp_import_html_desc');
       
        
        $LibsynPostImage = get_option('ep_art_select');
        if ($LibsynPostImage == '2')  
            $useLibsynPostImage = true;
        else
            $useLibsynPostImage = false;
            
                
		$pp_counter = 0;
		foreach ($podcastXML->channel->item as $item){
	
			$title = $item->title;
			$pub_date = $item->pubDate;
			
            
            if ($import_html_desc) {
                  $description = $item->contentencoded;
                  if (empty($description))
                        $description = $item->itunessummary;
              }
            else
                  $description = $item->description;
                  


			if ($item->enclosure){			

			$audio_file = $item->enclosure->attributes()->url;  

			}else{

			continue;

			}

			$audio_duration = $item->itunesduration;
			$audio_length = $item->enclosure->attributes()->length; 
			$episode_keywords = $item->ituneskeywords;
            $pc_libsyn_image = '';
            
      
            if ($item->itunesimage) {
                $episode_image = $item->itunesimage->attributes()->href; 
            }
		$duplicate = $wpdb->get_row("SELECT * FROM " . $table_spp_podcast . " WHERE pc_audio_file = '$audio_file'");            	
           // Logic for Libsyn image only     
		if  ( ($useLibsynPostImage) and ($manul_import) ) {
            
             $episode_link = $item->link;
             if ( strpos($episode_link, '.mp3') )
                   break;
             require_once('tools/simple_html_dom.php');
             $response = wp_remote_get($episode_link);
             $html = wp_remote_retrieve_body($response);
             $html=str_get_html($html);
             
            if ($html) {
                $pc_libsyn_image = $html->find('img[class=postImage]', 0)->src;
                $html->clear(); 
            }

            
            
            if ( ($manul_import) AND ($duplicate) ){
                  if (empty($duplicate->pc_libsyn_image)){
                      $updated = $wpdb->update( $table_spp_podcast,																		
                                                array(		
                                                            'pc_libsyn_image' => $pc_libsyn_image
                                                    ), 
                                                array(
                                                            'pc_audio_file' => $duplicate->pc_audio_file,
                                                    ) );
                    }//end if $pc_libsyn_image
                   continue;	
                }//end if $manual_import
            }

		
              if (!$duplicate->pc_audio_file){
				
							$data = array(
							'pc_title' => $title,
							'pc_published_date' => $pub_date,
							'pc_description' => $description,
							'pc_audio_file' => $audio_file,
							'pc_audio_duration' => $audio_duration,
							'pc_audio_length' => $audio_length,
							'pc_episode_keywords' => $episode_keywords,
							'pc_episode_image' => $episode_image,
                            'pc_libsyn_image' => $pc_libsyn_image
							);						
  
                                $inserted = $wpdb->insert($table_spp_podcast, $data );
				}
            
                
	
				if ($inserted){
		
				$pp_counter++;
		
				}//endif
		}//end foreach
	
	return $pp_counter;
}


	function register_spp_admin_scripts( $hook ) {
		if ( (isset($_GET['page'])) AND ($_GET['page'] == 'spp-podcast-settings' or $_GET['page'] == 'spp_reviews' or $_GET['page'] == 'spp-url-shortner') ){
	    wp_enqueue_style( 'wp-color-picker' );
		wp_enqueue_script('jquery-ui-datepicker');
		wp_enqueue_style('jquery-ui-css', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.2/themes/smoothness/jquery-ui.css');
	    wp_enqueue_script( 'spp-admin-script', SPPRESS_PLUGIN_URL . '/spp_view/js/spp_admin_scripts.js', array( 'wp-color-picker' ), false, true );
		wp_register_style( 'spp_wp_admin_css_bootstrap', SPPRESS_PLUGIN_URL . '/spp_view/css/bootstrap.css', false, '1.0.0' );
		wp_register_style( 'spp_wp_admin_css_bootstrap_responsive', SPPRESS_PLUGIN_URL . '/spp_view/css/bootstrap-responsive.css', false, '1.0.0' );
		wp_register_style( 'spp_wp_admin_css_common', SPPRESS_PLUGIN_URL . '/spp_view/css/common.css', false, '1.0.0' );
		wp_register_style( 'spp_wp_admin_css_fontawesome', SPPRESS_PLUGIN_URL . '/spp_view/css/fontawesome.css', false, '1.0.0' );
		wp_register_style( 'spp_wp_admin_css', SPPRESS_PLUGIN_URL . '/spp_view/css/spp-admin.css', false, '1.0.0' );
        wp_enqueue_style( 'spp_wp_admin_css_bootstrap' );
        wp_enqueue_style( 'spp_wp_admin_css_bootstrap_responsive' );
        wp_enqueue_style( 'spp_wp_admin_css_common' );
        wp_enqueue_style( 'spp_wp_admin_css_fontawesome' );
        wp_enqueue_style( 'spp_wp_admin_css_project' );
        wp_enqueue_style( 'spp_wp_admin_css' );
		wp_enqueue_script( 'spp_wp_admin_js_bootstrap_min', SPPRESS_PLUGIN_URL . '/spp_view/js/bootstrap.min.js', false, null, true);
		}
		
		if ( 'widgets.php' != $hook )
			return;
		}
		function preserve_draft_date($post){
			$release_date = get_post_meta($post->ID,'_release_date',TRUE);
			
			if ($release_date && $post->post_date != date('Y-m-d H:i:s',strtotime($release_date)) ){
				$post->edit_date = date('Y-m-d H:i:s',strtotime($release_date));
				$post->post_date = date('Y-m-d H:i:s',strtotime($release_date));
				wp_update_post($post);
			}
		}
		function makeClickableLinks($text){
			$text = preg_replace('/(((f|ht){1}tp:\/\/)[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '<a href="\\1" rel="nofollow">\\1</a>'.PHP_EOL, $text);
			$text = preg_replace('/([[:space:]()[{}])(www.[-a-zA-Z0-9@:%_\+.~#?&\/\/=]+)/i', '\\1<a href="<a href="http://" rel="nofollow">http://</a>'.PHP_EOL.'\\2" >\\2</a>'.PHP_EOL, $text);
			$text = preg_replace('/([_\.0-9a-z-]+@([0-9a-z][0-9a-z-]+\.)+[a-z]{2,3})/i', '<a href="mailto:\\1" rel="nofollow">\\1</a>'.PHP_EOL, $text);
			return $text;
		}
		function remove_evil_styles_v2($tag_source)
			{

			  $evil_styles = array('font','font-family','font-face','font-size','font-size-adjust','font-stretch','font-variant','line-height', 'margin-top', 'margin-bottom');
			  $evil_style_pttrns = array();
			  foreach ($evil_styles as $v)
			    $evil_style_pttrns[]= '/'.$v.'\s*:\s*[^;"]*;?/';
			  return preg_replace($evil_style_pttrns,'',$tag_source);
			}
		function generate_post_from_spp_table() {
					global $wpdb;
              
                	$table_spp_podcast	=  $wpdb->prefix . "spp_podcast";
					$counterposts = 0;
				    $podcast_URL = get_option('podcast_url');
                    $spp_channel_image = get_option('channel_image');
                    $this->spp_save_podcast_xml($podcast_URL, true);
					update_option('post_inserted', 0);
					$podcast_items = $wpdb->get_results("SELECT * FROM " . $table_spp_podcast );
						$totalvids = count($podcast_items);
							foreach ($podcast_items as $podcast_item) {
								$audio_file=$podcast_item->pc_audio_file;
								
								$post_meta = $wpdb->get_row("SELECT * FROM " . $wpdb->prefix . "postmeta WHERE meta_value = '$audio_file' ");
								
									if (!empty($post_meta->meta_value)) {
						
										continue;
									}
									
								$pcTitle=$podcast_item->pc_title;
						
			                    $slugarray = preg_split("/[\s,]+/", $pcTitle);
			
                                foreach ($slugarray as $slugelement) {
                                    $episode_number = preg_replace('~[^0-9]~','',$slugelement);
                                    $episode_number = intval($episode_number);
                                    if ($episode_number !== 0)
                                       break;
                                }
                                
                                
                                $spp_description	= get_option('spp_description');
								$audio_duration = $podcast_item->pc_audio_duration;
								$audio_player_position =  get_option('audio_player_position');
								$transcript_position =  get_option('transcript_position');
							if ( $spp_description == 0)
								{
									$pc_description	= $podcast_item->pc_description;
									$pc_description = $this->remove_evil_styles_v2($pc_description);
									$pc_description = make_clickable($pc_description);
								}//end if
								$audioUrl= $podcast_item->pc_audio_file;
								$ep_art_select = get_option ('ep_art_select');
							switch ($ep_art_select){
								case 1:
                                  $thumbnail=$podcast_item->pc_episode_image;
								break;
								case 2:
                                  $thumbnail=$podcast_item->pc_libsyn_image;
								break;
                                
                                case 3:
                                  $thumbnail=$spp_channel_image;
								break;
							}
								
								$tags = explode(' ,', $podcast_item->pc_episode_keywords);
								$publishedate = $podcast_item->pc_published_date;
								$spp_import_select = get_option('spp_import_select');
								if($spp_import_select == 2){
									$ep_specific_date = strtotime(get_option('ep_specific_date'));
									$publish_date = strtotime($publishedate);
									if ($publish_date <= $ep_specific_date){
										continue;
									}
								}
								$PublishDate = date("Y-m-d H:i:s", strtotime($publishedate));
								$auto_post = get_option('spp_auto_publish');
                                $no_import = get_option('spp_import_select');
								
								$cpt_select = get_option('spp_cpt_select');
								$author = get_option('spp_author');
								
									$category = get_option('spp_post_category');
									
									if ($auto_post) {
										$my_post = array(       'post_title'    => $pcTitle,       'post_content'  => $pc_description,  'post_date'     =>  $PublishDate,         'post_status'   => 'publish',  'post_category' =>  array($category),       'post_author'   => $author,       'post_type'  => $cpt_select,  'tags_input'  =>  $tags     );
									} else {
										$my_post = array(       'post_title'    => $pcTitle,       'post_content'  => $pc_description,  'post_date'     =>  $PublishDate,         'post_status'   => 'draft',  'post_category' =>  array($category),       'post_author'   => $author,       'post_type'  => $cpt_select,  'tags_input'  =>  $tags     );
									}
									//	Insert the post into the database
									$post_id = wp_insert_post($my_post);
								
					add_post_meta( $post_id, '_audiourl', $audioUrl, true ) || update_post_meta($post_id, '_audiourl', $audioUrl);
$disable_url_shortner = get_option('disable_url_shortner');
					if (!$disable_url_shortner){
									$permellink = get_permalink( $post_id ); 
									$table_spp_links	=  $wpdb->prefix . "spp_links";
									
                                //$myPcTitle = $my_post->pcTitle;
                                
                                
                                $pcTitle = get_the_title($post_id);
                                $slugarray = preg_split("/[\s,]+/", $pcTitle);
			
                                foreach ($slugarray as $slugelement) {
                                    $episode_number = preg_replace('~[^0-9]~','',$slugelement);
                                    $episode_number = intval($episode_number);
                                    if ($episode_number !== 0)
                                       break;
                                }
                                
                                
                               
									if ($episode_number == 0){

									}
									$slug = get_option('episode_short_link') . $episode_number;
									$is_available = $this->spp_slugIsAvailable($slug);
									
                                    $data = array();
                                
                                    if ($is_available){
										$data = array(
			
										'spp_name' => $pcTitle,
										'spp_url' => $permellink,
										'spp_slug' => $slug,
										'spp_post_id' => $post_id
										
										);
                                        
                                        
                                        
                                        $slugAlreadyInDB = $wpdb->get_row("SELECT * FROM $wpdb->links WHERE spp_slug = ".$slug);
                                        if ($slugAlreadyInDB)
                                        {
                                            $wpdb->update( 
                                                $table_spp_links, 
                                                $data, 
                                                array( 'spp_slug' => $slug ) 
                                                
                                            );
                                        }
                                        else
                                            $wpdb->insert($table_spp_links, $data );
									}
												
					}//end if 				
									add_post_meta( $post_id, '_audioduration', $audio_duration, true ) || update_post_meta($post_id, '_audioduration', $audio_duration);
									$counterposts++;
									 

									$disable_thumbs = get_option('spp_disable_thumbs');
						
									add_post_meta( $post_id, '_release_date', $PublishDate, true ) || update_post_meta($post_id, '_release_date', $PublishDate);
                                    // Set FB Open Graph Image.  Overright with thumbnail below if it exists
                                    $fbImage = get_option('channel_image');
                                
									if (!empty($thumbnail)){

                                    //	Set feature image for post
									$upload_dir=wp_upload_dir();
                                    $image_data=$this->url_get_contents($thumbnail);    
                                    
                                    $image_array=explode('.',$thumbnail);
									$total_img=count( $image_array );
									$ext=end( $image_array );
									unset($image_array[$total_img-1]);
									$pcTitleWithDashes = preg_replace('/\%/',' percentage',$pcTitle);
									$pcTitleWithDashes = preg_replace('/\@/',' at ',$pcTitleWithDashes);
									$pcTitleWithDashes = preg_replace('/\&/',' and ',$pcTitleWithDashes);
									$pcTitleWithDashes = preg_replace('/\]/',' - ',$pcTitleWithDashes);
									$pcTitleWithDashes = preg_replace('/\[/',' - ',$pcTitleWithDashes);
									$pcTitleWithDashes = preg_replace('/\+/',' - ',$pcTitleWithDashes);
									$pcTitleWithDashes = preg_replace('/\s[\s]+/','-',$pcTitleWithDashes);
									
                                    // Strip off multiple spaces 
									$pcTitleWithDashes = preg_replace('/[\s\W]+/','-',$pcTitleWithDashes);
									
                                    // Strip off spaces and non-alpha-numeric 
									$pcTitleWithDashes = preg_replace('/^[\-]+/','',$pcTitleWithDashes);
									
                                    // Strip off the starting hyphens 
									$pcTitleWithDashes = preg_replace('/[\-]+$/','',$pcTitleWithDashes);
									
                                    // Strip off the ending hyphens 
									$pcTitleWithDashes = strtolower($pcTitleWithDashes);
									$new_file=$pcTitleWithDashes.$i.'_thumbnail.'.$ext;
                                    //If Libsyn Image Import then always add PNG extension
                                    if ($ep_art_select == 2)
                                          $new_file=$pcTitleWithDashes.$i.'_thumbnail.png';
									$filename=basename($new_file);
									
									// TODO: Check if image already exists in Media library and don't reupload it
                                          
                                    if(wp_mkdir_p($upload_dir['path']))$file = $upload_dir['path'] . '/' . $filename; else $file = $upload_dir['basedir'] . '/' . $filename;
                                          $spp_channelart_upload = file_put_contents($file, $image_data);
                                          if (!$spp_channelart_upload) {
                                                global $wp_filesystem;
                                                // protect if the the global filesystem isn't setup yet
                                                if( is_null( $wp_filesystem ) )
                                                      WP_Filesystem();
                                                $wp_filesystem->put_contents($file, $image_data, FS_CHMOD_FILE);
                                          }
              
									$wp_filetype = wp_check_filetype($filename, null );
									$attachment = array('post_mime_type' => $wp_filetype['type'],'post_title' => sanitize_file_name($filename),'post_content' => '','post_status' => 'inherit');
									$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
									require_once(ABSPATH . 'wp-admin/includes/image.php');
									$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
									wp_update_attachment_metadata( $attach_id, $attach_data );
									set_post_thumbnail( $post_id, $attach_id );
									//	End of setting feature image
                                        
                                    $fbImage = $thumbnail;
                                         
                                          
									}
									
                                    
                              
                                    $sppogp = get_post_meta($post_id,'OGP', true );
									$sppogp["title"] = get_the_title( $post_id );
                                    $sppogp["image"] = $fbImage;
	                 				update_post_meta( $post_id,'OGP', $sppogp );
											
									// End of Setting Facebook Image Post-specific OpenGraph Tags
								
							}//end foreach
					
						
						
				echo	$counterposts;
die();
				}//end function
	function spp_pannel(){
	$refID = get_option('spp_poweredby_url');
	if(isset($_POST['spp_cbsn_reset']))
	{
		global $wpdb;
		$table_spp_podcast	=  $wpdb->prefix . "spp_podcast";
		$table_spp_reviews	=  $wpdb->prefix . "spp_reviews";
		$sql0='DROP TABLE IF EXISTS '. $table_spp_podcast;
		$wpdb->query($sql0);
		$sql1='DROP TABLE IF EXISTS '. $table_spp_reviews;
		$wpdb->query($sql1);

		update_option('spp_channel_image','');
		update_option('podcast_url','');
		update_option('itunes_url','');

		$this->delete_spp_settings();
		
	}//end if 
		global $wpdb;
		
		$spp_auto_publish	=	get_option('spp_auto_publish');
        $spp_insert_feat_image	=	get_option('spp_insert_feat_image');
	 	$spp_email_on_draft	=	get_option('spp_email_on_draft');
        $spp_player_over_image	=	get_option('spp_player_over_image');
         
	
	
		$spp_description	=	get_option('spp_description'); 
	
	
		$spp_category			=	get_option('spp_post_category');
		$spp_sync_description = 	get_option('spp_sync_description');
		$spp_autoplay_podcast = 	get_option('spp_autoplay_podcast');
        
        $spp_optin_box1 = get_option('spp_optin_box');
		$spp_two_step_optin = get_option('spp_two_step_optin');
		$spp_two_step_optin_selected1 = ($spp_two_step_optin == 1) ? 'selected=selected' : '';
		$spp_two_step_optin_selected2 = ($spp_two_step_optin == 2) ? 'selected=selected' : '';
		$spp_two_step_optin_selected3 = ($spp_two_step_optin == 3) ? 'selected=selected' : '';
		$spp_two_step_optin_selected4 = ($spp_two_step_optin == 4) ? 'selected=selected' : '';
		
	
		//start custom post type dropdown
		$post_types = get_post_types( array('_builtin' => false,'public' => true ) ); 
		$spp_cpt_select = get_option('spp_cpt_select');
		
		$spp_cpt_dropdown = '<select name="spp_cpt_select">';
		if ($spp_cpt_select == 'post' or empty($spp_cpt_select)){
        $spp_cpt_dropdown .= "<option value='post' selected='selected'>Standard Post (Default)</option>";
		}else{
        $spp_cpt_dropdown .= "<option value='post'>Standard Post (Default)</option>";
		}
		foreach ( $post_types as $post_type ) {
			if ($spp_cpt_select == $post_type){
			
			   $spp_cpt_dropdown .= "<option value='".$post_type ."' selected='selected'>".$post_type ."</option>";
	
			}else{
			   $spp_cpt_dropdown .= "<option value='".$post_type ."'>".$post_type ."</option>";
	
			}
		}
		 $spp_cpt_dropdown .= '</select>';

$podcast_xml = get_option('podcast_url');
$btn_itunes_url = get_option('btn_itunes_url');
$isLicenseValid = get_option('sppress_ls');
        
if ($isLicenseValid == 'valid') 
{
        if (empty($podcast_xml)) {
        $html = '
        <h2>Simple Podcast Press</h2>
        <br class="clear" />';
          $html .= ' 						
                                <p><b>'.__("Enter iTunes Url:&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;", 'spp').' </b><input class="span5" type="text" name="podcast_url" value="" size="61"></p>or
								<p><b>'.__("Enter Podcast Feed:&nbsp;", 'spp').' </b><input class="span5" type="text" name="podcast_xml" value="" size="61" placeholder="this feed must be iTunes compatible"></p>
                                &nbsp;&nbsp;
                                <p><strong>Note: Depending on how many episodes and reviews you have, it may take several minutes to analyze your Podcast Channel.
                                <table>
                                <tr><td>
                                <input type="submit" id="podcast_url" class="button button-primary" name="save_podcast_url" value="'.__("Save", 'spp').'"/>
                                <input style="display:none;" type="submit" id="delete_settings" class="button button-secondary" name="delete_settings" value="'.__("Delete", 'spp').'"/>
                                <input type="submit" class="btn btn-primary" name="cbsn_save" id="cbsn_save" value="Save Changes" style="display:none;">
                                <input type="submit" class="btn" name="chk_new_vids" id="chk_new_vids" value="Import New podcasts Now" style="display:none;">
                                <input type="submit" name="manual_update" class="btn" id="fetch_comments" value="Import New Comments Now" style="display:none;">
                                </td><td class="save_access_spinning">
                                </td>
                                </tr>
                                </table>
                        </div>';
        } else {
        

         $powerpressplayer = '';
        $simplepodcastpressblack = '';
        $spp_disable_thumbs = get_option('spp_disable_thumbs');
        $spp_auto_publish1 = ($spp_auto_publish == 1) ? 'checked' : ''; 
        $spp_insert_feat_image1 = ($spp_insert_feat_image == 1) ? 'checked' : '';
	
		$disable_url_shortner = get_option('disable_url_shortner');
        $disable_url_shortner = ($disable_url_shortner == 1) ? 'checked' : ''; 
              
        $spp_force_player_home = get_option('spp_force_player_home');
        $spp_force_player_home = ($spp_force_player_home == 1) ? 'checked' : ''; 
              
		$disable_opengraph = get_option('disable_opengraph');
        $disable_opengraph = ($disable_opengraph == 1) ? 'checked' : ''; 
        $spp_draft_row_display = ($spp_auto_publish == 1) ? 'display:none;' : ''; 
        $spp_feat_image_settings_display = ($spp_insert_feat_image == 0) ? 'display:none;' : '';
        $spp_email_on_draft = ($spp_email_on_draft == 1) ? 'checked' : ''; 
        $spp_player_over_image = ($spp_player_over_image == 1) ? 'checked' : ''; 
        $spp_description = ($spp_description == 1) ? 'checked' : '';  
        
              
        $replace_pp_with_spp = get_option('replace_pp_with_spp');
        $replace_pp_with_spp = ($replace_pp_with_spp == 1) ? 'checked' : '';
        $spp_replace_with_spp_display = ($replace_pp_with_spp == 0) ? 'display:none;' : '';
        $replace_ppplayer_with_spp = get_option('replace_ppplayer_with_spp');
        $replace_ppplayer_with_spp = ($replace_ppplayer_with_spp == 1) ? 'checked' : '';
        $replace_wp_with_spp = get_option('replace_wp_with_spp');
        $replace_wp_with_spp = ($replace_wp_with_spp == 1) ? 'checked' : '';
        $replace_stp_with_spp = get_option('replace_stp_with_spp');
        $replace_stp_with_spp =($replace_stp_with_spp == 1) ? 'checked' : '';
        $spp_autoplay_podcast = ($spp_autoplay_podcast == 1) ? 'checked' : '';
            
        $spp_sync_description =($spp_sync_description == 1) ? 'checked' : '';
        $spp_disable_thumbs =($spp_disable_thumbs == 1) ? 'checked' : '';
        $btn_download = get_option('btn_download');
        $btn_download =($btn_download == 1) ? 'checked' : '';
              
        $btn_spplisten = get_option('btn_spplisten');
        $btn_spplisten =($btn_spplisten == 1) ? 'checked' : '';      
        $btn_spprss = get_option('btn_spprss');
        $btn_spprss =($btn_spprss == 1) ? 'checked' : '';  
        $btn_sppreview = get_option('btn_sppreview');
        $btn_sppreview =($btn_sppreview == 1) ? 'checked' : '';       
		$btn_ClammrIT_checkbox = get_option('btn_ClammrIT_checkbox');
        $btn_ClammrIT_checkbox =($btn_ClammrIT_checkbox == 1) ? 'checked' : '';        
        $btn_sppandroid = get_option('btn_sppandroid');
        $btn_sppandroid =($btn_sppandroid == 1) ? 'checked' : '';  
              
        $btn_itunes = get_option('btn_itunes');
        $btn_itunes =($btn_itunes == 1) ? 'checked' : '';
        $btn_stiticher = get_option('btn_stiticher');
        $btn_stiticher =($btn_stiticher == 1) ? 'checked' : '';
        $spp_disable_poweredby = get_option('spp_disable_poweredby');
        $spp_disable_poweredby =($spp_disable_poweredby == 1) ? 'checked' : '';

		$spp_pre_roll_url = get_option('spp_pre_roll_url');

		$spp_pre_roll_checkbox = get_option('spp_pre_roll_checkbox');
        $spp_pre_roll_checkbox =($spp_pre_roll_checkbox == 1) ? 'checked' : '';

        $spp_disable_spp_player_script = get_option('spp_disable_spp_player_script');
        $spp_disable_spp_player_script =($spp_disable_spp_player_script == 1) ? 'checked' : '';
        $direct_download_button = get_option('direct_download_button');
        $direct_download_button =($direct_download_button == 1) ? 'checked' : '';
        $spp_import_html_desc = get_option('spp_import_html_desc');
        $spp_import_html_desc =($spp_import_html_desc == 1) ? 'checked' : '';
        $btn_soundcloud = get_option('btn_soundcloud');
        $btn_soundcloud =($btn_soundcloud == 1) ? 'checked' : '';
        $btn_style_round = get_option('btn_style_round');
        $btn_style_round =($btn_style_round == 1) ? 'checked' : '';
        $spp_remove_timecode = get_option('spp_remove_timecode');
        $spp_remove_timecode =($spp_remove_timecode == 1) ? 'checked' : '';
        $spp_flat_player = get_option('spp_flat_player');
        $spp_flat_player =($spp_flat_player == 1) ? 'checked' : '';
        $disable_player_excerpt  = get_option('spp_hide_player_from_excerpt');
        $disable_player_excerpt  =($disable_player_excerpt == 1) ? 'checked' : '';
        $transcript = get_option('transcript');
        $transcript =($transcript == 1) ? 'checked' : '';
		$player_bar_color = get_option('player_bar_color');
		$progress_bar_color = get_option('progress_bar_color');
		$player_text_color = get_option('player_text_color');
        $twitter_text_color = get_option('twitter_text_color');
        $submit_button_color = get_option('submit_button_color');
        $submit_button_text = get_option('submit_button_text');
        $opt_container_color = get_option('opt_container_color');
        $btn_download_color = get_option('btn_download_color');
        $btn_spplisten_color = get_option('btn_spplisten_color');
        $btn_spprss_color = get_option('btn_spprss_color');
        $btn_sppreview_color = get_option('btn_sppreview_color');
		$btn_ClammrIT_color = get_option('btn_ClammrIT_color');
        $btn_sppandroid_color = get_option('btn_sppandroid_color');
        $btn_itunes_color = get_option('btn_itunes_color');
        $btn_stiticher_color = get_option('btn_stiticher_color');
        $btn_soundcloud_color = get_option('btn_soundcloud_color');
        $transcript_txt = get_option('transcript_txt');
        if (empty($transcript_txt)) {
            $transcript_txt = "Read Full Transcript";
        }
        $spp_listen_text = get_option('spp_listen_text');
 
        $transcript_color = get_option('transcript_color');
        $btn_stiticher_url = get_option('btn_stiticher_url');
        $spp_poweredby_url = get_option('spp_poweredby_url');
        $btn_soundcloud_url = get_option('btn_soundcloud_url');
        $spp_optin_box1 = get_option('spp_optin_box');
        $spp_optin_box = ($spp_optin_box1 == 1) ? 'checked' : '';
        $spp_optin_row_display = ($spp_optin_box1 == 0) ? '' : ''; 
        $optin_old_code_get = get_option('optin_old_code');
        $spp_auto_resp_url_get = get_option('spp_auto_resp_url');
        $spp_auto_resp_heading_get = get_option('spp_auto_resp_heading');
        $spp_auto_resp_sub_heading_get = get_option('spp_auto_resp_sub_heading');
        $spp_auto_resp_hidden_get = get_option('spp_auto_resp_hidden');
        $spp_auto_resp_name_get = get_option('spp_auto_resp_name');
        $spp_auto_resp_email_get = get_option('spp_auto_resp_email');
        $spp_auto_resp_submitt_get = get_option('spp_auto_resp_submitt');
        $spptwitterhandle =  get_option('spp-twitter-handle');
        $episode_short_link =  get_option('episode_short_link');
              
		$btn_spp_custom1 = get_option('btn_spp_custom1');
		$btn_spp_custom1 =($btn_spp_custom1 == 1) ? 'checked' : '';
		$btn_spp_custom2 = get_option('btn_spp_custom2');
		$btn_spp_custom2 =($btn_spp_custom2 == 1) ? 'checked' : '';
		$btn_spp_custom3 = get_option('btn_spp_custom3');
		$btn_spp_custom3 =($btn_spp_custom3 == 1) ? 'checked' : '';
        $btn_spp_custom4 = get_option('btn_spp_custom4');
		$btn_spp_custom4 =($btn_spp_custom4 == 1) ? 'checked' : '';
        $btn_spp_custom5 = get_option('btn_spp_custom5');
		$btn_spp_custom5 =($btn_spp_custom5 == 1) ? 'checked' : '';
        $btn_spp_custom6 = get_option('btn_spp_custom6');
		$btn_spp_custom6 =($btn_spp_custom6 == 1) ? 'checked' : '';
        $spp_LeadBox_btn_checkbox = get_option('spp_LeadBox_btn_checkbox');
		$spp_LeadBox_btn_checkbox =($spp_LeadBox_btn_checkbox == 1) ? 'checked' : '';


              
		$btn_spp_custom_color1 = get_option('btn_spp_custom_color1');
		$btn_spp_custom_color2 = get_option('btn_spp_custom_color2');
		$btn_spp_custom_color3 = get_option('btn_spp_custom_color3');
        $btn_spp_custom_color4 = get_option('btn_spp_custom_color4');
		$btn_spp_custom_color5 = get_option('btn_spp_custom_color5');
		$btn_spp_custom_color6 = get_option('btn_spp_custom_color6');
		$spp_LeadBox_btn_color = get_option('spp_LeadBox_btn_color');

              
		$btn_spp_custom_url1 = get_option('btn_spp_custom_url1');
		$btn_spp_custom_url2 = get_option('btn_spp_custom_url2');
		$btn_spp_custom_url3 = get_option('btn_spp_custom_url3');
        $btn_spp_custom_url4 = get_option('btn_spp_custom_url4');
		$btn_spp_custom_url5 = get_option('btn_spp_custom_url5');
		$btn_spp_custom_url6 = get_option('btn_spp_custom_url6');
		$spp_LeadBox_btn_code = get_option('spp_LeadBox_btn_code');
              
		$btn_spp_custom_name1 = get_option('btn_spp_custom_name1');
		$btn_spp_custom_name2 = get_option('btn_spp_custom_name2');
		$btn_spp_custom_name3 = get_option('btn_spp_custom_name3');
        $btn_spp_custom_name4 = get_option('btn_spp_custom_name4');
		$btn_spp_custom_name5 = get_option('btn_spp_custom_name5');
		$btn_spp_custom_name6 = get_option('btn_spp_custom_name6');
              
        $ep_art_select =  get_option('ep_art_select');
        $ep_art_select1 = ($ep_art_select == 0) ? 'selected=selected' : '';
        $ep_art_select2 = ($ep_art_select == 1) ? 'selected=selected' : '';
        $ep_art_select3 = ($ep_art_select == 2) ? 'selected=selected' : '';
        $ep_art_select4 = ($ep_art_select == 3) ? 'selected=selected' : '';
        $spp_import_select =  get_option('spp_import_select');
        
        
            
        $noImportLegacy = get_option('spp_no_import');
        if ($noImportLegacy) {
            $spp_import_select = 1;
            update_option('spp_no_import',0);
        }
        
        $spp_import_selected1 = ($spp_import_select == 0) ? 'selected=selected' : '';
        $spp_import_selected2 = ($spp_import_select == 1) ? 'selected=selected' : '';
        $spp_import_selected3 = ($spp_import_select == 2) ? 'selected=selected' : '';
              
        $spp_imgsize_select =  get_option('spp_imgsize_select');
        $spp_imgsize_selected1 = ($spp_imgsize_select == 'thumbnail') ? 'selected=selected' : '';
        $spp_imgsize_selected2 = ($spp_imgsize_select == 'medium') ? 'selected=selected' : '';
        $spp_imgsize_selected3 = ($spp_imgsize_select == 'large') ? 'selected=selected' : '';
        $spp_imgsize_selected4 = ($spp_imgsize_select == 'full') ? 'selected=selected' : '';
         
        $spp_imgalign_select =  get_option('spp_imgalign_select');
        $spp_imgalign_selected1 = ($spp_imgalign_select == 'alignleft') ? 'selected=selected' : '';
        $spp_imgalign_selected2 = ($spp_imgalign_select == 'aligncenter') ? 'selected=selected' : '';
        $spp_imgalign_selected3 = ($spp_imgalign_select == 'alignright') ? 'selected=selected' : '';
        $spp_imgalign_selected4 = ($spp_imgalign_select == 'alignnone') ? 'selected=selected' : '';
              
		$ep_specific_date = get_option('ep_specific_date');
        $date_textbox_display = ($spp_import_select == 2) ? 'display:block;' : 'display:none;';
        
        $audio_player_position =  get_option('audio_player_position');
        $audio_player_position1 = ($audio_player_position == 'above') ? 'selected=selected' : '';
        $audio_player_position2 = ($audio_player_position == 'below') ? 'selected=selected' : '';
        $audio_player_position3 = ($audio_player_position == 'disabled') ? 'selected=selected' : '';
        
        $select_audio_player =  get_option('select_audio_player');
        $select_audio_player1 = ($select_audio_player == 'powerpressplayer') ? 'selected=selected' : '';
        $select_audio_player2 = ($select_audio_player == 'simplepodcastpressblack') ? 'selected=selected' : '';
        $select_audio_player3 = ($select_audio_player == 'simplepodcastpresswhite') ? 'selected=selected' : '';
        $select_audio_player4 = ($select_audio_player == 'simplepodcastpresscustomcolor') ? 'selected=selected' : '';
        $sppress_custom_player_display = ($select_audio_player == 'simplepodcastpresscustomcolor') ? 'display:block;' : 'display:none;';
        $transcript_position =  get_option('transcript_position');
        $transcript_position1 = ($transcript_position == 'above') ? 'selected=selected' : '';
        $transcript_position2 = ($transcript_position == 'below') ? 'selected=selected' : '';
        $spp_allcategories = get_terms('category','hide_empty=0&orderby=name'); 
        $spp_catselechtml ='<select id="cat" name="spp_cat" class="postform" >';
                         foreach( $spp_allcategories as $term) { 
                            $selectedcat = '';
                            if($spp_category == $term->term_id){
                                $selectedcat =  'selected=selected';
                            }
                       $spp_catselechtml .= '<option  value="'. $term->term_id .'" '.$selectedcat.'>'.$term->name.'</option>';
                        }       
            $spp_catselechtml .=        '</select>';
        $spp_authorlist ='<select id="spp_author" name="spp_author" class="postform" >';
            $spp_author = get_option('spp_author');
            $authors=get_users();
            $i=0;
            //get all users list
            foreach($authors as $author){
                    $selectedauthor = '';
                    if($spp_author == $author->data->ID){
                                $selectedauthor =  'selected=selected';
                            }
                $spp_authorlist .= '<option  value="'. $author->data->ID .'" '.$selectedauthor.'>'.$author->data->display_name.'</option>';
            }
        $spp_authorlist .='</select>';
        $spp_channel_image = get_option('channel_image');
		$container_width = get_option('container_width');
        $minbutton_width = get_option('minbutton_width');
        $podcastURL_Feed =  get_option('is_third_party_feed');
        $html =' 
        <!--  <link href="https://fonts.googleapis.com/css?family=Limelight|Flamenco|Federo|Yesteryear|Josefin Sans|Spinnaker|Sansita One|Handlee|Droid Sans|Oswald:400,300,700" media="screen" rel="stylesheet" type="text/css" /> -->
            <div class="container-fluid">
              <div class="well well-1">
                <div class="row-fluid">
                  <span class="span8">
                    <div class="row-fluid">
                      <div class="spp-logo">
                        <!-- <img src="../wp-content/plugins/simple-podcast-press/spp_view/img/spp-logo-lg.png" class="image" style="margin-top:20px;"> -->
                      </div>
                      <span class="span10">
                                         Need Help? Check out the <a href="http://www.simplepodcastpress.com/quickstartguide.pdf" target="_new">Quick Start Guide</a> or <a href="mailto:support@simplepodcastpress.com">Email Our Support Team</a>.  We are here for you.<br><br>
                                         Love It? Please share on <a href="https://www.facebook.com/sharer/sharer.php?u=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Facebook</a>, <a href="https://twitter.com/intent/tweet?text=I%20love%20%23SimplePodcastPress%20a%20%23podcast%20player%20that%20builds%20your%20list%20and%20grows%20your%20audience%20on%20autopilot%20%2D&url=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Twitter</a>, <a href="https://plus.google.com/share?url=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Google+</a> (automatically shares your affiliate link)
                      </span>
                    </div>
                  </span>
                  <span class="span4">
                    <div class="row-fluid">
                    <span class="span8">
                        <p></p>
                      </span>
                      <span class="span4 userimage" > 
                        <!-- <img src="'.$spp_channel_image.'" class="image" style="width:100px;"> -->
                        <img src="'.$spp_channel_image.'" class="imagenotround" style="width:100px;">
                      </span>
                    </div>
                  </span>
                </div>
              </div>
              ';
        if ($podcastURL_Feed){
                $html .= '
            <div class="well well-1">
                <div class="page-header page-header-2">
                  <h1> <small>Publish Settings</small> 
                  </h1>
                </div>
                <div class="row-fluid">
                  <span class="span6">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_auto_publish" id="spp_auto_publish"  '.$spp_auto_publish1.' />
                      <span></span>
                      <span>Auto publish podcast posts</span>
                      <br>
                    </label>
                  </span>
                  <span class="span6">
                    <div class="row-fluid">
                      <span class="span12">  <a data-content="When this option is selected, Simple Podcast Press will automatically publish the new podcast blog posts. If this is deselected, then the podcast blog posts will remain in the draft state." data-original-title="Auto Publish Podcast Posts" rel="popover" class="icon icon-info-sign spp_icon-auto-publish">&nbsp;</a>
                      </span>
                    </div>
                  </span>
                </div>
                <div class="row-fluid spp_emaildraft" style="'.$spp_draft_row_display.'">
                  <span class="span6" >
                    <label class="checkbox">
                      <input type="checkbox" name="spp_email_on_draft" id="spp_email_on_draft" '.$spp_email_on_draft.'  />
                      <span></span>
                      <span>Email me each time a <strong>draft</strong> podcast post is created</span>
                      <br>
                    </label>
                  </span>
                  <span class="span6">
                    <div class="row-fluid">
                      <span class="span12"> <a data-content="When this option is selected, you will receive an email each time a draft podcast blog post is created by Simple Podcast Press. Note that if the auto publish option is en-abled, you will not receive any emails." data-original-title="Draft Notification" rel="popover" class="icon icon-info-sign spp_icon-draft-post">&nbsp;</a>
                      </span>
                    </div>
                  </span>
                </div>
				<div class="row-fluid">
                  <span class="span6">
                    Select Podcasts to Import
                  </span>
                  <span class="span2" style="height:10px; width: 16%;">
						<select id="spp_import_select" name="spp_import_select" style="width: 200px;">
						<option value="0" '.$spp_import_selected1.'>All (Default)</option>
						<option value="1" '.$spp_import_selected2.'>Disable Import</option>
						<option value="2" '.$spp_import_selected3.'>Only After Specific Date</option>
					   </select>
                  </span>
					<span class="span3 date_textbox" style="'.$date_textbox_display.'">
                    <input class="ep_specific_date" type="text" placeholder="Select Date ...." value="'.$ep_specific_date.'" name="ep_specific_date" style="width:128px">
                    </span>
                </div>
                <br>
                <div class="row-fluid row-fluid-1">
                  <span class="span6">
                    Enable Podcast Episode Image Import As Featured Image
                  </span>
                  <span class="span6">
						<select name="ep_art_select" style="width: 200px;">
						<option value="0" '.$ep_art_select1.'>Off (Default)</option>
						<option value="1" '.$ep_art_select2.'>From Podcast Feed</option>
						<option value="2" '.$ep_art_select3.'>From Your Libsyn Website Page</option>
                        <option value="3" '.$ep_art_select4.'>Always Use iTunes Podcast Cover Art</option>
					   </select>
                  </span>
                </div>
               
                <div class="row-fluid">
                  <span class="span6">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_insert_feat_image" id="spp_insert_feat_image"  '.$spp_insert_feat_image1.' />
                      <span></span>
                      <span>Automatically Insert Featured Image On Top Of Post</span>
                      <br>
                    </label>
                  </span>
                </div>
                
                <div class="spp_player_over_image_section" style="'.$spp_feat_image_settings_display.'">
                                          
                    <div class="row-fluid">
                  <span class="span6">
                    Featured Image Size and Alignment
                  </span>
                  <span class="span2" style="height:10px; width: 16%;">
						<select id="spp_imgsize_select" name="spp_imgsize_select" style="width: 200px;">
						<option value="thumbnail" '.$spp_imgsize_selected1.'>Thumbnail (150 x 150px max)</option>
						<option value="medium" '.$spp_imgsize_selected2.'>Medium (300 x 300px max)</option>
						<option value="large" '.$spp_imgsize_selected3.'>Large (640 x 640p max)</option>
                        <option value="full" '.$spp_imgsize_selected4.'>Full (original size max)</option>
					   </select>
                  </span>
					<span class="span2" style="height:10px; width: 16%;">
						<select id="spp_imgalign_select" name="spp_imgalign_select" style="width: 200px;">
						<option value="alignleft" '.$spp_imgalign_selected1.'>Left</option>
						<option value="aligncenter" '.$spp_imgalign_selected2.'>Center</option>
						<option value="alignright" '.$spp_imgalign_selected3.'>Right</option>
                        <option value="alignnone" '.$spp_imgalign_selected4.'>None</option>
					   </select>
                  </span>
                </div>
                <br>         
                    
                    </div>
                    
                

                      
                      
                <div class="row-fluid">
                  <span class="span6">
                    Choose a WordPress category for your podcast posts
                  </span>
                  <span class="span6">
                    <div class="row-fluid">
                      <span class="span7">
                        '.$spp_catselechtml.'
                      </span>
                      <span class="span5"></span>
                    </div>
                  </span>
                </div>
                <div class="row-fluid">
                  <span class="span6">
                    Choose an author for the podcast posts
                  </span>
                  <span class="span6">
                    <div class="row-fluid">
                      <span class="span7">
                        '.$spp_authorlist.'
                      </span>
                      <span class="span5"></span>
                    </div>
                  </span>
                </div>
                <div class="row-fluid">
                  <span class="span6">
                    Choose a custom post type for your podcast posts
                  </span>
                  <span class="span6">
                    <div class="row-fluid">
                      <span class="span7">
                        '.$spp_cpt_dropdown.'
                      </span>
                    </div>
                  </span>
                </div>
        </div>
        ';
        }
        $html .= '
         <div class="well">
             <div class="page-header page-header-1">
                  <h1> <small>Podcast Player Style Settings</small> 
                  </h1>
                </div>';
        $powerpressexists = get_option('powerpress_general');
        $powerpressactive = is_plugin_active( 'powerpress/powerpress.php' );
            if (!$podcastURL_Feed){
                $html .= '

                              ';
                    if (!$powerpressactive) {
                    $html .= '
        <div class="row-fluid">
                    <span class="span6">
                            <label class="span6">
                              <span>Choose your audio player
                                </br>
                              </span> </label>
                     </span>
                    <span class="span7"  style="height: auto ! important; width: 19%;">
                            <select id="select_audio_player" name="select_audio_player">
                            <option value="simplepodcastpressblack" '. $simplepodcastpressblack.' '.$select_audio_player2 .'>Simple Podcast Press Black</option>
                           	<option value="simplepodcastpresswhite" '. $simplepodcastpressblack.' '.$select_audio_player3 .'>Simple Podcast Press White</option>
                           	<option value="simplepodcastpresscustomcolor"  '.$select_audio_player4 .'>Simple Podcast Press Custom</option>
                           </select>
                            </span>
                        </div>
                        ';
                          $html .= '
        
         <div class="sppress_customplayer_settings" style="'.$sppress_custom_player_display.'">
              
        <div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Player Bar Colour
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="player_bar_color" id="player_bar_color" style="width:90px" value="'.$player_bar_color.'" >
                    </span>
             </div>
		<div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Progress Bar Colour
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="progress_bar_color" id="progress_bar_color" style="width:90px" value="'.$progress_bar_color.'" >
                    </span>
         </div>
		<div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Player Text and Buttons Colours
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="player_text_color" id="player_text_color" style="width:90px" value="'.$player_text_color.'" >
                    </br></br></span>
         </div>
         </div>
         
         <div class="row-fluid row-fluid-1">
                      <span class="span5">
                          <span><strong>Choose Which Podcast Players You Do NOT Want Replaced:</strong></br>
                            <br>
                          </span>
                      </span>
                    </div>
                          
                      
                    
                  <div class="row-fluid row-fluid-1">
                      <span class="span5">
                        <label class="checkbox">
                          <input type="checkbox" name="replace_wp_with_spp" id="replace_wp_with_spp" '.$replace_wp_with_spp .' />
                          <span>WordPress Audio Player</br>
                            <br>
                          </span>
                        </label>
                      </span>
                    </div>
                          
                          
                    <div class="row-fluid row-fluid-1">
                      <span class="span5">
                        <label class="checkbox">
                          <input type="checkbox" name="replace_stp_with_spp" id="replace_stp_with_spp" '.$replace_stp_with_spp .' />
                          <span>Smart Podcast Player Single Track Player</br>
                            <br>
                          </span>
                        </label>
                      </span>
                    </div>
                    ';
                        }
                        else {
                         $html .= '
                        <div class="row-fluid">
                    <span class="span6">
                            <label class="span6">
                              <span>Choose your audio player
                                </br>
                              </span> </label>
                     </span>
                    <span class="span7"  style="height: auto ! important; width: 19%;">
                            <select id="select_audio_player" name="select_audio_player">
                            <option value="simplepodcastpressblack" '. $simplepodcastpressblack.' '.$select_audio_player2 .'>Simple Podcast Press Black</option>
                           	<option value="simplepodcastpresswhite" '. $simplepodcastpressblack.' '.$select_audio_player3 .'>Simple Podcast Press White</option>
                           	<option value="simplepodcastpresscustomcolor"  '.$select_audio_player4 .'>Simple Podcast Press Custom</option>
                           </select>
                            </span>
                </div>  
                ';
                              $html .= '
        
         <div class="sppress_customplayer_settings" style="'.$sppress_custom_player_display.'">
              
        <div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Player Bar Colour
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="player_bar_color" id="player_bar_color" style="width:90px" value="'.$player_bar_color.'" >
                    </span>
             </div>
		<div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Progress Bar Colour
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="progress_bar_color" id="progress_bar_color" style="width:90px" value="'.$progress_bar_color.'" >
                    </span>
         </div>
		<div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Player Text and Buttons Colours
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="player_text_color" id="player_text_color" style="width:90px" value="'.$player_text_color.'" >
                    </br></br></span>
         </div>
         </div>
         
               <div class="row-fluid row-fluid-1">
                      <span class="span5">
                          <span><strong>Your PowerPress Player Will Be Replaced with Simple Podcast Press.<br>Choose Which Other Players You Do NOT Want Replaced:</strong></br>
                            <br>
                          </span>
                      </span>
                    </div>
                          
                      
                    
                  <div class="row-fluid row-fluid-1">
                      <span class="span5">
                        <label class="checkbox">
                          <input type="checkbox" name="replace_wp_with_spp" id="replace_wp_with_spp" '.$replace_wp_with_spp .' />
                          <span>WordPress Audio Player</br>
                            <br>
                          </span>
                        </label>
                      </span>
                    </div>
                          
                          
                    <div class="row-fluid row-fluid-1">
                      <span class="span5">
                        <label class="checkbox">
                          <input type="checkbox" name="replace_stp_with_spp" id="replace_stp_with_spp" '.$replace_stp_with_spp .' />
                          <span>Smart Podcast Player Single Track Player</br>
                            <br>
                          </span>
                        </label>
                      </span>
                    </div>
               
         ';
                        }           
             }
             else {
             $html .= '
         <div class="row-fluid">
                    <span class="span6">
                            <label class="span6">
                              <span>Choose your audio player
                                </br>
                              </span> </label>
                     </span>
                    <span class="span7"  style="height: auto ! important; width: 19%;">
                            <select id="select_audio_player" name="select_audio_player">
                            <option value="simplepodcastpressblack" '. $simplepodcastpressblack.' '.$select_audio_player2 .'>Simple Podcast Press Black</option>
                           	<option value="simplepodcastpresswhite" '. $simplepodcastpressblack.' '.$select_audio_player3 .'>Simple Podcast Press White</option>
                           	<option value="simplepodcastpresscustomcolor" '.$select_audio_player4 .'>Simple Podcast Press Custom</option>
                           </select>
                     </span>
                </div>
                ';
                
      $html .= '
        
         <div class="sppress_customplayer_settings" style="'.$sppress_custom_player_display.'">
              
        <div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Player Bar Colour
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="player_bar_color" id="player_bar_color" style="width:90px" value="'.$player_bar_color.'" >
                    </span>
             </div>
		<div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Progress Bar Colour
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="progress_bar_color" id="progress_bar_color" style="width:90px" value="'.$progress_bar_color.'" >
                    </span>
         </div>
		<div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Player Text and Buttons Colours
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="player_text_color" id="player_text_color" style="width:90px" value="'.$player_text_color.'" >
                    </br></br></span>
         </div></div>';
                   
                   $html .= '
            <div class="row-fluid">
                    <span class="span6">
                            <label class="span6">
                              <span>Audio player default location
                                </br>
                              </span> </label>
                     </span>
                    <span class="span7"  style="height: auto ! important; width: 19%;">
                       <select name="audio_player_position">
                          <option value="above" ' . $audio_player_position1 . '>Above page content</option>
                           <option value="below" '. $audio_player_position2.'>Below page content</option>
                           <option value="disabled" '. $audio_player_position3.'>Disabled</option>
                        </select>
                     </span>
                </div>  
                
                <div class="spp_player_over_image_section" style="'.$spp_feat_image_settings_display.'">
                                          
                    <div class="row-fluid row-fluid-1" >
                  <span class="span6" >
                    <label class="checkbox">
                      <input type="checkbox" name="spp_player_over_image" id="spp_player_over_image" '.$spp_player_over_image.'  />
                      <span>Force Player On Top Of Featured Image</span>
                     <br><br>     
                    </label>
                  </span>
                  <span class="span6">
                    <div class="row-fluid">
                      <span class="span12"> <a data-content="By default, the featured image will be inserted above everything in the post including the player.  If you want the player to be on top of the featured image, then enable this option." data-original-title="Force Player On Top Of Image" rel="popover" class="icon icon-info-sign spp_icon-draft-post">&nbsp;</a>
                      </span>
                    </div>
                  </span>
                    </div>                  
                    
                    </div>
                    
                ';
                

                 
                $html .= '
                 <div class="row-fluid row-fluid-1">
                      <span class="span6">
                        <label class="checkbox">
                          <input type="checkbox" name="replace_pp_with_spp" id="replace_pp_with_spp" '.$replace_pp_with_spp .' />
                          <span></span>
                          <span>Automatically replace all your existing audio players with the SPP player</br>
                            <br>
                          </span>
                        </label>
                      </span>
                      <span class="span6">
                        <div class="row-fluid">
                          <span class="span12"> <a data-content="Supports PowerPress, Smart Podcast Player Single Track Player, and Native WordPress audio players. Turning this option ON will automatically replace all instances of the existing audio player with the Simple Podcast Press player at the same location.  It will also add the call-to-action buttons or opt-in boxes as specified in your settings. Turning this option OFF will automatically revert back to the original player.Your iTunes feed is untouched." data-original-title="Use Simple Podcast Player instead of existing player" rel="popover" class="icon icon-info-sign spp_icon-auto-publish">&nbsp;</a>
                          </span>
                        </div>
                      </span>
                    </div>
                    
                    
                    <div class="sppress_donotreplace_player" style="'.$spp_replace_with_spp_display.'">
                          
                          
                    <div class="row-fluid row-fluid-1" style="margin-left: 25px;">
                      <span class="span5">
                          <span><strong>Do NOT Replace The Following Podcast Players:</strong></br>
                            <br>
                          </span>
                      </span>
                    </div>
                          
                          
                    
                    
                    
                    
                  <div class="row-fluid row-fluid-1" style="margin-left: 25px;">
                      <span class="span5">
                        <label class="checkbox">
                          <input type="checkbox" name="replace_wp_with_spp" id="replace_wp_with_spp" '.$replace_wp_with_spp .' />
                          <span>WordPress Audio Player</br>
                            <br>
                          </span>
                        </label>
                      </span>
                    </div>
                          
                          
                    <div class="row-fluid row-fluid-1" style="margin-left: 25px;">
                      <span class="span5">
                        <label class="checkbox">
                          <input type="checkbox" name="replace_stp_with_spp" id="replace_stp_with_spp" '.$replace_stp_with_spp .' />
                          <span>Smart Podcast Player Single Track Player</br>
                            <br>
                          </span>
                        </label>
                      </span>
                    </div>
                    
                    </div>
                  
                    ';
            
                
            $html .= '
            <div class="row-fluid row-fluid-4" >
                <span class="span6" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_autoplay_podcast" id="spp_autoplay_podcast" '.$spp_autoplay_podcast.'>
                      <span></span>
                      <span>Automatically play podcasts
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span1">
                    <div class="row-fluid">
                      <span class="span7"> <a data-content="When this option is selected, the Simple Podcast Press will automatically start playing a podcast as soon as the page loads." data-original-title="Automatically Play Podcasts" rel="popover" class="icon icon-info-sign icon-spp-description">&nbsp;</a>
                      </span>
                    </div>
                  </span>
             </div>   
                
                ';  
                 
                 
                 
                 
                 
                 
            }

              $html .= '
        <br>
        <div class="row-fluid row-fluid-1">
            <span style="height:auto !important;" class="span3">
                    <label>
                      <span>Audio Player Width
                       <br><br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" placeholder="Auto" value="'.$container_width.'" name="container_width" style="width:105px"> px
                    </span>
                                      <span class="span6">
                    <div class="row-fluid">
                      <span class="span12">  <a data-content="Set a custom width for the audio player (including the call to action buttons and opt-in if enabled).  Note that when a value is entered, it may affect the look of the player on mobile sites.  To set an automatic width, simply delete the contents of the input box." data-original-title="Audio Player Width" rel="popover" class="icon icon-info-sign spp_icon-auto-publish">&nbsp;</a>
                      </span>
                    </div>
                  </span>
             </div>   
             <br>
             <div class="row-fluid row-fluid-1">
            <span style="height:auto !important;" class="span3">
                    <label>
                      <span>Minimum Button Width
                       <br><br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" placeholder="130" value="'.$minbutton_width.'" name="minbutton_width" style="width:105px"> px
                    </span>
                                      <span class="span6">
                    <div class="row-fluid">
                      <span class="span12">  <a data-content="Set a minimum button width for the audio player buttons. This is just a minimum size.  The actual size of the button may be larger depending on the amount of text inside the button.  To set it back to the default value, simply delete the contents of the input box." data-original-title="Button Minimum Width" rel="popover" class="icon icon-info-sign spp_icon-auto-publish">&nbsp;</a>
                      </span>
                    </div>
                  </span>
             </div>   
             <br>
                   
             <div class="row-fluid row-fluid-2" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_download" id="btn_download" '.$btn_download.' >
                      <span>Show Download Button
                       </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="btn_download_color" id="btn_download_color" value="'.$btn_download_color.'" style="width:90px" >
                    </span>
        </div>   
         <div class="row-fluid row-fluid-1" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_spplisten" id="btn_spplisten" '.$btn_spplisten.'>
                      <span></span>
                      <span>Show Listen In New Window Button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="btn_spplisten_color" id="btn_spplisten_color" style="width:90px" value="'.$btn_spplisten_color.'" >
                    </span>
             </div>   
            <div class="row-fluid row-fluid-1" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_sppreview" id="btn_sppreview" '.$btn_sppreview.'>
                      <span></span>
                      <span>Show Leave a Review Button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="btn_sppreview_color" id="btn_sppreview_color" style="width:90px" value="'.$btn_sppreview_color.'" >
                    </span>
             </div>  
		<div class="row-fluid row-fluid-1" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_ClammrIT_checkbox" id="btn_ClammrIT_checkbox" '.$btn_ClammrIT_checkbox.'>
                      <span></span>
                      <span>Show Clammr It Button	
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="btn_ClammrIT_color" id="btn_ClammrIT_color" style="width:90px" value="'.$btn_ClammrIT_color.'" >
                    </span>
             </div>  
            <div class="row-fluid row-fluid-1" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_spprss" id="btn_spprss" '.$btn_spprss.'>
                      <span></span>
                      <span>Show Subscribe Via RSS Button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="btn_spprss_color" id="btn_spprss_color" style="width:90px" value="'.$btn_spprss_color.'" >
                    </span>
             </div>  
            <div class="row-fluid row-fluid-1" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_sppandroid" id="btn_sppandroid" '.$btn_sppandroid.'>
                      <span></span>
                      <span>Show Subscribe On Android Button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="btn_sppandroid_color" id="btn_sppandroid_color" style="width:90px" value="'.$btn_sppandroid_color.'" >
                    </span>
             </div>  
             <div class="row-fluid row-fluid-1" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_itunes" id="btn_itunes" '.$btn_itunes.' >
                      <span>Show iTunes Button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="btn_itunes_color" id="btn_itunes_color" style="width:90px" value="'.$btn_itunes_color.'" >
                    </span>
					<span class="span5" style="height: auto ! important; width: 19%;">
                    <input type="text" name="btn_itunes_url" id="btn_itunes_url" style="width:350px" value="'.$btn_itunes_url.'" placeholder="Enter your own iTunes URL to overwrite default ..." >
                    </span>
             </div>   
        <div class="row-fluid row-fluid-1" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_stiticher" id="btn_stiticher" '.$btn_stiticher.'>
                      <span></span>
                      <span>Show Stitcher Button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="btn_stiticher_color" id="btn_stiticher_color" style="width:90px" value="'.$btn_stiticher_color.'" >
                    </span>
                    <span class="span5" style="height: auto ! important; width: 19%;">
                    <input type="text" name="btn_stiticher_url" id="btn_stiticher_url" style="width:350px" value="'.$btn_stiticher_url.'" placeholder="Enter your Stitcher URL ..." >
                    </span>
             </div>   
        <div class="row-fluid row-fluid-1" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_soundcloud" id="btn_soundcloud" '.$btn_soundcloud.' >
                      <span>Show SoundCloud Button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="btn_soundcloud_color" id="btn_soundcloud_color" style="width:90px" value="'.$btn_soundcloud_color.'" >
                    </span>
                    <span class="span5"  style="height: auto ! important; width: 19%;">
                    <input type="text" name="btn_soundcloud_url" id="btn_soundcloud_url" style="width:350px" value="'.$btn_soundcloud_url.'" placeholder="Enter your SoundCloud URL ..." >
                    </span>
             </div>
		<div class="row-fluid row-fluid-4" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      	<input type="checkbox" name="btn_spp_custom1" id="btn_spp_custom1" '.$btn_spp_custom1.' >
                      <span>Show Custom button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span2" style="height: auto ! important;">
                    	<input type="text" name="btn_spp_custom_color1" id="btn_spp_custom_color1" style="width:90px" value="'.$btn_spp_custom_color1.'" >
                    </span>
                    <span class="span3" style="height: auto ! important;">
                   		<input type="text" name="btn_spp_custom_name1" id="btn_spp_custom_name1" style="width:220px" value="'.$btn_spp_custom_name1.'" placeholder="Button Name ..." >
                    </span>
                    <span class="span3"  style="height: auto ! important; width: 19%;">
                   		<input type="text" name="btn_spp_custom_url1" id="btn_spp_custom_url1" style="width:250px" value="'.$btn_spp_custom_url1.'" placeholder="Enter Button URL ..." >
                    </span>
         </div>
		<div class="row-fluid row-fluid-4" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      	<input type="checkbox" name="btn_spp_custom2" id="btn_spp_custom2" '.$btn_spp_custom2.' >
                      <span>Show Custom button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span2" style="height: auto ! important;">
                    	<input type="text" name="btn_spp_custom_color2" id="btn_spp_custom_color2" style="width:90px" value="'.$btn_spp_custom_color2.'" >
                    </span>
                    <span class="span3" style="height: auto ! important;">
                   		<input type="text" name="btn_spp_custom_name2" id="btn_spp_custom_name2" style="width:220px" value="'.$btn_spp_custom_name2.'" placeholder="Button Name ..." >
                    </span>
                    <span class="span3"  style="height: auto ! important; width: 19%;">
                   		<input type="text" name="btn_spp_custom_url2" id="btn_spp_custom_url2" style="width:250px" value="'.$btn_spp_custom_url2.'" placeholder="Enter Button URL ..." >
                    </span>
         </div>
		<div class="row-fluid row-fluid-4" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      	<input type="checkbox" name="btn_spp_custom3" id="btn_spp_custom3" '.$btn_spp_custom3.' >
                      <span>Show Custom button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span2" style="height: auto ! important;">
                    	<input type="text" name="btn_spp_custom_color3" id="btn_spp_custom_color3" style="width:90px" value="'.$btn_spp_custom_color3.'" >
                    </span>
                    <span class="span3" style="height: auto ! important;">
                   		<input type="text" name="btn_spp_custom_name3" id="btn_spp_custom_name3" style="width:220px" value="'.$btn_spp_custom_name3.'" placeholder="Button Name ..." >
                    </span>
                    <span class="span3"  style="height: auto ! important; width: 19%;">
                   		<input type="text" name="btn_spp_custom_url3" id="btn_spp_custom_url3" style="width:250px" value="'.$btn_spp_custom_url3.'" placeholder="Enter Button URL ..." >
                    </span>
         </div>
         <div class="row-fluid row-fluid-4" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      	<input type="checkbox" name="btn_spp_custom4" id="btn_spp_custom4" '.$btn_spp_custom4.' >
                      <span>Show Custom button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span2" style="height: auto ! important;">
                    	<input type="text" name="btn_spp_custom_color4" id="btn_spp_custom_color4" style="width:90px" value="'.$btn_spp_custom_color4.'" >
                    </span>
                    <span class="span3" style="height: auto ! important;">
                   		<input type="text" name="btn_spp_custom_name4" id="btn_spp_custom_name4" style="width:220px" value="'.$btn_spp_custom_name4.'" placeholder="Button Name ..." >
                    </span>
                    <span class="span3"  style="height: auto ! important; width: 19%;">
                   		<input type="text" name="btn_spp_custom_url4" id="btn_spp_custom_url4" style="width:250px" value="'.$btn_spp_custom_url4.'" placeholder="Enter Button URL ..." >
                    </span>
         </div>
		<div class="row-fluid row-fluid-4" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      	<input type="checkbox" name="btn_spp_custom5" id="btn_spp_custom5" '.$btn_spp_custom5.' >
                      <span>Show Custom button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span2" style="height: auto ! important;">
                    	<input type="text" name="btn_spp_custom_color5" id="btn_spp_custom_color5" style="width:90px" value="'.$btn_spp_custom_color5.'" >
                    </span>
                    <span class="span3" style="height: auto ! important;">
                   		<input type="text" name="btn_spp_custom_name5" id="btn_spp_custom_name5" style="width:220px" value="'.$btn_spp_custom_name5.'" placeholder="Button Name ..." >
                    </span>
                    <span class="span3"  style="height: auto ! important; width: 19%;">
                   		<input type="text" name="btn_spp_custom_url5" id="btn_spp_custom_url5" style="width:250px" value="'.$btn_spp_custom_url5.'" placeholder="Enter Button URL ..." >
                    </span>
         </div>
		<div class="row-fluid row-fluid-4" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      	<input type="checkbox" name="btn_spp_custom6" id="btn_spp_custom6" '.$btn_spp_custom6.' >
                      <span>Show Custom button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span2" style="height: auto ! important;">
                    	<input type="text" name="btn_spp_custom_color6" id="btn_spp_custom_color6" style="width:90px" value="'.$btn_spp_custom_color6.'" >
                    </span>
                    <span class="span3" style="height: auto ! important;">
                   		<input type="text" name="btn_spp_custom_name6" id="btn_spp_custom_name6" style="width:220px" value="'.$btn_spp_custom_name6.'" placeholder="Button Name ..." >
                    </span>
                    <span class="span3"  style="height: auto ! important; width: 19%;">
                   		<input type="text" name="btn_spp_custom_url6" id="btn_spp_custom_url6" style="width:250px" value="'.$btn_spp_custom_url6.'" placeholder="Enter Button URL ..." >
                    </span>
         </div>
		<div class="row-fluid row-fluid-4" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      	<input type="checkbox" name="spp_LeadBox_btn_checkbox" id="spp_LeadBox_btn_checkbox" '.$spp_LeadBox_btn_checkbox.' >
                      <span>Show LeadBox button
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span2" style="height: auto ! important;">
                    	<input type="text" name="spp_LeadBox_btn_color" id="spp_LeadBox_btn_color" style="width:90px" value="'.$spp_LeadBox_btn_color.'" >
                    </span>
                    <span class="span3"  style="height: auto ! important; width: 19%;">
						<textarea id="spp_LeadBox_btn_code" name="spp_LeadBox_btn_code" style="width: 576px; height: 117px;" class="span11" placeholder=" Paste LeadPages LeadBox HTML code here.">'. htmlspecialchars_decode($spp_LeadBox_btn_code, ENT_QUOTES) .'</textarea>
  
                    </span>
         </div>
  <div class="row-fluid">
            <span class="span6" style="height:auto !important;">
                    <label class="span6">
                      <span>Customize Text Above The Player 
                       </br></br>
                      </span> </label>
                    </span>
                    <span class="span7"  style="height: auto ! important; width: 19%;">
                    <input type="text" name="spp_listen_text" id="spp_listen_text" style="width:350px" value="'.$spp_listen_text.'" placeholder="i.e Listen to the Episode. Leave blank for no text.">
                    </span>
        </div>  
        
        
                
          <div class="row-fluid row-fluid-1" >
            
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_remove_timecode" id="spp_remove_timecode" '.$spp_remove_timecode.' >
                      <span>Hide Time From Text Above Player
                        </br></br>
                      </span> </label>
                    </span>
                   
             </div>
                   
                   
             <div class="row-fluid row-fluid-1" >
            
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="btn_style_round" id="btn_style_round" '.$btn_style_round.' >
                      <span>Enable Round Buttons
                        </br></br>
                      </span> </label>
                    </span>
                   
             </div>
               
            <div class="row-fluid row-fluid-4">
                  <span class="span6">
                    <label class="checkbox">
                      <input type="checkbox" name="disable_player_excerpt" id="disable_player_excerpt" '.$disable_player_excerpt.' >
                      <span>Disable Player and Text from Home, Blog, or Archive Pages
                        </br></br>
                      </span>
                    </label>
                  </span>
                  <span class="span3">
                    <div class="row-fluid">
                      <span class="span12"> <a data-content="When this option is selected, the Simple Podcast Press audio player will not appear on the home, blog or archive pages.  This option is also used to remove the random player text that appears on some home or archive pages on some themes" data-original-title="Disable Player on Blog Pages" rel="popover" class="icon icon-info-sign icon-spp-description">&nbsp;</a>
                      </span>
                    </div>
                  </span>
                </div>
                
             
                  
        <div class="row-fluid row-fluid-4" >
            <span class="span6" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_disable_poweredby" id="spp_disable_poweredby" '.$spp_disable_poweredby.'>
                      <span></span>
                      <span>Disable "Powered by" Link Below Player (or Enter Affiliate ID here) 
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span5" style="height: auto ! important; width: 30%;">
                    <input type="text" name="spp_poweredby_url" id="spp_poweredby_url" style="width:350px" value="'.$spp_poweredby_url.'" placeholder="Enter Your Affiliate ID Number Here (i.e 1)" ><a href="http://simplepodcastpress.com/affiliate-area/" target="_blank">Earn Commission. Click Here To Get Your Affilliate ID.</a>
                    </span>
             </div>   
             </br>
			<!-- Preroll
            <div class="row-fluid row-fluid-4" >
            <span class="span6" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_pre_roll_checkbox" id="spp_pre_roll_checkbox" '.$spp_pre_roll_checkbox.'>
                      <span></span>
                      <span>Pre Roll. 
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span5" style="height: auto ! important; width: 19%;">
                    <input type="text" name="spp_pre_roll_url" id="spp_pre_roll_url" style="width:350px" value="'.$spp_pre_roll_url.'" placeholder="Enter Your Pre Roll Mp3 URL)" >
                    </span>
             </div> 
             -->
             </br>

        <div class="row-fluid row-fluid-4" >
            <span class="span3" style="height:auto !important;">
            
                      <span>Clutter-Free Transcript/Show Notes Title
                        </br></br>
                      </span>
                    </span>
                    <span class="span2" style="height: auto ! important;">
                    	<input type="text" name="transcript_color" id="transcript_color" style="width:90px" value="'.$transcript_color.'" >
                    </span>
                    
                    <span class="span7"  style="height: auto ! important; width: 19%;">
                    <input type="text" name="transcript_txt" id="transcript_txt" style="width:350px" value="'.$transcript_txt.'" placeholder="Enter Transcript / Show Notes Section Title ..." >
                    </span>
         </div>               
               
        </div>
        <div class="well well-1">
                <div class="page-header page-header-1">
                  <h1> <small>Opt-in Box Settings</small> 
                  </h1>
                </div>
                <div class="row-fluid row-fluid-4">
                  <span class="span12">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_optin_box" id="spp_optin_box" '.$spp_optin_box .' />
                      <span></span>
                      <span>Automatically Add Opt-in Box Below Player
                        <br>
                      </span>
                    </label>
                  </span>
                </div>
			<div class="row-fluid" >
            	<span class="span3" style="height:auto !important;">
                	    <label class="checkbox">
                      	<span>Opt-in Style
                        	</br></br>
                      	</span> </label>
                    </span>
						<span class="span3">
	                    <select name="spp_two_step_optin" id="spp_two_step_optin">
							<option value="1" '. $spp_two_step_optin_selected1 .'>Name and Email</option>
							<option value="2" '. $spp_two_step_optin_selected2 .'>Email Address Only</option>
							<option value="3" '. $spp_two_step_optin_selected3 .'>Two Step Opt-in Name and Email</option>
							<option value="4" '. $spp_two_step_optin_selected4 .'>Two Step Opt-in Email Only</option>
						
						</select>
                    	</span>
		    </div>  
        <div class="optsettings" style="'.$spp_optin_row_display.'" >
        <div class="row-fluid">
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Submit Button Color
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="submit_button_color" id="submit_button_color" style="width:90px" value="'.$submit_button_color.'" >
                    </span>
             </div>   
        <div class="row-fluid" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Submit Button Text Color
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="submit_button_text" id="submit_button_text" style="width:90px" value="'.$submit_button_text.'" >
                    </span>
             </div>   
        <div class="row-fluid" >
            <span class="span3" style="height:auto !important;">
                    <label class="checkbox">
                      <span>Opt-in Box Container Color
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span4">
                    <input type="text" name="opt_container_color" id="opt_container_color" style="width:90px" value="'.$opt_container_color.'" >
                    </span>
             </div>   
        </br>
                <div class="row-fluid">
                  <span class="span5">
                    <label class="control-label">Opt-in box headline</label>
                    <input class="textinput span12" type="text" name="spp_auto_resp_heading" placeholder="Enter headline here" value="'. $spp_auto_resp_heading_get .'">
                  </span>
                  <span class="span7">
                    <div class="row-fluid">
                      <span class="span9 offset1">
                        <label class="control-label">Opt-in box sub headline</label>
                        <input class="textinput span12" type="text"  placeholder="Enter sub headline here" value="'. $spp_auto_resp_sub_heading_get.'" name="spp_auto_resp_sub_heading" />
                      </span>
                    </div>
                  </span>
                </div>
                <label class="control-label control-label-2">Opt-in form HTML code</label>
                <textarea id="jwsqz_autocode" name="optin_old_code" class="span11" placeholder="Paste your HTML code here.  Opt-in form should only include First Name and Email Address fields.">'. htmlspecialchars_decode($optin_old_code_get,ENT_QUOTES) .'</textarea>
                <input type="hidden" name="spp_auto_resp_url" id="jwsqz_autoformurl" value="'. $spp_auto_resp_url_get .'">
                <textarea style="display:none;" name="spp_auto_resp_hidden" cols="70" rows="5" id="jwsqz_autohidden">'. htmlspecialchars_decode($spp_auto_resp_hidden_get, ENT_QUOTES).'</textarea>
                 <input type="hidden" name="spp_auto_resp_name" id="jwsqz_arnameinput" value="'. htmlspecialchars_decode($spp_auto_resp_name_get, ENT_QUOTES) .'">
                 <input type="hidden" name="spp_auto_resp_email" id="jwsqz_aremailinput" value="'. htmlspecialchars_decode($spp_auto_resp_email_get, ENT_QUOTES).'"><br>
                <div class="row-fluid">
                  <span class="span12">
                    <label class="control-label">Submit button text</label>
                    <input class="textinput span3" type="text"  placeholder="Enter submit button text here" value="'. stripslashes($spp_auto_resp_submitt_get).'" name="spp_auto_resp_submitt">
                  </span>
                </div>
                </div>
              </div>
        <div class="well">
             <div class="page-header page-header-1">
                  <h1> <small>Share Settings</small> 
                  </h1>
                </div>
          
                
                
                <div class="row-fluid row-fluid-2">
            <span class="span2" style="height:auto !important;">
                    <label>
                      <span>Clickable Tweets 
                       </br></br>
                      </span> </label>
                    </span>
                    <span class="span3">
                    <input type="text" name="spp-twitter-handle" value="'.$spptwitterhandle.'" placeholder="Twitter Name without @ ..." />
                    </span>
                    <span class="span2" style="height:auto !important;">
                    <input type="text" name="twitter_text_color" id="twitter_text_color" style="width:90px" value="'.$twitter_text_color.'" >
                    </span>
        <span class="span3">
                    <div class="row-fluid">
                      <span class="span12">  <a data-content="Enter Twitter username, without the @ symbol.  The phrase via @username will be added at the end of the tweetable quote when shared on Twitter." data-original-title="Tweetable Twitter Name" rel="popover" class="icon icon-info-sign spp_icon-auto-publish">&nbsp;</a>
                      </span>
                    </div>
                  </span>
             </div>  
			
        <div class="row-fluid row-fluid-2">
            <span class="span2" style="height:auto !important;">
                    <label>
                      <span>Podcast Episode URL Shortener Prefix
                       </br></br>
                      </span> </label>
                    </span>
                    <span class="span5">
                    <input type="text" name="episode_short_link" value="'.$episode_short_link.'" placeholder="e.g. EPISODE or SESSION ..." />
                    </span>
        <span class="span3">
                    <div class="row-fluid">
                      <span class="span12">  <a data-content="This prefix will be automatically added to your shortened URL just before the episode number. For example, if you want all your episode shortened URLs to be yoursite.com/episode1, then enter the prefix \'episode\' in this box.  If you leave it blank, the shortened URL will simply be www.yoursite.com/1." data-original-title="Episode URL Shortener Prefix" rel="popover" class="icon icon-info-sign spp_icon-auto-publish">&nbsp;</a>
                      </span>
                    </div>
                  </span>
             </div>  
             
          <div class="row-fluid row-fluid-4">
                  <span class="span7">
                    <label class="checkbox">
                      <input type="checkbox" name="disable_url_shortner" id="disable_url_shortner" '.$disable_url_shortner .' />
                      <span></span>
                      <span>Disable URL Shortener
                        <br>
                      </span>
                    </label>
                  </span>
                  <span class="span1">
                    <div class="row-fluid">
                      <span class="span7"> <a data-content="When this option is selected, the Simple Podcast Press URL shortener is disabled." data-original-title="Disable URL Shortener" rel="popover" class="icon icon-info-sign icon-spp-description">&nbsp;</a>
                      </span>
                    </div>
                  </span>
                </div>
                
                             <div class="row-fluid row-fluid-1">
                  <span class="span7">
                    <label class="checkbox">
                      <input type="checkbox" name="disable_opengraph" id="disable_opengraph" '.$disable_opengraph .' />
                      <span></span>
                      <span>Disable Facebook Open Graph Meta
                        <br>
                      </span>
                    </label>
                  </span>
                  <span class="span1">
                    <div class="row-fluid">
                      <span class="span7"> <a data-content="When this option is selected, the Simple Podcast Press will not output the Facebook Meta data.  This is usually disabled when your theme or another plugin already generates the required Facebook meta data." data-original-title="Disable Facebook Open Graph" rel="popover" class="icon icon-info-sign icon-spp-description">&nbsp;</a>
                      </span>
                    </div>
                  </span>
                </div>           
        </div>
        
        
        <div class="well well-1">
            <div class="page-header page-header-1">
                <h1> <small>Advanced Tweaks (Most Setups Don\'t Require These Settings)</small></h1>
            </div>
                
             
			<div class="row-fluid" >
            	<span class="span6" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="direct_download_button" id="direct_download_button" '.$direct_download_button.'>
                      <span></span>
                      <span>Direct Download Button (not compatible with all hosting companies)
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span1">
                    <div class="row-fluid">
                      <span class="span7"> <a data-content="When this option is selected, the download button will directly download the MP3 file to listener\'s computer.  Note that some hosting companies have their servers configured to block this option.  If this option doesn\'t work on your site, please uncheck this option" data-original-title="Direct Download URL" rel="popover" class="icon icon-info-sign icon-spp-description">&nbsp;</a>
                      </span>
                    </div>
                  </span>
             </div>   
             <div class="row-fluid" >
            	<span class="span6" style="height:auto !important;">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_import_html_desc" id="spp_import_html_desc" '.$spp_import_html_desc.'>
                      <span></span>
                      <span>Import Full HTML Description
                        </br></br>
                      </span> </label>
                    </span>
                    <span class="span1">
                    <div class="row-fluid">
                      <span class="span7"> <a data-content="If you notice that the posts are not importing the full HTML description from your podcast feed, then enabled this option.  Note that you will need to delete the existing post, empty trash, RESET the PLUGIN, and attempt to import the post again from the SPP Settings"data-original-title="Import Full HTML Description" rel="popover" class="icon icon-info-sign icon-spp-description">&nbsp;</a>
                      </span>
                    </div>
                  </span>
             </div>   
             
              <div class="row-fluid">
                  <span class="span6">
                    <label class="checkbox">
                      <input type="checkbox" name="spp_force_player_home" id="spp_force_player_home" '.$spp_force_player_home .' />
                      <span></span>
                      <span>Force SPP Player on Home Page
                        </br></br>
                      </span>
                    </label>
                  </span>
                  <span class="span1">
                    <div class="row-fluid">
                      <span class="span7"> <a data-content="When this option is selected, the Simple Podcast Press Player is forced to appear on the home page.  This is only required on some themes that do not display the player on the home page. You can choose the location of the player (above or below the post excerpt) in the Podcast Player Styles Settings above or the PowerPress Media Appearance settings if you are replacing the PowerPress player with SPP)" data-original-title="Force SPP Player" rel="popover" class="icon icon-info-sign icon-spp-description">&nbsp;</a>
                      </span>
                    </div>
                  </span>
                </div>
                
                
            
        </div> 
              
              
              
              <div class="well">
                <div class="row-fluid">
                  <span class="span7">
                    <table>
                    <tr>
                    <td>
                        <input type="submit" class="btn btn-primary" name="spp_cbsn_save" id="spp_cbsn_save" value="Save Changes"> 
                    </td>
                    <td>
                            <span class="saved"></span>
                    </td>
                    </tr>
                    </table>
                  </span>
                                    
                  
                  <span class="span3">
                    <table>
                    <tr>
                    <td>
                    <input type="submit" class="btn" name="spp_cbsn_reset" id="spp_cbsn_reset" value="Reset Plugin">
                    </td>
                    <td>
                            <span class="reset"></span>
                    </td>
                    </tr>
                    </table>
                </span>
             </div>
              </div>
              
                <div class="alert alert-1" id="saved" style="display:none;"> </div>
                
  
                ';
            if ($podcastURL_Feed){
                    $html .= '
                          <div class="well well-1 well-2">
                            <div class="page-header page-header-1">
                              <h1> <small>Manual Import (Required for Initial Import)</small> 
                              </h1>
                            </div>
                            <p><strong>The first time you install and configure this plugin, you will need to manually import all your podcasts.  This can be done using the button below.</strong>
                    </br></br>Under most circumstances, you won\'t need to use this button. &nbsp;Simple Podcast Press with automatically check for new podcasts (once an hour) &nbsp;and import&nbsp;them automatically. &nbsp;If you need to import new podcasts sooner than that, you can use the button below.</p><p><strong>Note: Depending on how many podcasts you have, it may take several minutes for the import to complete.</strong></p>
                            <div class="row-fluid">
                              <span class="span7">
                                <table>
                                <tr>
                                <td>
                                <input type="submit" class="btn" name="spp_chk_new_vids" id="spp_chk_new_vids" value="Import New Podcasts Now">
                                </td>
                                <td>
                                        <span  id="fetchresults"></span>
                                </td>
                                </tr>
                                </table>
                              </span>
                            </div>
                          </div>
                          <div class="alert fetchresults fetchcomments" style="display:none;">       
                        </div>
                    ';
            }
        }
        echo $html;
}
        
        else {
    $html = '
        Oops. Your Simple Podcast Press License Hasn\'t Been Activated Yet.  <a href="admin.php?page=spp-license">Click Here to Activate It Now.</a></br></br>
        Don\'t Have a Full License Yet? <a target="_blank" href="http://simplepodcastpress.com">Grab One from Here.</a></br></br>
        Need Help? Send us an email to <a href="mailto:support@simplepodcastpress.com">support@simplepodcastpress.com</a> and we will be more than happy to help you.<br><br>
        Love It? Please share on <a href="https://www.facebook.com/sharer/sharer.php?u=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Facebook</a>, <a href="https://twitter.com/intent/tweet?text=I%20love%20%23SimplePodcastPress%20a%20%23podcast%20player%20that%20builds%20your%20list%20and%20grows%20your%20audience%20on%20autopilot%20%2D&url=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Twitter</a>, <a href="https://plus.google.com/share?url=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Google+</a> (automatically shares your affiliate link)
        
        ';
    // Load the License Activator Page if no valid license is found
    echo $html;
}
        
        
}
function spp_plugin_review_page(){
$isLicenseValid = get_option('sppress_ls');
        
if ($isLicenseValid == 'valid') 
{
    
    global $wpdb;
      $refID = get_option('spp_poweredby_url');
		$table_spp_reviews	=  $wpdb->prefix . "spp_reviews";
		$spp_channel_image = get_option('channel_image');
		//$spp_reviews = $wpdb->get_results("SELECT * FROM " . $table_spp_reviews );
		$spp_reviews = $wpdb->get_results("SELECT * FROM " . $table_spp_reviews . " ORDER BY rw_published_date DESC");
		$reviews_count = count($spp_reviews);
$html = '
<div class="container-fluid">
      <div class="well well-1">
        <div class="row-fluid">
          <span class="span8">
            <div class="row-fluid">
              <div class="spp-logo">
                <!-- <img src="../wp-content/plugins/simple-podcast-press/spp_view/img/spp-logo-lg.png" class="image" style="margin-top:20px;"> -->
              </div>
              
          
         
          
          
              <span class="span10">
                                 Need Help? Check out the <a href="http://www.simplepodcastpress.com/quickstartguide.pdf" target="_new">Quick Start Guide</a> or <a href="mailto:support@simplepodcastpress.com">Email Our Support Team</a>.  We are here for you.<br><br>
                                 Love It? Please share on <a href="https://www.facebook.com/sharer/sharer.php?u=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Facebook</a>, <a href="https://twitter.com/intent/tweet?text=I%20love%20%23SimplePodcastPress%20a%20%23podcast%20player%20that%20builds%20your%20list%20and%20grows%20your%20audience%20on%20autopilot%20%2D&url=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Twitter</a>, <a href="https://plus.google.com/share?url=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Google+</a> (automatically shares your affiliate link)
              </span>
            </div>
          </span>
          <span class="span4">
            <div class="row-fluid">
			<span class="span8">
                <p></p>
              </span>
              <span class="span4 userimage" > 
				<!-- <img src="'.$spp_channel_image.'" class="image" style="width:100px;"> -->
				<img src="'.$spp_channel_image.'" class="imagenotround" style="width:100px;">
              </span>
            </div>
          </span>
        </div>
      </div>
      <div class="well well-1">
        <div class="page-header page-header-2">
          <h1> <small>International iTunes Reviews ('.$reviews_count.')</small> 
          </h1>
        </div>
        <div class="row-fluid">';
		$counter = 0;
			foreach ($spp_reviews as $spp_review){
			
				$html .= '<table><tr><td>';
				$html .=  '<strong>'. $spp_review->rw_title . '</strong>' . '&nbsp;&nbsp;&nbsp;&nbsp;'
;
				$rating = $spp_review->rw_ratings;
				switch ($rating){
			
					case 5 :
					$html .= '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/5star.png" />';
					break;
					case 4 :
					$html .= '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/5star.png" />';
					break;
					case 3 :
					$html .= '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/3star.png" />';
					break;
					case 2 :
					$html .= '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/2star.png" />';
					break;
					case 1 :
					$html .= '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/1star.png" />';
					break;
					default:
					$html .= '<img src="'.SPPRESS_PLUGIN_URL.'/icons/rating_stars/00star.png" />';
					break;
				}
					$publishedat = $spp_review->rw_published_date;
					$PublishDate = date("F j, Y", strtotime($publishedat));
				$html .= '</td></tr><tr><td>';
				$html .= $PublishDate  . ' by '. '<b>' .  $spp_review->rw_author . '</b>' . ' from ' . $this->get_full_country_name($spp_review->rw_coutry);	
				$html .= '</td></tr><tr><td>';
				$html .=  $spp_review->rw_text . '</br></br>';	
				$html .= '</td></tr></table>';
				
	
			}//end foreach
		$html .= '</div>';
		echo $html;
}
    
    else {
        $html = '
        </br>Oops. Your Simple Podcast Press License Hasn\'t Been Activated Yet.  <a href="admin.php?page=spp-license">Click Here to Activate It Now.</a>
        
        ';
    // Load the License Activator Page if no valid license is found
    echo $html;
    
    }
}
function spp_url_shortner_page () { 
$spp_channel_image = get_option('channel_image');
$refID = get_option('spp_poweredby_url');
$fixed = get_option ('spp_links_table_fixed');
?>
<script type="text/javascript">
jQuery(document).ready(function($){
	$("#spp_url_shortner_button").click(function() {
			  var plug_url = "<?php echo SPPRESS_PLUGIN_URL; ?>";
			 $('.saved').html('<img src="'+plug_url+'/spp_view/img/loading1.gif" title="loading" style="padding-left: 15px;">'); 

			  var data = jQuery('#spp_url_shortner').serialize();

			<?php  $nonce = wp_create_nonce( 'urlshortner_settings' ); ?>

			data += '&wpnonce_urlshortner=<?php echo $nonce ?>' ;
		
			  $.post(ajaxurl, data, function(response) {
	
				
				$('body').load(window.location.href);
				 $('.saved').html(''); 
			   });
		
		return false;
		});
});
</script>
		
<form action="<?php echo get_bloginfo('wpurl'); ?>/wp-admin/admin.php?page=spp-url-shortner" method="post" id="spp_url_shortner">
<input type="hidden" name="action" value="spp_url_shortner" />
<?php
		$html = '
<div class="container-fluid">
      <div class="well well-1">
        <div class="row-fluid">
          <span class="span8">
            <div class="row-fluid">
              <div class="spp-logo">
                <!-- <img src="../wp-content/plugins/simple-podcast-press/spp_view/img/spp-logo-lg.png" class="image" style="margin-top:20px;"> -->
              </div>
              
          
         
          
          
              <span class="span10">
                                 Need Help? Check out the <a href="http://www.simplepodcastpress.com/quickstartguide.pdf" target="_new">Quick Start Guide</a> or <a href="mailto:support@simplepodcastpress.com">Email Our Support Team</a>.  We are here for you.<br><br>
                                 Love It? Please share on <a href="https://www.facebook.com/sharer/sharer.php?u=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Facebook</a>, <a href="https://twitter.com/intent/tweet?text=I%20love%20%23SimplePodcastPress%20a%20%23podcast%20player%20that%20builds%20your%20list%20and%20grows%20your%20audience%20on%20autopilot%20%2D&url=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Twitter</a>, <a href="https://plus.google.com/share?url=http://simplepodcastpress.com/?ref='.$refID.'" target="_blank">Google+</a> (automatically shares your affiliate link)
              </span>
            </div>
          </span>
          <span class="span4">
            <div class="row-fluid">
			<span class="span8">
                <p></p>
              </span>
              <span class="span4 userimage" > 
				<!-- <img src="'.$spp_channel_image.'" class="image" style="width:100px;"> -->
              </span>
            </div>
          </span>
        </div>
      </div>
      <div class="well well-1">
        <div class="page-header page-header-2">
          <h1> <small>URL Shortener</small> 
          </h1>
        </div>';

    
   if ( !isset($_GET['edit']) ){
    	   $html .= '<div class="row-fluid"><span class="span7">
                    <table>
                    <tr>
                    <td>
                       <input type="submit" class="btn btn-primary" name="spp_url_shortner_button" id="spp_url_shortner_button" value="Automatically Fix URL Shortener Links">
                    </td>
                    <td>
                            <span class="saved"></span>
                    </td>
                    </tr>
                    </table>
                  </span></div></form>';
			}

		echo $html;
		echo '<div class="row-fluid">';
				 $this->spp_links();
		    if (empty($_GET['edit'])) {
		      /**Display the data into the Dashboard**/
		        $this->spp_manage_links();
		    } else {
		      /**Display a form to add or update the data**/
		        $this->spp_add_link();  
		    }
		echo '</div></div>';
}
function spp_redirect()
{
  
  // Remove the trailing slash if there is one
  $request_uri = preg_replace('#/$#','',urldecode($_SERVER['REQUEST_URI']));
  if( $link_info = $this->spp_is_pretty_link($request_uri,false) )
  {
    $params = (isset($link_info['pretty_link_params'])?$link_info['pretty_link_params']:'');
    $this->spp_link_redirect_from_slug( $link_info['pretty_link_found']->spp_slug);
  }
}
 function spp_is_pretty_link($url, $check_domain=true)
    {
       
 	  $spp_blogurl	= ((get_option('home'))?get_option('home'):get_option('siteurl'));	
      if( !$check_domain or preg_match( '#^' . preg_quote( $spp_blogurl ) . '#', $url ) )
      {
        $uri = preg_replace('#' . preg_quote($spp_blogurl) . '#', '', $url);
        // Resolve WP installs in sub-directories
        preg_match('#^(https?://.*?)(/.*)$#', $spp_blogurl, $subdir);
        
        $struct = $this->spp_get_permalink_pre_slug_regex();
        $subdir_str = (isset($subdir[2])?$subdir[2]:'');
        $match_str = '#^'.$subdir_str.'('.$struct.')([^\?]*?)([\?].*?)?$#';
        
        if(preg_match($match_str, $uri, $match_val))
        {
          // Match longest slug -- this is the most common
          $params = (isset($match_val[3])?$match_val[3]:'');
          if( $pretty_link_found = $this->spp_is_pretty_link_slug( $match_val[2] ) )
            return compact('pretty_link_found','pretty_link_params');
          // Trim down the matched link
          $matched_link = preg_replace('#/[^/]*?$#','',$match_val[2],1);
          // cycle through the links (maximum depth 25 folders so we don't get out
          // of control -- that should be enough eh?) and trim the link down each time
          for( $i=0; ($i < 25) and 
                     $matched_link and 
                     !empty($matched_link) and
                     $matched_link != $match_val[2]; $i++ )
          {
            $new_match_str ="#^{$subdir_str}({$struct})({$matched_link})(.*?)?$#";
            $params = (isset($match_val[3])?$match_val:'');
            if( $pretty_link_found = $this->spp_is_pretty_link_slug( $match_val[2] ) )
              return compact('pretty_link_found','pretty_link_params');
            // Trim down the matched link and try again
            $matched_link = preg_replace('#/[^/]*$#','',$match_val[2],1);
          }
        }
      }
      
      return false;
    }
function spp_is_pretty_link_slug($slug)
    {
	  return apply_filters('spp-check-if-slug', $this->getOneFromSlug( urldecode($slug) ), urldecode($slug));
    }
 function getOneFromSlug( $slug, $return_type = OBJECT, $include_stats = false )
    {
      global $wpdb;
 	
	$table_spp_links	=  $wpdb->prefix . "spp_links";
        $query = "SELECT * FROM {$table_spp_links} WHERE spp_slug='$slug'";
      
      $link = $wpdb->get_row($query);
      return $link;
    }
function spp_get_permalink_pre_slug_uri($force=false,$trim=false)
  {
    global $prli_options;
    if($force)
    {
      preg_match('#^([^%]*?)%#', get_option('permalink_structure'), $struct);
      $pre_slug_uri = $struct[1];
      if($trim)
      {
        $pre_slug_uri = trim($pre_slug_uri);
        $pre_slug_uri = preg_replace('#^/#','',$pre_slug_uri);
        $pre_slug_uri = preg_replace('#/$#','',$pre_slug_uri);
      }
      return $pre_slug_uri;
    }
    else
      return '/';
  }
function spp_get_permalink_pre_slug_regex()
  {
    $pre_slug_uri = $this->spp_get_permalink_pre_slug_uri(true);
    if(empty($pre_slug_uri))
      return '/';
    else
      return "{$pre_slug_uri}|/";
  }
		function spp_link_redirect_from_slug($slug)
		{
		
		  $link = $this->getOneFromSlug(urldecode($slug));
		  
		  if(isset($link->spp_slug) and !empty($link->spp_slug))
		  {
		    $custom_get = $_GET;
		 
		    $this->spp_track_link($link->spp_slug,$custom_get); 
		    exit;
		  }
		}
	function spp_track_link($slug,$values)
  {
    global $wpdb;
	$table_spp_links	=  $wpdb->prefix . "spp_links";
  
    $query = "SELECT * FROM ".$table_spp_links." WHERE spp_slug='$slug' LIMIT 1";
    $spp_link = $wpdb->get_row($query);
    $spp_link_target = apply_filters( 'spp_target_url', array( 'spp_url' => $spp_link->spp_url, 'link_id' => $spp_link->spp_id) );
    $spp_link_url = $spp_link_target['spp_url'];


        header("HTTP/1.1 301 Moved Permanently");
        header('Location: '.$spp_link_url);
        break;
    
    
    
  }
	

		//	Schedule cron
		function podcast_cron_setup($schedules){
			$schedules['simplepodcastpress-cron'] = array('interval'=>60,'display'=>__('Every Minute'),);
			return $schedules;
		}
		
		
		function install_spp_db() {
		
			global $wpdb;
		$podcast_feed_url = get_option('podcast_url');
		
		require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
		if ($podcast_feed_url){
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			$sppress_collate = " COLLATE utf8_general_ci";
              
            $table_spp_podcast	=  $wpdb->prefix . "spp_podcast";
		
			$table_spp_podcast="CREATE TABLE IF NOT EXISTS " . $table_spp_podcast . " (
				  `pc_id` bigint(20) NOT NULL AUTO_INCREMENT,
				  `pc_title` text NOT NULL,
				  `pc_published_date` varchar(50) NOT NULL,
				  `pc_description` longtext NOT NULL,
				  `pc_audio_file` varchar(200) NOT NULL,
				  `pc_audio_duration` varchar(100) NOT NULL,
				  `pc_audio_length` varchar(100) NOT NULL,
				  `pc_episode_keywords` varchar(255) NOT NULL,
				  `pc_episode_image` varchar(255) NOT NULL,
                  `pc_libsyn_image` varchar(255) NOT NULL,
						PRIMARY KEY (`pc_id`)
					)" . $sppress_collate .";";
			dbDelta($table_spp_podcast);
			}
			$table_spp_links	=  $wpdb->prefix . "spp_links";
			$table_spp_links = "CREATE TABLE {$table_spp_links} (
              spp_id int(11) NOT NULL auto_increment,
              spp_name varchar(255) default NULL,
              spp_url text default NULL,
              spp_slug varchar(255) default NULL,
			  spp_post_id bigint(20) default NULL,
              PRIMARY KEY  (spp_id)
				)" . $sppress_collate .";";
			dbDelta($table_spp_links);
			$table_spp_reviews	=  $wpdb->prefix . "spp_reviews";
			$table_spp_reviews = "CREATE TABLE {$table_spp_reviews} (
              id int(11) NOT NULL auto_increment,
              rw_id varchar(50) default NULL,
              rw_coutry varchar(50) default NULL,
			  rw_published_date varchar(50) default NULL,
              rw_title varchar(255) default NULL,
              rw_text longtext default NULL,
              rw_ratings varchar(255) default NULL,
			  rw_author varchar(255) default NULL,
              PRIMARY KEY  (id)
				)" . $sppress_collate .";";
			dbDelta($table_spp_reviews);
}
	
    //	Activate plugin block
		function simplepodcastpress_activate(){
			global $wpdb , $spp_db_version;
            $table_spp_podcast	=  $wpdb->prefix . "spp_podcast";
            
            $installed_version = get_option("spp_db_version");
			
			if ($installed_version !== $spp_db_version) {
                $this->install_spp_db();
                
                $myPodcastTable = $wpdb->get_row("SELECT * FROM " . $table_spp_podcast);
                
                
                //Add column if not present.
                if(!isset($myPodcastTable->pc_libsyn_image)) 
                    $wpdb->query("ALTER TABLE " . $table_spp_podcast ." ADD pc_libsyn_image varchar(255) NOT NULL");
                
                update_option("spp_db_version" , $spp_db_version);
			}
    
            
            $this->generate_options_css(); 
                     
            
            
		}
		//	End of activating block
		
            //	Deactivate plugin block
		function simplepodcastpress_deactivate(){
			$timestamp = wp_next_scheduled( 'simplepodcastpress_fetch' );
			wp_unschedule_event($timestamp, 'hourly', 'simplepodcastpress_fetch');
			wp_clear_scheduled_hook($timestamp, 'hourly', 'simplepodcastpress_fetch');	
			$timestamp = wp_next_scheduled( 'simplepodcastpress_event');
			wp_unschedule_event($timestamp,'daily', 'simplepodcastpress-cron');
            wp_clear_scheduled_hook($timestamp,'daily', 'simplepodcastpress-cron');
            
			
		}
	
}//end class
// register activate hook
	?>