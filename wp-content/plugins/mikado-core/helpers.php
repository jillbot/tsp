<?php

if(!function_exists('mkd_core_version_class')) {
    /**
     * Adds plugins version class to body
     * @param $classes
     * @return array
     */
    function mkd_core_version_class($classes) {
        $classes[] = 'mkd-core-'.MIKADO_CORE_VERSION;

        return $classes;
    }

    add_filter('body_class', 'mkd_core_version_class');
}

if(!function_exists('mkd_core_theme_installed')) {
    /**
     * Checks whether theme is installed or not
     * @return bool
     */
    function mkd_core_theme_installed() {
        return defined('MIKADO_ROOT');
    }
}

if (!function_exists('mkd_core_get_carousel_slider_array')){
    /**
     * Function that returns associative array of carousels,
     * where key is term slug and value is term name
     * @return array
     */
    function mkd_core_get_carousel_slider_array() {
        $carousels_array = array();
        $terms = get_terms('carousels_category');

        if (is_array($terms) && count($terms)) {
            $carousels_array[''] = '';
            foreach ($terms as $term) {
                $carousels_array[$term->slug] = $term->name;
            }
        }

        return $carousels_array;
    }
}

if(!function_exists('mkd_core_get_carousel_slider_array_vc')) {
    /**
     * Function that returns array of carousels formatted for Visual Composer
     *
     * @return array array of carousels where key is term title and value is term slug
     *
     * @see mkd_core_get_carousel_slider_array
     */
    function mkd_core_get_carousel_slider_array_vc() {
        return array_flip(mkd_core_get_carousel_slider_array());
    }
}