<?php

add_action('after_setup_theme', 'mkd_meta_boxes_map_init', 1);
function mkd_meta_boxes_map_init() {
	global $mkd_options;
	global $mkdFramework;
	global $mkd_options_fontstyle;
	global $mkd_options_fontweight;
	global $mkd_options_texttransform;
	global $mkd_options_fontdecoration;
	global $mkd_options_arrows_type;
	require_once("page/map.inc");
	require_once("portfolio/map.inc");
	require_once("slides/map.inc");
	require_once("post/map.inc");
	require_once("testimonials/map.inc");
	require_once("carousels/map.inc");
}