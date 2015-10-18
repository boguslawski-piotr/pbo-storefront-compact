<?php

/**
 * General
 */

// posts per page
add_action( 'pre_get_posts',
	function ( $query ) {
		if ( $query->is_home() && $query->is_main_query() ) {
			$query->set( 'posts_per_page', pbosfc_get_option('posts_per_page') );
		}
	}
);


/**
 * Header
 */

add_action( 'storefront_before_header', 'pbosfc_topheader_1', 200 );
add_action( 'storefront_before_header', 'pbosfc_topmenu', 300 );
add_action( 'storefront_before_header', 'pbosfc_topheader_2', 400 );

// Change fields order on mobile view: secondary menu first then search box
remove_action( 'storefront_header', 'storefront_product_search', 40 );
add_action( 'storefront_header', 'pbosfc_search', 55 );

// Insert link to Wishlist into header
if ( defined( 'YITH_WCWL' ) ) {
	add_action( 'storefront_header', 'pbosfc_wishlist_link', 25 );
}

/**
 * Posts
 */


// Apply the excerpt replacing the content block on the archive pages
remove_action( 'storefront_loop_post', 'storefront_post_content', 30 );
add_action( 'storefront_loop_post', 'pbosfc_post_excerpt', 30 );


/**
 * Footer
 */

add_action( 'storefront_before_footer', 'pbosfc_bottomheader', 200 );
