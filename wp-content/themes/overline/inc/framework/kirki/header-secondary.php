<?php
Kirki::add_section(
	'overline_headersecondary',
	array(
		'title'       => esc_html__( 'Header - Secondary Area', 'overline' ),
		'description' => esc_html__( 'Header - Secondary Area Settings', 'overline' ),
		'panel'       => 'overline',
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_headersecondary',
		'settings' => 'header_search',
		'label'    => esc_html__( 'Display Search?', 'overline' ),
		'default'  => 1,
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_headersecondary',
		'settings' => 'header_menu',
		'label'    => esc_html__( 'Display Secondary Menu?', 'overline' ),
		'default'  => 1,
	)
);
