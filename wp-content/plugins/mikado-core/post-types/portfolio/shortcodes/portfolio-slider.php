<?php
namespace MikadoCore\CPT\Portfolio\Shortcodes;

use MikadoCore\Lib;

/**
 * Class PortfolioSlider
 * @package MikadoCore\CPT\Portfolio\Shortcodes
 */
class PortfolioSlider implements Lib\ShortcodeInterface {
    /**
     * @var string
     */
    private $base;

    public function __construct() {
        $this->base = 'no_portfolio_slider';

        add_action('vc_before_init', array($this, 'vcMap'));
    }

    /**
     * Returns base for shortcode
     * @return string
     */
    public function getBase() {
        return $this->base;
    }


    /**
     * Maps shortcode to Visual Composer
     *
     * @see vc_map()
     */
    public function vcMap() {
        if(function_exists('vc_map')) {
            vc_map( array(
                "name" => "Portfolio Slider",
                "base" => $this->base,
                "category" => 'by MIKADO',
                "icon" => "icon-wpb-portfolio-slider extended-custom-icon",
                "allowed_container_element" => 'vc_row',
                "params" => array(
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Portfolio Slider Template",
                        "param_name" => "type",
                        "value" => array(
                            "Text on Image Hover" => "text_on_hover_image",
                            "Standard" => "standard",
                        ),
                        "description" => "",
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Hover Animation Type",
                        "param_name" => "hover_type_text_on_hover_image",
                        "value" => array(
                            "Gradient" => "gradient_hover",
                            "Upward" => "upward_hover",
                            "Opposite Corners" => "opposite_corners_hover",
                            "Slide from left" => "slide_from_left_hover",
                            "Subtle Vertical" => "subtle_vertical_hover",
                            "Image Subtle Rotate Zoom" => "image_subtle_rotate_zoom_hover",
                            "Image Text Zoom" => "image_text_zoom_hover",
                            "Prominent Plain" => "prominent_plain_hover",
                            "Prominent Blur" => "prominent_blur_hover",
                            "Slide Up" => "slide_up_hover"
                        ),
                        "dependency" => array('element' => "type", 'value' => array('text_on_hover_image'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Hover Animation Type",
                        "param_name" => "hover_type_standard",
                        "value" => array(
                            "Gradient" => "gradient_hover",
                            "Upward" => "upward_hover",
                            "Opposite Corners" => "opposite_corners_hover",
                            "Slide from left" => "slide_from_left_hover",
                            "Subtle Vertical" => "subtle_vertical_hover",
                            "Image Subtle Rotate Zoom" => "image_subtle_rotate_zoom_hover",
                            "Image Text Zoom" => "image_text_zoom_hover",
                            "Text Slides With Image" => "text_slides_with_image",
                            "Thin Plus Only" => "thin_plus_only",
                            "Icons Bottom Corner" => "icons_bottom_corner",
                            "Slow Zoom" => "slow_zoom",
                            "Split Up" => "split_up",
                            "Circle" => "circle_hover"
                        ),
                        "dependency" => array('element' => "type", 'value' => array('standard'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Padding between portfolio items",
                        "param_name" => "padding_between",
                        "value" => array(
                            "No" => "no",
                            "Yes" => "yes"
                        ),
                        "description" => ''
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Image Color Overlay",
                        "param_name" => "overlay_background_color",
                        "value" => "",
                        "description" => "Disabled on Upward Hover",
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Cursor Color",
                        "param_name" => "cursor_color_hover_type_text_on_hover_image",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "hover_type_text_on_hover_image", 'value' => array('thin_plus_only'))
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Cursor Color",
                        "param_name" => "cursor_color_hover_type_standard",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "hover_type_standard", 'value' => array('thin_plus_only'))
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Info Box Hover Color",
                        "param_name" => "hover_box_color_standard",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "hover_type_standard", 'value' => array('upward_hover','slide_from_left_hover'))
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Info Box Hover Color",
                        "param_name" => "hover_box_color_text_on_hover_image",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "hover_type_text_on_hover_image", 'value' => array('upward_hover','slide_from_left_hover'))
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Info Box Text Alignment",
                        "param_name" => "text_align",
                        "value" => array(
                            ""   => "",
                            "Left" => "left",
                            "Center" => "center",
                            "Right" => "right"
                        ),
                        "description" => "Note: Info Box, containing Portfolio Title (and Categories), is placed under Portfolio Image",
                        "dependency" => array('element' => 'type', 'value' => array('standard'))
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Info Box Background Color",
                        "param_name" => "box_background_color",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "type", 'value' => array('standard'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Info Box Border",
                        "param_name" => "box_border",
                        "value" => array(
                            "Default" => "",
                            "No" => "no",
                            "Yes" => "yes"
                        ),
                        "description" => "",
                        "dependency" => array('element' => "type", 'value' => array('standard'))
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Info Box Border Width (px)",
                        "param_name" => "box_border_width",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "box_border", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Box Border Color",
                        "param_name" => "box_border_color",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "box_border", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Info Box Padding",
                        "param_name" => "info_box_padding",
                        "value" => "",
                        "description" => "Set padding for info box in format 0px 5px 15px 5px",
                        "dependency" => array('element' => "type", 'value' => array('standard'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Image size",
                        "param_name" => "image_size",
                        "value" => array(
                            "Default" => "",
                            "Original Size" => "full",
                            "Square" => "square",
                            "Landscape" => "landscape",
                            "Portrait" => "portrait"
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Order By",
                        "param_name" => "order_by",
                        "value" => array(
                            "" => "",
                            "Menu Order" => "menu_order",
                            "Title" => "title",
                            "Date" => "date"
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Order",
                        "param_name" => "order",
                        "value" => array(
                            "" => "",
                            "ASC" => "ASC",
                            "DESC" => "DESC",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Number",
                        "param_name" => "number",
                        "value" => "-1",
                        "description" => "Number of portolios on page (-1 is all)"
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Number of Portfolios Shown",
                        "param_name" => "portfolios_shown",
                        "value" => array(
                            "" => "",
                            "3" => "3",
                            "4" => "4",
                            "5" => "5",
                            "6" => "6"
                        ),
                        "description" => "Number of portfolios that are showing at the same time in full width (on smaller screens is responsive so there will be less items shown)",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Category",
                        "param_name" => "category",
                        "value" => "",
                        "description" => "Category Slug (leave empty for all)"
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Enable Icons on Portfolio Image",
                        "param_name" => "show_icons",
                        "value" => array(
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Link Icon",
                        "param_name" => "link_icon",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is Yes",
                        "dependency" => array('element' => "show_icons", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Lightbox Icon",
                        "param_name" => "lightbox",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is Yes",
                        "dependency" => array('element' => "show_icons", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Like Icon",
                        "param_name" => "show_like",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is Yes",
                        "dependency" => array('element' => "show_icons", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Separator",
                        "param_name" => "separator",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "",
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Separator thickness (px)",
                        "param_name" => "separator_thickness",
                        "description" => "",
                        "dependency" => array('element' => "separator", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Separator Color",
                        "param_name" => "separator_color",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "separator", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Animate Separator",
                        "param_name" => "separator_animation",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "",
                        "dependency" => array('element' => "separator", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Show Category Names",
                        "param_name" => "show_categories",
                        "value" => array(
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is Yes",
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Category Name Color",
                        "param_name" => "category_color",
                        "value" => "",
                        "description" => "",
                        "dependency" => array('element' => "show_categories", 'value' => array('yes'))
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Selected Projects",
                        "param_name" => "selected_projects",
                        "value" => "",
                        "description" => "Selected Projects (leave empty for all, delimit by comma)"
                    ),
                    array(
                        "type" => "dropdown",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Disable Portfolio Link",
                        "param_name" => "disable_link",
                        "value" => array(
                            "" => "",
                            "Yes" => "yes",
                            "No" => "no"
                        ),
                        "description" => "Default value is No, but it is always disabled on hover type 'gradient', 'prominent_plain' and 'prominent_blur' (Also disabled on subtle_vertical, image_subtle_rotate_zoom and image_text_zoom if icons are used)"
                    ),
                    array(
                        "type" => "dropdown",
                        "class" => "",
                        "heading" => "Title Tag",
                        "param_name" => "title_tag",
                        "value" => array(
                            ""   => "",
                            "h2" => "h2",
                            "h3" => "h3",
                            "h4" => "h4",
                            "h5" => "h5",
                            "h6" => "h6",
                        ),
                        "description" => ""
                    ),
                    array(
                        "type" => "colorpicker",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Title Color",
                        "param_name" => "title_color",
                        "value" => "",
                        "description" => ""
                    ),
                    array(
                        "type" => "textfield",
                        "holder" => "div",
                        "class" => "",
                        "heading" => "Title Font Size (px)",
                        "param_name" => "title_font_size",
                        "value" => ""
                    ),
                    array(
                        "type" => "checkbox",
                        "class" => "",
                        "heading" => "Prev/Next navigation",
                        "value" => array("Enable prev/next navigation?" => "enable_navigation"),
                        "param_name" => "enable_navigation"
                    )
                )
            ) );
        }
    }

    /**
     * Renders shortcodes HTML
     *
     * @param $atts array of shortcode params
     * @param $content string shortcode content
     * @return string
     */
    public function render($atts, $content = null) {
        global $mkd_options;
        $portfolio_mkd_like = "on";
        if (isset($mkd_options['portfolio_mkd_like'])) {
            $portfolio_mkd_like = $mkd_options['portfolio_mkd_like'];
        }

        $args = array(
            "type" => "text_on_hover_image",
            "hover_type_text_on_hover_image" => "gradient_hover",
            "hover_type_standard" => "gradient_hover",
            "padding_between" => "",
            "overlay_background_color" => "",
            "cursor_color_hover_type_text_on_hover_image" => "",
            "cursor_color_hover_type_standard" => "",
            "hover_box_color_standard" => "",
            "hover_box_color_text_on_hover_image" => "",
            "text_align" => "",
            "info_box_padding" => "",
            "box_border" => "",
            "box_background_color" => "",
            "box_border_color" => "",
            "box_border_width" => "",
            "order_by" => "menu_order",
            "order" => "ASC",
            "number" => "-1",
            "portfolios_shown" => "",
            "category" => "",
            "selected_projects" => "",
            "show_icons" => "yes",
            "link_icon" => "yes",
            "lightbox" => "yes",
            "show_like" => "yes",
            "disable_link" => "no",
            "show_categories" => "yes",
            "category_color" => "",
            "separator" => "",
            "separator_thickness" => "",
            "separator_color" => "",
            "separator_animation" => "",
            "title_tag" => "h5",
            "title_font_size" => "",
            "title_color" => "",
            "image_size" => "portfolio-square",
            "enable_navigation" => ""
        );
        extract(shortcode_atts($args, $atts));


        $overlay_background_color = esc_attr($overlay_background_color);
        $cursor_color_hover_type_text_on_hover_image = esc_attr($cursor_color_hover_type_text_on_hover_image);
        $cursor_color_hover_type_standard = esc_attr($cursor_color_hover_type_standard);
        $hover_box_color_standard = esc_attr($hover_box_color_standard);
        $hover_box_color_text_on_hover_image = esc_attr($hover_box_color_text_on_hover_image);
        $info_box_padding = esc_attr($info_box_padding);
        $box_background_color = esc_attr($box_background_color);
        $box_border_color = esc_attr($box_border_color);
        $box_border_width = esc_attr($box_border_width);
        $number = esc_attr($number);
        $category = esc_attr($category);
        $selected_projects = esc_attr($selected_projects);
        $category_color = esc_attr($category_color);
        $separator_thickness = esc_attr($separator_thickness);
        $separator_color = esc_attr($separator_color);
        $title_font_size = esc_attr($title_font_size);
        $title_color = esc_attr($title_color);


        $headings_array = array('h2', 'h3', 'h4', 'h5', 'h6');

        //get correct heading value. If provided heading isn't valid get the default one
        $title_tag = (in_array($title_tag, $headings_array)) ? $title_tag : $args['title_tag'];

        $html = "";
        $lightbox_slug = 'portfolio_slider_' . rand();
        $data_attribute = "";

        // adding correct classes
        $_type_class = '';
        if ($type == "text_on_hover_image") {
            $_type_class = " hover_text";
        }
        elseif ($type == "standard"){
            $_type_class = " standard";
        }

        if ($portfolios_shown !== "") {
            $data_attribute .= " data-portfolios_shown='" . $portfolios_shown. "'";
        }

        // adding padding class
        $with_padding_class = "";
        if ($padding_between == 'yes') {
            $with_padding_class .= "with_padding";
        }

        // adding hover type
        $hover_type = "";
        if ($type == 'standard') {
            $hover_type = $hover_type_standard;
        }
        if ($type == 'text_on_hover_image') {
            $hover_type = $hover_type_text_on_hover_image;
        }

        // this is used for color on thin_plus_only
        $cursor_color = '';
        if($cursor_color_hover_type_text_on_hover_image != '' && $hover_type == 'thin_plus_only' && $type == 'text_on_hover_image'){
            $cursor_color = 'style="color:'.$cursor_color_hover_type_text_on_hover_image.'"';
        }
        elseif($cursor_color_hover_type_standard != '' && $hover_type == 'thin_plus_only' && $type == 'standard'){
            $cursor_color = 'style="color:'.$cursor_color_hover_type_standard.'"';
        }

        // for this type holder needs to be shown
        if ($hover_type == 'slide_from_left_hover' && $show_icons == 'no') {
            $show_icons = 'yes';
            $link_icon = 'no';
            $lightbox = 'no';
            $show_like = 'no';
        }

        // disable link if icons are shown for these hover type
        if ((($hover_type == 'subtle_vertical_hover' || $hover_type == 'image_subtle_rotate_zoom_hover' || $hover_type == 'image_text_zoom_hover') && $show_icons == 'yes')
            || $hover_type == 'gradient_hover' || $hover_type == 'prominent_plain_hover' || $hover_type == 'prominent_blur_hover') {
            $disable_link = "yes";
        }

        // disable icons on this hover type
        if ($hover_type == 'thin_plus_only' || $hover_type == 'split_up') {
            $show_icons = "no";
        }

        // adding element style and class
        $separator_animation_class = "";
        if ($separator_animation == 'yes') {
            $separator_animation_class = "animate";
        }

        $separator_style = "";
        if ($separator_color != '' || $separator_thickness != '') {
            $separator_style = 'style="';
            if ($separator_color != '') {
                $separator_style .= 'background-color: ' . $separator_color . ';';
            }
            if ($separator_thickness != '') {
                $valid_height = (strstr($separator_thickness, 'px', true)) ? $separator_thickness : $separator_thickness . "px";
                $separator_style .= 'height: ' . $valid_height . ';';
            }
            $separator_style .= '"';
        }


        $portfolio_shader_style = "";
        if ($overlay_background_color != '') {
            if ($hover_type == "gradient_hover") {
                if (substr($overlay_background_color, 0, 3) === "rgba") { // if rgba is set, portfolio uses default color
                    $portfolio_shader_style = '';
                } else {

                    $rgb = mkd_hex2rgb($overlay_background_color);

                    $opacity = 0;
                    $overlay_background_color1 = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';
                    $opacity = 0.9;
                    $overlay_background_color2 = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';

                    $portfolio_shader_style = 'style="background: -webkit-linear-gradient(to bottom, ' . $overlay_background_color1 . ' 10%, ' . $overlay_background_color2 . ' 100%);';
                    $portfolio_shader_style .= 'background: linear-gradient(to bottom, ' . $overlay_background_color1 . ' 10%, ' . $overlay_background_color2 . ' 100%);"';
                }
            } elseif ($hover_type == "upward_hover") {
                // disabled
            } else {
                $portfolio_shader_style = 'style="background-color:' . $overlay_background_color . ';"';
            }
        }

        $title_style = '';
        $title_link_style = ''; // with or without 'a' tag
        if ($title_font_size != "" || $title_color != "") {
            $title_link_style .= 'style="';
            $title_style .= 'style="';
            if ($title_font_size != "") {
                $title_style .= 'font-size: ' . $title_font_size . 'px;';
                $title_link_style .= 'font-size: inherit;';
            }
            if ($title_color != "") {
                $title_style .= 'color: ' . $title_color . ';';
                $title_link_style .= 'color: inherit;';
            }
            $title_style .= '"';
            $title_link_style .= '"';
        }

        $category_style = '';
        if ($category_color != '') {
            $category_style = 'style="color: ' . $category_color . ';"';
        }

        // marging same option for 2 different type
        $hover_box_style = "";
        if ($hover_type == 'upward_hover' || $hover_type == 'slide_from_left_hover') {
            if (($type == 'standard') && $hover_box_color_standard != '') {
                $hover_box_style = 'style="background-color:' . $hover_box_color_standard . ';"';
            } elseif (($type == 'text_on_hover_image') && $hover_box_color_text_on_hover_image != '') {
                $hover_box_style = 'style="background-color:' . $hover_box_color_text_on_hover_image . ';"';
            }
        }

        // adding info box style and class for 'standard'
        $portfolio_box_style = array();
        $portfolio_description_class = "";
        if (($box_border == "yes" || $box_background_color != "" || $info_box_padding != "") &&$type == 'standard') {

            if ($box_border == "yes") {
                $portfolio_box_style[]= "border-style:solid";
                if ($box_border_color != "") {
                    $portfolio_box_style[]= "border-color:" . $box_border_color;
                }
                if ($box_border_width != "") {
                    $box_border_width = (strstr($box_border_width, 'px', true)) ? $box_border_width : $box_border_width . "px";
                    $portfolio_box_style[]= "border-width:" . $box_border_width;
                } else {
                    $portfolio_box_style[]= "border-width: 1px";
                }
            }
            if ($box_background_color != "") {
                $portfolio_box_style[]= "background-color:" . $box_background_color;
            }

            if ($info_box_padding !== ""){
                $portfolio_box_style[] = "padding: ".$info_box_padding;
            }

            $portfolio_description_class .= ' with_padding';

        }

        if ($text_align !== '') {
            $portfolio_description_class .= ' text_align_' . $text_align;
        }

        //get proper image size
        switch ($image_size) {
            case 'landscape':
                $thumb_size = 'portfolio-landscape';
                break;
            case 'portrait':
                $thumb_size = 'portfolio-portrait';
                break;
            case 'square':
                $thumb_size = 'portfolio-square';
                break;
            case 'full':
                $thumb_size = 'full';
                break;
            default:
                $thumb_size = 'full';
                break;
        }

        $html .= "<div class='portfolio_main_holder portfolio_slider_holder clearfix ".$_type_class."'><div class='portfolio_slider ".$with_padding_class."'" . $data_attribute . "><ul class='portfolio_slides'>";

        if ($category == "") {
            $q = array(
                'post_type' => 'portfolio_page',
                'orderby' => $order_by,
                'order' => $order,
                'posts_per_page' => $number
            );
        } else {
            $q = array(
                'post_type' => 'portfolio_page',
                'portfolio_category' => $category,
                'orderby' => $order_by,
                'order' => $order,
                'posts_per_page' => $number
            );
        }

        $project_ids = null;
        if ($selected_projects != "") {
            $project_ids = explode(",", $selected_projects);
            $q['post__in'] = $project_ids;
        }

        query_posts($q);

        if (have_posts()) : $postCount = 0;
            while (have_posts()) : the_post();

                $title = get_the_title();
                $terms = wp_get_post_terms(get_the_ID(), 'portfolio_category');

                $overlay_background_color_custom = $overlay_background_color;
                $portfolio_shader_style_custom = $portfolio_shader_style;
                // If Portfolio Single have chosen Image Overlay color for custom field
                if (get_post_meta(get_the_ID(), 'mkd_portfolio-hover-color', true) != "") {
                    $overlay_background_color_custom =  esc_attr(get_post_meta(get_the_ID(), "mkd_portfolio-hover-color", true));
                    $portfolio_shader_style_custom = "";
                    if ($overlay_background_color_custom != '') {
                        if ($hover_type == "gradient_hover") {
                            if (substr($overlay_background_color_custom, 0, 3) === "rgba") { // if rgba is set, portfolio uses default color
                                $portfolio_shader_style_custom = '';
                            } else {

                                $rgb = mkd_hex2rgb($overlay_background_color_custom);

                                $opacity = 0;
                                $overlay_background_color1 = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';
                                $opacity = 0.9;
                                $overlay_background_color2 = 'rgba(' . $rgb[0] . ',' . $rgb[1] . ',' . $rgb[2] . ',' . $opacity . ')';

                                $portfolio_shader_style_custom = 'style="background: -webkit-linear-gradient(to bottom, ' . $overlay_background_color1 . ' 10%, ' . $overlay_background_color2 . ' 100%);';
                                $portfolio_shader_style_custom .= 'background: linear-gradient(to bottom, ' . $overlay_background_color1 . ' 10%, ' . $overlay_background_color2 . ' 100%);"';
                            }
                        } elseif ($hover_type == "upward_hover") {
                            // disabled
                        } else {
                            $portfolio_shader_style_custom = 'style="background-color:' . $overlay_background_color_custom . ';"';
                        }
                    }
                }

                $featured_image_array = wp_get_attachment_image_src(get_post_thumbnail_id(), $thumb_size);

                if (get_post_meta(get_the_ID(), 'mkd_portfolio-lightbox-link', true) != "") {
                    $large_image = get_post_meta(get_the_ID(), 'mkd_portfolio-lightbox-link', true);
                } else {
                    $large_image = $featured_image_array[0];
                }

                $slug_list_ = "pretty_photo_gallery";

                $custom_portfolio_link = get_post_meta(get_the_ID(), 'mkd_portfolio-external-link', true);
                $portfolio_link = $custom_portfolio_link != "" ? $custom_portfolio_link : get_permalink();
                $target = $custom_portfolio_link != "" ? '_blank' : '_self';

                // get categories for specific article
                $category_html = "";
                $category_html .= '<span>' . __('In ', 'mkd_core') . '</span>';
                $k = 1;
                foreach ($terms as $term) {
                    $category_html .= "$term->name";
                    if (count($terms) != $k) {
                        $category_html .= ' / ';
                    }
                    $k++;
                }

                $html .= "<li class='item'>";
                $html .= '<div class="item_holder ' . $hover_type . '">';

                switch ($hover_type) {
                    case 'gradient_hover':
                    case 'upward_hover':
                    case 'subtle_vertical_hover':
                    case 'image_subtle_rotate_zoom_hover':
                    case 'slide_up_hover':
                    case 'image_text_zoom_hover':
                    case 'text_slides_with_image':
                    case 'thin_plus_only':
                    case 'circle_hover': {
                        $html .= '<div class="text_holder" ' . $hover_box_style . '>';
                        $html .= '<div class="text_holder_outer">';
                        $html .= '<div class="text_holder_inner">';
                        if ($hover_type == 'thin_plus_only') {
                            $html .= '<span class="thin_plus_only_icon" ' . $cursor_color . '>+</span>';
                        } elseif ($type == 'text_on_hover_image') {
                            if ($disable_link != "yes") {
                                $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '><a href="' . $portfolio_link . '" ' . $title_link_style . '>' . get_the_title() . '</a></' . $title_tag . '>';
                            } else {
                                $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '>' . get_the_title() . '</' . $title_tag . '>';
                            }
                            if ($separator == 'yes') {
                                $html .= '<span class="separator ' . $separator_animation_class . '" ' . $separator_style . '></span>';
                            }
                            if ($show_categories == 'yes') {
                                $html .= '<span class="project_category" ' . $category_style . '>' . $category_html . '</span>';
                            }
                        }
                        if ($show_icons == 'yes') {
                            $html .= '<div class="icons_holder">';
                            if ($lightbox == "yes") {
                                $html .= '<a class="portfolio_lightbox" title="' . $title . '" href="' . $large_image . '" data-rel="prettyPhoto[' . $slug_list_ . ']" rel="prettyPhoto[' . $slug_list_ . ']"></a>';
                            }
                            if ($portfolio_mkd_like == "on" && $show_like == "yes") {
                                if (function_exists('mkd_like_portfolio_list')) {
                                    $html .= mkd_like_portfolio_list(get_the_ID());
                                }
                            }
                            if ($link_icon == "yes") {
                                $html .= '<a class="preview" title="Go to Project" href="' . $portfolio_link . '" data-type="portfolio_list" target="' . $target . '" ></a>';
                            }
                            $html .= '</div>'; // icons_holder
                        }

                        $html .= '</div>'; // text_holder_inner
                        $html .= '</div>';  // text_holder_outer
                        $html .= '</div>'; // text_holder
                    }
                        break;
                    case 'opposite_corners_hover':
                    case 'slide_from_left_hover':
                    case 'prominent_plain_hover':
                    case 'prominent_blur_hover':
                    case 'icons_bottom_corner':
                    case 'slow_zoom':
                    case 'split_up': {
                        if ($type == 'text_on_hover_image') {
                            $html .= '<div class="text_holder">';
                            $html .= '<div class="text_holder_outer">';
                            $html .= '<div class="text_holder_inner">';
                            if ($disable_link != "yes") {
                                $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '><a href="' . $portfolio_link . '" ' . $title_link_style . '>' . get_the_title() . '</a></' . $title_tag . '>';
                            } else {
                                $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '>' . get_the_title() . '</' . $title_tag . '>';
                            }
                            if ($separator == 'yes') {
                                $html .= '<span class="separator ' . $separator_animation_class . '" ' . $separator_style . '></span>';
                            }
                            if ($show_categories == 'yes') {
                                $html .= '<span class="project_category" ' . $category_style . '>' . $category_html . '</span>';
                            }
                            $html .= '</div>'; //text_holder_inner
                            $html .= '</div>';  // text_holder_outer
                            $html .= '</div>'; // text_holder
                        }
                        if ($show_icons == 'yes') {
                            $html .= '<div class="icons_holder" ' . $hover_box_style . '>';
                            if ($lightbox == "yes") {
                                $html .= '<a class="portfolio_lightbox" title="' . $title . '" href="' . $large_image . '" data-rel="prettyPhoto[' . $slug_list_ . ']" rel="prettyPhoto[' . $slug_list_ . ']"></a>';
                            }
                            if ($portfolio_mkd_like == "on" && $show_like == "yes") {
                                if (function_exists('mkd_like_portfolio_list')) {
                                    $html .= mkd_like_portfolio_list(get_the_ID());
                                }
                            }
                            if ($link_icon == "yes") {
                                $html .= '<a class="preview" title="Go to Project" href="' . $portfolio_link . '" data-type="portfolio_list" target="' . $target . '" ></a>';
                            }
                            $html .= '</div>';  // icons_holder
                        }
                    }
                        break;
                }

                $html .= '<div class="portfolio_shader" ' . $portfolio_shader_style_custom . '></div>';
                $html .= '<div class="image_holder">';
                $html .= '<span class="image">';
                $html .= get_the_post_thumbnail(get_the_ID(), $thumb_size);
                $html .= '</span>';
                $html .= '</div>'; // close image_holder
                $html .= '</div>'; // close item_holder

                // portfolio description start

                if ($type == "standard") {
                    $html .= "<div class='portfolio_description " . $portfolio_description_class . "' ".mkd_get_inline_style(implode('; ', $portfolio_box_style)).">";

                    $html .= '<' . $title_tag . ' class="portfolio_title" ' . $title_style . '><a href="' . $portfolio_link . '" target="' . $target . '" ' . $title_link_style . '>' . get_the_title() . '</a></' . $title_tag . '>';
                    if ($separator == 'yes') {
                        $html .= '<span class="separator ' . $separator_animation_class . '" ' . $separator_style . '></span>';
                    }
                    if ($show_categories != 'no') {
                        $html .= '<span class="project_category" ' . $category_style . '>' . $category_html . '</span>';
                    }

                    $html .= '</div>'; // close portfolio_description
                }


                $html .= "</li>";

                $postCount++;

            endwhile;

        else:
            $html .= __('Sorry, no posts matched your criteria.', 'mkd_core');
        endif;

        wp_reset_query();

        $html .= "</ul>";
        if ($enable_navigation) {

            $icon_navigation_class = 'arrow_carrot-';
            if (isset($mkd_options['carousel_navigation_arrows_type']) && $mkd_options['carousel_navigation_arrows_type'] != '') {
                $icon_navigation_class = $mkd_options['carousel_navigation_arrows_type'];
            }

            $direction_nav_classes = mkd_horizontal_slider_icon_classes($icon_navigation_class);
            $random_number = rand();

            $html .= '<ul class="caroufredsel-direction-nav"><li><a id="caroufredsel-prev-'.$random_number.'" class="caroufredsel-prev" href="#"><span class="' .$direction_nav_classes['left_icon_class']. '"></span></a></li><li><a class="caroufredsel-next" id="caroufredsel-next-'.$random_number.'" href="#"><span class="' .$direction_nav_classes['right_icon_class']. '"></span></a></li></ul>';
        }
        $html .= "</div></div>";

        return $html;
    }
}