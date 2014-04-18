<?php 
require_once ('shortcode_header.php');
add_action( 'admin_footer', 'generator_popup' );

/* Youtube shortcode ============================== */
add_shortcode('y', 'shortcode_youtube');
	function shortcode_youtube($atts) {
		$id = str_replace('=','',trim($atts[0]));
		extract( shortcode_atts( array(
			'height' => ''
		), $atts ) );
		return '<span class="video_wrapper fit"><iframe width="100%" height="'.$height.'" title="YouTube video player" src="http://www.youtube.com/embed/' . $id . '" frameborder="0"></iframe></span>';
	}


/* Vimeo shortcode ============================== */
add_shortcode('v', 'shortcode_vimeo');
	function shortcode_vimeo($atts) {
		$id = str_replace('=','',trim($atts[0]));
		extract( shortcode_atts( array(
			'height' => ''
		), $atts ) );
		return '<span class="video_wrapper fit"><iframe width="100%" height="'.$height.'" title="Vimeo video player" src="http://player.vimeo.com/video/' . $id . '" frameborder="0"></iframe></span>';
	}

/* Columns shortcode ============================== */
add_shortcode('column', 'shortcode_column');
	function shortcode_column($atts, $content = null) {
		$atts = shortcode_atts(
			array(
				'col'  => '1/3',
				'position' => 'middle',
			), $atts);
			
			switch($atts['col']){
				case '1/2':
					$class = 'six';
				break;
				case '1/3':
					$class = 'four';
				break;
				case '2/3':
					$class = 'eight';
				break;
				case '1/4':
					$class = 'three';
				break;
				case '3/4':
					$class = 'nine';
				break;
			}
			
			if($atts['position'] == 'first') {
				return '<div class="row"><div class="'.$class.' columns">' .do_shortcode($content). '</div>';
			} else if($atts['position'] == 'last') {
				return '<div class="'.$class.' columns end">' .do_shortcode($content). '</div><div class="clear"></div></div>';
			} else {
				return '<div class="'.$class.' columns">' .do_shortcode($content). '</div>';
			}

	}

	
/* Button shortcode ============================== */
add_shortcode('button', 'shortcode_button');
	function shortcode_button($atts, $content = null) {
		extract(shortcode_atts(array(
			'color' => '',
			'size' => '',
			'width' => '',
			'url' => '',
			'target' => '',
			'text' => 'Button'
		), $atts));	
		
		switch($size){
			case 'normal':
				$add_size = '';
			break;
			
			case 'big':
				$add_size = ' big';
			break;
			
			case 'small':
				$add_size = ' small';
			break;
			
			default:
				$add_size = '';
			break;
		}

		if($width == 'full') $add_width = ' full';
		else $add_width = '';

		if($target!='none') $do_target = 'target="' . $target . '"';
		else $do_target = '';
		
		return '<a href="' . $url . '" '.$do_target.' class="button '. $color . $add_size . $add_width. '">' .trim($text). '</a>';
	}

/* Alert shortcode ============================== */
add_shortcode('alert', 'shortcode_alert');
	function shortcode_alert($atts, $content = null) {
		extract(shortcode_atts(array(
			'type' => '',
			'text' => ''
		), $atts));
		
		return '<div class="pbox ' . $atts['type'] . '">' .trim($text). '</div>';
	}
	
	
	
/* Dropcap shortcode ============================== */
add_shortcode('dropcap', 'shortcode_dropcap');
	function shortcode_dropcap( $atts, $content = null ) {  
		extract(shortcode_atts(array(
			'style'    => '',
			'text'    => ''
		), $atts));
		return '<span class="dropcap style-'.trim($style).'">' .trim($text). '</span>';  
		
}


/* Tabs shortcode ============================== */
add_shortcode('tabs', 'shortcode_tabs');
	function shortcode_tabs( $atts, $content = null) {
	$out = '<div class="tabs-container horizontal-tabs"><ul class="tabs">';
	
	$arr = explode(',',$atts['headings']);
	$i = 0;
	foreach ($arr as $title) {
		$i++;
		$out .= '<li><span>' . trim($title) . '</span></li>';
	}
	$out .= '</ul><div class="tab_panes">' . do_shortcode($content) . '</div></div>';
	
	return $out;
}

add_shortcode('tab', 'shortcode_tab');
	function shortcode_tab( $atts, $content = null ) {

	$out = '<div class="tab_pane">' . do_shortcode($content) .'</div>';
	
	return $out;  
}
	
/* Accordion shortcode ============================== */
// Warpper
add_shortcode('accordion', 'shortcode_accordion');
	function shortcode_accordion( $atts, $content = null ) {  
		$out = '<ul class="accordion">' .do_shortcode($content). '</ul>';
		return $out;  
}

add_shortcode('accord_item', 'shortcode_accord_item');
	function shortcode_accord_item( $atts, $content = null ) {  
		extract(shortcode_atts(array(
			'header'    => ''
		), $atts));
		
		$out = '<li><div class="accordion_head">' .$header. '</div>';
		$out .= '<div class="accordion_content">' .do_shortcode($content). '</div></li>';
		
		return $out;  
		
}

	

// add to admin header
function admin_scripts(){
	wp_enqueue_style('admin_shortcode_style', get_template_directory_uri().'/libs/shortcodes/admin_style.css');
}

add_action('admin_head', 'admin_scripts');

add_action('wp_ajax_shortcode_load_ajax', 'shortcode_ajax');

function shortcode_ajax(){
	// button for insert
	$button = '<li><label>&nbsp;</label><div class="right"><input type="button" id="submit" class="button-primary" value=" Insert shortcode" name="submit" /></div><div class="clear"></div></li>';
	
	$data = $_POST;
	if($data['do']!='none'){
		include('inc/'.$data['do'].'.php');
	}
	exit();
}

