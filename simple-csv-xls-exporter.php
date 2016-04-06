<?php
/*
Plugin Name: Simple CSV/XLS Export
Plugin URI: https://wordpress.org/plugins/simple-csv-xls-exporter/
Description: Export posts to CSV or XLS, through a simple link/button, from backend or frontend. Supports custom post types, taxonomies and fields.
Author: Shambix
Author URI: http://www.shambix.com
Version: 1.3
*/

/*
Forked at https://github.com/Jany-M/simple-csv-xls-exporter
Original author 2013  Ethan Hinson  (email : ethan@bluetent.com)
*/

define('SIMPLE_CSV_EXPORTER_VERSION', '1.3');

if(!class_exists('SIMPLE_CSV_EXPORTER')) {
    class SIMPLE_CSV_EXPORTER {

        public function __construct()   {
            require_once(sprintf("%s/settings.php", dirname(__FILE__)));
            require_once(sprintf("%s/exporter.php", dirname(__FILE__)));
            add_action('wp_loaded', 'ccsve_export');
            $SIMPLE_CSV_EXPORTER_SETTINGS = new SIMPLE_CSV_EXPORTER_SETTINGS();
        }

        public static function activate() { } 

        public static function deactivate() { }

    }
}

if(class_exists('SIMPLE_CSV_EXPORTER')) {

    register_activation_hook(__FILE__, array('SIMPLE_CSV_EXPORTER', 'activate'));
    register_deactivation_hook(__FILE__, array('SIMPLE_CSV_EXPORTER', 'deactivate'));

    $SIMPLE_CSV_EXPORTER = new SIMPLE_CSV_EXPORTER();

    // Add a link to the settings page onto the plugin page

        function plugin_settings_link($links)  {
            $links[] = '<a href="tools.php?page=simple_csv_exporter_settings">Export</a>';
            return $links;
        }

        add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'plugin_settings_link');

}
