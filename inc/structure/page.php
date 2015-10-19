<?php

/**
 * Display the page header
 * PBO: options for featured image
 */
function storefront_page_header() {
	?>
	<header class="entry-header">
		<?php
		if ( pbosfc_get_option('page_featured_image_size') != 'none' ) {
			storefront_post_thumbnail( pbosfc_get_option('page_featured_image_size') );
		}
		the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
		?>
	</header><!-- .entry-header -->
	<?php
}

/**
 * Display the page content
 * PBO: disabled 'entry-content' section
 */
function storefront_page_content() {
	?>
	<!-- <div class="entry-content" itemprop="mainContentOfPage"> -->
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
			'after'  => '</div>',
		) );
		?>
	<!-- </div>--><!-- .entry-content -->
	<?php
}
