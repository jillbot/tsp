<?php

global $mkdIconCollections;

$socialPage = new MikadoAdminPage("12", "Social", "icon_group");
$mkdFramework->mkdOptions->addAdminPage("socialPage",$socialPage);

// Social sidebar

$panel1 = new MikadoPanel("Social Sidebar","social_sidebar");
$socialPage->addChild("panel1",$panel1);

$enable_social_sidebar = new MikadoField("yesno","enable_social_sidebar","no","Enable Social Sidebar","Enabling this option will allow social sidebar", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_enable_social_sidebar_container"));
$panel1->addChild("enable_social_sidebar",$enable_social_sidebar);

$enable_social_sidebar_container = new MikadoContainer("enable_social_sidebar_container","enable_social_sidebar","no");
$panel1->addChild("enable_social_sidebar_container",$enable_social_sidebar_container);

$social_sidebar_icon_pack = new MikadoField('select', 'social_sidebar_icon_pack', 'font_elegant', 'Social Sidebar Icon Pack', '', $mkdIconCollections->getIconCollectionsExclude('linea_icons'));
$enable_social_sidebar_container->addChild('social_sidebar_icon_pack', $social_sidebar_icon_pack);

$social_sidebar_icon_style = new MikadoField("select","social_sidebar_icon_style","circle","Icon Shape Type","Specify Icon Shape Type", array(
		"circle" => "Circle",
		"square" => "Square",
		"normal" => "Normal",
	),
	array("dependence" => true,
		"hide" => array(
			"normal"=>"#mkdf_enable_social_sidebar_box_type_container"),
		"show" => array(
			"circle"=>"#mkdf_enable_social_sidebar_box_type_container",
			"square"=>"#mkdf_enable_social_sidebar_box_type_container") ));
$enable_social_sidebar_container->addChild("social_sidebar_icon_style",$social_sidebar_icon_style);

$social_sidebar_icon_size = new MikadoField("text","social_sidebar_icon_size","","Icon Size","Set size for icon",array(), array("col_width" => 3));
$enable_social_sidebar_container->addChild("social_sidebar_icon_size",$social_sidebar_icon_size);

$social_sidebar_icon_shape_size = new MikadoField("text","social_sidebar_icon_shape_size","","Shape Size","Set size for icon shape",array(), array("col_width" => 3));
$enable_social_sidebar_container->addChild("social_sidebar_icon_shape_size",$social_sidebar_icon_shape_size);

$social_sidebar_icon_color = new MikadoField("color","social_sidebar_icon_color","","Color","Set color for Icon");
$enable_social_sidebar_container->addChild("social_sidebar_icon_color",$social_sidebar_icon_color);

$social_sidebar_icon_hover_color = new MikadoField("color","social_sidebar_icon_hover_color","","Hover Color","Set color for Icon");
$enable_social_sidebar_container->addChild("social_sidebar_icon_hover_color",$social_sidebar_icon_hover_color);

$group1 = new MikadoGroup("Position of sidebar","Define position for Social Sidebar. Place values with 'px' or '%'");
$enable_social_sidebar_container->addChild("group1",$group1);
$row1 = new MikadoRow();
$group1->addChild("row1",$row1);

$social_sidebar_icon_position_top = new MikadoField("textsimple","social_sidebar_icon_position_top","","From top (default 20%)","This is some description");
$row1->addChild("social_sidebar_icon_position_top",$social_sidebar_icon_position_top);
$social_sidebar_icon_position_right = new MikadoField("textsimple","social_sidebar_icon_position_right","","From right (default 30px)","This is some description");
$row1->addChild("social_sidebar_icon_position_right",$social_sidebar_icon_position_right);


$social_sidebar_icon_space_size = new MikadoField("text","social_sidebar_icon_space_size","","Space Between Icons Size (px)","Set size for space between icons. Default value is 2px.",array(), array("col_width" => 3));
$enable_social_sidebar_container->addChild("social_sidebar_icon_space_size",$social_sidebar_icon_space_size);


$enable_social_sidebar_box_type_container = new MikadoContainer("enable_social_sidebar_box_type_container","social_sidebar_icon_style","normal");
$enable_social_sidebar_container->addChild("enable_social_sidebar_box_type_container",$enable_social_sidebar_box_type_container);

$social_sidebar_icon_background_color = new MikadoField("color","social_sidebar_icon_background_color","","Background Color","Set color for background");
$enable_social_sidebar_box_type_container->addChild("social_sidebar_icon_background_color",$social_sidebar_icon_background_color);

$social_sidebar_icon_background_hover_color = new MikadoField("color","social_sidebar_icon_background_hover_color","","Background Hover Color","Set color for background hover");
$enable_social_sidebar_box_type_container->addChild("social_sidebar_icon_background_hover_color",$social_sidebar_icon_background_hover_color);

$social_sidebar_icon_border_color = new MikadoField("color","social_sidebar_icon_border_color","","Border Color","Set color for Border");
$enable_social_sidebar_box_type_container->addChild("social_sidebar_icon_border_color",$social_sidebar_icon_border_color);

$social_sidebar_icon_border_hover_color = new MikadoField("color","social_sidebar_icon_border_hover_color","","Border Hover Color","Set color for border hover");
$enable_social_sidebar_box_type_container->addChild("social_sidebar_icon_border_hover_color",$social_sidebar_icon_border_hover_color);

$social_sidebar_icon_border_width = new MikadoField("text","social_sidebar_icon_border_width","","Border Size","Set size for border",array(), array("col_width" => 3));
$enable_social_sidebar_box_type_container->addChild("social_sidebar_icon_border_width",$social_sidebar_icon_border_width);

// Facebook sidebar icon

$social_sidebar_facebook_icon = new MikadoField("yesno","social_sidebar_facebook_icon","no","Enable Facebook icon","Enabling this option will allow Facebook icon on your Social Sidebar", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_enable_social_sidebar_facebook_icon_container"));
$enable_social_sidebar_container->addChild("social_sidebar_facebook_icon",$social_sidebar_facebook_icon);

$enable_social_sidebar_facebook_icon_container = new MikadoContainer("enable_social_sidebar_facebook_icon_container","social_sidebar_facebook_icon","no");
$enable_social_sidebar_container->addChild("enable_social_sidebar_facebook_icon_container",$enable_social_sidebar_facebook_icon_container);
$social_sidebar_facebook_icon_link = new MikadoField("text","social_sidebar_facebook_icon_link","","Link","Set Facebook link.",array(), array("col_width" => 3));
$enable_social_sidebar_facebook_icon_container->addChild("social_sidebar_facebook_icon_link",$social_sidebar_facebook_icon_link);

// Twitter sidebar icon

$social_sidebar_twitter_icon = new MikadoField("yesno","social_sidebar_twitter_icon","no","Enable Twitter icon","Enabling this option will allow Twitter icon on your Social Sidebar", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_enable_social_sidebar_twitter_icon_container"));
$enable_social_sidebar_container->addChild("social_sidebar_twitter_icon",$social_sidebar_twitter_icon);

$enable_social_sidebar_twitter_icon_container = new MikadoContainer("enable_social_sidebar_twitter_icon_container","social_sidebar_twitter_icon","no");
$enable_social_sidebar_container->addChild("enable_social_sidebar_twitter_icon_container",$enable_social_sidebar_twitter_icon_container);
$social_sidebar_twitter_icon_link = new MikadoField("text","social_sidebar_twitter_icon_link","","Link","Set Twitter link.",array(), array("col_width" => 3));
$enable_social_sidebar_twitter_icon_container->addChild("social_sidebar_twitter_icon_link",$social_sidebar_twitter_icon_link);

// Google Plus sidebar icon

$social_sidebar_google_plus_icon = new MikadoField("yesno","social_sidebar_google_plus_icon","no","Enable Google Plus icon","Enabling this option will allow Google Plus icon on your Social Sidebar", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_enable_social_sidebar_google_plus_icon_container"));
$enable_social_sidebar_container->addChild("social_sidebar_google_plus_icon",$social_sidebar_google_plus_icon);

$enable_social_sidebar_google_plus_icon_container = new MikadoContainer("enable_social_sidebar_google_plus_icon_container","social_sidebar_google_plus_icon","no");
$enable_social_sidebar_container->addChild("enable_social_sidebar_google_plus_icon_container",$enable_social_sidebar_google_plus_icon_container);
$social_sidebar_google_plus_icon_link = new MikadoField("text","social_sidebar_google_plus_icon_link","","Link","Set Google Plus link.",array(), array("col_width" => 3));
$enable_social_sidebar_google_plus_icon_container->addChild("social_sidebar_google_plus_icon_link",$social_sidebar_google_plus_icon_link);

// LinkedIn sidebar icon

$social_sidebar_linkedIn_icon = new MikadoField("yesno","social_sidebar_linkedIn_icon","no","Enable LinkedIn icon","Enabling this option will allow LinkedIn icon on your Social Sidebar", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_enable_social_sidebar_linkedIn_icon_container"));
$enable_social_sidebar_container->addChild("social_sidebar_linkedIn_icon",$social_sidebar_linkedIn_icon);

$enable_social_sidebar_linkedIn_icon_container = new MikadoContainer("enable_social_sidebar_linkedIn_icon_container","social_sidebar_linkedIn_icon","no");
$enable_social_sidebar_container->addChild("enable_social_sidebar_linkedIn_icon_container",$enable_social_sidebar_linkedIn_icon_container);
$social_sidebar_linkedIn_icon_link = new MikadoField("text","social_sidebar_linkedIn_icon_link","","Link","Set LinkedIn link.",array(), array("col_width" => 3));
$enable_social_sidebar_linkedIn_icon_container->addChild("social_sidebar_linkedIn_icon_link",$social_sidebar_linkedIn_icon_link);

// Tumblr sidebar icon

$social_sidebar_tumblr_icon = new MikadoField("yesno","social_sidebar_tumblr_icon","no","Enable Tumblr icon","Enabling this option will allow Tumblr icon on your Social Sidebar", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_enable_social_sidebar_tumblr_icon_container"));
$enable_social_sidebar_container->addChild("social_sidebar_tumblr_icon",$social_sidebar_tumblr_icon);

$enable_social_sidebar_tumblr_icon_container = new MikadoContainer("enable_social_sidebar_tumblr_icon_container","social_sidebar_tumblr_icon","no");
$enable_social_sidebar_container->addChild("enable_social_sidebar_tumblr_icon_container",$enable_social_sidebar_tumblr_icon_container);
$social_sidebar_tumblr_icon_link = new MikadoField("text","social_sidebar_tumblr_icon_link","","Link","Set Tumblr link.",array(), array("col_width" => 3));
$enable_social_sidebar_tumblr_icon_container->addChild("social_sidebar_tumblr_icon_link",$social_sidebar_tumblr_icon_link);

// Pinterest sidebar icon

$social_sidebar_pinterest_icon = new MikadoField("yesno","social_sidebar_pinterest_icon","no","Enable Pinterest icon","Enabling this option will allow Pinterest icon on your Social Sidebar", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_enable_social_sidebar_pinterest_icon_container"));
$enable_social_sidebar_container->addChild("social_sidebar_pinterest_icon",$social_sidebar_pinterest_icon);

$enable_social_sidebar_pinterest_icon_container = new MikadoContainer("enable_social_sidebar_pinterest_icon_container","social_sidebar_pinterest_icon","no");
$enable_social_sidebar_container->addChild("enable_social_sidebar_pinterest_icon_container",$enable_social_sidebar_pinterest_icon_container);
$social_sidebar_pinterest_icon_link = new MikadoField("text","social_sidebar_pinterest_icon_link","","Link","Set Pinterest link.",array(), array("col_width" => 3));
$enable_social_sidebar_pinterest_icon_container->addChild("social_sidebar_pinterest_icon_link",$social_sidebar_pinterest_icon_link);

// VK sidebar icon

$social_sidebar_vk_icon = new MikadoField("yesno","social_sidebar_vk_icon","no","Enable VK icon","Enabling this option will allow VK icon on your Social Sidebar", array(),
	array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_enable_social_sidebar_vk_icon_container"));
$enable_social_sidebar_container->addChild("social_sidebar_vk_icon",$social_sidebar_vk_icon);

$enable_social_sidebar_vk_icon_container = new MikadoContainer("enable_social_sidebar_vk_icon_container","social_sidebar_vk_icon","no");
$enable_social_sidebar_container->addChild("enable_social_sidebar_vk_icon_container",$enable_social_sidebar_vk_icon_container);
$social_sidebar_vk_icon_link = new MikadoField("text","social_sidebar_vk_icon_link","","Link","Set VK link.",array(), array("col_width" => 3));
$enable_social_sidebar_vk_icon_container->addChild("social_sidebar_vk_icon_link",$social_sidebar_vk_icon_link);

//Enable Social Share

$panel2 = new MikadoPanel("Enable Social Share","social_sharing_panel");
$socialPage->addChild("panel2",$panel2);

	$enable_social_share = new MikadoField("yesno","enable_social_share","no","Enable Social Share","Enabling this option will allow social share on networks of your choice", array(),
		array("dependence" => true,
		"dependence_hide_on_yes" => "",
		"dependence_show_on_yes" => "#mkdf_social_networks_panel,#mkdf_show_social_share_panel"));
	$panel2->addChild("enable_social_share",$enable_social_share);

//Show Social Share

$panel3 = new MikadoPanel("Show Social Share On","show_social_share_panel","enable_social_share","no");
$socialPage->addChild("panel3",$panel3);

	$post_types_names_post = new MikadoField("flagpost","post_types_names_post","","Posts","Show Social Share on Blog Posts");
	$panel3->addChild("post_types_names_post",$post_types_names_post);

	$post_types_names_page = new MikadoField("flagpage","post_types_names_page","","Pages","Show Social Share on Pages");
	$panel3->addChild("post_types_names_page",$post_types_names_page);

	$post_types_names_attachment = new MikadoField("flagmedia","post_types_names_attachment","","Media","Show Social Share for Images and Videos");
	$panel3->addChild("post_types_names_attachment",$post_types_names_attachment);

	$post_types_names_portfolio_page = new MikadoField("flagportfolio","post_types_names_portfolio_page","","Portfolio Item","Show Social Share for Portfolio Items");
	$panel3->addChild("post_types_names_portfolio_page",$post_types_names_portfolio_page);

	if(mkd_is_woocommerce_installed()){
		$post_types_names_product = new MikadoField("flagproduct","post_types_names_product","","Product","Show Social Share for Product Items");
		$panel3->addChild("post_types_names_product",$post_types_names_product);
	}

//Social Share Networks

$panel4 = new MikadoPanel("Social Networks","social_networks_panel","enable_social_share","no");
$socialPage->addChild("panel4",$panel4);

//Facebook

$facebook_subtitle = new MikadoTitle("facebook_subtitle", "Share on Facebook");
$panel4->addChild("facebook_subtitle", $facebook_subtitle);

$enable_facebook_share = new MikadoField("yesno","enable_facebook_share","no","Enable Share","Enabling this option will allow sharing via Facebook", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#mkdf_enable_facebook_share_container"));
	$panel4->addChild("enable_facebook_share",$enable_facebook_share);

	$enable_facebook_share_container = new MikadoContainer("enable_facebook_share_container","enable_facebook_share","no");
	$panel4->addChild("enable_facebook_share_container",$enable_facebook_share_container);

		$facebook_icon = new MikadoField("image","facebook_icon","","Upload Icon","");
		$enable_facebook_share_container->addChild("facebook_icon",$facebook_icon);

//Twitter
$twitter_subtitle = new MikadoTitle("twitter_subtitle", "Share on Twitter");
$panel4->addChild("twitter_subtitle", $twitter_subtitle);

	$enable_twitter_share = new MikadoField("yesno","enable_twitter_share","no","Enable Share","Enabling this option will allow sharing via Twitter", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#mkdf_enable_twitter_share_container"));
	$panel4->addChild("enable_twitter_share",$enable_twitter_share);
	$enable_twitter_share_container = new MikadoContainer("enable_twitter_share_container","enable_twitter_share","no");
	$panel4->addChild("enable_twitter_share_container",$enable_twitter_share_container);
		$twitter_icon = new MikadoField("image","twitter_icon","","Upload Icon","");
		$enable_twitter_share_container->addChild("twitter_icon",$twitter_icon);
		$twitter_via = new MikadoField("text","twitter_via","","Via","");
		$enable_twitter_share_container->addChild("twitter_via",$twitter_via);

//Google Plus

$google_plus_subtitle = new MikadoTitle("google_plus_subtitle", "Share on Google Plus");
$panel4->addChild("google_plus_subtitle", $google_plus_subtitle);

$enable_google_plus = new MikadoField("yesno","enable_google_plus","no","Enable Share","Enabling this option will allow sharing via Google Plus", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#mkdf_enable_google_plus_container"));
	$panel4->addChild("enable_google_plus",$enable_google_plus);
	$enable_google_plus_container = new MikadoContainer("enable_google_plus_container","enable_google_plus","no");
	$panel4->addChild("enable_google_plus_container",$enable_google_plus_container);
		$google_plus_icon = new MikadoField("image","google_plus_icon","","Upload Icon","");
		$enable_google_plus_container->addChild("google_plus_icon",$google_plus_icon);

//LinkedIn

$linkedin_subtitle = new MikadoTitle("linkedin_subtitle", "Share on LinkedIn");
$panel4->addChild("linkedin_subtitle", $linkedin_subtitle);

	$enable_linkedin = new MikadoField("yesno","enable_linkedin","no","Enable Share","Enabling this option will allow sharing via LinkedIn", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#mkdf_enable_linkedin_container"));
	$panel4->addChild("enable_linkedin",$enable_linkedin);
	$enable_linkedin_container = new MikadoContainer("enable_linkedin_container","enable_linkedin","no");
	$panel4->addChild("enable_linkedin_container",$enable_linkedin_container);
		$linkedin_icon = new MikadoField("image","linkedin_icon","","Upload Icon","");
		$enable_linkedin_container->addChild("linkedin_icon",$linkedin_icon);

//Tumblr

$tumblr_subtitle = new MikadoTitle("tumblr_subtitle", "Share on Tumblr");
$panel4->addChild("tumblr_subtitle", $tumblr_subtitle);

	$enable_tumblr = new MikadoField("yesno","enable_tumblr","no","Enable Share","Enabling this option will allow sharing via Tumblr", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#mkdf_enable_tumblr_container"));
	$panel4->addChild("enable_tumblr",$enable_tumblr);

	$enable_tumblr_container = new MikadoContainer("enable_tumblr_container","enable_tumblr","no");
	$panel4->addChild("enable_tumblr_container",$enable_tumblr_container);

		$tumblr_icon = new MikadoField("image","tumblr_icon","","Upload Icon","");
		$enable_tumblr_container->addChild("tumblr_icon",$tumblr_icon);

// Pinterest

$pinterest_subtitle = new MikadoTitle("pinterest_subtitle", "Share on Pinterest");
$panel4->addChild("pinterest_subtitle", $pinterest_subtitle);

	$enable_pinterest = new MikadoField("yesno","enable_pinterest","no","Enable Share","Enabling this option will allow sharing via Pinterest", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#mkdf_enable_pinterest_container"));
	$panel4->addChild("enable_pinterest",$enable_pinterest);
	$enable_pinterest_container = new MikadoContainer("enable_pinterest_container","enable_pinterest","no");
	$panel4->addChild("enable_pinterest_container",$enable_pinterest_container);
		$pinterest_icon = new MikadoField("image","pinterest_icon","","Upload Icon","");
		$enable_pinterest_container->addChild("pinterest_icon",$pinterest_icon);


//VK

$vk_subtitle = new MikadoTitle("vk_subtitle", "Share on VK");
$panel4->addChild("vk_subtitle", $vk_subtitle);

	$enable_vk = new MikadoField("yesno","enable_vk","no","Enable Share","Enabling this option will allow sharing via VK", array(), array("dependence" => true, "dependence_hide_on_yes" => "", "dependence_show_on_yes" => "#mkdf_enable_vk_container"));
	$panel4->addChild("enable_vk",$enable_vk);
	$enable_vk_container = new MikadoContainer("enable_vk_container","enable_vk","no");
	$panel4->addChild("enable_vk_container",$enable_vk_container);
		$vk_icon = new MikadoField("image","vk_icon","","Upload Icon","");
		$enable_vk_container->addChild("vk_icon",$vk_icon);