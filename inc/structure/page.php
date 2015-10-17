<?php

/**
 * Display the page header
 * PBO: options for featured image
 */
function storefront_page_header() {
	?>
	<header class="entry-header">
		<?php
		if ( pbosfc_get_option('page_featured_image') ) {
			storefront_post_thumbnail( pbosfc_get_option('page_featured_image_size') );
		}
		the_title( '<h1 class="entry-title" itemprop="name">', '</h1>' );
		?>
	</header><!-- .entry-header -->
	<?php
}
