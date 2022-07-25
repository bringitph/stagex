<?php

Kirki::add_section(
	'overline_article',
	array(
		'title'       => esc_html__( 'Article', 'overline' ),
		'description' => esc_html__( 'Article Settings', 'overline' ),
		'panel'       => 'overline',
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_article',
		'settings' => 'article_author_name',
		'label'    => esc_html__( 'Author Name', 'overline' ),
		'default'  => 1,
	)
);


thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_article',
		'settings' => 'article_date',
		'label'    => esc_html__( 'Article Date', 'overline' ),
		'default'  => 1,
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_article',
		'settings' => 'article_cat',
		'label'    => esc_html__( 'Article Category', 'overline' ),
		'default'  => 1,
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_article',
		'settings' => 'article_nav',
		'label'    => esc_html__( 'Article Navigation', 'overline' ),
		'default'  => 1,
	)
);

thb_customizer_field(
	array(
		'type'     => 'switch',
		'section'  => 'overline_article',
		'settings' => 'article_tags',
		'label'    => esc_html__( 'Article Tags', 'overline' ),
		'default'  => 1,
	)
);
