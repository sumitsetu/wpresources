<?php
/**
 * Plugin Name:       WP Resources
 * Plugin URI:        https://localhost/plugins/wp-resources/
 * Description:       Show blogs, ebooks, casestudies using shortcodes.
 * Version:           1.0
 * Requires at least: 4.5
 * Requires PHP:      5.4
 * Author:            Sumit Mishra
 * Author URI:        https://localhost.com/
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
* Currently plugin version.
*/

define( 'PLUGIN_NAME_VERSION', '1.0' );

/**
* The code that runs during plugin activation.
* This action is documented in includes/class-plugin-name-activator.php
*/
function activate_plugin_name() {
	//require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-resources-activator.php';
//	WP_Resources_Activator::activate();
}

require_once plugin_dir_path( __FILE__ ) . 'includes/class-wp-resources.php';
function wpresource_register_shortcode(){
	require_once plugin_dir_path( __FILE__ ) . 'includes/shortcodes-wp-resources.php';
}
add_action('init', 'wpresource_register_shortcode');

function wpresource_frontend_scripts(){
	wp_enqueue_style( 'wpresource-frontend-boot',  plugins_url( 'lib/css/bootstrap.min.css', __FILE__ ) , array(), '1.0');
	wp_enqueue_style( 'wpresource-frontend-style',  plugins_url( 'lib/css/style.css', __FILE__ ) , array(), '1.0');
	wp_register_script ( 'wpresource-frontend-js',  plugins_url( 'lib/js/bootstrap.min.js', __FILE__ ),array('jquery'), '1.0', true);
	wp_enqueue_script ('wpresource-frontend-js');
}
add_action( 'wp_enqueue_scripts', 'wpresource_frontend_scripts', 99 );

add_filter( 'page_template', 'wpa3396_page_template' );
function wpa3396_page_template( $page_template )
{
    if ( is_page() ) {
        $page_template = dirname( __FILE__ ) . '/custom-page-template.php';
    }
    return $page_template;
}

register_deactivation_hook( __FILE__, 'wpresource_deactivate' );
function wpresource_deactivate(){
	global $wpdb; // Must have this or else!
	$postmeta_table = $wpdb->postmeta;
	$posts_table = $wpdb->posts;
	$wpdb->query("DELETE FROM " . $postmeta_table . " WHERE meta_key = 'wpresourcemetadata'");
	$wpdb->query("DELETE FROM " . $posts_table . " WHERE post_type = 'wp-resources'");
}
/**
* Begins execution of the plugin.
*/
function run_wp_resources() {

	$plugin = new WP_Resources();
	$plugin->run();

}
run_wp_resources();
