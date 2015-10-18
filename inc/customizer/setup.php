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
		'default' => apply_filters( 'pbosfc_default_site_logo_opt', false ),
	) );
	$wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'pbosfc_site_logo', array(
		'label'    => __( 'Use logo image', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_logo',
		'type'     => 'checkbox',
		'priority' => 1,
	) ) );
	$wp_customize->add_setting( 'pbosfc_site_logo_image', array(
		'default' => apply_filters( 'pbosfc_default_site_logo_image', false ),
	) );
	$wp_customize->add_control( new WP_Customize_Image_Control( $wp_customize, 'pbosfc_site_logo_image', array(
		'label'    => __( 'Image', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_logo_image',
		'priority' => 2,
	) ) );

	/**
	 * Colors for header controls (title, menus, etc.)
	 */

	$wp_customize->remove_control( 'storefront_header_text_color' );
	$wp_customize->remove_control( 'storefront_header_link_color' );

	$wp_customize->add_setting( 'pbosfc_site_title_link_color', array(
		'default'           => apply_filters( 'pbosfc_default_site_title_link_color', '#96588a' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_title_link_color', array(
		'label'    => __( 'Site title color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_title_link_color',
		'priority' => 40,
	) ) );

	$wp_customize->add_setting( 'pbosfc_site_title_text_color', array(
		'default'           => apply_filters( 'pbosfc_default_site_title_text_color', '#f3f3f3' ),
		'sanitize_callback' => 'storefront_sanitize_hex_color',
	) );
	$wp_customize->add_control( new WP_Customize_Color_Control( $wp_customize, 'pbosfc_site_title_text_color', array(
		'label'    => __( 'Site description color', 'pbosfc' ),
		'section'  => 'header_image',
		'settings' => 'pbosfc_site_title_text_color',
		'priority' => 50,
	) ) );

	/**
	 * Others
	 */

	$wp_customize->add_section( 'pbosfc', array(
		'title'    => PBOSFC_FULL_NAME,
		'priority' => 1,
	) );

	// use wp search

	$wp_customize->add_setting( 'pbosfc_use_wp_search', array(
		'default' => apply_filters( 'pbosfc_use_wp_search_opt', pbosfc_get_option_def( 'use_wp_search' ) ),
	) );
	$wp_customize->add_control( 'pbosfc_use_wp_search', [
		'section'     => 'pbosfc',
		'type'        => 'checkbox',
		'label'       => __( 'Use Wordpress search box', 'pbosfc' ),
		'description' => __( 'When checked gives you possiblity for advanced search. We recommend: PBO Tools plugin in conjunction with SearchWP Live Ajax Search plugin.', 'pbosfc' ),
		'settings'    => 'pbosfc_use_wp_search'
	] );

	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_1', array(
		'section' => 'pbosfc',
		'type'    => 'divider',
	) ) );

	// products (per page, columns, etc.)

	$wp_customize->add_setting( 'pbosfc_products_per_page', array(
		'default' => apply_filters( 'pbosfc_products_per_page_opt', pbosfc_get_option_def( 'products_per_page' ) ),
	) );
	$wp_customize->add_control( 'pbosfc_products_per_page', [
		'section'  => 'pbosfc',
		'type'     => 'number',
		'label'    => __( 'How many products per page', 'pbosfc' ),
		'settings' => 'pbosfc_products_per_page'
	] );

	$wp_customize->add_setting( 'pbosfc_product_columns', array(
		'default' => apply_filters( 'pbosfc_product_columns_opt', pbosfc_get_option_def( 'product_columns' ) ),
	) );
	$wp_customize->add_control( 'pbosfc_product_columns', [
		'section'  => 'pbosfc',
		'type'     => 'number',
		'label'    => __( 'How many product columns', 'pbosfc' ),
		'settings' => 'pbosfc_product_columns'
	] );


	$wp_customize->add_control( new Arbitrary_Storefront_Control( $wp_customize, 'pbosfc_divider_2', array(
		'section' => 'pbosfc',
		'type'    => 'divider',
	) ) );

	// posts per page

	$wp_customize->add_setting( 'pbosfc_posts_per_page', array(
		'default' => apply_filters( 'pbosfc_posts_per_page_opt', pbosfc_get_option_def( 'posts_per_page' ) ),
	) );
	$wp_customize->add_control( 'pbosfc_posts_per_page', [
		'section'  => 'pbosfc',
		'type'     => 'number',
		'label'    => __( 'How many posts per page', 'pbosfc' ),
		'settings' => 'pbosfc_posts_per_page'
	] );

	// excerpts

	$wp_customize->add_setting( 'pbosfc_post_excerpt', array(
		'default' => apply_filters( 'pbosfc_post_excerpt_opt', pbosfc_get_option_def( 'post_excerpt' ) ),
	) );
	$wp_customize->add_control( 'pbosfc_post_excerpt', [
		'section'     => 'pbosfc',
		'type'        => 'checkbox',
		'label'       => __( 'Use excerpts', 'pbosfc' ),
		'description' => __( 'When checked displays post excertps on archive and search results pages.', 'pbosfc' ),
		'settings'    => 'pbosfc_post_excerpt'
	] );

}


/**
 * Setup the WordPress core custom header feature.
 */

add_filter( 'storefront_custom_header_args', 'pbosfc_custom_header_setup' );

function pbosfc_custom_header_setup( $args ) {
	$args['width']  = 2200;
	$args['height'] = 100;

	return $args;
}

