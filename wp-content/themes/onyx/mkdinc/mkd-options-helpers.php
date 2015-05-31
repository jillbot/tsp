<?php

if(!function_exists('mkd_get_header_variables')) {
    function mkd_get_header_variables() {
        global $mkd_options;

        $loading_animation = true;
        $loading_image = '';
        $enable_side_area = "yes";
        $enable_popup_menu = "no";
        $popup_menu_animation_style = '';
        $enable_fullscreen_search = "no";
        $fullscreen_search_animation = "fade";
        $enable_vertical_menu = false;
        $header_button_size = '';
        $paspartu_header_alignment = false;
        $header_in_grid = true;
        $header_bottom_class = ' header_in_grid';
        $menu_item_icon_position = "";
        $menu_position = "";
        $centered_logo = false;
        $enable_border_top_bottom_menu = false;
        $menu_dropdown_appearance_class = "";
        $logo_wrapper_style = "";
        $divided_left_menu_padding = "";
        $divided_right_menu_padding = "";
        $display_header_top = "yes";
        $header_top_area_scroll = "no";
        $id = mkd_get_page_id();
        $header_style = "";
        $header_color_transparency_per_page = "";
        $header_color_per_page = "";
        $header_top_color_per_page = "";
        $header_color_transparency_on_scroll = "";
        $header_bottom_border_style = '';
        $header_bottom_appearance = 'fixed';
        $header_transparency = '';
        $vertical_area_background_image = "";
        $vertical_menu_style = '';
        $vertical_area_scroll = " with_scroll";
        $page_vertical_area_background_transparency = "";
        $page_vertical_area_background = "";

        if (isset($mkd_options['loading_animation']) && $mkd_options['loading_animation'] == "off"){
            $loading_animation = false;
        }

        if (isset($mkd_options['loading_image']) && $mkd_options['loading_image'] != ""){
            $loading_image = $mkd_options['loading_image'];
        }


        if (isset($mkd_options['enable_side_area']) && $mkd_options['enable_side_area'] == "no") {
            $enable_side_area = "no";
        }

        if (isset($mkd_options['enable_popup_menu'])){
            if($mkd_options['enable_popup_menu'] == "yes" && has_nav_menu('popup-navigation')) {
                $enable_popup_menu = "yes";
            }

            if (isset($mkd_options['popup_menu_animation_style']) && !empty($mkd_options['popup_menu_animation_style'])) {
                $popup_menu_animation_style = $mkd_options['popup_menu_animation_style'];
            }
        };

        if(isset($mkd_options['enable_search']) && $mkd_options['enable_search'] == "yes" && isset($mkd_options['search_type']) && $mkd_options['search_type'] == "fullscreen_search" ){
            $enable_fullscreen_search="yes";
        }


        if(isset($mkd_options['search_type']) && $mkd_options['search_type'] == "fullscreen_search" && isset($mkd_options['search_animation']) && $mkd_options['search_animation'] !== "" ){
            $fullscreen_search_animation = $mkd_options['search_animation'];
        }

        if(isset($mkd_options['vertical_area']) && $mkd_options['vertical_area'] =='yes'){
            $enable_vertical_menu = true;
        }

        if(isset($mkd_options['header_buttons_size'])){
            $header_button_size = $mkd_options['header_buttons_size'];
        }

        if(isset($mkd_options['paspartu_header_alignment'])
        && $mkd_options['paspartu_header_alignment'] == 'yes'
        && isset($mkd_options['paspartu'])
        && $mkd_options['paspartu'] == 'yes') {
            $paspartu_header_alignment = true;
        }

        if(isset($mkd_options['header_in_grid'])){
            if ($mkd_options['header_in_grid'] == "no" || $paspartu_header_alignment) {
                $header_in_grid = false;
            }

            if($header_in_grid) {
                $header_bottom_class = ' header_in_grid';
            } else {
                $header_bottom_class = ' header_full_width';
            }
        }

        if(isset($mkd_options['menu_item_icon_position'])) {
            $menu_item_icon_position = $mkd_options['menu_item_icon_position'];
        }

        if(isset($mkd_options['menu_position'])) {
            $menu_position = $mkd_options['menu_position'];
        }

        if (isset($mkd_options['center_logo_image'])) {
            if($mkd_options['center_logo_image'] == "yes" && $mkd_options['header_bottom_appearance'] !== "stick_with_left_right_menu") {
                $centered_logo = true;
            }
        }

        if(isset($mkd_options['header_bottom_appearance']) && $mkd_options['header_bottom_appearance'] == "fixed_hiding"){
            $centered_logo = true;
        }

        if (isset($mkd_options['enable_border_top_bottom_menu']) && $mkd_options['enable_border_top_bottom_menu'] == "yes") {
            $enable_border_top_bottom_menu = true;
        }

        if(isset($mkd_options['menu_dropdown_appearance']) && $mkd_options['menu_dropdown_appearance'] != "default"){
            $menu_dropdown_appearance_class = $mkd_options['menu_dropdown_appearance'];
        }

        if(isset($mkd_options['header_bottom_appearance']) && $mkd_options['header_bottom_appearance'] == "stick_with_left_right_menu"){
            $logo_wrapper_style = 'width:'.(esc_attr($mkd_options['logo_width'])/2).'px;';
            $divided_left_menu_padding = 'padding-right:'.(esc_attr($mkd_options['logo_width'])/4).'px;';
            $divided_right_menu_padding = 'padding-left:'.(esc_attr($mkd_options['logo_width'])/4).'px;';
        }
        if($mkd_options['center_logo_image'] == "yes" && $mkd_options['header_bottom_appearance'] == "regular"){
            $logo_wrapper_style = 'height:'.(esc_attr($mkd_options['logo_height'])/2).'px;';
        }

        if(isset($mkd_options['header_bottom_appearance']) && $mkd_options['header_bottom_appearance'] == "fixed_top_header"){
            $logo_wrapper_style = 'height:'.(esc_attr($mkd_options['logo_height'])/2).'px;';
        }

        if(isset($mkd_options['header_top_area'])){
            $display_header_top = $mkd_options['header_top_area'];
        }

        if(isset($mkd_options['header_top_area_scroll'])){
            $header_top_area_scroll = $mkd_options['header_top_area_scroll'];
        }

        if(get_post_meta($id, "mkd_header-style", true) != ""){
            $header_style = get_post_meta($id, "mkd_header-style", true);
        }else if(isset($mkd_options['header_style'])){
            $header_style = $mkd_options['header_style'];
        }

        if($mkd_options['header_background_transparency_initial'] != "") {
            $header_color_transparency_per_page = esc_attr($mkd_options['header_background_transparency_initial']);
        }
        if(get_post_meta($id, "mkd_header_color_transparency_per_page", true) != ""){
            $header_color_transparency_per_page = esc_attr(get_post_meta($id, "mkd_header_color_transparency_per_page", true));
        }

        if(get_post_meta($id, "mkd_header_color_per_page", true) != ""){
            if($header_color_transparency_per_page != ""){
                $header_background_color = mkd_hex2rgb(esc_attr(get_post_meta($id, "mkd_header_color_per_page", true)));
                $header_color_per_page .= "background-color:rgba(" . $header_background_color[0] . ", " . $header_background_color[1] . ", " . $header_background_color[2] . ", " . $header_color_transparency_per_page . ");";
            }else{
                $header_color_per_page .= "background-color:" . esc_attr(get_post_meta($id, "mkd_header_color_per_page", true)) . ";";
            }
        } else if($header_color_transparency_per_page != "" && get_post_meta($id, "mkd_header_color_per_page", true) == ""){
            $header_background_color = $mkd_options['header_background_color'] ? mkd_hex2rgb(esc_attr($mkd_options['header_background_color'])) : mkd_hex2rgb("#ffffff");
            $header_color_per_page .= "background-color:rgba(" . $header_background_color[0] . ", " . $header_background_color[1] . ", " . $header_background_color[2] . ", " . $header_color_transparency_per_page . ");";
        }

        if(isset($mkd_options['header_botom_border_in_grid']) && $mkd_options['header_botom_border_in_grid'] != "yes" && get_post_meta($id, "mkd_header_bottom_border_color", true) != ""){
            $header_color_per_page .= "border-bottom: 1px solid ".esc_attr(get_post_meta($id, "mkd_header_bottom_border_color", true)).";";
        }

        if(get_post_meta($id, "mkd_header_color_per_page", true) != ""){
            if($header_color_transparency_per_page != ""){
                $header_background_color = mkd_hex2rgb(esc_attr(get_post_meta($id, "mkd_header_color_per_page", true)));
                $header_top_color_per_page .= "background-color:rgba(" . esc_attr($header_background_color[0]) . ", " . esc_attr($header_background_color[1]) . ", " . esc_attr($header_background_color[2]) . ", " . esc_attr($header_color_transparency_per_page) . ");";
            }else{
                $header_top_color_per_page .= "background-color:" . esc_attr(get_post_meta($id, "mkd_header_color_per_page", true)) . ";";
            }
        } else if($header_color_transparency_per_page != "" && get_post_meta($id, "mkd_header_color_per_page", true) == ""){
            $header_background_color = $mkd_options['header_top_background_color'] ? mkd_hex2rgb(esc_attr($mkd_options['header_top_background_color'])) : mkd_hex2rgb("#ffffff");
            $header_top_color_per_page .= "background-color:rgba(" . esc_attr($header_background_color[0]) . ", " . esc_attr($header_background_color[1]) . ", " . esc_attr($header_background_color[2]) . ", " . esc_attr($header_color_transparency_per_page) . ");";
        }

        if(isset($mkd_options['header_background_transparency_sticky']) && $mkd_options['header_background_transparency_sticky'] != ""){
            $header_color_transparency_on_scroll = esc_attr($mkd_options['header_background_transparency_sticky']);
        }

        if(isset($mkd_options['header_separator_color']) && $mkd_options['header_separator_color'] != ""){
            $header_separator = mkd_hex2rgb(esc_attr($mkd_options['header_separator_color']));
        }

        if(isset($mkd_options['header_botom_border_in_grid']) && $mkd_options['header_botom_border_in_grid'] == "yes" && get_post_meta($id, "mkd_header_bottom_border_color", true) != ""){
            $header_bottom_border_style = 'border-bottom: 1px solid '.esc_attr(get_post_meta($id, "mkd_header_bottom_border_color", true)).';';
        }

        if(isset($mkd_options['header_bottom_appearance'])){
            $header_bottom_appearance = $mkd_options['header_bottom_appearance'];
        }

        $per_page_header_transparency = esc_attr(get_post_meta($id, 'mkd_header_color_transparency_per_page', true));

        if($per_page_header_transparency !== '' && $per_page_header_transparency !== false) {
            $header_transparency = $per_page_header_transparency;
        } else {
            $header_transparency = esc_attr($mkd_options['header_background_transparency_initial']);
        }

        if(isset($mkd_options['vertical_area_background_image']) && $mkd_options['vertical_area_background_image'] != "" && isset($mkd_options['vertical_area_dropdown_showing']) && $mkd_options['vertical_area_dropdown_showing'] != "side" && get_post_meta($id, "mkd_page_disable_vertical_area_background_image", true) != "yes") {
            $vertical_area_background_image = $mkd_options['vertical_area_background_image'];
        }
        if(get_post_meta($id, "mkd_page_vertical_area_background_image", true) != "" && get_post_meta($id, "mkd_page_disable_vertical_area_background_image", true) != "yes" && isset($mkd_options['vertical_area_dropdown_showing']) && $mkd_options['vertical_area_dropdown_showing'] != "side"){
            $vertical_area_background_image = get_post_meta($id, "mkd_page_vertical_area_background_image", true);
        }

        $vertical_area_dropdown_showing = $mkd_options['vertical_area_dropdown_showing'];

        switch($vertical_area_dropdown_showing){
            case 'hover':
                $vertical_menu_style = "toggle";
                break;
            case 'click':
                $vertical_menu_style = "toggle click";
                break;
            case 'side':
                $vertical_menu_style = "side";
                break;
            case 'to_content':
                $vertical_menu_style = "to_content";
                break;
            default:
                $vertical_menu_style = "toggle";

        }

        if ($vertical_area_dropdown_showing == 'to_content') {
            $vertical_area_scroll = "";
        }

        if(isset($mkd_options['paspartu']) && $mkd_options['paspartu'] == 'yes' && isset($mkd_options['vertical_menu_inside_paspartu']) && $mkd_options['vertical_menu_inside_paspartu'] == 'yes'){
            if($mkd_options['vertical_area_background_transparency'] != "") {
                $page_vertical_area_background_transparency = esc_attr($mkd_options['vertical_area_background_transparency']);
            }
            if(get_post_meta($id, "mkd_page_vertical_area_background_opacity", true) != ""){
                $page_vertical_area_background_transparency = esc_attr(get_post_meta($id, "mkd_page_vertical_area_background_opacity", true));
            }

            if(isset($mkd_options['vertical_area_dropdown_showing']) && $mkd_options['vertical_area_dropdown_showing'] == "side"){
                $page_vertical_area_background_transparency = 1;
            }
        }

        else if(isset($mkd_options['paspartu']) && $mkd_options['paspartu'] == 'no') {
            if($mkd_options['vertical_area_background_transparency'] != "") {
                $page_vertical_area_background_transparency = esc_attr($mkd_options['vertical_area_background_transparency']);
            }
            if(get_post_meta($id, "mkd_page_vertical_area_background_opacity", true) != ""){
                $page_vertical_area_background_transparency = esc_attr(get_post_meta($id, "mkd_page_vertical_area_background_opacity", true));
            }

            if(isset($mkd_options['vertical_area_dropdown_showing']) && $mkd_options['vertical_area_dropdown_showing'] == "side"){
                $page_vertical_area_background_transparency = 1;
            }
        }

        if(get_post_meta($id, "mkd_page_vertical_area_background", true) != ""){
            $page_vertical_area_background =esc_attr(get_post_meta($id, 'mkd_page_vertical_area_background', true));

        }else if(get_post_meta($id, "mkd_page_vertical_area_background", true) == ""){
            $page_vertical_area_background = $mkd_options['vertical_area_background'];
        }

        return array(
            'id' => $id,
            'loading_animation' => $loading_animation,
            'loading_image' => $loading_image,
            'enable_side_area' => $enable_side_area,
            'enable_popup_menu' => $enable_popup_menu,
            'popup_menu_animation_style' => $popup_menu_animation_style,
            'enable_fullscreen_search' => $enable_fullscreen_search,
            'fullscreen_search_animation' => $fullscreen_search_animation,
            'enable_vertical_menu' => $enable_vertical_menu,
            'header_button_size' => $header_button_size,
            'paspartu_header_alignment' => $paspartu_header_alignment,
            'header_in_grid' => $header_in_grid,
            'header_bottom_class' => $header_bottom_class,
            'menu_item_icon_position' => $menu_item_icon_position,
            'menu_position' => $menu_position,
            'centered_logo' => $centered_logo,
            'enable_border_top_bottom_menu' => $enable_border_top_bottom_menu,
            'menu_dropdown_appearance_class' => $menu_dropdown_appearance_class,
            'logo_wrapper_style' => $logo_wrapper_style,
            'divided_left_menu_padding' => $divided_left_menu_padding,
            'divided_right_menu_padding' => $divided_right_menu_padding,
            'display_header_top' => $display_header_top,
            'header_top_area_scroll' => $header_top_area_scroll,
            'header_style' => $header_style,
            'header_color_transparency_per_page' => $header_color_transparency_per_page,
            'header_color_per_page' => $header_color_per_page,
            'header_top_color_per_page' => $header_top_color_per_page,
            'header_color_transparency_on_scroll' => $header_color_transparency_on_scroll,
            'header_bottom_border_style' => $header_bottom_border_style,
            'header_bottom_appearance' => $header_bottom_appearance,
            'header_transparency' => $header_transparency,
            'vertical_area_background_image' => $vertical_area_background_image,
            'vertical_menu_style' => $vertical_menu_style,
            'vertical_area_scroll' => $vertical_area_scroll,
            'page_vertical_area_background_transparency' => $page_vertical_area_background_transparency,
            'page_vertical_area_background' => $page_vertical_area_background
        );
    }
}

if(!function_exists('mkd_get_footer_variables')) {
    function mkd_get_footer_variables() {
        global $mkd_options;

        $id                                 = mkd_get_page_id();
        $footer_border_columns				= 'yes';
        $footer_top_border_color            = '';
        $footer_top_border_in_grid          = '';
        $footer_bottom_border_color         = '';
        $footer_bottom_border_in_grid       = '';
        $footer_bottom_border_bottom_color  = '';
        $footer_classes_array				= array();
        $footer_classes						= '';

        if(isset($mkd_options['footer_border_columns']) && $mkd_options['footer_border_columns'] !== '') {
            $footer_border_columns = $mkd_options['footer_border_columns'];
        }

        if(!empty($mkd_options['footer_top_border_color'])) {
            if (isset($mkd_options['footer_top_border_width']) && $mkd_options['footer_top_border_width'] !== '') {
                $footer_border_height = $mkd_options['footer_top_border_width'];
            } else {
                $footer_border_height = '1';
            }

            $footer_top_border_color = 'height: '.esc_attr($footer_border_height).'px;background-color: '.esc_attr($mkd_options['footer_top_border_color']).';';
        }

        if(isset($mkd_options['footer_top_border_in_grid']) && $mkd_options['footer_top_border_in_grid'] == 'yes') {
            $footer_top_border_in_grid = 'in_grid';
        }

        if(!empty($mkd_options['footer_bottom_border_color'])) {
            if(!empty($mkd_options['footer_bottom_border_width'])) {
                $footer_bottom_border_width = $mkd_options['footer_bottom_border_width'].'px';
            }
            else{
                $footer_bottom_border_width = '1px';
            }

            $footer_bottom_border_color = 'height: '.esc_attr($footer_bottom_border_width).';background-color: '.esc_attr($mkd_options['footer_bottom_border_color']).';';
        }

        if(isset($mkd_options['footer_bottom_border_in_grid']) && $mkd_options['footer_bottom_border_in_grid'] == 'yes') {
            $footer_bottom_border_in_grid = 'in_grid';
        }

        if(!empty($mkd_options['footer_bottom_border_bottom_color'])) {
            if(!empty($mkd_options['footer_bottom_border_bottom_width'])) {
                $footer_bottom_border_bottom_width = $mkd_options['footer_bottom_border_bottom_width'].'px';
            }
            else{
                $footer_bottom_border_bottom_width = '1px';
            }

            $footer_bottom_border_bottom_color = 'height: '.esc_attr($footer_bottom_border_bottom_width).';background-color: '.esc_attr($mkd_options['footer_bottom_border_bottom_color']).';';
        }

        //is uncovering footer option set in theme options?
        if(isset($mkd_options['uncovering_footer']) && $mkd_options['uncovering_footer'] == "yes" && isset($mkd_options['paspartu']) && $mkd_options['paspartu'] == 'no') {
            //add uncovering footer class to array
            $footer_classes_array[] = 'uncover';
        }



        if(get_post_meta($id, "mkd_footer-disable", true) == "yes"){
            $footer_classes_array[] = 'disable_footer';
        }

        if($footer_border_columns == 'yes') {
            $footer_classes_array[] = 'footer_border_columns';
        }

        if(isset($mkd_options['paspartu']) && $mkd_options['paspartu'] == 'yes' && isset($mkd_options['paspartu_footer_alignment']) && $mkd_options['paspartu_footer_alignment'] == 'yes'){
            $footer_classes_array[]= 'paspartu_footer_alignment';
        }

        //is some class added to footer classes array?
        if(is_array($footer_classes_array) && count($footer_classes_array)) {
            //concat all classes and prefix it with class attribute
            $footer_classes = esc_attr(implode(' ', $footer_classes_array));
        }


        return array(
            'footer_border_columns' => $footer_border_columns,
            'footer_top_border_color' => $footer_top_border_color,
            'footer_top_border_in_grid' => $footer_top_border_in_grid,
            'footer_bottom_border_color' => $footer_bottom_border_color,
            'footer_bottom_border_in_grid' => $footer_bottom_border_in_grid,
            'footer_bottom_border_bottom_color' => $footer_bottom_border_bottom_color,
            'footer_classes' => $footer_classes
        );
    }
}