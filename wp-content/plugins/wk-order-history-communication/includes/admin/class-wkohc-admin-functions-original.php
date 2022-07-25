<?php
/**
 * Admin Hooks
 * @package WK Order History Communication
 * @version 1.0.0
 */

namespace WKOHC\Includes\Admin;

use WKOHC\Templates;
use WKOHC\Helper;

defined( 'ABSPATH' ) || exit;


if ( ! class_exists( 'WKOHC_Admin_Functions' ) ) {
	/**
	 * Admin Functions  class
	 */
	class WKOHC_Admin_Functions {

		private $template_handler;
		private $db_obj;
		/**
		 * Admin Functions constructor
		 */
		public function __construct() {

			$this->db_obj = new Helper\WKOHC_Data_Query();
			$this->template_handler = new Templates\WKOHC_Templates_Handler($this->db_obj);

		}

		/**
		 * Enque admin script
		 * @return void
		*/
		public function wkohc_admin_scripts() {

			wp_enqueue_style( 'wkohc-admin-style', WKOHC_PLUGIN_URL . 'assets/css/plugin.css', array(), WKOHC_SCRIPT_VERSION );

			wp_enqueue_script( 'wkohc-admin-script', WKOHC_PLUGIN_URL . 'assets/js/plugin.js', array( 'select2' ), WKOHC_SCRIPT_VERSION );

			$ajax_obj = array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'ajaxNonce' => wp_create_nonce( 'wkohc-admin-nonce' ),
			);

			wp_localize_script( 'wkohc-admin-script', 'wkohcObj', array(
				'ajax'              => $ajax_obj,
				'commonConfirmMsg'  => esc_html__( 'Are you sure?', 'wk-ohc' ),
				'text_processing'   => esc_html__('Please wait... Comment is Now Being Processing', 'wk-ohc'),
				'text_error_comment' => esc_html__('Please add your comment','wk-ohc'),
			) );
		}

		/**
		 * Add admin menu
		 * @return boolean
		*/
		public function wkohc_add_menu() {
			add_menu_page(
				esc_html__( 'Order History Communication', 'wk-ohc' ),
				esc_html__( 'Order History Communication', 'wk-ohc' ),
				'edit_posts',
				'wkohc-settings',
				array($this->template_handler, 'wkohc_settings_page'),
				'dashicons-yes-alt',
				59
			);
		}

		/**
		 * Set screen ids
		 * @return boolean
		*/
		public function wkohc_set_screens_id($screen) {
			$screen[] = 'toplevel_page_wkohc-settings';
			return $screen;
		}

		/**
		 * Register admin setting
		 * @return boolean
		*/
		public function wkohc_register_settings() {
			//Register Live Sales Settings Fields
			register_setting( 'wkohc-settings-group', 'wkohc_module_status' );
			register_setting( 'wkohc-settings-group', 'wkohc_allow_order_status' );
			register_setting( 'wkohc-settings-group', 'wkohc_send_mail_admin' );
			register_setting( 'wkohc-settings-group', 'wkohc_send_mail_customer' );
		}

		/**
		 * Add meta boxes on the order edit page
		 * @return boolean
		*/
		public function wkohc_add_comment_box() {
			add_meta_box(
					'wkohc-modal',
					'Order History Communication',
					array($this,'wkohc_comment_box_callback'),
					'shop_order',
					'side',
					'core'
			);
		}

		/**
		 * Call back method for metaboxes
		 * @param array $order
		 * @return void
		*/
		public function wkohc_comment_box_callback($order) {
			$this->template_handler->wkhoc_admin_comment_page($order);
		}

		/**
		 * Save order communication comment
		 * @return boolean
		*/
		public function wkohc_save_comment_box() {
			$json = array();

			if ( !check_ajax_referer( 'wkohc-admin-nonce', 'wkohc_nonce', false ) ) {
        $json['error'] = true;
        $json['message'] = esc_html__( 'Security check failed!', 'wk-ohc' );
        wp_send_json($json);
        die();
			}

			if(isset($_POST['comment']) && $_POST['comment']) {
				$date = date("Y-m-d h:i:s");
				$add_data = array(
					'comment_post_ID'      => $_POST['order_id'],
					'comment_author'       => 'admin',
					'comment_author_email' => get_option('admin_email'),
					'comment_date'         => $date,
					'comment_date_gmt'     => $date,
					'comment_content'      => sanitize_text_field( wp_unslash($_POST['comment'])),
					'comment_approved'     => 1,
					'comment_agent'        => 'WooCommerce',
					'comment_type'         => 'wkohc_order_note',
				);

				$save_name = array();

				if(isset($_FILES['files'])) {
					$files = $_FILES['files'];
					$path = WKOHC_PLUGIN_FILE . 'uploads/' . $_POST['order_id'] . '/';
					if (!file_exists($path)) {
				    mkdir(WKOHC_PLUGIN_FILE . 'uploads/' . $_POST['order_id'], 0777);
					}
					foreach ($files['name'] as $key => $file) {
						$rand = rand(0000,9999);
						$file_name = $rand . $files['name'][$key];
						$image = $path . $file_name;
						move_uploaded_file($files['tmp_name'][$key] , $image);
						$save_name[] = $file_name;
					}
				}
				$comment_id = $this->db_obj->wkohc_add_comment_data($add_data);
				foreach ($save_name as $key => $value) {
					$meta_value = array(
						'comment_id' => $comment_id,
						'meta_key'   => '_wkohc_attach_file',
						'meta_value' => $value,
					);
					$this->db_obj->wkohc_add_comment_meta_data($meta_value);
				}
				$json['comment_id'] = $comment_id;
			}

			wp_send_json($json);
			die();

		}

	}
}
