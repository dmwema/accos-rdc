<?php
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) exit;
/*
Plugin Name: Keon Toolset
Plugin URI:  
Description: A easy plugin to import dummy data for themes by Keon Themes.
Version:     1.4.3
Author:      Keon Themes
Author URI:  https://keonthemes.com
License:     GPLv3 or later
License URI: https://www.gnu.org/licenses/gpl-3.0.html
Domain Path: /languages
Text Domain: keon-toolset
*/
define( 'KEON_TOOLSET_URL', plugin_dir_url( __FILE__ ).'demo/' );
define( 'KEON_TEMPLATE_URL', plugin_dir_url( __FILE__ ) );
define( 'KEON_TOOLSET_PATH', plugin_dir_path( __FILE__ ) );

/**
 * Returns the currently active theme's name.
 *
 * @since    1.0.0
 */
function keon_toolset_get_theme_slug(){
    $demo_theme = wp_get_theme();
   	return $demo_theme->get( 'TextDomain' );
}

/**
 * Returns the currently active theme's screenshot.
 *
 * @since    1.0.0
 */
function keon_toolset_get_theme_screenshot(){
	$demo_theme = wp_get_theme();
    return $demo_theme->get_screenshot();
}
/**
 * The core plugin class that is used to define internationalization,admin-specific hooks, 
 * and public-facing site hooks..
 *
 * @since    1.0.0
 */   
require KEON_TOOLSET_PATH . 'demo/functions.php';
require KEON_TOOLSET_PATH . 'includes/class-template-library-base.php';
require KEON_TOOLSET_PATH . 'includes/theme-check-functions.php';
require KEON_TOOLSET_PATH . 'includes/admin-notices.php';

/**
 * Register all of the hooks related to the admin area functionality
 * of the plugin.
 *
 * @since    1.0.0
 */
$plugin_admin = keon_toolset_hooks();
add_filter( 'advanced_import_demo_lists', array( $plugin_admin,'keon_toolset_demo_import_lists'), 10, 1 );
add_filter( 'admin_menu', array( $plugin_admin, 'import_menu' ), 10, 1 );
add_filter( 'wp_ajax_keon_toolset_getting_started', array( $plugin_admin, 'install_advanced_import' ), 10, 1 );
add_filter( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_styles' ), 10, 1 );
add_filter( 'admin_enqueue_scripts', array( $plugin_admin, 'enqueue_scripts' ), 10, 1 );
add_action( 'advanced_import_replace_term_ids', array( $plugin_admin, 'replace_term_ids' ), 20 );
add_action( 'advanced_import_replace_post_ids', array( $plugin_admin, 'replace_attachment_ids' ), 30 );
