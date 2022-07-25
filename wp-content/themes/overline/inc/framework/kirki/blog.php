<?php

Kirki::add_section(
	'overline_blog',
	array(
		'title'       => esc_html__( 'Blog', 'overline' ),
		'description' => esc_html__( 'Blog Settings', 'overline' ),
		'panel'       => 'overline',
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_blog',
		'settings' => 'post_meta_date',
		'label'    => esc_html__( 'Post Date', 'overline' ),
		'default'  => 1,
	)
);


thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_blog',
		'settings' => 'post_meta_excerpt',
		'label'    => esc_html__( 'Post Excerpt', 'overline' ),
		'default'  => 1,
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_blog',
		'settings' => 'post_meta_cat',
		'label'    => esc_html__( 'Post Category', 'overline' ),
		'default'  => 1,
	)
);
