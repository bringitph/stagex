<?php

Kirki::add_section(
	'overline_mobilemenu',
	array(
		'title'       => esc_html__( 'Mobile Menu', 'overline' ),
		'description' => esc_html__( 'Mobile Menu Settings', 'overline' ),
		'panel'       => 'overline',
	)
);

thb_customizer_field(
	array(
		'type'     => 'editor',
		'section'  => 'overline_mobilemenu',
		'settings' => 'mobile_menu_footer',
		'label'    => esc_html__( 'Mobile Menu Footer Content', 'overline' ),
	)
);
