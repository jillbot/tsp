<?php
if (!function_exists ('add_action')) {
    header('Status: 403 Forbidden');
    header('HTTP/1.1 403 Forbidden');
    exit();
}
class Mikado_Import {

    public $message = "";
    public $attachments = false;
    function Mikado_Import() {
        add_action('admin_menu', array(&$this, 'mkd_admin_import'));
        add_action('admin_init', array(&$this, 'mkd_register_theme_settings'));

    }
    function mkd_register_theme_settings() {
        register_setting( 'mkd_options_import_page', 'mkd_options_import');
    }

    function init_mkd_import() {
        if(isset($_REQUEST['import_option'])) {
            $import_option = $_REQUEST['import_option'];
            if($import_option == 'content'){
                $this->import_content('proya_content.xml');
            }elseif($import_option == 'custom_sidebars') {
                $this->import_custom_sidebars('custom_sidebars.txt');
            } elseif($import_option == 'widgets') {
                $this->import_widgets('widgets.txt','custom_sidebars.txt');
            } elseif($import_option == 'options'){
                $this->import_options('options.txt');
            }elseif($import_option == 'menus'){
                $this->import_menus('menus.txt');
            }elseif($import_option == 'settingpages'){
                $this->import_settings_pages('settingpages.txt');
            }elseif($import_option == 'complete_content'){
                $this->import_content('proya_content.xml');
                $this->import_options('options.txt');
                $this->import_widgets('widgets.txt','custom_sidebars.txt');
                $this->import_menus('menus.txt');
                $this->import_settings_pages('settingpages.txt');
                $this->message = __("Content imported successfully", "mkd");
            }
        }
    }

    public function import_content($file){
        if (!class_exists('WP_Importer')) {
            ob_start();
            $class_wp_importer = ABSPATH . 'wp-admin/includes/class-wp-importer.php';
            require_once($class_wp_importer);
            require_once(get_template_directory() . '/mkdinc/import/class.wordpress-importer.php');
            $mkd_import = new WP_Import();
            set_time_limit(0);
            $path = get_template_directory() . '/mkdinc/import/files/' . $file;

            $mkd_import->fetch_attachments = $this->attachments;
            $returned_value = $mkd_import->import($file);
            if(is_wp_error($returned_value)){
                $this->message = __("An Error Occurred During Import", "mkd");
            }
            else {
                $this->message = __("Content imported successfully", "mkd");
            }
            ob_get_clean();
        } else {
            $this->message = __("Error loading files", "mkd");
        }
    }

    public function import_widgets($file, $file2){
        $this->import_custom_sidebars($file2);
        $options = $this->file_options($file);
        foreach ((array) $options['widgets'] as $mkd_widget_id => $mkd_widget_data) {
            update_option( 'widget_' . $mkd_widget_id, $mkd_widget_data );
        }
        $this->import_sidebars_widgets($file);
        $this->message = __("Widgets imported successfully", "mkd");
    }

    public function import_sidebars_widgets($file){
        $mkd_sidebars = get_option("sidebars_widgets");
        unset($mkd_sidebars['array_version']);
        $data = $this->file_options($file);
        if ( is_array($data['sidebars']) ) {
            $mkd_sidebars = array_merge( (array) $mkd_sidebars, (array) $data['sidebars'] );
            unset($mkd_sidebars['wp_inactive_widgets']);
            $mkd_sidebars = array_merge(array('wp_inactive_widgets' => array()), $mkd_sidebars);
            $mkd_sidebars['array_version'] = 2;
            wp_set_sidebars_widgets($mkd_sidebars);
        }
    }

    public function import_custom_sidebars($file){
        $options = $this->file_options($file);
        update_option( 'mkd_sidebars', $options);
        $this->message = __("Custom sidebars imported successfully", "mkd");
    }

    public function import_options($file){
        $options = $this->file_options($file);
        update_option( 'mkd_options_onyx', $options);
        $this->message = __("Options imported successfully", "mkd");
    }

    public function import_menus($file){
        global $wpdb;
        $mkd_terms_table = $wpdb->prefix . "terms";
        $this->menus_data = $this->file_options($file);
        $menu_array = array();
        foreach ($this->menus_data as $registered_menu => $menu_slug) {
            $term_rows = $wpdb->get_results($wpdb->prepare("SELECT * FROM $mkd_terms_table where slug=%s", $menu_slug), ARRAY_A);
            if(isset($term_rows[0]['term_id'])) {
                $term_id_by_slug = $term_rows[0]['term_id'];
            } else {
                $term_id_by_slug = null;
            }
            $menu_array[$registered_menu] = $term_id_by_slug;
        }
        set_theme_mod('nav_menu_locations', array_map('absint', $menu_array ) );

    }
    public function import_settings_pages($file){
        $pages = $this->file_options($file);
        foreach($pages as $mkd_page_option => $mkd_page_id){
            update_option( $mkd_page_option, $mkd_page_id);
        }
    }

    public function file_options($file){
        $file_content = "";
        $file_for_import = get_template_directory() . '/mkdinc/import/files/' . $file;
        /*if ( file_exists($file_for_import) ) {
            $file_content = $this->mkd_file_contents($file_for_import);
        } else {
            $this->message = __("File doesn't exist", "mkd");
        }*/
        $file_content = $this->mkd_file_contents($file);
        if ($file_content) {
            $unserialized_content = unserialize(base64_decode($file_content));
            if ($unserialized_content) {
                return $unserialized_content;
            }
        }
        return false;
    }

    function mkd_file_contents( $path ) {
		$url      = "http://export.mikado-themes.com/".$path;
		$response = wp_remote_get($url);
		$body     = wp_remote_retrieve_body($response);
		return $body;
    }

    function mkd_admin_import() {
        global $mkdFramework;

		$slug = "_tabimport";
		$this->pagehook = add_submenu_page(
			'mkd_theme_menu',
			'Mikado Options - Mikado Import',                   // The value used to populate the browser's title bar when the menu page is active
			'Import',                   // The text of the menu in the administrator's sidebar
			'administrator',                  // What roles are able to access the menu
			'mkd_theme_menu'.$slug,                // The ID used to bind submenu items to this menu
			array($mkdFramework->getSkin(), 'renderImport')
		);

        add_action('admin_print_scripts-'.$this->pagehook, 'mkd_enqueue_admin_scripts');
        add_action('admin_print_styles-'.$this->pagehook, 'mkd_enqueue_admin_styles');
        //$this->pagehook = add_menu_page('Mikado Import', 'Mikado Import', 'manage_options', 'mkd_options_import_page', array(&$this, 'mkd_generate_import_page'),'dashicons-download');
    }

}
global $mkd_import_object;
$mkd_import_object = new Mikado_Import();



if(!function_exists('mkd_dataImport')){
    function mkd_dataImport(){
        global $mkd_import_object;

        if ($_POST['import_attachments'] == 1)
            $mkd_import_object->attachments = true;
        else
            $mkd_import_object->attachments = false;

        $folder = "onyx1/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        $mkd_import_object->import_content($folder.$_POST['xml']);

        die();
    }

    add_action('wp_ajax_mkd_dataImport', 'mkd_dataImport');
}

if(!function_exists('mkd_widgetsImport')){
    function mkd_widgetsImport(){
        global $mkd_import_object;

        $folder = "onyx1/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        $mkd_import_object->import_widgets($folder.'widgets.txt',$folder.'custom_sidebars.txt');

        die();
    }

    add_action('wp_ajax_mkd_widgetsImport', 'mkd_widgetsImport');
}

if(!function_exists('mkd_optionsImport')){
    function mkd_optionsImport(){
        global $mkd_import_object;

        $folder = "onyx1/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        $mkd_import_object->import_options($folder.'options.txt');

        die();
    }

    add_action('wp_ajax_mkd_optionsImport', 'mkd_optionsImport');
}

if(!function_exists('mkd_otherImport')){
    function mkd_otherImport(){
        global $mkd_import_object;

        $folder = "onyx1/";
        if (!empty($_POST['example']))
            $folder = $_POST['example']."/";

        $mkd_import_object->import_options($folder.'options.txt');
        $mkd_import_object->import_widgets($folder.'widgets.txt',$folder.'custom_sidebars.txt');
        $mkd_import_object->import_menus($folder.'menus.txt');
        $mkd_import_object->import_settings_pages($folder.'settingpages.txt');

        die();
    }

    add_action('wp_ajax_mkd_otherImport', 'mkd_otherImport');
}