<?php
/**
 *
 */
function pbosfc_bottomheader() {
	if ( is_active_sidebar( 'bottom-header-1' ) ) {
		?>
		<div class="bottom-header-1-widget-region" role="complementary">
			<div class="col-full">
				<?php dynamic_sidebar( 'bottom-header-1' ); ?>
			</div>
		</div>
		<?php
	}
}