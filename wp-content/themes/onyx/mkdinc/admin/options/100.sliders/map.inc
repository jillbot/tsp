<?php

$slidersPage = new MikadoAdminPage('_sliders', 'Sliders', 'arrow_left-right');
$mkdFramework->mkdOptions->addAdminPage('sliders', $slidersPage);

$panel_mikado_slider = new MikadoPanel('Mikado Slider', 'panel_mikado_slider');
$slidersPage->addChild('panel_mikado_slider', $panel_mikado_slider);

$qs_slider_height_mobile = new MikadoField("text","qs_slider_height_mobile","","Slider Height For Mobile Devices (px)","Define slider height for mobile devices");
$panel_mikado_slider->addChild("qs_slider_height_mobile",$qs_slider_height_mobile);

$qs_slider_preloader_background = new MikadoField("color","qs_slider_preloader_background","","Slider Preloader Background Color","Define background color for slider preloader");
$panel_mikado_slider->addChild("qs_slider_preloader_background",$qs_slider_preloader_background);

$slider_navigation_style_title = new MikadoTitle('slider_navigation_style_title', 'Navigation Bullets Style');
$panel_mikado_slider->addChild("slider_navigation_style_title",$slider_navigation_style_title);

$qs_navigation_control_color = new MikadoField("color","qs_navigation_control_color","","Color","Choose color for navigation bullets controls", array(), array("col_width" => 3));
$panel_mikado_slider->addChild("qs_navigation_control_color",$qs_navigation_control_color);

$qs_navigation_control_size = new MikadoField("text","qs_navigation_control_size","","Size (px)","Define size for navigation bullets controls (w=h in px)", array(), array("col_width" => 3));
$panel_mikado_slider->addChild("qs_navigation_control_size",$qs_navigation_control_size);

$qs_navigation_control_border_radius = new MikadoField("text","qs_navigation_control_border_radius","","Border Radius (px)","Define border radius for navigation bullets controls", array(), array("col_width" => 3));
$panel_mikado_slider->addChild("qs_navigation_control_border_radius",$qs_navigation_control_border_radius);


//Vertical split slider
$vss_panel = new MikadoPanel("Vertical Split Slider","vertical_split_slider");
$slidersPage->addChild("vss_panel",$vss_panel);

$vss_navigation_color = new MikadoField("color","vss_navigation_color","","Navigation Color","Define color for navigation dots");
$vss_panel->addChild("vss_navigation_color",$vss_navigation_color);

$vss_navigation_size = new MikadoField("text","vss_navigation_size","","Navigation Size (px)","Define size for navigation dots", array(), array("col_width" => 1));
$vss_panel->addChild("vss_navigation_size",$vss_navigation_size);

$vss_navigation_spacing_from_edge = new MikadoField("text","vss_navigation_spacing_from_edge","","Navigation Position (px)","Define position of navigation from right/left edge of slider", array(), array("col_width" => 1));
$vss_panel->addChild("vss_navigation_spacing_from_edge",$vss_navigation_spacing_from_edge);

$vss_left_panel_size = new MikadoField("text","vss_left_panel_size","","Left Slide Panel size (%)","Define size for left slide panel. Note that sum of left and right slide panel should be 100.", array(), array("col_width" => 1));
$vss_panel->addChild("vss_left_panel_size",$vss_left_panel_size);

$vss_right_panel_size = new MikadoField("text","vss_right_panel_size","","Right Slide Panel size (%)","Define size for right slide panel. Note that sum of left and right slide panel should be 100.", array(), array("col_width" => 1));
$vss_panel->addChild("vss_right_panel_size",$vss_right_panel_size);