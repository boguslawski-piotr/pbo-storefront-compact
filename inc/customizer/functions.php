<?php

function pbo_compact_css( $text ) {
	$text = preg_replace("#(/\*.+\*/\n)#", '', $text); // very simple solution to strips one line comments
	$text = str_ireplace("\n", '', $text);
	$text = str_ireplace("\r", '', $text);
	$text = preg_replace('/\s\s+/', ' ', $text);    // strips excess whitespace
	$text = preg_replace('/\s*}\s*/', '}', $text);
	$text = preg_replace('/\s*{\s*/', '{', $text);
	$text = preg_replace('/\s*,\s*/', ',', $text);
	$text = preg_replace('/\s*:\s*/', ':', $text);
//	echo $text;
	return ltrim(rtrim($text));
}

add_action( 'customize_register', 'pbosfc_customize_register', 20 );

function pbosfc_customize_register( $wp_customize ) {
	/**
	 * Logo or title.
	 */

	$wp_customize->remove_control( 'storefront_logo_heading' );
	$wp_customize->remove_control( 'storefront_logo_info' );
	$wp_customize->remove_control( 'storefront_logo_divider_after' );

	/**
	 * Colors for header controls (title, menus, etc.)
	 */

	$wp_customize->add_section( 'pbosfc', array(
		'title'    => PBOSFC_FULL_NAME,
		'priority' => 999,
	) );

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

}


add_action( 'wp_enqueue_scripts', 'pbosfc_add_customizer_css', 140 );
add_filter( 'storefront_brighten_factor', 'pbosfc_brighten_factor' );
add_filter( 'storefront_darken_factor', 'pbosfc_darken_factor' );

function pbosfc_brighten_factor() {
	return 50;
}

function pbosfc_darken_factor() {
	return - 50;
}

function pbosfc_add_customizer_css() {
	//$accent_color = storefront_sanitize_hex_color( get_theme_mod( 'storefront_accent_color', apply_filters( 'storefront_default_accent_color', '#96588a' ) ) );
	$header_link_color = storefront_sanitize_hex_color( get_theme_mod( 'storefront_header_link_color', apply_filters( 'storefront_default_header_link_color', '#ffffff' ) ) );

	$brighten_factor = apply_filters( 'storefront_brighten_factor', 50 );
	$darken_factor   = apply_filters( 'storefront_darken_factor', - 50 );

	$left_top_menu_width  = "70%";
	$right_top_menu_width = "30%";

	$top_menu_background_color        = '#f3f3f3';
	$top_menu_1level_background_color = '#f3f3f3';
	$top_menu_1level_link_color       = '#96588a';
	$top_menu_2level_background_color = '#f3f3f3';
	$top_menu_2level_link_color       = '#96588a';

	$site_title_link_color = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_title_link_color', apply_filters( 'pbosfc_default_site_title_link_color', '#96588a' ) ) );
	$site_title_text_color = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_title_text_color', apply_filters( 'pbosfc_default_site_title_text_color', '#f3f3f3' ) ) );

	$main_navigation_1level_background_color = '#2c2d33';
	$main_navigation_1level_link_color       = '#ffffff';
	$main_navigation_2level_background_color = '#2c2d33';
	$main_navigation_2level_link_color       = '#ffffff';

	$site_header_search_background_color = "#f3f3f3";
	$site_header_search_text_color       = "#61656b";

	$site_header_cart_background_color         = '#96588a';
	$site_header_cart_link_color               = '#ffffff';

	$site_header_cart_content_background_color = "#f3f3f3";
	$site_header_cart_content_link_color       = '#96588a';
	$site_header_cart_content_text_color       = "#61656b";

	$styles = "
		/* Site title */

		.site-title a,
		.site-branding h1 a {
			color: $site_title_link_color;
		}
		.site-title a:hover,
		.site-branding h1 a:hover {
			color: " . storefront_adjust_color_brightness( $site_title_link_color, $darken_factor ) . ";
		}
		p.site-description {
			color: $site_title_text_color;
		}

		@media screen and ( min-width: 768px ) {
			/* Top menu */

			.top-menu-wrap {
				background-color: $top_menu_background_color;
			}

			.left-top-menu-wrap {
				width    : $left_top_menu_width;
				min-width: $left_top_menu_width;
			}

			.right-top-menu-wrap {
				width    : $right_top_menu_width;
				min-width: $right_top_menu_width;
			}

			.left-top-menu .menu a,
			.right-top-menu .menu a,
			.left-top-menu ul.menu li.current-menu-item > a,
			.right-top-menu ul.menu li.current-menu-item > a {
				color: $top_menu_1level_link_color;
				background-color: $top_menu_1level_background_color;
			}

			.left-top-menu .menu a:hover,
			.right-top-menu .menu a:hover,
			.left-top-menu ul.menu li.current-menu-item > a:hover,
			.right-top-menu ul.menu li.current-menu-item > a:hover {
				color: " . storefront_adjust_color_brightness( $top_menu_1level_link_color, $darken_factor ) . ";
				background-color: " . storefront_adjust_color_brightness( $top_menu_1level_background_color, $brighten_factor ) . ";
			}

			.left-top-menu .menu ul a,
			.right-top-menu .menu ul a {
				color: $top_menu_2level_link_color;
				background-color: $top_menu_2level_background_color;
			}

			.left-top-menu .menu ul a:hover,
			.right-top-menu .menu ul a:hover {
				color: " . storefront_adjust_color_brightness( $top_menu_2level_link_color, $darken_factor ) . ";
				background-color: " . storefront_adjust_color_brightness( $top_menu_2level_background_color, $brighten_factor ) . ";
			}

		}

		/* Main menu */

		/* first (and rest on mobile) level */
		.main-navigation ul li a {
			color: $main_navigation_1level_link_color;
		    background-color: $main_navigation_1level_background_color;
		}

		.main-navigation ul li a:hover {
			color: " . storefront_adjust_color_brightness( $main_navigation_1level_link_color, $darken_factor ) . ";
			background-color: " . storefront_adjust_color_brightness( $main_navigation_1level_background_color, $brighten_factor ) . ";
		}


		@media screen and ( min-width: 768px ) {
			/* second level, desktops */
			.main-navigation ul.menu ul li a {
				color: $main_navigation_2level_link_color;
				background-color: $main_navigation_2level_background_color;
			}
			.main-navigation ul.menu ul li a:hover {
				color: " . storefront_adjust_color_brightness( $main_navigation_2level_link_color, $darken_factor ) . ";
				background-color: " . storefront_adjust_color_brightness( $main_navigation_2level_background_color, $brighten_factor ) . ";
			}
		}


		.site-header-wishlist a {
			color: $header_link_color;
		}
		.site-header-wishlist a:hover {
			color: " . storefront_adjust_color_brightness( $header_link_color, $darken_factor ) . ";
		}


		.widget_search form input[type=text],
		.widget_search form input[type=search],
		.widget_product_search form input[type=text],
		.widget_product_search form input[type=search] {
			background-color: $site_header_search_background_color;
			color : $site_header_search_text_color;
		}


		.site-header-cart .cart-contents,
		.woocommerce-active .site-header .site-header-cart {
			background-color : $site_header_cart_background_color;
			color: $site_header_cart_link_color;
		}

		.site-header-cart .widget_shopping_cart {
			background-color: $site_header_cart_content_background_color;
			color: $site_header_cart_content_text_color;
		}
		.site-header .product_list_widget li .quantity,
		.widget_shopping_cart .product_list_widget li .quantity {
			color: $site_header_cart_content_text_color;
		}

		a.cart-contents {
			color: $site_header_cart_link_color;
		}
		.site-header-cart .widget_shopping_cart a {
			color: $site_header_cart_content_link_color;
		}
		a.cart-contents:hover {
			color: " . storefront_adjust_color_brightness( $site_header_cart_link_color, $darken_factor ) . ";
		}
		.site-header-cart .widget_shopping_cart a:hover {
			color: " . storefront_adjust_color_brightness( $site_header_cart_content_link_color, $darken_factor ) . ";
		}
	";
	$styles = pbo_compact_css( $styles );
	wp_add_inline_style( 'pbosfc-style', $styles );
}