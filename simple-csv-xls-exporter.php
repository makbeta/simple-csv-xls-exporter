<?php
/*
Plugin Name: Simple CSV/XLS Export
Plugin URI: https://wordpress.org/plugins/simple-csv-xls-exporter/
Author: Shambix
Author URI: http://www.shambix.com
Version: 1.1
*/

/*
Forked at https://github.com/Jany-M/simple-csv-xls-exporter
Original author 2013  Ethan Hinson  (email : ethan@bluetent.com)
*/


if(!class_exists('WP_CCSVE'))
{
  class WP_CCSVE
  {
    /**
     * Construct the plugin object
     */
    public function __construct()
    {
          // Initialize Settings
      require_once(sprintf("%s/settings.php", dirname(__FILE__)));
      require_once(sprintf("%s/exporter.php", dirname(__FILE__)));
      add_action('wp_loaded', 'ccsve_export');
      $WP_CCSVE_Settings = new WP_CCSVE_Settings();

        } // END public function __construct

    /**
     * Activate the plugin
     */
    public static function activate()
    {
      // Do nothing
    } // END public static function activate

    /**
     * Deactivate the plugin
     */
    public static function deactivate()
    {

    }
  }
}

if(class_exists('WP_CCSVE'))
{
  // Installation and uninstallation hooks
  register_activation_hook(__FILE__, array('WP_CCSVE', 'activate'));
  register_deactivation_hook(__FILE__, array('WP_CCSVE', 'deactivate'));

  // instantiate the plugin class
  $wp_ccsve = new WP_CCSVE();

    // Add a link to the settings page onto the plugin page
  if(isset($wp_plugin_template))
  {
        // Add the settings link to the plugins page
    function plugin_settings_link($links)  {
      $settings_link = '<a href="options-general.php?page=wp_plugin_template">Settings</a>';
      array_unshift($links, $settings_link);
      return $links;
    }

    $plugin = plugin_basename(__FILE__);
    add_filter("plugin_action_links_$plugin", 'plugin_settings_link');
  }
}
