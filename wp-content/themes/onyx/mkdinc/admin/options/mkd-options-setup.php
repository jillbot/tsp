<?php

add_action('after_setup_theme', 'mkd_admin_map_init', 0);
function mkd_admin_map_init() {
	global $mkd_options;
	global $mkdFramework;
	global $mkd_options_fontstyle;
	global $mkd_options_fontweight;
	global $mkd_options_texttransform;
	global $mkd_options_fontdecoration;
	global $mkd_options_arrows_type;
	global $mkd_options_double_arrows_type;
	global $mkd_options_arrows_up_type;
	require_once("10.general/map.inc");
    require_once("20.fonts/map.inc");
	require_once("30.header/map.inc");
    require_once("40.title/map.inc");
    require_once("50.content/map.inc");
	require_once("60.footer/map.inc");
	require_once("70.elements/map.inc");
	require_once("80.blog/map.inc");
	require_once("90.portfolio/map.inc");
	require_once("100.sliders/map.inc");
	require_once("110.social/map.inc");
	require_once("120.error404/map.inc");
	if(mkd_visual_composer_installed() && version_compare(mkd_get_vc_version(), '4.4.2') >= 0) {
		require_once("130.visualcomposer/map.inc");
	} else {
		$mkdFramework->mkdOptions->addOption("enable_grid_elements","no");
	}
    if(mkd_contact_form_7_installed()) {
        require_once("140.contactform7/map.inc");
    }

	if(function_exists("is_woocommerce")){
		require_once("150.woocommerce/map.inc");
	}
	require_once("160.reset/map.inc");
}