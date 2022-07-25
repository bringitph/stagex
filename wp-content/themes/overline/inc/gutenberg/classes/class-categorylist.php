<?php

namespace FuelThemes;

class CategoryList {

	private $atts;

	/**
	 * Constructor
	 *
	 * @param array $atts
	 */
	public function __construct( $atts ) {
		$this->atts = $atts; // sanitize this if you are going to use it later
	}

	/**
	 * Get Category List
	 *
	 * @param array $request.
	 * @return WP_REST_Response|WP_Error
	 */
	public function get_items() {

		$taxonomy = 'product_cat';
		$args     = array(
			'taxonomy'   => $taxonomy,
			'hide_empty' => true,
			'number'     => 20,
		);

		if ( isset( $this->atts['query'] ) ) {
			$args['name__like'] = esc_sql( $this->atts['query'] );
		}

		return $this->prepare_for_response( get_terms( $args ) );
	}

	/**
	 * Prepare terms for response
	 *
	 * @param Array $cats taxonomy term objects to sort
	 */
	private function prepare_for_response( $cats ) {

		$response = array();

		foreach ( $cats as $term ) {

			$term_arr         = $term->to_array();
			$term_arr['id']   = $term->term_id;
			$term_arr['name'] = $term->name;
			$term_arr['slug'] = $term->slug;

			$response[] = $term_arr; // added
		}

		return $response;
	}

}
