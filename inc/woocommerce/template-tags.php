<?php

/**
 * Breadcrumb always in shop (products, categories, etc.)
 * and on pages/posts only if option is ON.
 */
function pbosfc_woocommerce_breadcrumb( $args = array() ) {
	$display = true;
	if ( 'page' === get_post_type() ) {
		$display = pbosfc_get_option('page_breadcrumb');
	}
	elseif ( 'post' === get_post_type() ) {
		$display = pbosfc_get_option('post_breadcrumb');
	}

	if ( $display ) {
		woocommerce_breadcrumb( $args );
	}
}

