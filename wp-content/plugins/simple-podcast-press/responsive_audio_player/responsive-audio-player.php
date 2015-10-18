<?php
/*************************************************************************************************************
file responsive-audio-player.php is a part of Simple Podcast Press and contains proprietary code - simplepodcastpress.com
*************************************************************************************************************/
add_action(
	'plugins_loaded',
	array ( B5F_Responsive_Audio_Player::get_instance(), 'plugin_setup' )
);
 
class B5F_Responsive_Audio_Player
{
	/**
	 * Plugin instance.
	 *
	 * @see get_instance()
	 * @type object
	 */
	protected static $instance = NULL;
 
	/**
	 * URL to this plugin's directory.
	 *
	 * @type string
	 */
	public $plugin_url = '';
 
	/**
	 * Path to this plugin's directory.
	 *
	 * @type string
	 */
	public $plugin_path = '';
 
	/**
	 * Access this plugin’s working instance
	 *
	 * @wp-hook plugins_loaded
	 * @since   2012.09.13
	 * @return  object of this class
	 */
	public static function get_instance()
	{
		NULL === self::$instance and self::$instance = new self;
		return self::$instance;
	}
 
	/**
	 * Used for regular plugin work.
	 *
	 * @wp-hook plugins_loaded
	 * @since   2012.09.10
	 * @return  void
	 */
	public function plugin_setup()
	{
 
		$this->plugin_url    = plugins_url( '/', __FILE__ );
		$this->plugin_path   = plugin_dir_path( __FILE__ );
		$this->load_language( 'b5f-rap' );
 
		if ( ! is_admin() ) {
				add_action( 'wp_enqueue_scripts', array( $this, 'sppress_enqueue_scripts' ) );
            	add_action( 'wp_default_scripts', array( $this, 'enqueue_jquery' ) );
	        	add_action('wp_footer', array( &$this, 'two_step_optin_fn' ) );
		}
		
		$isLicenseValid = get_option('sppress_ls');
        
        if ($isLicenseValid !== 'valid') 
        {
          return; 
        }
        
        // Only If license is valid, then load the shortcodes and css/jquery
        else {
        
            add_shortcode( 'spp-audioonly', array( $this, 'shortcode' ) );
            add_shortcode( 'spp-ctabuttons', array( $this, 'ctabuttons_fn' ) );
            add_shortcode( 'spp-transcript', array( $this, 'transcript_fn' ) );
            add_shortcode( 'spp-optin', array( $this, 'spp_optin_fn' ) );
            add_shortcode( 'spp-audio', array( $this, 'sppressplayer_fn' ) );
            add_shortcode( 'spp-player', array( $this, 'sppressplayer_fn' ) );
            add_shortcode( 'spp-poweredby', array( $this, 'spp_poweredby_fn' ) );
			add_shortcode( 'spp-timestamp', array( $this, 'spp_timestamp_fn') );
			add_shortcode( 'spp-episodes', array( $this, 'spp_episodes_fn') );
            

			
            
            
        
            
        }
	}
 
	/**
	 * Constructor. Intentionally left empty and public.
	 *
	 * @see plugin_setup()
	 * @since 2012.09.12
	 */
	public function __construct() {}   
    
    function shortcode($atts) 
	{
		global $post;
		$html = '';
		$duration = '';
		
		$width = isset( $atts['width'] ) ? " style='max-width:{$atts['width']}; float:right; margin-bottom:10px;'" : '';
    if ( !isset ( $atts['widget'] ) ){  

        if ( isset ( $atts['url'] ) )
        {
            $audio_file = $atts['url'];
			
			$spp_line = '|';
			$filtered_audio_file_location = strpos($audio_file, $spp_line);
			
			if ($filtered_audio_file_location)
				$audio_file = substr($audio_file, 0,$filtered_audio_file_location);
			
			update_post_meta( $post->ID, '_useraudiourl', $audio_file );
        }
        
            
        else
        {
				$audio_file =  get_post_meta( $post->ID, '_audiourl', true ); 
				$duration = get_post_meta( $post->ID, '_audioduration', true ); 
				update_post_meta( $post->ID, '_useraudiourl', '' );
        }

	}else{

				$audio_file = $atts['url'];
				$duration = get_post_meta( $post->ID, '_audioduration', true );


	}
			if (empty($audio_file)){


				$PPGeneral= get_option('powerpress_general');
				$MetaData = get_post_meta($post->ID, 'enclosure', true);
				$MetaParts = explode("\n", $MetaData, 4);
				$audio_file = trim($MetaParts[0]);
	
				$audio_url_parts = parse_url($audio_file);
				
				if (!empty($PPGeneral['redirect1'])){
				
				$audio_file = $PPGeneral['redirect1'] . $audio_url_parts['host'] . $audio_url_parts['path'];

				}
				$duration = unserialize($MetaParts[3]);

				$duration = $duration['duration'];

				}
			
		$mp3 = '<source src="' . $audio_file  .'" />';
		$text = __( "This text displays if the audio tag isn't supported.", 'b5f-rap' );

		$spp_autoplay_podcast = get_option('spp_autoplay_podcast');
        if ($spp_autoplay_podcast)
            $spp_autoplay = 'autoplay';
        else
            $spp_autoplay = '';
        
                
        if ( isset ( $atts['width'] ) )
        {
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
			
		if( isset( $atts['textabove'] )) { 
            $textabove = $atts['textabove'];
            if($textabove == 'off')
			   $listen_text = '';
			else
			   $listen_text = $textabove;
		}
		else
			   $listen_text = get_option('spp_listen_text');	
        
		$listen_text = '<div><b>'.$listen_text.' '. $duration.' </b></div>';
        
		$html .= $listen_text.'
		<div '.$width.'>
		<audio class="sppaudioplayer" controls preload="none"' . $spp_preroll . $spp_autoplay .'>'. $mp3 .'
		</audio>
		</div>
        ';
			

            
        }
        
	elseif ( isset ( $atts['widget'] ) )
        {
        
		$spp_pre_roll_checkbox = get_option('spp_pre_roll_checkbox');
        $spp_pre_roll_url = get_option('spp_pre_roll_url');
       
        if ($spp_pre_roll_checkbox)
              $spp_preroll = "preroll=" . $spp_pre_roll_url;
        else
              $spp_preroll = '';
		
		$html .= '
         	<div>
			<audio class="sppaudioplayer_widget" controls preload="none"' .$spp_preroll .'>'. $mp3 .'
			</audio>
		</div>
        ';
            
        }

        else
        {
		
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
			
		if( isset( $atts['textabove'] )) { 
            $textabove = $atts['textabove'];
            if($textabove == 'off')
			   $listen_text = '';
			else
			   $listen_text = $textabove;
		}
		else
			   $listen_text = get_option('spp_listen_text');	
			
        $listen_text = '<div><b>'.$listen_text.' '. $duration.' </b></div>';
  						
		$html .= $listen_text.'
		<div>
            <audio class="sppaudioplayer" controls preload="none"' . $spp_preroll . $spp_autoplay .'>'. $mp3 .'
			</audio>
		</div>
        ';
			
        }
    
		return $html;
        
	}
	
        
    function transcript_fn($atts, $content = null) 
	{
		
		global $post;
		$title = get_option('transcript_txt');
		
		if (empty($title))
			$title  = "Read Full Transcript";

		if ($content == null)
			$spptranscript = get_post_meta( $post->ID, '_spptranscript', true );
		else
			$spptranscript = $content;
		
			
			$html = <<<HTML
<div class="transcript-box" style="float:none !important;">
<div class="accordion-container">
		<a href="#" class="accordion-toggle">$title<span class="toggle-icon"><i class="fa fa-angle-double-down"></i></span></a>
		<div class="accordion-accordion_content">
			<p>$spptranscript</p>
		</div>
		<!--/.accordion-accordion_content-->
	</div>
</div>

HTML;
		

		return $html;
	}
	function ctabuttons_fn($atts) 
	{
		global $post;
		$html = '';
		
		$btn_ClammrIT_checkbox = get_option('btn_ClammrIT_checkbox'); 
		$itunes_url = get_option('btn_itunes_url');
        if ( empty($itunes_url) )
            $itunes_url = get_option('itunes_url');
		$btn_download = get_option('btn_download');
		$btn_spplisten = get_option('btn_spplisten');
        $btn_spprss = get_option('btn_spprss');
        $btn_sppreview = get_option('btn_sppreview');
        $btn_sppandroid = get_option('btn_sppandroid');
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
		

		$useraudio_file =  get_post_meta( $post->ID, '_useraudiourl', true );
		if (empty($useraudio_file))
			$audio_file =  get_post_meta( $post->ID, '_audiourl', true );
		else
			$audio_file = $useraudio_file;
		
	if (empty($audio_file)){

				$PPGeneral= get_option('powerpress_general');
				$MetaData = get_post_meta($post->ID, 'enclosure', true);
				$MetaParts = explode("\n", $MetaData, 4);
				$audio_file = trim($MetaParts[0]);
				$audio_url_parts = parse_url($audio_file);
	
				if (!empty($PPGeneral['redirect1'])){
				
				$audio_file = $PPGeneral['redirect1'] . $audio_url_parts['host'] . $audio_url_parts['path'];

				}
	}
		$direct_download_button = get_option('direct_download_button');

    if ($direct_download_button)
        $audiodownloadurl = SPPRESS_PLUGIN_URL . '/responsive_audio_player/downloadaudio.php?file=' . $audio_file;
    else
        $audiodownloadurl = $audio_file;

		$btn_spp_custom1_display =($btn_spp_custom1 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom2_display =($btn_spp_custom2 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom3_display =($btn_spp_custom3 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom4_display =($btn_spp_custom4 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom5_display =($btn_spp_custom5 == 0) ? 'display:none !important;' : '';
		$btn_spp_custom6_display =($btn_spp_custom6 == 0) ? 'display:none !important;' : '';


		//Get Custom Buttons Name
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
				
		if ( has_post_thumbnail() ) 
              $channel_image = wp_get_attachment_url( get_post_thumbnail_id($post->ID) );
        else
              $channel_image =  get_option('channel_image');
        
		$link = get_permalink($post->ID);
		$posttitle = htmlspecialchars(rawurlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');
		
		$fullpostcontent = get_the_content();
		$postcontent = $link . ' - ' . strip_shortcodes($fullpostcontent);
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

		return $html;
	}

    
    function spp_poweredby_fn($atts) 
	{
        $html = '';
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
        else
            $html .= ''; 
        
        				
		return $html;
		
	}
        
	function spp_optin_fn($atts) 
	{
    $hide_email = '';
	$html = '';
	
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
								
				
								
						
        

return $html;
		
	}

function two_step_optin_fn($atts) 
	{
    $html = '';
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
						 break;
						 case 4 :
								$hide_first_name = 'display:none !important;';
								$hide_email = 'display:none !important;';
								$hide_first_name_two_step = 'display:none !important;';
						 break;

					}

    
        if ( ($spp_two_step_optin == 3) || ($spp_two_step_optin == 4) ) {
            $html .= '
             <div id="spp-two-step-optin" class="reveal-modal">
                 <a class="close-reveal-modal">&#215;</a>
                <div id="spp-box-below-video" class="spp-optin-box">
				<div class="spp-optin-box-padding">
				<div class="spp-optin-box-content">
				<div class="spp-optin-box-headline">' . stripslashes($spp_auto_resp_heading_get) .'</div>
				<div class="spp-optin-box-subheadline">' . stripslashes($spp_auto_resp_sub_heading_get) . '</div>
				<div class="spp-optin-box-form-wrap">
				<form accept-charset="utf-8" action="'. $spp_auto_resp_url_get .'" method="post" target="_blank">
				'. htmlspecialchars_decode($spp_auto_resp_hidden_get, ENT_QUOTES) . '
				<div class="spp-optin-box-field" style="'.$hide_first_name_two_step.'">
				 <input placeholder="First Name" type="text" name="'. $spp_auto_resp_name_get .'"></div>
				<div class="spp-optin-box-field">
				 <input placeholder="Email" type="text" name="'. $spp_auto_resp_email_get .'"></div>
				<div class="spp-optin-box-field-submit"><input type="submit" name="submit" class="spp-optin-box-submit" value=" ' . stripslashes($spp_auto_resp_email_submitt) . '"></div>
				</form>
				</div>
				</div>
				</div>
				</div>
			</div>
                ';
        }

										
						
        

echo $html;
		
	}
    
    function sppressplayer_fn($atts) 
	{

        $html = '';
		$ctabuttonspart = '';
		$optinpart = '';
		$poweredby = '';
			
		if( isset($atts['url'] ) ) {
			
			
			
			$audio_file = $atts['url'];
						
			$spp_line = '|';
			$filtered_audio_file_location = strpos($audio_file, $spp_line);
			
			if ($filtered_audio_file_location)
				$audio_file = substr($audio_file, 0,$filtered_audio_file_location);
                
            
		}
		
		elseif ( isset($atts['src']) )
			$audio_file = $atts['src'];
		
        $audiopart = $this->shortcode($atts);
		$spp_optin_box = get_option('spp_optin_box');        
            
        if( isset( $atts['optin'] )) { 
            $optin = $atts['optin'];
            if($optin != 'off')
                $optinpart = $this->spp_optin_fn($atts);
        }
        else {
	       // If Optin Option is disabled, don't add it to the player
	       if ($spp_optin_box == 1)
		      $optinpart = $this->spp_optin_fn($atts);
        
                
        }

            
        
        if( isset( $atts['ctabuttons'] )) {
            $ctabuttons = $atts['ctabuttons'];
            if($ctabuttons != 'off')
                $ctabuttonspart = $this->ctabuttons_fn($atts);
        }
        else
            $ctabuttonspart = $this->ctabuttons_fn($atts);
		
		if( isset( $atts['poweredby'] )) {
            $poweredbylink = $atts['poweredby'];
            if($poweredbylink != 'off')
                $poweredby = $this->spp_poweredby_fn($atts);
        }
        else
            $poweredby = $this->spp_poweredby_fn($atts);
		
        

        
        

		$container_width = get_option('container_width');

		if ($container_width)
			$container_width  = 'style="max-width:' . $container_width . 'px;"';
	    
        $html .= '<div class="player_container"'. $container_width.'>' . $audiopart . $ctabuttonspart . $optinpart . $poweredby . '</div>';
        
        return $html;
    }
	
	
	// Function to advance the time
	function spp_timestamp_fn($atts)
	{
		
		if( isset( $atts['time'] )) { 
            $time = $atts['time'];
		}
		
		//$arr = split(':',$time);
		$arr = explode(':',$time);
		$m = (int)$arr[0];
		$s = (int)$arr[1];
		$interval = $m*60+$s;
		
		if( ( is_single() && is_main_query() ) || is_page() )
			return '<a class="spp-timestamp" time="'.$interval.'">['.$time.']</a>';
		else
			return '<span>['.$time.']</span>';  
	}
	
	
	// Sort podcasts by published date_create
	function sortFunction($a,$b){
		    return strtotime($b['pc_published_date']) - strtotime($a['pc_published_date']);
	}
	
	function spp_episodes_fn($atts) {
		
		global $wpdb;
		$table_name = $wpdb->prefix.'spp_podcast';
		$episodes = $wpdb->get_results("select * from $table_name ") or die("No Podcasts Found");
		$audiodownloadurl = '';
		
		$direct_download_button = get_option('direct_download_button');
		
		if($direct_download_button)
        	$audiodownloadurl = SPPRESS_PLUGIN_URL . '/responsive_audio_player/downloadaudio.php?file=';
	
			
		$html = '		
					
					<table id="grid-basic" class="table table-condensed table-hover table-striped" style="font-size: 14px;" >
							<thead>
									<tr>
											<td class="spp-episodes-released-title" data-column-id="released" data-header-css-class="releasedColumn">Released</th>
											<td class="spp-episodes-podcast-title" data-column-id="name">Episode</th>
											<td class="spp-episodes-download-title" data-column-id="link" data-header-css-class="downloadColumn" data-formatter="link" data-sortable="false"></th>
									</tr>
							</thead>
							<tbody>';
		foreach($episodes as $episode){
			$episode_array[] = (array)$episode;
		
			
			usort($episode_array,array( $this, 'sortFunction')); 
		}
				

		foreach($episode_array as $latest_episode){
						
			$html.='
			    <tr>
							<td class="spp-episodes-released" >';
							//$arr = split(' ',$latest_episode['pc_published_date']);
							$arr = explode(' ',$latest_episode['pc_published_date']);
							$html.=$arr[1]." &nbsp;".$arr[2]." &nbsp;".$arr[3];
							$html.='</td>
							<td class="spp-episodes-podcast" >'.$latest_episode['pc_title'].'</td>
							<td class="spp-episodes-download" ><a href="'.$audiodownloadurl.$latest_episode['pc_audio_file'].'">Download</a></td>
					</tr> ';
			}
    $html.='</tbody></table>';
			
		return $html;
		
	}
          
    
	// Simple podcast press enqueue_scripts which calls two diferent CSS files.
    function sppress_enqueue_scripts()
	{
		$css_version = rand(10, 99)/10;
		
		// Always load all scripts and js
		echo '<link href="http://netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">'  . "\n";
		echo '<link href="http://fonts.googleapis.com/css?family=Oswald:300,400,700" rel="stylesheet" type="text/css">'  . "\n";
		
		// Handle the location of the CSS file for multisite
		if(is_multisite()) {
			$uploads = wp_upload_dir();
		  	$spp_audiocss_file = trailingslashit($uploads['baseurl']).'audio-player.css';
		}
		else
			$spp_audiocss_file = SPPRESS_PLUGIN_URL . '/responsive_audio_player/css/audio-player.css';
		
		wp_enqueue_style( 'resp-player-css', $spp_audiocss_file, false, $css_version, 'all' );
		wp_enqueue_script( 'resp-player-js', SPPRESS_PLUGIN_URL . '/responsive_audio_player/js/audio-player.js', array('jquery'), false, false );
		wp_enqueue_style( 'jquery-reveal-css', SPPRESS_PLUGIN_URL . '/responsive_audio_player/css/reveal.css', false, $css_version, 'all' );
        wp_enqueue_script( 'jquery-reveal', SPPRESS_PLUGIN_URL . '/responsive_audio_player/js/jquery.reveal.js', array('jquery'), false, false );
		wp_enqueue_script( 'rotator', SPPRESS_PLUGIN_URL . '/responsive_audio_player/js/rotator.js', array('jquery'), false, false );
		wp_enqueue_style( 'spp-clickable-tweet', SPPRESS_PLUGIN_URL . '/responsive_audio_player/css/spp-tweet-styles.css', false, $css_version, 'all' );
		//Just using regular tables for now, not the Bootgrid table
		//wp_enqueue_style( 'jquery-bootgrid-css', $this->plugin_url . 'css/jquery.bootgrid.css', false, $css_version, 'all' );
        //wp_enqueue_script( 'jquery-bootgrid', $this->plugin_url . 'js/jquery.bootgrid.js', array('jquery'), false, true );
	} 



	/**
	 * Description: Prints jQuery in footer on front-end.
	 * Author:      Dominik Schilling
	 * Author URI:  http://wpgrafie.de/
	 */
	function enqueue_jquery( &$scripts ) {

			$scripts->add_data( 'jquery', 'group', 1 );
	}


	private function has_shortcode( $shortcode = '' ) 
	{  
		$post_to_check = get_post(get_the_ID());  
		$found = false;  
		if ( !$shortcode ) 
			return $found;  

		if ( stripos( $post_to_check->post_content, '[' . $shortcode) !== false ) 
			$found = true;  

		return $found;  
	}

	/**
	 * Loads translation file.
	 *
	 * Accessible to other classes to load different language files (admin and
	 * front-end for example).
	 *
	 * @wp-hook init
	 * @param   string $domain
	 * @since   2012.09.11
	 * @return  void
	 */
	public function load_language( $domain )
	{
		load_plugin_textdomain(
			$domain,
			FALSE,
			$this->plugin_path . 'languages'
		);
	}
}