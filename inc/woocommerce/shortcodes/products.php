<?php
/**
 * @author Piotr Boguslawski
 */

add_shortcode( 'pbosfc_featured_products', 'pbo_sfc_featured_products' );
add_shortcode( 'pbosfc_sale_products', 'pbo_sfc_sale_products' );
add_shortcode( 'pbosfc_recent_products', 'pbo_sfc_recent_products' );
add_shortcode( 'pbosfc_best_selling_products', 'pbo_sfc_best_selling_products' );
add_shortcode( 'pbosfc_top_rated_products', 'pbo_sfc_top_rated_products' );

add_shortcode( 'pbosfc_cart_link', 'pbo_sfc_storefront_cart_link');

function pbo_sfc_storefront_cart_link( $atts ) {
	ob_start();
	storefront_header_cart();

	return ob_get_clean();
}

function pbo_sfc_xxx_products( $atts, $func ) {
	$latts = shortcode_atts( [
		'style'    => '',
		'max_rows' => 1,
		'caption'  => '',
	], $atts );

	ob_start();
	call_user_func( $func, $latts['style'], $latts['max_rows'], pbosfc_get_option( 'product_columns' ), $latts['caption'] );

	return ob_get_clean();
}

function pbo_sfc_featured_products( $atts ) {
	return pbo_sfc_xxx_products( $atts, 'pbo_featured_products' );
}


function pbo_sfc_sale_products( $atts ) {
	return pbo_sfc_xxx_products( $atts, 'pbo_sale_products' );
}


function pbo_sfc_recent_products( $atts ) {
	return pbo_sfc_xxx_products( $atts, 'pbo_recent_products' );
}


function pbo_sfc_best_selling_products( $atts ) {
	return pbo_sfc_xxx_products( $atts, 'pbo_best_selling_products' );
}


function pbo_sfc_top_rated_products( $atts ) {
	return pbo_sfc_xxx_products( $atts, 'pbo_top_rated_products' );
}

