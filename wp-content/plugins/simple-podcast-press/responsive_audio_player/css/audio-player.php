<?php header("Content-type: text/css; charset: UTF-8");

$btn_download_color = get_option('btn_download_color');
if (!$btn_download_color)
	$btn_download_color = '#81d742';
	
$btn_itunes_color = get_option('btn_itunes_color');
if (!$btn_itunes_color)
	$btn_itunes_color = '#1e73be';

$btn_sppreview_color = get_option('btn_sppreview_color');
if (!$btn_sppreview_color)
	$btn_sppreview_color = '#8224e3';

$btn_spprss_color = get_option('btn_spprss_color');
if (!$btn_spprss_color)
	$btn_spprss_color = '#dd9933';

$btn_sppandroid_color = get_option('btn_sppandroid_color');
if (!$btn_sppandroid_color)
	$btn_sppandroid_color = '#93ae00';

$btn_spplisten_color = get_option('btn_spplisten_color');
if (!$btn_spplisten_color)
	$btn_spplisten_color = '#f7d600';

$btn_stiticher_color = get_option('btn_stiticher_color');
if (!$btn_stiticher_color)
	$btn_stiticher_color = '#33e0d4';

$btn_soundcloud_color = get_option('btn_soundcloud_color');
if (!$btn_soundcloud_color)
	$btn_soundcloud_color = '#ef8037';


$btn_ClammrIT_color = get_option('btn_ClammrIT_color');
if (!$btn_ClammrIT_color)
	$btn_ClammrIT_color = '#d40a0a';


$transcript_color = get_option('transcript_color'); 
if (!$transcript_color)
	$transcript_color = '#000000';

$container_width = get_option('container_width'); 
if ($container_width)
	$container_width = 'width: ' . $container_width . 'px;';
else 
	$container_width = '';
$select_audio_player = get_option('select_audio_player');

$submit_button_color = get_option('submit_button_color');
if (!$submit_button_color)
	$submit_button_color = '#1e73be';

$submit_button_text = get_option('submit_button_text');
if (!$submit_button_text)
	$submit_button_text = '#ffffff';

$opt_container_color = get_option('opt_container_color');
if (!$opt_container_color)
	$opt_container_color = '#fcfcfc';

$twitter_text_color = get_option('twitter_text_color');
if (!$twitter_text_color)
	$twitter_text_color = '#24c9f2';



$player_bar_color = get_option('player_bar_color');
if (!$player_bar_color)
	$player_bar_color = '#000000';


$progress_bar_color = get_option('progress_bar_color');
if (!$progress_bar_color)
	$progress_bar_color = '#ffffff';

$player_text_color = get_option('player_text_color');
if (!$player_text_color)
	$player_text_color = '#ffffff';

$player_bar_color_hover = $player_bar_color;
//$player_bar_color_hover = sppressAdjBrightness($player_bar_color , 10);
$progress_bar_color_hover = sppressAdjBrightness($progress_bar_color , 50);
$player_text_color_hover = sppressAdjBrightness($player_text_color , 50);


$btn_spp_custom_color1 = get_option('btn_spp_custom_color1');
if (!$btn_spp_custom_color1)
	$btn_spp_custom_color1 = '#9b9b9b';

$btn_spp_custom_color2 = get_option('btn_spp_custom_color2');
if (!$btn_spp_custom_color2)
	$btn_spp_custom_color2 = '#9b9b9b';


$btn_spp_custom_color3 = get_option('btn_spp_custom_color3');
if (!$btn_spp_custom_color3)
	$btn_spp_custom_color3 = '#9b9b9b';

$btn_spp_custom_color4 = get_option('btn_spp_custom_color4');
if (!$btn_spp_custom_color4)
	$btn_spp_custom_color4 = '#9b9b9b';

$btn_spp_custom_color5 = get_option('btn_spp_custom_color5');
if (!$btn_spp_custom_color5)
	$btn_spp_custom_color5 = '#9b9b9b';


$btn_spp_custom_color6 = get_option('btn_spp_custom_color6');
if (!$btn_spp_custom_color6)
	$btn_spp_custom_color6 = '#9b9b9b';

$btn_sppleadbox_color = get_option('spp_LeadBox_btn_color');
if (!$btn_sppleadbox_color)
	$btn_sppleadbox_color = '#2da0e2';


$minbutton_width = get_option('minbutton_width'); 
if ($minbutton_width)
	$minbutton_width = 'min-width: ' . $minbutton_width . 'px !important;';
else 
	$minbutton_width = 'min-width: 130px !important;';

$btn_spp_custom_color1_hover = sppressAdjBrightness($btn_spp_custom_color1 , 30);
$btn_spp_custom_color2_hover = sppressAdjBrightness($btn_spp_custom_color2 , 30);
$btn_spp_custom_color3_hover = sppressAdjBrightness($btn_spp_custom_color3 , 30);
$btn_spp_custom_color4_hover = sppressAdjBrightness($btn_spp_custom_color4 , 30);
$btn_spp_custom_color5_hover = sppressAdjBrightness($btn_spp_custom_color5 , 30);
$btn_spp_custom_color6_hover = sppressAdjBrightness($btn_spp_custom_color6 , 30);
$btn_sppleadbox_color_hover = sppressAdjBrightness($btn_sppleadbox_color , 30);

$downloadhover = sppressAdjBrightness($btn_download_color , 30);
$ituneshover = sppressAdjBrightness($btn_itunes_color,30); 
$stitcherhover = sppressAdjBrightness($btn_stiticher_color,30);
$soundcloudhover = sppressAdjBrightness($btn_soundcloud_color,30);
$clammrhover = sppressAdjBrightness($btn_ClammrIT_color,30);
$spplistenhover = sppressAdjBrightness($btn_spplisten_color,30);
$spprsshover = sppressAdjBrightness($btn_spprss_color,30);
$sppandroidhover = sppressAdjBrightness($btn_sppandroid_color,30);
$sppreviewhover = sppressAdjBrightness($btn_sppreview_color,30);
$transcript_color_hover = sppressAdjBrightness($transcript_color,30);


$submit_button_color_hover = sppressAdjBrightness($submit_button_color,30); 

function sppressAdjBrightness($hex, $steps) {
    // Steps should be between -255 and 255. Negative = darker, positive = lighter
    $steps = max(-255, min(255, $steps));

    // Format the hex color string
    $hex = str_replace('#', '', $hex);
    if (strlen($hex) == 3) {
        $hex = str_repeat(substr($hex,0,1), 2).str_repeat(substr($hex,1,1), 2).str_repeat(substr($hex,2,1), 2);
    }

    // Get decimal values
    $r = hexdec(substr($hex,0,2));
    $g = hexdec(substr($hex,2,2));
    $b = hexdec(substr($hex,4,2));

    // Adjust number of steps and keep it inside 0 to 255
    $r = max(0,min(255,$r + ($r * ($steps / 255))));
    $g = max(0,min(255,$g + $steps));  
    $b = max(0,min(255,$b + $steps));

    $r_hex = str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
    $g_hex = str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
    $b_hex = str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

    return '#'.$r_hex.$g_hex.$b_hex;
}

$btn_style_round = get_option('btn_style_round');
$spp_flat_player = 'true';
?>


/*
	PLAYER
*/
@font-face {
  font-family: 'fontello';
  src: url("font/fontello.eot?25440500");
  src: url("font/fontello.eot?25440500#iefix") format('embedded-opentype'), url("font/fontello.woff?25440500") format('woff'), url("font/fontello.ttf?25440500") format('truetype'), url("font/fontello.svg?25440500#fontello") format('svg');
  font-weight: normal;
  font-style: normal;
}
@font-face {
  font-family: 'fontawsome';
  src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/fonts/fontawesome-webfont.eot");
  src: url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/fonts/fontawesome-webfont.eot") format('embedded-opentype'), url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/fonts/fontawesome-webfont.woff") format('woff'), url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/fonts/fontawesome-webfont.ttf") format('truetype'), url("https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/fonts/fontawesome-webfont.svg") format('svg');
  font-weight: normal;
  font-style: normal;
}


/* .site-title {display:none;} */

/* Float Clearing
--------------------------------------------- */

audio:before, audio:after, buttons:before, buttons:after, sppbuttons:before, sppbuttons:after, spp-optin-box:before, spp-optin-box:after
{
	content: " ";
	display: table;
}



<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
.audioplayer
{



    /* margin-bottom: 25px !important; */
    top: 5px; 
    height: 2.5em; /* 40 */
	color: #fff;
	/* margin-bottom: 10px; */
	/* text-shadow: 1px 1px 0 #000;*/
	
	position: relative;
	z-index: 1;
	background: #333;

	/* -webkit-box-shadow: inset 0 1px 0 rgba( 255, 255, 255, .15 ), 0 0 1.25em rgba( 0, 0, 0, .5 );   comment 20 */
	/* -moz-box-shadow: inset 0 1px 0 rgba( 255, 255, 255, .15 ), 0 0 1.25em rgba( 0, 0, 0, .5 );  comment 20 */
	/* box-shadow: inset 0 1px 0 rgba( 255, 255, 255, .15 ), 0 0 1.25em rgba( 0, 0, 0, .5 );  comment 20 */
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	


}
<?php break;

	  case 'simplepodcastpresswhite'	: 
?>
.audioplayer
{


top: 5px; 
    height: 2.5em; /* 40 */
	color: #000;
	/* margin-bottom: 10px; */
	/* text-shadow: 1px 1px 0 #fff; */
	position: relative;
	z-index: 1;
	background: #fff;
     border: 0px solid #222;
	/* -webkit-box-shadow: inset 0 1px 0 rgba( 255, 255, 255, 0 ), 0 0 1.25em rgba( 0, 0, 0, .13 ); comment 20 */
	/* -moz-box-shadow: inset 0 1px 0 rgba( 255, 255, 255, 0), 0 0 1.25em rgba( 0, 0, 0, .13 );   comment 20 */
	/* box-shadow: inset 0 1px 0 rgba( 255, 255, 255, 0), 0 0 1.25em rgba( 0, 0, 0, .13 );   comment 20 */
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border: 1px solid #222;
	border-radius: 0px;



	
}

<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
.audioplayer
{



top: 5px; 
    height: 2.5em; /* 40 */
	color: <?php echo $player_text_color;?>;
	/* margin-bottom: 10px; */
	/* text-shadow: 1px 1px 0 #fff; */
	position: relative;
	z-index: 1;
	background: <?php echo $player_bar_color;?>;

	/* -webkit-box-shadow: inset 0 1px 0 rgba( 255, 255, 255, 0 ), 0 0 1.25em rgba( 0, 0, 0, .13 ); comment 20 */
	/* -moz-box-shadow: inset 0 1px 0 rgba( 255, 255, 255, 0), 0 0 1.25em rgba( 0, 0, 0, .13 );   comment 20 */
	/* box-shadow: inset 0 1px 0 rgba( 255, 255, 255, 0), 0 0 1.25em rgba( 0, 0, 0, .13 );   comment 20 */
	-webkit-border-radius: 0px;
	-moz-border-radius: 0px;
	border-radius: 0px;

	<?php if (!$spp_flat_player){ ?>

    border: 1px solid #222;
	background: -webkit-gradient( linear, left top, left bottom, from( <?php echo $player_bar_color;?> ), to( <?php echo $player_bar_color_hover;?> ) );
	background: -webkit-linear-gradient( top, <?php echo $player_bar_color;?>, <?php echo $player_bar_color_hover;?> );
	background: -moz-linear-gradient( top, <?php echo $player_bar_color;?>, <?php echo $player_bar_color_hover;?> );
	background: -ms-radial-gradient( top, <?php echo $player_bar_color;?>, <?php echo $player_bar_color_hover;?> );
	background: -o-linear-gradient( top, <?php echo $player_bar_color;?>, <?php echo $player_bar_color_hover;?> );
	background: linear-gradient( top, <?php echo $player_bar_color;?>, <?php echo $player_bar_color_hover;?> );

<?php } ?>
	
}
<?php 
	break;
	}
 ?>
	.audioplayer-mini
	{
		width: 2.5em; /* 40 */
		margin: 0 auto;
	}
	.audioplayer-mini audio
	{
		display: none;
	}
	.audioplayer > div
	{
		position: absolute;
	}
	.audioplayer-playpause
	{
		width: 2.5em; /* 40 */
		height: 100%;
		text-align: left;
		text-indent: -9999px;
		cursor: pointer;
		z-index: 2;
		top: 0;
		left: 0;
	}
		.audioplayer:not(.audioplayer-mini) .audioplayer-playpause
		{
			border-right: 0px solid #555;
			border-right-color: rgba( 255, 255, 255, .1 );
		}
		.audioplayer-mini .audioplayer-playpause
		{
			width: 100%;
		}
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
		.audioplayer-playpause:hover,
		.audioplayer-playpause:focus
		{
			background-color: #333;
		}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>
		.audioplayer-playpause:hover,
		.audioplayer-playpause:focus
		{
			background-color: #fff;
		}
<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
		.audioplayer-playpause:hover,
		.audioplayer-playpause:focus
		{
			background-color: <?php echo $player_bar_color;?>;
		}

<?php 
		break;
		}
?>
		.audioplayer-playpause a
		{
			display: block;
		}
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
		.audioplayer:not(.audioplayer-playing) .audioplayer-playpause a
		{
			width: 0;
			height: 0;
			border: 0.5em solid transparent; /* 8 */
			border-right: none;
			border-left-color: #fff;
			content: '';
			position: absolute;
			top: 50%;
			left: 50%;
			margin: -0.5em 0 0 -0.25em; /* 8 4 */
		}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>
	.audioplayer:not(.audioplayer-playing) .audioplayer-playpause a
		{
			width: 0;
			height: 0;
			border: 0.5em solid transparent; /* 8 */
			border-right: none;
			border-left-color: #222;
			content: '';
			position: absolute;
			top: 50%;
			left: 50%;
			margin: -0.5em 0 0 -0.25em; /* 8 4 */
		}
<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
.audioplayer:not(.audioplayer-playing) .audioplayer-playpause a
		{
			width: 0;
			height: 0;
			border: 0.5em solid transparent; /* 8 */
			border-right: none;
			border-left-color: <?php echo $player_text_color; ?>;
			content: '';
			position: absolute;
			top: 50%;
			left: 50%;
			margin: -0.5em 0 0 -0.25em; /* 8 4 */
		}
<?php
	  break;
 } ?>
		.audioplayer-playing .audioplayer-playpause a
		{
			width: 0.75em; /* 12 */
			height: 0.75em; /* 12 */
			position: absolute;
			top: 50%;
			left: 50%;
			margin: -0.375em 0 0 -0.375em; /* 6 */
		}
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
			.audioplayer-playing .audioplayer-playpause a:before,
			.audioplayer-playing .audioplayer-playpause a:after
			{
				width: 40%;
				height: 100%;
				background-color: #fff;
				content: '';
				position: absolute;
				top: 0;
			}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>
		.audioplayer-playing .audioplayer-playpause a:before,
			.audioplayer-playing .audioplayer-playpause a:after
			{
				width: 40%;
				height: 100%;
				background-color: #222;
				content: '';
				position: absolute;
				top: 0;
			}
<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
		.audioplayer-playing .audioplayer-playpause a:before,
			.audioplayer-playing .audioplayer-playpause a:after
			{
				width: 40%;
				height: 100%;
				background-color: <?php echo $player_text_color; ?>;
				content: '';
				position: absolute;
				top: 0;
			}
<?php  
	  break;
	  } 
?>
			.audioplayer-playing .audioplayer-playpause a:before
			{
				left: 0;
			}
			.audioplayer-playing .audioplayer-playpause a:after
			{
				right: 0;
			}
	.audioplayer-time
	{
		width: 4.375em; /* 70 */
		height: 100%;
		line-height: 2.375em; /* 38 */
		text-align: center;
		z-index: 2;
		top: 0;
	}
		.audioplayer-time-current
		{
			border-left: 0px solid #111;
			border-left-color: rgba( 0, 0, 0, .25 );
			left: 2.5em; /* 40 */
		}
		.audioplayer-time-duration
		{
			border-right: 0px solid #555;
			border-right-color: rgba( 255, 255, 255, .1 );
			right: 2.5em; /* 40 */
		}
			.audioplayer-novolume .audioplayer-time-duration
			{
				border-right: 0;
				right: 0;
			}
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
	.audioplayer-bar
	{
		height: 0.875em; /* 14 */
		background-color: #333;
		cursor: pointer;
		z-index: 1;
		top: 50%;
		right: 6.875em; /* 110 */
		left: 6.875em; /* 110 */
		margin-top: -0.438em; /* 7 */
	}
		.audioplayer-bar-loaded
		{
			background-color: #333;
			z-index: 1;
		}
		.audioplayer-bar-played
		{
			background: #fff;
			
			z-index: 2;
		}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>
	.audioplayer-bar
	{
		height: 0.875em; /* 14 */
		background-color: #fff;
		cursor: pointer;
		z-index: 1;
		top: 50%;
		right: 6.875em; /* 110 */
		left: 6.875em; /* 110 */
		margin-top: -0.438em; /* 7 */
	}
		.audioplayer-bar-loaded
		{
			background-color: #fff;
			z-index: 1;
		}
		.audioplayer-bar-played
		{
			background: #222;
			z-index: 2;
		}
<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
	.audioplayer-bar
	{
		height: 0.875em; /* 14 */
		background-color: <?php echo $player_bar_color; ?>;
		cursor: pointer;
		z-index: 1;
		top: 50%;
		right: 6.875em; /* 110 */
		left: 6.875em; /* 110 */
		margin-top: -0.438em; /* 7 */
	}
		.audioplayer-bar-loaded
		{
			background-color: <?php echo $player_bar_color_hover; ?>;
			z-index: 1;
		}
		.audioplayer-bar-played
		{
			background: <?php echo $progress_bar_color; ?>;
			z-index: 2;
		}
<?php
	 break;
	 } 
?>
		.audioplayer-novolume .audioplayer-bar
		{
			right: 4.375em; /* 70 */
		}
		.audioplayer-bar div
		{
			width: 0;
			height: 100%;
			position: absolute;
			left: 0;
			top: 0;
		}

	.audioplayer-volume
	{
		width: 2.5em; /* 40 */
		height: 100%;
		border-left: 0px solid #111;
		border-left-color: rgba( 0, 0, 0, .25 );
		text-align: left;
		text-indent: -9999px;
		cursor: pointer;
		z-index: 2;
		top: 0;
		right: 0;
	}
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
		.audioplayer-volume:hover,
		.audioplayer-volume:focus
		{
			background-color: #333;
		}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>

		.audioplayer-volume:hover,
		.audioplayer-volume:focus
		{
			background-color: #fff;
		}
<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
		.audioplayer-volume:hover,
		.audioplayer-volume:focus
		{
			background-color: <?php echo $player_bar_color; ?>;
		}


<?php
	 break;
     } 
?>
		.audioplayer-volume-button
		{
			width: 100%;
			height: 100%;
		}
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
			.audioplayer-volume-button a
			{
				width: 0.313em; /* 5 */
				height: 0.375em; /* 6 */
				background-color: #fff;
				display: block;
				position: relative;
				z-index: 1;
				top: 40%;
				left: 35%;
			}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>
			.audioplayer-volume-button a
			{
				width: 0.313em; /* 5 */
				height: 0.375em; /* 6 */
				background-color: #222;
				display: block;
				position: relative;
				z-index: 1;
				top: 40%;
				left: 35%;
			}
<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
	.audioplayer-volume-button a
			{
				width: 0.313em; /* 5 */
				height: 0.375em; /* 6 */
				background-color: <?php echo $player_text_color; ?>;
				display: block;
				position: relative;
				z-index: 1;
				top: 40%;
				left: 35%;
			}
<?php
	  break;
      }
?>
				.audioplayer-volume-button a:before,
				.audioplayer-volume-button a:after
				{
					content: '';
					position: absolute;
				}
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
				.audioplayer-volume-button a:before
				{
					width: 0;
					height: 0;
					border: 0.5em solid transparent; /* 8 */
					border-left: none;
					border-right-color: #fff;
					z-index: 2;
					top: 50%;
					right: -0.25em;
					margin-top: -0.5em; /* 8 */
				}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>
				.audioplayer-volume-button a:before
				{
					width: 0;
					height: 0;
					border: 0.5em solid transparent; /* 8 */
					border-left: none;
					border-right-color: #222;
					z-index: 2;
					top: 50%;
					right: -0.25em;
					margin-top: -0.5em; /* 8 */
				}
<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
				.audioplayer-volume-button a:before
				{
					width: 0;
					height: 0;
					border: 0.5em solid transparent; /* 8 */
					border-left: none;
					border-right-color: <?php echo $player_text_color; ?>;
					z-index: 2;
					top: 50%;
					right: -0.25em;
					margin-top: -0.5em; /* 8 */
				}
<?php
	  break;
      } 
?>
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
			.audioplayer:not(.audioplayer-mute) .audioplayer-volume-button a:after
				{
					/* "volume" icon by Nicolas Gallagher, http://nicolasgallagher.com/pure-css-gui-icons */
					width: 0.313em; /* 5 */
					height: 0.313em; /* 5 */
					border: 0.25em double #fff; /* 4 */
					border-width: 0.25em 0.25em 0 0; /* 4 */
					left: 0.563em; /* 9 */
					top: -0.063em; /* 1 */
					-webkit-border-radius: 0 0.938em 0 0; /* 15 */
					-moz-border-radius: 0 0.938em 0 0; /* 15 */
					border-radius: 0 0.938em 0 0; /* 15 */
					-webkit-transform: rotate( 45deg );
					-moz-transform: rotate( 45deg );
					-ms-transform: rotate( 45deg );
					-o-transform: rotate( 45deg );
					transform: rotate( 45deg );
				}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>
				.audioplayer:not(.audioplayer-mute) .audioplayer-volume-button a:after
				{
					/* "volume" icon by Nicolas Gallagher, http://nicolasgallagher.com/pure-css-gui-icons */
					width: 0.313em; /* 5 */
					height: 0.313em; /* 5 */
					border: 0.25em double #222; /* 4 */
					border-width: 0.25em 0.25em 0 0; /* 4 */
					left: 0.563em; /* 9 */
					top: -0.063em; /* 1 */
					-webkit-border-radius: 0 0.938em 0 0; /* 15 */
					-moz-border-radius: 0 0.938em 0 0; /* 15 */
					border-radius: 0 0.938em 0 0; /* 15 */
					-webkit-transform: rotate( 45deg );
					-moz-transform: rotate( 45deg );
					-ms-transform: rotate( 45deg );
					-o-transform: rotate( 45deg );
					transform: rotate( 45deg );
				}

<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
	.audioplayer:not(.audioplayer-mute) .audioplayer-volume-button a:after
				{
					/* "volume" icon by Nicolas Gallagher, http://nicolasgallagher.com/pure-css-gui-icons */
					width: 0.313em; /* 5 */
					height: 0.313em; /* 5 */
					border: 0.25em double <?php echo $player_text_color; ?>; /* 4 */
					border-width: 0.25em 0.25em 0 0; /* 4 */
					left: 0.563em; /* 9 */
					top: -0.063em; /* 1 */
					-webkit-border-radius: 0 0.938em 0 0; /* 15 */
					-moz-border-radius: 0 0.938em 0 0; /* 15 */
					border-radius: 0 0.938em 0 0; /* 15 */
					-webkit-transform: rotate( 45deg );
					-moz-transform: rotate( 45deg );
					-ms-transform: rotate( 45deg );
					-o-transform: rotate( 45deg );
					transform: rotate( 45deg );
				}
<?php
	 break;
     }
 ?>
<?php	switch($select_audio_player){

		case 'simplepodcastpressblack'	: ?>
		.audioplayer-volume-adjust
		{
			height: 6.25em; /* 100 */
			cursor: default;
			position: absolute;
			left: 0;
			right: -1px;
			top: -9999px;
			background: #333;
			
			-webkit-border-top-left-radius: 2px;
			-webkit-border-top-right-radius: 2px;
			-moz-border-radius-topleft: 2px;
			-moz-border-radius-topright: 2px;
			border-top-left-radius: 2px;
			border-top-right-radius: 2px;
		}
	.audioplayer-volume-adjust > div
			{
				width: 40%;
				height: 80%;
				background-color: #333;
				cursor: pointer;
				position: relative;
				z-index: 1;
				margin: 30% auto 0;
			}
				.audioplayer-volume-adjust div div
				{
					width: 100%;
					height: 100%;
					position: absolute;
					bottom: 0;
					left: 0;
					background: #fff;
					
				}
<?php break;
	  case 'simplepodcastpresswhite'	: 
?>
	.audioplayer-volume-adjust
		{
			height: 6.25em; /* 100 */
			cursor: default;
			position: absolute;
			left: 0;
			right: -1px;
			top: -9999px;
			background: #fff;
			-webkit-border-top-left-radius: 2px;
			-webkit-border-top-right-radius: 2px;
			-moz-border-radius-topleft: 2px;
			-moz-border-radius-topright: 2px;
			border-top-left-radius: 2px;
			border-top-right-radius: 2px;
		}
	.audioplayer-volume-adjust > div
			{
				width: 40%;
				height: 80%;
				background-color: #fff;
				cursor: pointer;
				position: relative;
				z-index: 1;
				margin: 30% auto 0;
			}
				.audioplayer-volume-adjust div div
				{
					width: 100%;
					height: 100%;
					position: absolute;
					bottom: 0;
					left: 0;
					background: #222;
				
				}
<?php
	 break;
	 case 'simplepodcastpresscustomcolor'	: 
?>
	.audioplayer-volume-adjust
		{
			height: 6.25em; /* 100 */
			cursor: default;
			position: absolute;
			left: 0;
			right: -1px;
			top: -9999px;
			background: <?php echo $player_bar_color; ?>;
			background: -webkit-gradient( linear, left top, left bottom, from( <?php echo $player_bar_color; ?> ), to( <?php echo $player_bar_color_hover; ?> ) );
			background: -webkit-linear-gradient( top, <?php echo $player_bar_color; ?>, <?php echo $player_bar_color_hover; ?> );
			background: -moz-linear-gradient( top, <?php echo $player_bar_color; ?>, <?php echo $player_bar_color_hover; ?> );
			background: -ms-radial-gradient( top, <?php echo $player_bar_color; ?>, <?php echo $player_bar_color_hover; ?> );
			background: -o-linear-gradient( top, <?php echo $player_bar_color; ?>, <?php echo $player_bar_color_hover; ?> );
			background: linear-gradient( top, <?php echo $player_bar_color; ?>, <?php echo $player_bar_color_hover; ?> );
			-webkit-border-top-left-radius: 2px;
			-webkit-border-top-right-radius: 2px;
			-moz-border-radius-topleft: 2px;
			-moz-border-radius-topright: 2px;
			border-top-left-radius: 2px;
			border-top-right-radius: 2px;
		}
	.audioplayer-volume-adjust > div
			{
				width: 40%;
				height: 80%;
				background-color: <?php echo $player_bar_color; ?>;
				cursor: pointer;
				position: relative;
				z-index: 1;
				margin: 30% auto 0;
			}
				.audioplayer-volume-adjust div div
				{
					width: 100%;
					height: 100%;
					position: absolute;
					bottom: 0;
					left: 0;
					background: <?php echo $progress_bar_color; ?>;
					background: -webkit-gradient( linear, left top, right top, from( <?php echo $progress_bar_color; ?> ), to( <?php echo $progress_bar_color_hover; ?> ) );
					background: -webkit-linear-gradient( left, <?php echo $progress_bar_color; ?>, <?php echo $progress_bar_color_hover; ?> );
					background: -moz-linear-gradient( left, <?php echo $progress_bar_color; ?>, <?php echo $progress_bar_color_hover; ?> );
					background: -ms-radial-gradient( left, <?php echo $progress_bar_color; ?>, <?php echo $progress_bar_color_hover; ?> );
					background: -o-linear-gradient( left, <?php echo $progress_bar_color; ?>, <?php echo $progress_bar_color_hover; ?> );
					background: linear-gradient( left, <?php echo $progress_bar_color; ?>, <?php echo $progress_bar_color_hover; ?> );
				}
<?php
	break;
 	} 
?>
			.audioplayer-volume:not(:hover) .audioplayer-volume-adjust
			{
				opacity: 0;
			}
			.audioplayer-volume:hover .audioplayer-volume-adjust
			{
				top: auto;
				bottom: 100%;
			}
		
		.audioplayer-novolume .audioplayer-volume
		{
			display: none;
		}

	.audioplayer-play,
	.audioplayer-pause,
	.audioplayer-volume a
	{
		-moz-filter: drop-shadow( 1px 1px 0 #000 );
		-ms-filter: drop-shadow( 1px 1px 0 #000 );
		-o-filter: drop-shadow( 1px 1px 0 #000 );
		filter: drop-shadow( 1px 1px 0 #000 );
	}
	.audioplayer-bar,
	.audioplayer-bar div,
	.audioplayer-volume-adjust div
	{
		-webkit-border-radius: 4px;
		-moz-border-radius: 4px;
		border-radius: 4px;
	}
	.audioplayer-bar,
	.audioplayer-volume-adjust > div
	{
		/* -webkit-box-shadow: -1px -1px 0 rgba( 0, 0, 0, .5 ), 1px 1px 0 rgba( 255, 255, 255, .1 ); */
		/* -moz-box-shadow: -1px -1px 0 rgba( 0, 0, 0, .5 ), 1px 1px 0 rgba( 255, 255, 255, .1 ); */
		/* box-shadow: -1px -1px 0 rgba( 0, 0, 0, .5 ), 1px 1px 0 rgba( 255, 255, 255, .1 ); */
	}
	.audioplayer-volume-adjust div div,
	.audioplayer-bar-played
	{
		-webkit-box-shadow: inset 0 0 5px rgba( 255, 255, 255, .5 );
		-moz-box-shadow: inset 0 0 5px rgba( 255, 255, 255, .5 );
		box-shadow: inset 0 0 5px rgba( 255, 255, 255, .5 );
	}
	.audioplayer-volume-adjust
	{
		-webkit-box-shadow: -2px -2px 2px rgba( 0, 0, 0, .15 ), 2px -2px 2px rgba( 0, 0, 0, .15 );
		-moz-box-shadow: -2px -2px 2px rgba( 0, 0, 0, .15 ), 2px -2px 2px rgba( 0, 0, 0, .15 );
		box-shadow: -2px -2px 2px rgba( 0, 0, 0, .15 ), 2px -2px 2px rgba( 0, 0, 0, .15 );
	}
	.audioplayer *,
	.audioplayer *:before,
	.audioplayer *:after
	{
		-webkit-transition: color .25s ease, background-color .25s ease, opacity .5s ease;
		-moz-transition: color .25s ease, background-color .25s ease, opacity .5s ease;
		-ms-transition: color .25s ease, background-color .25s ease, opacity .5s ease;
		-o-transition: color .25s ease, background-color .25s ease, opacity .5s ease;
		transition: color .25s ease, background-color .25s ease, opacity .5s ease;
	}

.player_container{

margin-top: 25px;
margin-bottom: 45px;
<?php echo $container_width; ?>
clear: both;
}

/* responsiveness */

@media only screen and ( max-width: 32.5em ) /* 520 */
{
	body
	{
		/* -webkit-box-shadow: inset 0 0 9.375em rgba( 0, 0, 0, .5 );  */
		/* -moz-box-shadow: inset 0 0 9.375em rgba( 0, 0, 0, 5 );  */
		/* box-shadow: inset 0 0 9.375em rgba( 0, 0, 0, .5 );  */
	}
	#wrapper
	{
		width: 100%;
		height: auto;
		position: static;
		padding: 1.25em; /* 20 */
		margin: 0;
	}



}



/* portrait phone */
@media screen and (max-width:29.9999em) {

}



/* landscape phone and portrait tablet (>= 480px < 960px) */
@media screen and (min-width:30em) and (max-width:59.9999em) {

    .download-box 
    {
        font-weight: normal !important;
        /* text-align: center !important; */
    }


}


/* landscape tablet and normal monitor (>= 960px < 1440px) */
@media screen and (min-width:60em) and (max-width:89.9999em) {
}

/* bigger monitor (>= 1440px) */
@media screen and (min-width:90em) {
}

/* big monitor (>= 1920px) */
@media screen and (min-width:120em) {
}



/* Container Box Properties */

.download-box {
    /* border: 2px solid transparent !important; */
    font-weight: normal !important;
    text-align: center !important;
    /* color: #AAAAAA; */
    /* padding: 2.2rem; */
    /* margin-top:5px; */
    /* margin-bottom:5px; */
}






/* Button Properties */

.sppbuttons {
    margin-top: 25px; 
    margin-bottom: 25px; 
    text-align: center !important;
}

.sppbuttons a {
	text-decoration: none !important;
}


.button-download, .button-itunes, .button-spprss, .button-sppreview, .button-spplisten, .button-sppandroid, .button-stitcher, .button-clammr, .button-soundcloud, .spp-button-custom1, .spp-button-custom2, .spp-button-custom3, .spp-button-custom4, .spp-button-custom5, .spp-button-custom6, .spp-button-leadbox {
    /* margin-top: 5px !important; */
    margin-bottom: 5px !important;
    margin-left: 2px !important;
	<?php echo $minbutton_width; ?>
    font-weight: bold !important;
    box-shadow: none !important;
    color: #FFFFFF !important;
    cursor: pointer !important;
    outline: medium none !important;
    padding: 11px !important;
    top: 30px !important;
    text-decoration: none !important;
    font-size: 13px !important;
    display: inline-block;
}



.button-sppsidebar {
    
    margin-top: 0px !important;
    text-align: center !important;

    border: 0px solid transparent !important;
    font-weight: bold !important;
    box-shadow: none !important;
    color: #FFFFFF !important;
    cursor: pointer !important;
    outline: medium none !important;
    padding-top: 7px !important;
    padding-bottom: 7px !important;
    text-transform: uppercase !important;
    text-decoration: none !important;
    background-color: <?php echo $btn_itunes_color; ?>;
    font-size: 12px !important;
    text-transform: uppercase !important;
    width: 100% !important; 
    line-height: 250% !important;
    display:block !important; 
    
}


.button-sppsidebar2 {
    
    margin-top: 1px;
    text-align: center !important;

    border: 0px solid transparent !important;
    font-weight: bold !important;
    box-shadow: none !important;
    color: #FFFFFF !important;
    cursor: pointer !important;
    outline: medium none !important;
    padding-top: 7px !important;
    padding-bottom: 7px !important;
    text-transform: uppercase !important;
	top: 30px !important;
    text-decoration: none !important;
    background-color: <?php echo $btn_itunes_color; ?>;
    font-size: 12px !important;
    text-transform: uppercase !important;
    width: 98.5% !important; 
    line-height: 250% !important;
    display:inline-table !important; 
      
    
}

.button-itunes {
    background-color: <?php echo $btn_itunes_color; ?>;

}

.button-stitcher {
    background-color: <?php echo $btn_stiticher_color; ?>;


}


.button-download {
    background-color: <?php echo $btn_download_color; ?>;

}


.button-soundcloud {
    background-color: <?php echo $btn_soundcloud_color; ?>;

}

.button-clammr {
    background-color: <?php echo $btn_ClammrIT_color; ?>;

}

.button-spplisten{
    background-color: <?php echo $btn_spplisten_color; ?>;

}

.button-spprss{
    background-color: <?php echo $btn_spprss_color; ?>;

}

.button-sppandroid{
    background-color: <?php echo $btn_sppandroid_color; ?>;

}

.button-sppreview{
    background-color: <?php echo $btn_sppreview_color; ?>;

}


.spp-button-custom1{
    background-color: <?php echo $btn_spp_custom_color1; ?>;

}
.spp-button-custom2{
    background-color: <?php echo $btn_spp_custom_color2; ?>;

}

.spp-button-custom3{
    background-color: <?php echo $btn_spp_custom_color3; ?>;

}

.spp-button-custom4{
    background-color: <?php echo $btn_spp_custom_color4; ?>;

}
.spp-button-custom5{
    background-color: <?php echo $btn_spp_custom_color5; ?>;

}

.spp-button-custom6{
    background-color: <?php echo $btn_spp_custom_color6; ?>;

}


.spp-button-leadbox{

    background-color: <?php echo $btn_sppleadbox_color; ?>;

}


/* Button Hover Properties */

.button:hover, .button-itunes:hover, .button-download:hover, .button-spprss:hover, .button-spplisten:hover, .button-sppreview:hover, .button-sppandroid:hover, .button-stitcher:hover, .button-clammr:hover, .button-soundcloud:hover, .button-sppsidebar:hover, .spp-button-custom1:hover, .spp-button-custom2:hover, .spp-button-custom3:hover, .spp-button-custom4:hover, .spp-button-custom5:hover, .spp-button-custom6:hover, .spp-button-leadbox:hover {
    color: #FFFFFF !important;
    text-decoration: none !important;
}


.button-sppsidebar:hover {
    background-color: <?php echo $ituneshover; ?>;
}

.button-itunes:hover {
    background-color: <?php echo $ituneshover; ?>;
}


.button-spprss:hover {
    background-color: <?php echo $spprsshover; ?>;
}


.button-spplisten:hover {
    background-color: <?php echo $spplistenhover; ?>;
}


.button-sppreview:hover {
    background-color: <?php echo $sppreviewhover; ?>;
}


.button-sppandroid:hover {
    background-color: <?php echo $sppandroidhover; ?>;
}


.button-download:hover {
    background-color: <?php echo $downloadhover; ?>;
}


.button-stitcher:hover {
    background-color: <?php echo $stitcherhover; ?>;
}


.button-soundcloud:hover {
    background-color: <?php echo $soundcloudhover; ?>;
}

.button-clammr:hover {
    background-color: <?php echo $clammrhover; ?>;
}

.spp-button-custom1:hover{
    background-color: <?php echo $btn_spp_custom_color1_hover; ?>;
}
.spp-button-custom2:hover{
    background-color: <?php echo $btn_spp_custom_color2_hover; ?>;
}

.spp-button-custom3:hover{
    background-color: <?php echo $btn_spp_custom_color3_hover; ?>;
}

.spp-button-custom4:hover{
    background-color: <?php echo $btn_spp_custom_color4_hover; ?>;
}
.spp-button-custom5:hover{
    background-color: <?php echo $btn_spp_custom_color5_hover; ?>;
}

.spp-button-custom6:hover{
    background-color: <?php echo $btn_spp_custom_color6_hover; ?>;
}

.spp-button-leadbox:hover{
    background-color: <?php echo $btn_sppleadbox_color_hover; ?>;
}

/* Icons inside buttons properties */

.button-download:before, .button-itunes:before, .button-stitcher:before, .button-clammr:before, .button-soundcloud:before, .button-spprss:before, .button-spplisten:before, .button-sppandroid:before, .button-sppreview:before{
    font-weight: normal !important;
    position: relative !important;
    display: inline !important;
    padding-right: 7px !important;
}

.button-download:before {
	font-family: 'fontawsome';
    content:  "\f019";
}


.button-spprss:before {
	font-family: 'fontawsome';
    content:  "\f09e";
}



.button-sppreview:before {
	font-family: 'fontawsome';
    content:  "\f006";
}



.button-spplisten:before {
	font-family: 'fontawsome';
    content:  "\f025";
}


.button-sppandroid:before {
	font-family: 'fontawsome';
    content:  "\f17b";
}


.button-sppsidebar:before {
}


.button-itunes:before {
	font-family: 'fontawsome';
   content:  "\f001";
}

.button-stitcher:before {
	font-family: 'fontawsome';
     content:  "\f080";
}

.button-soundcloud:before {
	font-family: 'fontawsome';
    content:  "\f0c2";
}


.button-clammr:before {
	font-family: 'fontawsome';
    content:  "\f01e";
}





/* Transcript Box Properties */

.button-mp3:before, .transcript .headline:before, .transcript .speaker:before {
    font-weight: normal !important;
    text-decoration: none !important;
}

.transcript-box {
    text-decoration: none !important;
    text-align: left;
}

.transcript-box a,
    text-decoration: none !important;   
}


	.accordion_content {
		text-decoration: none !important;
        width: 60%;
		margin: 50px auto;
		padding: 20px;
	}
	.accordion_content h1 {
		text-decoration: none !important;
        font-weight: 400;
		text-transform: uppercase;
		margin: 0;
	}
	.accordion_content h2 {
		text-decoration: none !important;
        font-weight: 400;
		text-transform: uppercase;
		margin: 0 0 20px;
	}
	.accordion_content p {
		text-decoration: none !important;
		font-weight: 300;
		line-height: 1.5em;
		margin: 0 0 20px;
	}
	.accordion_content p:last-child {
		margin: 0;
        text-decoration: none !important;
	}
	.accordion_content a.button {
		text-decoration: none !important;
        display: inline-block;
		padding: 10px 20px;
		background: #ff0;
		text-decoration: none;
	}
	.accordion_content a.button:hover {
		text-decoration: none !important;
        background: #000;
	}
	.accordion_content.title {
        text-decoration: none !important;
        font-weight: bold;
		position: relative;
		background: none;
		border: 2px solid transparent !important;
	}
	.accordion_content.title h1 span.demo {
		text-decoration: none !important;
        display: inline-block;
		padding: 5px 10px;
		background: #000;
		vertical-align: top;
		margin: 7px 0 0;
	}
	.accordion_content.title .back-to-article {
		text-decoration: none !important;
        position: absolute;
		bottom: -20px;
		left: 20px;
	}
	.accordion_content.title .back-to-article a {
		text-decoration: none !important;
        padding: 10px 20px;
		background: #f60;
		text-decoration: none;
	}
	.accordion_content.title .back-to-article a:hover {
		text-decoration: none !important;
        background: #f90;
	}
	.accordion_content.title .back-to-article a i {
		text-decoration: none !important;
        margin-left: 0px;
	}
	.fa {

		text-decoration: none !important;
		line-height:2 !important;

	}
	.accordion_content.white {
		text-decoration: none !important;
        background: #fff;
		box-shadow: 0 0 10px #999;
	}
	.accordion_content.black {
		text-decoration: none !important;
        background: #000;
	}
	.accordion_content.black p {
		text-decoration: none !important;
	}
	.accordion_content.black p a {
		text-decoration: none !important;
	}
	
	.accordion-container {
		text-decoration: none !important;
        width: 100%;
		clear: both;
	}
	.accordion-toggle {
	    text-decoration: none !important;
        border: none !important;
	    color: <?php echo $transcript_color; ?> !important;
	    position: relative;
	    text-decoration: none !important;
	    padding-right: 40px;
        padding-top: 18px;
        padding-bottom: 17px;
	}
	.accordion-toggle.open {
		color: <?php echo $transcript_color; ?> !important;
        text-decoration: none !important;
	}
	.accordion-toggle:hover {
        color: <?php echo $transcript_color; ?> !important;
		text-decoration: none !important;
        border: 0px solid transparent !important;   
	}
	.accordion-toggle span.toggle-icon {
	    text-decoration: none !important;
	    position: absolute;
        right: 20px;
	    top: 14px;  
	}
	.accordion-accordion_content {
		text-decoration: none !important;
        display: none;
		padding: 10px;
		overflow: auto;
	}
	.accordion-accordion_content p {
	    text-decoration: none !important;
	
	}
	.accordion-accordion_content img {
		text-decoration: none !important;
        display: block;
		float: left;
		margin: 0 15px 10px 0;
		max-width: 100%;
		height: auto;
	}
	
	/* media query for mobile */
	@media (max-width: 767px) {
		.accordion_content {
			width: auto;
		}
		.accordion-accordion_content {
			padding: 15px;
			overflow: inherit;
		}
	}




/* SPP Optin Box Properties */


.spp-optin-box {
display:inline-table !important;
text-align: center !important;
box-sizing: border-box !important;
clear: both !important;
color: rgb(34, 34, 34) !important;
display: block !important;
font-size: 12px !important;
line-height: 18px !important;
margin-bottom: 0px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
}



.spp-optin-box-padding {
background-color: <?php echo $opt_container_color; ?> !important;
background-position: 50% 0% !important;
background-repeat: no-repeat !important;
border-bottom-style: solid !important;
border-bottom-width: 0px !important;
border-image-outset: 0px !important;
border-image-repeat: stretch !important;
border-image-slice: 100% !important;
border-image-source: none !important;
border-image-width: 1 !important;
border-left-style: solid !important;
border-left-width: 0px !important;
border-right-style: solid !important;
border-right-width: 0px !important;
border-top-left-radius: 0px !important;
border-top-right-radius: 0px !important;
border-bottom-left-radius: 0px !important;
border-bottom-right-radius: 0px !important;
border-top-style: solid !important;
border-top-width: 0px !important;
box-sizing: border-box !important;
color: rgb(34, 34, 34) !important;
display: block !important;
font-size: 12px !important;

line-height: 18px !important;
margin-bottom: 0px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
padding-bottom: 15px !important;
padding-left: 15px !important; 
padding-right: 15px !important;
padding-top: 15px !important;
}



.spp-optin-box-form-wrap form {
padding-top:10px;
margin:0 !important;
}

.clear-subscribe {
clear:both !important;
}

.spp-optin-box-content {
text-align: center !important;
box-sizing: border-box !important;
color: rgb(40, 40, 40) !important;
display: block !important;
font-size: 12px !important;
line-height: 18px !important;
position: relative !important;
z-index: 10 !important;
}


@media only screen and (max-width:480px){

.subscribetxt{
font-size: 17px !important;
}


}

@media only screen and (max-width: 600px){
height:166px !important;
}



.spp-optin-box-headline {
word-break: normal !important;
text-align: center !important;
box-sizing: border-box !important;
clear: none !important;
color: rgb(40, 40, 40) !important;
display: inline-block !important;
font-size: 20px !important;
font-style: normal !important;
font-weight: bold !important;
letter-spacing: normal !important;
line-height: 23px !important;
margin-bottom: 7px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
text-transform: none !important;
}


.spp-optin-box-subheadline {
word-break: normal !important;
text-align: center !important;
box-sizing: border-box !important;
clear: none !important;
color: rgb(85, 85, 85) !important;
display: block !important;
font-size: 15px !important;
font-style: normal !important;
font-weight: bold !important;
line-height: 18px !important;
margin-bottom: 10px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
text-transform: none !important;
font-family:Arial, Helvetica, sans-serif !important;
}



.spp-optin-box-form-wrap {
box-sizing: border-box !important;
color: rgb(40, 40, 40) !important;
display: block !important;
font-size: 12px !important;
line-height: 18px !important;
overflow-x: hidden !important;
overflow-y: hidden !important;
}

.spp-optin-box-field {
text-align: center !important;
box-sizing: border-box !important;
color: rgb(40, 40, 40) !important;
display: inline-block !important;
/* text-transform: uppercase !important; */
border: 2px solid transparent !important;
line-height: 18px !important;
margin-bottom: 10px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
max-width: 400px !important; /* 200 */
min-width:200px !important; /* 170 */
zoom: 1 !important;

box-shadow: none !important;
-webkit-box-shadow: none !important;
-moz-box-shadow: none !important;
}

.spp-optin-box-field-submit {
text-align: center !important;
box-sizing: border-box !important;
color: rgb(40, 40, 40) !important;
display: inline-block !important;
font-size: 12px !important;  /* 15px */
/* text-transform: uppercase !important; */
border: 2px solid transparent !important;
line-height: 18px !important;
margin-bottom: 10px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
zoom: 1 !important;

box-shadow: none !important;
-webkit-box-shadow: none !important;
-moz-box-shadow: none !important;
}

.spp-optin-box-field input[type*="text"]{
text-align: center !important;
font-size: 12px !important; /* 15px */
height: 46px !important;
line-height: 18px !important;
border: 2px solid transparent !important;
margin:0;
display: inline-block !important;
width: 90% !important;
border-radius: 0px !important;
background-color: #FFFFFF !important;
border: 1px solid #CCCCCC !important;
padding-left: 5px !important; 
padding-right: 5px !important; 
padding-top: 0px !important;
padding-bottom: 0px !important;
box-shadow: none !important;
-webkit-box-shadow: none !important;
-moz-box-shadow: none !important;
vertical-align: middle !important;

}


spp-optin-box-field input[type*="text"]:focus {
  box-shadow: 0 0 0px rgba(0, 0, 0, 0) !important;
  padding: 0px 0px 0px 0px !important;
  margin: 0px 0px 0px 0px !important;
  border: 0px solid rgba(0, 0, 0, 0) !important;
}



.spp-optin-box-lastfield-second-row {
text-align: center !important;
box-sizing: border-box !important;
color: rgb(40, 40, 40) !important;
display: block !important;
font-size: 12px !important; /* 15px */
height: 40px !important;
line-height: 18px !important;
margin-bottom: 10px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
width: auto !important;
zoom: 1 !important;
padding-left: 20px !important; 
padding-right: 20px !important; 

}

.spp-optin-box-lastfield {
text-align: center !important;
box-sizing: border-box !important;
color: rgb(40, 40, 40) !important;
display: inline-block !important;
font-size: 12px !important;  /* 15px */
/* text-transform: uppercase !important; */
border: 2px solid transparent !important;
line-height: 18px !important;
margin-bottom: 10px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
max-width: 400px !important; /* 200 */
min-width:200px !important; /* 170 */
zoom: 1 !important;
box-shadow: none !important;
-webkit-box-shadow: none !important;
-moz-box-shadow: none !important;


}

.spp-optin-box-lastfield input[type*="submit"] {
text-align: center !important;
line-height: 18px !important; 
margin-top: 0px !important; 
vertical-align: middle !important;
}


.spp-optin-box-submit {
-webkit-appearance: none !important;
-webkit-background-clip: border-box !important;
-webkit-background-origin: padding-box !important;
-webkit-background-size: auto !important;
-webkit-box-shadow: none !important;
-webkit-rtl-ordering: logical !important;
-webkit-user-select: text !important;
-webkit-writing-mode: horizontal-tb !important;
align-items: flex-start !important;
background-attachment: scroll !important;
background-clip: border-box !important;
background-color: <?php echo $submit_button_color; ?> !important;
background-image: none !important;
background-origin: padding-box !important;
background-size: auto;
border-bottom-color: <?php echo $submit_button_color; ?> !important;
border-bottom-left-radius: 0px !important;
border-bottom-right-radius: 0px !important;
border-bottom-style: solid !important;
border-bottom-width: 3px !important;
border-image-outset: 0px !important;
border-image-repeat: stretch !important;
border-image-slice: 100% !important;
border-image-source: none !important;
border-image-width: 1 !important;
border-left-color: <?php echo $submit_button_color; ?> !important;
border-left-style: solid !important;
border-left-width: 3px !important;
border-right-color: <?php echo $submit_button_color; ?> !important;
border-right-style: solid !important;
border-right-width: 3px !important;
border-top-color: <?php echo $submit_button_color; ?> !important;
border-top-left-radius: 0px !important;
border-top-right-radius: 0px !important;
border-top-style: solid !important;
border-top-width: 3px !important;
box-shadow: none !important;
box-sizing: border-box !important;
color: <?php echo $submit_button_text; ?> !important;
cursor: pointer !important;
display: inline-block !important;
font-size: 13px !important;  /* 16px */
font-style: normal !important;
letter-spacing: normal !important;
line-height: 18px !important;
margin-bottom: 0px !important;
margin-left: 0px !important;
margin-right: 0px !important;
margin-top: 0px !important;
max-width: 100% !important;
padding-bottom: 5px !important;
padding-left: 5px !important; 
padding-right: 5px !important; 
padding-top: 5px !important;
text-align: center !important;
text-indent: 0px !important;
text-shadow: none !important;
text-transform: none !important;
border: 2px solid transparent !important;
white-space: pre !important;
width: auto !important;
word-spacing: 0px !important;
writing-mode: lr-tb !important;
zoom: 1 !important;
text-align: center !important;

border: 2px solid transparent !important;

    font-weight: bold !important;
    box-shadow: none !important;
    color: #FFFFFF !important;
    cursor: pointer !important;
    outline: medium none !important;
    padding: 14px !important;
    border-radius: 0px !important;
    text-decoration: none !important;
background-color: <?php echo $submit_button_color; ?> !important;
border: <?php echo $submit_button_color; ?> !important;
color: <?php echo $submit_button_text; ?> !important;
vertical-align: middle !important;

}
.spp-optin-box-submit:hover{

background-color:<?php echo $submit_button_color_hover; ?> !important;

}



@media only screen and (max-width:480px){


.spp-optin-box-subheadline{
}

.subscribetxt{
font-size: 17px !important;
}


}

@media only screen and (max-width: 600px) and (max-width: 700px){

}
@media (max-width: 767px) {
height:221px !important;
}

@media (min-width: 768px) and (max-width: 778px) {

}
@media (min-width: 768px) and (max-width: 979px) {

}


.spp-click-to-tweet a.spp-ctt-btn, .spp-ctt-text:before{
text-decoration: none !important;
color: <?php echo $twitter_text_color; ?> !important;
}
.spp-click-to-tweet{
border-left: 5px solid <?php echo $twitter_text_color; ?> !important;
}

<?php if ($btn_style_round == 1){ ?>

.button-sppsidebar, .button-download, .button-itunes, .button-spprss, .button-sppreview, .button-spplisten, .button-sppandroid, .button-stitcher, .button-soundcloud, .button-clammr, .spp-button-custom1, .spp-button-custom2, .spp-button-custom3, .spp-button-custom4, .spp-button-custom5, .spp-button-custom6, .spp-button-leadbox, .spp-optin-box-lastfield input[type*="submit"], .spp-optin-box-field input[type*="text"], .spp-optin-box-submit, .spp-optin-box-submit-button {
		
		-webkit-border-radius: 7px !important;
		-moz-border-radius: 7px !important;
        border-radius: 7px !important;
        vertical-align: middle !important;
}


<?php } ?>



<?php

$SPP_with_pp = get_option('replace_pp_with_spp');
$check = get_option('spp_check_shortcode');
    



if ($SPP_with_pp == 1) { ?>
.powerpress_player, powerpress_links, p.powerpress_links, .powerpress_links_mp3 {
    display:none;
}
<?php } ?>

a.spp-timestamp {
	cursor: pointer !important;
}

.releasedColumn
{
	width: 17%;
}
	
.downloadColumn { 
	width: 15%;
}

td.spp-episodes-released, td.spp-episodes-released-title  { 
	width: 17%;
}
td.spp-episodes-download, td.spp-episodes-download-title { 
	width: 15%;
	text-align: center;
}

td.spp-episodes-released-title, td.spp-episodes-podcast-title {
	font-weight: bold;
}

div.reviews_view img {
	max-width: 75px;
	margin-left: 5px;
}

div.reviews_view li {
	border-bottom: 0px;
	margin-left: 0px !important;	
}

div.reviews_view ol, div.reviews_view ul {
	margin-left: 0px !important;
}