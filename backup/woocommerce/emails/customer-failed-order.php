<?php
/**
 * Customer failed order email
 */

defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_email_header', $email_heading, $email ); ?>

<div dir="rtl" style="font-family: Arial, sans-serif; text-align: right; color: #000;">

	<p style="font-size: 16px;">
		<?php esc_html_e( 'לצערנו, הזמנתך לא הושלמה עקב בעיית תשלום. ניתן לנסות שוב או ליצור קשר איתנו.', 'woocommerce' ); ?>
	</p>

	<?php
	do_action( 'woocommerce_email_order_details', $order, $sent_to_admin, $plain_text, $email );
	do_action( 'woocommerce_email_customer_details', $order, $sent_to_admin, $plain_text, $email );
	?>

	<p style="font-size: 14px;">
		<?php esc_html_e( 'לסיוע, אנא צרו קשר במייל:', 'woocommerce' ); ?><br>
		<a href="mailto:info@noakirel.co" style="color: #000; font-weight: bold;">info@noakirel.co</a>
	</p>

</div>

<?php do_action( 'woocommerce_email_footer', $email ); ?>
