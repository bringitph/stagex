<?php
/**
 * Front Hooks
 * @package WK Order History Communication
 * @version 1.0.0
 */

namespace WKOHC\Includes\Front;

defined( 'ABSPATH' ) || exit;


if ( ! class_exists( 'WKOHC_Front_Hooks' ) ) {
	/**
	 * Front Hooks  class
	 */
	class WKOHC_Front_Hooks {
		/**
		 * Front Hooks constructor
		 */
		public function __construct() {
			$function_handler = new WKOHC_Front_Functions();

			add_action( 'wp_enqueue_scripts', [$function_handler, 'wkohc_enqueue_scripts']);
			add_action( 'woocommerce_view_order', [$function_handler, 'wkohc_add_comment_box']);
		}
	}
}
