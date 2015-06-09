<?php

if(!function_exists('mkd_is_responsive_on')) {
    /**
     * Checks whether responsive mode is enabled in theme options
     * @return bool
     */
    function mkd_is_responsive_on() {
        global $mkd_options;

        return isset($mkd_options['responsiveness']) && $mkd_options['responsiveness'] !== 'no';
    }
}

if(!function_exists('mkd_is_seo_enabled')) {
    /**
     * Checks if SEO is enabled in theme options
     * @return bool
     */
    function mkd_is_seo_enabled() {
        global $mkd_options;

        return isset($mkd_options['disable_mkd_seo']) && $mkd_options['disable_mkd_seo'] == 'no';
    }
}