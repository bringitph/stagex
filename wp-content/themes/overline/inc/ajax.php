<?php
/**
 * AJAX functions
 *
 * @package WordPress
 * @subpackage fifthavenue
 * @since 1.0
 * @version 1.0
 */

// Ajax Search.
function thb_ajax_search() {
	check_ajax_referer( 'thb_autocomplete_ajax', 'security' );
	$search_keyword              = filter_input( INPUT_GET, 'query', FILTER_SANITIZE_STRING );
	$time_start                  = microtime( true );
	$product_visibility_term_ids = wc_get_product_visibility_term_ids();
	$ordering_args               = WC()->query->get_catalog_ordering_args( 'title', 'asc' );
	$suggestions                 = array();

	$args = array(
		's'                   => $search_keyword,
		'post_type'           => 'product',
		'post_status'         => 'publish',
		'ignore_sticky_posts' => 1,
		'posts_per_page'      => 3,
		'orderby'             => $ordering_args['orderby'],
		'order'               => $ordering_args['order'],
		'suppress_filters'    => false,
		'tax_query'           => array(
			array(
				'taxonomy' => 'product_visibility',
				'field'    => 'term_taxonomy_id',
				'terms'    => $product_visibility_term_ids['exclude-from-search'],
				'operator' => 'NOT IN',
			),
		),
	);

	$products = get_posts( $args );

	if ( ! empty( $products ) ) {
		foreach ( $products as $post ) {
			$product = wc_get_product( $post );

			$suggestions[] = array(
				'id'        => $product->get_id(),
				'value'     => wp_strip_all_tags( $product->get_title() ),
				'url'       => $product->get_permalink(),
				'thumbnail' => $product->get_image(),
				'price'     => $product->get_price_html(),
			);
		}
	} else {
		$suggestions = false;
	}

	$time_end    = microtime( true );
	$time        = $time_end - $time_start;
	$suggestions = array(
		'suggestions' => $suggestions,
		'time'        => $time,
	);
	echo wp_json_encode( $suggestions );
	wp_die();
}
add_action( 'wp_ajax_nopriv_thb_ajax_search', 'thb_ajax_search' );
add_action( 'wp_ajax_thb_ajax_search', 'thb_ajax_search' );
