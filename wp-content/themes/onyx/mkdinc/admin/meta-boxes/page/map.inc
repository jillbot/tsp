<?php

$mkd_custom_sidebars = mkd_get_custom_sidebars();

$mkd_blog_categories = array();
$categories = get_categories(); 
foreach($categories as $category) {
	$mkd_blog_categories[$category->term_id] = $category->name;
}
global $mkdIconCollections;

//General

$mkdGeneral = new MikadoMetaBox("page", "General");
$mkdFramework->mkdMetaBoxes->addMetaBox("page_general",$mkdGeneral);

	$mkd_page_background_color = new MikadoMetaField("color","mkd_page_background_color","","Page Background Color","Choose the page background (body) color");
	$mkdGeneral->addChild("mkd_page_background_color",$mkd_page_background_color);

	$group1 = new MikadoGroup("Content Style","Define styles for Content area");
	$mkdGeneral->addChild("group1",$group1);

		$row1 = new MikadoRow();
		$group1->addChild("row1",$row1);

			$mkd_enable_content_top_margin = new MikadoMetaField("yesnosimple","mkd_enable_content_top_margin","no","Always put content below header","Enabling this option always will put content below header ");
			$row1->addChild("mkd_enable_content_top_margin",$mkd_enable_content_top_margin);

			$mkd_content_top_padding = new MikadoMetaField("textsimple","mkd_content-top-padding","","Content Top Padding (px)","This option control content top padding.");
			$row1->addChild("mkd_content-top-padding",$mkd_content_top_padding);

			$mkd_content_top_padding_mobile = new MikadoMetaField("selectblanksimple","mkd_content-top-padding-mobile","","Set this top padding for mobile header","", array(
		       "no" => "No",
		       "yes" => "Yes"
		      ));
			$row1->addChild("mkd_content-top-padding-mobile",$mkd_content_top_padding_mobile);

	$mkd_show_animation = new MikadoMetaField("selectblank","mkd_show-animation","","Page Transition",'Choose a type of transition between loading pages.', array(
	   "no_animation" => "No Animation",
	   "updown" => "Up / Down",
	   "fade" => "Fade",
		"updown_fade" => "Up/Down (In) / Fade (Out)",
	   "leftright" => "Left / Right"
	  ), array(), "enable_grid_elements", array("yes"));
	$mkdGeneral->addChild("mkd_show-animation",$mkd_show_animation);

	$page_transitions_notice = new MikadoNotice("Page Transition",'Choose a a type of transition between loading pages. In order for animation to work properly, you must choose "Post name" in permalinks settings', "AJAX Page transitions are disabled due to VC Grid Elements", "enable_grid_elements","no");
	$mkdGeneral->addChild("page_transitions_notice",$page_transitions_notice);

	$mkd_revolution_slider = new MikadoMetaField("text","mkd_revolution-slider","","Layer Slider or Mikado Slider Shortcode","Copy and paste your shortcode located in Mikado Slider -> Slider");
	$mkdGeneral->addChild("mkd_revolution-slider",$mkd_revolution_slider);

// Side Menu Area

$mkdLeftMenuArea = new MikadoMetaBox("page", "Side Menu Area","vertical_area",array("no"));
$mkdFramework->mkdMetaBoxes->addMetaBox("page_left_menu",$mkdLeftMenuArea);

	$mkd_page_vertical_area_transparency = new MikadoMetaField("selectblank","mkd_page_vertical_area_transparency","","Enable transparent side menu area","Enabling this option will make Side Menu background transparent ", array(
	   "no" => "No",
	   "yes" => "Yes"
	  ));
	$mkdLeftMenuArea->addChild("mkd_page_vertical_area_transparency",$mkd_page_vertical_area_transparency);

	$mkd_page_vertical_area_background = new MikadoMetaField("color","mkd_page_vertical_area_background","","Side Menu Area Background Color","Choose a color for Side Menu background");
	$mkdLeftMenuArea->addChild("mkd_page_vertical_area_background",$mkd_page_vertical_area_background);
	
	$mkd_page_vertical_area_background_opacity = new MikadoMetaField("text","mkd_page_vertical_area_background_opacity","","Side Menu Area Background Opacity","Choose a opacity for the Side Menu Area Background (0 = fully transparent, 1 = opaque)", array(), array("col_width" => 3));
	$mkdLeftMenuArea->addChild("mkd_page_vertical_area_background_opacity",$mkd_page_vertical_area_background_opacity);
	
	$mkd_page_vertical_area_transparency_over_slider = new MikadoMetaField("selectblank","mkd_page_vertical_area_transparency_over_slider","","Transparency Setting Takes Effect Only on Mikado Slider","Enabling this option will ensure that the transparency set in the 'Side Menu Area Background Opacity' takes effect only when the side menu area is over the Mikado Slider", array(
	   "no" => "No",
	   "yes" => "Yes"
	  ));
	$mkdLeftMenuArea->addChild("mkd_page_vertical_area_transparency_over_slider",$mkd_page_vertical_area_transparency_over_slider);
	

	$mkd_page_vertical_area_background_image = new MikadoMetaField("image","mkd_page_vertical_area_background_image","","Side Menu Area Background Image","Choose an image for Side Menu background");
	$mkdLeftMenuArea->addChild("mkd_page_vertical_area_background_image",$mkd_page_vertical_area_background_image);
	
	$mkd_page_disable_vertical_area_background_image = new MikadoMetaField("selectblank","mkd_page_disable_vertical_area_background_image","","Disable Side Menu Area Background Image","Enabling this option will hide background image in Side Menu", array(
	   "no" => "No",
	   "yes" => "Yes"
	  ));
	$mkdLeftMenuArea->addChild("mkd_page_disable_vertical_area_background_image",$mkd_page_disable_vertical_area_background_image);

// Header

$mkdHeader = new MikadoMetaBox("page", "Header","vertical_area",array("yes"));
$mkdFramework->mkdMetaBoxes->addMetaBox("page_header",$mkdHeader);

	$mkd_header_style = new MikadoMetaField("selectblank","mkd_header-style","","Header Skin","Choose a header style to make header elements (logo, main menu, side menu button) in that predefined style", array(
	   "light" => "Light",
	   "dark" => "Dark"
	  ));
	$mkdHeader->addChild("mkd_header-style",$mkd_header_style);

    $mkd_header_style_on_scroll = new MikadoMetaField("selectblank","mkd_header-style-on-scroll","","Enable Header Style on Scroll","Enabling this option, header will change style on scroll (depending on row settings) to make header elements (logo, main menu, side menu button) in that style", array(
        "no" => "No",
        "yes" => "Yes"
    ));
    $mkdHeader->addChild("mkd_header-style-on-scroll",$mkd_header_style_on_scroll);

	$mkd_header_color_per_page = new MikadoMetaField("color","mkd_header_color_per_page","","Initial Header Background Color","Choose a background color for header area");
	$mkdHeader->addChild("mkd_header_color_per_page",$mkd_header_color_per_page);

	$mkd_header_color_transparency_per_page = new MikadoMetaField("text","mkd_header_color_transparency_per_page","","Initial Header Transparency","Choose a transparency for the header background color (0 = fully transparent, 1 = opaque)", array(), array("col_width" => 3));
	$mkdHeader->addChild("mkd_header_color_transparency_per_page",$mkd_header_color_transparency_per_page);

	$mkd_header_bottom_border_color = new MikadoMetaField("color","mkd_header_bottom_border_color","","Initial Header Bottom Border Color","Choose a bottom border color for header area");
	$mkdHeader->addChild("mkd_header_bottom_border_color",$mkd_header_bottom_border_color);

	$mkd_page_scroll_amount_for_sticky = new MikadoMetaField("text","mkd_page_scroll_amount_for_sticky","","Scroll amount for sticky header appearance (px)","Define scroll amount for sticky header appearance", array(), array("col_width" => 3),"header_bottom_appearance",array( "regular","fixed","fixed_hiding") );
	$mkdHeader->addChild("mkd_page_scroll_amount_for_sticky",$mkd_page_scroll_amount_for_sticky);
	
	$mkd_page_hide_initial_sticky = new MikadoMetaField("selectblank","mkd_page_hide_initial_sticky","","Hide Sticky Header Initially","Enabling this option will initially hide the header, and it will only be displayed when the user scrolls down the page", array(
		"no" => "No",
		"yes" => "Yes"	
	));
	$mkdHeader->addChild("mkd_page_hide_initial_sticky",$mkd_page_hide_initial_sticky);
// Title


$mkdTitle = new MikadoMetaBox("page", "Title");
$mkdFramework->mkdMetaBoxes->addMetaBox("page_title",$mkdTitle);

	$mkd_show_page_title = new MikadoMetaField("selectblank","mkd_show-page-title","","Show Title Area","Disabling this option will turn off page title area", array(
		"no" => "No",
		"yes" => "Yes"),
		array("dependence" => true,
			"hide" => array(
				"no"=>"#mkdf_mkd_page_title_area_container"),
			"show" => array(
				""=>"#mkdf_mkd_page_title_area_container",
				"yes"=>"#mkdf_mkd_page_title_area_container") ));
	$mkdTitle->addChild("mkd_show-page-title",$mkd_show_page_title);

	$mkd_page_title_area_container = new MikadoContainer("mkd_page_title_area_container","mkd_show-page-title","no");
	$mkdTitle->addChild("mkd_page_title_area_container",$mkd_page_title_area_container);

	$mkd_page_title_type = new MikadoMetaField("selectblank","mkd_page_title_type","","Title Type","Choose title type for this page.",array(
		"standard_title" => "Standard",
		"breadcrumbs_title" => "Breadcrumbs"
	),array(
      	"dependence" => true,
      	"hide" => array("breadcrumbs_title" => "#mkdf_mkd_title_standard_container","standard_title" => "#mkdf_mkd_title_breadcrumbs_container","" => "#mkdf_mkd_title_breadcrumbs_container"),
      	"show" => array("standard_title" => "#mkdf_mkd_title_standard_container","" => "#mkdf_mkd_title_standard_container","breadcrumbs_title" => "#mkdf_mkd_title_breadcrumbs_container")
      ));
	$mkd_page_title_area_container->addChild("mkd_page_title_type",$mkd_page_title_type);

	$mkd_animate_page_title = new MikadoMetaField("selectblank","mkd_animate_page_title","","Animations","Choose an animation for Title Area",array(
        "no" => "No animation",
		"text_right_left" => "Text right to left",
		"area_top_bottom" => "Title area top to bottom"
	));
	$mkd_page_title_area_container->addChild("mkd_animate_page_title",$mkd_animate_page_title);
	
	$mkd_page_page_title_vertical_aligment = new MikadoMetaField("selectblank","mkd_page_page_title_vertical_aligment","","Vertical Alignment","Specify Title vertical alignment", array( 
		"header_bottom" => "From Bottom of Header",
		"window_top" => "From Window Top"
	 ));
	$mkd_page_title_area_container->addChild("mkd_page_page_title_vertical_aligment",$mkd_page_page_title_vertical_aligment);
	
	$mkd_show_page_title_text = new MikadoMetaField("selectblank","mkd_show_page_title_text","","Show Title Text","Disabling this option will turn off page title text", array(
		"no" => "No",
		"yes" => "Yes"),
		array("dependence" => true,
			"hide" => array(
				"no"=>"#mkdf_mkd_title_text_container"),
			"show" => array(
				""=>"#mkdf_mkd_title_text_container",
				"yes"=>"#mkdf_mkd_title_text_container") ));
	$mkd_page_title_area_container->addChild("mkd_show_page_title_text",$mkd_show_page_title_text);
	
	$mkd_title_text_container = new MikadoContainer("mkd_title_text_container","mkd_show_page_title_text","no");
	$mkd_page_title_area_container->addChild("mkd_title_text_container",$mkd_title_text_container);

	$mkd_page_title_position = new MikadoMetaField("selectblank","mkd_page_title_position","","Title Text Alignment","Specify Title text alignment",array(
		"left" => "Left",
		"center" => "Center",
		"right" => "Right"
	));
	$mkd_title_text_container->addChild("mkd_page_title_position",$mkd_page_title_position);

	$group1 = new MikadoGroup("Title Text Style","Define styles for text in Title Area");
	$mkd_title_text_container->addChild("group1",$group1);
	
		$row1 = new MikadoRow();
		$group1->addChild("row1",$row1);

			$mkd_page_title_color = new MikadoMetaField("colorsimple","mkd_page-title-color","","Text Color","ThisIsDescription");
			$row1->addChild("mkd_page-title-color",$mkd_page_title_color);

			$mkd_title_text_shadow = new MikadoMetaField("selectblanksimple","mkd_title_text_shadow","","Text Shadow","ThisIsDescription",array(
				"no" => "No",
				"yes" => "yes"
			));
			$row1->addChild("mkd_title_text_shadow",$mkd_title_text_shadow);

	$mkd_title_breadcrumbs_container = new MikadoContainer("mkd_title_breadcrumbs_container","mkd_page_title_type",array(),array("standard_title",""));
	$mkd_page_title_area_container->addChild("mkd_title_breadcrumbs_container",$mkd_title_breadcrumbs_container);

		$mkd_enable_subtitle_breadcrumbs = new MikadoMetaField("selectblank","mkd_enable_subtitle_breadcrumbs","","Show Subtitle","Enable this option to show subtitle",array(
			"yes" => "Yes",
			"no" => "No"
			));
		$mkd_title_breadcrumbs_container->addChild("mkd_enable_subtitle_breadcrumbs",$mkd_enable_subtitle_breadcrumbs);

	$mkd_title_standard_container = new MikadoContainer("mkd_title_standard_container","mkd_page_title_type","breadcrumbs_title");
	$mkd_page_title_area_container->addChild("mkd_title_standard_container",$mkd_title_standard_container);

	$mkd_title_like_separator = new MikadoMetaField("selectblank","mkd_title_like_separator","","Show Separator Around Title Text","Choose if you want title to look like separator with text",array(
			"no" => "No",
			"yes" => "Yes"
		),
		array(
			"dependence" => true,
		 	"hide" => array(
				"no" => "#mkdf_mkd_title_like_separator_container",
				"" => "#mkdf_mkd_title_like_separator_container"
			),
		    "show" => array(
				"yes" => "#mkdf_mkd_title_like_separator_container"
			)
		  )
		);
	$mkd_title_standard_container->addChild("mkd_title_like_separator",$mkd_title_like_separator);

	$mkd_title_like_separator_container = new MikadoContainer("mkd_title_like_separator_container","mkd_title_like_separator","", array('', 'no'));
	$mkd_title_standard_container->addChild("mkd_title_like_separator_container",$mkd_title_like_separator_container);

		$group1 = new MikadoGroup("Line Styles", "Choose style for separator line");
		$mkd_title_like_separator_container->addChild("group1",$group1);

			$row1 = new MikadoRow();
			$group1->addChild("row1",$row1);

				$mkd_title_like_separator_line_color = new MikadoMetaField("colorsimple","mkd_title_like_separator_line_color","","Color","This is some description");
				$row1->addChild("mkd_title_like_separator_line_color",$mkd_title_like_separator_line_color);

				$mkd_title_like_separator_line_width = new MikadoMetaField("textsimple","mkd_title_like_separator_line_width","","Width","This is some description");
				$row1->addChild("mkd_title_like_separator_line_width",$mkd_title_like_separator_line_width);

				$mkd_title_like_separator_line_thickness = new MikadoMetaField("textsimple","mkd_title_like_separator_line_thickness","","Thickness","This is some description");
				$row1->addChild("mkd_title_like_separator_line_thickness",$mkd_title_like_separator_line_thickness);

				$mkd_title_like_separator_line_style = new MikadoMetaField("selectsimple","mkd_title_like_separator_line_style","","Style","This is some description",array(
					"solid" => "Solid",
					"dashed" => "Dashed",
					"dotted" => "Dotted"
					));
				$row1->addChild("mkd_title_like_separator_line_style",$mkd_title_like_separator_line_style);

		$mkd_title_like_separator_margins = new MikadoMetaField("text","mkd_title_like_separator_margins","","Margins for Title","Define left/right margins for title from separator");
		$mkd_title_like_separator_container->addChild("mkd_title_like_separator_margins",$mkd_title_like_separator_margins);

		$mkd_title_like_separator_line_dots = new MikadoMetaField("selectblank","mkd_title_like_separator_line_dots","","Dots on The End of Lines","Enabling this option will give lines a dot next to title",array(
				"no" => "No",
				"yes" => "Yes"
			),array(
				"dependence" => true,
				"hide" => array("no" => "#mkdf_mkd_title_like_separator_dots_container"),
				"show" => array("yes" => "#mkdf_mkd_title_like_separator_dots_container","" => "#mkdf_mkd_title_like_separator_dots_container")
			));
		$mkd_title_like_separator_container->addChild("mkd_title_like_separator_line_dots",$mkd_title_like_separator_line_dots);

		$mkd_title_like_separator_dots_container = new MikadoContainer("mkd_title_like_separator_dots_container","mkd_title_like_separator_line_dots","no");
		$mkd_title_like_separator_container->addChild("mkd_title_like_separator_dots_container",$mkd_title_like_separator_dots_container);

			$group1 = new MikadoGroup("Dots Style","Choose style for dots");
			$mkd_title_like_separator_dots_container->addChild("group1",$group1);

				$row1 = new MikadoRow();
				$group1->addChild("row1",$row1);

					$mkd_title_like_separator_dots_size = new MikadoMetaField("textsimple","mkd_title_like_separator_dots_size","","Size (px)","This is some description");
					$row1->addChild("mkd_title_like_separator_dots_size",$mkd_title_like_separator_dots_size);

					$mkd_title_like_separator_dots_color = new MikadoMetaField("colorsimple","mkd_title_like_separator_dots_color","","Color","This is some description");
					$row1->addChild("mkd_title_like_separator_dots_color",$mkd_title_like_separator_dots_color);

	$mkd_subtitle_like_separator = new MikadoMetaField("selectblank","mkd_subtitle_like_separator","","Show Separator Around Subtitle Text","Choose if you want title to look like separator with text",array(
			"no" => "No",
			"yes" => "Yes"
		),
		array(
			"dependence" => true,
		 	"hide" => array(
				"" => "#mkdf_mkd_subtitle_like_separator_container",
				"no" => "#mkdf_mkd_subtitle_like_separator_container"
			),
		    "show" => array(
				"yes" => "#mkdf_mkd_subtitle_like_separator_container"
			)
		  )
		);
	$mkd_title_standard_container->addChild("mkd_subtitle_like_separator",$mkd_subtitle_like_separator);

	$mkd_subtitle_like_separator_container = new MikadoContainer("mkd_subtitle_like_separator_container","mkd_subtitle_like_separator","", array('', 'no'));
	$mkd_title_standard_container->addChild("mkd_subtitle_like_separator_container",$mkd_subtitle_like_separator_container);

		$group1 = new MikadoGroup("Line Styles", "Choose style for separator line");
		$mkd_subtitle_like_separator_container->addChild("group1",$group1);

			$row1 = new MikadoRow();
			$group1->addChild("row1",$row1);

				$mkd_subtitle_like_separator_line_color = new MikadoMetaField("colorsimple","mkd_subtitle_like_separator_line_color","","Color","This is some description");
				$row1->addChild("mkd_subtitle_like_separator_line_color",$mkd_subtitle_like_separator_line_color);

				$mkd_subtitle_like_separator_line_width = new MikadoMetaField("textsimple","mkd_subtitle_like_separator_line_width","","Width","This is some description");
				$row1->addChild("mkd_subtitle_like_separator_line_width",$mkd_subtitle_like_separator_line_width);

				$mkd_subtitle_like_separator_line_thickness = new MikadoMetaField("textsimple","mkd_subtitle_like_separator_line_thickness","","Thickness","This is some description");
				$row1->addChild("mkd_subtitle_like_separator_line_thickness",$mkd_subtitle_like_separator_line_thickness);

				$mkd_subtitle_like_separator_line_style = new MikadoMetaField("selectsimple","mkd_subtitle_like_separator_line_style","","Style","This is some description",array(
					"solid" => "Solid",
					"dashed" => "Dashed",
					"dotted" => "Dotted"
					));
				$row1->addChild("mkd_subtitle_like_separator_line_style",$mkd_subtitle_like_separator_line_style);

		$mkd_subtitle_like_separator_margins = new MikadoMetaField("text","mkd_subtitle_like_separator_margins","","Margins for Subitle","Define left/right margins for subtitle from separator");
		$mkd_subtitle_like_separator_container->addChild("mkd_subtitle_like_separator_margins",$mkd_subtitle_like_separator_margins);
	
	$mkd_page_title_background_color = new MikadoMetaField("color","mkd_page-title-background-color","","Background Color","Choose background color for Title Area");
	$mkd_page_title_area_container->addChild("mkd_page-title-background-color",$mkd_page_title_background_color);

	$mkd_show_page_title_image = new MikadoMetaField("yesno","mkd_show-page-title-image","no","Don't Show Background Image","Enable this option to hide background image in Title Area", array(), array("dependence" => true, "dependence_hide_on_yes" => "#mkdf_mkd_background_image_container", "dependence_show_on_yes" => "#mkdf_mkd_title-height"));
	$mkd_page_title_area_container->addChild("mkd_show-page-title-image",$mkd_show_page_title_image);

	$mkd_background_image_container = new MikadoContainer("mkd_background_image_container","mkd_show-page-title-image","yes");
	$mkd_page_title_area_container->addChild("mkd_background_image_container",$mkd_background_image_container);

	$mkd_title_image = new MikadoMetaField("image","mkd_title-image","","Background Image","Choose a background image for Title Area");
	$mkd_background_image_container->addChild("mkd_title-image",$mkd_title_image);

	$mkd_title_overlay_image = new MikadoMetaField("image","mkd_title-overlay-image","","Pattern Overlay Image","Choose an image to be used as pattern over Title Area");
	$mkd_background_image_container->addChild("mkd_title-overlay-image",$mkd_title_overlay_image);

	$mkd_responsive_title_image = new MikadoMetaField("selectblank","mkd_responsive-title-image","","Responsive Background Image","Do you want to make Title background image responsive?", array(
		"no" => "No",
		"yes" => "Yes"),
		array("dependence" => true,
			"hide" => array(
				"yes"=>"#mkdf_mkd_responsive_title_image_container, #mkdf_mkd_title-height"),
			"show" => array(
				""=>"#mkdf_mkd_responsive_title_image_container, #mkdf_mkd_title-height",
				"no"=>"#mkdf_mkd_responsive_title_image_container, #mkdf_mkd_title-height") ));
	$mkd_background_image_container->addChild("mkd_responsive-title-image",$mkd_responsive_title_image);


	$mkd_responsive_title_image_container = new MikadoContainer("mkd_responsive_title_image_container","mkd_responsive-title-image","yes");
	$mkd_background_image_container->addChild("mkd_responsive_title_image_container",$mkd_responsive_title_image_container);

	$mkd_fixed_title_image = new MikadoMetaField("selectblank","mkd_fixed-title-image","","Parallax Background Image","Do you want background image to have parallax effect?", array(
		"no" => "No",
		"yes" => "Yes",
		"yes_zoom" => "Yes, with zoom out"
	));
	$mkd_responsive_title_image_container->addChild("mkd_fixed-title-image",$mkd_fixed_title_image);

	$mkd_title_height = new MikadoMetaField("text","mkd_title-height","","Title Height (px)","Set a height for Title Area in pixels", array(), array("col_width" => 3));
	$mkd_page_title_area_container->addChild("mkd_title-height",$mkd_title_height);
	
	

	
//Separator

	$mkd_title_separator = new MikadoMetaField("selectblank","mkd_title_separator","","Show Title Separator","Enabling this option will display a separator underneath Title", array(
			"no" => "No",
			"yes" => "Yes"
		),
		array(
			"dependence" => true,
			"hide" => array(
				"" => "#mkdf_mkd_title_separator_container",
				"no" => "#mkdf_mkd_title_separator_container"
			),
			"show" => array(
				"yes" => "#mkdf_mkd_title_separator_container"
			)
		));
	$mkd_page_title_area_container->addChild("mkd_title_separator",$mkd_title_separator);

	$mkd_title_separator_container = new MikadoContainer("mkd_title_separator_container","mkd_title_separator","", array('', 'no'));
	$mkd_page_title_area_container->addChild("mkd_title_separator_container",$mkd_title_separator_container);

		$mkd_title_separator_format = new MikadoMetaField("select","mkd_title_separator_format","","Format","Choose a format (type) of separator", array(
				"" => "",
                "normal" => "Normal",
                "with_icon" => "With Icon",
                "with_custom_icon" => "With Custom Icon"
        ), array(
        "dependence" => true,
        "hide" => array(
        	"" => "#mkdf_mkd_separator_with_icon_container, #mkdf_mkd_separator_with_custom_icon_container",
        	"normal" => "#mkdf_mkd_separator_with_icon_container, #mkdf_mkd_separator_with_custom_icon_container",
        	"with_custom_icon" => "#mkdf_mkd_separator_with_icon_container",
        	"with_icon" => "#mkdf_mkd_separator_with_custom_icon_container"),
        "show" => array("with_icon" => "#mkdf_mkd_separator_with_icon_container", "with_custom_icon" => "#mkdf_mkd_separator_with_custom_icon_container" )));

        $mkd_title_separator_container->addChild("mkd_title_separator_format",$mkd_title_separator_format);

        $mkd_separator_with_icon_container = new MikadoContainer("mkd_separator_with_icon_container","mkd_title_separator_format","normal", array("normal","with_custom_icon",""));
		$mkd_title_separator_container->addChild("mkd_separator_with_icon_container",$mkd_separator_with_icon_container);

             //init icon pack hide and show array. It will be populated dinamically from collections array
			$separator_icon_pack_hide_array = array();
			$separator_icon_pack_show_array = array();
			$separator_icon_pack_hide_array[""] = "";

			//do we have some collection added in collections array?
			if(is_array($mkdIconCollections->iconCollections) && count($mkdIconCollections->iconCollections)) {
				//get collections params array. It will contain values of 'param' property for each collection
				$separator_icon_collections_params = $mkdIconCollections->getIconCollectionsParams();

				//foreach collection generate hide and show array
				foreach ($mkdIconCollections->iconCollections as $dep_collection_key => $dep_collection_object) {
					$separator_icon_pack_hide_array[$dep_collection_key] = '';

					//we need to include only current collection in show string as it is the only one that needs to show
					$separator_icon_pack_show_array[$dep_collection_key] = '#mkdf_mkd_separator_icon_'.$dep_collection_object->param.'_container';
					$separator_icon_pack_hide_array[""] .= '#mkdf_mkd_separator_icon_'.$dep_collection_object->param.'_container,';

					//for all collections param generate hide string
					foreach ($separator_icon_collections_params as $separator_icon_collections_param) {
						//we don't need to include current one, because it needs to be shown, not hidden
						if($separator_icon_collections_param !== $dep_collection_object->param) {
							$separator_icon_pack_hide_array[$dep_collection_key].= '#mkdf_mkd_separator_icon_'.$separator_icon_collections_param.'_container,';
						}
					}

					//remove remaining ',' character
					$separator_icon_pack_hide_array[$dep_collection_key] = rtrim($separator_icon_pack_hide_array[$dep_collection_key], ',');

				}

				$separator_icon_pack_hide_array[""] = rtrim($separator_icon_pack_hide_array[""], ',');

			}

			$mkd_separator_icon_pack = new MikadoMetaField(
				"selectblank",
				"mkd_separator_icon_pack",
				"",
				"Separator Icon Pack",
				"Choose icon pack for separator",
				$mkdIconCollections->getIconCollections(),
				array(
					"dependence" => true,
					"hide" => $separator_icon_pack_hide_array,
					"show" => $separator_icon_pack_show_array
				));

			$mkd_separator_with_icon_container->addChild("mkd_separator_icon_pack", $mkd_separator_icon_pack);

			if(is_array($mkdIconCollections->iconCollections) && count($mkdIconCollections->iconCollections)) {
				//foreach icon collection we need to generate separate container that will have dependency set
				//it will have one field inside with icons dropdown
				foreach ($mkdIconCollections->iconCollections as $collection_key => $collection_object) {
					$icons_array = $collection_object->getIconsArray();

					//get icon collection keys (keys from collections array, e.g 'font_awesome', 'font_elegant' etc.)
					$icon_collections_keys = $mkdIconCollections->getIconCollectionsKeys();

					//unset current one, because it doesn't have to be included in dependency that hides icon container
					unset($icon_collections_keys[array_search($collection_key, $icon_collections_keys)]);

					$separator_icon_hide_values = $icon_collections_keys;
					$separator_icon_hide_values[] = "";
					$mkd_separator_icon_container = new MikadoContainer("mkd_separator_icon_".$collection_object->param."_container", "mkd_separator_icon_pack", "", $separator_icon_hide_values);
					$mkd_separator_icon = new MikadoMetaField("select", "mkd_separator_icon_".$collection_object->param, "", "Separator Icon","Choose Separator Icon", $icons_array, array("col_width" => 3));
					$mkd_separator_icon_container->addChild("mkd_separator_icon_".$collection_object->param, $mkd_separator_icon);

					$mkd_separator_with_icon_container->addChild("mkd_separator_icon_".$collection_object->param."_container", $mkd_separator_icon_container);
				}

			}

			$group1 = new MikadoGroup("Icon Style", "Choose icon style");
			$mkd_separator_with_icon_container->addChild("group1",$group1);

				$row1 = new MikadoRow();
				$group1->addChild("row1",$row1);

					$mkd_title_separator_icon_color = new MikadoMetaField("colorsimple","mkd_title_separator_icon_color","","Color","Choose a color of icon for Title separator");
					$row1->addChild("mkd_title_separator_icon_color",$mkd_title_separator_icon_color);

					$mkd_title_separator_icon_hover_color = new MikadoMetaField("colorsimple","mkd_title_separator_icon_hover_color","","Hover Color","Choose a hover color of icon for Title separator");
					$row1->addChild("mkd_title_separator_icon_hover_color",$mkd_title_separator_icon_hover_color);

					$mkd_title_separator_icon_custom_size = new MikadoMetaField("textsimple","mkd_title_separator_icon_custom_size","","Icon Size","Choose size of icon");
					$row1->addChild("mkd_title_separator_icon_custom_size",$mkd_title_separator_icon_custom_size);

			$group2 = new MikadoGroup("Icon Position and Margin","Choose icon position and left(right) margin");
			$mkd_separator_with_icon_container->addChild("group2",$group2);

				$row1 = new MikadoRow();
				$group2->addChild("row1",$row1);

					$mkd_title_separator_icon_position = new MikadoMetaField("selectsimple","mkd_title_separator_icon_position","","Icon Position","Choose a position for an icon", array(
		                "left" => "Left",
		                "center" => "Center",
		                "right" => "Right"
		        	));
		        	$row1->addChild("mkd_title_separator_icon_position",$mkd_title_separator_icon_position);

		        	$mkd_title_separator_icon_margins = new MikadoMetaField("textsimple","mkd_title_separator_icon_margins","","Margins (px)","Enter margin that will refer to left and right margin of the icon");
		        	$row1->addChild("mkd_title_separator_icon_margins",$mkd_title_separator_icon_margins);

        	$mkd_title_separator_icon_type = new MikadoMetaField("selectblank","mkd_title_separator_icon_type","","Icon Type","Choose icon type", array(
                "normal" => "Normal",
                "circle" => "Circle",
                "square" => "Square"
        	),array("dependence" => true,
        		"hide" => array("normal" => "#mkdf_mkd_title_separator_types_container", "" => "#mkdf_mkd_title_separator_types_container"),
        		"show" => array("circle" => "#mkdf_mkd_title_separator_types_container","square" => "#mkdf_mkd_title_separator_types_container")));
        	$mkd_separator_with_icon_container->addChild("mkd_title_separator_icon_type",$mkd_title_separator_icon_type);

        	$mkd_title_separator_types_container = new MikadoContainer("mkd_title_separator_types_container","mkd_title_separator_icon_type","",array("","normal"));
			$mkd_separator_with_icon_container->addChild("mkd_title_separator_types_container",$mkd_title_separator_types_container);

				$group1 = new MikadoGroup("Border Style", "Define border style for icon");
				$mkd_title_separator_types_container->addChild("group1",$group1);

					$row1 = new MikadoRow();
					$group1->addChild("row1",$row1);

						$mkd_title_separator_icon_border_radius = new MikadoMetaField("textsimple","mkd_title_separator_icon_border_radius","","Border Radius (px)","Enter border radius for icon");
                		$row1->addChild("mkd_title_separator_icon_border_radius",$mkd_title_separator_icon_border_radius);

                		$mkd_title_separator_icon_border_width = new MikadoMetaField("textsimple","mkd_title_separator_icon_border_width","","Border Width (px)","Enter border width for icon");
                		$row1->addChild("mkd_title_separator_icon_border_width",$mkd_title_separator_icon_border_width);

                		$mkd_title_separator_icon_border_color = new MikadoMetaField("colorsimple","mkd_title_separator_icon_border_color","","Border Color","Enter border color for icon");
                		$row1->addChild("mkd_title_separator_icon_border_color",$mkd_title_separator_icon_border_color);

                		$mkd_title_separator_icon_border_hover_color = new MikadoMetaField("colorsimple","mkd_title_separator_icon_border_hover_color","","Border Hover Color","Enter border color for icon");
                		$row1->addChild("mkd_title_separator_icon_border_hover_color",$mkd_title_separator_icon_border_hover_color);

                $group2 = new MikadoGroup("Additional Icon Style","Choose adition icon styling");
                $mkd_title_separator_types_container->addChild("group2",$group2);

                	$row1 = new MikadoRow();
                	$group2->addChild("row1",$row1);

                		$mkd_title_separator_icon_shape_size = new MikadoMetaField("textsimple","mkd_title_separator_icon_shape_size","","Shape Size (px)","This is some description");
                		$row1->addChild("mkd_title_separator_icon_shape_size",$mkd_title_separator_icon_shape_size);

                		$mkd_title_separator_icon_background_color = new MikadoMetaField("colorsimple","mkd_title_separator_icon_background_color","","Background Color","This is some description");
                		$row1->addChild("mkd_title_separator_icon_background_color",$mkd_title_separator_icon_background_color);

                		$mkd_title_separator_icon_background_hover_color = new MikadoMetaField("colorsimple","mkd_title_separator_icon_background_hover_color","","Background Hover Color","This is some description");
                		$row1->addChild("mkd_title_separator_icon_background_hover_color",$mkd_title_separator_icon_background_hover_color);		                		

        $mkd_separator_with_custom_icon_container = new MikadoContainer("mkd_separator_with_custom_icon_container","mkd_title_separator_format","normal",array("normal","with_icon",""));
        $mkd_title_separator_container->addChild("mkd_separator_with_custom_icon_container",$mkd_separator_with_custom_icon_container);

        	$mkd_separator_custom_icon = new MikadoMetaField("image","mkd_separator_custom_icon","","Custom Icon","Choose custom icon for separator");
        	$mkd_separator_with_custom_icon_container->addChild("mkd_separator_custom_icon",$mkd_separator_custom_icon);

        $mkd_title_separator_type = new MikadoMetaField("select","mkd_title_separator_type","","Type","Choose a Title separator line style", array( "" => "",
                "solid" => "Solid",
                "dashed" => "Dashed"
        ));
        $mkd_title_separator_container->addChild("mkd_title_separator_type",$mkd_title_separator_type);

        $mkd_title_separator_position = new MikadoMetaField("select","mkd_title_separator_position","","Position","Choose a Title separator position", array( "" => "",
                "above" => "Above Title",
                "below" => "Below Title"
        ));
        $mkd_title_separator_container->addChild("mkd_title_separator_position",$mkd_title_separator_position);

        $mkd_title_separator_color = new MikadoMetaField("color","mkd_title_separator_color","","Color","Choose a color for Title separator");
        $mkd_title_separator_container->addChild("mkd_title_separator_color",$mkd_title_separator_color);

        $group1 = new MikadoGroup("Size",'Define size for Title separator');
        $mkd_title_separator_container->addChild("group1",$group1);

        $row1 = new MikadoRow();
        $group1->addChild("row1",$row1);

                $mkd_title_separator_thickness = new MikadoMetaField("textsimple","mkd_title_separator_thickness","","Thickness (px)","This is some description");
                $row1->addChild("mkd_title_separator_thickness",$mkd_title_separator_thickness);

                $mkd_title_separator_width = new MikadoMetaField("textsimple","mkd_title_separator_width","","Width (px)","This is some description");
                $row1->addChild("mkd_title_separator_width",$mkd_title_separator_width);

        $group2 = new MikadoGroup("Margin",'Add space at top and bottom of Title separator');
        $mkd_title_separator_container->addChild("group2",$group2);

        $row1 = new MikadoRow();
        $group2->addChild("row1",$row1);

                $mkd_title_separator_topmargin = new MikadoMetaField("textsimple","mkd_title_separator_topmargin","","Top Margin (px)","This is some description");
                $row1->addChild("mkd_title_separator_topmargin",$mkd_title_separator_topmargin);

                $mkd_title_separator_bottommargin = new MikadoMetaField("textsimple","mkd_title_separator_bottommargin","","Bottom Margin (px)","This is some description");
                $row1->addChild("mkd_title_separator_bottommargin",$mkd_title_separator_bottommargin);

    $mkd_title_graphics = new MikadoMetaField("image","mkd_title-graphics","","Title Graphics","Choose a graphic for Title Area, appearing above title");
	$mkd_title_standard_container->addChild("mkd_title-graphics",$mkd_title_graphics);


	$mkd_enable_breadcrumbs = new MikadoMetaField("selectblank","mkd_enable_breadcrumbs","","Enable Breadcrumbs","Do you want to display breadcrumbs in title area?", array(
		"no" => "No",
		"yes" => "Yes"
	));
	$mkd_page_title_area_container->addChild("mkd_enable_breadcrumbs",$mkd_enable_breadcrumbs);

	$mkd_page_breadcrumbs_color = new MikadoMetaField("color","mkd_page_breadcrumbs_color","","Breadcrumbs Color","Choose a color for breadcrumbs text ");
	$mkd_page_title_area_container->addChild("mkd_page_breadcrumbs_color",$mkd_page_breadcrumbs_color);

	$mkd_page_subtitle = new MikadoMetaField("text","mkd_page_subtitle","","Subtitle Text","Enter your subtitle text");
	$mkd_page_title_area_container->addChild("mkd_page_subtitle",$mkd_page_subtitle);

	
	$mkd_page_subtitle_position = new MikadoMetaField("selectblank","mkd_page_subtitle_position","","Subtitle Position","Choose a Subtitle position", array(
			"below_title" => "Below Title",
			"above_title" => "Above Title"
	));
	$mkd_page_title_area_container->addChild("mkd_page_subtitle_position",$mkd_page_subtitle_position);
	
	
	
	$mkd_page_subtitle_color = new MikadoMetaField("color","mkd_page_subtitle_color","","Subtitle Text Color","Choose a color for subtitle text");
	$mkd_page_title_area_container->addChild("mkd_page_subtitle_color",$mkd_page_subtitle_color);

	$mkd_title_content_style = new MikadoGroup("Title Content Style", "Define style for title area content");
	$mkd_page_title_area_container->addChild("mkd_title_content_style", $mkd_title_content_style);

		$row1 = new MikadoRow();
		$mkd_title_content_style->addChild("row1", $row1);

			$mkd_title_area_content_background_color = new MikadoMetaField("colorsimple","mkd_title_area_content_background_color","","Title Area Content Background Color","Choose a background color for Title Area Content");
			$row1->addChild("mkd_title_area_content_background_color",$mkd_title_area_content_background_color);

			$mkd_title_area_content_opacity = new MikadoMetaField("textsimple","mkd_title_area_content_opacity","","Title Area Content Background Color Opacity","Choose a transparency for the content area background color (0 = fully transparent, 1 = opaque)");
			$row1->addChild("mkd_title_area_content_opacity",$mkd_title_area_content_opacity);

	$mkd_title_style = new MikadoGroup("Title Style", "Define style for title");
	$mkd_page_title_area_container->addChild("mkd_title_style", $mkd_title_style);

		$row1 = new MikadoRow();
		$mkd_title_style->addChild("row1", $row1);

			$mkd_title_background_color = new MikadoMetaField("colorsimple","mkd_title_background_color","","Title Background Color","Choose a background color for Title");
			$row1->addChild("mkd_title_background_color",$mkd_title_background_color);

			$mkd_title_opacity = new MikadoMetaField("textsimple","mkd_title_opacity","","Title Background Color Opacity","Choose a transparency for the title background color (0 = fully transparent, 1 = opaque)");
			$row1->addChild("mkd_title_opacity",$mkd_title_opacity);

	$title_padding_group = new MikadoGroup("Padding","Define padding for title (When using separator around title, only right margin is counted for left/right margin)");
    $mkd_page_title_area_container->addChild("title_padding_group",$title_padding_group);
        
        $row1 = new MikadoRow(true);
        $title_padding_group->addChild("row1",$row1);

			$mkd_title_top_padding = new MikadoMetaField("textsimple","mkd_title_top_padding","","Top Padding (px)","This is some description.");
			$row1->addChild("mkd_title_top_padding",$mkd_title_top_padding);	

			$mkd_title_right_padding = new MikadoMetaField("textsimple","mkd_title_right_padding","","Right Padding (px)","This is some description.");
			$row1->addChild("mkd_title_right_padding",$mkd_title_right_padding);	

			$mkd_title_bottom_padding = new MikadoMetaField("textsimple","mkd_title_bottom_padding","","Bottom Padding (px)","This is some description.");
			$row1->addChild("mkd_title_bottom_padding",$mkd_title_bottom_padding);	

			$mkd_title_left_padding = new MikadoMetaField("textsimple","mkd_title_left_padding","","Left Padding (px)","This is some description.");
			$row1->addChild("mkd_title_left_padding",$mkd_title_left_padding);

	$mkd_subtitle_style = new MikadoGroup("Subtitle Style", "Define style for subtitle");
	$mkd_page_title_area_container->addChild("mkd_subtitle_style", $mkd_subtitle_style);

		$row1 = new MikadoRow();
		$mkd_subtitle_style->addChild("row1", $row1);	

			$mkd_subtitle_background_color = new MikadoMetaField("colorsimple","mkd_subtitle_background_color","","Subtitle Background Color","Choose a background color for Subtitle");
			$row1->addChild("mkd_subtitle_background_color",$mkd_subtitle_background_color);

			$mkd_subtitle_opacity = new MikadoMetaField("textsimple","mkd_subtitle_opacity","","Subtitle Background Color Opacity","Choose a transparency for the subtitle background color (0 = fully transparent, 1 = opaque)");
			$row1->addChild("mkd_subtitle_opacity",$mkd_subtitle_opacity);

	$subtitle_padding_group = new MikadoGroup("Padding","Define padding for subtitle (When using separator around subtitle, only right margin is counted for left/right margin)");
    $mkd_page_title_area_container->addChild("subtitle_padding_group",$subtitle_padding_group);
        $row1 = new MikadoRow(true);
        $subtitle_padding_group->addChild("row1",$row1);

			$mkd_subtitle_top_padding = new MikadoMetaField("textsimple","mkd_subtitle_top_padding","","Top Padding (px)","This is some description.");
			$row1->addChild("mkd_subtitle_top_padding",$mkd_subtitle_top_padding);

			$mkd_subtitle_right_padding = new MikadoMetaField("textsimple","mkd_subtitle_right_padding","","Right Padding (px)","This is some description.");
			$row1->addChild("mkd_subtitle_right_padding",$mkd_subtitle_right_padding);

			$mkd_subtitle_bottom_padding = new MikadoMetaField("textsimple","mkd_subtitle_bottom_padding","","Bottom Padding (px)","This is some description.");
			$row1->addChild("mkd_subtitle_bottom_padding",$mkd_subtitle_bottom_padding);

			$mkd_subtitle_left_padding = new MikadoMetaField("textsimple","mkd_subtitle_left_padding","","Left Padding (px)","This is some description.");
			$row1->addChild("mkd_subtitle_left_padding",$mkd_subtitle_left_padding);


// Content Bottom

$mkdContentBottom = new MikadoMetaBox("page", "Content Bottom");
$mkdFramework->mkdMetaBoxes->addMetaBox("page_content_bottom",$mkdContentBottom);

	$mkd_enable_content_bottom_area = new MikadoMetaField("selectblank","mkd_enable_content_bottom_area","","Show Content Bottom Area","Do you want to show content bottom area?", array(
	   "no" => "No",
	   "yes" => "Yes"
	  ),
	  array("dependence" => true,
		"hide" => array(
			"no"=>"#mkdf_mkd_enable_content_bottom_area_container",
			""=>"#mkdf_mkd_enable_content_bottom_area_container"),
		"show" => array(
			"yes"=>"#mkdf_mkd_enable_content_bottom_area_container") ));
	$mkdContentBottom->addChild("mkd_enable_content_bottom_area",$mkd_enable_content_bottom_area);
	
	$mkd_enable_content_bottom_area_container = new MikadoContainer("mkd_enable_content_bottom_area_container","mkd_enable_content_bottom_area","no",array("", "no"));
	$mkdContentBottom->addChild("mkd_enable_content_bottom_area_container",$mkd_enable_content_bottom_area_container);

		$mkd_content_bottom_background_color = new MikadoMetaField("color","mkd_content_bottom_background_color","","Background Color","Choose a color for content bottom area");
		$mkd_enable_content_bottom_area_container->addChild("mkd_content_bottom_background_color",$mkd_content_bottom_background_color);
	
		$mkd_choose_content_bottom_sidebar = new MikadoMetaField("selectblank","mkd_choose_content_bottom_sidebar","","Custom Widget","Choose Custom Widget area to display",$mkd_custom_sidebars);
		$mkd_enable_content_bottom_area_container->addChild("mkd_choose_content_bottom_sidebar",$mkd_choose_content_bottom_sidebar);
	
		$mkd_content_bottom_sidebar_in_grid = new MikadoMetaField("selectblank","mkd_content_bottom_sidebar_in_grid","","Display in Grid","Enabling this option will place Content Bottom in grid",array(
		   "no" => "No",
		   "yes" => "Yes"
		  ));
		$mkd_enable_content_bottom_area_container->addChild("mkd_content_bottom_sidebar_in_grid",$mkd_content_bottom_sidebar_in_grid);


// Blog

$mkdBlog = new MikadoMetaBox("page", "Blog");
$mkdFramework->mkdMetaBoxes->addMetaBox("page_blog",$mkdBlog);

	$mkd_choose_blog_category = new MikadoMetaField("selectblank","mkd_choose-blog-category","","Blog Category","Choose category of posts to display (leave empty to display all categories)",$mkd_blog_categories);
	$mkdBlog->addChild("mkd_choose-blog-category",$mkd_choose_blog_category);

	$mkd_show_posts_per_page = new MikadoMetaField("text","mkd_show-posts-per-page","","Number of Posts","Enter the number of posts to display", array(), array("col_width" => 3));
	$mkdBlog->addChild("mkd_show-posts-per-page",$mkd_show_posts_per_page);

	$mkd_enable_page_comments = new MikadoMetaField("yesno","mkd_enable-page-comments","no","Show Comments","Enabling this option will show comments on your page ");
	$mkdBlog->addChild("mkd_enable-page-comments",$mkd_enable_page_comments);


// Side Bar Area

$mkdSideBar = new MikadoMetaBox("page", "Sidebar");
$mkdFramework->mkdMetaBoxes->addMetaBox("page_side_bar",$mkdSideBar);

	$mkd_show_sidebar = new MikadoMetaField("select","mkd_show-sidebar","default","Layout","Choose the sidebar layout",array( "default" => "Default",
	   "1" => "Sidebar 1/3 right",
	   "2" => "Sidebar 1/4 right",
	   "3" => "Sidebar 1/3 left",
	   "4" => "Sidebar 1/4 left",
	  ));
	$mkdSideBar->addChild("mkd_show-sidebar",$mkd_show_sidebar);

	$mkd_choose_sidebar = new MikadoMetaField("selectblank","mkd_choose-sidebar","default","Choose Widget Area in Sidebar","Choose Custom Widget area to display in Sidebar", $mkd_custom_sidebars);
	$mkdSideBar->addChild("mkd_choose-sidebar",$mkd_choose_sidebar);

// Footer

$mkdFooter = new MikadoMetaBox("page", "Footer");
$mkdFramework->mkdMetaBoxes->addMetaBox("page_footer",$mkdFooter);

    $mkd_footer_disable = new MikadoMetaField("yesno","mkd_footer-disable","no","Disable Footer for this Page",
        "Enabling this option will hide footer on your page");
    $mkdFooter->addChild("mkd_footer-disable",$mkd_footer_disable);


// Full Screen Template

$mkdFullScreenTemplate = new MikadoMetaBox("page", "Full Screen Template");
$mkdFramework->mkdMetaBoxes->addMetaBox("page_full_screen_template",$mkdFullScreenTemplate);

	$mkd_full_screen_sections_on_small_screens = new MikadoMetaField("selectblank","mkd_full_screen_sections_on_small_screens","","Enable Full Screen Sections on Small Screens","Enabling this option will turn on Full Screen Sections on small screens", array(
        "no" => "No",
        "yes" => "Yes"));
    $mkdFullScreenTemplate->addChild("mkd_full_screen_sections_on_small_screens",$mkd_full_screen_sections_on_small_screens);

	
// SEO

$mkdSeo = new MikadoMetaBox("page", "SEO");
$mkdFramework->mkdMetaBoxes->addMetaBox("page_seo",$mkdSeo);

	$seo_title = new MikadoMetaField("text","mkd_seo_title","","SEO Title","Enter custom Title for this page");
	$mkdSeo->addChild("mkd_seo_title",$seo_title);

	$seo_keywords = new MikadoMetaField("text","mkd_seo_keywords","","SEO Keywords","Enter the list of keywords separated by commas");
	$mkdSeo->addChild("mkd_seo_keywords",$seo_keywords);

	$seo_description = new MikadoMetaField("textarea","mkd_seo_description","","SEO Description","Enter meta description for this page");
	$mkdSeo->addChild("mkd_seo_description",$seo_description);