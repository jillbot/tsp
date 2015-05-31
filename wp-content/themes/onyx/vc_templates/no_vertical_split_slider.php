<?php

$args = array(
    "background_color" => "",
	"disable_header_skin_change" => "no"
);
extract(shortcode_atts($args, $atts));

$background_color = esc_attr($background_color);
$disable_header_skin_change = esc_attr($disable_header_skin_change);

$mkd_preloader_style = '';
if($background_color != "") {
    $mkd_preloader_style .= "style='";
    if ($background_color != "") {
        $mkd_preloader_style .= "background-color:".$background_color.";";
    }
    $mkd_preloader_style .= "'";
}


$data_disable_header_skin_change = 'no';
if($disable_header_skin_change == "yes"){
	$data_disable_header_skin_change = 'yes';
}

$html = "";

$html .= '<div class="vertical_split_slider_preloader" '.$mkd_preloader_style.'><div class="ajax_loader"><div class="ajax_loader_1">'.mkd_loading_spinners(true).'</div></div></div>';
$html .= '<div class="vertical_split_slider" data-disable-header-skin-change="'.$data_disable_header_skin_change.'">';
$html .= do_shortcode($content);
$html .= '</div>';

print $html;

