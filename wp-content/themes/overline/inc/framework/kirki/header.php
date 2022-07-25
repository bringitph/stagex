<?php
Kirki::add_section(
	'overline_header',
	array(
		'title'       => esc_html__( 'Header', 'overline' ),
		'description' => esc_html__( 'Header Section Settings', 'overline' ),
		'panel'       => 'overline',
	)
);
thb_customizer_field(
	array(
		'type'     => 'dimension',
		'section'  => 'overline_header',
		'settings' => 'logo_height',
		'label'    => esc_html__( 'Logo Height', 'overline' ),
		'default'  => '16px',
	)
);

thb_customizer_field(
	array(
		'type'     => 'dimension',
		'section'  => 'overline_header',
		'settings' => 'logo_height_mobile',
		'label'    => esc_html__( 'Logo Height - Mobile', 'overline' ),
		'default'  => '16px',
	)
);

thb_customizer_field(
	array(
		'type'     => 'select',
		'section'  => 'overline_header',
		'settings' => 'fixed_header_shadow',
		'label'    => esc_html__( 'Fixed Header - Shadow', 'overline' ),
		'default'  => 'thb-fixed-shadow-style1',
		'multiple' => 0,
		'choices'  => array(
			'thb-fixed-noshadow'      => 'None',
			'thb-fixed-shadow-style1' => 'Small',
			'thb-fixed-shadow-style2' => 'Medium',
			'thb-fixed-shadow-style3' => 'Large',
		),
	)
);
