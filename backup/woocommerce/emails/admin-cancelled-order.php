<?php
/**
 * Admin cancelled order email (RTL)
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<div dir="rtl" style="font-family: Arial, sans-serif; text-align: right; color: #000000;">

	<p style="font-size: 16px;">
		<?php
		printf(
			/* translators: %s: Order number */
			esc_html__( 'ההזמנה מספר %s בוטלה.', 'woocommerce' ),
			esc_html( $order->get_order_number() )
		);
		?>
	</p>

	<?php
	do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
	do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text, $email );
	do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
	?>

</div>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
