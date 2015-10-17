<?php
/**
 * Single product short description
 *
 * @author        WooThemes
 * @package    WooCommerce/Templates
 * @version     1.6.4
 */
/**
 * PB: added link to full description
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $post;

if ( ! $post->post_excerpt ) {
	return;
}

?>
<div itemprop="description">
	<?php echo apply_filters( 'woocommerce_short_description', $post->post_excerpt . ' <a href="#tab-description">' . __( 'Continue reading', 'pbosfc' ) . '</a>' )
	?>
</div>
