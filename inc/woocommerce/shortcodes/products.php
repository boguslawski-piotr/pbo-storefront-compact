<?php
/**
 * @author Piotr Boguslawski
 */

add_shortcode( 'pbosfc_featured_products', 'pbosfc_featured_products' );
add_shortcode( 'pbosfc_sale_products', 'pbosfc_sale_products' );
add_shortcode( 'pbosfc_recent_products', 'pbosfc_recent_products' );
add_shortcode( 'pbosfc_best_selling_products', 'pbosfc_best_selling_products' );
add_shortcode( 'pbosfc_top_rated_products', 'pbosfc_top_rated_products' );

add_shortcode( 'pbosfc_cart_link', 'pbosfc_storefront_cart_link' );

add_shortcode( 'pbosfc_product_tags', 'pbosfc_product_tags' );

function pbosfc_storefront_cart_link( $atts ) {
	ob_start();
	storefront_header_cart();

	return ob_get_clean();
}

function pbosfc_xxx_products( $atts, $func ) {
	$latts = shortcode_atts( [
		'class'    => '',
		'max_rows' => 1,
		'caption'  => '',
	], $atts );

	ob_start();
	call_user_func( $func, $latts['class'], $latts['max_rows'], pbosfc_get_option( 'product_columns' ), $latts['caption'] );

	return ob_get_clean();
}

function pbosfc_featured_products( $atts ) {
	return pbosfc_xxx_products( $atts, 'pbo_featured_products' );
}


function pbosfc_sale_products( $atts ) {
	return pbosfc_xxx_products( $atts, 'pbo_sale_products' );
}


function pbosfc_recent_products( $atts ) {
	return pbosfc_xxx_products( $atts, 'pbo_recent_products' );
}


function pbosfc_best_selling_products( $atts ) {
	return pbosfc_xxx_products( $atts, 'pbo_best_selling_products' );
}


function pbosfc_top_rated_products( $atts ) {
	return pbosfc_xxx_products( $atts, 'pbo_top_rated_products' );
}

function pbosfc_product_tags( $atts ) {
	// TODO: rozwinac, rozne mozliwosc, a nie tylko dropdown
	ob_start();
	pbosfc_product_dropdown_tags();

	return ob_get_clean();
}

function pbosfc_product_dropdown_tags() {
	$args = array(
		'unit'     => 'pt',
		'number'   => 0,
		'format'   => 'array',
		'orderby'  => 'name',
		'order'    => 'ASC',
		'exclude'  => null,
		'include'  => null,
		'link'     => 'view',
		'taxonomy' => 'product_tag',
		'echo'     => false,
		'child_of' => null, // see Note!
	);

	$tags = wp_tag_cloud( $args );

	wc_enqueue_js(
		"jQuery( '.dropdown_product_tag' ).change(
			function() {
				if ( jQuery(this).val() != '' ) {
				  var this_page = '';
				  var home_url  = '" . esc_js( home_url( '/' ) ) . "';
				  if ( home_url.indexOf( '?' ) > 0 ) {
				    this_page = home_url + '&product_tag=' + jQuery(this).val();
				  } else {
				    this_page = home_url + '?product_tag=' + jQuery(this).val();
				  }
				  location.href = this_page;
				}
			}
		);"
	);

	$html = '<option value="">' . esc_html( apply_filters( 'pbosfc_product_dropdown_tags_title', __( 'Select a tag', 'pbosfc' ) ) ) . '</option>';
	foreach ( $tags as $k => $v ) {
		$slug  = str_replace( 'tag=', '', strstr( strstr( $v, 'tag=' ), "'", true ) );
		$count = str_replace( "title='", '', strstr( strstr( $v, 'title=' ), " ", true ) );
		$html  = $html . '<option value="' . $slug . '">' . $v . ' (' . $count . ')</option>';
	}
	$html = '<select name="product_tag" class="dropdown_product_tag">' . $html . '</select>';
	echo $html;
}
