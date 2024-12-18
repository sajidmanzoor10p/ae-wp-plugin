<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://americaneagle.com
 * @since      1.0.0
 *
 * @package    Ae_Wp_Plugin
 * @subpackage Ae_Wp_Plugin/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Ae_Wp_Plugin
 * @subpackage Ae_Wp_Plugin/admin
 * @author     Sajid <sajid.manzoor@americaneagle.com>
 */
class Ae_Wp_Plugin_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ae_Wp_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ae_Wp_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/ae-wp-plugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ae_Wp_Plugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ae_Wp_Plugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/ae-wp-plugin-admin.js', array( 'jquery' ), $this->version, false );

	}



	/*
	* $res empty at this step
	* $action 'plugin_information'
	* $args stdClass Object ( [slug] => woocommerce [is_ssl] => [fields] => Array ( [banners] => 1 [reviews] => 1 [downloaded] => [active_installs] => 1 ) [per_page] => 24 [locale] => en_US )
	*/
	function ae_plugin_info( $res, $action, $args ){

		// do nothing if this is not about getting plugin information
		if( 'plugin_information' !== $action ) {
			return $res;
		}

		// do nothing if it is not our plugin
		if( plugin_basename( __DIR__ ) !== $args->slug ) {
			return $res;
		}

		// info.json is the file with the actual plugin information on your server
		$remote = wp_remote_get( 
			'https://raw.githubusercontent.com/sajidmanzoor10p/ae-wp-plugin/refs/heads/main/ae-wp-plugin/ae-wp-plugin.json?token=GHSAT0AAAAAAC4CZNBVXYGXOBJMZQXGLUSEZ3CZUYA', 
			array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				) 
			)
		);

		// do nothing if we don't get the correct response from the server
		if( 
			is_wp_error( $remote )
			|| 200 !== wp_remote_retrieve_response_code( $remote )
			|| empty( wp_remote_retrieve_body( $remote ) 
		)) {
			return $res;	
		}

		$remote = json_decode( wp_remote_retrieve_body( $remote ) );
		
		$res = new stdClass();
		$res->name = $remote->name;
		$res->slug = $remote->slug;
		$res->author = $remote->author;
		$res->author_profile = $remote->author_profile;
		$res->version = $remote->version;
		$res->tested = $remote->tested;
		$res->requires = $remote->requires;
		$res->requires_php = $remote->requires_php;
		$res->download_link = $remote->download_url;
		$res->trunk = $remote->download_url;
		$res->last_updated = $remote->last_updated;
		$res->sections = array(
			'description' => $remote->sections->description,
			'installation' => $remote->sections->installation,
			'changelog' => $remote->sections->changelog
			// you can add your custom sections (tabs) here
		);
		// in case you want the screenshots tab, use the following HTML format for its content:
		// <ol><li><a href="IMG_URL" target="_blank"><img src="IMG_URL" alt="CAPTION" /></a><p>CAPTION</p></li></ol>
		if( ! empty( $remote->sections->screenshots ) ) {
			$res->sections[ 'screenshots' ] = $remote->sections->screenshots;
		}

		$res->banners = array(
			'low' => $remote->banners->low,
			'high' => $remote->banners->high
		);
		
		return $res;

	}

	 
	function ae_push_update( $transient ){
	
		if ( empty( $transient->checked ) ) {
			return $transient;
		}

		$remote = wp_remote_get( 
			'https://raw.githubusercontent.com/sajidmanzoor10p/ae-wp-plugin/refs/heads/main/ae-wp-plugin/ae-wp-plugin.json?token=GHSAT0AAAAAAC4CZNBVXYGXOBJMZQXGLUSEZ3CZUYA',
			array(
				'timeout' => 10,
				'headers' => array(
					'Accept' => 'application/json'
				)
			)
		);

		if( 
			is_wp_error( $remote )
			|| 200 !== wp_remote_retrieve_response_code( $remote )
			|| empty( wp_remote_retrieve_body( $remote ) 
		) ) {
			return $transient;	
		}
		
		$remote = json_decode( wp_remote_retrieve_body( $remote ) );
	
			// your installed plugin version should be on the line below! You can obtain it dynamically of course 
		if(
			$remote
			&& version_compare( $this->version, $remote->version, '<' )
			&& version_compare( $remote->requires, get_bloginfo( 'version' ), '<' )
			&& version_compare( $remote->requires_php, PHP_VERSION, '<' )
		) {
			
			$res = new stdClass();
			$res->slug = $remote->slug;
			$res->plugin = plugin_basename( __FILE__ ); // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
			$res->new_version = $remote->version;
			$res->tested = $remote->tested;
			$res->package = $remote->download_url;
			$transient->response[ $res->plugin ] = $res;
			
			//$transient->checked[$res->plugin] = $remote->version;
		}
	
		return $transient;

	}

}
