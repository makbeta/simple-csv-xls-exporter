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

	function simple_csv_exporter_assets() {
		wp_enqueue_style(
			"simple-csv-exporter-admin",
			SIMPLE_CSV_EXPORTER_PLUGIN_URL . "/styles/admin.css",
			array(),
			SIMPLE_CSV_EXPORTER_VERSION
		);
	}

	add_action("admin_enqueue_scripts", "simple_csv_exporter_assets");

	/**
	 * Adds a link to the settings page onto the plugin page.
	 *
	 * @param $links
	 *
	 * @return array
	 */
	function simple_csv_exporter_plugin_settings_link($links) {
		$link_text = __("Export", TEXTDOMAIN);
		$links[]   = '<a href="tools.php?page=simple_csv_exporter_settings">' . $link_text . '</a>';

		return $links;
	}