<div style="max-width: 600px; margin: 0 auto; font-family: Arial, sans-serif; color: #000000; background-color: #ffffff; direction: rtl; text-align: right;">
    <!-- Header -->
    <?php get_template_part('template-parts/emails/header'); ?>

    <!-- New Order Notification -->
    <div style="padding: 20px; text-align: center; border-top: 1px solid #000000; border-bottom: 1px solid #000000; margin: 20px 0;">
        <h1 style="text-align: center; font-size: 24px; color: #000000; margin-bottom: 10px;">
            <?= __('התקבלה הזמנה חדשה', 'noakirel') ?>
        </h1>
        <p style="font-size: 16px; color: #000000;">
            <?php echo __('מספר הזמנה', 'noakirel') . ' ' . esc_html( $order->get_order_number() ) . ' ' . __('מאתר Signature By Noa Kirel', 'noakirel'); ?>
        </p>
    </div>

    <!-- Order Details -->
    <div style="padding: 20px;">
        <h2 style="text-align: center; font-size: 18px; color: #000000; border-bottom: 1px solid #000000; padding-bottom: 10px;">
            <?= __('פרטי ההזמנה', 'noakirel') ?>
        </h2>

        <table style="width: 100%; border-collapse: collapse; margin-bottom: 20px; direction: rtl;">
            <thead>
                <tr>
                    <th style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee;"><?= __('מוצר', 'noakirel') ?></th>
                    <th style="text-align: center; padding: 10px; border-bottom: 1px solid #eeeeee;"><?= __('תמונה', 'noakirel') ?></th>
                    <th style="text-align: center; padding: 10px; border-bottom: 1px solid #eeeeee;"><?= __('כמות', 'noakirel') ?></th>
                    <th style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee;"><?= __('מחיר', 'noakirel') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ( $order->get_items() as $item_id => $item ) :
                    $product = $item->get_product();
                    $product_id = $product ? $product->get_id() : 0;
                    $product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $product_id ), 'thumbnail' );
                    ?>
                    <tr>
                        <td style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee;">
                            <?= esc_html( $item->get_name() ); ?>
                        </td>
                        <td style="text-align: center; padding: 10px; border-bottom: 1px solid #eeeeee;">
                            <?php if ( $product_image ) : ?>
                                <img src="<?= esc_url( $product_image[0] ); ?>" width="50" height="50" style="max-width: 50px; height: auto;" loading="lazy">
                            <?php endif; ?>
                        </td>
                        <td style="text-align: center; padding: 10px; border-bottom: 1px solid #eeeeee;">
                            <?= esc_html( $item->get_quantity() ); ?>
                        </td>
                        <td style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee;">
                            <?= wp_kses_post( $order->get_formatted_line_subtotal( $item ) ); ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th scope="row" colspan="3" style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee;"><?= __('סכום ביניים:', 'noakirel') ?></th>
                    <td style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee;"><?= wp_kses_post( $order->get_subtotal_to_display() ); ?></td>
                </tr>
                <tr>
                    <th scope="row" colspan="3" style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee;"><?= __('משלוח:', 'noakirel') ?></th>
                    <td style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee;"><?= wp_kses_post( $order->get_shipping_to_display() ); ?></td>
                </tr>
                <tr>
                    <th scope="row" colspan="3" style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee; font-size: 18px;"><?= __('סה״כ לתשלום:', 'noakirel') ?></th>
                    <td style="text-align: right; padding: 10px; border-bottom: 1px solid #eeeeee; font-size: 18px; font-weight: bold;"><?= wp_kses_post( $order->get_formatted_order_total() ); ?></td>
                </tr>
            </tfoot>
        </table>

        <!-- Customer Info -->
        <div style="margin-bottom: 20px;">
            <h3 style="text-align:right; font-size: 16px; color: #000000; margin-bottom: 10px;"><?= __('פרטי הלקוח', 'noakirel') ?></h3>
            <p style="margin: 0; padding: 0;">
                <?= __('שם:', 'noakirel') . ' ' . esc_html( $order->get_formatted_billing_full_name() ); ?><br>
                <?php if ( $order->get_billing_phone() ) : ?>
                    <?= __('טלפון:', 'noakirel') . ' ' . esc_html( $order->get_billing_phone() ); ?><br>
                <?php endif; ?>
                <?php if ( $order->get_billing_email() ) : ?>
                    <?= __('אימייל:', 'noakirel') . ' ' . esc_html( $order->get_billing_email() ); ?>
                <?php endif; ?>
            </p>
        </div>

        <!-- Shipping and Billing Address -->
        <div style="margin-bottom: 20px; width: 100%; display: inline-block; direction: rtl;">
            <div style="width: 48%; float: right;">
                <h3 style="text-align:right; font-size: 16px; color: #000000; margin-bottom: 10px;"><?= __('כתובת למשלוח', 'noakirel') ?></h3>
                <address style="padding: 10px; border: 1px solid #eeeeee; background-color: #fafafa; margin: 0; text-align: right;">
                    <?= wp_kses_post( $order->get_formatted_shipping_address() ); ?>
                </address>
            </div>

            <div style="width: 48%; float: left;">
                <h3 style="text-align:right; font-size: 16px; color: #000000; margin-bottom: 10px;"><?= __('כתובת לחיוב', 'noakirel') ?></h3>
                <address style="padding: 10px; border: 1px solid #eeeeee; background-color: #fafafa; margin: 0; text-align: right;">
                    <?= wp_kses_post( $order->get_formatted_billing_address() ); ?>
                </address>
            </div>
        </div>
        <div style="clear: both;"></div>
    </div>

    <!-- Footer -->
    <?php get_template_part('template-parts/emails/footer'); ?>
</div>
