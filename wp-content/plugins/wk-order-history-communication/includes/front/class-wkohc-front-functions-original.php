<?php
/**
 * Front Functions
 * @package WK Order History Communication
 * @version 1.0.0
 */

namespace WKOHC\Includes\Front;

use WKOHC\Templates;
use WKOHC\Helper;
use WKOHC\Includes\Emails;

defined( 'ABSPATH' ) || exit;


if ( ! class_exists( 'WKOHC_Front_Functions' ) ) {

	/**
	 * Front Functions  class
	*/
	class WKOHC_Front_Functions {


		private $db_obj;
		/**
		 * Front Functions constructor
		 */
		public function __construct() {

			$this->db_obj = new Helper\WKOHC_Data_Query();
			$this->template_handler = new Templates\WKOHC_Templates_Handler($this->db_obj);
		}

		/**
		 * Front front script
		*/
		public function wkohc_enqueue_scripts() {

			wp_enqueue_style( 'wkohc-front-style', WKOHC_PLUGIN_URL . 'assets/css/plugin.css', array(), WKOHC_SCRIPT_VERSION );

			wp_enqueue_script( 'wkohc-front-script', WKOHC_PLUGIN_URL . 'assets/js/plugin.js', array( 'select2' ), WKOHC_SCRIPT_VERSION );

			wp_enqueue_style( 'dashicons' );

			$ajax_obj = array(
				'ajaxUrl' => admin_url( 'admin-ajax.php' ),
				'ajaxNonce' => wp_create_nonce( 'wkohc-front-nonce' ),
			);

			wp_localize_script( 'wkohc-front-script', 'wkohcObj', array(
				'ajax'              => $ajax_obj,
				'commonConfirmMsg'  => esc_html__( 'Are you sure?', 'wk-ohc' ),
				'text_processing'   => esc_html__('Please wait... Comment is Now Being Processing', 'wk-ohc'),
				'text_error_comment' => esc_html__('Please add your comment','wk-ohc'),
			) );
		}

		public function wkohc_add_comment_box($order_id) {
			$this->template_handler->wkhoc_customer_comment_page($order_id);
		}

		public function wkohc_save_customer_comment_box() {
			$json = array();

			if ( !check_ajax_referer( 'wkohc-front-nonce', 'wkohc_nonce', false ) ) {
        $json['error'] = true;
        $json['message'] = esc_html__( 'Security check failed!', 'wk-ohc' );
        wp_send_json($json);
        die();
			}
  		$user_info = get_userdata(get_current_user_id());

			if(isset($_POST['comment']) && $_POST['comment']) {
				$date = date("Y-m-d h:i:s");
				$add_data = array(
					'comment_post_ID'      => $_POST['order_id'],
					'comment_author'       => $user_info->display_name,
					'comment_author_email' => $user_info->user_email,
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

		/**
		 * Add email action
		 *
		 * @param array $actions actions.
		 *
		 * @return array
		 */
		public function wkohc_add_woocommerce_email_actions($actions) {

			$actions[] = 'wkohc_admin_mail';
			$actions[] = 'wkohc_customer_mail';
			return $actions;
		}

		/**
		 * Add mail class
		 * @param array $email email.
		 * @return array
		*/
		public function wkohc_add_new_email_notification($email) {

			$email['WC_EMAIL_WKOHC_Admin_Mail'] = new Emails\WKOHC_Admin_Mail();;
			$email['WC_EMAIL_WKOHC_Customer_Mail'] = new Emails\WKOHC_Customer_Mail();;

			return $email;
		}

	}
}
