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

do_action( 'woocommerce_email_header', $email_heading, $email );

$result = '<p>' . utf8_decode(esc_html__('Hello', 'wk-ohc')).', ' . $admin_email . '</p>
			<p>' . $data['reference_message'] . '</p>
			<p><strong>' . $admin . '</strong>' . $admin_message . '</p>';

if(isset($additional_content) && !empty($additional_content)) {
	$result .= '<p> <strong>' . utf8_decode(esc_html__('Additional Content : ', 'wk-ohc')) . '</strong>' . utf8_decode($additional_content) . '</p>';
}

echo $result;

do_action('woocommerce_email_footer', $email);
