<?php
defined( 'ABSPATH' ) || exit;

do_action( 'woocommerce_before_pay_form', $order );

if ( ! $order ) {
	echo '<div class="woocommerce-error">' . esc_html__( 'Invalid order.', 'noakirel' ) . '</div>';
	return;
}
?>

<div class="custom-order-pay-wrapper">
  <div class="custom-order-pay-card">
    <ul class="order_details">
      <li class="order">מספר הזמנה: <strong><?php echo esc_html( $order->get_order_number() ); ?></strong></li>
      <li class="date">תאריך ההזמנה: <strong><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong></li>
      <li class="time">שעת ההזמנה: <strong><?php echo esc_html( $order->get_date_created()->date( 'H:i' ) ); ?></strong></li>
      <li class="method">אמצעי תשלום: <strong><?php echo esc_html( $order->get_payment_method_title() ); ?></strong></li>
      <li class="total">סך הכל לתשלום: <strong><?php echo $order->get_formatted_order_total(); ?></strong></li>
    </ul>

    <p class="custom-order-pay-note">תודה רבה על ההזמנה! אנא לחץ על הכפתור לביצוע תשלום 100% מאובטח.</p>

    <?php wc_get_template( 'checkout/payment.php', array( 'order' => $order ) ); ?>

    <div class="custom-return-link">
      <a class="button cancel" href="<?php echo esc_url( $order->get_cancel_order_url() ); ?>">חזור לעגלת הקניות</a>
    </div>

  </div>
</div>

<?php do_action( 'woocommerce_after_pay_form', $order ); ?>
