<?php 
$audio = get_post_meta($post->ID, 'pl_audio', true) ;
$audio_embed = get_post_meta($post->ID, 'pl_audio_embed', true) ;
$video_embed = trim( get_post_meta($post->ID, 'pl_video_embed', true) );

if($audio_embed!=''){ ?>
<?php 
if(get_the_post_thumbnail()=='' && $video_embed=='' ) $title_top_class = ' post_top_element';
else $title_top_class = '';
?>  
<div class="fit audio_embed<?php echo $title_top_class;?>"><?php echo $audio_embed;?></div>
<?php }
if($audio!=''){ ?>
<div class="player_wrapper">
	<audio id="player-<?php echo $post->ID;?>" src="<?php echo $audio;?>" controls="controls" style="width: 100%; height: 100%;"></audio>
</div>
<?php } ?>

