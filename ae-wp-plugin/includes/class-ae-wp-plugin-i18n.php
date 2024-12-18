<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://americaneagle.com
 * @since      1.0.0
 *
 * @package    Ae_Wp_Plugin
 * @subpackage Ae_Wp_Plugin/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Ae_Wp_Plugin
 * @subpackage Ae_Wp_Plugin/includes
 * @author     Sajid <sajid.manzoor@americaneagle.com>
 */
class Ae_Wp_Plugin_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'ae-wp-plugin',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
