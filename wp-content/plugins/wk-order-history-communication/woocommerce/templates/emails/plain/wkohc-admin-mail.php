<?php
/**
 * Email templates
 * @package WK Order History Communication
 * @version 1.0.0
*/

defined( 'ABSPATH' ) || exit;


$admin = utf8_decode(esc_html__('Message : ', 'wk-ohc'));
$admin_message = utf8_decode($data['message']);
$reference_message = utf8_decode($data['subject']);

// JS edit: Change Order Hist Comm to seller and customer. Step 11
$result = '<p>' . utf8_decode(esc_html__('Hi ', 'wk-ohc')). $admin_email .', '. '</p>
			<p>' . $data['reference_message'] . '</p>
			<p><strong>' . $admin . '</strong>' . $admin_message . '</p>';

if(isset($additional_content) && !empty($additional_content)) {
	$result .= '<p> <strong>' . utf8_decode(esc_html__('Additional Content : ', 'wk-ohc')) . '</strong>' . utf8_decode($additional_content) . '</p>';
}

echo $result;

echo "\n=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=\n\n";

echo apply_filters( 'woocommerce_email_footer_text', get_option( 'woocommerce_email_footer_text' ) );
