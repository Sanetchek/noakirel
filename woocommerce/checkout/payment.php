<?php
/**
 * Checkout Payment Section
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/checkout/payment.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://woocommerce.com/document/template-structure/
 * @package WooCommerce\Templates
 * @version 9.8.0
 */

defined( 'ABSPATH' ) || exit;

if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_before_payment' );
}
?>
<div class="form-row place-order">
	<noscript>
		<?php
		/* translators: $1 and $2 opening and closing emphasis tags respectively */
		printf( esc_html__( 'Since your browser does not support JavaScript, or it is disabled, please ensure you click the %1$sUpdate Totals%2$s button before placing your order. You may be charged more than the amount stated above if you fail to do so.', 'woocommerce' ), '<em>', '</em>' );
		?>
		<br/><button type="submit" class="button alt<?php echo esc_attr( wc_wp_theme_get_element_class_name( 'button' ) ? ' ' . wc_wp_theme_get_element_class_name( 'button' ) : '' ); ?>" name="woocommerce_checkout_update_totals" value="<?php esc_attr_e( 'Update totals', 'woocommerce' ); ?>"><?php esc_html_e( 'Update totals', 'woocommerce' ); ?></button>
	</noscript>

	<?php wc_get_template( 'checkout/terms.php' ); ?>

	<?php do_action( 'woocommerce_review_order_before_submit' ); ?>

	<?php
	$subtotal = wp_strip_all_tags(wc_price(WC()->cart->get_subtotal()));
	$total = wp_strip_all_tags(wc_price(WC()->cart->total));
	$text = __('לתשלום', 'noakirel');

	$order_button_html = '<span class="subtotal-price">' . $text . ' ' . esc_html($subtotal) . '</span>';

	if ( WC()->cart->get_discount_total() > 0 ) {
		$order_button_html = '<span class="subtotal-price">' . $text . ' ' . esc_html($total) . '</span> <span class="total-price">' . esc_html($subtotal) . '</span>';
	}

	echo apply_filters(
		'woocommerce_order_button_html',
		'<button type="submit" class="button alt' . esc_attr(wc_wp_theme_get_element_class_name('button') ? ' ' . wc_wp_theme_get_element_class_name('button') : '') . '" name="woocommerce_checkout_place_order" id="place_order">'
		. $order_button_html .
		'</button>'
	);
	?>


	<?php do_action( 'woocommerce_review_order_after_submit' ); ?>

	<?php wp_nonce_field( 'woocommerce-process_checkout', 'woocommerce-process-checkout-nonce' ); ?>
</div>
<?php
if ( ! wp_doing_ajax() ) {
	do_action( 'woocommerce_review_order_after_payment' );
}
