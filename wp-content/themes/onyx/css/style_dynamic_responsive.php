<?php
$root = dirname(dirname(dirname(dirname(dirname(__FILE__)))));
if ( file_exists( $root.'/wp-load.php' ) ) {
    require_once( $root.'/wp-load.php' );
//    require_once( $root.'/wp-config.php' );
} else {
	$root = dirname(dirname(dirname(dirname(dirname(dirname(__FILE__))))));
	if ( file_exists( $root.'/wp-load.php' ) ) {
    require_once( $root.'/wp-load.php' );
//    require_once( $root.'/wp-config.php' );
	}
}
header("Content-type: text/css; charset=utf-8");
?>

@media only screen and (max-width: 1000px){
	
	<?php if (!empty($mkd_options['header_background_color'])) { ?>
	.header_bottom {
		background-color: <?php echo esc_attr($mkd_options['header_background_color']);  ?>;
	}
	<?php } ?>
	<?php if (!empty($mkd_options['mobile_background_color'])) { ?>
		.header_bottom,
		nav.mobile_menu{
				background-color: <?php echo esc_attr($mkd_options['mobile_background_color']);  ?> !important;
		}
	<?php } ?>
	
	 <?php if (isset($mkd_options['page_subtitle_fontsize']) && ($mkd_options['page_subtitle_fontsize']) < 28 && ($mkd_options['page_subtitle_fontsize']) !== '') { ?>
		.subtitle{
			font-size: <?php echo esc_attr($mkd_options['page_subtitle_fontsize']) *0.8;  ?>px;
		}
	 <?php }?>
		
	<?php if(isset($mkd_options['h1_fontsize']) && ($mkd_options['h1_fontsize'])>80) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($mkd_options['h1_fontsize'])*0.8; ?>px;			
		}
	<?php } ?>
	<?php if(isset($mkd_options['page_title_fontsize']) && ($mkd_options['page_title_fontsize'])>80) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($mkd_options['page_title_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h2_fontsize']) && ($mkd_options['h2_fontsize'])>70) { ?>
		.content h2{
			font-size:<?php echo esc_attr($mkd_options['h2_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h3_fontsize']) && ($mkd_options['h3_fontsize'])>70) { ?>
		.content h3{
			font-size:<?php echo esc_attr($mkd_options['h3_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h4_fontsize']) && ($mkd_options['h4_fontsize'])>70) { ?>
		.content h4{
			font-size:<?php echo esc_attr($mkd_options['h4_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h5_fontsize']) && ($mkd_options['h5_fontsize'])>70) { ?>
		.content h5{
			font-size:<?php echo esc_attr($mkd_options['h5_fontsize'])*0.8; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h6_fontsize']) && ($mkd_options['h6_fontsize'])>70) { ?>
		.content h6{
			font-size:<?php echo esc_attr($mkd_options['h6_fontsize'])*0.8; ?>px;
		}
	<?php } ?>

	<?php if(isset($mkd_options['portfolio_list_filter_height']) && $mkd_options['portfolio_list_filter_height'] !== '') { ?>
		.filter_outer.filter_portfolio{
			line-height: 2em;
		}
	<?php } ?>
}

@media only screen and (min-width: 600px) and (max-width: 768px){
	<?php if(isset($mkd_options['h1_fontsize']) && ($mkd_options['h1_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($mkd_options['h1_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['page_title_fontsize']) && ($mkd_options['page_title_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($mkd_options['page_title_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h2_fontsize']) && ($mkd_options['h2_fontsize'])>35) { ?>
		.content h2{
			font-size:<?php echo esc_attr($mkd_options['h2_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h3_fontsize']) && ($mkd_options['h3_fontsize'])>35) { ?>
		.content h3{
			font-size:<?php echo esc_attr($mkd_options['h3_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h4_fontsize']) && ($mkd_options['h4_fontsize'])>35) { ?>
		.content h4{
			font-size:<?php echo esc_attr($mkd_options['h4_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h5_fontsize']) && ($mkd_options['h5_fontsize'])>35) { ?>
		.content h5{
			font-size:<?php echo esc_attr($mkd_options['h5_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h6_fontsize']) && ($mkd_options['h6_fontsize'])>35) { ?>
		.content h6{
			font-size:<?php echo esc_attr($mkd_options['h6_fontsize'])*0.7; ?>px;
		}
	<?php } ?>
	
	<?php if (isset($mkd_options['page_subtitle_fontsize']) && ($mkd_options['page_subtitle_fontsize']) < 28 && ($mkd_options['page_subtitle_fontsize']) !== '') { ?>
		.subtitle{
			font-size: <?php echo esc_attr($mkd_options['page_subtitle_fontsize']) *0.8;  ?>px;
		}
	 <?php } ?>
}

@media only screen and (min-width: 480px) and (max-width: 768px){
	<?php if (isset($mkd_options['parallax_minheight']) && !empty($mkd_options['parallax_minheight'])) { ?>
        section.parallax_section_holder{
		height: auto !important;
		min-height: <?php echo esc_attr($mkd_options['parallax_minheight']); ?>px !important;
	}
	<?php } ?>
	
	<?php if (isset($mkd_options['header_background_color_mobile']) &&  !empty($mkd_options['header_background_color_mobile'])) { ?>
	header
	{
		 background-color: <?php echo esc_attr($mkd_options['header_background_color_mobile']);  ?> !important;
		 background-image:none;
	}
	<?php } ?>
}

@media only screen and (max-width: 600px){
	<?php if(isset($mkd_options['h1_fontsize']) && ($mkd_options['h1_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($mkd_options['h1_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['page_title_fontsize']) && ($mkd_options['page_title_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($mkd_options['page_title_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h2_fontsize']) && ($mkd_options['h2_fontsize'])>35) { ?>
			.content h2{
				font-size:<?php echo esc_attr($mkd_options['h2_fontsize'])*0.5; ?>px;
			}
	<?php } ?>
	<?php if(isset($mkd_options['h3_fontsize']) && ($mkd_options['h3_fontsize'])>35) { ?>
		.content h3{
			font-size:<?php echo esc_attr($mkd_options['h3_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h4_fontsize']) && ($mkd_options['h4_fontsize'])>35) { ?>
		.content h4{
			font-size:<?php echo esc_attr($mkd_options['h4_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h5_fontsize']) && ($mkd_options['h5_fontsize'])>35) { ?>
		.content h5{
			font-size:<?php echo esc_attr($mkd_options['h5_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h6_fontsize']) && ($mkd_options['h6_fontsize'])>35) { ?>
		.content h6{
			font-size:<?php echo esc_attr($mkd_options['h6_fontsize'])*0.5; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['title_span_background_color']) && !empty($mkd_options['title_span_background_color'])) { ?>
		.title h1 span{
			padding: 0 5px;
		}
	<?php } ?>

	<?php if(isset($mkd_options['portfolio_list_filter_height']) && $mkd_options['portfolio_list_filter_height'] !== '') { ?>
		.filter_outer.filter_portfolio{
			height:auto;
		}
	<?php } ?>
}

@media only screen and (max-width: 480px){

	<?php if(isset($mkd_options['h1_fontsize']) && ($mkd_options['h1_fontsize'])>35) { ?>
			.title h1,
			.title h1.title_like_separator .vc_text_separator.full .separator_content{
				font-size:<?php echo esc_attr($mkd_options['h1_fontsize'])*0.4; ?>px;
			}
	<?php } ?>
	<?php if(isset($mkd_options['page_title_fontsize']) && ($mkd_options['page_title_fontsize'])>35) { ?>
		.title h1,
		.title h1.title_like_separator .vc_text_separator.full .separator_content{
			font-size:<?php echo esc_attr($mkd_options['page_title_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h2_fontsize']) && ($mkd_options['h2_fontsize'])>35) { ?>
			.content h2{
				font-size:<?php echo esc_attr($mkd_options['h2_fontsize'])*0.4; ?>px;
			}
	<?php } ?>
	<?php if(isset($mkd_options['h3_fontsize']) && ($mkd_options['h3_fontsize'])>35) { ?>
		.content h3{
			font-size:<?php echo esc_attr($mkd_options['h3_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h4_fontsize']) && ($mkd_options['h4_fontsize'])>35) { ?>
		.content h4{
			font-size:<?php echo esc_attr($mkd_options['h4_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h5_fontsize']) && ($mkd_options['h5_fontsize'])>35) { ?>
		.content h5{
			font-size:<?php echo esc_attr($mkd_options['h5_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
	<?php if(isset($mkd_options['h6_fontsize']) && ($mkd_options['h6_fontsize'])>35) { ?>
		.content h6{
			font-size:<?php echo esc_attr($mkd_options['h6_fontsize'])*0.4; ?>px;
		}
	<?php } ?>
		
	<?php if (isset($mkd_options['parallax_minheight']) && !empty($mkd_options['parallax_minheight'])) { ?>
	section.parallax_section_holder{
		height: auto !important;
		min-height: <?php echo esc_attr($mkd_options['parallax_minheight']); ?>px !important;
	}
	<?php } ?>
	
	
	<?php if (isset($mkd_options['header_background_color_mobile']) &&  !empty($mkd_options['header_background_color_mobile'])) { ?>
	header
	{
		 background-color: <?php echo esc_attr($mkd_options['header_background_color_mobile']);  ?> !important;
		 background-image:none;
	}
	<?php } ?>

	<?php
		if(isset($mkd_options['masonry_gallery_square_big_title_font_size']) && ($mkd_options['masonry_gallery_square_big_title_font_size']) > 30) { ?>
		        .masonry_gallery_item.square_big h3 {
	        		font-size: <?php echo esc_attr($mkd_options['masonry_gallery_square_big_title_font_size'])*0.7; ?>px;
	    		}
		<?php }
	?>
}