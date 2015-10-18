<?php

add_action( 'wp_enqueue_scripts', 'pbosfc_add_customizer_css', 140 );

function pbosfc_add_customizer_css() {
	$header_link_color = storefront_sanitize_hex_color( get_theme_mod( 'storefront_header_link_color', apply_filters( 'storefront_default_header_link_color', '#ffffff' ) ) );
	$footer_text_color = storefront_sanitize_hex_color( get_theme_mod( 'storefront_footer_text_color', apply_filters( 'storefront_default_footer_text_color', '#61656b' ) ) );

	$product_column_width = (integer) pbosfc_get_option( 'product_columns' );
	$product_column_width = ( 100 / ( $product_column_width !== 0 ? $product_column_width : 1 ) ) - 2;

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

	$site_header_cart_background_color = '#96588a';
	$site_header_cart_link_color       = '#ffffff';

	$site_header_cart_content_background_color = "#f3f3f3";
	$site_header_cart_content_link_color       = '#96588a';
	$site_header_cart_content_text_color       = "#61656b";

	$onsale_sign_background_color = '#3d9cd2'; //'#96588a';
	$onsale_sign_border_color     = '#ffffff';
	$onsale_sign_text_color       = '#ffffff';

	$styles = "
		/* Fixing some Storefront bugs ;) */

		.footer-widgets ul.menu li.current-menu-item > a {
			color: $footer_text_color;
		}

		/* Site title */

		ul.menu li a,
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
			.site-main ul.products li.product {
                width : $product_column_width%;
            }

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

		/* On Sale sign */

		.woocommerce span.onsale {
			background-color: $onsale_sign_background_color;
			border-color: $onsale_sign_border_color;
			color: $onsale_sign_text_color;
		}

	";
	$styles = pbo_compact_css( $styles );
	wp_add_inline_style( 'pbosfc-style', $styles );
}

add_filter( 'storefront_brighten_factor', 'pbosfc_brighten_factor' );
add_filter( 'storefront_darken_factor', 'pbosfc_darken_factor' );

function pbosfc_brighten_factor() {
	return 50;
}

function pbosfc_darken_factor() {
	return - 50;
}

/**
 * @param $text
 *
 * @return string
 */
function pbo_compact_css( $text ) {
	$text = preg_replace( "#(/\*.+\*/\n)#", '', $text ); // very simple solution to strips one line comments
	$text = str_ireplace( "\n", '', $text );
	$text = str_ireplace( "\r", '', $text );
	$text = preg_replace( '/\s\s+/', ' ', $text );    // strips excess whitespace
	$text = preg_replace( '/\s*}\s*/', '}', $text );
	$text = preg_replace( '/\s*{\s*/', '{', $text );
	$text = preg_replace( '/\s*,\s*/', ',', $text );
	$text = preg_replace( '/\s*:\s*/', ':', $text );

//	echo $text;
	return ltrim( rtrim( $text ) );
}