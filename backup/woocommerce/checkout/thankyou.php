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
