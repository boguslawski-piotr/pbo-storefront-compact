<?php

/**
 *
 */

add_action( 'customize_register', 'pbosfc_customize_register', 20 );

function pbosfc_customize_register( $wp_customize ) {
	/**
	 * Logo or title.
	 */

	$wp_customize->remove_control( 'storefront_logo_heading' );
	$wp_customize->remove_control( 'storefront_logo_info' );
	$wp_customize->remove_control( 'storefront_logo_divider_after' );

	$wp_customize->add_setting( 'pbosfc_site_logo', array(
		'default' => pbosfc_get_option_def( 'site_logo' ),
	) );
	$wp_customize->add_control( 'pbosfc_site_logo', [
		'section'  => 'header_image',
		'type'     => 'checkbox',
		'label'    => __( 'Use logo image', 'pbosfc' ),
		'settings' => 'pbosfc_site_logo',
		'priority' => 1,
	] );

	$wp_customize->add_setting( 'pbosfc_site_logo_image', array(
		'default' => pbosfc_get_option_def( 'site_logo_image' ),
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pbosfc_site_logo_image', array(
		'section'  => 'header_image',
		'label'    => __( 'Image', 'pbosfc' ),
		'settings' => 'pbosfc_site_logo_image',
		'priority' => 2,
	) ) );

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_l1', array(
		'section'  => 'header_image',
		'type'     => 'divider',
		'priority' => 3,
	) ) );

	/**
	 * Colors for header (background, title, search, cart, etc.)
	 */

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_h0', array(
		'section'  => 'header_image',
		'type'     => 'divider',
		'priority' => 11,
	) ) );

	// TODO: wykorzystac wszedzie gdzie sie da: transport = 'postMessage'

	$wp_customize->get_setting( 'storefront_header_background_color' )->transport = '';
	$wp_customize->get_setting( 'storefront_header_link_color' )->transport       = '';
	$wp_customize->get_setting( 'storefront_header_text_color' )->transport       = '';

	$wp_customize->add_setting( 'pbosfc_site_title_link_color', array(
		'default'           => pbosfc_get_option_def( 'site_title_link_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_title_link_color', array(
		'label'    => __( 'Site Title color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_title_link_color',
		'priority' => 16,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_title_text_color', array(
		'default'           => pbosfc_get_option_def( 'site_title_text_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_title_text_color', array(
		'label'    => __( 'Tagline color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_title_text_color',
		'priority' => 16,
	) ) );

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_h1', array(
		'section'  => 'header_image',
		'type'     => 'divider',
		'priority' => 35,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_header_search_background_color', array(
		'default'           => pbosfc_get_option_def( 'site_header_search_background_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_header_search_background_color', array(
		'label'    => __( 'Search box background color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_header_search_background_color',
		'priority' => 60,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_header_search_text_color', array(
		'default'           => pbosfc_get_option_def( 'site_header_search_text_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_header_search_text_color', array(
		'label'    => __( 'Search box text color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_header_search_text_color',
		'priority' => 70,
	) ) );

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_h2', array(
		'section'  => 'header_image',
		'type'     => 'divider',
		'priority' => 75,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_header_cart_background_color', array(
		'default'           => pbosfc_get_option_def( 'site_header_cart_background_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_header_cart_background_color', array(
		'label'    => __( 'Mini Cart background color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_header_cart_background_color',
		'priority' => 80,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_header_cart_link_color', array(
		'default'           => pbosfc_get_option_def( 'site_header_cart_link_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_header_cart_link_color', array(
		'label'    => __( 'Mini Cart text color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_header_cart_link_color',
		'priority' => 90,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_header_cart_content_background_color', array(
		'default'           => pbosfc_get_option_def( 'site_header_cart_content_background_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_header_cart_content_background_color', array(
		'label'    => __( 'Mini Cart content background color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_header_cart_content_background_color',
		'priority' => 100,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_header_cart_content_link_color', array(
		'default'           => pbosfc_get_option_def( 'site_header_cart_content_link_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_header_cart_content_link_color', array(
		'label'    => __( 'Mini Cart content link color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_header_cart_content_link_color',
		'priority' => 110,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_header_cart_content_text_color', array(
		'default'           => pbosfc_get_option_def( 'site_header_cart_content_text_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_header_cart_content_text_color', array(
		'label'    => __( 'Mini Cart content text color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_header_cart_content_text_color',
		'priority' => 120,
	) ) );

	/**
	 * Menu(s)
	 */

	$wp_customize->get_section( 'storefront_layout' )->priority = 29;
	$wp_customize->get_panel( 'nav_menus' )->priority           = 34;

	$wp_customize->add_section( 'pbosfc_menus', array(
		'title'       => __( 'Menu Sizes, Alignments, Colors', 'pbosfc' ),
		'description' => __( '', 'pbosfc' ), // TODO: opis dla ustawien Menu
		'panel'       => 'nav_menus',
		'priority'    => 1,
	) );

	$wp_customize->add_setting( 'pbosfc_top_menu_background_color', array(
		'default'           => pbosfc_get_option_def( 'top_menu_background_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_top_menu_background_color', array(
		'label'    => __( 'Top Menu background color', 'pbosfc' ),
		'section'  => 'pbosfc_menus',
		'settings' => 'pbosfc_top_menu_background_color',
	) ) );

	$wp_customize->add_setting( 'pbosfc_top_menu_1level_link_color', array(
		'default'           => pbosfc_get_option_def( 'top_menu_1level_link_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_top_menu_1level_link_color', array(
		'label'    => __( 'Top Menu link color', 'pbosfc' ),
		'section'  => 'pbosfc_menus',
		'settings' => 'pbosfc_top_menu_1level_link_color',
	) ) );

	$wp_customize->add_setting( 'pbosfc_left_top_menu_width', array(
		'default' => pbosfc_get_option_def( 'left_top_menu_width' ),
	) );
	$wp_customize->add_control( 'pbosfc_left_top_menu_width', [
		'section'     => 'pbosfc_menus',
		'type'        => 'number',
		'label'       => __( 'Left Top Menu width (in %)', 'pbosfc' ),
		'settings'    => 'pbosfc_left_top_menu_width',
		'input_attrs' => array(
			'style' => 'width: 5em',
			'min'   => '0',
			'max'   => '100',
		),
	] );

	$wp_customize->add_setting( 'pbosfc_left_top_menu_align', array(
		'default' => pbosfc_get_option_def( 'left_top_menu_align' ),
	) );
	$wp_customize->add_control( 'pbosfc_left_top_menu_align', [
		'section'  => 'pbosfc_menus',
		'type'     => 'select',
		'choices'  => [ 'left' => __( 'Left', 'pbosfc' ), 'right' => __( 'Right', 'pbosfc' ) ],
		'label'    => __( 'Left Top Menu alignment', 'pbosfc' ),
		'settings' => 'pbosfc_left_top_menu_align',
	] );

	$wp_customize->add_setting( 'pbosfc_right_top_menu_width', array(
		'default' => pbosfc_get_option_def( 'right_top_menu_width' ),
	) );
	$wp_customize->add_control( 'pbosfc_right_top_menu_width', [
		'section'     => 'pbosfc_menus',
		'type'        => 'number',
		'label'       => __( 'Right Top Menu width (in %)', 'pbosfc' ),
		'settings'    => 'pbosfc_right_top_menu_width',
		'input_attrs' => array(
			'style' => 'width: 5em',
			'min'   => '0',
			'max'   => '100',
		),
	] );

	$wp_customize->add_setting( 'pbosfc_right_top_menu_align', array(
		'default' => pbosfc_get_option_def( 'right_top_menu_align' ),
	) );
	$wp_customize->add_control( 'pbosfc_right_top_menu_align', [
		'section'  => 'pbosfc_menus',
		'type'     => 'select',
		'choices'  => [ 'left' => __( 'Left', 'pbosfc' ), 'right' => __( 'Right', 'pbosfc' ) ],
		'label'    => __( 'Right Top Menu alignment', 'pbosfc' ),
		'settings' => 'pbosfc_right_top_menu_align',
	] );

	/**
	 * Content
	 */

	$wp_customize->get_section( 'storefront_typography' )->title = __( 'Content', 'pbosfc' );
	$wp_customize->get_section( 'storefront_typography' )->priority = 39;

	// colors

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_c0', array(
		'section'  => 'storefront_typography',
		'type'     => 'divider',
		'priority' => 50,
	) ) );

	$wp_customize->add_setting( 'pbosfc_onsale_sign_background_color', array(
		'default'           => pbosfc_get_option_def( 'onsale_sign_background_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_onsale_sign_background_color', array(
		'label'    => __( 'Sale! sign background color', 'pbosfc' ),
		'section'  => 'storefront_typography',
		'settings' => 'pbosfc_onsale_sign_background_color',
		'priority' => 60,
	) ) );

	$wp_customize->add_setting( 'pbosfc_onsale_sign_border_color', array(
		'default'           => pbosfc_get_option_def( 'onsale_sign_border_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_onsale_sign_border_color', array(
		'label'    => __( 'Sale! sign border color', 'pbosfc' ),
		'section'  => 'storefront_typography',
		'settings' => 'pbosfc_onsale_sign_border_color',
		'priority' => 70,
	) ) );

	$wp_customize->add_setting( 'pbosfc_onsale_sign_text_color', array(
		'default'           => pbosfc_get_option_def( 'onsale_sign_text_color' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_onsale_sign_text_color', array(
		'label'    => __( 'Sale! sign text color', 'pbosfc' ),
		'section'  => 'storefront_typography',
		'settings' => 'pbosfc_onsale_sign_text_color',
		'priority' => 80,
	) ) );

	// excerpts

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_c1', array(
		'section'  => 'storefront_typography',
		'type'     => 'divider',
		'priority' => 100,
	) ) );

	$wp_customize->add_setting( 'pbosfc_post_excerpt', array(
		'default' => pbosfc_get_option_def( 'post_excerpt' ),
	) );
	$wp_customize->add_control( 'pbosfc_post_excerpt', [
		'section'     => 'storefront_typography',
		'type'        => 'checkbox',
		'label'       => __( 'Use excerpts', 'pbosfc' ),
		'description' => __( 'When checked displays post excertps on archive and search results pages.', 'pbosfc' ),
		'settings'    => 'pbosfc_post_excerpt',
		'priority' => 110,
	] );

	$wp_customize->add_setting( 'pbosfc_excerpt_word_count', array(
		'default' => pbosfc_get_option_def( 'excerpt_word_count' ),
	) );
	$wp_customize->add_control( 'pbosfc_excerpt_word_count', [
		'section'     => 'storefront_typography',
		'type'        => 'number',
		'label'       => __( 'How many words in excerpt', 'pbosfc' ),
		'settings'    => 'pbosfc_excerpt_word_count',
		'input_attrs' => array(
			'style' => 'width: 5em',
		),
		'priority' => 120,
	] );

	$wp_customize->add_setting( 'pbosfc_excerpt_image_size', array(
		'default' => pbosfc_get_option_def( 'excerpt_image_size' ),
	) );
	$wp_customize->add_control( 'pbosfc_excerpt_image_size', [
		'section'  => 'storefront_typography',
		'type'     => 'select',
		'choices'  => [
			'none'      => __( 'No image', 'pbosfc' ),
			'thumbnail' => __( 'Thumbnail', 'pbosfc' ),
			'medium'    => __( 'Medium size', 'pbosfc' ),
			'full'      => __( 'Full size', 'pbosfc' ),
		],
		'label'    => __( 'Featured image size on excerpts', 'pbosfc' ),
		'settings' => 'pbosfc_excerpt_image_size',
		'priority' => 130,
	] );

	$wp_customize->add_setting( 'pbosfc_excerpt_image_float', array(
		'default' => pbosfc_get_option_def( 'excerpt_image_float' ),
	) );
	$wp_customize->add_control( 'pbosfc_excerpt_image_float', [
		'section'  => 'storefront_typography',
		'type'     => 'select',
		'choices'  => [ 'alignleft' => __( 'Left', 'pbosfc' ), 'alignright' => __( 'Right', 'pbosfc' ) ],
		'label'    => __( 'Excerpt thumbnail alignment', 'pbosfc' ),
		'settings' => 'pbosfc_excerpt_image_float',
		'priority' => 140,
	] );

	// featured images

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_c2', array(
		'section'  => 'storefront_typography',
		'type'     => 'divider',
		'priority' => 200,
	) ) );

	$wp_customize->add_setting( 'pbosfc_page_featured_image_size', array(
		'default' => pbosfc_get_option_def( 'page_featured_image_size' ),
	) );
	$wp_customize->add_control( 'pbosfc_page_featured_image_size', [
		'section'  => 'storefront_typography',
		'type'     => 'select',
		'choices'  => [
			'none'      => __( 'No image', 'pbosfc' ),
			'thumbnail' => __( 'Thumbnail', 'pbosfc' ),
			'medium'    => __( 'Medium size', 'pbosfc' ),
			'full'      => __( 'Full size', 'pbosfc' ),
		],
		'label'    => __( 'Featured image size for pages', 'pbosfc' ),
		'settings' => 'pbosfc_page_featured_image_size',
		'priority' => 210,
	] );

	$wp_customize->add_setting( 'pbosfc_post_featured_image_size', array(
		'default' => pbosfc_get_option_def( 'post_featured_image_size' ),
	) );
	$wp_customize->add_control( 'pbosfc_post_featured_image_size', [
		'section'  => 'storefront_typography',
		'type'     => 'select',
		'choices'  => [
			'none'      => __( 'No image', 'pbosfc' ),
			'thumbnail' => __( 'Thumbnail', 'pbosfc' ),
			'medium'    => __( 'Medium size', 'pbosfc' ),
			'full'      => __( 'Full size', 'pbosfc' ),
		],
		'label'    => __( 'Featured image size for posts', 'pbosfc' ),
		'settings' => 'pbosfc_post_featured_image_size',
		'priority' => 220,
	] );

	// breadcrumbs

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_c3', array(
		'section'  => 'storefront_typography',
		'type'     => 'divider',
		'priority' => 230,
	) ) );

	$wp_customize->add_setting( 'pbosfc_page_breadcrumb', array(
		'default' => pbosfc_get_option_def( 'page_breadcrumb' ),
	) );
	$wp_customize->add_control( 'pbosfc_page_breadcrumb', [
		'section'     => 'storefront_typography',
		'type'        => 'checkbox',
		'label'       => __( 'Breadcrumb on pages', 'pbosfc' ),
		'settings'    => 'pbosfc_page_breadcrumb',
		'priority' => 240,
	] );

	$wp_customize->add_setting( 'pbosfc_post_breadcrumb', array(
		'default' => pbosfc_get_option_def( 'post_breadcrumb' ),
	) );
	$wp_customize->add_control( 'pbosfc_post_breadcrumb', [
		'section'     => 'storefront_typography',
		'type'        => 'checkbox',
		'label'       => __( 'Breadcrumb on posts', 'pbosfc' ),
		'settings'    => 'pbosfc_post_breadcrumb',
		'priority' => 250,
	] );

	$wp_customize->add_setting( 'pbosfc_product_breadcrumb', array(
		'default' => pbosfc_get_option_def( 'product_breadcrumb' ),
	) );
	$wp_customize->add_control( 'pbosfc_product_breadcrumb', [
		'section'     => 'storefront_typography',
		'type'        => 'checkbox',
		'label'       => __( 'Breadcrumb on shop pages', 'pbosfc' ),
		'settings'    => 'pbosfc_product_breadcrumb',
		'priority' => 260,
	] );

	/**
	 * Functionality
	 */

	$wp_customize->add_section( 'pbosfc', array(
		'title'    => __( 'Functionality', 'pbosfc' ),
		'priority' => 21,
	) );

	// products (add to cart buttons, per page, columns, etc.)

	$wp_customize->add_setting( 'pbosfc_add_to_cart_on_product_list', array(
		'default' => pbosfc_get_option_def( 'add_to_cart_on_product_list' ),
	) );
	$wp_customize->add_control( 'pbosfc_add_to_cart_on_product_list', [
		'section'     => 'pbosfc',
		'type'        => 'checkbox',
		'label'       => __( 'Enable Add To Cart button on lists', 'pbosfc' ),
		'description' => __( '', 'pbosfc' ), // TODO: opis opcji add_to_cart_on_product_list
		'settings'    => 'pbosfc_add_to_cart_on_product_list'
	] );

	$wp_customize->add_setting( 'pbosfc_add_to_cart_with_quantity_on_product_list', array(
		'default' => pbosfc_get_option_def( 'add_to_cart_with_quantity_on_product_list' ),
	) );
	$wp_customize->add_control( 'pbosfc_add_to_cart_with_quantity_on_product_list', [
		'section'     => 'pbosfc',
		'type'        => 'checkbox',
		'label'       => __( 'Enable Quantity field on lists', 'pbosfc' ),
		'description' => __( '', 'pbosfc' ), // TODO: opis opcji add_to_cart_with_quantity_on_product_list
		'settings'    => 'pbosfc_add_to_cart_with_quantity_on_product_list'
	] );

	$wp_customize->add_setting( 'pbosfc_products_per_page', array(
		'default' => pbosfc_get_option_def( 'products_per_page' ),
	) );
	$wp_customize->add_control( 'pbosfc_products_per_page', [
		'section'     => 'pbosfc',
		'type'        => 'number',
		'label'       => __( 'How many products per page', 'pbosfc' ),
		'settings'    => 'pbosfc_products_per_page',
		'input_attrs' => array(
			'style' => 'width: 5em',
		),
	] );

	$wp_customize->add_setting( 'pbosfc_product_columns', array(
		'default' => pbosfc_get_option_def( 'product_columns' ),
	) );
	$wp_customize->add_control( 'pbosfc_product_columns', [
		'section'     => 'pbosfc',
		'type'        => 'number',
		'label'       => __( 'How many product columns', 'pbosfc' ),
		'settings'    => 'pbosfc_product_columns',
		'input_attrs' => array(
			'style' => 'width: 5em',
		),
	] );


	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_2', array(
		'section' => 'pbosfc',
		'type'    => 'divider',
	) ) );

	// posts per page

	$wp_customize->add_setting( 'pbosfc_posts_per_page', array(
		'default' => pbosfc_get_option_def( 'posts_per_page' ),
	) );
	$wp_customize->add_control( 'pbosfc_posts_per_page', [
		'section'     => 'pbosfc',
		'type'        => 'number',
		'label'       => __( 'How many posts per page', 'pbosfc' ),
		'settings'    => 'pbosfc_posts_per_page',
		'input_attrs' => array(
			'style' => 'width: 5em',
		),
	] );


	// use wp search

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_1', array(
		'section' => 'pbosfc',
		'type'    => 'divider',
	) ) );

	$wp_customize->add_setting( 'pbosfc_use_wp_search', array(
		'default' => pbosfc_get_option_def( 'use_wp_search' ),
	) );
	$wp_customize->add_control( 'pbosfc_use_wp_search', [
		'section'     => 'pbosfc',
		'type'        => 'checkbox',
		'label'       => __( 'Use Wordpress search box', 'pbosfc' ),
		'description' => __( 'When checked gives you possiblity for advanced search. We recommend: PBO Tools plugin in conjunction with SearchWP Live Ajax Search plugin.', 'pbosfc' ),
		'settings'    => 'pbosfc_use_wp_search'
	] );

}

/**
 * Setup the WordPress core custom header feature.
 */

add_filter( 'storefront_custom_header_args', 'pbosfc_custom_header_setup' );

function pbosfc_custom_header_setup( $args ) {
	$args['width']  = 2200;
	$args['height'] = 130;

	return $args;
}

