<?php
defined( 'ABSPATH' ) || exit;
$order = wc_get_order( get_query_var( 'order-received' ) );
if ( ! $order ) return;
?>

<div class="thankyou-page-wrapper">
    <img src="https://noakirel.co/wp-content/uploads/2025/05/Packshot.png" alt="thnkas">
    <div class="thankyou-card">


        <h1 class="thankyou-title">
            ההזמנה בוצעה בהצלחה
        </h1>

        <p class="thankyou-text">
            הזמנה מספר <strong>#<?= $order->get_order_number(); ?></strong> נוצרה בהצלחה.<br>
            כל פרטי ההזמנה נשלחו אליך במייל
        </p>

        <a href="<?php echo home_url(); ?>" class="thankyou-link">
            חזרה לדף הבית
        </a>
    </div>
</div>

<?php
$subtotal = $order->get_subtotal(); // Product subtotal minus discounts
$total = $subtotal / 1.18;
$extID = $order->get_id();
?>
<script type="text/javascript" src="https://track.wesell.co.il/conversionFirstParty/6n0AKLFgU18/oKo6kK9jnMw/json?total=<?php echo esc_js($total); ?>&extID=<?php echo esc_js($extID); ?>"></script>
