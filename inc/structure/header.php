<?php

/**
 *
 */
function pbosfc_topheader_1() {
	if ( is_active_sidebar( 'top-header-1' ) ) {
		?>
		<div class="top-header-1-widget-region" role="complementary">
			<div class="col-full">
				<?php dynamic_sidebar( 'top-header-1' ); ?>
			</div>
		</div>
		<?php
	}
}

/**
 *
 */
function pbosfc_topheader_2() {
	if ( is_active_sidebar( 'top-header-2' ) ) {
		?>
		<div class="top-header-2-widget-region" role="complementary">
			<div class="col-full">
				<?php dynamic_sidebar( 'top-header-2' ); ?>
			</div>
		</div>
		<?php
	}
}

/**
 *
 */
function pbosfc_topmenu() {
	if ( has_nav_menu( 'left_top' ) || has_nav_menu( 'right_top' ) ) {
		?>
		<div class="top-menu-wrap">
			<div class="col-full">
				<section class="left-top-menu-wrap">
					<nav class="left-top-menu" role="navigation"
					     aria-label="<?php _e( 'Left Top Menu', 'pbosfc' ); ?>">
						<?php
						if ( ! has_nav_menu( 'left_top' ) ) {
							echo '&nbsp;';
						} else {
							wp_nav_menu(
								array(
									'theme_location' => 'left_top',
									'fallback_cb'    => '',
								)
							);
						}
						?>
					</nav>
				</section>

				<section class="right-top-menu-wrap">
					<nav class="right-top-menu" role="navigation"
					     aria-label="<?php _e( 'Right Top Menu', 'pbosfc' ); ?>">
						<?php
						if ( ! has_nav_menu( 'right_top' ) ) {
							echo '&nbsp;';
						} else {
							wp_nav_menu(
								array(
									'theme_location' => 'right_top',
									'fallback_cb'    => '',
								)
							);
						}
						?>
					</nav>
				</section>

			</div>
		</div>
		<?php
	}
}

/**
 * Original Storefront secondary Navigation is DISABLED
 */
function storefront_secondary_navigation() {
	// DISABLED!!!
}

/**
 * Replace Woocommerce products search box with standard Wordpress search box
 */
function pbosfc_search() {
	if ( ! pbosfc_get_option( 'use_wp_search' ) ) {
		storefront_product_search();
	} else { ?>
		<div class="site-search">
			<?php the_widget( 'WP_Widget_Search' ); ?>
		</div>
		<?php
	}
}

/**
 *
 */
function storefront_skip_links() {
	// nothing
}

/**
 *
 */
function pbosfc_wishlist_link() { ?>
	<div class="site-header-wishlist">
		<a href="<?php echo esc_url( get_permalink( 2568 ) ) ?>"><?php echo esc_html__( 'View Wishlist', 'pbosfc' ); ?></a>
	</div>
	<?php
}
