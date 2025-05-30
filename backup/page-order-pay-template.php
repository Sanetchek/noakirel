<?php
/**
 * Template Name: Order Pay Custom
 */

get_header();

global $wp;
$current_url = home_url( add_query_arg( array(), $wp->request ) );

$is_order_pay = isset( $wp->query_vars['order-pay'] );
$is_order_received = strpos( $current_url, 'order-received' ) !== false;
?>

<main id="main" class="custom-order">

  <?php if ( $is_order_pay ) : ?>

    <div class="custom-order-pay-wrapper">
      <div class="custom-order-pay-card">
        <img src="https://noakirel.co/wp-content/uploads/2025/05/Packshot-1.png" alt="img">

        <div class="custom-order-pay-card-wrapper">
          <?php
          $order_id = absint( $wp->query_vars['order-pay'] );
          $order = wc_get_order( $order_id );

          if ( $order ) : ?>
            <ul class="custom-order-pay-card-list">
              <li class="order">מספר הזמנה<strong><?php echo esc_html( $order->get_order_number() ); ?></strong></li>
              <li class="date">תאריך הזמנה<strong><?php echo esc_html( wc_format_datetime( $order->get_date_created() ) ); ?></strong></li>
              <li class="time">שעה<strong><?php echo esc_html( $order->get_date_created()->date( 'H:i' ) ); ?></strong></li>
              <li class="method">אמצעי תשלום<strong><?php echo esc_html( $order->get_payment_method_title() ); ?></strong></li>
              <li class="total">סך הכל לתשלום<strong><?php echo $order->get_formatted_order_total(); ?></strong></li>
            </ul>
          <?php endif; ?>

          <div class="w2t-tranzila-form-page">
            <?php the_content(); ?>
          </div>
        </div>
      </div>
    </div>

  <?php else : ?>
    <main class="custom-checkout-template" dir="rtl">
      <div class="woocommerce">
        <?php echo do_shortcode('[woocommerce_checkout]'); ?>
      </div>
    </main>
  <?php endif; ?>

</main>

<?php get_footer(); ?>
