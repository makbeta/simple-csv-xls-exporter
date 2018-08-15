<?php
	/**
	 * (C) 2018 by Kolja Nolte
	 * kolja.nolte@gmail.com
	 * http://www.koljanolte.com
	 *
	 * All information contained herein is,
	 * and remains the property of Kolja Nolte.
	 * The intellectual and technical concepts contained.
	 * Dissemination of this information or reproduction
	 * of this material is strictly forbidden unless prior
	 * written permission is obtained from the author.
	 */

	/** Prevents this file from being called directly */
	if(!function_exists("add_action")) {
		return;
	}

	if(!class_exists('Simple_CSV_Exporter')) {
		/**
		 * Class Simple_CSV_Exporter
		 */
		class Simple_CSV_Exporter {
			/**
			 * Simple_CSV_Exporter constructor.
			 */
			public function __construct() {
				if(isset($_GET['export']) && ($_GET['export'] === 'csv' || $_GET['export'] === 'xls')) {
					add_action('wp_loaded', 'ccsve_export');
				}

				new Simple_CSV_Exporter_Settings();
			}

			public static function activate() {
			}

			public static function deactivate() {
				unregister_setting('wp_ccsve-group', 'ccsve_post_type');
				unregister_setting('wp_ccsve-group', 'ccsve_post_status');
				unregister_setting('wp_ccsve-group', 'ccsve_std_fields');
				unregister_setting('wp_ccsve-group', 'ccsve_tax_terms');
				unregister_setting('wp_ccsve-group', 'ccsve_custom_fields');
				unregister_setting('wp_ccsve-group', 'ccsve_woocommerce_fields');

				delete_option('wp_ccsve-group');
			}
		}
	}