<?php

/** JS edit: whole file is new
* My Account navigation
*
* This template can be overridden by copying it to yourtheme/woocommerce/myaccount/navigation.php.
*
* HOWEVER, on occasion WooCommerce will need to update template files and you
* (the theme developer) will need to copy the new files to your theme to
* maintain compatibility. We try to do this as little as possible, but it does
* happen. When this occurs the version of the template file will be bumped and
* the readme will list any important changes.
*
* @see     https://docs.woocommerce.com/document/template-structure/
* @package WooCommerce\Templates
* @version 2.6.0
*/

if (!defined('ABSPATH')) {
	exit;
}

do_action('woocommerce_before_account_navigation');
?>

<nav class="woocommerce-MyAccount-navigation">
	<p style="font-size:20px; color:#eb9a72"><strong><a href="#" class="customer_menu">As Buyer <span style="float:none"><i class="thb-icon-right-open-mini"></i></span></a></strong></p>
	<?php $user = wp_get_current_user();
	$roles = $user->roles;
	?>
	<ul class="customer">
		<!-- <?php foreach (wc_get_account_menu_items() as $endpoint => $label) : ?>
			<li class="<?php echo wc_get_account_menu_item_classes($endpoint); ?>">
				<a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
			</li>
		<?php endforeach; ?> -->
		<li class="<?php echo esc_attr(wc_get_account_menu_item_classes('rfq')); ?>">
			<a href="<?php echo site_url(); ?>/my-account/rfq/">Quotations</a>
		</li>
		<li class="<?php echo esc_attr(wc_get_account_menu_item_classes('orders')); ?>">
			<a href="<?php echo site_url(); ?>/my-account/orders/">My Orders</a>
		</li>
		<li class="<?php echo esc_attr(wc_get_account_menu_item_classes('favourite-seller')); ?>">
			<a href="<?php echo site_url(); ?>/my-account/favourite-seller/">My Favorite Seller</a>
		</li>
		<li class="woocommerce-MyAccount-navigation-link">
			<a href="/submit-your-payment">Submit your Payment</a>
		</li>
		<li class="<?php echo esc_attr(wc_get_account_menu_item_classes('edit-account')); ?>">
			<a href="<?php //echo site_url(); ?>/my-account/edit-account/">Account Details</a>
		</li>
	</ul>
	<?php if (in_array('wk_marketplace_seller', $roles)) { ?>

		<p style="font-size:20px; color:#eb9a72"><strong><a href="#" class="seller_menu">As Seller <span style="float:none"><i class="thb-icon-right-open-mini"></i></span></a></strong></p>
		<!-- Sharmatech -->
		<ul class="wkmp-account-nav wkmp-nav-vertical">
			<li class="<?php echo esc_attr(wc_get_account_menu_item_classes('../seller/manage-rfq')); ?>">
				<a href="<?php echo site_url('seller/manage-rfq'); ?>">Manage RFQ</a>
			</li>
			<?php foreach (wc_get_account_menu_items() as $endpoint => $label) : if($label == 'Manage RFQ' || $label == 'Logout') continue; ?>
				<li class="<?php echo esc_attr(wc_get_account_menu_item_classes($endpoint)); ?>">
					<a href="<?php echo esc_url(wc_get_account_endpoint_url($endpoint)); ?>"><?php echo esc_html($label); ?></a>
				</li>
			<?php endforeach; ?>
			<li class="woocommerce-MyAccount-navigation-link">
				<a href="/failed-meetup">Report Failed Meetup</a>
			</li>
		</ul>
	<?php } ?>

	<!--<p style="margin-top:1rem"><a href="<?php //echo wp_logout_url(); ?>">Logout</a></p>-->

</nav>

<?php do_action('woocommerce_after_account_navigation'); ?>

