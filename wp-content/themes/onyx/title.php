<?php 
global $mkd_options, $mkdIconCollections;

/* Set id on -1 beacause archive page id can have same id as some post and settings is not good */
if(is_category() || is_tag() || is_author()){
	$archive_id = $id;
	$id = mkd_get_page_id();
}

if(get_post_meta($id, "mkd_responsive-title-image", true) != ""){
 $responsive_title_image = get_post_meta($id, "mkd_responsive-title-image", true);
}else{
	$responsive_title_image = $mkd_options['responsive_title_image'];
}

if(get_post_meta($id, "mkd_fixed-title-image", true) != ""){
 $fixed_title_image = get_post_meta($id, "mkd_fixed-title-image", true);
}else{
	$fixed_title_image = $mkd_options['fixed_title_image'];
}

$title_image = '';
if(get_post_meta($id, "mkd_title-image", true) != ""){
    $title_image = get_post_meta($id, "mkd_title-image", true);
}else{
    $title_image = $mkd_options['title_image'];
}
$title_image_height = "";
$title_image_width = "";
if($title_image !== ''){
	$title_image_dimensions_array = mkd_get_image_dimensions($title_image);
	if (count($title_image_dimensions_array)) {
	    $title_image_height = $title_image_dimensions_array["height"];
	    $title_image_width = $title_image_dimensions_array["width"];
	}
}

$title_graphics = "";
if (get_post_meta($id, "mkd_title-graphics", true) !== "") {
    $title_graphics = get_post_meta($id, "mkd_title-graphics", true);
}
elseif($mkd_options['title_graphics'] != "") {
    $title_graphics = $mkd_options['title_graphics'];
}

if(get_post_meta($id, "mkd_title-overlay-image", true) != ""){
 $title_overlay_image = get_post_meta($id, "mkd_title-overlay-image", true);
}else{
	$title_overlay_image = $mkd_options['title_overlay_image'];
}
$logo_width = $mkd_options['logo_width'];
$logo_height = $mkd_options['logo_height'];
if (isset($mkd_options['header_bottom_appearance'])) {
    $header_bottom_appearance = $mkd_options['header_bottom_appearance'];
}

$header_top_border=0;
$header_bottom_border=0;
if(isset($mkd_options['enable_header_top_border']) && $mkd_options['enable_header_top_border']=='yes' && isset($mkd_options['header_top_border_width']) && $mkd_options['header_top_border_width']!==''){
    $header_top_border = esc_attr($mkd_options['header_top_border_width']);
}
if(isset($mkd_options['enable_header_bottom_border']) && $mkd_options['enable_header_bottom_border']=='yes' && isset($mkd_options['header_bottom_border_width']) && $mkd_options['header_bottom_border_width']!==''){
    $header_bottom_border = esc_attr($mkd_options['header_bottom_border_width']);
}

$header_centered_logo_border = 0;
if(isset($mkd_options['center_logo_image']) && $mkd_options['center_logo_image'] == "yes" && isset($mkd_options['enable_border_top_bottom_menu']) && $mkd_options['enable_border_top_bottom_menu'] == "yes"){
    $header_centered_logo_border = 2;
}

$header_height = 105;
if (!empty($mkd_options['header_height']) && $header_bottom_appearance != "fixed_hiding") {
    $header_height = esc_attr($mkd_options['header_height']);
} elseif($header_bottom_appearance == "fixed_hiding"){
    $header_height = 105 + $logo_height/2 + 40; // 40 is top and bottom margin of logo
} elseif(isset($mkd_options['center_logo_image']) && $mkd_options['center_logo_image'] == "yes" && $header_bottom_appearance == "fixed") {
    if($header_bottom_appearance == "fixed" && $logo_height > 105){
        $header_height = 105 + 105 + 20; //20 is top and bottom margin of logo, 105 is default header height, other 105 is logo height
    }
    if($header_bottom_appearance == "fixed" && $logo_height < 105){
        $header_height = 105 + $logo_height + 20; //20 is top and bottom margin of logo, 105 is default header height
    }
}

if($mkd_options['header_bottom_appearance'] == 'stick menu_bottom'){
    $menu_bottom = 60;
    if(is_active_sidebar('header_fixed_right')){
        $menu_bottom = $menu_bottom + 26;
    }
} else {
    $menu_bottom = 0;
}


$header_height = $header_height + $menu_bottom + $header_top_border + $header_bottom_border + $header_centered_logo_border;

$header_top = 0;
if(isset($mkd_options['header_top_area']) && $mkd_options['header_top_area'] == "yes"){
	if(isset($mkd_options['header_top_height']) && $mkd_options['header_top_height'] !== ""){
		$header_top = $mkd_options['header_top_height'];
	} else {
		$header_top = 36;
	}
}


//title vertical alignment
$title_vertical_alignment = 'header_bottom';
if(get_post_meta($id, "mkd_page_page_title_vertical_aligment", true) == 'header_bottom') {
	$title_vertical_alignment = 'header_bottom';
}elseif(get_post_meta($id, "mkd_page_page_title_vertical_aligment", true) == 'window_top') {
	$title_vertical_alignment = 'window_top';
}elseif(get_post_meta($id, "mkd_page_page_title_vertical_aligment", true) == '' && (isset($mkd_options['page_title_vertical_aligment']) && $mkd_options['page_title_vertical_aligment'] == 'header_bottom')) {
	$title_vertical_alignment = 'header_bottom';
} elseif(get_post_meta($id, "mkd_page_page_title_vertical_aligment", true) == '' && (isset($mkd_options['page_title_vertical_aligment']) && $mkd_options['page_title_vertical_aligment'] == 'window_top')) {
	$title_vertical_alignment = 'window_top';
}


$header_height_padding = 0;

if($title_vertical_alignment=='header_bottom'){

if ($header_bottom_appearance != "fixed" && $header_bottom_appearance != "fixed_hiding" && $header_bottom_appearance != "regular") {
    if ($mkd_options['center_logo_image'] != "yes") {

        $header_height_padding = $header_top + $header_height;

    } else {
        if($header_bottom_appearance == "stick menu_bottom") {

            $header_height_padding = 20 + $logo_height/2 + $menu_bottom + $header_top + $header_top_border + $header_bottom_border + $header_centered_logo_border; // 20 is top margin of centered logo

        } elseif($header_bottom_appearance == "stick_with_left_right_menu"){

            $header_height_padding = $header_height + $header_top;

        }  else {

            $header_height_padding = (20 + $logo_height/2 + $header_height + $header_top); // 20 is top margin of centered logo
        }
    }
} else {
    $header_height_padding = $header_height + $header_top;
}

if (!empty($mkd_options['header_height'])) {
    if($header_bottom_appearance == "fixed_hiding") {
        $header_height_padding =  esc_attr($mkd_options['header_height']) + $header_top + $logo_height/2 + 40 + $header_top_border + $header_bottom_border + $header_centered_logo_border; // 40 is top and bottom margin of logo
    } elseif($mkd_options['center_logo_image'] == "yes"){
        if($header_bottom_appearance == "fixed") {
            if ($mkd_options['header_height'] > $logo_height) {
                $header_height_padding = esc_attr($mkd_options['header_height']) + $header_top + $logo_height + 20 + $header_top_border + $header_bottom_border + $header_centered_logo_border; // 20 is top margin of logo
            } else {
                $header_height_padding = (esc_attr($mkd_options['header_height'])) * 2 + $header_top + 20 + $header_top_border + $header_bottom_border + $header_centered_logo_border; // 20 is top margin of logo
            }
        }
        if($header_bottom_appearance == "stick"){
            $header_height_padding = (20 + $logo_height/2 + esc_attr($mkd_options['header_height']) + $header_top + $header_top_border + $header_bottom_border + $header_centered_logo_border); // 20 is top margin of centered logo
        }
    } else {
        if($header_bottom_appearance != "stick menu_bottom") {
            $header_height_padding = esc_attr($mkd_options['header_height']) + $header_top + $header_top_border + $header_bottom_border + $header_centered_logo_border;
        }
    }
}

}

else if ($title_vertical_alignment=='window_top'){
	$header_height_padding = 0;
}

$title_type = "standard_title";
if(get_post_meta($id, "mkd_page_title_type", true) != ""){
    $title_type = get_post_meta($id, "mkd_page_title_type", true);
}else{
    if(isset($mkd_options['title_type'])){
        $title_type = $mkd_options['title_type'];
    }
}

$subtitle_position = "below_title";
if(get_post_meta($id, "mkd_page_subtitle_position", true) != ""){
    $subtitle_position = get_post_meta($id, "mkd_page_subtitle_position", true);
}else{
    if(isset($mkd_options['subtitle_position'])){
        $subtitle_position = $mkd_options['subtitle_position'];
    }
}

$enable_subtitle_breadcrumbs = false;
if(get_post_meta($id, "mkd_enable_subtitle_breadcrumbs", true) != ""){
	if (get_post_meta($id, "mkd_enable_subtitle_breadcrumbs", true) == "yes"){
		$enable_subtitle_breadcrumbs = true;
	}
	else {
		$enable_subtitle_breadcrumbs = false;
	}
}
else if (isset($mkd_options['enable_subtitle_breadcrumbs']) && $mkd_options['enable_subtitle_breadcrumbs'] == 'yes') {
	$enable_subtitle_breadcrumbs = true;
}

//init variables
$title_subtitle_padding 	= '';
$header_transparency 		= '';
$is_header_transparent  	= false;
$transparent_values_array 	= array('0.00', '0');
$solid_values_array			= array('', '1');
$header_bottom_border		= '';
$is_title_area_visible		= true;
$is_title_text_visible		= true;

//this is done this way because content was already created
//and we had to keep current settings for existing pages
//checkbox that was previously here had 'yes' value when title area is hidden
if(get_post_meta($id, "mkd_show-page-title", true) == 'yes') {
	$is_title_area_visible = true;
} elseif(get_post_meta($id, "mkd_show-page-title", true) == 'no') {
	$is_title_area_visible = false;
} elseif(get_post_meta($id, "mkd_show-page-title", true) == '' && (isset($mkd_options['show_page_title']) && $mkd_options['show_page_title'] == 'yes')) {
	$is_title_area_visible = true;
} elseif(get_post_meta($id, "mkd_show-page-title", true) == '' && (isset($mkd_options['show_page_title']) && $mkd_options['show_page_title'] == 'no')) {
	$is_title_area_visible = false;
} elseif(isset($mkd_options['show_page_title']) && $mkd_options['show_page_title'] == 'yes') {
	$is_title_area_visible = true;
}

//is title text visible
if(get_post_meta($id, "mkd_show_page_title_text", true) == 'yes') {
	$is_title_text_visible = true;
} elseif(get_post_meta($id, "mkd_show_page_title_text", true) == 'no') {
	$is_title_text_visible = false;
} elseif(get_post_meta($id, "mkd_show_page_title_text", true) == '' && (isset($mkd_options['show_page_title_text']) && $mkd_options['show_page_title_text'] == 'yes')) {
	$is_title_text_visible = true;
} elseif(get_post_meta($id, "mkd_show_page_title_text", true) == '' && (isset($mkd_options['show_page_title_text']) && $mkd_options['show_page_title_text'] == 'no')) {
	$is_title_text_visible = false;
} elseif(isset($mkd_options['show_page_title_text']) && $mkd_options['show_page_title_text'] == 'yes') {
	$is_title_text_visible = true;
}

//is header transparent not set on current page?
if(get_post_meta($id, "mkd_header_color_transparency_per_page", true) === "" || mkd_is_default_wp_template()) {
	//take global value set in Mikado Options
	$header_transparency = esc_attr($mkd_options['header_background_transparency_initial']);
} else {
	//take value set for current page
	$header_transparency = esc_attr(get_post_meta($id, "mkd_header_color_transparency_per_page", true));
}

//is header completely transparent?
$is_header_transparent 	= in_array($header_transparency, $transparent_values_array);

//is header solid?
$is_header_solid		= in_array($header_transparency, $solid_values_array);

//is header some of sticky types and initially hidden
$is_header_initially_hidden = false;
if(isset($mkd_options['header_bottom_appearance']) && ($mkd_options['header_bottom_appearance'] == "stick" || $mkd_options['header_bottom_appearance'] == "stick menu_bottom" || $mkd_options['header_bottom_appearance'] == "stick_with_left_right_menu")){
	if(get_post_meta($id, "mkd_page_hide_initial_sticky", true) !== "") {
		if(get_post_meta($id, "mkd_page_hide_initial_sticky", true) === "yes") {
				$is_header_initially_hidden = true;
		}
	} else if(isset($mkd_options['hide_initial_sticky']) && $mkd_options['hide_initial_sticky'] == 'yes'){
		$is_header_initially_hidden = true;
	}
} 

$title_height = 200; // default title height without header height
if($title_type == "breadcrumbs_title") {
    $title_height = 88;
}

if(get_post_meta($id, "mkd_title-height", true) != ""){
	$title_height = esc_attr(get_post_meta($id, "mkd_title-height", true));
}elseif($mkd_options['title_height'] != ''){
	$title_height = esc_attr($mkd_options['title_height']);
}
//is header solid?
if(!$is_header_solid && !$is_header_initially_hidden && $mkd_options['header_bottom_appearance'] != 'regular' && get_post_meta($id, "mkd_enable_content_top_margin", true) != "yes"){
//	if ((isset($mkd_options['center_logo_image']) && $mkd_options['center_logo_image'] == "yes") || $mkd_options['header_bottom_appearance'] == 'fixed_hiding') {
//		if($mkd_options['header_bottom_appearance'] == 'stick menu_bottom'){
//	        $title_height = $title_height + $header_height + $header_top + $logo_height + 20; // 20 is top margin of centered logo
//	    } elseif($mkd_options['header_bottom_appearance'] == 'fixed_hiding' || $mkd_options['header_bottom_appearance'] == 'fixed'){
//	        if(!empty($mkd_options['header_height']) && $mkd_options['header_bottom_appearance'] == "fixed"){
//	        	$title_height = $title_height + $mkd_options['header_height'] + $header_top + $logo_height + 20;
//	        } else {
//	        	$title_height = $title_height + $header_height + $header_top;
//	        }
//	    } else {
//	        $title_height = $title_height + $header_height + $header_top + $logo_height + 20; // 20 is top margin of centered logo
//	    }
//	} else {
//		$title_height = $title_height + $header_height + $header_top;
//	}
    $title_height = $title_height + $header_height_padding;
	//is header semi-transparent?
	if(!$is_header_transparent) {
		$title_calculated_height = $title_height - $header_height_padding;

		if($title_calculated_height < 0) {
			$title_calculated_height = 0;
		}

		//center title between border and end of title section
		$title_holder_height = 'padding-top:' . $header_height_padding . 'px;height:' . ($title_calculated_height) . 'px;';
		$title_subtitle_padding = 'padding-top:' . esc_attr($header_height_padding) . 'px;';
	} else {
		//header is transparent
		$title_holder_height = 'padding-top:'.$header_height_padding.'px;height:'.($title_height - $header_height_padding).'px;';
		$title_subtitle_padding = 'padding-top:'.esc_attr($header_height_padding).'px;';
	}
} else {
	$title_holder_height = 'height:'.$title_height.'px;';
	$title_subtitle_padding = '';
}

$title_background_color = '';
if(get_post_meta($id, "mkd_page-title-background-color", true) != ""){
    $title_background_color = esc_attr(get_post_meta($id, "mkd_page-title-background-color", true));
}else{
    $title_background_color = esc_attr($mkd_options['title_background_color']);
}

$show_title_image = true;
if(get_post_meta($id, "mkd_show-page-title-image", true) == "yes") {
    $show_title_image = false;
}
$mkd_page_title_style = "standard";
if(get_post_meta($id, "mkd_page_title_style", true) != ""){
    $mkd_page_title_style = get_post_meta($id, "mkd_page_title_style", true);
}else{
    if(isset($mkd_options['title_style'])) {
        $mkd_page_title_style = $mkd_options['title_style'];
    } else {
        $mkd_page_title_style = "standard";
    }
}

$animate_title_area = '';
if(get_post_meta($id, "mkd_animate_page_title", true) != ""){
    $animate_title_area = get_post_meta($id, "mkd_animate_page_title", true);
}else{
    $animate_title_area = $mkd_options['animate_title_area'];
}

if($animate_title_area == "text_right_left") {
    $animate_title_class = "animate_title_text";
} elseif($animate_title_area == "area_top_bottom"){
    $animate_title_class = "animate_title_area";
} else {
    $animate_title_class = "title_without_animation";
}

//is vertical menu activated in Mikado Options?
if(isset($mkd_options['vertical_area']) && $mkd_options['vertical_area'] =='yes' && isset($mkd_options['paspartu']) && $mkd_options['paspartu'] == 'no'){
    $title_subtitle_padding = 0;
    $title_holder_height = 200;
    if($title_type == "breadcrumbs_title") {
        $title_holder_height = 100;
    }
    $title_height = 200; // default title height without header height
    if($title_type == "breadcrumbs_title") {
        $title_height = 100;
    }
    if(get_post_meta($id, "mkd_title-height", true) != ""){
        $title_holder_height = get_post_meta($id, "mkd_title-height", true);
        $title_height = esc_attr(get_post_meta($id, "mkd_title-height", true));
    }else if($mkd_options['title_height'] != ''){
        $title_holder_height = $mkd_options['title_height'];
        $title_height = esc_attr($mkd_options['title_height']);
    }
    $title_holder_height = 'height:' . esc_attr($title_holder_height). 'px;';
}

$enable_breadcrumbs = 'no';
if(get_post_meta($id, "mkd_enable_breadcrumbs", true) != ""){
	$enable_breadcrumbs = get_post_meta($id, "mkd_enable_breadcrumbs", true);
}elseif(isset($mkd_options['enable_breadcrumbs'])){
	$enable_breadcrumbs = $mkd_options['enable_breadcrumbs'];
}

$title_text_shadow = '';
if(get_post_meta($id, "mkd_title_text_shadow", true) != ""){
	if(get_post_meta($id, "mkd_title_text_shadow", true) == "yes"){
		$title_text_shadow = ' title_text_shadow';
	}
}else{
	if($mkd_options['title_text_shadow'] == "yes"){
		$title_text_shadow = ' title_text_shadow';
	}
}
$subtitle_color ="";
if(get_post_meta($id, "mkd_page_subtitle_color", true) != ""){
	$subtitle_color = "color:" . esc_attr(get_post_meta($id, "mkd_page_subtitle_color", true)) . ";";
}

if (is_tag()) {
	$title = single_term_title("", false)." Tag";
}elseif (is_date()) {
	$title = get_the_time('F Y');
}elseif (is_author()){
	$title = __('Author:', 'mkd').get_the_author();
}elseif (is_category()){
	$title = single_cat_title('', false);
}elseif (is_home()){
	$title = get_option('blogname');
}elseif (is_search()){
    $title = __('Results for', 'mkd').': '.get_search_query();
}elseif (is_404()){
	if($mkd_options['404_title'] != "") {
		$title = $mkd_options['404_title'];
	} else { 
		$title = __('404 - Page not found', 'mkd');
	}
}elseif(function_exists("is_woocommerce") && (is_shop() || is_singular('product'))){
	global $woocommerce;
	$shop_id = get_option('woocommerce_shop_page_id');
	$shop= get_page($shop_id);
	$title = $shop->post_title;
}elseif(function_exists("is_woocommerce") && (is_product_category() || is_product_tag())){
	global $wp_query;
	$tax = $wp_query->get_queried_object();
	$category_title = $tax->name;
	$title = $category_title;
}elseif (is_archive()){
	$title = __('Archive','mkd');
}else {
	$title = get_the_title($id);
}

$title_shortcode = "";

$title_like_separator = false;

if (get_post_meta($id,"mkd_title_like_separator",true) == "yes" || (isset($mkd_options['title_like_separator']) && $mkd_options['title_like_separator']=='yes' && get_post_meta($id,"mkd_title_like_separator",true) != "no")) {
    $title_like_separator = true;
}

if ($title_like_separator) {

    $title_shortcode .= 'title = "' . $title . '"';

    if (get_post_meta($id,'mkd_page_title_position',true) != "") {
        $title_shortcode .= ' text_position = "' . get_post_meta($id,'mkd_page_title_position',true) . '"';
    }
    elseif (isset($mkd_options['page_title_position']) && !empty($mkd_options['page_title_position'])) {
        $title_shortcode .= ' text_position = "' . $mkd_options['page_title_position'] . '"';
    }

    if (get_post_meta($id, "mkd_page-title-color", true) != "") {  
        $title_shortcode .= ' title_color = "' . get_post_meta($id, "mkd_page-title-color", true) . '"';
    }

    if (get_post_meta($id, "mkd_title_like_separator_line_color", true) != "") {  
        $title_shortcode .= ' line_color = "' . get_post_meta($id, "mkd_title_like_separator_line_color", true) . '"';
    }
    elseif (isset($mkd_options['title_like_separator_line_color']) && !empty($mkd_options['title_like_separator_line_color'])) {
        $title_shortcode .= ' line_color = "' . $mkd_options['title_like_separator_line_color'] . '"';
    }

    if (get_post_meta($id, "mkd_title_like_separator_line_width", true) != "") {  
        $title_shortcode .= ' line_width = "' .   get_post_meta($id, "mkd_title_like_separator_line_width", true) . '"';
    }
    elseif (isset($mkd_options['title_like_separator_line_width']) && !empty($mkd_options['title_like_separator_line_width'])) {
        $title_shortcode .= ' line_width = "' . $mkd_options['title_like_separator_line_width'] . '"';
    }

    if (get_post_meta($id, "mkd_title_like_separator_line_thickness", true) != "") {  
        $title_shortcode .= ' line_thickness = "' .   get_post_meta($id, "mkd_title_like_separator_line_thickness", true) . '"';
    }
    elseif (isset($mkd_options['title_like_separator_line_thickness']) && !empty($mkd_options['title_like_separator_line_thickness'])) {
        $title_shortcode .= ' line_thickness = "' . $mkd_options['title_like_separator_line_thickness'] . '"';
    }

    if (get_post_meta($id, "mkd_title_like_separator_line_style", true) != "") {  
        $title_shortcode .= ' line_border_style = "' .   get_post_meta($id, "mkd_title_like_separator_line_style", true) . '"';
    }
    elseif (isset($mkd_options['title_like_separator_line_style']) && !empty($mkd_options['title_like_separator_line_style'])) {
        $title_shortcode .= ' line_border_style = "' . $mkd_options['title_like_separator_line_style'] . '"';
    }

    if (get_post_meta($id, "mkd_title_like_separator_margins", true) != "") {  
        $title_shortcode .= ' box_margin = "' .   get_post_meta($id, "mkd_title_like_separator_margins", true) . '"';
    }
    elseif (isset($mkd_options['title_like_separator_margins']) && !empty($mkd_options['title_like_separator_margins'])) {
        $title_shortcode .= ' box_margin = "' . $mkd_options['title_like_separator_margins'] . '"';
    }

    $title_like_separator_dots = false;

    if (get_post_meta($id, "mkd_title_like_separator_line_dots", true) != "") {  
        $title_shortcode .= ' line_dots = "' .   get_post_meta($id, "mkd_title_like_separator_line_dots", true) . '"';
        if (get_post_meta($id, "mkd_title_like_separator_line_dots", true) == "yes") {
            $title_like_separator_dots = true;
        }
    }
    elseif (isset($mkd_options['title_like_separator_line_dots']) && !empty($mkd_options['title_like_separator_line_dots'])) {
        $title_shortcode .= ' line_dots = "' . $mkd_options['title_like_separator_line_dots'] . '"';
        if ($mkd_options['title_like_separator_line_dots'] == "yes") {
            $title_like_separator_dots = true;
        }
    }


    if ($title_like_separator_dots) {          
        if (get_post_meta($id,"mkd_title_like_separator_dots_size", true) != "") {  
            $title_shortcode .= ' line_dots_size = "' .   get_post_meta($id,"mkd_title_like_separator_dots_size", true) . '"';
        }
        elseif (isset($mkd_options['title_like_separator_dots_size']) && !empty($mkd_options['title_like_separator_dots_size'])) {
            $title_shortcode .= ' line_dots_size = "' . $mkd_options['title_like_separator_dots_size'] . '"';
        }

        if (get_post_meta($id, "mkd_title_like_separator_dots_color", true) != "") {  
            $title_shortcode .= ' line_dots_color = "' .   get_post_meta($id, "mkd_title_like_separator_dots_color", true) . '"';
        }
        elseif (isset($mkd_options['title_like_separator_dots_color']) && !empty($mkd_options['title_like_separator_dots_color'])) {
            $title_shortcode .= ' line_dots_color = "' . $mkd_options['title_like_separator_dots_color'] . '"';
        }
    }

    $title_span_background_color = "";
    $title_span_background_color_rgb = "";
    $title_span_background_color = "";
    $title_in_box = "";

    if (get_post_meta($id,'mkd_title_background_color',true) != "") {
        $title_span_background_color_rgb = mkd_hex2rgb(esc_attr(get_post_meta($id, 'mkd_title_background_color', true)));
    }

    if (get_post_meta($id,'mkd_title_opacity',true) != "") {
        $title_span_opacity = esc_attr(get_post_meta($id,'mkd_title_opacity',true));
    }
    else {
        $title_span_opacity = 1;
    }

    if (is_array($title_span_background_color_rgb) && count($title_span_background_color_rgb)) {
        $title_span_background_color = ' box_background_color = "rgba(' . $title_span_background_color_rgb[0] .','. $title_span_background_color_rgb[1] .','. $title_span_background_color_rgb[2] .','. $title_span_opacity . ')" ';
    }


    if (get_post_meta($id,'mkd_title_right_padding',true) != "") {
        $title_shortcode .= ' box_padding = "' . esc_attr(get_post_meta($id,'mkd_title_right_padding',true)). 'px" ';
    }

    if ($title_span_background_color !== "") {
        $title_shortcode = '[vc_text_separator text_in_box="yes" box_border_color="transparent" ' . $title_shortcode . $title_span_background_color . ']';
        $title_in_box = "title_in_box";
    }
    else {
        $title_shortcode = '[vc_text_separator text_in_box="no" ' . $title_shortcode . ']';
    }


}

$subtitle_shortcode = "";

$subtitle_like_separator = false;

if (get_post_meta($id,"mkd_subtitle_like_separator",true) == "yes" || (isset($mkd_options['subtitle_like_separator']) && $mkd_options['subtitle_like_separator']=='yes' && get_post_meta($id,"mkd_subtitle_like_separator",true) != "no")) {
    $subtitle_like_separator = true;
}

if ($subtitle_like_separator) {

    $subtitle_shortcode .= 'title = "' . get_post_meta($id, "mkd_page_subtitle", true) . '"';

    if (get_post_meta($id,'mkd_page_title_position',true) != "") {
        $subtitle_shortcode .= ' text_position = "' . get_post_meta($id,'mkd_page_title_position',true) . '"';
    }
    elseif (isset($mkd_options['page_title_position']) && !empty($mkd_options['page_title_position'])) {
        $subtitle_shortcode .= ' text_position = "' . $mkd_options['page_title_position'] . '"';
    }

    if (get_post_meta($id, "mkd_page_subtitle_color", true) != "") {  
        $subtitle_shortcode .= ' title_color = "' . get_post_meta($id, "mkd_page_subtitle_color", true) . '"';
    }

    if (get_post_meta($id, "mkd_subtitle_like_separator_line_color", true) != "") {  
        $subtitle_shortcode .= ' line_color = "' . get_post_meta($id, "mkd_subtitle_like_separator_line_color", true) . '"';
    }
    elseif (isset($mkd_options['subtitle_like_separator_line_color']) && !empty($mkd_options['subtitle_like_separator_line_color'])) {
        $subtitle_shortcode .= ' line_color = "' . $mkd_options['subtitle_like_separator_line_color'] . '"';
    }

    if (get_post_meta($id, "mkd_subtitle_like_separator_line_width", true) != "") {  
        $subtitle_shortcode .= ' line_width = "' .   get_post_meta($id, "mkd_subtitle_like_separator_line_width", true) . '"';
    }
    elseif (isset($mkd_options['subtitle_like_separator_line_width']) && !empty($mkd_options['subtitle_like_separator_line_width'])) {
        $subtitle_shortcode .= ' line_width = "' . $mkd_options['subtitle_like_separator_line_width'] . '"';
    }

    if (get_post_meta($id, "mkd_subtitle_like_separator_line_thickness", true) != "") {  
        $subtitle_shortcode .= ' line_thickness = "' .   get_post_meta($id, "mkd_subtitle_like_separator_line_thickness", true) . '"';
    }
    elseif (isset($mkd_options['subtitle_like_separator_line_thickness']) && !empty($mkd_options['subtitle_like_separator_line_thickness'])) {
        $subtitle_shortcode .= ' line_thickness = "' . $mkd_options['subtitle_like_separator_line_thickness'] . '"';
    }

    if (get_post_meta($id, "mkd_subtitle_like_separator_line_style", true) != "") {  
        $subtitle_shortcode .= ' line_border_style = "' .   get_post_meta($id, "mkd_subtitle_like_separator_line_style", true) . '"';
    }
    elseif (isset($mkd_options['subtitle_like_separator_line_style']) && !empty($mkd_options['subtitle_like_separator_line_style'])) {
        $subtitle_shortcode .= ' line_border_style = "' . $mkd_options['subtitle_like_separator_line_style'] . '"';
    }

    if (get_post_meta($id, "mkd_subtitle_like_separator_margins", true) != "") {  
        $subtitle_shortcode .= ' box_margin = "' .   get_post_meta($id, "mkd_subtitle_like_separator_margins", true) . '"';
    }
    elseif (isset($mkd_options['subtitle_like_separator_margins']) && !empty($mkd_options['subtitle_like_separator_margins'])) {
        $subtitle_shortcode .= ' box_margin = "' . $mkd_options['subtitle_like_separator_margins'] . '" ';
    }

    
    $subtitle_span_background_color = "";
    $subtitle_span_background_color_rgb = "";
    $subtitle_span_background_color = "";
    $subtitle_in_box = "";

    if (get_post_meta($id,'mkd_subtitle_background_color',true) != "") {
        $subtitle_span_background_color_rgb = mkd_hex2rgb(esc_attr(get_post_meta($id, 'mkd_subtitle_background_color', true)));
    }

    if (get_post_meta($id,'mkd_subtitle_opacity',true) != "") {
        $subtitle_span_opacity = esc_attr(get_post_meta($id,'mkd_subtitle_opacity',true));
    }
    else {
        $subtitle_span_opacity = 1;
    }

    if (is_array($subtitle_span_background_color_rgb) && count($subtitle_span_background_color_rgb)) {
        $subtitle_span_background_color = ' box_background_color = "rgba(' . $subtitle_span_background_color_rgb[0] .','. $subtitle_span_background_color_rgb[1] .','. $subtitle_span_background_color_rgb[2] .','. $subtitle_span_opacity . ')" ';
    }

    if (get_post_meta($id,'mkd_subtitle_right_padding',true) != "") {
        $subtitle_shortcode .= ' box_padding = "' . esc_attr(get_post_meta($id,'mkd_subtitle_right_padding',true)). 'px" ';
    }

    if ($subtitle_span_background_color !== "") {
        $subtitle_shortcode = '[vc_text_separator text_in_box="yes" box_border_color="transparent" ' . $subtitle_shortcode . $subtitle_span_background_color . ']';
        $subtitle_in_box = "subtitle_in_box";
    }
    else {
        $subtitle_shortcode = '[vc_text_separator text_in_box="no" ' . $subtitle_shortcode . ']';
    }

}


//Title Separator
$title_separator = "";
$title_separator_style = "";
$separator_title_position = "";
if (get_post_meta($id,'mkd_title_separator',true) == "yes"  || (!empty($mkd_options['title_separator']) && $mkd_options['title_separator']=='yes' && get_post_meta($id,'mkd_title_separator',true) != "no")) {
    $title_separator = "yes";

    $title_separator_position_vertical = "below";
    if (get_post_meta($id,'mkd_title_separator_position',true) == "above") {
        $title_separator_position_vertical = "above";
    }
    elseif (get_post_meta($id,'mkd_title_separator_position',true) == "below") {
        $title_separator_position_vertical = "below";
    }
    elseif (isset($mkd_options['title_separator_position']) && $mkd_options['title_separator_position'] == "above") {
        $title_separator_position_vertical = "above";
    }

    $with_icon = false;

    if (get_post_meta($id,'mkd_title_separator_format',true) == "with_icon" || get_post_meta($id,'mkd_title_separator_format',true) == "with_custom_icon") {
        $with_icon = true;
    }
    elseif (get_post_meta($id,'mkd_title_separator_format',true) == "normal") {
        $with_icon = false;
    }
    elseif ($mkd_options['title_separator_format'] == "with_icon" || $mkd_options['title_separator_format'] == "with_custom_icon") {
        $with_icon = true;
    }


    if ($with_icon) {

        $separator_shortcode_params = '';

        if (get_post_meta($id,'mkd_title_separator_format',true) != "") {
            $separator_shortcode_params .= ' type = "' . get_post_meta($id,'mkd_title_separator_format',true) . '" ';
        }
        else {
            $separator_shortcode_params .= ' type = "' . $mkd_options['title_separator_format'] . '" ';
        }

        if (get_post_meta($id,'mkd_title_separator_format',true) == "with_custom_icon" || (get_post_meta($id,'mkd_title_separator_format',true) == "" && $mkd_options['title_separator_format'] == "with_custom_icon")) {
            if (get_post_meta($id,'mkd_separator_custom_icon',true) != "") {
                $separator_shortcode_params .= ' custom_icon ="' . get_post_meta($id,'mkd_separator_custom_icon',true) . '" ';
            }
            elseif (isset($mkd_options['separator_custom_icon']) && !empty($mkd_options['separator_custom_icon'])) {
                $separator_shortcode_params .= ' custom_icon ="' . $mkd_options['separator_custom_icon'] . '" ';
            }
        }
        else {
            if (get_post_meta($id,'mkd_separator_icon_pack',true) != "") {
                $separator_shortcode_params .= $mkdIconCollections->iconPackParamName.'="'.get_post_meta($id,'mkd_separator_icon_pack',true).'"';

                $icon_collection = $mkdIconCollections->getIconCollection(get_post_meta($id,'mkd_separator_icon_pack',true));

                if(is_object($icon_collection) && get_post_meta($id,'mkd_separator_icon_'.$icon_collection->param,true) !== "") {
                    $separator_shortcode_params .= ' '.$icon_collection->param.'="'.get_post_meta($id,'mkd_separator_icon_'.$icon_collection->param,true).'"';
                }
            }
            elseif (isset($mkd_options['separator_icon_pack']) && !empty($mkd_options['separator_icon_pack'])) {

                $separator_shortcode_params .= $mkdIconCollections->iconPackParamName.'="'.$mkd_options['separator_icon_pack'].'"';

                $icon_collection = $mkdIconCollections->getIconCollection($mkd_options['separator_icon_pack']);

                if(is_object($icon_collection) && isset($mkd_options['separator_icon_'.$icon_collection->param]) && !empty($mkd_options['separator_icon_'.$icon_collection->param])) {
                    $separator_shortcode_params .= ' '.$icon_collection->param.'="'.$mkd_options['separator_icon_'.$icon_collection->param].'"';
                }
            }

            if (get_post_meta($id,'mkd_title_separator_icon_hover_color',true) != "") {
                $separator_shortcode_params .= ' hover_icon_color = "'.get_post_meta($id,'mkd_title_separator_icon_hover_color',true).'"';
            }
            elseif (isset($mkd_options['title_separator_icon_hover_color']) && !empty($mkd_options['title_separator_icon_hover_color'])) {
                $separator_shortcode_params .= ' hover_icon_color = "'.$mkd_options['title_separator_icon_hover_color'].'"';
            }

            if (get_post_meta($id,'mkd_title_separator_icon_color',true) != "") {
                $separator_shortcode_params .= ' icon_color = "'.get_post_meta($id,'mkd_title_separator_icon_color',true).'"';
            }
            elseif (isset($mkd_options['title_separator_icon_color']) && !empty($mkd_options['title_separator_icon_color'])) {
                $separator_shortcode_params .= ' icon_color = "'.$mkd_options['title_separator_icon_color'].'"';
            }

            if (get_post_meta($id,'mkd_title_separator_icon_custom_size',true) != "") {
               $separator_shortcode_params .= ' icon_custom_size = "'.get_post_meta($id,'mkd_title_separator_icon_custom_size',true).'"';
            }
            elseif (isset($mkd_options['title_separator_icon_custom_size']) && !empty($mkd_options['title_separator_icon_custom_size'])) {
                $separator_shortcode_params .= ' icon_custom_size = "'.$mkd_options['title_separator_icon_custom_size'].'"';
            }

            if (get_post_meta($id,'mkd_title_separator_icon_type',true) != "") {
               $separator_shortcode_params .= ' icon_type = "'.get_post_meta($id,'mkd_title_separator_icon_type',true).'"';
               $separator_type = get_post_meta($id,'mkd_title_separator_icon_type',true);
            }
            elseif (isset($mkd_options['title_separator_icon_type']) && !empty($mkd_options['title_separator_icon_type'])) {
                $separator_shortcode_params .= ' icon_type = "'.$mkd_options['title_separator_icon_type'].'"';
                $separator_type = $mkd_options['title_separator_icon_type'];
            }

            if ($separator_type != "normal"){
                if (get_post_meta($id,'mkd_title_separator_icon_border_radius',true) != "") {
                   $separator_shortcode_params .= ' icon_border_radius = "'.get_post_meta($id,'mkd_title_separator_icon_border_radius',true).'"';
                }
                elseif (isset($mkd_options['title_separator_icon_border_radius']) && !empty($mkd_options['title_separator_icon_border_radius'])) {
                    $separator_shortcode_params .= ' icon_border_radius = "'.$mkd_options['title_separator_icon_border_radius'].'"';
                }

                if (get_post_meta($id,'mkd_title_separator_icon_border_width',true) != "") {
                   $separator_shortcode_params .= ' icon_border_width = "'.get_post_meta($id,'mkd_title_separator_icon_border_width',true).'"';
                }
                elseif (isset($mkd_options['title_separator_icon_border_width']) && !empty($mkd_options['title_separator_icon_border_width'])) {
                    $separator_shortcode_params .= ' icon_border_width = "'.$mkd_options['title_separator_icon_border_width'].'"';
                }

                if (get_post_meta($id,'mkd_title_separator_icon_border_color',true) != "") {
                   $separator_shortcode_params .= ' icon_border_color = "'.get_post_meta($id,'mkd_title_separator_icon_border_color',true).'"';
                }
                elseif (isset($mkd_options['title_separator_icon_border_color']) && !empty($mkd_options['title_separator_icon_border_color'])) {
                    $separator_shortcode_params .= ' icon_border_color = "'.$mkd_options['title_separator_icon_border_color'].'"';
                }

                if (get_post_meta($id,'mkd_title_separator_icon_border_hover_color',true) != "") {
                   $separator_shortcode_params .= ' hover_icon_border_color = "'.get_post_meta($id,'mkd_title_separator_icon_border_hover_color',true).'"';
                }
                elseif (isset($mkd_options['title_separator_icon_border_hover_color']) && !empty($mkd_options['title_separator_icon_border_hover_color'])) {
                    $separator_shortcode_params .= ' hover_icon_border_color = "'.$mkd_options['title_separator_icon_border_hover_color'].'"';
                }

                if (get_post_meta($id,'mkd_title_separator_icon_shape_size',true) != "") {
                   $separator_shortcode_params .= ' icon_shape_size = "'.get_post_meta($id,'mkd_title_separator_icon_shape_size',true).'"';
                }
                elseif (isset($mkd_options['title_separator_icon_shape_size']) && !empty($mkd_options['title_separator_icon_shape_size'])) {
                    $separator_shortcode_params .= ' icon_shape_size = "'.$mkd_options['title_separator_icon_shape_size'].'"';
                }

                if (get_post_meta($id,'mkd_title_separator_icon_background_color',true) != "") {
                   $separator_shortcode_params .= ' icon_background_color = "'.get_post_meta($id,'mkd_title_separator_icon_background_color',true).'"';
                }
                elseif (isset($mkd_options['title_separator_icon_background_color']) && !empty($mkd_options['title_separator_icon_background_color'])) {
                    $separator_shortcode_params .= ' icon_background_color = "'.$mkd_options['title_separator_icon_background_color'].'"';
                }

                if (get_post_meta($id,'mkd_title_separator_icon_background_hover_color',true) != "") {
                   $separator_shortcode_params .= ' hover_icon_background_color = "'.get_post_meta($id,'mkd_title_separator_icon_background_hover_color',true).'"';
                }
                elseif (isset($mkd_options['title_separator_icon_background_hover_color']) && !empty($mkd_options['title_separator_icon_background_hover_color'])) {
                    $separator_shortcode_params .= ' hover_icon_background_color = "'.$mkd_options['title_separator_icon_background_hover_color'].'"';
                }
            }
        }

        if (get_post_meta($id,'mkd_title_separator_color',true) != "") {
           $separator_shortcode_params .= ' color = "'.get_post_meta($id,'mkd_title_separator_color',true).'"';
        }
        elseif (isset($mkd_options['title_separator_color']) && !empty($mkd_options['title_separator_color'])) {
            $separator_shortcode_params .= ' color = "'.$mkd_options['title_separator_color'].'"';
        }

        if (get_post_meta($id,'mkd_title_separator_type',true) != "") {
           $separator_shortcode_params .= ' border_style = "'.get_post_meta($id,'mkd_title_separator_type',true).'"';
        }
        elseif (isset($mkd_options['title_separator_type']) && !empty($mkd_options['title_separator_type'])) {
            $separator_shortcode_params .= ' border_style = "'.$mkd_options['title_separator_type'].'"';
        }

        if (get_post_meta($id,'mkd_title_separator_thickness',true) != "") {
           $separator_shortcode_params .= ' thickness = "'.get_post_meta($id,'mkd_title_separator_thickness',true).'"';
        }
        elseif (isset($mkd_options['title_separator_thickness']) && !empty($mkd_options['title_separator_thickness'])) {
            $separator_shortcode_params .= ' thickness = "'.$mkd_options['title_separator_thickness'].'"';
        }

        if (get_post_meta($id,'mkd_title_separator_width',true) != "") {
           $separator_shortcode_params .= ' width = "'.get_post_meta($id,'mkd_title_separator_width',true).'"';
        }
        elseif (isset($mkd_options['title_separator_width']) && !empty($mkd_options['title_separator_width'])) {
            $separator_shortcode_params .= ' width = "'.$mkd_options['title_separator_width'].'"';
        }

        if (get_post_meta($id,'mkd_title_separator_topmargin',true) != "") {
           $separator_shortcode_params .= ' up = "'.get_post_meta($id,'mkd_title_separator_topmargin',true).'"';
        }
        elseif (isset($mkd_options['title_separator_topmargin']) && !empty($mkd_options['title_separator_topmargin'])) {
            $separator_shortcode_params .= ' up = "'.$mkd_options['title_separator_topmargin'].'"';
        }

        if (get_post_meta($id,'mkd_title_separator_bottommargin',true) != "") {
           $separator_shortcode_params .= ' down = "'.get_post_meta($id,'mkd_title_separator_bottommargin',true).'"';
        }
        elseif (isset($mkd_options['title_separator_bottommargin']) && !empty($mkd_options['title_separator_bottommargin'])) {
            $separator_shortcode_params .= ' down = "'.$mkd_options['title_separator_bottommargin'].'"';
        }

        if (get_post_meta($id,'mkd_title_separator_icon_position',true) != "") {
           $separator_shortcode_params .= ' separator_icon_position = "'.get_post_meta($id,'mkd_title_separator_icon_position',true).'"';
        }
        elseif (isset($mkd_options['title_separator_icon_position']) && !empty($mkd_options['title_separator_icon_position'])) {
            $separator_shortcode_params .= ' separator_icon_position = "'.$mkd_options['title_separator_icon_position'].'"';
        }

        if (get_post_meta($id,'mkd_title_separator_icon_margins',true) != "") {
           $separator_shortcode_params .= ' icon_margin = "'.get_post_meta($id,'mkd_title_separator_icon_margins',true).'"';
        }
        elseif (isset($mkd_options['title_separator_icon_margins']) && !empty($mkd_options['title_separator_icon_margins'])) {
            $separator_shortcode_params .= ' icon_margin = "'.$mkd_options['title_separator_icon_margins'].'"';
        }
    }

    else {
		if(get_post_meta($id,'mkd_page_title_position',true) != "") {
			$separator_title_position = get_post_meta($id,'mkd_page_title_position',true);
		}
		elseif(isset($mkd_options['page_title_position']) && !empty($mkd_options['page_title_position'])) {
			$separator_title_position = $mkd_options['page_title_position'];
		}

		$title_separator_style = '';

		if(get_post_meta($id,'mkd_title_separator_color',true) != ""){
			$title_separator_style .= 'border-color:'.esc_attr(get_post_meta($id,'mkd_title_separator_color',true)).';';
		}
		elseif(!empty($mkd_options['title_separator_color'])){
			$title_separator_style .= 'border-color:'.esc_attr($mkd_options['title_separator_color']).';';
		}

		if(get_post_meta($id,'mkd_title_separator_thickness',true) != "") {
			$title_separator_style .= 'border-width: ' . esc_attr(get_post_meta($id,'mkd_title_separator_thickness',true)) . 'px 0 0;';
		}
		elseif(isset($mkd_options['title_separator_thickness']) && !empty($mkd_options['title_separator_thickness'])) {
			$title_separator_style .= 'border-width: ' . esc_attr($mkd_options['title_separator_thickness']) . 'px 0 0;';
		}

		if(get_post_meta($id,'mkd_title_separator_width',true) != "") {
			$title_separator_style .= 'width: ' . esc_attr(get_post_meta($id,'mkd_title_separator_width',true)) . 'px;';
		}
		elseif(isset($mkd_options['title_separator_width']) && !empty($mkd_options['title_separator_width'])) {
			$title_separator_style .= 'width: ' . esc_attr($mkd_options['title_separator_width']) . 'px;';
		}

		if(get_post_meta($id,'mkd_title_separator_topmargin',true) != "") {
			$title_separator_style .= 'margin-top: ' . esc_attr(get_post_meta($id,'mkd_title_separator_topmargin',true)) . 'px;';
		}
		elseif(isset($mkd_options['title_separator_topmargin']) && !empty($mkd_options['title_separator_topmargin'])) {
			$title_separator_style .= 'margin-top: ' . esc_attr($mkd_options['title_separator_topmargin']) . 'px;';
		}

		if(get_post_meta($id,'mkd_title_separator_bottommargin',true) != "") {
			$title_separator_style .= 'margin-bottom: ' . esc_attr(get_post_meta($id,'mkd_title_separator_bottommargin',true)) . 'px;';
		}
		elseif(isset($mkd_options['title_separator_bottommargin']) && !empty($mkd_options['title_separator_bottommargin'])) {
			$title_separator_style .= 'margin-bottom: ' . esc_attr($mkd_options['title_separator_bottommargin']) . 'px;';
		}

		if(get_post_meta($id,'mkd_title_separator_type',true) != "") {
			$title_separator_style .= 'border-style: ' . esc_attr(get_post_meta($id,'mkd_title_separator_type',true)) . ';';
		}
		elseif(isset($mkd_options['title_separator_type']) && !empty($mkd_options['title_separator_type'])) {
			$title_separator_style .= 'border-style: ' . esc_attr($mkd_options['title_separator_type']) . ';';
		}
    }

}

$title_area_content_background_color = "";
$title_area_content_opacity = "";
$title_area_content_background_color_rgb = array();


if (get_post_meta($id,'mkd_title_area_content_background_color',true) != "") {
    $title_area_content_background_color_rgb = mkd_hex2rgb(esc_attr(get_post_meta($id, 'mkd_title_area_content_background_color', true)));
}

if (get_post_meta($id,'mkd_title_area_content_opacity',true) != "") {
        $title_area_content_opacity = esc_attr(get_post_meta($id,'mkd_title_area_content_opacity',true));
}
else {
    $title_area_content_opacity = 1;
}

if (is_array($title_area_content_background_color_rgb) && count($title_area_content_background_color_rgb)) {
    $title_area_content_background_color = 'background-color: rgba(' . $title_area_content_background_color_rgb[0] .','. $title_area_content_background_color_rgb[1] .','. $title_area_content_background_color_rgb[2] .','. $title_area_content_opacity . ');';
}

$title_span_style = "";
$title_span_background_color = "";
$title_span_opacity = "";
$title_span_padding = "";
$title_span_background_color_rgb = array();


if (get_post_meta($id,'mkd_title_background_color',true) != "") {
    $title_span_background_color_rgb = mkd_hex2rgb(esc_attr(get_post_meta($id, 'mkd_title_background_color', true)));
}

if (get_post_meta($id,'mkd_title_opacity',true) != "") {
    $title_span_opacity = esc_attr(get_post_meta($id,'mkd_title_opacity',true));
}
else {
    $title_span_opacity = 1;
}

if (isset($title_span_background_color_rgb) && count($title_span_background_color_rgb)) {
    $title_span_background_color = 'background-color: rgba(' . $title_span_background_color_rgb[0] .','. $title_span_background_color_rgb[1] .','. $title_span_background_color_rgb[2] .','. $title_span_opacity . ');';
}

if (get_post_meta($id,'mkd_title_top_padding',true) != "") {
    $title_span_padding .= 'padding-top: ' . esc_attr(get_post_meta($id,'mkd_title_top_padding',true)). 'px; ';
}
if (get_post_meta($id,'mkd_title_right_padding',true) != "") {
    $title_span_padding .= 'padding-right: ' . esc_attr(get_post_meta($id,'mkd_title_right_padding',true)). 'px; ';
}
if (get_post_meta($id,'mkd_title_bottom_padding',true) != "") {
    $title_span_padding .= 'padding-bottom: ' . esc_attr(get_post_meta($id,'mkd_title_bottom_padding',true)). 'px; ';
}
if (get_post_meta($id,'mkd_title_left_padding',true) != "") {
    $title_span_padding .= 'padding-left: ' . esc_attr(get_post_meta($id,'mkd_title_left_padding',true)). 'px; ';
}

if ($title_span_background_color != "" || $title_span_padding != "") {
    $title_span_style = $title_span_background_color . $title_span_padding;
}

$subtitle_span_style = "";
$subtitle_span_background_color = "";
$subtitle_span_opacity = "";
$subtitle_span_padding = "";
$subtitle_span_background_color_rgb = array();

if (get_post_meta($id,'mkd_subtitle_background_color',true) != "") {
    $subtitle_span_background_color_rgb = mkd_hex2rgb(esc_attr(get_post_meta($id, 'mkd_subtitle_background_color', true)));
}

if (get_post_meta($id,'mkd_subtitle_opacity',true) != "") {
    $subtitle_span_opacity = esc_attr(get_post_meta($id,'mkd_subtitle_opacity',true));
}
else {
    $subtitle_span_opacity = 1;
}

if (is_array($subtitle_span_background_color_rgb) && count($subtitle_span_background_color_rgb)) {
    $subtitle_span_background_color = 'background-color: rgba(' . $subtitle_span_background_color_rgb[0] .','. $subtitle_span_background_color_rgb[1] .','. $subtitle_span_background_color_rgb[2] .','. $subtitle_span_opacity . ');';
}

if (get_post_meta($id,'mkd_subtitle_top_padding',true) != "") {
    $subtitle_span_padding .= 'padding-top: ' . esc_attr(get_post_meta($id,'mkd_subtitle_top_padding',true)). 'px; ';
}
if (get_post_meta($id,'mkd_subtitle_right_padding',true) != "") {
    $subtitle_span_padding .= 'padding-right: ' . esc_attr(get_post_meta($id,'mkd_subtitle_right_padding',true)). 'px; ';
}
if (get_post_meta($id,'mkd_subtitle_bottom_padding',true) != "") {
    $subtitle_span_padding .= 'padding-bottom: ' . esc_attr(get_post_meta($id,'mkd_subtitle_bottom_padding',true)). 'px; ';
}
if (get_post_meta($id,'mkd_subtitle_left_padding',true) != "") {
    $subtitle_span_padding .= 'padding-left: ' . esc_attr(get_post_meta($id,'mkd_subtitle_left_padding',true)). 'px; ';
}

if ($subtitle_span_background_color != "" || $subtitle_span_padding != "") {
    $subtitle_span_style = esc_attr($subtitle_span_background_color . $subtitle_span_padding);
}

//Check if background color should be put on title_subtitle_holder (if there is no title_subtitle_holder_inner)
$title_content_classes = "";
if(!(($responsive_title_image == 'yes' && $show_title_image == true) || ($fixed_title_image == "yes" || $fixed_title_image == "yes_zoom") || ($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "no" && $show_title_image == true))){
    $title_content_classes = "title_content_background";
}


$title_classes = '';

if(get_post_meta($id, "mkd_show_page_title_text", true) == 'no') {
	$title_classes = 'without_title_text';
}
if($is_title_area_visible) { ?>
	<div class="title_outer <?php echo esc_attr($animate_title_class.$title_text_shadow); if($responsive_title_image == 'yes' && $show_title_image == true && $title_image !== ''){ echo ' with_image'; }?>" <?php echo 'data-height="'.esc_attr($title_height).'"'; if($title_height != '' && $animate_title_area == 'area_top_bottom'){ echo ' style="opacity:0; height:0px;"'; } ?>>
		<div class="title <?php mkd_title_classes(); ?>" style="<?php if($responsive_title_image == 'no' && $title_image != "" && $show_title_image == true){ if($title_image_width != ''){ echo 'background-size:'.esc_attr($title_image_width).'px auto;'; } echo 'background-image:url('.esc_url($title_image).');';  } if($title_height != ''){ echo 'height:'.esc_attr($title_height).'px;'; } if($title_background_color != ''){ echo 'background-color:'.esc_attr($title_background_color).';'; } ?>">
			<div class="image <?php if($responsive_title_image == 'yes' && $title_image != "" && $show_title_image == true){ echo "responsive"; }else{ echo "not_responsive"; } ?>"><?php if($title_image != ""){ ?><img src="<?php echo esc_url($title_image); ?>" alt="&nbsp;" /> <?php } ?></div>
			<?php if($title_overlay_image != ""){ ?>
				<div class="title_overlay" style="background-image:url('<?php echo esc_url($title_overlay_image); ?>');"></div>
			<?php } ?>

			<div class="title_holder" <?php if($responsive_title_image != 'yes'){ mkd_inline_style($title_holder_height); } ?>>
				<div class="container clearfix">
					<div class="container_inner clearfix">
						<div class="title_subtitle_holder <?php echo esc_attr($title_content_classes); ?>" <?php if($title_image !== '' && $responsive_title_image == 'yes' && $show_title_image == true){ mkd_inline_style($title_subtitle_padding); } if($title_content_classes !== ""){ mkd_inline_style($title_area_content_background_color); } ?>>
                            <?php if($mkd_options['overlapping_content'] == 'yes') {?><div class="overlapping_content_margin"><?php } ?>
                            <?php if(($responsive_title_image == 'yes' && $show_title_image == true) || ($fixed_title_image == "yes" || $fixed_title_image == "yes_zoom") || ($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "no" && $show_title_image == true)){ ?>
							<div class="title_subtitle_holder_inner title_content_background" <?php mkd_inline_style($title_area_content_background_color); ?>>
							<?php } ?>
								<?php if($title_type != "breadcrumbs_title") { ?>

									<?php if($title_graphics != ""){ ?>
										<div class="title_graphics">
											<img src=<?php echo esc_url($title_graphics); ?> alt="" class="title_graphics_img">
										</div>
									<?php } ?>

									
									
									<?php if($subtitle_position=="above_title"){?>
										<?php if(get_post_meta($id, "mkd_page_subtitle", true) != ""){ 
												if ($subtitle_like_separator){?>
												<span class="subtitle subtitle_like_separator <?php echo esc_attr($subtitle_in_box); ?>" <?php mkd_inline_style($subtitle_color); ?>><span class="span_subtitle_separator" > <?php echo do_shortcode($subtitle_shortcode); // XSS OK ?></span></span>
												<?php }
												else {
											?>
												<span class="subtitle" <?php mkd_inline_style($subtitle_color); ?>><span <?php mkd_inline_style($subtitle_span_style); ?>><?php echo wp_kses_post(get_post_meta($id, "mkd_page_subtitle", true)); ?></span></span>
										<?php }
										} ?>
									<?php } ?>
									
                                    <?php if($title_separator == "yes" && $title_separator_position_vertical == "above"){
                                            if ($with_icon) {?>
                                                <div>
                                                <?php echo do_shortcode('[no_separator_with_icon '. $separator_shortcode_params .' ]'); // XSS OK ?>
                                                </div>
                                            <?php }
                                            else {?>
                                                <span class="separator small <?php echo esc_attr($separator_title_position); ?>" <?php mkd_inline_style($title_separator_style); ?>></span>
                                            <?php } ?>
                                    <?php } ?>
									
									
									
									
                                    <?php if($is_title_text_visible) {
                                            if ($subtitle_position == "next_to_title" && get_post_meta($id, "mkd_page_subtitle", true) != ""){?>
                                                <h1<?php if(get_post_meta($id, "mkd_page-title-color", true)) { ?> style="color:<?php echo esc_attr(get_post_meta($id, "mkd_page-title-color", true)); ?>" <?php } ?>><span <?php mkd_inline_style($title_span_style); ?>><?php echo wp_kses_post($title); ?></span></h1>
                                                <span class="subtitle next_to_title" <?php mkd_inline_style($subtitle_color); ?>><span <?php mkd_inline_style($subtitle_span_style); ?>><?php echo wp_kses_post(get_post_meta($id, "mkd_page_subtitle", true)); ?></span></span>
                                        <?php }
                                            else{
                                                if($title_like_separator){ ?>
                                                    <h1 class="title_like_separator <?php echo esc_attr($title_in_box); ?>" <?php if(get_post_meta($id, "mkd_page-title-color", true)) { ?> style="color:<?php echo esc_attr(get_post_meta($id, "mkd_page-title-color", true)); ?>" <?php } ?>><?php echo do_shortcode($title_shortcode); // XSS OK ?></h1>
                                            <?php }
                                                else {
                                            ?>
										          <h1<?php if(get_post_meta($id, "mkd_page-title-color", true)) { ?> style="color:<?php echo esc_attr(get_post_meta($id, "mkd_page-title-color", true)); ?>" <?php } ?>><span <?php mkd_inline_style($title_span_style); ?>><?php echo wp_kses_post($title); ?></span></h1>
									<?php } }
                                    } ?>

									
									
									
                                    <?php if($title_separator == "yes" && $title_separator_position_vertical == "below"){
                                            if ($with_icon) {?>
                                                <div>
                                                <?php echo do_shortcode('[no_separator_with_icon '. $separator_shortcode_params .' ]'); // XSS OK ?>
                                                </div>
                                            <?php }
                                            else {?>
                                                <span class="separator small <?php echo esc_attr($separator_title_position); ?>" <?php mkd_inline_style($title_separator_style); ?>></span>
                                            <?php } ?>
                                    <?php } ?>

									
								
								<?php if($subtitle_position=="below_title"){?>
									<?php if(get_post_meta($id, "mkd_page_subtitle", true) != ""){ 
                                            if ($subtitle_like_separator){?>
                                            <span class="subtitle subtitle_like_separator <?php echo esc_attr($subtitle_in_box); ?>" <?php mkd_inline_style($subtitle_color); ?>><span class="span_subtitle_separator" > <?php echo do_shortcode($subtitle_shortcode); // XSS OK ?></span></span>
                                            <?php }
                                            else {
                                        ?>
									        <span class="subtitle" <?php mkd_inline_style($subtitle_color); ?>><span <?php mkd_inline_style($subtitle_span_style); ?>><?php echo wp_kses_post(get_post_meta($id, "mkd_page_subtitle", true));  ?></span></span>
									<?php }
                                    } ?>
								<?php } ?>

									<?php if (function_exists('mkd_custom_breadcrumbs') && $enable_breadcrumbs == "yes") { ?>
										<div class="breadcrumb"> <?php mkd_custom_breadcrumbs(); ?></div>
									<?php } ?>

								<?php } else { ?>

									<?php if($subtitle_position=="above_title" && $enable_subtitle_breadcrumbs){?>
										<?php if(get_post_meta($id, "mkd_page_subtitle", true) != ""){ 
												if ($subtitle_like_separator){?>
												<span class="subtitle subtitle_like_separator <?php echo esc_attr($subtitle_in_box); ?>" <?php mkd_inline_style($subtitle_color); ?>><span class="span_subtitle_separator" > <?php echo do_shortcode($subtitle_shortcode); // XSS OK ?></span></span>
												<?php }
												else {
											?>
												<span class="subtitle" <?php mkd_inline_style($subtitle_color); ?>><span <?php mkd_inline_style($subtitle_span_style); ?>><?php echo wp_kses_post(get_post_meta($id, "mkd_page_subtitle", true)); ?></span></span>
										<?php }
										} ?>
									<?php } ?>

                                    <?php if($title_separator == "yes" && $title_separator_position_vertical == "above"){
                                            if ($with_icon) {?>
                                                <div>
                                                <?php echo do_shortcode('[no_separator_with_icon '. $separator_shortcode_params .' ]'); // XSS OK ?>
                                                </div>
                                            <?php }
                                            else {?>
                                                <span class="separator small <?php echo esc_attr($separator_title_position); ?>" <?php mkd_inline_style($title_separator_style); ?> ></span>
                                            <?php } ?>
                                    <?php } ?>

									<div class="breadcrumb breadcrumb_title_type" <?php mkd_inline_style($title_span_style); ?> > <?php mkd_custom_breadcrumbs(); ?></div>
									
									<?php if ($subtitle_position == "next_to_title" && get_post_meta($id, "mkd_page_subtitle", true) != ""){ ?>
										<span class="subtitle next_to_title" <?php mkd_inline_style($subtitle_color); ?>><span <?php mkd_inline_style($subtitle_span_style); ?>><?php echo wp_kses_post(get_post_meta($id, "mkd_page_subtitle", true)); ?></span></span>
									<?php } ?>

                                    <?php if($title_separator == "yes" && $title_separator_position_vertical == "below"){
                                            if ($with_icon) {?>
                                                <div>
                                                <?php echo do_shortcode('[no_separator_with_icon '. $separator_shortcode_params .' ]'); // XSS OK ?>
                                                </div>
                                            <?php }
                                            else {?>
                                                <span class="separator small <?php echo esc_attr($separator_title_position); ?>" <?php mkd_inline_style($title_separator_style); ?> ></span>
                                            <?php } ?>
                                    <?php } ?>

									<?php if($subtitle_position=="below_title" && $enable_subtitle_breadcrumbs){?>
										<?php if(get_post_meta($id, "mkd_page_subtitle", true) != ""){ 
												if ($subtitle_like_separator){?>
												<span class="subtitle subtitle_like_separator <?php echo esc_attr($subtitle_in_box); ?>" <?php mkd_inline_style($subtitle_color); ?>><span class="span_subtitle_separator" > <?php echo do_shortcode($subtitle_shortcode); // XSS OK ?></span></span>
												<?php }
												else {
											?>
												<span class="subtitle" <?php mkd_inline_style($subtitle_color); ?>><span <?php mkd_inline_style($subtitle_span_style); ?>><?php echo wp_kses_post(get_post_meta($id, "mkd_page_subtitle", true)); ?></span></span>
										<?php }
										} ?>
									<?php } ?>

								<?php } ?>
							<?php if(($responsive_title_image == 'yes' && $show_title_image == true)  || ($fixed_title_image == "yes" || $fixed_title_image == "yes_zoom") || ($responsive_title_image == 'no' && $title_image != "" && $fixed_title_image == "no" && $show_title_image == true)){ ?>
							</div>
							<?php } ?>
                                <?php if($mkd_options['overlapping_content'] == 'yes') {?></div><?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>
<?php
	/* Return id for archive pages */
	if(is_category() || is_tag() || is_author()){
		$id = $archive_id;
	}
?>