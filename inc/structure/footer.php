<?php
/**
 *
 */
function pbosfc_footer_bar() {
	if ( is_active_sidebar( 'footer-bar-1' ) ) {
		?>
		<div class="footer-bar-1-widget-region" role="complementary">
			<div class="col-full">
				<?php dynamic_sidebar( 'footer-bar-1' ); ?>
			</div>
		</div>
		<?php
	}
}