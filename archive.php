<?php
/**
 * The template for displaying archive pages.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 */
/**
 * PBO: Shows page title as a breadcrumb when real breadcrumbs are disabled.
 * TODO: sprawdzic jak bedzie wygladac bez Woocommerce
 */
get_header();

if ( ! pbosfc_get_option( 'post_breadcrumb' ) ) {
	echo '<nav class="woocommerce-breadcrumb">' . the_archive_title() . '</nav>';
}
?>

<section id="primary" class="content-area">
	<main id="main" class="site-main" role="main">

		<?php if ( have_posts() ) : ?>

			<?php get_template_part( 'loop' ); ?>

		<?php else : ?>

			<?php get_template_part( 'content', 'none' ); ?>

		<?php endif; ?>

	</main>
	<!-- #main -->
</section><!-- #primary -->

<?php do_action( 'storefront_sidebar' ); ?>
<?php get_footer(); ?>
