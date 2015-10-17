<?php
/*
 *
 */

// Category/product columns on archives pages
add_filter( 'loop_shop_columns', function () {
	return pbosfc_get_option( 'product_columns' );
}, 999 );

// Products per page
add_filter( 'loop_shop_per_page', function ( $cols ) {
	return pbosfc_get_option( 'products_per_page' );
}, 999 );

// Related products columns and amount
add_filter( 'woocommerce_related_products_args',
	function ( $args ) {
		$args['columns']        = pbosfc_get_option( 'product_columns' );
		$args['posts_per_page'] = pbosfc_get_option( 'product_columns' );

		return $args;
	}
);


// ...
remove_action( 'storefront_content_top', 'woocommerce_breadcrumb', 10 );
add_action( 'storefront_content_top', 'pbosfc_woocommerce_breadcrumb', 10 );


/*
 * Product(s)
 */

/*
 * Change single product fields presentation order to:
 *  - product name
 *  - short description/excerpt
 *  - rating
 *  - meta
 *  ... (no change)
 */

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 6 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 10 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_rating', 7 );

remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 9 );
