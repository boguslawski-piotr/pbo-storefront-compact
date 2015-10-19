<?php
/**
 * Loop Add to Cart
 */
/**
 * PB:
 */
global $product;

// Availability
$availability      = $product->get_availability();
$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';
echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );

global $add_to_cart_template_from_wishlist;

if ( ! pbosfc_get_option( 'add_to_cart_on_product_list' ) ) {

	/* Only Read more button */
	echo sprintf( '<a href="%s" class="button product_type_%s">%s</a>',
		esc_url( get_permalink() ),
		esc_attr( $product->product_type ),
		esc_html( __( 'Read more', 'woocommerce' ) )
	);

} else {
	if ( ! pbosfc_get_option( 'add_to_cart_with_quantity_on_product_list' )
	     || ! $product->is_purchasable()
	     || ( $product->product_type != 'variable' && $product->product_type != 'simple' )
	     || $add_to_cart_template_from_wishlist > 0
	) {

		/* Standard woocommerce output */
		echo apply_filters( 'woocommerce_loop_add_to_cart_link',
			sprintf( '<a href="%s" rel="nofollow" data-product_id="%s" data-product_sku="%s" data-quantity="%s" class="button %s %s product_type_%s">%s</a>',
				esc_url( $product->add_to_cart_url() ),
				esc_attr( $product->id ),
				esc_attr( $product->get_sku() ),
				esc_attr( isset( $quantity ) ? $quantity : 1 ),
				$product->is_purchasable() && $product->is_in_stock() ? 'add_to_cart_button' : '',
				$product->product_type === 'external' || ( $product->product_type === 'simple' && $product->is_purchasable() ) || apply_filters( 'pbosfc_woocommerce_loop_add_to_cart_link_is_alt', false, $product ) ? 'alt' : '',
				esc_attr( $product->product_type ),
				esc_html( $product->add_to_cart_text() )
			),
			$product );

	} else {

		/* You can specify quantity and (for variable products) variantions before hitting Add to Cart button :) */
		do_action( 'woocommerce_before_add_to_cart_form' );

		if ( $product->product_type == 'simple' ) { ?>

			<form class="cart" method="post" enctype='multipart/form-data'>
				<?php
				do_action( 'woocommerce_before_add_to_cart_button' );

				if ( ! $product->is_sold_individually() ) {
					woocommerce_quantity_input( array(
						'min_value'   => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
						'max_value'   => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product ),
						'input_value' => ( isset( $_POST['quantity'] ) ? wc_stock_amount( $_POST['quantity'] ) : 1 )
					) );
				} ?>

				<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>"/>

				<button type="submit"
				        class="single_add_to_cart_button button alt"><?php echo esc_html( $product->single_add_to_cart_text() ); ?></button>

				<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
			</form>

			<?php
		} else {

			// Enqueue variation scripts
			wp_enqueue_script( 'wc-add-to-cart-variation' );

			// Get Available variations?
			$get_variations       = sizeof( $product->get_children() ) <= apply_filters( 'woocommerce_ajax_variation_threshold', 30, $product );
			$available_variations = $get_variations ? $product->get_available_variations() : false;
			$attributes           = $product->get_variation_attributes();
			$selected_attributes  = $product->get_variation_default_attributes();
			$attribute_keys       = array_keys( $attributes ); ?>

			<form class="variations_form cart list" method="post" enctype='multipart/form-data'
			      data-product_id="<?php echo absint( $product->id ); ?>"
			      data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">
				<?php do_action( 'woocommerce_before_variations_form' ); ?>

				<?php if ( empty( $available_variations ) && false !== $available_variations ) : ?>
					<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'woocommerce' ); ?></p>
				<?php else : ?>
					<table class="variations list" cellspacing="0">
						<tbody>
						<?php foreach ( $attributes as $attribute_name => $options ) : ?>
							<tr>
								<td class="label value list">
									<label
										for="<?php echo sanitize_title( $attribute_name ); ?>"><?php echo wc_attribute_label( $attribute_name ); ?>
									</label>
									<?php
									$selected = $product->get_variation_default_attribute( $attribute_name );
									ob_start();
									wc_dropdown_variation_attribute_options( array(
										'options'   => $options,
										'attribute' => $attribute_name,
										'product'   => $product,
										'selected'  => $selected
									) );
									echo ob_get_clean();
									?>
								</td>
							</tr>
						<?php endforeach; ?>
						</tbody>
					</table>

					<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

					<div class="single_variation_wrap" style="display:none;">
						<?php
						/**
						 * woocommerce_before_single_variation Hook
						 */
						do_action( 'woocommerce_before_single_variation' );

						/**
						 * woocommerce_single_variation hook. Used to output the cart button and placeholder for variation data.
						 * @since 2.4.0
						 * @hooked woocommerce_single_variation - 10 Empty div for variation data.
						 * @hooked woocommerce_single_variation_add_to_cart_button - 20 Qty and cart button.
						 */
						do_action( 'woocommerce_single_variation' );

						/**
						 * woocommerce_after_single_variation Hook
						 */
						do_action( 'woocommerce_after_single_variation' );
						?>
					</div>

					<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
				<?php endif; ?>

				<?php do_action( 'woocommerce_after_variations_form' ); ?>
			</form>

			<?php
		}

		do_action( 'woocommerce_after_add_to_cart_form' );
	}
}
?>
