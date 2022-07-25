<?php

Kirki::add_section(
	'overline_shop',
	array(
		'title'       => esc_html__( 'Shop', 'overline' ),
		'description' => esc_html__( 'Shop Settings', 'overline' ),
		'panel'       => 'overline',
	)
);
thb_customizer_field(
	array(
		'type'        => 'switch',
		'section'     => 'overline_shop',
		'settings'    => 'shop_product_hover',
		'label'       => esc_html__( 'Show Hover Image?', 'overline' ),
		'description' => esc_html__( 'When enabled, products will show a second image on hover. Does not work on Gutenberg elements.', 'overline' ),
		'default'     => 1,
	)
);
thb_customizer_field(
	array(
		'type'              => 'textarea',
		'section'           => 'overline_shop',
		'settings'          => 'shop_description',
		'label'             => esc_html__( 'Shop Description', 'overline' ),
		'description'       => esc_html__( 'Displays on main shop page, similar to product category descriptions.', 'overline' ),
		'sanitize_callback' => 'wp_kses_post',
	)
);

thb_customizer_field(
	array(
		'type'        => 'switch',
		'section'     => 'overline_shop',
		'settings'    => 'single_product_ajax',
		'label'       => esc_html__( 'Single Product Ajax', 'overline' ),
		'description' => esc_html__( 'When enabled, add to cart functionality will use AJAX on single product pages.', 'overline' ),
		'default'     => 1,
	)
);
