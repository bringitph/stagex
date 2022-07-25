<?php
/**
 * Admin Hooks
 * @package WK Order History Communication
 * @version 1.0.0
 */

namespace WKOHC\Includes\Admin;

defined( 'ABSPATH' ) || exit;


if ( ! class_exists( 'WKOHC_Admin_Hooks' ) ) {
	/**
	 * Admin Hooks  class
	 */
	class WKOHC_Admin_Hooks {
		/**
		 * Admin Hooks constructor
		 */
		public function __construct() {

			$function_handler = new WKOHC_Admin_Functions();

			add_action( 'admin_enqueue_scripts', [ $function_handler, 'wkohc_admin_scripts' ] );
			add_action( 'admin_menu', [$function_handler, 'wkohc_add_menu'] );
			add_filter( 'woocommerce_screen_ids', [$function_handler, 'wkohc_set_screens_id' ] );
			add_action( 'admin_init', [$function_handler, 'wkohc_register_settings' ] );

			if ( 'enable' === get_option( 'wkohc_module_status', 'enable' ) ) {
				add_action( 'add_meta_boxes', [$function_handler, 'wkohc_add_comment_box'] );
				add_action( 'wp_ajax_wkohc_save_comment_box', [$function_handler, 'wkohc_save_comment_box']);
			}

		}

	}
}
