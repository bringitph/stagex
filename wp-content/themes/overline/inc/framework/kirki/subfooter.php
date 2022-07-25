<?php

Kirki::add_section(
	'overline_subfooter',
	array(
		'title'       => esc_html__( 'Sub-Footer', 'overline' ),
		'description' => esc_html__( 'Sub-Footer Settings', 'overline' ),
		'panel'       => 'overline',
	)
);
thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_subfooter',
		'settings' => 'subfooter',
		'label'    => esc_html__( 'Display Sub-Footer?', 'overline' ),
		'default'  => 1,
	)
);
thb_customizer_field(
	array(
		'type'              => 'text',
		'section'           => 'overline_subfooter',
		'settings'          => 'copyright_text',
		'label'             => esc_html__( 'Copyright Text', 'overline' ),
		'default'           => wp_kses_post( '© 2020 <a href="https://fuelthemes.net" target="_blank" title="Premium WordPress Themes">Premium WordPress Themes</a>' ),
		'sanitize_callback' => 'wp_kses_post',
	)
);
thb_customizer_field(
	array(
		'type'         => 'repeater',
		'section'      => 'overline_subfooter',
		'label'        => esc_html__( 'Payment Icons', 'overline' ),
		'row_label'    => array(
			'type'  => 'text',
			'value' => esc_html__( 'Payment Icon', 'overline' ),
		),
		'button_label' => esc_html__( 'Add New Payment Icon', 'overline' ),
		'settings'     => 'payment_type',
		'fields'       => array(
			'link_icon' => array(
				'type'        => 'select',
				'label'       => esc_html__( 'Payment Icon', 'overline' ),
				'default'     => '',
				'placeholder' => esc_html__( 'Select an option...', 'overline' ),
				'priority'    => 10,
				'choices'     => thb_payment_icons_array(),
			),
		),
		'default'      => array(),
	)
);
