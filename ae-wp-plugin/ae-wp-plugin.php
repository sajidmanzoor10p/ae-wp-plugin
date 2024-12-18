<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://americaneagle.com
 * @since             1.0.0
 * @package           Ae_Wp_Plugin
 *
 * @wordpress-plugin
 * Plugin Name:       AE WP Plugin
 * Plugin URI:        //https://github.com/sajidmanzoor10p/ae-wp-plugin
 * Description:       American Eagle Self Hosted Plugin for Updates testing
 * Version:           1.1.2
 * Author:            Sajid
 * Author URI:        https://americaneagle.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ae-wp-plugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'AE_WP_PLUGIN_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ae-wp-plugin-activator.php
 */
function activate_ae_wp_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ae-wp-plugin-activator.php';
	Ae_Wp_Plugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ae-wp-plugin-deactivator.php
 */
function deactivate_ae_wp_plugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ae-wp-plugin-deactivator.php';
	Ae_Wp_Plugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ae_wp_plugin' );
register_deactivation_hook( __FILE__, 'deactivate_ae_wp_plugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ae-wp-plugin.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ae_wp_plugin() {

	$plugin = new Ae_Wp_Plugin();
	$plugin->run();

}
run_ae_wp_plugin();


/**  Setup for Updating Plugin **/

// add_filter( 'plugins_api', 'misha_plugin_info', 20, 3);
/*
 * $res empty at this step
 * $action 'plugin_information'
 * $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
 */
// function misha_plugin_info( $res, $action, $args ){

// 	// do nothing if this is not about getting plugin information
// 	if( 'plugin_information' !== $action ) {
// 		return $res;
// 	}

// 	// do nothing if it is not our plugin
// 	if( plugin_basename( __DIR__ ) !== $args->slug ) {
// 		return $res;
// 	}

// 	// info.json is the file with the actual plugin information on your server
// 	$remote = wp_remote_get( 
// 		'https://raw.githubusercontent.com/sajidmanzoor10p/ae-wp-plugin/refs/heads/main/ae-wp-plugin/ae-wp-plugin.json?token=GHSAT0AAAAAAC4CZNBVXYGXOBJMZQXGLUSEZ3CZUYA', 
// 		array(
// 			'timeout' => 10,
// 			'headers' => array(
// 				'Accept' => 'application/json'
// 			) 
// 		)
// 	);

// 	// do nothing if we don't get the correct response from the server
// 	if( 
// 		is_wp_error( $remote )
// 		|| 200 !== wp_remote_retrieve_response_code( $remote )
// 		|| empty( wp_remote_retrieve_body( $remote ) 
// 	)) {
// 		return $res;	
// 	}

// 	$remote = json_decode( wp_remote_retrieve_body( $remote ) );
	
// 	$res = new stdClass();
// 	$res->name = $remote->name;
// 	$res->slug = $remote->slug;
// 	$res->author = $remote->author;
// 	$res->author_profile = $remote->author_profile;
// 	$res->version = $remote->version;
// 	$res->tested = $remote->tested;
// 	$res->requires = $remote->requires;
// 	$res->requires_php = $remote->requires_php;
// 	$res->download_link = $remote->download_url;
// 	$res->trunk = $remote->download_url;
// 	$res->last_updated = $remote->last_updated;
// 	$res->sections = array(
// 		'description' => $remote->sections->description,
// 		'installation' => $remote->sections->installation,
// 		'changelog' => $remote->sections->changelog
// 		// you can add your custom sections (tabs) here
// 	);
// 	// in case you want the screenshots tab, use the following HTML format for its content:
// 	// <ol><li><a href="IMG_URL" target="_blank"><img src="IMG_URL" alt="CAPTION" /></a><p>CAPTION</p></li></ol>
// 	if( ! empty( $remote->sections->screenshots ) ) {
// 		$res->sections[ 'screenshots' ] = $remote->sections->screenshots;
// 	}

// 	$res->banners = array(
// 		'low' => $remote->banners->low,
// 		'high' => $remote->banners->high
// 	);
	
// 	return $res;

// }


// add_filter( 'site_transient_update_plugins', 'misha_push_update' );
 
// function misha_push_update( $transient ){
 
// 	if ( empty( $transient->checked ) ) {
// 		return $transient;
// 	}

// 	$remote = wp_remote_get( 
// 		'https://raw.githubusercontent.com/sajidmanzoor10p/ae-wp-plugin/refs/heads/main/ae-wp-plugin/ae-wp-plugin.json?token=GHSAT0AAAAAAC4CZNBVXYGXOBJMZQXGLUSEZ3CZUYA',
// 		array(
// 			'timeout' => 10,
// 			'headers' => array(
// 				'Accept' => 'application/json'
// 			)
// 		)
// 	);

// 	if( 
// 		is_wp_error( $remote )
// 		|| 200 !== wp_remote_retrieve_response_code( $remote )
// 		|| empty( wp_remote_retrieve_body( $remote ) 
// 	) ) {
// 		return $transient;	
// 	}
	
// 	$remote = json_decode( wp_remote_retrieve_body( $remote ) );
 
// 		// your installed plugin version should be on the line below! You can obtain it dynamically of course 
// 	if(
// 		$remote
// 		&& version_compare( $this->version, $remote->version, '<' )
// 		&& version_compare( $remote->requires, get_bloginfo( 'version' ), '<' )
// 		&& version_compare( $remote->requires_php, PHP_VERSION, '<' )
// 	) {
		
// 		$res = new stdClass();
// 		$res->slug = $remote->slug;
// 		$res->plugin = plugin_basename( __FILE__ ); // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
// 		$res->new_version = $remote->version;
// 		$res->tested = $remote->tested;
// 		$res->package = $remote->download_url;
// 		$transient->response[ $res->plugin ] = $res;
		
// 		//$transient->checked[$res->plugin] = $remote->version;
// 	}
 
// 	return $transient;

// }