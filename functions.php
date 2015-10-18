<?php
/*
 Theme Name:   PBO Storefront Compact
 Theme URI:
 Description:  ...
 Author:       Piotr Boguslawski
 Author URI:
 Template:     storefront
 Version:      1.0.0
 License:      GNU General Public License v2 or later
 License URI:  http://www.gnu.org/licenses/gpl-2.0.html

 Text Domain:  storefront
 Text Domain:  pbosfc
*/
if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly

define( 'PBOSFC_FULL_NAME', 'PBO Storefront Compact' );
define( 'PBOSFC_VERSION', "1.0.0" );

include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
$pbosfc_inc_directory = get_stylesheet_directory() . '/inc/';

/**
 * Setup, settings, etc.
 */

require_once $pbosfc_inc_directory . 'setup.php';
require_once $pbosfc_inc_directory . 'customizer/setup.php';

/**
 * Components
 */

require_once $pbosfc_inc_directory . 'structure/header.php';
require_once $pbosfc_inc_directory . 'structure/page.php';
require_once $pbosfc_inc_directory . 'structure/post.php';
require_once $pbosfc_inc_directory . 'structure/footer.php';

require_once $pbosfc_inc_directory . 'woocommerce/shortcodes/products.php';
require_once $pbosfc_inc_directory . 'woocommerce/template-tags.php';

require_once $pbosfc_inc_directory . 'customizer/functions.php';
require_once $pbosfc_inc_directory . 'customizer/frontend.php';

/**
 * Initialization
 */

add_action( 'after_setup_theme',
	/* Initialize theme... */
	function () {
		load_theme_textdomain( 'pbosfc', dirname( __FILE__ ) . '/languages/' );
		pbosfc_register_menus();
		pbosfc_register_sidebars();
	},
	999
);

add_action( 'init',
	function () {
		global $pbosfc_inc_directory;
		require_once $pbosfc_inc_directory . 'structure/hooks.php';
		require_once $pbosfc_inc_directory . 'woocommerce/hooks.php';
	},
	999
);


/**
 * Stylesheets, scripts
 */

function pbosfc_enqueue_styles() {
	// Load parent stylesheet first
	wp_enqueue_style( 'storefront-style', trailingslashit( get_template_directory_uri() ) . 'style.css', false );

	// Load active theme stylesheet but later than specified plugins
	wp_enqueue_style( 'pbosfc-style', get_stylesheet_uri(),
		[
			'storefront-style',
			'storefront-woocommerce-style',
			'easy_social_share_buttons-frontend',
			'yith-wcwl-main',
			'su-box-shortcodes',
			'searchwp-live-search',
			'simple-favorites',
			'basecss',                                 // EU Cookie Law
		]
	);
}

add_action( 'wp_enqueue_scripts', 'pbosfc_enqueue_styles' );


/**
 * Hack for YITH Wishlist, because it not work correctly with advanced Add To Cart funcionality (see woocommerce/loop/add-to-cart.php)
 */

$add_to_cart_template_from_wishlist = 0;

function bwishlist_hack() {
	global $add_to_cart_template_from_wishlist;
	$add_to_cart_template_from_wishlist ++;
}

function awishlist_hack() {
	global $add_to_cart_template_from_wishlist;
	$add_to_cart_template_from_wishlist --;
}

add_action( 'yith_wcwl_before_wishlist', 'bwishlist_hack' );
add_action( 'yith_wcwl_after_wishlist', 'awishlist_hack' );


/* ================================================ TEST AREA ================================================ */


?>

