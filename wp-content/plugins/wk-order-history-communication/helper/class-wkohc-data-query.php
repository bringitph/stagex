<?php
/**
 * File Handler
 * @package WK Order History Communication
 * @version 1.0.0
*/

namespace WKOHC\Helper;

defined( 'ABSPATH' ) || exit;

if ( ! class_exists( 'WKOHC_Data_Query' ) ) {

  /**
   * Database query class
  */
  class WKOHC_Data_Query {

    /**
		 * DB global variable
		 * @var object
		*/
    protected $wpdb;
    protected $comment_table;
    protected $comment_meta_table;

    /**
     * Constructor of the class
    */
    public function __construct() {
      global $wpdb;
			$this->wpdb = $wpdb;
      $this->comment_table = $this->wpdb->prefix . 'comments';
      $this->comment_meta_table = $this->wpdb->prefix . 'commentmeta';
    }

    // JS edit: Fix inability to send uploaded attachment in messages and field for filename. Step 5
    public function wkohc_added_comment_data_mail($data = array()) {

      if(get_option('wkohc_send_mail_admin')) {
        // JS edit: Fix Order Comm History email addressee
        //do_action('wkohc_admin_mail', $data);
      }

      if(get_option('wkohc_send_mail_customer')) {
        // JS edit: Fix inability to send uploaded attachment in messages and field for filename. Step 6.1
        // JS edit: Fix Order Comm History email addressee
        do_action('wkohc_customer_mail', $data);
      }
	
	// JS edit: Fix inability to send uploaded attachment in messages and field for filename. Step 6.2
	}

    public function wkohc_add_comment_data($data = array()) {

      $insert_query = $this->wpdb->insert($this->comment_table, $data );
      
      return $insert_query ? $this->wpdb->insert_id : false;

    }

    public function wkohc_add_comment_meta_data($data = array()) {

      $this->wpdb->insert($this->comment_meta_table, $data );
    }

    public function wkohc_get_comment_data($order_id) {
      $results = $this->wpdb->get_results( $this->wpdb->prepare("SELECT * FROM $this->comment_table WHERE comment_post_ID = '%d' AND comment_type = '%s'", esc_attr($order_id),esc_attr('wkohc_order_note')) );

      return apply_filters('wkohc_get_comment_data' , $results, $order_id);
    }

  }

}
