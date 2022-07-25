<?php
/**
 * File Handler
 * @package WK Order History Communication
 * @version 1.0.0
*/

namespace WKOHC\Includes;

defined( 'ABSPATH' ) || exit;

use WKOHC\Includes\Front;
use WKOHC\Includes\Admin;

if ( ! class_exists( 'WKOHC_File_Handler' ) ) {
	/**
	 * File handler class
	 */
	class WKOHC_File_Handler {
		/**
		 * File handler constructor
		 */
		public function __construct() {

			if ( is_admin() ) {
				new Admin\WKOHC_Admin_Hooks();
			} else {

				if ( 'enable' === get_option( 'wkohc_module_status', 'enable' ) ) {
					new Front\WKOHC_Front_Hooks();
				}

			}
			new Front\WKOHC_Front_Ajax_Hooks();

		}
	}
}
