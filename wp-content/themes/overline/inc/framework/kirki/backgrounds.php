<?php

Kirki::add_section(
	'overline_background',
	array(
		'title'       => esc_html__( 'Backgrounds', 'overline' ),
		'description' => esc_html__( 'Background settings', 'overline' ),
		'panel'       => 'overline',
	)
);
thb_customizer_field(
	array(
		'type'      => 'background',
		'section'   => 'overline_background',
		'settings'  => 'subheader_background',
		'label'     => esc_html__( 'Sub-Header Background', 'overline' ),
		'transport' => 'auto',
		'output'    => array(
			array(
				'element' => '.subheader',
			),
		),
	)
);
thb_customizer_field(
	array(
		'type'      => 'background',
		'section'   => 'overline_background',
		'settings'  => 'header_background',
		'label'     => esc_html__( 'Header Background', 'overline' ),
		'transport' => 'auto',
		'output'    => array(
			array(
				'element' => '.header .header-logo-row',
			),
		),
	)
);
thb_customizer_field(
	array(
		'type'      => 'background',
		'section'   => 'overline_background',
		'settings'  => 'footer_background',
		'label'     => esc_html__( 'Footer Background', 'overline' ),
		'transport' => 'auto',
		'output'    => array(
			array(
				'element' => '#footer',
			),
		),
	)
);
thb_customizer_field(
	array(
		'type'      => 'background',
		'section'   => 'overline_background',
		'settings'  => 'subfooter_background',
		'label'     => esc_html__( 'Sub-Footer Background', 'overline' ),
		'transport' => 'auto',
		'output'    => array(
			array(
				'element' => '.subfooter',
			),
		),
	)
);
