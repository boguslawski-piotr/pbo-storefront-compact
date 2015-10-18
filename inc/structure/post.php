<?php

/**
 * Display the post header with a link to the single post
 * PBO: date of post under post title ;)
 */
function storefront_post_header() { ?>
	<header class="entry-header">
		<?php
		if ( is_single() ) {
			the_title( '<h1 class="entry-title" itemprop="name headline">', '</h1>' );
			storefront_posted_on();
		} else {
			the_title( sprintf( '<h1 class="entry-title" itemprop="name headline"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h1>' );
			if ( 'post' == get_post_type() ) {
				storefront_posted_on();
			}
		}
		?>
	</header><!-- .entry-header -->
	<?php
}


/**
 * Based (with preserved compatibility) on Storefront Blog Excerpts plugin.
 */
function pbosfc_post_excerpt() {
	if ( ! pbosfc_get_option('post_excerpt') ) {
		storefront_post_content();
	}
	else {
		?>
		<div class="entry-content" itemprop="articleBody">
			<?php
			if ( has_post_thumbnail() ) {
				$thumb_size = pbosfc_get_option( 'excerpt_image_size' );
				$img_class  = ( $thumb_size == 'thumbnail' ) ? apply_filters( 'woa_sf_blog_excerpt_image_float', pbosfc_get_option( 'excerpt_image_float' ) ) : '';
				the_post_thumbnail( $thumb_size, array(
					'itemprop' => 'image',
					'class'    => "attachment-$thumb_size $img_class"
				) );
			}
			$content = do_shortcode( ( has_excerpt( get_the_ID() ) ) ? get_the_excerpt() : get_the_content() );
			$content = wp_trim_words( $content, pbosfc_get_option( 'excerpt_word_count' ), pbosfc_get_option( 'excerpt_end' ) );
			echo apply_filters( 'the_excerpt', $content );
			?>
			<p class="read-more"><a class="button"
			                        href="<?php the_permalink(); ?>"><?php echo __( 'Continue reading', 'pbosfc' ); ?></a>
			</p>
		</div><!-- .entry-content -->
		<?php
	}
}


/**
 * Display the post content
 * PBO: options for featured image
 */
function storefront_post_content() {
	?>
	<div class="entry-content" itemprop="articleBody">
		<?php
		if ( pbosfc_get_option('post_featured_image') ) {
			storefront_post_thumbnail( $a_settings['post_featured_image_size'] );
		}

		the_content(
			sprintf(
				__( 'Continue reading %s', 'storefront' ),
				'<span class="screen-reader-text">' . get_the_title() . '</span>'
			)
		);

		wp_link_pages( array(
			'before' => '<div class="page-links">' . __( 'Pages:', 'storefront' ),
			'after'  => '</div>',
		) );
		?>
	</div><!-- .entry-content -->
	<?php
}


/**
 * Display the post meta
 * PBO: code rearrange in order to not insert empty <aside ...></aside> section
 */
function storefront_post_meta() {
	/* translators: used between list items, there is a space after the comma */
	$categories_list = get_the_category_list( __( ', ', 'storefront' ) );

	/* translators: used between list items, there is a space after the comma */
	$tags_list = get_the_tag_list( '', __( ', ', 'storefront' ) );

	if ( ( $categories_list && storefront_categorized_blog() ) || $tags_list ) : ?>
		<aside class="entry-meta">
			<?php
			if ( 'post' == get_post_type() ) : // Hide category and tag text for pages on Search
				if ( $categories_list && storefront_categorized_blog() ) : ?>
					<span class="cat-links">
						<?php
						echo '<span class="screen-reader-text">' . esc_attr( __( 'Categories: ', 'storefront' ) ) . '</span>';
						echo wp_kses_post( $categories_list );
						?>
					</span>
				<?php endif; // End if categories
				?>

				<?php
				if ( $tags_list ) : ?>
					<span class="tags-links">
						<?php
						echo '<span class="screen-reader-text">' . esc_attr( __( 'Tags: ', 'storefront' ) ) . '</span>';
						echo wp_kses_post( $tags_list );
						?>
					</span>
				<?php endif; // End if $tags_list
				?>

			<?php endif; // End if 'post' == get_post_type() ?>
		</aside>
		<?php
	endif;
}
