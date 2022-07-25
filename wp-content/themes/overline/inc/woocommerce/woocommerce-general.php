<?php
/**
 * WooCommerce misc functions
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */

if ( ! thb_wc_supported() ) {
	return;
}

// Pagination.
function thb_woocommerce_pagination_args( $defaults ) {
	$defaults['type']      = 'plain';
	$defaults['prev_text'] = esc_html__( 'Prev', 'overline' );
	$defaults['next_text'] = esc_html__( 'Next', 'overline' );

	return $defaults;
}
add_filter( 'woocommerce_pagination_args', 'thb_woocommerce_pagination_args' );

// Remove Hooks.
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10 );
add_action( 'woocommerce_before_shop_loop_item', 'woocommerce_show_product_loop_sale_flash', 10 );
remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

// woocommerce_before_shop_loop_item.
function thb_woocommerce_before_shop_loop_item() {
	$shop_product_hover = thb_customizer( 'shop_product_hover' );
	$shop_product_hover = $shop_product_hover ? 'image' : 'regular';
	?>
	<div class="thb-product-inner-wrapper">
		<figure class="product-thumbnail">
			<?php wc_get_template_part( 'layouts/content-product', $shop_product_hover ); ?>
	<?php
}
add_action( 'woocommerce_before_shop_loop_item', 'thb_woocommerce_before_shop_loop_item', 0 );

// woocommerce_before_shop_loop_item_title.
function thb_woocommerce_before_shop_loop_item_title() {
	?>
		</figure>
	<div class="thb-product-inner-content">
	<?php
}
add_action( 'woocommerce_before_shop_loop_item_title', 'thb_woocommerce_before_shop_loop_item_title', 99 );

// woocommerce_after_shop_loop_item.
function thb_woocommerce_after_shop_loop_item() {
	?>
		</div>
	</div>
	<?php
}
add_action( 'woocommerce_after_shop_loop_item', 'thb_woocommerce_after_shop_loop_item', 99 );

// Add Custom Notice wrapper.
add_action( 'thb_after_main', 'thb_custom_notice', 10 );
function thb_custom_notice() {
	?>
	<div class="thb-woocommerce-notices-wrapper"></div>
	<?php
}

// Add Title with Link.
function thb_template_loop_product_title() {
	global $product;
	$product_url = apply_filters( 'woocommerce_loop_product_link', get_the_permalink(), $product );
	?>
	<h2 class="<?php echo esc_attr( apply_filters( 'woocommerce_product_loop_title_classes', 'woocommerce-loop-product__title' ) ); ?>"><a href="<?php echo esc_url( $product_url ); ?>" title="<?php the_title_attribute(); ?>"><?php the_title(); ?></a></h2>
	<?php
}
add_action( 'woocommerce_shop_loop_item_title', 'thb_template_loop_product_title', 10 );

// Remove Rating Text
function thb_template_loop_product_rating( $html, $rating, $count ) {
	$html = '<span style="width:' . ( ( $rating / 5 ) * 100 ) . '%"></span>';
	return $html;
}
add_filter( 'woocommerce_get_star_rating_html', 'thb_template_loop_product_rating', 5, 3 );

// Breadcrumb Delimiter.
function thb_change_breadcrumb_delimiter( $defaults ) {
	$defaults['delimiter'] = ' <i>/</i> ';
	return $defaults;
}
add_filter( 'woocommerce_breadcrumb_defaults', 'thb_change_breadcrumb_delimiter' );

// Filter just the args for adding a custom data attribute.
add_filter( 'woocommerce_loop_add_to_cart_args', 'thb_filter_woocommerce_loop_add_to_cart_args', 10, 2 );
function thb_filter_woocommerce_loop_add_to_cart_args( $args, $product ) {
	$args['class'] .= ' small';
	return $args;
}

// Product Classes.
function thb_add_product_classes( $classes, $product ) {

	if ( ! is_single() || ( $product->get_id() !== get_queried_object_id() && is_single() ) ) {
		// Settings.
		$columns = thb_translate_columns( wc_get_loop_prop( 'columns' ) );

		$classes[] = 'small-6';
		$classes[] = isset( $columns ) ? $columns : 'medium-6';
		$classes[] = 'columns';
		$classes[] = 'thb-listing-style1';
	}

	return $classes;
}
add_filter( 'woocommerce_post_class', 'thb_add_product_classes', 10, 2 );
