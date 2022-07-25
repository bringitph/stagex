<?php
/**
 * WooCommerce Checkout related functions
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */

if ( ! thb_wc_supported() ) {
	return;
}
if ( is_admin() ) {
	return;
}
/* Checkout */
function thb_checkout_before_customer_details() {
	echo '<div class="row"><div class="small-12 large-8 columns thb-checkout-form-column">';
}
add_action(
	'woocommerce_checkout_before_customer_details',
	'thb_checkout_before_customer_details',
	5
);

function thb_checkout_after_customer_details() {
	echo '</div><div class="small-12 large-4 columns thb-checkout-review-column">';
	echo '<div class="thb-fixed">';
}
add_action(
	'woocommerce_checkout_after_customer_details',
	'thb_checkout_after_customer_details',
	30
);

function thb_checkout_after_order_review() {
	echo '</div>'; // .thb-fixed
	echo '</div></div>';
}
add_action(
	'woocommerce_checkout_after_order_review',
	'thb_checkout_after_order_review',
	30
);
