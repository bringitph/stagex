<?php

Kirki::add_section(
	'overline_colors',
	array(
		'title'       => esc_html__( 'Color', 'overline' ),
		'description' => esc_html__( 'Color Settings', 'overline' ),
		'panel'       => 'overline',
	)
);

thb_customizer_field(
	array(
		'type'     => 'color',
		'section'  => 'overline_colors',
		'settings' => 'accent_color',
		'label'    => esc_html__( 'Accent Color', 'overline' ),
		'output'   => array(
			array(
				'element'  => 'a:hover, .widget ul a:hover, .thb-full-menu > .menu-item > a:hover, .thb-full-menu .menu-item.current-menu-item>a, .products .product .woocommerce-loop-product__title a:hover, .wc-block-grid__products .product .woocommerce-loop-product__title a:hover, .woocommerce-terms-and-conditions-wrapper .woocommerce-privacy-policy-text a, .woocommerce-account .woocommerce-MyAccount-navigation .is-active a, .thb-full-menu .sub-menu li a:hover',
				'property' => 'color',
			),
			array(
				'element'  => '.products .product-category .thb-category-link:hover, .pagination .page-numbers.current, .woocommerce-pagination .page-numbers.current, input[type="submit"].accent, input[type="submit"].alt, .button.accent, .button.alt, .btn.accent, .btn.alt, .pushbutton-wide.accent, .pushbutton-wide.alt',
				'property' => 'background-color',
			),
		),
		'choices'  => array(
			'alpha' => true,
		),
	)
);
