<?php
/**
 * Plugin Name: Order Approval by Customer for WooCommerce
 * Description: This plugin enables the order approval by Customers for woocommerce. The customers can change the order status/approve the order when it has order status set as Delivered.
 * Version:     1.2.1
 * Author:      MS Web Arts
 * Author URI:  https://www.mswebarts.com/
 * License:     GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: order-approval

 {Plugin Name} is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.
 
{Plugin Name} is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.
 
You should have received a copy of the GNU General Public License
along with {Plugin Name}. If not, see {License URI}.
 */

// Check if woocommerce is installed

add_action('plugins_loaded', 'msoa_check_for_woocommerce');
function msoa_check_for_woocommerce() {
    if ( !defined('WC_VERSION') ) {
        add_action( 'admin_notices', 'msoa_woocommerce_dependency_error' );
        return;
    }
}

function msoa_woocommerce_dependency_error() {
    $class = 'notice notice-error';
    $message = __( 'You must need to install and activate woocommerce for Order Approval to work', 'order-approval' );

    printf( '<div class="%1$s"><p>%2$s</p></div>', esc_attr( $class ), esc_html( $message ) ); 
}

add_action( "wp_enqueue_scripts", "msoa_register_styles" );
function msoa_register_styles() {
    wp_enqueue_style( "msoa_style", plugins_url( 'style.css', __FILE__ ) );
}

/*================================
	Add Delivered Order Status
==================================*/

add_action( 'init', 'msoa_register_delivered_order_status' );
function msoa_register_delivered_order_status() {
    register_post_status( 'wc-delivered', array(
        'label'                     => 'Session Completed',
        'public'                    => true,
        'show_in_admin_status_list' => true,
        'show_in_admin_all_list'    => true,
        'exclude_from_search'       => false,
        'label_count'               => _n_noop( 'Delivered <span class="count">(%s)</span>', 'Delivered <span class="count">(%s)</span>' )
    ) );
}

add_filter( 'wc_order_statuses', 'msoa_add_delivered_status_to_order_statuses' );
function msoa_add_delivered_status_to_order_statuses( $order_statuses ) {

    $new_order_statuses = array();

    foreach ( $order_statuses as $key => $status ) {

        $new_order_statuses[ $key ] = $status;

        if ( 'wc-processing' === $key ) {
            $new_order_statuses['wc-delivered'] = __( 'Delivered', 'order-approval' );
        }
    }

    return $new_order_statuses;
}

// JS edit: Step 1: Mark as Accepted button on Buyers order view 1/7
// add_filter( 'woocommerce_my_account_my_orders_actions', 'msoa_mark_as_received', 10, 2 );
// function msoa_mark_as_received( $actions, $order ) {
add_filter( 'woocommerce_order_details_after_order_table', 'msoa_mark_as_received', 10, 2 );
function msoa_mark_as_received($order ) {
	$order_id = $order->id;

    if ( ! is_object( $order ) ) {
        $order_id = absint( $order );
        $order    = wc_get_order( $order_id );
    }
    
    // check if order status delivered and form not submitted

	// JS edit: Step 1: Mark as Accepted button on Buyers order view 2/7
	//if ( ( $order->has_status( 'delivered' ) ) && ( !isset( $_POST['mark_as_received'] ) ) ) {
		$check_received = ( $order->has_status( 'purchased' ) ) ? "true" : "false";
		$disable = ( $order->has_status( 'purchased' ) ) ? "" : "disabled";
	    ?>
	    
	    <!-- JS edit. Add title for Mark as Accepted -->
	    <h2>On Your Meet-up Day</h2><br/>Click the button below if you accept the item.<br/><br/>
	    <div class="ms-mark-as-received">
		    <!-- JS edit: Step 2: Add warning message on Accept button -->
		    <form method="post" onSubmit="return confirm('Are you sure?') ">
				<input type="hidden" name="mark_as_received" value="<?php echo esc_attr( $check_received ); ?>">
				<input type="hidden" name="order_id" value="<?php echo esc_attr($order_id);?>">
				<?php wp_nonce_field( 'so_38792085_nonce_action', '_so_38792085_nonce_field' ); ?> 
				<!-- JS edit: Step 1: Mark as Accepted button on Buyers order view 3/7 -->
				<button class="woocommerce-button button view" <?php echo $disable; ?> type="submit"  data-toggle="tooltip" title="<?php echo esc_attr_e( 'Click to mark the item or order as Accepted.', 'order-approval' ); ?>"><?php echo esc_attr_e( 'I accept the item', 'order-approval' ); ?></button>
			</form>
	    </div>
        <!-- JS edit: Step 1: Mark as Accepted button on Buyers order view 4/7 -->
        <!-- <div class="ms-mark-as-received">
		    <form method="post">
				<input type="hidden" name="mark_as_not_received" value="<?php echo esc_attr( $check_received ); ?>">
				<input type="hidden" name="order_id" value="<?php echo esc_attr($order_id);?>">
				<?php wp_nonce_field( 'so_38792085_nonce_action', '_so_38792085_nonce_field' ); ?> 
				<button class="woocommerce-button button view" <?php echo $disable; ?> type="submit" value="" ><?php echo esc_attr_e( 'Mark as not Accepted', 'order-approval' ); ?></button>
				
			</form>
	    </div> -->
	    Link for Not Accepted<br/>
	    <?php
	// JS edit: Step 1: Mark as Accepted button on Buyers order view 5/7
	//}

    /*
    //refresh page if form submitted

    * fix status not updating
    */
    
    // JS edit: Step 1: Mark as Accepted button on Buyers order view 6/7
    // if( isset( $_POST['mark_as_received'] ) || isset( $_POST['mark_as_not_received'] ) ) { 
    //     echo "<meta http-equiv='refresh' content='0'>";
    // }

	// // not a "mark as received" form submission
    // if ( ! isset( $_POST['mark_as_received']) || isset( $_POST['mark_as_not_received'] ) ){
    //     return $actions;
    // }

    // // basic security check
    // if ( ! isset( $_POST['_so_38792085_nonce_field'] ) || ! wp_verify_nonce( $_POST['_so_38792085_nonce_field'], 'so_38792085_nonce_action' ) ) {   
    //     //return $actions;
    // } 

    // // make sure order id is submitted
    // if ( ! isset( $_POST['order_id'] ) ){
    //     $order_id = intval( $_POST['order_id'] );
    //     $order = wc_get_order( $order_id );
    //     $order->update_status( "completed" );
    //     return $actions;
    // }  
    // if ( isset( $_POST['mark_as_received'] ) == true ) {
    // 	$order_id = intval( $_POST['order_id'] );
    //     $order = wc_get_order( $order_id );
    //     $order->update_status( "completed" );
    // }
    // if ( isset( $_POST['mark_as_not_received'] ) == true ) {
    // 	$order_id = intval( $_POST['order_id'] );
    //     $order = wc_get_order( $order_id );
    //     $order->update_status( "not-received" );
    // }

    // $actions = array(
    //     'pay'    => array(
    //         'url'  => $order->get_checkout_payment_url(),
    //         'name' => __( 'Pay', 'woocommerce' ),
    //     ),
    //     'view'   => array(
    //         'url'  => $order->get_view_order_url(),
    //         'name' => __( 'View', 'woocommerce' ),
    //     ),
    //     'cancel' => array(
    //         'url'  => $order->get_cancel_order_url( wc_get_page_permalink( 'myaccount' ) ),
    //         'name' => __( 'Cancel', 'woocommerce' ),
    //     ),
    // );

    // if ( ! $order->needs_payment() ) {
    //     unset( $actions['pay'] );
    // }

    // if ( ! in_array( $order->get_status(), apply_filters( 'woocommerce_valid_order_statuses_for_cancel', array( 'pending', 'failed' ), $order ), true ) ) {
    //     unset( $actions['cancel'] );
    // }

    // return $actions;

}
add_action('init', 'update_order_status');
function update_order_status(){
  
  
    if ( isset( $_POST['mark_as_received'] ) == true ) {
    	$order_id = intval( $_POST['order_id'] );
        $order = wc_get_order( $order_id );
        $order->update_status( "completed" );
	// JS edit: JS edit: Step 1: Mark as Accepted button on Buyers order view 7/7
        
        WC()->mailer()->emails['WC_Email_Customer_Completed_Order']->trigger($order_id);

        $items = $order->get_items();
        foreach ( $items as $value ) {
            $author = get_post_field( 'post_author', $value->get_product_id() );
        }
        $user_info = get_userdata($author);
        $user_email = $user_info->user_email;
        WC()->mailer()->emails['WC_Email_WKMP_Seller_Order_Completed']->trigger($order_id, $items, $user_email);
        wc_add_notice( esc_html__( 'Order status updated.', 'wk-marketplace' ), 'success' );

    }
    if ( isset( $_POST['mark_as_not_received'] ) == true ) {
    	$order_id = intval( $_POST['order_id'] );
        $order = wc_get_order( $order_id );
        $order->update_status( "not-received" );
        wc_add_notice( esc_html__( 'Order status updated.', 'wk-marketplace' ), 'success' );
       // WC()->mailer()->emails['WC_Email_Customer_not-received_Order']->trigger($order_id);
        echo "<script>window.location.href='https://google.com';</script>";
        exit;
    }
}