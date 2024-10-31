<?php
/**
 * Plugin Name: Picsmize
 * Plugin URI: https://softpulseinfotech.com/
 * Version: 1.0.0
 * Description: Optimize & speed up your store by compressing product and other asset images with different modes like lossy, balanced & lossless.
 * Author: Softpulse Infotech
 * Author URI: https://softpulseinfotech.com
 * License : GPL v2 or later
 * License URI : https://www.gnu.org/licenses/gpl-2.0.html
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}
/**
 * Basic plugin definitions
 * 
 * @package Picsmize
 * @since 1.0.0
 */
if( !defined( 'PICS_VERSION' ) ) {
	define( 'PICS_VERSION', '1.0.0' ); 
}
if( !defined( 'PICS_DIR' ) ) {
	define( 'PICS_DIR', dirname( __FILE__ ) ); 
}
if( !defined( 'PICS_URL' ) ) {
	define( 'PICS_URL', plugin_dir_url( __FILE__ ) );
}
if( !defined( 'PICS_BASENAME' ) ) {
	define( 'PICS_BASENAME', 'Picsmize' );
}
if( !defined( 'PICS_IMAGE_TABLE' ) ) {
	define( 'PICS_IMAGE_TABLE', 'pics_images' );
}
if(!defined('PICS_LOG_TABLE')){
	define('PICS_LOG_TABLE', 'pics_logs');
}

if( !defined( 'PICS_SITE_URL' ) ) 
	define('PICS_SITE_URL', 'https://picsmize.com/');

if( !defined( 'PICS_HELP_DIR' ) ) 
	define('PICS_HELP_DIR', 'https://apps.picsmize.com/sh/');

/**
 * Activation Hook
 * 
 * Register plugin activation hook.
 * 
 * @package Picsmize
 * @since 1.0
 */
register_activation_hook( __FILE__, 'PICS_install' );
register_deactivation_hook( __FILE__, 'PICS_uninstall' );

require_once( PICS_DIR . '/includes/install.php' );
// Functions file
require_once( PICS_DIR . '/includes/functions.php' );

require_once( PICS_DIR . '/includes/class-image-function.php' );
// Picsmize Post Class
require_once( PICS_DIR . '/includes/class-picsmize.php' );
// Script/ CSS Class
require_once( PICS_DIR . '/includes/class-pics-script.php' );
// Picsmize library Class
require_once( PICS_DIR . '/lib/Picsmize.php' );