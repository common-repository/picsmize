<?php
/**
 * Admin Class
 *
 * Handles the Admin side functionality of plugin
 *
 * @package Picsmize
 * @since 1.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; /* Exit if accessed directly */
}
if ( !class_exists( 'PICS_Admin' ) ) {
	class PICS_Admin {
		function __construct() {
			// Action to register admin menu
			add_action( 'admin_menu', array($this, 'PICS_register_menu'), 9 );
			add_action( 'admin_notices', array($this, 'PICS_admin_messages' ) );
			add_action( 'admin_enqueue_scripts', array( $this, 'PICS_admin_script' ) );

			add_action( 'admin_init', array($this, 'PICS_register_option' ) );
		}
		/**
		 * Function to register admin menus
		 * 
		 * @package Picsmize
		 * @since 1.0.0
		 */
		function PICS_register_menu() {
			// Getting Started Page
			add_menu_page(__(PICS_BASENAME),PICS_BASENAME, 'edit_pages','pics-dashboard', array($this, 'PicsHistory'),'dashicons-format-gallery');
			add_submenu_page('pics-dashboard', 'Dashboard', 'Dashboard', 'edit_pages', 'pics-dashboard', array($this, 'PicsHistory'));
			add_submenu_page('pics-dashboard', 'API Setting', 'API Settings', 'edit_pages', 'settings', array($this, 'PICSsettings'));
			add_submenu_page('pics-dashboard', 'Manual Upload', 'Manual Upload', 'edit_pages', 'pics-manual', array($this, 'PicsManualUpload'));
			add_submenu_page('pics-dashboard', 'Compress Settings', 'Compress Settings', 'edit_pages', 'compress', array($this, 'PicsCompress'));
			add_submenu_page('pics-dashboard', 'ALT Settings', 'ALT Settings', 'edit_pages', 'alt-change', array($this, 'PicsAltChange'));
			add_submenu_page('pics-dashboard', 'File Rename Settings', 'File Rename Settings', 'edit_pages', 'rename', array($this, 'PicsRename'));

		}

		function PICSsettings(){ 
			include(PICS_DIR . '/templates/auth.php');
			include(PICS_DIR . '/templates/toast.php');
		}

		function PICS_admin_messages(){
			global $pagenow;
			$pics_api_key  = get_option( 'pics_api_key' );
		    if ( $pics_api_key == '' ) {
		        echo '<div class="notice notice-error pics-notice-error is-dismissible">
		             <p>Setup wizard still pending, please go to <b>API settings</b> for API setup.</p>
		         </div>';
		    }
		}

		function PICS_admin_script(){
			/* Init Style */
			wp_register_style( 'pics-polaris-style', PICS_URL . 'assets/css/polaris.css', array(), PICS_VERSION );
			wp_enqueue_style( 'pics-polaris-style' );

			wp_register_style( 'pics-common-style', PICS_URL . 'assets/css/common.css', array(), PICS_VERSION );
			wp_enqueue_style( 'pics-common-style' );

			wp_register_style( 'pics-dataTables-style', PICS_URL . 'assets/css/jquery.dataTables.min.css', array(), PICS_VERSION );
			wp_enqueue_style( 'pics-dataTables-style' );

			wp_enqueue_script('jquery', true );

			if(isset($_GET['page'])){
				if($_GET['page'] == 'pics-dashboard'){
					wp_register_style( 'pics-dashboard-style', PICS_URL . 'assets/css/dashboard.css', array(), PICS_VERSION );
					wp_enqueue_style( 'pics-dashboard-style' );
					
					wp_register_script( 'pics-dashboard-js', PICS_URL . 'assets/js/dashboard.js', array('jquery'), PICS_VERSION, true );
					wp_enqueue_script('pics-dashboard-js');
				}

				if($_GET['page'] == 'pics-manual'){
					wp_register_style( 'pics-manual-style', PICS_URL . 'assets/css/manual_upload.css', array(), PICS_VERSION );
					wp_enqueue_style( 'pics-manual-style' );
					wp_register_script( 'pics-manual-js', PICS_URL . 'assets/js/manual_upload.js', array('jquery'), PICS_VERSION, true );
					wp_enqueue_script('pics-manual-js');
				}

				if($_GET['page'] == 'compress'){
					wp_register_style( 'pics-compress-style', PICS_URL . 'assets/css/compression-settings.css', array(), PICS_VERSION );
					wp_enqueue_style( 'pics-compress-style' );
					wp_register_script( 'pics-compress-js', PICS_URL . 'assets/js/compression-settings.js', array('jquery'), PICS_VERSION, true );
					wp_enqueue_script('pics-compress-js');
				}

				if($_GET['page'] == 'alt-change' || $_GET['page'] == 'rename' ){
					wp_register_style( 'pics-alt-style', PICS_URL . 'assets/css/alt-settings.css', array(), PICS_VERSION );
					wp_enqueue_style( 'pics-alt-style' );
					wp_register_script( 'pics-drag-arrange-js', PICS_URL . 'assets/js/drag-arrange.js', array('jquery'), PICS_VERSION, true );
					wp_enqueue_script('pics-drag-arrange-js');
					wp_register_script( 'pics-alt-rename-js', PICS_URL . 'assets/js/file_alt_rename_settings.js', array('jquery'), PICS_VERSION, true );
					wp_enqueue_script('pics-alt-rename-js');
				}
			}
			/* End Init Style */
			
			wp_register_script( 'pics-datatable-js', PICS_URL . 'assets/js/jquery.dataTables.min.js', array('jquery'), PICS_VERSION, true );
			wp_enqueue_script('pics-datatable-js');
			wp_register_script( 'pics-common-js', PICS_URL . 'assets/js/common.js', array('jquery'), PICS_VERSION, true );
			wp_enqueue_script('pics-common-js');
			
		}

		function PICS_register_option() {
			// creates our settings in the options table
			register_setting('PICS_api_key', 'pics_api_key', '' );
		}

		function PicsHistory(){
			include(PICS_DIR . '/templates/image-history.php');
			include(PICS_DIR . '/templates/toast.php');
		}

		function PicsAltChange(){
			include(PICS_DIR . '/templates/altChange.php');
			include(PICS_DIR . '/templates/toast.php');
		}

		function PicsRename(){
			include(PICS_DIR . '/templates/renameImage.php');
			include(PICS_DIR . '/templates/toast.php');
		}

		function PicsCompress(){
			include(PICS_DIR . '/templates/compressImage.php');
			include(PICS_DIR . '/templates/toast.php');
		}

		function PicsManualUpload(){
			include(PICS_DIR . '/templates/manual.php');
			include(PICS_DIR . '/templates/toast.php');
		}

	}
}
$PICS_admin = new PICS_Admin();