<?php
/*************************************************************************************************************
file spp-widget.php is a part of Simple Podcast Press and contains proprietary code - simplepodcastpress.com
*************************************************************************************************************/

add_action( 'widgets_init', 'spp_widget' );


function spp_widget() {
	register_widget( 'spp_widget' );
}


    class spp_widget extends WP_Widget {

	function spp_widget() {
		$widget_ops = array( 'classname' => '', 'description' => __('A widget that showcases your latest podcast episodes.', 'latest-podcast') );
		
		
		$this->WP_Widget( 'latest-podcast', __('Latest Episode', 'latest-podcast'), $widget_ops);
	}
	
	function widget( $args, $instance ) {
		extract( $args ); 

		$title = 'Latest Episode';
		echo $before_widget;

		// Display the widget title 
		if ( $title )
			echo $before_title . $title . $after_title; 




    global $wpdb;

		$spp_widget_art = $instance['select_widget_art_name'];
		$table_spp_podcast	=  $wpdb->prefix . "spp_podcast";
		
        $itunes_url = get_option('btn_itunes_url');
        if ( empty($itunes_url) )
            $itunes_url = get_option('itunes_url');
      
		$query = "SELECT * FROM {$table_spp_podcast}";


		$results = $wpdb->get_results($query) or die("No Podcasts Found");

    	foreach( $results as $row ) {
        	$result_array[] = (array)$row;
    	}
		
		
		
		function sortFunction($a,$b){
		    return strtotime($a['pc_published_date']) - strtotime($b['pc_published_date']);
		}
		

		
		usort($result_array,"sortFunction");


		$mostRecent= end($result_array);
	
		switch($spp_widget_art){

		case 'no_image':

		$spp_channel_image = '';
		$art_style = 'display:none;';

		break;
		case 'podcast_channel_art':

		$spp_channel_image = get_option('channel_image');

		break;
		case 'pd_episode_art':

		$spp_channel_image =  $mostRecent['pc_episode_image'];

		break;
		case 'libsyn_image':

		$spp_channel_image =  $mostRecent['pc_libsyn_image'];

		break;
            
        default:
        $spp_channel_image = get_option('channel_image');
            
		}

		


		$audio_file =  $mostRecent['pc_audio_file'];

		if (empty($audio_file)){


				$PPGeneral= get_option('powerpress_general');
				$MetaData = get_post_meta($post->ID, 'enclosure', true);
				$MetaParts = explode("\n", $MetaData, 4);
				$audio_file = trim($MetaParts[0]);
	
				$audio_url_parts = parse_url($audio_file);
				
				if (!empty($PPGeneral['redirect1'])){
				
				$audio_file = $PPGeneral['redirect1'] . 'p/' . $audio_url_parts['host'] . $audio_url_parts['path'];

				}
				$duration = unserialize($MetaParts[3]);

				$duration = $duration['duration'];

				}
		

?>
<div class="download-box"><?php echo do_shortcode('[spp-audioonly url="'.$audio_file.'" widget="true"]');?>
<img style="margin-top: 0px !important; margin-bottom:0px !important; <?php echo $art_style; ?>" width="100%" height="auto" src="<?php echo $spp_channel_image; ?>" >
<a class="button-sppsidebar" target="_blank" href="<?php echo $itunes_url; ?>">Subscribe on iTunes</a></div>




<?php
	echo $after_widget;
	}

	//Update the widget 
	 	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		//Strip tags from title and name to remove HTML 
		$instance['selected_itunes_id'] = $new_instance['selected_itunes_id'];
		$instance['select_widget_art_name'] = $new_instance['select_widget_art_name'];
		return $instance;
	}

	
	function form( $instance ) {
		$title = $instance['title'];
		$itunes_urls = $instance['selected_itunes_id'];
		


		global $wpdb;
		$table_spp_itunes_urls	=  $wpdb->prefix . "spp_itunes_urls";
		$itunes_ids = $wpdb->get_results("SELECT * FROM " . $table_spp_itunes_urls);
		$itunes_widget_id = $this->get_field_id( 'selected_itunes_id' );
		$itunes_widget_name = $this->get_field_name( 'selected_itunes_id' );
	   	$Selected_Itunes_ID = $instance['selected_itunes_id'];
		$select_widget_art = $instance['select_widget_art_name'];
		$select_widget_art_id = $this->get_field_id( 'select_widget_art_id' );
		$select_widget_art_name = $this->get_field_name( 'select_widget_art_name' );
	 ?>

<select name="<?php echo $select_widget_art_name; ?>" id="<?php echo $select_widget_art_id; ?>" class="postform span10" style="padding: 0px ! important; width: 100%;" >
<option  value="no_image" <?php if($select_widget_art == 'no_image'){echo 'selected=selected';} ?> >No Image</option>
<option  value="podcast_channel_art" <?php if($select_widget_art == 'podcast_channel_art'){echo 'selected=selected'; } ?>>Podcast channel art</option>
<option  value="pd_episode_art"  <?php if($select_widget_art == 'pd_episode_art'){echo 'selected=selected'; } ?>>Podcast Episode Art from Feed</option>
<option  value="libsyn_image" <?php if($select_widget_art == 'libsyn_image'){echo 'selected=selected'; } ?>>Libsyn Page Image</option>
</select>

<?php



	}


	

}


?>