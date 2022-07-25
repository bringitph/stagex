<?php
/**
 * Front Hooks
 * @package WK Order History Communication
 * @version 1.0.0
 */

namespace WKOHC\Includes\Front;

defined( 'ABSPATH' ) || exit;


if ( ! class_exists( 'WKOHC_Front_Ajax_Hooks' ) ) {
	/**
	 * Front Hooks  class
	 */
	class WKOHC_Front_Ajax_Hooks {
		/**
		 * Front Hooks constructor
		 */
		public function __construct() {
			$function_handler = new WKOHC_Front_Functions();

			add_action( 'wp_ajax_wkohc_save_customer_comment_box', [$function_handler, 'wkohc_save_customer_comment_box']);

			add_filter('woocommerce_email_actions', [$function_handler, 'wkohc_add_woocommerce_email_actions'], 10, 1);
			add_filter('woocommerce_email_classes', [$function_handler, 'wkohc_add_new_email_notification'], 10, 1);
		}
	}
}
