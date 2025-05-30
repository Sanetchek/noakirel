<?php
/**
 * Customer processing order email
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/emails/customer-processing-order.php.
 *
 * @see     https://woocommerce.com/document/template-structure/
 */

defined( 'ABSPATH' ) || exit;

/** @var WC_Order $order */

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<div dir="rtl" style="font-family: Arial, sans-serif; text-align: right; color: #000;">

	<p style="font-size: 16px;">
		<?php
		printf(
			/* translators: %s: Customer first name */
			esc_html__( 'שלום %s, תודה על הזמנתך. כבר מטפלים בה והיא תשלח אליך בהקדם.', 'noakirel' ),
			esc_html( $order->get_billing_first_name() )
		);
		?>
	</p>

	<h2 style="font-size: 18px; margin-top: 30px;"><?php esc_html_e( 'פרטי ההזמנה שלך', 'noakirel' ); ?></h2>

	<?php
	/**
	 * Hook for order details table
	 *
	 * @hooked WC_Emails::order_details() Shows the order details table.
	 * @hooked WC_Emails::order_schema_markup() Adds Schema.org markup.
	 * @hooked WC_Emails::order_meta() Shows order meta data.
	 */
	do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );

	/**
	 * Hook for customer details section
	 *
	 * @hooked WC_Emails::customer_details() Shows customer details.
	 * @hooked WC_Emails::email_address() Shows email address.
	 */
	do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
	?>

  <p style="font-size: 14px;">
		<?php esc_html_e( 'אם יש לך שאלות, ניתן לפנות אלינו בכל עת דרך האתר או במייל:', 'noakirel' ); ?><br>
		<a href="mailto:info@noakirel.co" style="color: #000; font-weight: bold;">info@noakirel.co</a>
	</p>
</div>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
