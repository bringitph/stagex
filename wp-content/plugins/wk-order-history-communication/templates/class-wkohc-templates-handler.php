<?php
/**
 * Admin Hooks
 * @package WK Order History Communication
 * @version 1.0.0
 */

namespace WKOHC\Templates;

defined( 'ABSPATH' ) || exit;


if ( ! class_exists( 'WKOHC_Templates_Handler' ) ) {
	/**
	 * Admin Functions  class
	 */
	class WKOHC_Templates_Handler {

		private $db_obj;


		/**
		 * Admin Functions constructor
		 */
		public function __construct($db_obj) {
			$this->db_obj = $db_obj;
		}

    public function wkohc_settings_page() {
      require_once "admin/wkohc-setting.php";
    }

		public function wkhoc_admin_comment_page($order) {
			require_once "admin/wkohc-comment.php";
		}

		public function wkhoc_customer_comment_page($order_id) {
			require_once "front/wkohc-comment.php";
		}

  }
}
