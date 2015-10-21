<?php

add_action( 'wp_enqueue_scripts', 'pbosfc_add_customizer_css', 140 );

function pbosfc_add_customizer_css() {
	$header_background_color = storefront_sanitize_hex_color( get_theme_mod( 'storefront_header_background_color', apply_filters( 'storefront_default_header_background_color', '#2c2d33' ) ) );
	$header_link_color       = storefront_sanitize_hex_color( get_theme_mod( 'storefront_header_link_color', apply_filters( 'storefront_default_header_link_color', '#ffffff' ) ) );
	$footer_text_color       = storefront_sanitize_hex_color( get_theme_mod( 'storefront_footer_text_color', apply_filters( 'storefront_default_footer_text_color', '#61656b' ) ) );

	$product_column_width = (integer) pbosfc_get_option( 'product_columns' );
	$product_column_width = ( 100 / ( $product_column_width !== 0 ? $product_column_width : 1 ) ) - 2;

	$brighten_factor = apply_filters( 'storefront_brighten_factor', pbosfc_brighten_factor() );
	$darken_factor   = apply_filters( 'storefront_darken_factor', pbosfc_darken_factor() );

	$left_top_menu_width  = (string) pbosfc_get_option( 'left_top_menu_width' ) . "%";
	$left_top_menu_align  = (string) pbosfc_get_option( 'left_top_menu_align' );
	$right_top_menu_width = (string) pbosfc_get_option( 'right_top_menu_width' ) . "%";
	$right_top_menu_align = (string) pbosfc_get_option( 'right_top_menu_align' );

	// TODO: (not importrant) umozliwic ustawianie doklaniej kolorow top menu
	$top_menu_background_color        = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_top_menu_background_color', pbosfc_get_option_def( 'top_menu_background_color' ) ) );
	$top_menu_1level_background_color = $top_menu_background_color; //'#f3f3f3';
	$top_menu_1level_link_color       = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_top_menu_1level_link_color', pbosfc_get_option_def( 'top_menu_1level_link_color' ) ) );
	$top_menu_2level_background_color = $top_menu_background_color; //'#f3f3f3';
	$top_menu_2level_link_color       = $top_menu_1level_link_color; //'#96588a';

	// TODO: (not importrant) umozliwic ustawianie dokladniej kolorow glownego menu
	$main_navigation_1level_background_color = $header_background_color; //'#2c2d33';
	$main_navigation_1level_link_color       = $header_link_color; //'#ffffff';
	$main_navigation_2level_background_color = $header_background_color; //'#2c2d33';
	$main_navigation_2level_link_color       = $header_link_color; //'#ffffff';

	$site_title_link_color = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_title_link_color', pbosfc_get_option_def( 'site_title_link_color' ) ) );
	$site_title_text_color = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_title_text_color', pbosfc_get_option_def( 'site_title_text_color' ) ) );

	$site_header_search_background_color = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_header_search_background_color', pbosfc_get_option_def( 'site_header_search_background_color' ) ) );
	$site_header_search_text_color       = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_header_search_text_color', pbosfc_get_option_def( 'site_header_search_text_color' ) ) );

	$site_header_cart_background_color = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_header_cart_background_color', pbosfc_get_option_def( 'site_header_cart_background_color' ) ) );
	$site_header_cart_link_color       = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_header_cart_link_color', pbosfc_get_option_def( 'site_header_cart_link_color' ) ) );

	$site_header_cart_content_background_color = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_header_cart_content_background_color', pbosfc_get_option_def( 'site_header_cart_content_background_color' ) ) );
	$site_header_cart_content_link_color       = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_header_cart_content_link_color', pbosfc_get_option_def( 'site_header_cart_content_link_color' ) ) );
	$site_header_cart_content_text_color       = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_site_header_cart_content_text_color', pbosfc_get_option_def( 'site_header_cart_content_text_color' ) ) );

	$onsale_sign_background_color = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_onsale_sign_background_color', pbosfc_get_option_def( 'onsale_sign_background_color' ) ) );
	$onsale_sign_border_color     = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_onsale_sign_border_color', pbosfc_get_option_def( 'onsale_sign_border_color' ) ) );
	$onsale_sign_text_color       = storefront_sanitize_hex_color( get_theme_mod( 'pbosfc_onsale_sign_text_color', pbosfc_get_option_def( 'onsale_sign_text_color' ) ) );

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

			/* Category/product columns on archives pages */

			.site-main ul.products li.product {
                width : $product_column_width%;
                margin-right : 2%;
                float: left;
            }

			/* Top menu */

			.top-menu-wrap {
				background-color: $top_menu_background_color;
			}

			.left-top-menu-wrap {
				width    : $left_top_menu_width;
				min-width: $left_top_menu_width;
				background-color: $top_menu_1level_background_color;
			}
		    .left-top-menu .menu {
		        float    : $left_top_menu_align;
		    }

			.right-top-menu-wrap {
				width    : $right_top_menu_width;
				min-width: $right_top_menu_width;
				background-color: $top_menu_1level_background_color;
			}
		    .right-top-menu .menu {
		        float    : $right_top_menu_align;
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

		.main-navigation,
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


		/* Wishlist link (on mobile) */

		.site-header-wishlist a {
			color: $header_link_color;
		}
		.site-header-wishlist a:hover {
			color: " . storefront_adjust_color_brightness( $header_link_color, $darken_factor ) . ";
		}

		/* Search box */

		.widget_search form input[type=text],
		.widget_search form input[type=search],
		.widget_product_search form input[type=text],
		.widget_product_search form input[type=search] {
			background-color: $site_header_search_background_color;
			color : $site_header_search_text_color;
		}

		/* Mini Cart */

		.site-header-cart .cart-contents,
		.widget .site-header-cart .cart-contents,
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

		a.cart-contents,
		.widget a.cart-contents {
			color: $site_header_cart_link_color;
		}
		.site-header-cart .widget_shopping_cart a {
			color: $site_header_cart_content_link_color;
		}
		a.cart-contents:hover,
		.widget a.cart-contents:hover {
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

	// Some fixes for Firefox (on Linux)

	$user_agent = isset( $_SERVER['HTTP_USER_AGENT'] ) ? $_SERVER['HTTP_USER_AGENT'] : '';
	if ( (bool) preg_match( "/firefox/i", $user_agent ) ) {
		$styles = $styles . "
			/*@media screen and ( min-width: 768px ) {*/
				.site-branding h1 {
					font-size : 1.33em;
				}

				.site-header-wishlist a {
					font-size : 0.6em;
				}

				.woocommerce-active .site-header .main-navigation,
				.site-header .main-navigation {
					font-size : 1em;
				}
			/*}*/
		";
	}

	$styles = pbo_compact_css( $styles );
	wp_add_inline_style( 'pbosfc-style', apply_filters( 'pbosfc_inline_styles', $styles ) );
}

add_filter( 'storefront_brighten_factor', 'pbosfc_brighten_factor' );
add_filter( 'storefront_darken_factor', 'pbosfc_darken_factor' );

function pbosfc_brighten_factor() {
	return 35;
}

function pbosfc_darken_factor() {
	return - 35;
}

/**
 * @param $text
 *
 * @return string
 */
if ( ! function_exists( 'pbo_compact_css' ) ) {
	function pbo_compact_css( $text ) {
		// very simple solution to strips one line comments
		$text = preg_replace( "#(/\*.+\*/\n)#", '', $text );
		// strips end of line
		$text = str_ireplace( "\n", '', $text );
		$text = str_ireplace( "\r", '', $text );
		// strips excess whitespace
		$text = preg_replace( '/\s\s+/', ' ', $text );
		$text = preg_replace( '/\s*}\s*/', '}', $text );
		$text = preg_replace( '/\s*{\s*/', '{', $text );
		$text = preg_replace( '/\s*,\s*/', ',', $text );
		$text = preg_replace( '/\s*:\s*/', ':', $text );

		return apply_filters( 'pbo_compact_css', ltrim( rtrim( $text ) ) );
	}
}