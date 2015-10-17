<?php
/**
 *
 */

/**
 *
 */

$is_mobile = class_exists( 'PBO_User_Device' ) ? PBO_User_Device::is_mobile() : false;
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

/**
 * @param $name
 *
 * @return mixed|void
 */
function pbosfc_get_option( $name ) {
	global $is_mobile;

	$pbosfc_option = [ ];

	// If true then standard Wordpress search will be used instead of Woocommerce products search
	$pbosfc_option['use_wp_search'] = true;

	$pbosfc_option['post_excerpt']        = true;
	$pbosfc_option['excerpt_image_size']  = 'thumbnail';
	$pbosfc_option['excerpt_image_float'] = 'alignleft';
	$pbosfc_option['excerpt_word_count']  = $is_mobile ? 25 : 45;
	$pbosfc_option['excerpt_end']         = '...';

	$pbosfc_option['products_per_page'] = $is_mobile ? 6 : 15;
	$pbosfc_option['product_columns']   = $is_mobile ? 1 : 3;

	$pbosfc_option['posts_per_page'] = $is_mobile ? 3 : 5;

	$pbosfc_option['page_featured_image']      = false;
	$pbosfc_option['page_featured_image_size'] = 'full';
	$pbosfc_option['post_featured_image']      = false;
	$pbosfc_option['post_featured_image_size'] = 'full';

	$pbosfc_option['page_breadcrumb'] = false;
	$pbosfc_option['post_breadcrumb'] = true;

	return get_option( 'pbosfc_' . $name, $pbosfc_option[ $name ] );
}

/**
 * @param $name
 * @param $val
 */
function pbosfc_set_option( $name, $val ) {
	$name = 'pbosfc_' . $name;
	if ( get_option( $name ) !== false ) {
		// The option already exists, so we just update it.
		update_option( $name, $val );
	} else {
		// The option hasn't been added yet. We'll add it with $autoload set to 'no'.
		$deprecated = null;
		$autoload   = 'no';
		add_option( $name, $val, $deprecated, $autoload );
	}
}

/**
 *
 */
function pbosfc_register_menus() {
	unregister_nav_menu( 'secondary' );

	register_nav_menus( array(
		'left_top'  => __( 'Left Top Menu', 'pbosfc' ),
		'right_top' => __( 'Right Top Menu', 'pbosfc' ),
	) );
}


/**
 *
 */
function pbosfc_sidebars_init() {

	register_sidebar( array(
		'name'          => __( 'Top Header (above Top Menu)', 'pbosfc' ),
		'id'            => 'top-header-1',
		'description'   => __( 'Place for widgets above the Top Menu(s)', 'pbosfc' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Top Header (below Top Menu)', 'pbosfc' ),
		'id'            => 'top-header-2',
		'description'   => __( 'Place for widgets below the Top Menu(s) but above Site Title', 'pbosfc' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );

	register_sidebar( array(
		'name'          => __( 'Bottom Header (above Footer)', 'pbosfc' ),
		'id'            => 'bottom-header-1',
		'description'   => __( 'Place for widgets below Content but above Footer', 'pbosfc' ),
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h3 class="widget-title">',
		'after_title'   => '</h3>',
	) );
}

function pbosfc_register_sidebars() {
	add_action( 'widgets_init', 'pbosfc_sidebars_init' );
}


/**
 * Remove storefront credit link in footer
 * TODO: nie kasowac, tylko dodac informacje o PBO ;)
 */
add_filter( 'storefront_credit_link',
	function () {
		return false;
	}
);
