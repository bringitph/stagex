<?php
/**
 * WooCommerce Category related functions
 *
 * @package WordPress
 * @subpackage overline
 * @since 1.0
 * @version 1.0
 */

if ( ! thb_wc_supported() ) {
	return;
}
/* Change Category Thumbnail Size */
function thb_template_loop_category_link_open( $category ) {
	echo '<a href="' . esc_url( get_term_link( $category, 'product_cat' ) ) . '" class="thb-category-link">';
}
remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
add_action( 'woocommerce_before_subcategory', 'thb_template_loop_category_link_open', 0 );


// Product Category Classes.
function thb_add_product_cat_classes( $classes ) {
	$columns = thb_translate_columns( wc_get_loop_prop( 'columns' ) );

	$classes[] = 'small-6';
	$classes[] = isset( $columns ) ? $columns : 'medium-6';
	$classes[] = 'columns';
	$classes[] = 'thb-category-style1';

	return $classes;
}
add_filter( 'product_cat_class', 'thb_add_product_cat_classes' );

// woocommerce_before_subcategory.
function thb_woocommerce_before_subcategory() {
	?>
	<div class="thb-product-category-image">
	<?php
}
add_action( 'woocommerce_before_subcategory', 'thb_woocommerce_before_subcategory', 5 );

// woocommerce_before_subcategory_title.
function thb_woocommerce_before_subcategory_title() {
	?>
	</div>
	<?php
}
add_action( 'woocommerce_before_subcategory_title', 'thb_woocommerce_before_subcategory_title', 99 );
