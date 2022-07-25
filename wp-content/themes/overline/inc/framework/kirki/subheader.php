<?php
Kirki::add_section(
	'overline_subheader',
	array(
		'title'       => esc_html__( 'Sub-Header', 'overline' ),
		'description' => esc_html__( 'Sub-Header Settings', 'overline' ),
		'panel'       => 'overline',
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_subheader',
		'settings' => 'subheader',
		'label'    => esc_html__( 'Display Sub-Header?', 'overline' ),
		'default'  => 1,
	)
);

thb_customizer_field(
	array(
		'type'              => 'text',
		'section'           => 'overline_subheader',
		'settings'          => 'subheader_content',
		'label'             => esc_html__( 'Sub-Header Text', 'overline' ),
		'default'           => wp_kses_post( 'Free Tracked Shipping Worldwide On Orders Over $30' ),
		'sanitize_callback' => 'wp_kses_post',
	)
);
