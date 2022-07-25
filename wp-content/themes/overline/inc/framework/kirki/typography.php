<?php
Kirki::add_section(
	'overline_typography',
	array(
		'title'       => esc_html__( 'Typography', 'overline' ),
		'description' => esc_html__( 'Typography Settings', 'overline' ),
		'panel'       => 'overline',
	)
);

thb_customizer_field(
	array(
		'type'        => 'typography',
		'section'     => 'overline_typography',
		'settings'    => 'primary_typography',
		'label'       => esc_html__( 'Primary Font', 'overline' ),
		'description' => esc_html__( 'Changes primarily heading tags', 'overline' ),
		'default'     => array(
			'font-family' => 'Jost',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => 'h1,h2,h3,h4,h5,h6,.thb-full-menu,.subheader,.wp-block-latest-posts.is-grid a,.wp-block-button__link,.btn,.button',
			),
			array(
				'context' => array( 'editor' ),
			),
		),
	)
);
thb_customizer_field(
	array(
		'type'        => 'typography',
		'section'     => 'overline_typography',
		'settings'    => 'secondary_typography',
		'label'       => esc_html__( 'Secondary Font', 'overline' ),
		'description' => esc_html__( 'Changes primarily body text', 'overline' ),
		'default'     => array(
			'font-family' => 'Jost',
		),
		'transport'   => 'auto',
		'output'      => array(
			array(
				'element' => 'body',
			),
			array(
				'context' => array( 'editor' ),
			),
		),
	)
);
