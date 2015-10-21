<?php
/**
 *
 */

/**
 * Try to determine whether we operate on a mobile device
 */

$is_mobile = false;

if ( class_exists( 'PBO_User_Device' ) ) {
	$is_mobile = PBO_User_Device::is_mobile();
	if ( $is_mobile && ! in_array( PBO_User_Device::$device, [ 'iphone' ] ) ) {
		//echo 'MOBILE: ' . PBO_User_Device::$device . ' -> ';
		//echo $_SERVER['HTTP_USER_AGENT'];
		if ( PBO_User_Device::$device === 'ipad' ) {
			$is_mobile = false;
		} else {
			$doc_width = PBO_User_Device::try_to_get_document_width();
			//echo $doc_width;
			if ( ( isset( $doc_width ) && $doc_width >= 768 ) ) {
				$is_mobile = false;
			}
		}
	}
}

/**
 * Default values for all theme options
 */
function pbosfc_get_option_def( $name ) {
	$pbosfc_option = [ ];

	// Top menu(s)

	$pbosfc_option['left_top_menu_width']  = 70;
	$pbosfc_option['left_top_menu_align']  = 'left';
	$pbosfc_option['right_top_menu_width'] = 30;
	$pbosfc_option['right_top_menu_align'] = 'right';

	$pbosfc_option['top_menu_background_color']  = '#f3f3f3';
	$pbosfc_option['top_menu_1level_link_color'] = '#96588a';

	// Main menu

	$pbosfc_option['main_navigation_text_align'] = 'center';

	// Header

	$pbosfc_option['site_logo']       = false;
	$pbosfc_option['site_logo_image'] = '';

	$pbosfc_option['site_title_link_color'] = '#96588a';
	$pbosfc_option['site_title_text_color'] = '#f3f3f3';

	$pbosfc_option['site_header_search_background_color'] = "#f3f3f3";
	$pbosfc_option['site_header_search_text_color']       = "#61656b";

	$pbosfc_option['site_header_cart_background_color']         = '#96588a';
	$pbosfc_option['site_header_cart_link_color']               = '#ffffff';
	$pbosfc_option['site_header_cart_content_background_color'] = "#f3f3f3";
	$pbosfc_option['site_header_cart_content_link_color']       = '#96588a';
	$pbosfc_option['site_header_cart_content_text_color']       = "#61656b";

	// Content

	$pbosfc_option['onsale_sign_background_color'] = '#3d9cd2';
	$pbosfc_option['onsale_sign_border_color']     = '#ffffff';
	$pbosfc_option['onsale_sign_text_color']       = '#ffffff';

	$pbosfc_option['post_excerpt']        = true;
	$pbosfc_option['excerpt_image_size']  = 'thumbnail'; // none, medium, full
	$pbosfc_option['excerpt_image_float'] = 'alignleft';
	$pbosfc_option['excerpt_word_count']  = 45;

	$pbosfc_option['page_featured_image_size'] = 'none';
	$pbosfc_option['post_featured_image_size'] = 'none';

	$pbosfc_option['page_breadcrumb']    = true;
	$pbosfc_option['post_breadcrumb']    = true;
	$pbosfc_option['product_breadcrumb'] = true;

	// Functionality

	$pbosfc_option['add_to_cart_on_product_list']               = true;
	$pbosfc_option['add_to_cart_with_quantity_on_product_list'] = true;

	$pbosfc_option['products_per_page'] = 12;
	$pbosfc_option['product_columns']   = 3;

	$pbosfc_option['use_wp_search'] = false;

	$pbosfc_option['posts_per_page'] = 5;

	$rc = null;

	if ( isset( $pbosfc_option[ $name ] ) ) {
		$rc = $pbosfc_option[ $name ];
	}

	return apply_filters( 'pbosfc_default_opt', $rc, $name );
}

/**
 * Get theme option value
 */
function pbosfc_get_option( $name ) {
	$def_val = pbosfc_get_option_def( $name );
	if ( isset( $def_val ) && $def_val === 'depending on the device type' ) {
		global $is_mobile;
		$name    = $name . ( $is_mobile ? '_mobile' : '_desktop' );
		$def_val = pbosfc_get_option_def( $name );
	}

	return apply_filters('pbosfc_opt', get_theme_mod( 'pbosfc_' . $name, $def_val ), $name );
}


/**
 *
 */
if ( ! function_exists( 'pbosfc_register_menus' ) ) {
	function pbosfc_register_menus() {
		unregister_nav_menu( 'secondary' );

		do_action( 'pbosfc_before_register_menus' );

		register_nav_menus( array(
			'left_top'  => __( 'Left Top Menu', 'pbosfc' ),
			'right_top' => __( 'Right Top Menu', 'pbosfc' ),
		) );

		do_action( 'pbosfc_after_register_menus' );
	}
}

/**
 *
 */
if ( ! function_exists( 'pbosfc_sidebars_init' ) ) {
	function pbosfc_sidebars_init() {
		do_action( 'pbosfc_before_sidebars_init' );

		register_sidebar( array(
			'name'          => __( 'Top Header (above Top Menu)', 'pbosfc' ),
			'id'            => 'top-header-1',
			'description'   => __( 'Place for widgets above Top Menu(s)', 'pbosfc' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => __( 'Top Header (below Top Menu)', 'pbosfc' ),
			'id'            => 'top-header-2',
			'description'   => __( 'Place for widgets below Top Menu(s) but above Main Menu', 'pbosfc' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		register_sidebar( array(
			'name'          => __( 'Footer Bar (above Footer)', 'pbosfc' ),
			'id'            => 'footer-bar-1',
			'description'   => __( 'Place for widgets below Content but above Footer', 'pbosfc' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget'  => '</aside>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		) );

		do_action( 'pbosfc_after_sidebars_init' );
	}
}

/**
 *
 */
if ( ! function_exists( 'pbosfc_register_sidebars' ) ) {
	function pbosfc_register_sidebars() {
		add_action( 'widgets_init', 'pbosfc_sidebars_init' );
	}
}

/**
 *
 */
if ( ! function_exists( 'pbosfc_register_shortcodes' ) ) {
	function pbosfc_register_shortcodes() {
		if ( is_woocommerce_activated() ) {
			pbosfc_register_woocommerce_shortcodes();
		}
	}
}

/**
 * Add PBO Storefront Compact credit link in footer
 */
add_filter( 'storefront_credit_link',
	function () {
		?>
		<br/>
		<div style="font-size: 0.6em">
		<?php
		printf( __( 'This site use <strong>%1$s</strong> designed by %2$s based on', 'pbosfc' ), 'PBO Storefront Compact', '<a href="https://profiles.wordpress.org/piotr-boguslawski" alt="Piotr Boguslawski" title="Piotr Boguslawski" rel="designer">Piotr Boguslawski</a>' );

		return true;
	}
);
