<?php
/**
 * The template for displaying search results pages.
 *
 * @package storefront
 */
/**
 * PB: No global title & little hack with posts titles ;)
 *
 */

get_header(); ?>

<section id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php
			do_action( 'storefront_loop_before' );

			while ( have_posts() ) : the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?> itemscope=""
				         itemtype="http://schema.org/BlogPosting">

					<?php
					/**
					 * @hooked storefront_post_header() - 10
					 * @hooked storefront_post_meta() - 20
					 * @hooked storefront_post_content() - 30
					 */
					do_action( 'storefront_loop_post' );
					?>
				</article><!-- #post-## -->

				<?php if ( 'post' != get_post_type() ) : ?>
					<div class="a_search_post_divider"></div><?php endif ?>
				<?php
			endwhile;

			/**
			 * @hooked storefront_paging_nav - 10
			 */
			do_action( 'storefront_loop_after' );
			?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</main>
	<!-- #main -->
</section><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
